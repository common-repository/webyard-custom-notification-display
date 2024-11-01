<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the string value for Message type
 */
function wcnd_message_type( $type ) {

    if( ! $type )
        return;

    switch ($type) {

        case "0":
            return 'Select';
            break;

        case "1":
            return 'Deadline';
            break;

        case "2":
            return 'Custom Message';
            break;

        case "3":
            return 'Minimum Amount';
            break;
        
        default:
            return 'Invalid';
            break;
    
    }

}

/**
 * 
 * Return string value for Template based on database template id
 * 
 */
function wcnd_template_number( $number ) {

    if( ! $number ) 
        return;

    switch ($number) {

        case "0":
            return 'Select';
            break;

        case "1":
            return 'Template 1';
            break;

        case "2":
            return 'Template 2';
            break;

        case "3":
            return 'Template 3';
            break;

        case "4":
            return 'Template 4';
            break;
        
        default:
            return 'Invalid';
            break;
    
    }

}