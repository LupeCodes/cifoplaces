<?php

/** Welcome
 *
 * Controlador por omisión según la configuración por defecto del
 * fichero de configuración config.php.
 *
 * Última revisión: 09/03/2025
 * 
 * @author Robert Sallent <robert@fastlight.org>
 */

class WelcomeController extends Controller{
    
    /** 
     * Carga la vista de portada. 
     * 
     * @return ViewResponse
     * 
     * */
    public function index():Response{
        //recuperamos los ultimas 5 fotos, para poder poner las "novedades" en la portada
        $photos = V_picture::orderBy('id','desc', 6);
        
        return view('welcome', [
            'photos' => $photos
        ]);
    }  
}

