<?php
/*
 * WP License Agent Update Checker Plugin Update Checker Library 
 * 
 * Version 1.3.3
 * 
 * https://dustysun.com
 *
 * Copyright 2018 Dusty Sun
 * Released under the GPLv2 license.
 * Builds and extends plugin-update-checker libraries from Janis Elsts:
 * https://github.com/YahnisElsts/plugin-update-checker
 *
 * USAGE:
 * require this file in your plugin (and make sure the plugin-update-checker
 * directory is in the same directory as this file).
 *
 * Create a settings array with the following info:

   $settings = array(
     'update_url' => 'https://your-update-server.com/updates', // server address and wp-update-server path
     'update_slug' => your-plugin-slug, // needs to be the same as the update-slug on the server
     'main_file' => __FILE__, // server path to the main plugin file
     'license' => $license_key, // your plugin should allow the user to enter their license key. Retrieve that from your user settings and enter it here.
     'email' => $email_address, // your plugin should allow the user to enter their email address. Retrieve that from your user settings and enter it here.
     'development' => set to true or false. If you leave it off, it will be set to false. True and you will receive a development version of the plugin or theme update if defined. If the constant  is set to true in wp-config.php this will be used. 
   );

   finally, instantiate this object from your plugin:
   $update_checker = new WP_License_Agent_Update_Checker($settings);

 */

namespace DustySun\WP_License_Agent\Updater\v1_3;

require( dirname( __FILE__ ) . '/plugin-update-checker/plugin-update-checker.php');

