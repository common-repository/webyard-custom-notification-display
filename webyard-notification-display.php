<?php
/**
 * Plugin Name: WebYard Custom Notification Display
 * Plugin URI: https://profiles.wordpress.org/mongaya12/
 * Description: WebYard Custom Notification Display will help you boost your sales by informing your customer about promotions, sales on the shop page, product page, cart page or during checkout process.   
 * Version: 1.0.0
 * Author: Paul Jason Mongaya
 * Author URI: https://webyard.web.app/
 * License: GPL2
 */

if ( !defined( 'ABSPATH' ) ) {
    die;
}

define('WEBYARD_CND_DIR__PATH', plugin_dir_path( __FILE__ ) );
define('WEBYARD_CND__PATH', plugin_dir_url( __FILE__ ) );

require_once WEBYARD_CND_DIR__PATH . 'includes/wycnd-notice-functions.php';
require_once WEBYARD_CND_DIR__PATH . 'includes/wycnd-encoded-data-functions.php';

/**
* Detect plugin. For use in Admin area only.
*/
$wcnd_status = true;
if ( ! in_array( 
    'woocommerce/woocommerce.php', 
    apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
   )  ) {

    add_action( 'admin_notices', 'wcnd_admin_notice_error' );
    
    $wcnd_status = false;

}

require_once WEBYARD_CND_DIR__PATH . 'includes/class-wcnd-database.php';
require_once WEBYARD_CND_DIR__PATH . 'includes/class-validate-messages.php';
require_once WEBYARD_CND_DIR__PATH . 'includes/class-display-template-message.php';
require_once WEBYARD_CND_DIR__PATH . 'includes/class-webyard-notification-display.php';

//GLOBAL - CHECK STATUS IF WOOCMMERCE IS INSTALLED RETURN BOOLEAN;
$GLOBAL['wcnd_status'] = $wcnd_status;

function WNDD(){
    return new WebYardNotificationDisplayDatabase();
}

function WNDS() {
    return new WebYardNotificationDisplaySetup();
}