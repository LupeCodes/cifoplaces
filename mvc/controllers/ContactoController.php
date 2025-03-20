<?php
class ContactoController extends Controller{
    
    //cargará la vista con el formulario de contacto
    public function index(){
        return view ('contacto');
    }
    
    
    //METODO SEND------------------------------------------------
    public function send(){
        
        if(empty(request()->post('enviar')))
            throw new FormException('No se recibió el formulario de contacto');
        
        //tomamos los datos del formulario de contacto
        $from       = request()->post('email');
        $name       = request()->post('nombre');
        $subject    = request()->post('asunto');
        $message    = request()->post('mensaje');
        
        //intentamos preparar y enviar el mail al administrado
        //este mail esta configurado en config.php
        try{
            $email = new Email(ADMIN_EMAIL, $from, $name, $subject, $message);
            $email->send();
            
            //flashea el mensaje de extio y redirecciona a la portada
            Session::success("Mensaje enviado, en breve recibirás una respuesta");
            return redirect('/');
        //Y si no se puede enviar...    
        }catch(EmailException $e){
            Session::error("No se pudo enviar el email");
            
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            return redirect("/Contacto");
        }
    }//FIN DE SEND
    
}//FIN DE LA CLASE