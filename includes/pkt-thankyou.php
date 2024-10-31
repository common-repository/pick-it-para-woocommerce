<?php

include_once PICKIT_PATH . 'includes/pkt-class-utilities.php';

//add_action( 'woocommerce_checkout_order_processed', 'pickit_checkout_hook' );
//add_action( 'woocommerce_new_order', 'pickit_neworder_hooka' );

// Hook que agrega código en la página de confirmación de una compra. (Thank You)
add_action( 'woocommerce_thankyou', 'pickit_thankyou_hook' );

// Hook que agrega código cuando se crea una orden.
function pickit_thankyou_hook( $orderId ) {
    session_start();

    $order = new WC_Order($orderId);

    WC()->session->set( "noHayPuntos", NULL);
    WC()->session->set( "noSeIngresoCodigoPostal", NULL);

    if ( !WC()->session->get( "empezarCotizacion" ) )
    {
        WC()->session->get( "idPuntoPickitUno", NULL);
        WC()->session->get( "idPuntoPickitDos", NULL);
        WC()->session->get( "idPuntoPickitTres", NULL);
        WC()->session->get( "idPuntoPickitCuatro", NULL);
        WC()->session->get( "idPuntoPickitCinco", NULL);
        WC()->session->get( "precioPuntoPickit", NULL);

        return;
    }
    WC()->session->set( "empezarCotizacion", NULL );

    $idMetodoPunto1 = PKT_UTILITIES::obtenerIdMetodoPunto()[0];
    $idMetodoPunto2 = PKT_UTILITIES::obtenerIdMetodoPunto()[1];
    $idMetodoPunto3 = PKT_UTILITIES::obtenerIdMetodoPunto()[2];
    $idMetodoPunto4 = PKT_UTILITIES::obtenerIdMetodoPunto()[3];
    $idMetodoPunto5 = PKT_UTILITIES::obtenerIdMetodoPunto()[4];
    
    foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) {
        $shipping_method_id = $shipping_item_obj->get_method_id(); // The method ID
    }


    if( !$shipping_method_id ) {
        $shipping_method = @array_shift($order->get_shipping_methods());
        $shipping_method_id = $shipping_method['method_id'];
    }

    /*
    if ( $shipping_method_id == PKT_UTILITIES::obtenerIdMetodoDomicilio() ){

        WC()->session->set( "idPuntoPickitUno", NULL);
        WC()->session->set( "idPuntoPickitDos", NULL);
        WC()->session->set( "idPuntoPickitTres", NULL);
        WC()->session->set( "precioPuntoPickit", NULL);

        $envio = array(
            "tipo" => "domicilio"
        );

        $requestDomImpSimp = PKT_UTILITIES::imponerSimplificadoTransaccion($orderId, $envio);

        $transaccionId = $requestDomImpSimp["transactionId"];
        $urlTracking = $requestDomImpSimp["urlTracking"];
        $estadoInicial = PKT_UTILITIES::obtenerEstadoInicial();
        
        $responseCode = "";
        $count = 0;
        
        // Si en 5 oportunidades la etiqueta no pudo ser recuperada, se ignora y se pasa al siguiente paso.
        // (La etiqueta se recuperará más tarde.)
        while( $responseCode != "200" && $count < 5 ){
            $count++;
            // Espera dos segundos para que el Web Service genere la etiqueta.
            sleep(2);
            $etiqueta = PKT_UTILITIES::obtenerEtiqueta($transaccionId);
            $responseCode = $etiqueta["Status"]["Code"];
        }

        if ($responseCode == "200")
            $urlEtiqueta = $etiqueta["Response"]["UrlEtiqueta"][0];

        PKT_UTILITIES::insertarTablaOrder($orderId, $transaccionId, $urlEtiqueta, $urlTracking, $estadoInicial);

    } elseif */
    if (    $shipping_method_id == $idMetodoPunto1 ||
            $shipping_method_id == $idMetodoPunto2 || 
            $shipping_method_id == $idMetodoPunto3 || 
            $shipping_method_id == $idMetodoPunto4 || 
            $shipping_method_id == $idMetodoPunto5 ) {

        if ( PKT_UTILITIES::obtenerTipoImposicion() )
        {
            WC()->session->set( "idPuntoPickitUno", NULL);
            WC()->session->set( "idPuntoPickitDos", NULL);
            WC()->session->set( "idPuntoPickitTres", NULL);
            WC()->session->set( "idPuntoPickitCuatro", NULL);
            WC()->session->set( "idPuntoPickitCinco", NULL);
            WC()->session->set( "precioPuntoPickit", NULL);
    
            PKT_UTILITIES::insertarTablaOrderNoImpuesta( $orderId );
    
            return;
        }
        
        switch ($shipping_method_id)
        {
            case $idMetodoPunto1;
                $idPunto = WC()->session->get( "idPuntoPickitUno" );
                break;
            case $idMetodoPunto2;
                $idPunto = WC()->session->get( "idPuntoPickitDos" );
                break;
            case $idMetodoPunto3;
                $idPunto = WC()->session->get( "idPuntoPickitTres" );
                break;
            case $idMetodoPunto4;
                $idPunto = WC()->session->get( "idPuntoPickitCuatro" );
                break;
            case $idMetodoPunto5;
                $idPunto = WC()->session->get( "idPuntoPickitCinco" );
                break;
        }

        WC()->session->set( "idPuntoPickitUno", NULL);
        WC()->session->set( "idPuntoPickitDos", NULL);
        WC()->session->set( "idPuntoPickitTres", NULL);
        WC()->session->set( "idPuntoPickitCuatro", NULL);
        WC()->session->set( "idPuntoPickitCinco", NULL);
        WC()->session->set( "precioPuntoPickit", NULL);

        $envio = array(
            "tipo" => "punto",
            "idPunto" => $idPunto
        );        
        $requestImpSimp = PKT_UTILITIES::imponerSimplificadoTransaccion($orderId, $envio);
        
        $transaccionId = $requestImpSimp["transactionId"];
        $urlTracking = $requestImpSimp["urlTracking"];
        $estadoInicial = PKT_UTILITIES::obtenerEstadoInicial();
        
        $responseCode = "";
        $count = 0;
        
        // Si en 5 oportunidades la etiqueta no pudo ser recuperada, se ignora y se pasa al siguiente paso.
        // (La etiqueta se recuperará más tarde.)
        while( $responseCode != "200" && $count < 5 ){
            $count++;
            // Espera dos segundos para que el Web Service genere la etiqueta.
            sleep(2);
            $etiqueta = PKT_UTILITIES::obtenerEtiqueta($transaccionId);
            $responseCode = $etiqueta["Status"]["Code"];
        }

        if ($responseCode == "200")
            $urlEtiqueta = $etiqueta["Response"]["UrlEtiqueta"][0];
        else
            $urlEtiqueta = "";
            
        PKT_UTILITIES::insertarTablaOrderImpuesta($orderId, $transaccionId, $urlEtiqueta, $urlTracking, $estadoInicial);
    }
}