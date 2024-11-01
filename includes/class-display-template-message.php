<?php

defined( 'ABSPATH' ) || exit;

/**
 * 
 * Display Template Front End
 * 
 */

Class WebYardNotificationDisplayMessageTemplate {

    /**
     * 
     * Return Messages Array of Objects 
     * 
     */
    public static $wcnd_msg;


    public function __construct() {

        $this->initialize();

    }

    public function initialize() {

        add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles_frontend' ) );
        add_action( 'init', array( $this, 'template_html' ) );
        add_action( 'wp_loaded', array( $this, 'wc_hook_action' ) );

    }

    public function wc_hook_action() {

        add_action('woocommerce_before_main_content', array( $this, 'display_wc_template_msg_shop_page' ) );
        add_action('woocommerce_before_single_product', array( $this, 'display_wc_template_msg_product_page' ) );

    }

    public function scripts_styles_frontend() {

        wp_enqueue_style( 'wcnd-fontawesome-icons' , WEBYARD_CND__PATH . 'assets/libs/fontawesome/css/all.css',  array(), false );
        wp_enqueue_style( 'wcnd-front-end' , WEBYARD_CND__PATH . 'assets/css/wcnd-front-end-template.css',  array(), false );

    }

    public function get_initial_styles_template() {

        $template_style = WNDD()->get_template_styles();
        $tmp_arr        = array();

        if( $template_style ) {
            
            $ctr = 0;
            foreach ( $template_style as $style ) {
                $tmp_arr['templateID']    = $style->templateID;
                $tmp_arr['customCSS']     = maybe_unserialize( $style->customCSS );
            $ctr++;
            }
            
            return $tmp_arr;

        }

    }

    public function display_wc_template_msg_shop_page() {

        $data_msg = $this->wcnd_msg;
        
        if( is_shop() && $data_msg ) {

            $this->process_template_page_type_display( $data_msg );

        }

    }

    public function display_wc_template_msg_product_page() {

        $data_msg = $this->wcnd_msg;

        if( ( is_product() ) && ! empty( $data_msg ) ) {

            $this->process_template_page_type_display( $data_msg );

        }

    }

    public function process_template_page_type_display( $data_msg ) {
        
        if( empty( $data_msg ) || $data_msg == 'Empty' )
            return false;

        $template_styles = $this->get_initial_styles_template();

        foreach( $data_msg as $data ) {
            
            if( ( $data['page_type'] === 'product_page' ) && ( is_product() ) ) {

                if( in_array( wcnd_template_number( $data['templateID'] ), WNDS()->list_of_templates() ) ) {

                    include $this->get_template_html_by_id($data['templateID']); 

                }else{

                    include $this->get_template_html_by_id(1);

                }

            } else if ( ( $data['page_type'] === 'shop_page' ) && ( is_shop() ) ) {
                
                if( in_array( wcnd_template_number( $data['templateID'] ), WNDS()->list_of_templates() ) ) {

                    include $this->get_template_html_by_id($data['templateID']); 

                }else{

                    include $this->get_template_html_by_id(1);

                }

            } 

        }

    }

    public function get_template_html_by_id( $id ) {

        switch ($id) {
            
            case '1':
                return WEBYARD_CND_DIR__PATH . "templates/wcnd-template-1.php"; 
                break;
            
            case '2':
                return WEBYARD_CND_DIR__PATH . "templates/wcnd-template-2.php";
                break;

            default:
                return WEBYARD_CND_DIR__PATH . "templates/wcnd-template-1.php";
                break;

        }

    }

    public function template_html() {

        $msg_data = $this->start_end_date();

        if( $msg_data && $msg_data !== 'Empty' ) {

            $arr_msg = array();
            $ctr     = 0;

            foreach( $msg_data as $data ) {

                $arr_msg = array(
                    'page_type'     => $data->pageType,
                    'templateID'    => $data->templateID,
                    'btnText'       => $data->btnText,
                    'btnUrl'        => $data->btnUrl,
                    'message'       => $data->messages
                );

                $this->wcnd_msg[$ctr] = $arr_msg;
                $ctr++;
            }

        }
        

    }

    private function start_end_date() {

        $current_date   = current_time('m-d-Y'); 
        $msg_data       = WNDD()->get_start_date($current_date);
        $filter_date    = array();

        if( $msg_data ) {

            foreach( $msg_data as $data => $val ) {

                $endDate        = strtotime($msg_data[$data]->endDate);
                $current_date   = strtotime($current_date);
                $startDate      = strtotime($msg_data[$data]->startDate);

                if( ( $startDate <= $current_date ) &&  ( $endDate >= $current_date ) ) {

                    $filter_date[$data] = $val;

                }

            }

        } else {

            $filter_date = 'Empty';

        }

        return $filter_date;

    } 


}

new WebYardNotificationDisplayMessageTemplate();