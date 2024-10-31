<?php

/**
 * Pickit Functions Class
 */
class PKT_UTILITIES {

    // Devuelve el tipo de envío disponible de la base de datos.
    public static function obtenerTipoDeEnvioDisponible(){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_type = ($wpdb->get_results(
            "SELECT pickit_ship_type FROM $table"
        ));
        
        if(!$pickit_ship_type)
            return;
            
        return $pickit_ship_type[0]->pickit_ship_type;
    }

    // Devuelve el ID de carrier del método a domicilio.
    public static function obtenerIdMetodoDomicilio(){
        return "pickit_domicilio_ship";
    }

    // Devuelve los IDs de carrier del método de cada punto Pickit.
    public static function obtenerIdMetodoPunto(){
        $idPuntos[] = "pickit_punto_1";
        $idPuntos[] = "pickit_punto_2";
        $idPuntos[] = "pickit_punto_3";
        $idPuntos[] = "pickit_punto_4";
        $idPuntos[] = "pickit_punto_5";
        return $idPuntos;
    }
    
    // Devuelve las URL de Web Service correspondiente a cada país.
    public static function obtenerUrlPaises(){
        $urlPaises[0] = "https://api.pickit.net";
        $urlPaises[1] = "https://api.pickit.com.uy/index.php";
        $urlPaises[2] = "https://api.pickit.com.mx/index.php";
        $urlPaises[3] = "https://api.pickit.com.co/index.php";
        return $urlPaises;
    }

    // Devuelve la URL de Web Service de Testing.
    public static function obtenerUrlUAT(){
        return "https://api.pickitlabs.com";
    }

    // Devuelve el TokenId de la base de datos.
    public static function obtenerTokenId() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_token_id = ($wpdb->get_results(
            "SELECT pickit_token_id FROM $table"
        ));

        if(!$pickit_token_id)
            return;

