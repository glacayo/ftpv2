<?php
function url_exists($url) {

    if( empty( $url ) ){
        return false;
    }

    $ch = curl_init( $url );
 
    //Establecer un tiempo de espera
    curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

    //establecer NOBODY en true para hacer una solicitud tipo HEAD
    curl_setopt( $ch, CURLOPT_NOBODY, true );
    //Permitir seguir redireccionamientos
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    //recibir la respuesta como string, no output
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    $data = curl_exec( $ch );

    //Obtener el código de respuesta
    $httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    //cerrar conexión
    curl_close( $ch );

    //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
    $accepted_response = array( 200, 301, 302 );
    if( in_array( $httpcode, $accepted_response ) ) {
        $returnText = "<i class='fa fa-check-circle' style='color:green !important'></i> Online";
        return $returnText; // True
    }elseif ( $httpcode == 403) {
        $returnText =  "<i class='fa fa-times-circle' style='color:orange !important'></i> Empty";
        return $returnText; // False
    }elseif( $httpcode == 404 ){
        $returnText = "<i class='fa fa-times-circle' style='color:orange !important'></i> Empty";
        return $returnText; // False
    }elseif ( $httpcode == 0 ) {
        $connected = @fsockopen("www.example.com", 80); 
        if ($connected){
                $is_conn = true; //action when connected
                fclose($connected);
                $returnText = "<i class='fa fa-times-circle' style='color:red !important'></i> No se ha comprado la url";
            }else{
                $is_conn = false; //action in connection failure
                $returnText = "<i class='fa fa-times-circle' style='color:red !important'></i> No hay internet";
            }
        return $returnText; // False
    }

}


?>