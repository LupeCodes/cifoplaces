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
            $places = Place::orderBy('created_At', 'DESC', $limit, $paginator->getOffset());
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
    
}//FIN DE LA CLASE
