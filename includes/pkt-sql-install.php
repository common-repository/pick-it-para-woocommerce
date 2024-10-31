<?php

global $jal_db_version;
$jal_db_version = '1.0';

register_activation_hook( PICKIT_URL, 'pickit_sql_install_global' );
register_activation_hook( PICKIT_URL, 'pickit_sql_install_order' );


function pickit_sql_install_global () {
  global $wpdb;
  global $jal_db_version;
  
  $table_name = $wpdb->prefix . "woocommerce_pickit_global"; 
  $charset_collate = $wpdb->get_charset_collate();
  
  /*
  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    pickit_id int(9) NOT NULL AUTO_INCREMENT,
    pickit_testing_mode BOOLEAN,
    pickit_titledom char(255),
    pickit_apikey_retailer char(255),
    pickit_apikey_webapp char(255),
    pickit_token_id char(255),
    pickit_url_webservice char(255),
    pickit_url_webservice_test char(255),
    pickit_product_weight tinyint(1),
    pickit_product_dim tinyint(1),
    pickit_imposition_available tinyint(1),
    pickit_estado_actual tinyint(1),
    pickit_ship_campo_dni tinyint(1),
    pickit_ship_campo_dni_id tinyint(1),
    pickit_ship_type tinyint(1),
    pickit_ship_price_opt_dom tinyint(1),
    pickit_ship_price_fijo_dom int(25),
    pickit_ship_price_porcentual_dom float(25),
    pickit_ship_price_opt_punto tinyint(1),
    pickit_ship_price_fijo_punto int(25),
    pickit_ship_price_porcentual_punto float(25),
    PRIMARY KEY  (pickit_id)
  ) $charset_collate;";
  */
  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    pickit_id int(9) NOT NULL AUTO_INCREMENT,
    pickit_testing_mode BOOLEAN,
    pickit_apikey_webapp char(255),
    pickit_token_id char(255),
    pickit_shop_country tinyint(1),
    pickit_url_webservice char(255),
    pickit_url_webservice_test char(255),
    pickit_product_weight tinyint(1),
    pickit_product_dim tinyint(1),
    pickit_imposition_available tinyint(1),
    pickit_estado_actual tinyint(1),
    pickit_ship_campo_dni tinyint(1),
    pickit_ship_campo_dni_id char(255),
    pickit_ship_price_opt_punto tinyint(1),
    pickit_ship_price_fijo_punto int(25),
    pickit_ship_price_porcentual_punto float(25),
    PRIMARY KEY  (pickit_id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'jal_db_version', $jal_db_version );
}

function pickit_sql_install_order () {
  global $wpdb;
  global $jal_db_version;
  
  $table_name = $wpdb->prefix . "woocommerce_pickit_order"; 
  $charset_collate = $wpdb->get_charset_collate();
  
  $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    pickit_id int(9) NOT NULL AUTO_INCREMENT,
    pickit_wc_order_id int(9),
    pickit_transaccion_id int(9),
    pickit_etiqueta mediumtext NULL,
    pickit_seguimiento mediumtext NULL,
    pickit_estado_actual tinyint(1),
    pickit_orden_impuesta tinyint(1),
    PRIMARY KEY  (pickit_id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'jal_db_version', $jal_db_version );
}