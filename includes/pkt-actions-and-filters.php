<?php

include_once PICKIT_PATH . 'includes/pkt-class-utilities.php';

// TABLE EN MY_ACCOUNT (USUARIO) | Columna Tracking
add_filter( 'woocommerce_account_orders_columns', 'pickitAgregarColumnaTrackingUsuario', 10, 1 );
function pickitAgregarColumnaTrackingUsuario( $columns ){
    $new_columns = array();

    foreach ( $columns as $key => $name ) {

        $new_columns[ $key ] = $name;

        // add ship-to after order status column
        if ( 'order-actions' === $key ) {  //this is the line!
            $new_columns['pickit-tracking'] = __( 'Pickit - Tracking URL', 'woocommerce' );
        }
    }
    return $new_columns;
}

add_action( 'woocommerce_my_account_my_orders_column_pickit-tracking', 'pickitAgregarColumnaTrackingUsuarioContenido' );
function pickitAgregarColumnaTrackingUsuarioContenido( $order ) { 
    // ORDER ID (INT)
    $orderId = intval($order->get_order_number());
    $tracking = PKT_UTILITIES::consultarTracking($orderId);
    if ($tracking)
        echo "<a href='$tracking' target='_blank' class='button'>Seguimiento</a>";
}

 
// TABLE EN WooCommerce -> Orders (ADMIN) | Columna Etiqueta
add_filter( 'manage_edit-shop_order_columns', 'pickitAgregarColumnaOrderAdminEtiqueta' );
function pickitAgregarColumnaOrderAdminEtiqueta( $columns ) {
    $columns['pickit_etiqueta'] = 'Pickit - Etiqueta';
    return $columns;
}
 
add_action( 'manage_shop_order_posts_custom_column', 'pickitAgregarColumnaOrderAdminEtiquetaContenido' );
function pickitAgregarColumnaOrderAdminEtiquetaContenido( $column ) {
    global $post;
    if($column == "pickit_etiqueta"){
        // ORDER ID (INT) => | $post->ID |
        $orderId = $post->ID;
        $etiqueta = PKT_UTILITIES::consultarEtiqueta($orderId);
        if ($etiqueta)
            echo "<a href='$etiqueta' target='_blank' class='button'>Etiqueta</a>";
        else {
            $transaccionId = PKT_UTILITIES::consultarTransaccionId($orderId);

            if (!$transaccionId)
                return;
            
            $etiqueta = PKT_UTILITIES::obtenerEtiqueta($transaccionId);
            $responseCode = $etiqueta["Status"]["Code"];
            if ($responseCode == "200"){

                $urlEtiqueta = $etiqueta["Response"]["UrlEtiqueta"][0];
                echo "<a href='$urlEtiqueta' target='_blank' class='button'>Etiqueta</a>";
                PKT_UTILITIES::insertarEtiqueta($urlEtiqueta, $transaccionId);
            }
        }
    }
}

//  TABLE EN WooCommerce -> Orders (ADMIN) | Columna Estado Orden
add_filter( 'manage_edit-shop_order_columns', 'pickitAgregarColumnaOrderAdminEstadoOrden' );
function pickitAgregarColumnaOrderAdminEstadoOrden( $columns ) {
    $columns['pickit_estado_orden'] = 'Pickit - Estado de la Orden';
    return $columns;
}
 
add_action( 'manage_shop_order_posts_custom_column', 'pickitAgregarColumnaOrderAdminEstadoOrdenContenido' );
function pickitAgregarColumnaOrderAdminEstadoOrdenContenido( $column ) {
    global $post;
    if($column == "pickit_estado_orden"){
        // ORDER ID (INT) => | $post->ID |
        $orderId = $post->ID;
        $estadoorden = PKT_UTILITIES::consultarEstadoActual($orderId);
        if ( $estadoorden == 1)
            echo "En retailer";
        elseif ( $estadoorden == 2)
            echo "Disponible para retiro";
    }
}

//  TABLE EN WooCommerce -> Orders (ADMIN) | Columna Orden Impuesta
add_filter( 'manage_edit-shop_order_columns', 'pickitAgregarColumnaOrderAdminOrdenImpuesta' );
function pickitAgregarColumnaOrderAdminOrdenImpuesta( $columns ) {
    $columns['pickit_orden_impuesta'] = 'Pickit - Orden impuesta';
    return $columns;
}
 
add_action( 'manage_shop_order_posts_custom_column', 'pickitAgregarColumnaOrderAdminOrdenImpuestaContenido' );
function pickitAgregarColumnaOrderAdminOrdenImpuestaContenido( $column ) {
    global $post;
    if($column == "pickit_orden_impuesta"){
        $orderId = $post->ID;

        $estadoactual = PKT_UTILITIES::consultarOrdenImpuesta( $orderId );

        if ( $estadoactual == NULL ) 
            return;

        if ( $estadoactual == 0)
            echo "No impuesta";
        elseif ( $estadoactual == 1)
            echo "Impuesta";
    }
}

