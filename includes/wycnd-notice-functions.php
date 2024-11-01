<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return HTML notice error on dashboard if Woocommerce is not installed.
 */
function wcnd_admin_notice_error() {
    
    $class   = 'notice notice-error';
    $plugin  = __( 'Woocommerce Notification Display Plugin', 'WebYard' );
    $message = __( ' - Oopps! An error has occurred. Woocommerce is not installed!', 'WebYard' );
 
    printf( '<div class="%1$s"><p><b>%2$s</b>%3$s</p></div>', esc_attr( $class ), esc_html( $plugin ), esc_html( $message ) );

}