if(!class_exists('DustySun\WP_License_Agent\Updater\v1_3\Licensing_Agent')) {
class Licensing_Agent {
  
  private $update_settings;
  private $update_url;
  private $checklicense_url;

  public function __construct($settings = null) {
    error_log('constructed');
    // set up the update settings 
    $this->set_update_settings($settings);

    // create the update checker
    $this->build_plugin_update_checker();

    if($this->update_settings['puc_errors']) {
      add_action( 'admin_notices', array($this, 'show_puc_admin_error') );
    }

    add_action( 'admin_print_scripts', array($this, 'print_update_checker_scripts'), 100, 10 );

    add_filter( 'puc_request_info_result-' . $this->update_settings['update_slug'], array($this, 'update_checker_info_result') );

    add_action( 'wp_ajax_dismissed_notice_handler',  array($this, 'ajax_notice_handler') );

    //allow the REST license check to be done via cron
    add_action('wp_ajax_retrieve_news-' . $this->update_settings['update_slug'] , array($this, 'retrieve_plugin_news_ajax_handler'));
      // add_action('wp-license-agent_daily_news_check', array($this, 'retrieve_plugin_news'));

    if(isset($this->update_settings['news_widget']) && $this->update_settings['news_widget']) {
      // add an activation hook that schedules a cron job to get news
      register_activation_hook($this->update_settings['main_file'], array($this, 'mluc_activation_hook'));

      // register the cron callback
      add_action($this->update_settings['update_slug'] . '_daily_news_check', array($this, 'retrieve_plugin_news'));

      // Register the new dashboard widget with the 'wp_dashboard_setup' action
      add_action('wp_dashboard_setup', array($this, 'add_dashboard_widgets') );
    }

    register_deactivation_hook($this->update_settings['main_file'], array($this, 'mluc_deactivation_hook'));

  } //end function __construct
  protected function wl ( $log )  {
      if(defined('WP_LICENSE_AGENT_DEBUG')) {       
        if ( true === WP_LICENSE_AGENT_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
      }
  } // end function wl

  public function set_update_settings ($settings) {


    // Do some error checking
    if($settings == null) {
      wp_die('You must pass a settings array to the WP License Agent plugin update checker. Please check the documentation.');
    } else if(!isset($settings['update_url']) || $settings['update_url'] == '') {
      wp_die('You must pass a valid update_url in the settings array when setting up the WP License Agent update checker. Please check the documentation.');
    } else if(!isset($settings['update_slug']) || $settings['update_slug'] == '') {
      wp_die('You must pass a valid update_slug in the settings array when setting up the WP License Agent update checker. Please check the documentation.');
    } else if(!isset($settings['main_file']) || $settings['main_file'] == '') {
      wp_die('You must pass a valid main_file to the name of the main plugin php file in the settings array when setting up the WP License Agent update checker. Please check the documentation. Usually you can just pass __FILE__ to the function.');
    } 
    // store the settings in the class variable
    $this->update_settings = array(
      'update_url' => $settings['update_url'],
      'update_slug' => $settings['update_slug'],
      'main_file' => $settings['main_file'],
      'license' => isset($settings['license']) && !empty($settings['license']) ? $settings['license'] : '',
      'email' => isset($settings['email']) && !empty($settings['email']) ? $settings['email'] : '',
      'news_widget' => isset($settings['news_widget']) && !empty($settings['news_widget']) ? $settings['news_widget'] : true,
      'puc_errors' => isset($settings['puc_errors']) && !empty($settings['puc_errors']) ? $settings['puc_errors'] : true,
    );

    // check if a development flag is set 
    if(defined('WP_LICENSE_AGENT_TEST_URL') && WP_LICENSE_AGENT_TEST_URL != 
    '') { 
      $this->update_settings['update_url'] = WP_LICENSE_AGENT_TEST_URL;
    }

  } // end function set_update_settings
  public function show_puc_admin_error() {
    $error_message = get_option($this->update_settings['update_slug'] . '_puc_error', true);

    if($error_message != '' && $error_message != null && $error_message != '1' && $error_message != 1) {
      // Check if it's been dismissed...
      $dismissed_values =  get_option( $this->update_settings['update_slug'] . '-' . get_current_user_id() . '-puc-update-error-msg', true );

      if(isset($dismissed_values['date_time']) && $dismissed_values['date_time'] != null) {
        // add a week to the time it was last dismissed so we can see if we should show it again
        date_add($dismissed_values['date_time'], date_interval_create_from_date_string('1 week'));
      } //end if(isset($dismissed_values['date_time']) && $dismissed_values['date_time'] != null)

      if ( !$dismissed_values['dismissed'] || $dismissed_values['date_time'] < new \DateTime()) {
        printf( '<div class="notice-mluc notice notice-error is-dismissible" data-notice="' . $this->update_settings['update_slug'] . '-' . get_current_user_id() . '-puc-update-error-msg"><p>' . $error_message . '</p></div>');
      } //end if ( !$dismissed_values['dismissed'] || $dismissed_values['date_time'] < new DateTime())
    } //end if($error_message != '' || $error_message != null)
  } //end functionshow_puc_admin_error

  public function update_checker_info_result($request) {
    if(isset($request->license_error)) {
      if($request->license_error) {
        update_option($this->update_settings['update_slug'] . '_puc_error', $request->license_error);
        add_action( 'admin_notices', array($this, 'show_puc_admin_error'));
      }
    } else {
      //clear any db error
      update_option($this->update_settings['update_slug'] . '_puc_error', '');
    }
    return $request;
  } // end function  update_checker_info_result

  protected function build_plugin_update_checker() {

    // see if development versions are selected 
    if(isset($this->update_settings['development']) && !empty($this->update_settings['development']) && is_bool($this->update_settings['development'])) {
      $development_versions = $this->update_settings['development'];
    } else if (defined('WP_LICENSE_AGENT_DEVELOPMENT_VERSIONS') ) {
      $development_versions = WP_LICENSE_AGENT_DEVELOPMENT_VERSIONS; 
    } else {
      $development_versions = false;
    } // end if 

    // build the update URL 
    $deprecated_update_url = $this->update_settings['update_url'] . '/wp-license-agent/?update_action=get_metadata&update_slug=' . $this->update_settings['update_slug'] . '&license=' . $this->update_settings['license'] . '&email=' . $this->update_settings['email'] . '&url=' . site_url() . '&development=' . $development_versions;

    $this->update_url = $this->update_settings['update_url'] . '/wp-json/wp-license-agent/v1/updateserver/?update_action=get_metadata&update_slug=' . $this->update_settings['update_slug'] . '&license=' . $this->update_settings['license'] . '&email=' . $this->update_settings['email'] . '&url=' . site_url() . '&development=' . $development_versions;

    $this->wl('This message shows because you have WP License Agent debug turned on - Update URL: ' . $this->update_url);

    $myUpdateChecker = \Puc_v4p4_Factory::buildUpdateChecker( 
      $this->update_url,
      $this->update_settings['main_file'],
      $this->update_settings['update_slug']
    );
  } // end function build_plugin_update_checker

  public function print_update_checker_scripts() {
    ?>
      <script type="text/javascript">
        jQuery(function($) {
        // Hook into the "notice-mluc" class we added to the notice, so
        // Only listen to YOUR notices being dismissed
        $( document ).on( 'click', '.notice-mluc .notice-dismiss', function () {
            // Read the "data-notice" information to track which notice
            // is being dismissed and send it via AJAX
            var type = $( this ).closest( '.notice-mluc' ).data( 'notice' );
            console.log(type);
            // Make an AJAX call
            // Since WP 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.ajax( ajaxurl,
              {
                type: 'POST',
                data: {
                  action: 'dismissed_notice_handler',
                  type: type,
                }
              } );
          } );
        });
      </script>
    <?php
  } //end function

  public function ajax_notice_handler() {

    // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)

    $type = $_POST['type'];

    $dismissed_values = array(
      'date_time' => new \DateTime(),
      'dismissed' => true,
    );
    // Store it in the options table
    update_option( $type, $dismissed_values );
  } //end function ajax_notice_handler

  // Function that outputs the contents of the dashboard widget
  public function dashboard_widget_function($post, $callback_args) {
    if($callback_args['args']->valid) {
      echo '<p><strong>License Status: </strong>  Active</p>';
      echo '<p><strong>Expires: </strong> ' . $callback_args['args']->expiration . '</p>';
    } else {
      echo '<p><strong>License Status: </strong>  None - you are not licensed</p>';
      if(isset($callback_args['args']->expiration)) {
        echo '<strong>License expired on ' . $callback_args['args']->expiration . ' - please update your license to continue to get support and updates!';
      }
    }
    if(isset($callback_args['args']->customer_message) && $callback_args['args']->customer_message != '' ) {
      echo '<hr>';
      echo $callback_args['args']->customer_message;
    }

    if(isset($callback_args['args']->license_message) && $callback_args['args']->license_message != '' ) {
      echo '<hr>';
      echo $callback_args['args']->license_message;
    }
  } // end function dashboard_widget_function

  // Function used in the action hook
  public function add_dashboard_widgets() {

    $data = get_option($this->update_settings['update_slug'] . '_daily_news_check', true);

    $plugin_name = get_plugin_data($this->update_settings['main_file'])['Name'];

    wp_add_dashboard_widget('dashboard_widget_' . $this->update_settings['update_slug'], $plugin_name . ' News', array($this,'dashboard_widget_function'), '', $data);
    
  } // end function add_dashboard_widgets

  public function mluc_activation_hook() {
    if (! wp_next_scheduled ( $this->update_settings['update_slug'] . '_daily_news_check' )) {
	     wp_schedule_event(time(), 'daily', $this->update_settings['update_slug'] . '_daily_news_check');
    }
  } // end function mluc_activation_hook

  public function mluc_deactivation_hook() {
    $timestamp = wp_next_scheduled ( $this->update_settings['update_slug'] . '_daily_news_check' );
    if ($timestamp) {
      wp_unschedule_event($timestamp, $this->update_settings['update_slug'] . '_daily_news_check');
    }
  } // end function mluc_deactivation_hook

  public function retrieve_plugin_news() {

    $this->checklicense_url = $this->update_settings['update_url'] . '/wp-json/wp-license-agent/v1/checklicense/?update_slug=' . $this->update_settings['update_slug'] . '&license=' . $this->update_settings['license'] . '&email=' . $this->update_settings['email'] . '&url=' . site_url();
    $request = wp_remote_get( $this->checklicense_url );

    if( is_wp_error( $request )) {
      return false;
    }
    $body = wp_remote_retrieve_body($request);

    $data = json_decode($body);

    update_option($this->update_settings['update_slug'] . '_daily_news_check', $data);
    update_option($this->update_settings['update_slug'] . '_license_validity', $data->valid);

    return($data);

  } // end function retrieve_plugin_news

  public function retrieve_plugin_news_ajax_handler() {
    if(isset($_POST['get_news']) && $_POST['get_news'] == true) {
      $json_output = array(
        'news_data' => $this->retrieve_plugin_news(),
        'update_url' => $this->update_url,
        'checklicense_url' => $this->checklicense_url
      );
      wp_send_json($json_output);
  		wp_die();
    }
  } //end function retrieve_plugin_news_ajax_handler
}} //end class
