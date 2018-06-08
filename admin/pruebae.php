<?php
    ini_set('display_errors', '0');
    function shutdown(){ //async
        $e = error_get_last(); 
        if(!empty($e)){
            echo "Soy lento we";
        }
    } 
    register_shutdown_function('shutdown'); 
    
    ini_set('max_execution_time', 1); //max 1 segundo, cambiar a 3 para ver ejecución normal
    sleep(3); 
    
    echo "Normal";