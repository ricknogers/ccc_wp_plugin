<?php
/*
Plugin Name: CCC API
Plugin URI: http://www.starklmc.com
Description: Used to integrate ymca websites with CCC programs api
Version: 1.0
Author: Nick Rogers
Author Email: nick.rogers@starklmc.com
License:

  Copyright 2016 Nick Rogers ( nick.rogers@starklmc.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
ini_set('max_execution_time', -1);
ini_set('memory_limit', -1);

class CCCAPI {

    /*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
    const name = 'CCC API';
    const slug = 'ccc_api';

    /*--------------------------------------------*
	 * Properties
	 *--------------------------------------------*/
    private $options = array("access_token"=>"", "branches" => array() );
    
	private $branch_list = array("01" => array("name" => "Bradenton Branch YMCA", "code" => "010"), "02" => array("name" => "South Manatee County YMCA", "code" => "011"), "03" => array("name" => "Lakewood Ranch Branch YMCA", "code" => "012"), "07" => array("name" => "Parrish Branch YMCA", "code" => "016"));
	
	private $api_offset;

    private $custom_fields = array (
        array (
            'key' => 'field_5363b0009a0d7',
            'label' => 'ID',
            'name' => 'PGM_CODE',
            'type' => 'text',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b0779a0da',
            'label' => 'Session ID',
            'name' => 'SESSION',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b0c49a0db',
            'label' => 'Start Date',
            'name' => 'BEGIN_DATE',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b0f49a0dc',
            'label' => 'End Date',
            'name' => 'END_DATE',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b22e9a0e0',
            'label' => 'Start Time',
            'name' => 'START_TIME',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b2449a0e1',
            'label' => 'End Time',
            'name' => 'END_TIME',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b1079a0dd',
            'label' => 'Full Registration Start Date',
            'name' => 'REG_START1',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b1359a0de',
            'label' => 'Full Registration End Date',
            'name' => 'END_REG1',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_54ca60b55c3d8',
            'label' => 'Limited Registration Start Date',
            'name' => 'REG_START2',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_54ca60b55c4e8',
            'label' => 'Limited Registration End Date',
            'name' => 'END_REG2',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b2b09a0e4',
            'label' => 'Basic Registration Start Date',
            'name' => 'REG_START3',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b2d59a0e5',
            'label' => 'Basic Registration End Date',
            'name' => 'END_REG3',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3199a0e8',
            'label' => 'Special Registration Start Date',
            'name' => 'REG_START4',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3369a0e9',
            'label' => 'Special Registration End Date',
            'name' => 'END_REG4',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b25f9a0e2',
            'label' => 'Full Fee',
            'name' => 'FEE1',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b27f9a0e3',
            'label' => 'Limited Fee',
            'name' => 'FEE2',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3509a0ea',
            'label' => 'Basic Fee',
            'name' => 'FEE3',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3659a0eb',
            'label' => 'Special Fee',
            'name' => 'FEE4',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b2ef9a0e6',
            'label' => 'Starting Age',
            'name' => 'ageRangeFrom',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b2ff9a0e7',
            'label' => 'Ending Age',
            'name' => 'ageRangeTo',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3b59a0ed',
            'label' => 'Contact Email',
            'name' => 'FULL_EMAIL',
            'type' => 'email',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_53ce6d97eac82',
            'label' => 'Monday',
            'name' => 'DAYS_MON',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_53ce6dd6eac85',
            'label' => 'Tuesday',
            'name' => 'DAYS_TUE',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_53ce6dedeac86',
            'label' => 'Wednesday',
            'name' => 'DAYS_WED',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_53ce6dfceac87',
            'label' => 'Thursday',
            'name' => 'DAYS_THU',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_53ce6e14eac88',
            'label' => 'Friday',
            'name' => 'DAYS_FRI',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_53ce6e20eac89',
            'label' => 'Saturday',
            'name' => 'DAYS_SAT',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_53ce6e34eac8a',
            'label' => 'Sunday',
            'name' => 'DAYS_SUN',
            'type' => 'true_false',
            'message' => '',
            'default_value' => 0,
        ),
        array (
            'key' => 'field_5363bd4r9a0ef',
            'label' => 'Tags',
            'name' => 'SRCH_TAGS',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_54ca60975c4e7',
            'label' => 'Branch Name',
            'name' => 'branchName',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3f29a0ef',
            'label' => 'Program Link',
            'name' => 'programLink',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
        array (
            'key' => 'field_5363b3d59a0ee',
            'label' => 'Category Code',
            'name' => 'catCode',
            'type' => 'text',
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'none',
            'maxlength' => '',
        ),
    );

    /**
     * Constructor
     */
    function __construct() {
        //register an activation hook for the plugin
        register_activation_hook( __FILE__, array( &$this, 'install_ccc_api' ) );

        register_deactivation_hook(__FILE__, array( &$this, 'uninstall_ccc_api'));
        //Hook up to the init action
        add_action( 'init', array( &$this, 'init_ccc_api' ) );

        if ( is_admin() ) {
            add_action('admin_enqueue_scripts', array( &$this, 'admin_load_scripts') );

        }
    }

    /**
     * Runs when the plugin is activated
     */
    public function install_ccc_api() {
        // do not generate any output here
        add_option( self::slug .'_options', $this->options, '', "yes");
        add_option( self::slug . "_branches", array(), '', 'yes');
        add_option( self::slug .'_api_offset', array("value" => 0), '', "yes");
        add_filter( 'cron_schedules', array( &$this, 'add_cron_time') );
        wp_schedule_event( time(), 'threeMinute', self::slug.'_update_programs' );
        wp_schedule_event( time(), 'threeMinute', self::slug.'_clean_database' );
        $this-> register_cpt_program();
        $this-> create_custom_fields();
        $this-> register_taxonomy_branches();
        $this-> register_taxonomy_programs();
        flush_rewrite_rules();  
    }

    public function uninstall_ccc_api(){
        wp_clear_scheduled_hook(self::slug.'_update_programs');
        wp_clear_scheduled_hook(self::slug.'_clean_database');
        flush_rewrite_rules();  
        delete_option(self::slug . "_api_offset");
        delete_option(self::slug . "_options");
        delete_option(self::slug . "_branches");

    }

    /**
     * Runs when the plugin is initialized
     */
    public function init_ccc_api() {
        $this-> dependent_plugin_check();
        // Setup localization
        
        $this->options = get_option( self::slug.'_options' );
        $this-> get_api_offset();
        $this-> register_cpt_program();
        $this-> create_custom_fields();
        $this-> register_taxonomy_branches();
        $this->register_taxonomy_programs();


        add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );
        add_action(  self::slug.'_update_programs', array(&$this, "update_program_posts") );
        add_action(  self::slug.'_clean_database', array(&$this, "clean_database") );
        add_action( 'restrict_manage_posts', array(&$this, "add_filters_to_admin_programs_page") );
        add_filter( 'cron_schedules', array( &$this, 'add_cron_time') );


    }

    /**
     * Determines whether dependent plugins are active. If not this plugin will deactivate.
     *
     * @access public
     * @return void
     */
    public function dependent_plugin_check(){
        require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
        if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ){
            require_once ( WP_PLUGIN_DIR . '/advanced-custom-fields/acf.php' );
        }else{
            // deactivate dependent plugin
            deactivate_plugins( __FILE__);
            add_action( 'admin_notices', array( $this, 'activation_failure' ) );
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    }


    /**
     * Callback function for dependent_plugin_check. Sets message explaing why
     * this plugin was deactivated
     *
     * @access public
     * @return void
     */
    public function activation_failure(){
        echo '<div class="error"><p><strong>' . esc_html__( 'The CCC API Programs Plugin requires the Advances Custom Fields Plugin', 'my-plugin' ) . '</strong></p></div>';
    }

    /**
     * Registers and enqueues stylesheets for the administration panel and the
     * public facing site.
     */
    public function admin_load_scripts() {
        wp_enqueue_script("jquery");
        wp_enqueue_script("jquery-ui-tabs");
        wp_enqueue_script( 'custom-js',plugins_url( 'inc/custom.js', __FILE__ ), array(), '', true );
    } 

    /**
     * Creates Programs Post Type.
     *
     * @access public
     * @return void
     */
    public function register_cpt_program() {
        $labels = array(
            'name' => _x( 'Programs', 'program' ),
            'singular_name' => _x( 'Program', 'program' ),
            'add_new' => _x( 'Add New', 'program' ),
            'add_new_item' => _x( 'Add New Program', 'program' ),
            'edit_item' => _x( 'Edit Program', 'program' ),
            'new_item' => _x( 'New Program', 'program' ),
            'view_item' => _x( 'View Program', 'program' ),
            'search_items' => _x( 'Search Programs', 'program' ),
            'not_found' => _x( 'No programs found', 'program' ),
            'not_found_in_trash' => _x( 'No programs found in Trash', 'program' ),
            'parent_item_colon' => _x( 'Parent Program:', 'program' ),
            'menu_name' => _x( 'Programs', 'program' ),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,

            'supports' => array( 'title', 'editor', 'custom-fields', 'page-attributes' , "thumbnail"),
            'taxonomies' => array( 'category' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,


            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post'
        );

        register_post_type( 'program', $args );
    }

    /**
     * Creates Custom Fields for Programs Post type.
     *
     * @access public
     * @return void
     */
    public function create_custom_fields(){
        if(function_exists("register_field_group") &&  post_type_exists( "program" )){
            register_field_group(array (
                'id' => 'acf_ccc-programs-api-fields',
                'title' => 'CCC Programs API Fields',
                'fields' => $this-> custom_fields,
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'program',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                        0 => 'excerpt',
                        1 => 'custom_fields',
                        2 => 'discussion',
                        3 => 'comments',
                        4 => 'author',
                        5 => 'format',
                        6 => 'tags',
                    ),
                ),
                'menu_order' => 0,
            ));
        }
    }


    public function register_taxonomy_branches(){
        $labels = array(
            'name' => _x( 'Branches', 'branches' ),
            'singular_name' => _x( 'Branch', 'branches' ),
            'search_items' => _x( 'Search Branches', 'branches' ),
            'popular_items' => _x( 'Popular Branches', 'branches' ),
            'all_items' => _x( 'All Branches', 'branches' ),
            'parent_item' => _x( 'Parent Branch', 'branches' ),
            'parent_item_colon' => _x( 'Parent Branch:', 'branches' ),
            'edit_item' => _x( 'Edit Branch', 'branches' ),
            'update_item' => _x( 'Update Branch', 'branches' ),
            'add_new_item' => _x( 'Add New Branch', 'branches' ),
            'new_item_name' => _x( 'New Branch', 'branches' ),
            'separate_items_with_commas' => _x( 'Separate Branches with commas', 'branches' ),
            'add_or_remove_items' => _x( 'Add or remove Branches', 'branches' ),
            'choose_from_most_used' => _x( 'Choose from most used Branches', 'branches' ),
            'menu_name' => _x( 'Branches', 'branches' ),
        );
        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'rewrite' => false,
            'query_var' => true
        );
        $post_types = array("post", "page");
        if(post_type_exists( "program" )){
            array_push($post_types, "program");
        }
        register_taxonomy( 'branches', $post_types, $args );
    }    
	public function register_taxonomy_programs() {
	   $labels = array(
            'name' => _x( 'Programs', 'programs' ),
            'singular_name' => _x( 'Program', 'programs' ),
            'search_items' => _x( 'Search Programs', 'programs' ),
            'popular_items' => _x( 'Popular Programs', 'programs' ),
            'all_items' => _x( 'All Programs', 'programs' ),
            'parent_item' => _x( 'Parent Program', 'programs' ),
            'parent_item_colon' => _x( 'Parent Program:', 'programs' ),
            'edit_item' => _x( 'Edit Program', 'programs' ),
            'update_item' => _x( 'Update Program', 'programs' ),
            'add_new_item' => _x( 'Add New Program', 'programs' ),
            'new_item_name' => _x( 'New Program', 'programs' ),
            'separate_items_with_commas' => _x( 'Separate Programs with commas', 'programs' ),
            'add_or_remove_items' => _x( 'Add or remove Programs', 'programs' ),
            'choose_from_most_used' => _x( 'Choose from most used Programs', 'programs' ),
            'menu_name' => _x( 'CCC Categories', 'programs' ),
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'rewrite' => [
	            'slug' => 'programs',
	            
            ],
            'query_var' => true
        );
        $post_types = array("post", "page");
        if(post_type_exists( "program" )){
            array_push($post_types, "program");
        }
        register_taxonomy( 'programs', $post_types, $args );
        
    }

    /**
     * Adds CCC API Settings Page To Admin Menu.
     *
     * @access public
     * @return void
     */
    public function add_admin_menu() {
        add_options_page(
            self::name,
            self::name,
            'manage_options',
            self::slug,
            array( &$this, 'settings_page' )
        );
    }


    /**
     * Callback Function For add_admin_menu(). Checks For Admin Privilages And Retrives
     * Admin Setting's Page Template.
     *
     * @access public
     * @return void
     */
    public function  settings_page () {
        if( !current_user_can( 'manage_options' ) ) {

            wp_die( 'You do not have sufficient permissions to access this page.' );

        }
        if(isset($_POST[self::slug.'_form_delete'] ) ){
            $this-> clean_database();
        }

        if( isset($_POST[self::slug.'_form_save'] ) ) {

            $this->save_settings();

        }elseif( isset($_POST[self::slug.'_form_update']) ){
            if( $this->options['access_token'] && !empty($this->options['branches']) ){
	            
                $this-> set_options();
                if($_POST[ self::slug.'_no_branches'] == "N"){
                    $this-> update_program_posts();
                    //$this-> remote_get_branches();
                    $this-> set_options();
                }
            }
        }

        $this-> get_options();
        echo $this->api_offset;
        require( 'inc/options-page-wrapper.php' );
    }
    
    private function save_settings()
    {
        $this->options['access_token'] = sanitize_text_field($_POST[self::slug."_access_token"]);

        
        if( empty($this->options["branches"]) && $this->options['access_token']){
        
            $this->remote_get_branches();
            

        }elseif( isset($_POST[self::slug."_branches"]) ){
            $this->set_branches($_POST[self::slug."_branches"]);
        }else{

            $this->set_branches();
        }
        $this-> set_options();
        $this-> save_terms( "branches", $this->options["branches"] );
        $this-> delete_terms("branches", $this->options["branches"]);
    }
    

    public function query_posts_by_programs_id($program_id){
        $args = array(
            'post_type' => 'program',
            'posts_per_page' => -1,
            'meta_key'     => 'id',
            'meta_value'   => $program_id,
            'post_status' => 'any',
            'fields' => 'ids'
        );
        return new WP_Query( $args );

    }

    /**
     * wp_exist_post_by_title function.
     *
     * @access public
     * @param string $title
     * @return bool
     */
    public function exist_post_by_program_id( $program_id ) {
        $return = $this-> query_posts_by_programs_id($program_id);
        if( empty( $return->posts ) ) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * get_api_data function.
     *
     * @access public
     * @param strin $name
     * @param string $pass
     * @param int/string $assoc_id
     * @param string $query
     * @return void
     */
    public function get_api_data($query){
        
        $url = "https://manaweb.manateeymca.org/cgi-bin/ymweba.pl?TOKEN=".$this->options['access_token'].$query;
        
	    $args = array(
		    'timeout' => 60,
	    );
	    
	       
        $response = wp_remote_get( $url, $args );
//         var_dump($response);
        if(is_wp_error( $response ) ){
            return false;
        }
        
        if( $response['response']['code'] !== 200 ) {
            echo 'error '.$response['response']["message"];
        }else{
	    	$body = wp_remote_retrieve_body($response);
	    	
	    	if(strpos($body, 'could') === 0){
		    	return false;
	    	}
	    	
	    	$xml = new SimpleXMLElement($body);
			return $xml ;
	    	
        }
		
		return false;

    }

    public function set_branches($branches = null){
        if( !$branches ){
            foreach( $this->options['branches'] as $branch_code => $branch_name){
                $this->options['branches'][$branch_name]["active"] = 0;
            }
        }else{
            foreach( $this->options['branches'] as $branch_name => $branch_array){

                if( isset($branches[$branch_name] ) ){
                    $this->options['branches'][$branch_name]["active"] = 1;
                }else{
                    $this->options['branches'][$branch_name]["active"] = 0;
                }
                
            }
        }


    }

    private function remote_get_branches(){
        $branches = $this->get_api_data("&USEAPI=Y&PROCESS=BRLIST");
        
        
        foreach( $branches->BRANCH_LIST->BRANCH as $branch){
            if( !isset( $this->options['branches'][$branch["BRANCH_NAME"]] ) ){
	            
                $this->options['branches'][$branch["BRANCH_NAME"]] = array(
                    "id" => $branch["BRANCH_SEARCH_ID"],
                    "active" => 0,
                );
            }
            
        }
    }


    private function remote_get_program_tags(){
        $branches = $this->get_api_data("&USEAPI=Y&PROCESS=CATELIST");
        
        foreach( $branches["BRANCH_LIST"]["BRANCH"] as $branch){
            if( !isset( $this->options['branches'][$branch["BRANCH_NAME"]] ) ){
	            
                $this->options['branches'][$branch["BRANCH_NAME"]] = array(
                    "id" => $branch["BRANCH_SEARCH_ID"],
                    "active" => 0,
                );
            }
            
        }
    }

    public function update_program_posts()
    {
        
        $timeNow = new DateTime();
//         mail('andrew.shook@starklmc.com', 'manatee is importing programs', 'programs where imported at '.$timeNow->format('r'));
        
        $current_branches = get_terms(array(
	        'taxonomy' => 'branches',
	        'hide_empty' => false,
	        'fields' => 'all'
        ));       
        
        $current_branch = $current_branches[$this->api_offset];
		$program_terms = get_terms("programs", array("fields" => "all", "hide_empty" => false));
		
		foreach($program_terms as $term){
			$current_program_tags[$term->term_id] = $term;
		}
		
		
        $date = new Datetime();
      
   		//$programs = $this->get_api_data("&USEAPI=Y&PROCESS=SFYPGM&INDEX=0&VALUE=".$date->format('yM')."&RETURN=DETAIL&CURNLY=Y&BRANCH=".$current_branch->description);
	    
		$programs = $this->get_api_data("&VALUE=&INDEX=0&PROCESS=SFYPGM&RETURN=DETAIL&CURNLY=Y&USEAPI=Y&BRANCH1=".$current_branch->description);
		
		if($programs){	    
	        foreach($programs as $program){
				
		        // Check Description
	            if(!$program->DESC_2){
	                continue;
	           	}
	            
	            // Set post arguments
	            $my_post = array(
	                'post_title'    => $program->DESC_1,
	                'post_content'  => $program->DESC_2,
	                'post_status'   => 'publish',
	                'post_author'   => 1,
	                'post_type'   =>  'program'
	            );
	            
	            $existingProgram = $this->getProgramByPGM_CODE((string) $program->PGM_CODE); 
	           
	            if(!empty($existingProgram)){
		            $post_id = $existingProgram[0]->ID;
	            }else{
		           $post_id = wp_insert_post( $my_post ); 
	            }	                  
				
				$program_tags = !empty($program->SRCH_TAGS) ? explode(",",(string) $program->SRCH_TAGS) : [];
				$program_tag_ids = [];
				if(!empty($program_tags)){
					foreach($program_tags as $tag){
		                $formatedTag = preg_replace('!(([\s]+)|(\W))+!', "-", strtolower(htmlspecialchars_decode(trim($tag))));
		                
		                foreach($current_program_tags as $key => $value){
			           
			                if($formatedTag == $value->slug){
				               $program_tag_ids[] = intval($key);
				               
				               if($value->parent){
					               $program_tag_ids [] = $value->parent;
				               } 
			                }		                
		                }	                    
		               	
		            }
		            
				}
				
				
	            foreach($this->custom_fields as $field){
		        	$value = (string) $program->{$field["name"]};
		        			        					
					if($field['name'] === 'ageRangeFrom' || $field['name'] === 'ageRangeTo'){
						$age = 'N/A';
						$value = trim((string) $program-> AGE_CODE_D2);
					
						if(!empty($value)){
							$ages = explode('-', $value);
// 							echo var_dump($ages);echo '<br/>';
							if($field['name'] === 'ageRangeFrom' ){
								$age = $ages[0];
							}else{
								$age = $ages[1];
							}
						}						
												
	            		update_field( $field['key'], $age, $post_id );
					}					
					
		        	
		        	//INTERCEPT FIELDS AND FORMAT AS NEEDED.
		        	if( in_array( $field['name'], array("DAYS_MON", "DAYS_TUE", "DAYS_WED", "DAYS_THU", "DAYS_FRI", "DAYS_SAT", "DAYS_SUN") ) ){
			        	$day = false;
			        	if(!empty($value)){
	                        if($value == "Y"){
		                        $day = true;
	                        }
	                    }
						update_field( $field["key"], $day, $post_id );
                        continue; 
                    }
			        	
			        	
					// Format all date fields
	                if( in_array( $field['name'], array("BEGIN_DATE", "END_DATE", "REG_START1", "END_REG1", "REG_START2", "END_REG2", "REG_START3", "END_REG3", "REG_START4", "END_REG4") ) ){
		                $value = trim($value);
		                $time = NULL;
	                    if(!empty($value)){
                        	$time = DateTime::createFromFormat("ymd", trim($value))->format("Y-m-d");
                        }       
                        update_field( $field['key'], $time, $post_id );
                        continue;
                        
                    }
                    
                    // Format the Fees to dollar value
                    if( in_array( $field['name'], array("FEE1", "FEE2", "FEE3", "FEE4") ) ){
                        $fee = 0;
                        if(!empty($value)){
                        	$fee = intval($value)/100;
                        }
                        update_field( $field['key'], $fee.".00", $post_id );
                        continue;
                        
                    }
                    
                   
                                        
                    update_field( $field['key'], $value, $post_id );
                    
                                       	                	                
				}
	            
	             // Add branch to program
				wp_set_object_terms( $post_id, $current_branch->term_id, 'branches', false );
				
				if(empty($program_tag_ids)){
	                continue;
	            }
				
				// Add program tags to program
				wp_set_object_terms( $post_id, $program_tag_ids, 'programs', false );
				
				
				
				 												
										        		        	        		        	     
        	}
        	
        }
        		
		$offset = $this->api_offset;
		
		$offset ++;
		
		if($offset >= count($current_branches)){
			$offset = 0;
		}
		
		$this->set_api_offset($offset);					
	}
	
	private function getProgramByPGM_CODE($code)
	{
		$args = array(
			'post_type'  => 'program',
			'meta_query' => array(
				array(
					'key'     => 'PGM_CODE',
					'value'   => $code,
					'compare' => '=',
				),
			),
		);
		$query = new WP_Query( $args );
		
		return $query->posts;

	}
		
				
    public function register_cron_job(){
        $this->cron_job_init_class();
        
        if($this->options["access_token"]){
            $this-> update_program_posts();
        }
        
    }

    public function add_cron_time($schedules ){
        $schedules['threeMinute'] = array(
            'interval' => 180,
            'display' => __( 'Once Every 3 Minutes' )
        );
        return $schedules;
    }

    public function get_api_offset(){
        $offset_array = get_option(self::slug . "_api_offset");
        $this-> api_offset = $offset_array["value"];
    }
    private function inc_api_offset(){
        $offset = intval($this->api_offset);
        $this->set_api_offset( $offset += 1 );
    }
    public function set_api_offset($offset){
        
        update_option( self::slug.'_api_offset', array("value" => intval($offset) ) );
    }

    public function clean_database(){
	    
	    global $wpdb;
	    $timeNow = new DateTime();
//         mail('andrew.shook@starklmc.com', 'manatee is deleting programs', 'programs where deleted at '.$timeNow->format('r'));
	    
	    
	    $rawResults = $wpdb->get_results($wpdb->prepare('SELECT post_id FROM `wp_postmeta` WHERE `meta_key` = "END_DATE" AND `meta_value` < %s limit 200', $timeNow->format('Y-m-d')), ARRAY_N);
	    
	    if(empty($rawResults)){
		    echo("No More Old Programs");
	    }
	    
	    $results = array();
	    
	    foreach($rawResults as $result){
		    $results[]=$result[0];
	    }
	    //echo var_dump($results);
	    //die('Delete FROM `wp_postmeta` WHERE `post_id` in (' . implode(', ', $results ));
	    $wpdb->query('DELETE FROM `wp_postmeta` WHERE `post_id` in ('.implode(', ', $results ).')');
	    $wpdb->query('DELETE FROM `wp_posts` WHERE `ID` in ('.implode(', ', $results ).')');
	    

		
    }

    public function put_deletions($deleted){
        $url = "http://stark-api.com/api/v1/deletable";
        
        do_action("ccc_put_api_data", $deleted);
        
        $response = wp_remote_post( $url, array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(
                    'Authorization' =>
                    'Basic ' . base64_encode( $this-> options['access_token'] ),

                    'Accept' => 'application/json'
                ),

                'body' => array( 'deleted' => $deleted ),
                'cookies' => array()
            )
        );

    }

    public function save_terms($taxonomy, $options){
        foreach( $options as $term => $value){
            if( !term_exists($term, $taxonomy) && ($value["active"] == 1) ){
                wp_insert_term($term, $taxonomy, array(
                    "description" => $value["id"]
                ));
            }
        }
    }

    public function delete_terms($taxonomy, $options){

        $terms = get_terms($taxonomy, array("hide_empty"=>false) );
        $included = array();
        $excluded = array();

        foreach($terms as $term){
            if( isset($options[$term->name]) && ($options[$term->name]["active"] == 0) ){
                $excluded[] = $term->term_id;

            }else{
                $included[] = $term->term_id;
            }
        }

        if(!empty($excluded) ){
            $args = array(
                'post_type' => 'program',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $excluded
                    ),
                ),
                'fields' => 'ids'
            );

            if( !empty( $included ) ){
                $args['tax_query']['relation'] = "AND";
                $args['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $included,
                    'operator' => 'NOT IN',
                );
            }

            $query = new WP_Query( $args );

            $this-> delete_programs($query->posts);

            foreach($excluded as $term){

                wp_delete_term($term, $taxonomy);
            }
        }
    }


    public function delete_programs($old_program){
        $post_id = $old_program->posts[0];
        
        foreach($this-> custom_fields as $field){
            delete_post_meta($post_id, $field["name"]);
        }
        wp_delete_object_term_relationships( $post_id, array('programs', 'branches') );
        
        return wp_delete_post( $post_id, "true" );

    }
    public function set_options(){
        update_option( self::slug.'_options', $this->options );
    }

    public function get_options(){
        $this->options = get_option(self::slug . "_options");
        
    }
    
    private function cron_job_init_class(){
        $this->get_api_offset();
        $this->get_options();
    }
    
    public function add_filters_to_admin_programs_page(){
        // only display these taxonomy filters on desired custom post_type listings
        global $typenow;
        //echo $typenow;
        if ($typenow == 'program') {
    
            // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
                   $args = array('branches', 'programs');
                   foreach( $args as $taxonomy){ 
    			        $terms =  get_terms($taxonomy);
    			        $query = isset($_GET[$taxonomy])? $_GET[$taxonomy] : "";
    			        //die(var_dump($terms));
    		            // output html for taxonomy dropdown filter
    		            echo '<select name="'.strtolower($taxonomy).'" id="'.strtolower($taxonomy).'" class="postform">';
    		            echo "<option value=''>View All ". ucfirst($taxonomy)."</option>";
    		            foreach ($terms as $term) {
    		                // output each select option line, check against the last $_GET to show the current option selected
    		                echo '<option value='. $term->slug, $query == $term->slug ? ' selected="selected"' : '','>' . $term->name .'</option>';
    		            }
    		            echo "</select>";
    			   }
    	}
    }
    // END OF CLASS
} // end class
new CCCAPI();

