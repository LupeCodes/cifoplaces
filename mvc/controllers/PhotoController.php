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
    
}//FIN DE LA CLASE