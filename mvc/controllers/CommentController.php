<?php
class CommentController extends Controller{
    
    //STORE-----------------------------------------------------------
    public function store(){
        
        
       
        //comprobamos que el formulario llega con los datos y que hay usuario identificado
        if(!request()->has('guardar') && Login::user())
            throw new FormException('Ooooh, ha habido algún problema guardando tu comentario. Intentalo de nuevo.');
            
            $comment = new Comment();
            
            
            $comment->text      = request()->post('text');
            $comment->idplace   = request()->post('idplace');
            $comment->idphoto   = request()->post('idphoto');
            $comment->iduser    = Login::user()->id;
            
            //intentamos guardarlo en la bdd
            try{
                $comment->save();
                
                Session::success('Gracias por dejar tu comentario');
                
                //return redirect("/Ejemplar/create/$ejemplar->idlibro");
                return redirect($comment->idplace ? "/Place/show/$comment->idplace" : "/Photo/show/$comment->idphoto");
            }catch(SQLException $e){
                
                Session::error('Ooooh, ha habido algún problema guardando tu comentario. Intentalo de nuevo.');
                
                if(DEBUG)
                    throw new Exception($e->getMessage());
                    
                return redirect($comment->idplace ? "/Place/show/$comment->idplace" : "/Photo/show/$comment->idphoto");
            }
            
    }//FIN DE STORE
    
    
    //DESTROY--------------------------------------------------------------------
    public function destroy(int $id = 0){
        
        
        
        //lo recuperamos de la BDD
        $comment = Comment::findOrFail($id, "No se encontró el comentario");
        
        //recuperamos el usuario que ha hecho login
        $usuario = Login::user();
        $idlogin = $usuario->id;
        
            //solo puede borrar el autor del comentario o un admin o moderador
        if($idlogin == $comment->iduser || Login::oneRole(['ROLE_ADMIN', 'ROLE_MODERADOR'])){
                
                
            try{
                $comment->deleteObject();
                Session::Success('Se borró el comentario');
                return redirect($comment->idplace ? "/Place/show/$comment->idplace" : "/Photo/show/$comment->idphoto");
                    
            }catch(SQLException $e){
                    
                Session::error('No se pudo eliminar el comentario');
                    
                if(DEBUG)
                    throw new Exception($e->getMessage());
                        
                return redirect($comment->idplace ? "/Place/show/$comment->idplace" : "/Photo/show/$comment->idphoto");
            }
        }else{
            throw new AuthException('Tu no puedes borrar esto, contacta con un moderador');
        }
        
    }//FIN DE DESTROY
}//FIN DE LA CLASE