function ccc_program_link(){
	global $post;
	$options =get_option("ccc_api_options");
	$terms = get_the_terms($post->ID, 'branches');
	//echo var_dump($terms);
	echo "https://manaweb.manateeymca.org/cgi-bin/ymweb.pl?DIRECTORY=\\dsk0\\". $terms[0]->description."025\\&HPGM=".get_field('SESSION').get_field('PGM_CODE') ."%20&VOS=PGM";
	
	
	
}

?>
<?php

/*
	            // Set the Branch
				$branchCode = substr($program->PGM_CODE, 0, 2);
				$catCode = substr($program->PGM_CODE, 2, 2);
				echo $program->PGM_CODE." : ".$catCode." | ";
				$program["catCode"] = $catCode;
				//$program["branchName"] = $this->branch_list[$branchCode]["name"];
				$program["programLink"] = "https://manaweb.manateeymca.org/cgi-bin/ymweb.pl?DIRECTORY=/dsk0/".$current_branch->term_id."025/&HPGM=".$program['SESSION'].$program['PGM_CODE']."&VOS=PGM";
	            $programBranch = preg_replace('!\s+!', '-', preg_replace('!( -)|[^ \w-]!', "", strtolower($program['branchName'])));
	            $branch_id = array_search($programBranch, $current_branches);
	            if(  $branch_id === false ){
	                continue;
	            }
	            // Set the ID
				$program["id"] = $program["PGM_CODE"];
				
				// Set the contact email | if empty array > convert to empty string
				if( empty($program->FULL_EMAIL) ){
					$program->FULL_EMAIL = "";
				}
				// Set the Age Range
				if( !empty($program -> AGE_CODE_D2) ){
					$ages = explode("-", $program-> AGE_CODE_D2);
	            	$program -> ageRangeFrom = $ages[0];
	            	$program->ageRangeTo = $ages[1];
				}
*/
	/*
$field['name']= 'AGE_CODE_D2'
$fieldName = $field['name'];
$program->AGE_CODE_D2 == $program->{$fieldName}
	            
*/            
	            // Check if the program already exists, if so Update, else Insert