        return $pickit_token_id[0]->pickit_token_id;
    }

    // Devuelve la Apikey del WebApp la base de datos.
    public static function obtenerApikey() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_apikey = ($wpdb->get_results(
            "SELECT pickit_apikey_webapp FROM $table"
        ));
        
        if(!$pickit_apikey)
            return;

        return $pickit_apikey[0]->pickit_apikey_webapp;
    }

    // Devuelve la URL del Web Service de la base de datos.
    // Depende del valor de pickit_testing_mode
    // (Si el modo de testeo está habilitado, devuelve la URL de testeo.)
    public static function obtenerUrlWS() {

        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $resp = ($wpdb->get_results(
            "SELECT pickit_testing_mode FROM $table"
        ));

        if(!$resp)
            return;

        $pickit_testing_mode = $resp[0]->pickit_testing_mode;

        //Si el modo de testeo está deshabilitado.
        if ($pickit_testing_mode == 0){

            $table = $wpdb->prefix . 'woocommerce_pickit_global';

            $pickit_urlws = $wpdb->get_results(
                "SELECT pickit_url_webservice FROM $table"
            );

            //Retorna el URL del Web Service.
            return $pickit_urlws[0]->pickit_url_webservice;

        } else {

            $table = $wpdb->prefix . 'woocommerce_pickit_global';

            $pickit_urlwst = $wpdb->get_results(
                "SELECT pickit_url_webservice_test FROM $table"
            );

            //Retorna el URL de Testing del Web Service.
            return $pickit_urlwst[0]->pickit_url_webservice_test;
        }
    }

    // Devuelve el tipo de Precio de envío a domicilio de la base de datos.
    public static function obtenerTipoPrecioEnvioDom() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_price_opt_dom = ($wpdb->get_results(
            "SELECT pickit_ship_price_opt_dom FROM $table"
        ))[0]->pickit_ship_price_opt_dom;

        return $pickit_ship_price_opt_dom;
    }

    // Devuelve el Precio Fijo de envío a domicilio de la base de datos.
    public static function obtenerPrecioFijoEnvioDom() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_price_fijo_dom = ($wpdb->get_results(
            "SELECT pickit_ship_price_fijo_dom FROM $table"
        ))[0]->pickit_ship_price_fijo_dom;

        return (float)$pickit_ship_price_fijo_dom;
    }

    // Devuelve el porcentaje personalizado del precio de envío a domicilio de la base de datos.
    public static function obtenerPrecioPorcentualEnvioDom() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_price_porcentual_dom = ($wpdb->get_results(
            "SELECT pickit_ship_price_porcentual_dom FROM $table"
        ))[0]->pickit_ship_price_porcentual_dom;

        return ($pickit_ship_price_porcentual_dom / 100);
    }

    // Devuelve 0 o 1 - El campo DNI se crea o se usa uno existente.
    public static function obtenerCampoDni() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_campo_dni = ($wpdb->get_results(
            "SELECT pickit_ship_campo_dni FROM $table"
        ))[0]->pickit_ship_campo_dni;

        return $pickit_ship_campo_dni;
    }

    // Devuelve el ID del campo DNI de la tienda.
    public static function obtenerCampoDniId() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_campo_dni_id = ($wpdb->get_results(
            "SELECT pickit_ship_campo_dni_id FROM $table"
        ))[0]->pickit_ship_campo_dni_id;

        return $pickit_ship_campo_dni_id;
    }

    // Devuelve el tipo de Precio de envío a punto de la base de datos.
    public static function obtenerTipoPrecioEnvioPunto() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_price_opt_punto = ($wpdb->get_results(
            "SELECT pickit_ship_price_opt_punto FROM $table"
        ))[0]->pickit_ship_price_opt_punto;

        return $pickit_ship_price_opt_punto;
    }

    // Devuelve el Precio Fijo de envío a punto de la base de datos.
    public static function obtenerPrecioFijoEnvioPunto() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_price_fijo_punto = ($wpdb->get_results(
            "SELECT pickit_ship_price_fijo_punto FROM $table"
        ))[0]->pickit_ship_price_fijo_punto;

        return (float)$pickit_ship_price_fijo_punto;
    }

    // Devuelve el porcentaje personalizado del precio de envío a punto de la base de datos.
    public static function obtenerPrecioPorcentualEnvioPunto() {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_ship_price_porcentual_punto = ($wpdb->get_results(
            "SELECT pickit_ship_price_porcentual_punto FROM $table"
        ))[0]->pickit_ship_price_porcentual_punto;

        return ($pickit_ship_price_porcentual_punto / 100);
    }

    // Devuelve el nombre a mostrar del envío a domicilio de la base de datos.
    public static function obtenerTitleDom(){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_titledom = ($wpdb->get_results(
            "SELECT pickit_titledom FROM $table"
        ))[0]->pickit_titledom;

        return $pickit_titledom;
    }

    // Devuelve el estado inicial.
    public static function obtenerEstadoInicial(){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_estado_actual = ($wpdb->get_results(
            "SELECT pickit_estado_actual FROM $table"
        ))[0]->pickit_estado_actual;

        return (int)$pickit_estado_actual;
    }

    // Devuelve el tipo del peso de producto (kg, g, libra) de la base de datos.
    public static function obtenerTipoPesoProducto(){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_product_weight = ($wpdb->get_results(
            "SELECT pickit_product_weight FROM $table"
        ))[0]->pickit_product_weight;

        return $pickit_product_weight;
    }

    // Devuelve el tipo de las dimensiones del producto (cm, m) de la base de datos.
    public static function obtenerTipoDimensionProducto(){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_product_dim = ($wpdb->get_results(
            "SELECT pickit_product_dim FROM $table"
        ))[0]->pickit_product_dim;

        return $pickit_product_dim;
    }
    
    //Devuelve el Id del tipo de precio fijo.
    public static function obtenerIdTipoPrecioFijo(){
        return 1;
    } 

    //Devuelve el Id del tipo de precio porcentual.
    public static function obtenerIdTipoPrecioPorcentual(){
        return 2;
    }  
     
    //Devuelve el Id del tipo de peso kilogramo.
    public static function obtenerIdTipoPesoKilo(){
        return 0;
    }

    //Devuelve el Id del tipo de peso libra.
    public static function obtenerIdTipoPesoLibra(){
        return 2;        
    }

    //Devuelve el Id del tipo de dimensión centímetro.
    public static function obtenerIdTipoDimensionCentimetro(){
        return 0;        
    }

    //Devuelve el Id del tipo de dimensión centímetro.
    public static function obtenerIdTipoDimensionMilimetro(){
        return 2;        
    }

    // Devuelve el ID del tipo de operación de domicilio.
    public static function obtenerOperationTypeDomicilio(){
        return 2;        
    }

    // Devuelve el ID del tipo de operación de punto.
    public static function obtenerOperationTypePunto(){
        return 1;        
    }

    // Devuelve el tipo de imposición de la base de datos.
    public static function obtenerTipoImposicion(){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_global';

        $pickit_imposition_available = ($wpdb->get_results(
            "SELECT pickit_imposition_available FROM $table"
        ))[0]->pickit_imposition_available;

        return $pickit_imposition_available;
    }

    // Inserta en la tabla de "pickit_order".
    // pickit_orden_impuesta:
    // 0 => No impuesta
    // 1 => Impuesta
    public static function insertarTablaOrderImpuesta ( $orderId, $transaccionId, $urlEtiqueta, $urlTracking, $estadoInicial ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'woocommerce_pickit_order';

        $wpdb->insert(
            $table_name,
            array(
                'pickit_wc_order_id' => $orderId, 
                'pickit_transaccion_id' => $transaccionId,
                'pickit_etiqueta' => $urlEtiqueta,
                'pickit_seguimiento' => $urlTracking,
                'pickit_estado_actual' => $estadoInicial,
                'pickit_orden_impuesta' => 1
            )
        );
    }

    // Inserta en la tabla de "pickit_order".
    public static function insertarTablaOrderNoImpuesta ( $orderId ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'woocommerce_pickit_order';

        $wpdb->insert(
            $table_name,
            array(
                'pickit_wc_order_id' => $orderId,
                'pickit_orden_impuesta' => 0
            )
        );
    }

    // Inserta en la tabla de "pickit_order".
    public static function insertarEtiqueta($urlEtiqueta, $transaccionId){
        global $wpdb;

        $table = $wpdb->prefix . 'woocommerce_pickit_order';

        $wpdb->query( $wpdb->prepare(
            "UPDATE $table SET pickit_etiqueta = %s WHERE pickit_transaccion_id = %d",
            $urlEtiqueta, $transaccionId)
        );
    }

    // Devuelve la etiqueta de la base de datos.
    public static function consultarEtiqueta($orderId){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_order';


        $pickit_etiqueta = ($wpdb->get_results(
            "SELECT pickit_etiqueta FROM $table WHERE (pickit_wc_order_id = $orderId)"
        ));

        if (!$pickit_etiqueta)
            return;

        return $pickit_etiqueta[0]->pickit_etiqueta;
    }

    // Devuelve la URL de Tracking de la base de datos.
    public static function consultarTracking( $orderId ) {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_order';

        $pickit_seguimiento = ($wpdb->get_results(
            "SELECT pickit_seguimiento FROM $table WHERE (pickit_wc_order_id = $orderId)"
        ));

        if (!$pickit_seguimiento)
            return;

        return $pickit_seguimiento[0]->pickit_seguimiento;
    }

    // Devuelve el estado inicial de la base de datos.
    public static function consultarEstadoActual( $orderId ) {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_order';

        $pickit_estado_actual = ($wpdb->get_results(
            "SELECT pickit_estado_actual FROM $table WHERE (pickit_wc_order_id = $orderId)"
        ));

        if (!$pickit_estado_actual)
            return;
            
        return $pickit_estado_actual[0]->pickit_estado_actual;
    }

    // Devuelve el estado de la Imposición de la base de datos.
    public static function consultarOrdenImpuesta( $orderId ) {
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_order';

        $pickit_orden_impuesta = ($wpdb->get_results(
            "SELECT pickit_orden_impuesta FROM $table WHERE (pickit_wc_order_id = $orderId)"
        ));

        if (!$pickit_orden_impuesta)
            return;
            
        return $pickit_orden_impuesta[0]->pickit_orden_impuesta;
    }

    // Devuelve el ID de transacción de la base de datos.
    public static function consultarTransaccionId($orderId){
        global $wpdb;
        $table = $wpdb->prefix . 'woocommerce_pickit_order';

        $pickit_transaccion_id = ($wpdb->get_results(
            "SELECT pickit_transaccion_id FROM $table WHERE (pickit_wc_order_id = $orderId)"
        ));

        if (!$pickit_transaccion_id)
            return;
            
        return $pickit_transaccion_id[0]->pickit_transaccion_id;
    }

    // Cambia el estado inicial de la base de datos de 1 a 2 de el registro asociado al ID de orden.
    public static function cambiarEstadoInicialDb($orderId){
        global $wpdb;

        $table = $wpdb->prefix . 'woocommerce_pickit_order';

        $request = $wpdb->query( $wpdb->prepare( "UPDATE $table SET pickit_estado_actual = %d WHERE pickit_wc_order_id = %d", 2, $orderId) );

        return $request;
    }

    // ---------- Empiezan las funciones de Web Service ---------- //

    // Función para generar request al Web Service de Pickit
    public static function callPickitWs($data, $url) {
        $postdata = json_encode($data);
        
        //$ch = curl_init();
        
		$pickit_url = PKT_UTILITIES::obtenerUrlWS();
        $pickit_apikey = PKT_UTILITIES::obtenerApikey();

        $requestUrl = $pickit_url . $url;

        $headers = array (
            'Content-Type' => 'application/json',
            'apiKey' => $pickit_apikey
        );

        $args = array(
            'body' => $postdata,
            'headers' => $headers
        );
            
        $response = wp_remote_post( $requestUrl, $args );
        $body = wp_remote_retrieve_body( $response );

        $output = json_decode($body, true);

        return $output;
    }

    // Función para generar request al Web Service V2.0 de Pickit
    public static function callNewPickitWs($data, $url) {
        $postdata = json_encode($data);
        
        //$ch = curl_init();
        
		$pickit_url = PKT_UTILITIES::obtenerUrlWS();
        $pickit_apikey = PKT_UTILITIES::obtenerApikey();
        $pickit_token_id = PKT_UTILITIES::obtenerTokenId();

        $requestUrl = $pickit_url . $url;

        $headers = array (
            'Content-Type' => 'application/json',
            'apiKey' => $pickit_apikey,
            'token' => $pickit_token_id
        );

        $args = array(
            'body' => $postdata,
            'headers' => $headers
        );
            
        $response = wp_remote_post( $requestUrl, $args );
        $body = wp_remote_retrieve_body( $response );
        $output = json_decode($body, true);

        return $output;
    }

    // Devuelve la etiqueta del Web Service.
    public static function obtenerEtiqueta($transaccionId){

        $dataEtiqueta = array(
            'transaccionId' => $transaccionId,
        );

        $urlEtiqueta = "/api/ObtenerEtiqueta";

        $requestEtiqueta = PKT_UTILITIES::callPickitWs($dataEtiqueta, $urlEtiqueta);

        return $requestEtiqueta;
    }

    // Cambia el estado de 1 a 2 de la orden del ID transacción enviado.
    public static function cambiarEstadoInicialWs($orderId){
        $pickit_token_id = PKT_UTILITIES::obtenerTokenId();
        $transaccionId = PKT_UTILITIES::consultarTransaccionId($orderId);

        $dataCambiarEstado = array(
            "tokenId" => $pickit_token_id,
            "transaccionId" => $transaccionId
        );

        $urlCambiarEstado = "/api/DisponibleParaRetiro";

        $requestCambiarEstado = PKT_UTILITIES::callPickitWs($dataCambiarEstado, $urlCambiarEstado);

        return $requestCambiarEstado;
    }

    // Devuelve la cotización (A domicilio o a punto).
    public static function obtenerCotizacion($package, $envio){

        $listaProductos = array();

        foreach ($package["contents"] as $prod => $value) {
            
            $_product = new WC_Product($value["product_id"]);

            $pprice = $_product->get_price();
            $pweight = $_product->get_weight();
            $plength = floatval($_product->get_length());
            $pwidth = floatval($_product->get_width());
            $pheight = floatval($_product->get_height());
            $pname = $_product->get_name();
            $psku = $_product->get_sku();

            $tipoPesoProducto = PKT_UTILITIES::obtenerTipoPesoProducto();
            $tipoDimensionProducto = PKT_UTILITIES::obtenerTipoDimensionProducto();

            $centimetro = PKT_UTILITIES::obtenerIdTipoDimensionCentimetro();
            $milimetro = PKT_UTILITIES::obtenerIdTipoDimensionMilimetro();

            if ( $tipoPesoProducto == PKT_UTILITIES::obtenerIdTipoPesoKilo() )
                $pweight *= 1000;
            elseif ( $tipoPesoProducto == PKT_UTILITIES::obtenerIdTipoPesoLibra() )
                $pweight *= 453.6;

            if ( $tipoDimensionProducto == $milimetro ) {
                $plength /= 10;
                $pheight /= 10;
                $pwidth /= 10;
                $tipoDimensionProducto = $centimetro;
            }

            $newProductToAdd = array(
                "name" => $pname,
                "weight" => array(
                    "amount" => $pweight ? (float)ceil($pweight) : 1,
                    "unit" => "g"
                ),
                "length" => array(
                    "amount" => $plength ? (float)$plength : 1,
                    "unit" => $tipoDimensionProducto == $centimetro ? "cm" : "m"
                ),
                "height" => array(
                    "amount" => $pheight ? (float)$pheight : 1,
                    "unit" => $tipoDimensionProducto == $centimetro ? "cm" : "m"
                ),
                "width" => array(
                    "amount" => $pwidth ? (float)$pwidth : 1,
                    "unit" => $tipoDimensionProducto == $centimetro ? "cm" : "m"
                ),
                "price" => $pprice ? (float)$pprice : 1,
                "sku" => $psku
            );
            array_push($listaProductos, $newProductToAdd);
        }
    
        if(is_user_logged_in()){
            $customer = new WC_Customer($package["user"]["ID"]);
            $customerdata = $customer->get_data();
            
            /*
            $nombre = $customerdata["shipping"]["first_name"];
            $apellido = $customerdata["shipping"]["last_name"];
            $email = $customerdata["email"];
            $tel = $customerdata["billing"]["phone"];
            */
            
            $nombre = $customer->get_shipping_first_name();
            $apellido = $customer->get_shipping_last_name();
            $email = $customer->get_email();
            $tel = $customer->get_billing_phone();

            //$pais = $package["destination"]["country"];
            $provinciaId = $package["destination"]["state"];
            $codpost = $package["destination"]["postcode"];
            $ciudad = $package["destination"]["city"] == NULL ? "No especificado" : $package["destination"]["city"];
            $dir = $package["destination"]["address"];
            $dir2 = $package["destination"]["address_1"];
            $dir3 = $package["destination"]["address_2"];
        }
        
        $woocommerce = wc();
        if ( $woocommerce->customer->get_shipping_postcode() ) {
            $codpost = $woocommerce->customer->get_shipping_postcode();
            $ciudad = $woocommerce->customer->get_shipping_city() == NULL ? "No especificado" : $woocommerce->customer->get_shipping_city();
            $nombre = "Test";
            $apellido = "Test";
            $email = "test@test.com";
            $tel = "0000000000";
            $dir = "Test 1234";
            $provinciaId = "TEST";
        }

        $pickit_token_id = PKT_UTILITIES::obtenerTokenId();

        if ($envio["tipo"] == "domicilio")
            $dataCotPkt = array (
                "serviceType" => "PP",
                "workflowTag" => "dispatch",
                "operationType" => PKT_UTILITIES::obtenerOperationTypeDomicilio(),
                "retailer" => array(
                    "tokenId" => $pickit_token_id,
                ),
                "products" => $listaProductos,
                "sla" => array(
                    "id" => 1
                ),
                "customer" => array(
                    "name" => $nombre,
                    "lastName" => $apellido,
                    "pid" => 1,
                    "email" => $email,
                    "phone" => $tel,
                    "address" => array(
                        "postalCode" => $codpost,
                        "address" => $dir,
                        "city" => $ciudad,
                        "province" => $provinciaId
                    )
                ),
            );
        else if ($envio["tipo"] == "punto")
            $dataCotPkt = array (
                "serviceType" => "PP",
                "workflowTag" => "dispatch",
                "operationType" => PKT_UTILITIES::obtenerOperationTypePunto(),
                "retailer" => array(
                    "tokenId" => $pickit_token_id,
                ),
                "products" => $listaProductos,
                "sla" => array(
                    "id" => 1
                ),
                "customer" => array(
                    "name" => $nombre,
                    "lastName" => $apellido,
                    "pid" => 1,
                    "email" => $email,
                    "phone" => $tel,
                    "address" => array(
                        "postalCode" => $codpost,
                        "address" => $dir,
                        "city" => $ciudad,
                        "province" => $provinciaId
                    )
                ),
                "pointId" => $envio["idPunto"]
        );

        $urlCotPkt = "/apiV2/budget";

        $requestCotPkt = PKT_UTILITIES::callNewPickitWs($dataCotPkt, $urlCotPkt);
        
        return $requestCotPkt;
    }
    
    // Devuelve los puntos Pickit asociados al código postal.
    public static function obtenerPuntos( $postCode ){

        $woocommerce = wc();
        if ( $woocommerce->customer->get_shipping_postcode() ){
            $postCode = $woocommerce->customer->get_shipping_postcode();
        }
        
        if (!$postCode)
            return;

        $url = "/apiV2/map/point";
        
		$pickit_url = PKT_UTILITIES::obtenerUrlWS();
        $pickit_apikey = PKT_UTILITIES::obtenerApikey();
        $pickit_token_id = PKT_UTILITIES::obtenerTokenId();

        $requestUrl = $pickit_url . $url;
    
        $parameters = array (
            "filter.retailer.tokenId"   => $pickit_token_id,
            "filter.postalCode"         => $postCode,
            "orderBy"                   => "rnd"
        );

        $headers = array (
            'Content-Type' => 'application/json',
            'apiKey' => $pickit_apikey,
            'token' => $pickit_token_id
        );

        $args = array(
            'headers' => $headers
        );
            
        $response = wp_remote_get( $requestUrl . '?' . http_build_query($parameters), $args );
        $body = wp_remote_retrieve_body( $response );
        $output = json_decode($body, true);
        
        return $output;
    }

    // Impone la transacción (A domicilio o a punto).
    public static function imponerSimplificadoTransaccion ( $orderId, $envio ) {
        $order = new WC_Order($orderId);

        //$billing = $order->get_data()["billing"];
        //$shipping = $order->get_data()["shipping"];
        if ( PKT_UTILITIES::obtenerCampoDni() ) {
            // Obtiene el DNI de un campo existente
            if ( get_post_meta( $orderId, '_' . PKT_UTILITIES::obtenerCampoDniId(), true ) )
            $dni = (int)get_post_meta( $orderId, '_' . PKT_UTILITIES::obtenerCampoDniId(), true );

            if ( get_post_meta( $orderId, PKT_UTILITIES::obtenerCampoDniId(), true ) )
                $dni = (int)get_post_meta( $orderId, PKT_UTILITIES::obtenerCampoDniId(), true );
        }
        else
            // Obtiene el DNI del campo creado
            $dni = (int)get_post_meta( $orderId, '_billing_pickit_dni', true );

        if ( !$dni )
            $dni = 11111111;

        $nombre = $order->get_shipping_first_name();
        $apellido = $order->get_shipping_last_name();
        $dir = $order->get_shipping_address_1();
        $ciudad = $order->get_shipping_city();
        $provincia = $order->get_shipping_state();
        $postcode = $order->get_shipping_postcode();
        $pais = $order->get_shipping_country();
        $email = $order->get_billing_email();
        $phone = $order->get_billing_phone();

        if (!$nombre)
            $nombre = $order->get_billing_first_name();
        if (!$apellido)
            $nombre = $order->get_billing_last_name();
        if (!$dir)
            $nombre = $order->get_billing_address_1();
        if (!$ciudad)
            $nombre = $order->get_billing_city();
        if (!$provincia)
            $nombre = $order->get_billing_state();
        if (!$postcode)
            $nombre = $order->get_billing_postcode();
        if (!$pais)
            $nombre = $order->get_billing_country();

        $orderProducts = $order->get_items();

        $listaProductos = array();

        foreach ($orderProducts as $ordProd => $prod) {
            $quantity = $prod->get_data()["quantity"];
            $prodId = $prod->get_data()["product_id"];

            $_product = new WC_Product($prodId);

            $pprice = $_product->get_price();
            $pweight = $_product->get_weight();
            $plength = $_product->get_length();
            $pwidth = $_product->get_width();
            $pheight = $_product->get_height();
            $pname = $_product->get_name();
            $psku = $_product->get_sku();

            $tipoPesoProducto = PKT_UTILITIES::obtenerTipoPesoProducto();
            $tipoDimensionProducto = PKT_UTILITIES::obtenerTipoDimensionProducto();

            $centimetro = PKT_UTILITIES::obtenerIdTipoDimensionCentimetro();
            $milimetro = PKT_UTILITIES::obtenerIdTipoDimensionMilimetro();

            if ( $tipoPesoProducto == PKT_UTILITIES::obtenerIdTipoPesoKilo() )
                $pweight *= 1000;
            elseif ( $tipoPesoProducto == PKT_UTILITIES::obtenerIdTipoPesoLibra() )
                $pweight *= 453.6;

            if ( $tipoDimensionProducto == $milimetro ) {
                $plength /= 10;
                $pheight /= 10;
                $pwidth /= 10;
                $tipoDimensionProducto = $centimetro;
            }

            for($i=0;$i<$quantity;$i++){

                $newProductToAdd = array(
                    "name" => $pname,
                    "weight" => array(
                        "amount" => $pweight ? (float)ceil($pweight) : 1,
                        "unit" => "g"
                    ),
                    "length" => array(
                        "amount" => $plength ? (float)$plength : 1,
                        "unit" => $tipoDimensionProducto == $centimetro ? "cm" : "m"
                    ),
                    "height" => array(
                        "amount" => $pheight ? (float)$pheight : 1,
                        "unit" => $tipoDimensionProducto == $centimetro ? "cm" : "m"
                    ),
                    "width" => array(
                        "amount" => $pwidth ? (float)$pwidth : 1,
                        "unit" => $tipoDimensionProducto == $centimetro ? "cm" : "m"
                    ),
                    "price" => $pprice ? (float)$pprice : 1,
                    "sku" => $psku
                );
                array_push($listaProductos, $newProductToAdd);
            }
        }

        $pickit_token_id = PKT_UTILITIES::obtenerTokenId();
        $estado_inicial = PKT_UTILITIES::obtenerEstadoInicial();
        $pickit_apikey = PKT_UTILITIES::obtenerApikey();

        if ( $envio["tipo"] == "domicilio" )
            $dataImp = array(
                "budgetPetition" => array(
                    "serviceType" => "PP",
                    "workflowTag" => 'dispatch',
                    "operationType" => PKT_UTILITIES::obtenerOperationTypeDomicilio(),
                    "retailer" => array(
                        "tokenId" => $pickit_token_id
                    ),
                    "products" => $listaProductos,
                    "sla" => array(
                        "id" => 1
                    ),
                    "customer" => array(
                        "name" => $nombre,
                        "lastName" => $apellido,
                        // DNI
                        "pid" => $dni,
                        "email" => $email,
                        "phone" => $phone,
                        "address" => array(
                            "postalCode" => $postcode,
                            "address" => $dir,
                            "city" => $ciudad,
                            "province" => $provincia
                        )
                    ),
                ),
                "firstState" => $estado_inicial,
                "trakingInfo" => array(
                "order" => (string)$orderId
                //"shipment" => "string"
                ),
                "packageAmount" => 1
            );
        else if ( $envio["tipo"] == "punto" )
            $dataImp = array(
                "budgetPetition" => array(
                    "serviceType" => "PP",
                    "workflowTag" => 'dispatch',
                    "operationType" => PKT_UTILITIES::obtenerOperationTypePunto(),
                    "retailer" => array(
                        "tokenId" => $pickit_token_id
                    ),
                    "products" => $listaProductos,
                    "sla" => array(
                        "id" => 1
                    ),
                    "customer" => array(
                        "name" => $nombre,
                        "lastName" => $apellido,
                        // DNI
                        "pid" => $dni,
                        "email" => $email,
                        "phone" => $phone,
                        "address" => array(
                            "postalCode" => $postcode,
                            "address" => $dir,
                            "city" => $ciudad,
                            "province" => $provincia
                        )
                    ),
                    "pointId" => $envio["idPunto"]
                ),
                "firstState" => $estado_inicial,
                "trakingInfo" => array(
                    "order" => (string)$orderId
                ),
                "packageAmount" => 1
            );

        $urlImp = "/apiV2/transaction";

        $requestImp = PKT_UTILITIES::callNewPickitWs($dataImp, $urlImp);

        if (!$requestImp["price"])
            $requestImp = PKT_UTILITIES::callNewPickitWs($dataImp, $urlImp);

        return $requestImp;
    }
}