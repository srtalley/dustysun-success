<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//Include the admin panel page
require_once( dirname( __FILE__ ) . '/admin.php');
//Include the Dusty Sun settings api
require_once( dirname( __FILE__ ) . '/lib/dustysun-wp-settings-api/ds_wp_settings_api.php');

/* Add the child theme JS and CSS */

add_action( 'wp_enqueue_scripts', 'dst_enqueue_scripts' );
function dst_enqueue_scripts() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
  wp_enqueue_script( 'ds-main', get_stylesheet_directory_uri() . '/js/main.js', '', '', true );
}

////////////////////////////////////////////////////
// CHILD THEME INSTALLATION OPTIONS
////////////////////////////////////////////////////

// One click theme import activation
require_once get_stylesheet_directory() . '/auto-install/class-tgm-plugin-activation.php';
require_once get_stylesheet_directory() . '/lib/ds_divi_theme_options_import.php';
add_action( 'tgmpa_register', 'success_divi_ds_register_required_plugins' );

// Register the required plugins for this theme
function success_divi_ds_register_required_plugins() {
    $plugins = array( // Include the One Click Demo Import plugin from the WordPress repo
        array(
            'name' => 'One Click Demo Import',
            'slug' => 'one-click-demo-import',
            'required' => true,
        ) ,
    );
    $config = array(
        'id'           => 'success_divi_ds',       // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                    // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa($plugins, $config);
} // end function success_divi_ds_register_required_plugins

// Import all the files
function ocdi_import_files() {
  $update_url = 'https://dustysun.com/support/updates/themes/success/auto-install/';
    return array(
        array(
            'import_file_name' => 'SUCCESS Child Theme Import',
            'import_file_url' => $update_url . 'content-success.xml',
            'import_widget_file_url' => $update_url . 'widgets-success.wie',
            'import_customizer_file_url' => $update_url . 'customizer-success.dat',
            'import_preview_image_url' => $update_url . 'screenshot-success.jpg',
            'import_notice' => __( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'your_theme_name' ),
        ),
    );
} // end function ocdi_import_files
add_filter('pt-ocdi/import_files', 'ocdi_import_files');

// Reset the standard WordPress widgets
function ocdi_before_widgets_import($selected_import) {
    if (!get_option('acme_cleared_widgets')) {
        update_option('sidebars_widgets', array());
        update_option('acme_cleared_widgets', true);
    }
} // end function ocdi_before_widgets_import
add_action('pt-ocdi/before_widgets_import', 'ocdi_before_widgets_import');

function ocdi_after_import_setup() {
    $main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
    // $secondary_menu = get_term_by( 'name', 'Secondary Menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
      'primary-menu' => $main_menu->term_id,
      // 'secondary-menu' => $secondary_menu->term_id,
      )
    );
        // Assign home page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

    //run our Divi theme options import
    $imported_divi_options = new DS_Divi_Import('https://www.dustysun.com/support/updates/themes/success/auto-install/divi-success.json');
} // end function ocdi_after_import_setup
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );

// Disable plugin branding
add_filter('pt-ocdi/disable_pt_branding', '__return_true');

////////////////////////////////////////////////////
// CHILD THEME CUSTOMIZER OPTIONS
////////////////////////////////////////////////////
require_once('includes/theme_customizer.php');

////////////////////////////////////////////////////
// THEME UPDATER
////////////////////////////////////////////////////
use \DustySun\WP_License_Agent\Client\v1_5 as WPLA;
//Add update checker
require_once( dirname( __FILE__ ) . '/lib/wp-license-agent-client/wp-license-agent.php');
function ds_wpla_build_update_checker() {

    $settings = array(
      'update_url' => 'https://dustysun.com',
      'update_slug' => 'dustysun-success',
      'main_file' => __FILE__,
      'news_widget' => true,
      'puc_errors' => true
    );
   
    $update_checker = new WPLA\Licensing_Agent($settings);
} // end function ds_wpla_build_update_checker
add_action('after_setup_theme', 'ds_wpla_build_update_checker');


if(is_admin()) {
    $ds_success_admin_page = new DustySun_Success_Admin();
}