/*
	            if( $this->exist_post_by_program_id($program['PGM_CODE']) ){
	                $post_id_array = $this-> query_posts_by_programs_id($program -> PGM_CODE);
					
	                $post_id = $post_id_array->posts[0];
	                $my_post["ID"] = $post_id;
	                $my_post['edit_date'] = true;
	                wp_update_post($my_post);
	            }else{
	                // Insert the post into the database
	                $post_id = wp_insert_post( $my_post );
	            }
				
				// Set Branch Category/Taxonomy
	            wp_set_object_terms($post_id, intval($branch_id), 'branches');
	            
				// For each Program, Update all custom field values
	            foreach($this-> custom_fields as $field){
	                if(isset($program[$field->name])){
		                
		            	// Format all date fields
	                    elseif( in_array( $field['name'], array("BEGIN_DATE", "END_DATE", "REG_START1", "END_REG1", "REG_START2", "END_REG2", "REG_START3", "END_REG3", "REG_START4", "END_REG4") ) ){		
		                    if(!is_array($program[$field["name"]])){
	                        	$time = DateTime::createFromFormat("ymd", $program[$field['name']]);
	                        }       
	                        update_field( $field->key, $time->format("Y-m-d"), $post_id );
	                        continue;
	                        
	                    }// Format the Fees to dollar value
	                    elseif( in_array( $field->name, array("FEE1", "FEE2", "FEE3", "FEE4") ) ){
	                        $tempfee = intval($program[$field->name]);
	                        $tempfee = $tempfee/100;
	                        $tempfee = (string)$tempfee;
	                        update_field( $field->key, $tempfee, $post_id );
	                        continue;
	                        
	                    }// type cast the DAYS fields
	                    elseif( in_array( $field->name, array("DAYS_MON", "DAYS_TUE", "DAYS_WED", "DAYS_THU", "DAYS_FRI", "DAYS_SAT", "DAYS_SUN") ) ){
	                        if($program[$field->name] == "Y"){
		                        $day = true;
	                        }else{
		                        $day = false;
	                        }
	                        update_field( $field->key, $day, $post_id );
	                        continue;
	                        
	                    }// Update all other fields
	                    else{
		                    if(is_array($program[$field->name]) ){
			                    $program[$field->name] = "";
		                    }
	                    	update_field( $field->key, $program[$field->name], $post_id );
	                    }
	                }
	            }
*/
?>
