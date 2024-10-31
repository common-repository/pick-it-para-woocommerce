<?php

function pickit_register_delete_tables(){
    register_uninstall_hook( PICKIT_URL, 'pickit_delete_sql_tables' );
}
register_activation_hook( PICKIT_URL, 'pickit_register_delete_tables' );
 
// And here goes the uninstallation function:
function pickit_delete_sql_tables(){
    global $wpdb;

    $tablename = $wpdb->prefix . "woocommerce_pickit_global";
    $wpdb->query("DROP TABLE IF EXISTS $tablename");

    $tablename = $wpdb->prefix . "woocommerce_pickit_order";
    $wpdb->query("DROP TABLE IF EXISTS $tablename");
}