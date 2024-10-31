<?php

include_once PICKIT_PATH . "includes/pkt-class-utilities.php";


if (isset($_POST["submit_pickit_global"])){

  if ( $_POST["pickit_ship_price_fijo_punto"] )
    $pkt_fijo = sanitize_text_field($_POST["pickit_ship_price_fijo_punto"]);
  else
    $pkt_fijo = 0;
    //Sólo toma dos decimales del float.
  if ( $_POST["pickit_ship_price_porcentual_punto"] )
    $pkt_porc = sanitize_text_field($_POST["pickit_ship_price_porcentual_punto"]);
  else
    $pkt_porc = 0;

  $global_data = array(
    "testing_mode" => sanitize_text_field($_POST["pickit_testing_mode"]),
    //"titledom" => sanitize_text_field($_POST["pickit_titledom"],
    //"apk_r" => sanitize_text_field($_POST["pickit_apikey_retailer"],
    "apk_w" => sanitize_text_field($_POST["pickit_apikey_webapp"]),
    "token_id" => sanitize_text_field($_POST["pickit_token_id"]),
    "country" => sanitize_text_field($_POST["pickit_shop_country"]),
    "url_webs" => sanitize_text_field($_POST["pickit_url_webservice"]),
    "url_webs_test" => sanitize_text_field($_POST["pickit_url_webservice_test"]),
    "weight" => sanitize_text_field($_POST["pickit_product_weight"]),
    "dim" => sanitize_text_field($_POST["pickit_product_dim"]),
    "impos_av" => sanitize_text_field($_POST["pickit_imposition_available"]),
    "estado_actual" => sanitize_text_field($_POST["pickit_estado_actual"]),
    //"ship_price_opt_dom" => sanitize_text_field($_POST["pickit_ship_price_opt_dom"],
    //"ship_price_fijo_dom" => sanitize_text_field($_POST["pickit_ship_price_fijo_dom"],
    //"ship_price_porcentual_dom" => sanitize_text_field(number_format($_POST["pickit_ship_price_porcentual_dom"], 2),
    "ship_campo_dni" => sanitize_text_field($_POST["pickit_ship_campo_dni"]),
    "ship_campo_dni_id" => sanitize_text_field($_POST["pickit_ship_campo_dni_id"]),
    "ship_price_opt_punto" => sanitize_text_field($_POST["pickit_ship_price_opt_punto"]),
    "ship_price_fijo_punto" => $pkt_fijo,
    "ship_price_porcentual_punto" => $pkt_porc
  );

  function pickit_global_config_insert( $global_data ) {

    global $wpdb;

    $table_name = $wpdb->prefix . "woocommerce_pickit_global";
    /*
    $pickit_urlws = $wpdb->get_results(
      "SELECT pickit_shop_country FROM $table_name"
    );

    $country_db = $pickit_urlws[0]->pickit_shop_country;
    */
    $delete = $wpdb->query("TRUNCATE TABLE $table_name");

    /*
    $url_Paises = PKT_UTILITIES::obtenerUrlPaises();

    $url_webs = $global_data[url_webs];
    $url_UAT = $global_data[url_webs_test];

    if ( !$global_data[url_webs] )
      $url_webs = $url_Paises[$global_data[country]];

    if ( !$global_data[url_webs_test] )
      $url_UAT = PKT_UTILITIES::obtenerUrlUAT();

    if( $global_data[country] != $country_db) {
      $url_webs = $url_Paises[$global_data[country]];
      $url_UAT = PKT_UTILITIES::obtenerUrlUAT();
    }
    */
    
    $wpdb->insert(
      $table_name,
      array(
        "pickit_testing_mode" => $global_data["testing_mode"], 
        //"pickit_titledom" => $global_data["titledom"],
        "pickit_apikey_webapp" => $global_data["apk_w"], 
        "pickit_token_id" => $global_data["token_id"],
        "pickit_shop_country" => $global_data["country"],
        "pickit_url_webservice" => $global_data["url_webs"],
        "pickit_url_webservice_test" => $global_data["url_webs_test"],
        "pickit_product_weight" => $global_data["weight"],
        "pickit_product_dim" => $global_data["dim"],
        "pickit_imposition_available" => $global_data["impos_av"],
        "pickit_estado_actual" => $global_data["estado_actual"],
        //"pickit_ship_type" => $global_data["ship_type"],
        //"pickit_ship_price_opt_dom" => $global_data["ship_price_opt_dom"],
        //"pickit_ship_price_fijo_dom" => $global_data["ship_price_fijo_dom"],
        //"pickit_ship_price_porcentual_dom" => $global_data["ship_price_porcentual_dom"],
        "pickit_ship_campo_dni" => $global_data["ship_campo_dni"],
        "pickit_ship_campo_dni_id" => $global_data["ship_campo_dni_id"],
        "pickit_ship_price_opt_punto" => $global_data["ship_price_opt_punto"],
        "pickit_ship_price_fijo_punto" => $global_data["ship_price_fijo_punto"],
        "pickit_ship_price_porcentual_punto" => $global_data["ship_price_porcentual_punto"],
      ) 
    );
  }
  pickit_global_config_insert($global_data);
}