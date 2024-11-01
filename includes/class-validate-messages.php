<?php 

defined( 'ABSPATH' ) || exit;


/**
 * 
 * Notification Display - Validate
 * 
 */
Class WebYardNotificationDisplayValidateAjaxCall {

    public function __construct() {

        $this->setup_ajax_handlers();

    }

    public function setup_ajax_handlers() {

        add_action( 'wp_ajax_delete_single_row_message_wcnd', array( $this, 'remove_message_row' ) );

        add_action( 'wp_ajax_get_row_message_wcnd', array( $this, 'retrieve_message_details' ) );

        add_action( 'wp_ajax_update_row_message_wcnd', array( $this, 'validate_edited_message' ) );

        add_action( 'wp_ajax_save_notification_wcnd', array( $this, 'validate_save_message' ) );

        add_action( 'wp_ajax_save_template_settings_wcnd', array( $this, 'validate_template_styles' ) );

    }

    public function validate_template_styles() {

        $nonce  = $_POST['nonce'];

        if( ! wp_verify_nonce( $nonce, 'ncwd-nonce-ajax-security' ) )
            die('Busted!');

        $css_code = array(
            'font_size'     => sanitize_text_field( $_POST['fontsize'] ),
            'font_color'    => sanitize_text_field( $_POST['fontcolor'] ),
            'bg_color'      => sanitize_text_field( $_POST['bgcolor'] ),
            'btn_bgcolor'   => sanitize_text_field( $_POST['btnbgcolor'] ),
            'btn_textsize'  => sanitize_text_field( $_POST['btntextsize'] ),
            'btn_fontcolor' => sanitize_text_field( $_POST['btnFontColor'] ),
        );

        $serialized_css = maybe_serialize( $css_code );
        $template_id    = 1;

        $template =  WNDD()->save_template_settings( $template_id, $serialized_css );

        wp_send_json_success(
            wp_json_encode( $template )
        );

        die();

    }

    public function remove_message_row() {

        $nonce  = $_POST['nonce'];
        $id     = (int) $_POST['messageID'];

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $delete_msg = WNDD()->delete_row_message( $id );

        wp_send_json_success(
            wp_json_encode( $delete_msg )
        );

        die();

    }
    
    public function validate_edited_message() {

        $msg_type       = (int) $_POST['message_type'];
        $page_display   = sanitize_text_field( $_POST['page_display'] );
        $template_id    = (int) $_POST['template_id'];
        $start_date     = sanitize_text_field( $_POST['start_date'] );
        $end_date       = sanitize_text_field( $_POST['end_date'] );
        $msg_box        = sanitize_textarea_field( $_POST['message_box'] );
        $btn_text       = sanitize_text_field( $_POST['button_text'] );
        $btn_url        = sanitize_text_field( $_POST['button_url'] );
        $msgId          = (int) $_POST['messageId'];
        $nonce          = $_POST['nonce'];

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');
        
        if( in_array( wcnd_template_number($template_id), WNDS()->list_of_templates() ) ) {
    
            $valid_template_id = $template_id;
        
        }else{
        
            $valid_template_id = 0;
        
        }

        if( in_array( $page_display, WNDS()->list_of_page_types( false, 'validate_page_type') ) ) {

            $valid_page_display = $page_display;

        } else {

            $valid_page_display = '';
        
        }

        $data = array(
            'msg_type'          => $msg_type,
            'page_display'      => $valid_page_display,
            'template_id'       => $valid_template_id,
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'msg_box'           => $msg_box,
            'btn_text'          => $btn_text,
            'btn_url'           => $btn_url,
            'messageID'         => $msgId
        );

        $edited_msg = WNDD()->update_row_message( $data );

        wp_send_json_success(
            wp_json_encode( $edited_msg )
        );

        die();

    }

    public function retrieve_message_details() {

        $nonce  = $_POST['nonce'];
        $id     = (int) $_POST['messageID'];

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $message = WNDD()->get_message_details( $id );

        $castArr        = $message;
        $html_output    = array();

        if( empty( $castArr ) ) {
            $html_output['error'] = true;

            wp_send_json_success( 
                $html_output
            );

            die();
        }
        
        ob_start();
        include WEBYARD_CND_DIR__PATH . 'includes/admin/views/html-wcnd-edit-msg.php';
        $content = ob_get_clean();
        
        $html_output['content'] = $content;
        $html_output['error']   = false;

        wp_send_json_success( 
            $html_output
        );
        
        die();

    }

    public function validate_save_message() {

        $msg_type       = (int) $_POST['message_type'];
        $page_display   = sanitize_text_field( $_POST['page_display'] );
        $template_id    = (int) $_POST['template_id'];
        $start_date     = sanitize_text_field( $_POST['start_date'] );
        $end_date       = sanitize_text_field( $_POST['end_date'] );
        $msg_box        = sanitize_textarea_field( $_POST['message_box'] );
        $btn_text       = sanitize_text_field( $_POST['button_text'] );
        $btn_url        = sanitize_text_field( $_POST['button_url'] );
        $nonce          = $_POST['nonce'];

        if( in_array( wcnd_template_number($template_id), WNDS()->list_of_templates() ) ) {
        
            $valid_template_id = $template_id;
        
        }else{
        
            $valid_template_id = 0;
        
        }

        if( in_array( $page_display, WNDS()->list_of_page_types( false, 'validate_page_type') ) ) {

            $valid_page_display = $page_display;

        } else {

            $valid_page_display = '';
        
        }

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $data = array(
            'msg_type'          => $msg_type,
            'page_display'      => $valid_page_display,
            'template_id'       => $valid_template_id,
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'msg_box'           => $msg_box,
            'btn_text'          => $btn_text,
            'btn_url'           => $btn_url,
        );

        $savemsg = WNDD()->save_message_data( $data );

        wp_send_json_success(
            wp_json_encode( $savemsg )
        );

        die();

    }

}

new WebYardNotificationDisplayValidateAjaxCall();