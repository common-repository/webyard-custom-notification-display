<?php

defined( 'ABSPATH' ) || exit;

/**
 * 
 * Webyard Notification Display Create Tables and Queries
 * 
 */
Class WebYardNotificationDisplayDatabase {

    /**
     * 
     *  Notification Display Tables Version
     * 
     * @var string
     * 
     */
    public $db_version = '1.0.0';

    /**
     * 
     *  Notification Table Prefix
     * 
     * @var string
     */
    public $table_prefix = '';

    /**
     * 
     *  Notification Table Names
     * 
     * @var string
     * 
     */
    public $db_tb_messages  = 'wcnd_messages';

    /**
     * 
     *  Notification Table
     * 
     */
    private $table_name = '';


    public function __construct() {

        global $wpdb;
        $this->table_prefix = $wpdb->prefix;
        $this->table_name = $wpdb->prefix . $this->db_tb_messages;

        add_action( 'init', array( $this, 'initialize') );

    }

    public function initialize() {

        $this->create_tables();

    }

    public function create_tables() {

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $table_name     = $this->table_prefix . $this->db_tb_messages;

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        templateID int(10) NOT NULL,
        messageType int(10) NOT NULL,
        pageType varchar(255) NOT NULL,
        messages varchar(500) NOT NULL,
        startDate varchar(100) NOT NULL,
        endDate varchar(100) NOT NULL,
        btnText varchar(255) NOT NULL,
        btnUrl varchar(255) NOT NULL,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL,
        PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        dbDelta( $sql );

        $table_template = $this->table_prefix . 'wcnd_templates';

        $sql_2 = "CREATE TABLE IF NOT EXISTS $table_template (
            id int(10) unsigned NOT NULL AUTO_INCREMENT,
            templateID int(10) NOT NULL,
            customCSS varchar(500) NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL,
            PRIMARY KEY  (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    
        dbDelta( $sql_2 );

    }

    public function save_message_data( $data ) {

        if( ! $data )
            return;
        
        global $wpdb;

        $table_name     = $wpdb->prefix . $this->db_tb_messages;    

        $savemsg        = $wpdb->insert( $table_name, 
        array( 
            'templateId'        => $data['template_id'], 
            'messageType'       => $data['msg_type'],
            'pageType'          => $data['page_display'],
            'messages'          => $data['msg_box'],
            'startDate'         => $data['start_date'],
            'endDate'           => $data['end_date'],
            'btnText'           => $data['btn_text'],
            'btnUrl'            => $data['btn_url'] 
            ) 
        );

        return $savemsg;

    }

    public function save_template_settings( $template_id, $data ) {

        global $wpdb;

        $table_template = $this->table_prefix . 'wcnd_templates';

        $template = $wpdb->get_results( 
        $wpdb->prepare("SELECT *  FROM {$table_template} WHERE templateID = '{$template_id}' ") 
         );

        if( empty( $template ) ) {

            $template = $wpdb->insert( $table_template, 
            array( 
                'customCSS'        => $data,
                'templateID'       => $template_id
                ) 
            );

        } else {

            $template = $wpdb->update( $table_template, 
            array( 
                'customCSS'        => $data, 
                'templateID'       => $template_id,
                'updated_at'        => current_time('mysql'),
            ), array('templateID' => $template_id ) );

        }

        return $template;

    }

    public function get_template_styles() { 

        global $wpdb;

        $table_template = $this->table_prefix . 'wcnd_templates';

        $template = $wpdb->get_results( 
            $wpdb->prepare("SELECT *  FROM {$table_template} ") 
         );

        return $template;

    }

    public function notification_messages() {

        global $wpdb;

        $messages = $wpdb->get_results( 
            $wpdb->prepare("SELECT *  FROM {$this->table_name} ORDER BY id DESC") 
         );

        return $messages; 

    }

    public function delete_row_message( $id ) {

        global $wpdb;
        
        $delete_msg = $wpdb->delete( $this->table_name, array( 'id' => $id ) );

        return $delete_msg;

    }

    public function get_message_details( $id ) {

        global $wpdb;

        $message = $wpdb->get_results( 
        $wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id={$id}") 
            );
        
        return $message;

    }

    public function get_start_date( $current_date) {

        global $wpdb;
        
        $date = $wpdb->get_results(
        $wpdb->prepare( "SELECT * FROM {$this->table_name} WHERE startDate >= {$current_date} AND endDate >= {$current_date} ORDER BY startDate ASC")
        );

        return $date;

    }


    public function update_row_message( $data = array() ) {

        global $wpdb;

        $update_msg = $wpdb->update( $this->table_name, 
        array( 
            'templateId'        => $data['template_id'], 
            'messageType'       => $data['msg_type'],
            'pageType'          => $data['page_display'],
            'messages'          => $data['msg_box'],
            'startDate'         => $data['start_date'],
            'endDate'           => $data['end_date'],
            'btnText'           => $data['btn_text'],
            'btnUrl'            => $data['btn_url'],
            'updated_at'        => current_time('mysql'),
        ), array('id' => $data['messageID']) );

        return $update_msg;

    }

}

new WebYardNotificationDisplayDatabase();