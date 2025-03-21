<?php
class PhotoController extends Controller{
    
    //DETALLES DE LA FOTO---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $photo = Photo::findOrFail($id);    //busca la foto con ese ID
        
       
        $comments = $photo->hasMany('V_comment');
        $user = Photo::findOrFail($id)->belongsTo('User');
        $place = Photo::findOrFail($id)->belongsTo('Place');
        //carga la vista y le pasa el libro recuperado
        return view('Photo/show',[
            'photo'     => $photo,
            'comments'  => $comments,
            'user'      => $user,
            'place'     => $place
        ]);
    }
    
    
    //CREATE---------------------------------------------
    public function create(int $idplace = 0){
        
        //antes de nada, xa que solo lo pueda hacer usuario identificado
        Auth::check();
        
        $place = Place::findOrFail($idplace);
        
        return view('Photo/create',[
            'place' => $place
        ]);
    }
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //antes de nada, xa que solo lo pueda hacer usuario registrado
        Auth::check();
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
            
        $photo = new Photo();   //creamos el nuevo Place
            
        //toma los datos que llegan por POST
        //en la configuracion, las cadenas vacias las guarda como null
        //para poner un valor por defecto seria asi
        //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
        $photo->idplace             =intval(request()->post('idplace'));
        $photo->iduser              =Login::user()->id;
        $photo->name                =request()->post('name');
        $photo->date                =request()->post('date');
        $photo->time                =request()->post('time');
        $photo->description         =request()->post('description');
        $photo->alt                 =request()->post('alt');
            
            
        //intenta guardar el lugar. En caso de que la insercion falle
        //vamos a evitar ir a la página de error y volveremos
        //al formulario "nuevo lugar"
        try{
            //Primero validamos los campos
            //si la lista de errores está vacia, seguimos, pero si tiene algo
            //lanzamos una excepcion de validacion con los errores en el mensaje
            if($errores = $photo->validate())
                throw new ValidationException(
                    "<br>".arrayToString($errores, false, false, ".<br>")
                    );
                    
            //guarda el place en la base de datos
            $photo->save();
                    
            //recupera la imagen como objeto UploadedFile (o null si no llega)
            $file = request()->file(
                'file',  //nombre del input
                    8000000,    //tamaño máximo del fichero
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp'] //tipos aceptados
                        );
                    
            //si hay fichero, lo guardamos y actualizamos el campo "mainpicture"
            if($file){
                $photo->file = $file->store('../public/'.PHOTO_IMAGE_FOLDER, 'photo_');
                $photo->update();   //actualiza el libro para añadir la portada
                        
                        
                //flashea un mensaje de éxito en la sesión
                Session::success("Guardado de $photo->name correcto");
                        
                //redirecciona a los detalles del place que hemos guardado
                return redirect("/Photo/show/$photo->id");
            }
                    //si falla el guardado del place nos venimos al catch
            }catch(SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar $photo->name");
                
                //si está en modo DEBUG vuelve a lanzar la excepcion
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de place
                    //los valores no deberían haberse borrado si usamos los helpers old()
                    return redirect("/Photo/create");
                    
                    //si falla el guardado de la imagen...
            }catch(UploadException $e){
                //preparamos un mensaje de advertencia
                //no de error, puesto que el libro se guardó
                Session::warning("Los datos de la foto se guardaron correctamente,
                                pero no se pudo subir el fichero de imagen");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    //redirigimos a la edicion del place
                    //por si se quiere volver a intentar subir la imagen
                    redirect("/Photo/edit/$photo->id");
                    
                    //y aqui el catch de la validacion
            }catch(ValidationException $e){
                
                Session::error("Errores de validación. ".$e->getMessage());
                
                //regresa al formulario de creacion de lugar
                return redirect("/Photo/create");
            }
    }//FIN DE FUNCION STORE
    
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        
        //recuperamos el usuario que ha hecho login
        $usuario = Login::user();
        $idlogin = $usuario->id;
        
        //busca la foto con ese ID
        $photo = Photo::findOrFail($id, "No se encontró la foto");
        $iduser = $photo->iduser;
        $vpicture = V_picture::findOrFail($id);
        //primero comprobamos que el usuario que está intentando
        //editar el anuncio es el mismo que lo ha creado
        if($idlogin == $iduser){
            //retornamos una ViewResponse con la vista con el formulario de edicion
            return view('Photo/edit', [
                'photo'      => $photo,
                'vpicture'  => $vpicture
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
            
            $photo = Photo::findOrFail($id, "No se ha encontrado la foto.");
            
            $place = $photo->belongsTo('Place');
            
            //recuperar el resto de campos
            $photo->name            = request()->post('name');
            $photo->description     = request()->post('description');
            $photo->date            = request()->post('date');
            $photo->time            = request()->post('time');
            $photo->alt            = request()->post('alt');
            
            $idplace = $place->id;
            //intentamos actualizar el libro
            try{
                $photo->update();
                Session::success("Actualización dela foto correcta.");
                return redirect("/Place/show/$idplace");
                
                
                //si se produce un error al guardar el libro
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización de la foto");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Place/show/$idplace");
            }
            
    }//FIN DE UPDATE
    
    
    //DESTROY--------------------------------------------------------------------
    public function destroy(int $id = 0){
        
        
        //lo recuperamos de la BDD
        $photo = Photo::findOrFail($id, "No se encontró la foto");
        $placeid = $photo->idplace;
        
        $place = Place::findOrFail($placeid);
        
        
        //recuperamos el usuario que ha hecho login
        $usuario = Login::user();
        $idlogin = $usuario->id;
        //Solo lo haremos si el usuario que intenta hacerlo es el usuario que lo ha creado
        //if($idlogin <> $anuncio->iduser && !Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR']))
        //    throw new AuthException('Tú no puedes borrar esto, colegui');
        if($idlogin == $photo->iduser || Login::user()->id == $place->iduser || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){
            
            try{
                $photo->deleteObject();
                Session::Success('Foto eliminada correctamente.');
                return redirect("/Place/show/$placeid");
                
            }catch(SQLException $e){
                
                Session::error('No se pudo borrar la foto');
                
                if(DEBUG)
                    throw new Exception($e->getMessage());
                    
                    return redirect("/User/home");
            }
        }else{
            throw new AuthException('Tú no puedes borrar esto, colegui');
        }
    }//FIN DE DESTROY
    
    
}//FIN DE LA CLASE