// BULK ACTION
//  Agrega la acción nueva a la lista de Admin -> WooCommerce -> Orders
add_filter( 'bulk_actions-edit-shop_order', 'pickitCambiarEstadoBulkAction', 20, 1 );
function pickitCambiarEstadoBulkAction( $actions ) {
    $actions['cambiar_estado'] = __( 'Pickit - Cambiar a disponible para colecta', 'woocommerce' );
    return $actions;
}

//  Realiza la acción del Bulk Action
add_filter( 'handle_bulk_actions-edit-shop_order', 'pickitCambiarEstadoBulkActionHandle', 10, 3 );
function pickitCambiarEstadoBulkActionHandle( $redirect_to, $action, $post_ids ) {
    if ( $action !== 'cambiar_estado' )
        return $redirect_to; // Exit
        
    $processed_ids = array();
    $requestsWs = array();

    foreach($post_ids as $id){
        $estadoInicialId = PKT_UTILITIES::consultarEstadoActual($id);
        if ($estadoInicialId == 1){
            $requestWs = PKT_UTILITIES::cambiarEstadoInicialWs($id);
            $requestDb = PKT_UTILITIES::cambiarEstadoInicialDb($id);
            $processed_ids[] = $id;
        }
    }

    if (empty($processed_ids))
        $ningunoCambioEstado = 1;

    return $redirect_to = add_query_arg( array(
        'processed_ids'     => $processed_ids,
        'cambio_estado'     => $ningunoCambioEstado,
        'seproceso'         => 1
    ), $redirect_to );
}

//  Muestra un mensaje de confirmación al usuario.
add_action( 'admin_notices', 'pickitCambiarEstadoBulkActionAdminNotice' );
function pickitCambiarEstadoBulkActionAdminNotice() {
    if ( !isset($_REQUEST['processed_ids']) && !isset($_REQUEST['seproceso'])) {
        return;
    }

    if ( isset($_REQUEST['processed_ids']) ) {
        $count = count($_REQUEST['processed_ids']);

        if ( isset($_REQUEST['cambio_estado']) )
            $ningunoCambioEstado = sanitize_text_field($_REQUEST['cambio_estado']);

        if( $count == 1 )
            echo("<div id='message' class='updated fade'><p>Se cambió el estado de 1 orden.</p></div>");
        else if ( $count > 1)
            echo("<div id='message' class='updated fade'><p>Se cambió el estado de $count órdenes.</p></div>");
        else if ( $ningunoCambioEstado == 1 )
            echo("<div id='message' class='error updated fade'><p>No se cambió el estado de ninguna orden.</p></div>");
        
        unset($_REQUEST['seproceso']);
    }

    if ( isset($_REQUEST['seproceso']) ){
        echo("<div id='message' class='error updated fade'><p>No se cambió el estado de ninguna orden.</p></div>");
        return;
    }
}

// Muestra un mensaje cuando no hay Puntos Pickits disponibles para el código postal.
add_action( 'woocommerce_before_shipping_calculator', 'pickitAgregoLabelNoHayPuntos' );
function pickitAgregoLabelNoHayPuntos() {
    if ( WC()->session->get( "noHayPuntos" ) && !WC()->session->get( "noSeIngresoCodigoPostal" ))
        echo "<label> No hay Puntos Pickit disponibles para tu código postal. </label>";
    else
        echo "";
}

// Muestra un mensaje cuando no hay Puntos Pickits disponibles para el código postal.
add_action( 'woocommerce_before_shipping_calculator', 'pickitAgregoLabelIngreseCodigoPostal' );
function pickitAgregoLabelIngreseCodigoPostal() {
    //if ($_SESSION["noSeIngresoCodigoPostal"]) {

    if ( WC()->session->get( "noSeIngresoCodigoPostal" ) ) {
        echo "<label> Ingrese su código postal para ver los envíos Pickit disponibles. </label>";
    }
    else {
        echo "";
    }
}

add_filter( 'woocommerce_billing_fields', 'pickitAgregarCampoDni');
function pickitAgregarCampoDni( $fields ) {
    if ( PKT_UTILITIES::obtenerCampoDni() )
        return $fields;
    
    $fields["billing_pickit_dni"] = array(
        'label' => 'DNI para retiro',
        'required' => true,
        'class' => array('dni-pickit-class', 'form-row-wide'),
        'placeholder'   => __('Ej: 11223344')
    );
    
    return $fields;
}