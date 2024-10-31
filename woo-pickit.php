<?php
/*
	Plugin Name: Pickit para Woocommerce
	Plugin URI: http://wanderlust-webdesign.com/
	Description: Pick It te permite cotizar el valor de un envío con una amplia cantidad de empresas de correo de una forma simple y estandarizada.
	Version: 0.2
	Author: Wanderlust Web Design
	Author URI: https://wanderlust-webdesign.com
	WC tested up to: 3.7
	Copyright: 2007-2019 wanderlust-webdesign.com.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Verifica que WooCommerce esté activo.
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    define( 'PICKIT_PATH', plugin_dir_path( __FILE__ ) );
    define( 'PICKIT_URL', __FILE__ );
    
    require_once PICKIT_PATH . 'includes/pkt-sql-install.php';
    require_once PICKIT_PATH . 'includes/pkt-sql-uninstall.php';
    require_once PICKIT_PATH . 'includes/pkt-view.php';
    require_once PICKIT_PATH . 'includes/pkt-form-handler.php';
    require_once PICKIT_PATH . 'includes/pkt-ship-methods.php';
    require_once PICKIT_PATH . 'includes/pkt-thankyou.php'; 
    require_once PICKIT_PATH . 'includes/pkt-actions-and-filters.php';
}