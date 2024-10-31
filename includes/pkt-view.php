<?php

/*
 * Add my new menu to the Admin Control Panel
*/
 
add_action( 'admin_menu', 'pkt_Add_My_Admin_Link' );
add_action( 'admin_enqueue_scripts', 'pickit_add_scripts' );

function pickit_add_scripts() {
    //Adding CSS
    wp_register_style ( 'pickitconfig', plugins_url ( '../assets/css/pkt-config-page.css', __FILE__ ) );
    wp_enqueue_style( 'pickitconfig', plugins_url ( '../assets/css/pkt-config-page.css', __FILE__ ) );
}

// Add a new top level menu link to the ACP
function pkt_Add_My_Admin_Link()
{
    add_menu_page(
        'Pickit', // Title of the page
        'Pickit', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        plugin_dir_path( __FILE__ ) . '/pkt-config-page.php' // The 'slug' - file to display when clicking the link
    );
}