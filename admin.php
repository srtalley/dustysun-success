<?php

use \DustySun\WP_Settings_API\v2 as DSWPSettingsAPI;

class DustySun_Success_Admin {

    private $ds_success_settings_page;

    public function __construct() {
        add_action( 'admin_menu', array($this, 'ds_success_create_admin_page'));
        add_action( 'admin_menu', array($this, 'ds_success_admin_menu'));
    } // end function construct 


    // Add a theme options page
    public function ds_success_create_admin_page() {
        // set the settings api options
        $ds_api_settings = array(
            'json_file' => get_stylesheet_directory( __FILE__ ) . '/dustysun-success.json',
            'register_settings' => true,
            'views_dir' => plugin_dir_path( __FILE__ ) . '/admin/views'
        );
        //Create the settings object
        $this->ds_success_settings_page = new DSWPSettingsAPI\SettingsBuilder($ds_api_settings);

        //Get the current settings
        $this->ds_success_settings = $this->ds_success_settings_page->get_current_settings();

        //Get the plugin options
        $this->ds_success_main_settings = $this->ds_success_settings_page->get_main_settings();
    } //end function ds_success_create_admin_page
    // add_action( 'admin_menu', 'ds_success_create_admin_page');

    // Adds admin menu under the Sections section in the Dashboard
    public function ds_success_admin_menu() {
        $ds_success_plugin_hook = add_menu_page(
                __('Dusty Sun SUCCESS', 'ds_success'),
                __('Dusty Sun SUCCESS', 'ds_success'),
                'manage_options',
                'dustysun-success',
                array($this, 'ds_success_menu_callback'), 'dashicons-admin-generic');

                // add_submenu_page('urgency-coupons-mailing-lists', 'Configure Settings', 'Configure Settings', 'manage_options', 'urgency-coupons-mailing-lists');
    } //end public function ds_success_admin_menu()
    
    //Begin the admin menu
    public function ds_success_menu_callback() {
        // Create the main page HTML
        $this->ds_success_settings_page->build_settings_panel();
    } //end public function ds_success_menu_options()
}
