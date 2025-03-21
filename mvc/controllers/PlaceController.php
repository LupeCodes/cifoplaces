<?php
class PlaceController extends Controller{
    
    //FUNCION LIST-------------------------------------------------------------------
    public function list(int $page = 1){
        //analiza si hay filtros, pone uno nuevo o quita el existente
        $filtro = Filter::apply('places');
        
        $limit = RESULTS_PER_PAGE;  //numero de resultados x pagina, en el config
        
        //si hay filtro
        if($filtro){
            $total = Place::filteredResults($filtro);    //el total de places q hay
            
            //el objeto paginador
            $paginator = new Paginator('/Place/list', $page, $limit, $total);
            
            //recupera los libros que cumplen los criterios de busqueda
            $places = Place::filter($filtro, $limit, $paginator->getOffset());
            //si no hay filtro...
        }else{
            //recupera el total de places
            $total= Place::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Place/list', $page, $limit, $total);
            
            //recupera todos los places
            $places = Place::orderBy('created_at', 'DESC', $limit, $paginator->getOffset());
        }
        
        //carga la vista que los muestra
        //el view es un helper
        return view('place/list',[
            'places'    => $places,
            'paginator' => $paginator,
            'filtro'    =>  $filtro
        ]);
    }//FIN DE LIST
    
    
    //DETALLES DEL LUGAR---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $place = Place::findOrFail($id);    //busca el place con ese ID
        $photos = $place->hasMany('Photo');
        $comments = $place->hasMany('V_comment');
        //carga la vista y le pasa el place recuperado
        return view('Place/show',[
            'place' => $place,
            'photos' => $photos,
            'comments' => $comments
        ]);
    }
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        
        //antes de nada, xa que solo lo pueda hacer usuario identificado
        Auth::check();
        
        return view('Place/create');
    }
    
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //antes de nada, xa que solo lo pueda hacer usuario registrado
        Auth::check();
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
         
         //PRUEBA UNO   
        //if(!empty(request()->file)){
            $place = new Place();   //creamos el nuevo Place
            
            //toma los datos que llegan por POST
            //en la configuracion, las cadenas vacias las guarda como null
            //para poner un valor por defecto seria asi
            //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
            $place->name                =request()->post('name');
            $place->type                =request()->post('type');
            $place->location            =request()->post('location');
            $place->description         =request()->post('description');
            $place->latitude            =request()->post('latitude');
            $place->longitude           =request()->post('longitude');
            $place->iduser              =Login::user()->id;
            
            
            //intenta guardar el lugar. En caso de que la insercion falle
            //vamos a evitar ir a la página de error y volveremos
            //al formulario "nuevo lugar"
            try{
                //Primero validamos los campos
                //si la lista de errores está vacia, seguimos, pero si tiene algo
                //lanzamos una excepcion de validacion con los errores en el mensaje
                if($errores = $place->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false, ".<br>")
                        );
                    
                    //guarda el place en la base de datos
                
                //EL PLACE NO SE ALMACENA HASTA QUE NO ESTEMOS SEGUROS DE QUE TIENE FOTO
                //$place->save();
                    
                //recupera la imagen como objeto UploadedFile (o null si no llega)
                $file = request()->file(
                        'mainpicture',  //nombre del input
                        8000000,    //tamaño máximo del fichero
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp'] //tipos aceptados
                        );
                    
                //si hay fichero, lo guardamos y actualizamos el campo "mainpicture"
                if($file){
                    $place->mainpicture = $file->store('../public/'.PLACE_IMAGE_FOLDER, 'place_');
                    //$place->update();   //actualiza el lugar para añadir la foto
                    
                    //ENTONCES EL ALMACENADO REAL SE HARIA AQUI
                    $place->save();
                    
                    
                //flashea un mensaje de éxito en la sesión
                Session::success("Guardado de $place->name correcto");
                    
                //redirecciona a los detalles del place que hemos guardado
                return redirect("/Place/show/$place->id");
                }else{
                    Session::warning('Es necesario subir una foto');
                    return redirect("/Place/create");
                }
                //si falla el guardado del place nos venimos al catch
            }catch(SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar $place->name");
                
                //si está en modo DEBUG vuelve a lanzar la excepcion
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de place
                    //los valores no deberían haberse borrado si usamos los helpers old()
                    return redirect("/Place/create");
                    
                    //si falla el guardado de la imagen...
            }catch(UploadException $e){
                //preparamos un mensaje de advertencia
                //no de error, puesto que el libro se guardó
                Session::warning("El lugar se guardó correctamente,
                                pero no se pudo subir el fichero de imagen");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    //redirigimos a la edicion del place
                    //por si se quiere volver a intentar subir la imagen
                    redirect("/Place/edit/$place->id");
                    
                    //y aqui el catch de la validacion
            }catch(ValidationException $e){
                
                Session::error("Errores de validación. ".$e->getMessage());
                
                //regresa al formulario de creacion de lugar
                return redirect("/Place/create");
            }
            //PRUEBA UNO
       /* }else{
            Session::error("No puedes crear un lugar sin foto principal.");
            return redirect("/Place/create");
        }*/
    }//FIN DE FUNCION STORE
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        
        //recuperamos el usuario que ha hecho login
        $usuario = Login::user();
        $idlogin = $usuario->id;
        
        //busca el libro con ese ID
        $place = Place::findOrFail($id, "No se encontró el lugar");
        $iduser = $place->iduser;
        //primero comprobamos que el usuario que está intentando
        //editar el anuncio es el mismo que lo ha creado
        if($idlogin == $iduser){
            //retornamos una ViewResponse con la vista con el formulario de edicion
            return view('Place/edit', [
                'place'      => $place
            ]);
        }else{
            throw new AuthException('No puedes hacer esto, no seas tramposete');
        }
        
    }//FIN DE EDIT
    
    
    //METODO UPDATE-----------------------------------------------------
    public function update(){
        
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
            
        $id = intval(request()->post('id'));    //recuperar el id vía POST
            
        $place = Place::findOrFail($id, "No se ha encontrado el lugar.");
            
        //recuperar el resto de campos
        $place->name                =request()->post('name');
        $place->type                =request()->post('type');
        $place->location            =request()->post('location');
        $place->description         =request()->post('description');
        $place->latitude            =request()->post('latitude');
        $place->longitude           =request()->post('longitude');
        
            
            
        //intentamos actualizar el lugar
        try{
            //recuperamos el usuario que ha hecho login
            $usuario = Login::user();
            $idlogin = $usuario->id;
                
            //recuperamos la id del usuario que creo ese lugar
            
            $iduser = $place->iduser;
            //primero comprobamos que el usuario que está intentando
            //editar el anuncio es el mismo que lo ha creado
            if($idlogin == $iduser)
                    
                $place->update();
                    
                    //ahora recupera la portada como objeto UploadedFile (o null si no llega)
            $file = request()->file(
                        'mainpicture',  //nombre del input
                        8000000,    //tamaño maximo del fichero
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp']  //tipos aceptados
                        );
                    
            //si llega un nuevo fichero...
            if($file){
                if($place->mainpicture) //si el lugar ya tenia portada, la elimina
                    File::remove('../public/'.PLACE_IMAGE_FOLDER.'/'.$place->mainpicture);
                            
                //coloca el nuevo fichero (portada) y actualiza la propiedad
                $place->mainpicture = $file->store('../public/'.PLACE_IMAGE_FOLDER,'place_');
                $place->update();   //actualiza solamente el campo portada
            }
                    
                Session::success("Actualización de $place->name correcta.");
                return redirect("/Place/edit/$id");
                    
                //si se produce un error al guardar el anuncio
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización de $place->name");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Place/edit/$id");
                    //si falla la actualizacion de la portada...
            }catch(UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la imagen");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    return redirect("/Place/edit/$id");
            }
            
    }//FIN DE UPDATE
    
    
    
    //DESTROY--------------------------------------------------------------------
    public function destroy(int $id = 0){
        
        
        //lo recuperamos de la BDD
        $place = Place::findOrFail($id, "No se encontró el lugar");
        
        
        //recuperamos el usuario que ha hecho login
        $usuario = Login::user();
        $idlogin = $usuario->id;
        //Solo lo haremos si el usuario que intenta hacerlo es el usuario que lo ha creado
        //if($idlogin <> $anuncio->iduser && !Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR']))
        //    throw new AuthException('Tú no puedes borrar esto, colegui');
        if($idlogin == $place->iduser || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){
            
            try{
                $place->deleteObject();
                Session::Success('Lugar eliminado correctamente.');
                return redirect("/User/home");
                
            }catch(SQLException $e){
                
                Session::error('No se pudo borrar el lugar');
                
                if(DEBUG)
                    throw new Exception($e->getMessage());
                    
                    return redirect("/User/home");
            }
        }else{
            throw new AuthException('Tú no puedes borrar esto, colegui');
        }
    }//FIN DE DESTROY
    
}//FIN DE LA CLASE
