<?php
/**
* Contains methods for customizing the theme customization screen.
*
* @link http://codex.wordpress.org/Theme_Customization_API
* @since SUCCESS Child Theme 1.0
*/
class DustySunTheme_Customize {
  /**
  * This hooks into 'customize_register' (available as of WP 3.4) and allows
  * you to add new sections and controls to the Theme Customize screen.
  *
  * Note: To enable instant preview, we have to actually write a bit of custom
  * javascript. See live_preview() for more.
  *
  * @see add_action('customize_register',$func)
  * @param \WP_Customize_Manager $wp_customize
  * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
  * @since MyTheme 1.0
  */
  public static function dst_register ( $wp_customize ) {
    /* ========================================================== */
    //    MAIN PANEL
    /* ========================================================== */

    $wp_customize->add_panel( 'dst_child_theme_customizations_option', array(
      'priority' => 1,
      'capability' => 'edit_theme_options',
      'title' => __('SUCCESS Custom Options', 'dst_child_theme'),
    ));

    /* ========================================================== */
    //  Link Hover Settings //
    /* ========================================================== */

    $wp_customize->add_section('dst_link_hover_options', array(
      'priority' => 8,
      'title' => __('Link Hover Colors', 'dst_child_theme'),
      'panel' => 'dst_child_theme_customizations_option',
      // 'description' => __('Customize general settings.', 'dst_child_theme'),
    ));

    //General Link Hover Color
    $wp_customize->add_setting( 'dst_general_href_hover_color', array(
      'default'		=> et_get_option( 'accent_color', '#000' ),
      'transport' => 'postMessage',
      'sanitize_callback' => 'et_sanitize_alpha_color',
    ) );

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'dst_general_href_hover_color', array(
      'label'		=> esc_html__( 'Body Link Hover Color', 'Divi' ),
      // 'description' => 'Dusty Sun Child Theme Option',
      'section'	=> 'dst_link_hover_options',
      'priority' => 5,
      'settings'	=> 'dst_general_href_hover_color',
    ) ) );

    //Footer Link Hover Color
    $wp_customize->add_setting( 'dst_footer_href_hover_color', array(
      'default'		=> et_get_option( 'bottom_bar_text_color', '#666666' ),
      'transport' => 'postMessage',
      'sanitize_callback' => 'et_sanitize_alpha_color',
    ) );

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'dst_footer_href_hover_color', array(
      'label'		=> esc_html__( 'Footer Link Hover Color', 'Divi' ),
      // 'description' => 'Dusty Sun Child Theme Option',
      'section'	=> 'dst_link_hover_options',
      'priority' => 10,
      'settings'	=> 'dst_footer_href_hover_color',
    ) ) );

    /* ========================================================== */
    //  Menu Settings //
    /* ========================================================== */

    $wp_customize->add_section('dst_menu_options', array(
      'priority' => 10,
      'title' => __('Menu Options', 'dst_child_theme'),
      'panel' => 'dst_child_theme_customizations_option',
      // 'description' => __('Customize general settings.', 'dst_child_theme'),
    ));
    //  MENU HIGHLIGHTING WITH CHILD ITEMS //
    // Allow entire menu highlight with children items on or off
    $wp_customize->add_setting('dst_entire_menu_highlight_status', array(
      'default' => 'highlight_off',
    ));

    $wp_customize->add_control('dst_entire_menu_highlight_status', array(
      'label' => __('Highlight parent menu item when there is a child menu', 'dst_child_theme'),
      // 'description' => 'Dusty Sun Child Theme Option',
      'section' => 'dst_menu_options',
      'type' => 'radio',
      'priority' => 10,
      'settings' => 'dst_entire_menu_highlight_status',
      'choices' => array(
        'highlight_off' => 'Off',
        'highlight_on' => 'On',
      ),
    ));

    // Allow submenus to have an auto width
    $wp_customize->add_setting('dst_submenu_auto_width', array(
      'default' => 'autowidth_off',
    ));

    $wp_customize->add_control('dst_submenu_auto_width', array(
      'label' => __('Make submenus as wide as each entry item', 'dst_child_theme'),
      // 'description' => 'Dusty Sun Child Theme Option',
      'section' => 'dst_menu_options',
      'type' => 'radio',
      'priority' => 15,
      'settings' => 'dst_submenu_auto_width',
      'choices' => array(
        'autowidth_off' => 'Off',
        'autowidth_on' => 'On',
      ),
    ));

    // Allow submenus to have an auto width
    $wp_customize->add_setting('dst_submenu_background_hover_color', array(
      'default'		=> 'rgba(0,0,0,.3)',
      'transport' => 'postMessage',
      'sanitize_callback' => 'et_sanitize_alpha_color',
    ));

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'dst_submenu_background_hover_color', array(
      'label'		=> esc_html__( 'Submenu Hover Background Color', 'Divi' ),
      'section'	=> 'dst_menu_options',
      'priority' => 25,
      'settings'	=> 'dst_submenu_background_hover_color',
    ) ) );
    /* ========================================================== */
    //  SLIDERS
    /* ========================================================== */
    // add section to panel
    $wp_customize->add_section('dst_sliders_section', array(
      'priority' => 40,
      'title' => __('Slider Options', 'dst_child_theme'),
      'panel' => 'dst_child_theme_customizations_option',
      'description' => __('Set defaults for sliders.', 'dst_child_theme'),
    ));

    //Active slider dot color
    $wp_customize->add_setting( 'dst_slider_dot_active_color', array(
      'default'		=> et_get_option( 'accent_color', '#000' ),
      'transport' => 'postMessage',
      'sanitize_callback' => 'et_sanitize_alpha_color',
    ) );

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'dst_slider_dot_active_color', array(
      'label'		=> esc_html__( 'Active Slider Dot Color', 'Divi' ),
      'section'	=> 'dst_sliders_section',
      'priority' => 25,
      'settings'	=> 'dst_slider_dot_active_color',
    ) ) );

    //Inactive slider dot color
    $wp_customize->add_setting( 'dst_slider_dot_inactive_color', array(
      'default'		=> 'rgba(0,0,0,.3)',
      'transport' => 'postMessage',
      'sanitize_callback' => 'et_sanitize_alpha_color',
    ) );

    $wp_customize->add_control( new ET_Divi_Customize_Color_Alpha_Control( $wp_customize, 'dst_slider_dot_inactive_color', array(
      'label'		=> esc_html__( 'Inactive Slider Dot Color', 'Divi' ),
      'section'	=> 'dst_sliders_section',
      'priority' => 30,
      'settings'	=> 'dst_slider_dot_inactive_color',
    ) ) );

    /* ========================================================== */
    //  BLOG PANEL   //
    /* ========================================================== */
    // add section to panel
    $wp_customize->add_section('dst_blog_section', array(
      'priority' => 5,
      'title' => __('Blog Options', 'dst_child_theme'),
      'panel' => 'dst_child_theme_customizations_option',
      'description' => __('If you want to change the appearance of all Divi blog modules, use the settings below.', 'dst_child_theme'),
    ));

    // Blog Appearance
    $wp_customize->add_setting('dst_blog_appearance', array(
      'default' => 'no_change',
    ));

    $wp_customize->add_control('dst_blog_appearance', array(
      'label' => __('Blog Appearance', 'dst_child_theme'),
      'description' => 'Change the layout of the default Divi Blog Module',
      'section' => 'dst_blog_section',
      'type' => 'radio',
      'priority' => 10,
      'settings' => 'dst_blog_appearance',
      'choices' => array(
        'no_change' => 'Default Layout',
        'pic_left' => 'Smaller Picture on Left',
      ),
    ));
  } //end public static function dst_register

  /**
  * This will output the custom WordPress settings to the live theme's WP head.
  *
  * Used by hook: 'wp_head'
  *
  * @see add_action('wp_head',$func)
  * @since DustySunTheme 1.0
  */
  public static function dst_header_output() {

    //These options are needed to apply default styles to buttons
    $accent_color = et_get_option( 'accent_color', '#2ea3f2' );
    $button_text_size = absint( et_get_option( 'all_buttons_font_size', '20' ) );
    $button_text_color = et_get_option( 'all_buttons_text_color', '#ffffff' );
    $button_bg_color = et_get_option( 'all_buttons_bg_color', 'rgba(0,0,0,0)' );
    $button_border_width = absint( et_get_option( 'all_buttons_border_width', '2' ) );
    $button_border_color = et_get_option( 'all_buttons_border_color', '#ffffff' );
    $button_border_radius = absint( et_get_option( 'all_buttons_border_radius', '3' ) );
    $button_text_style = et_get_option( 'all_buttons_font_style', '', '', true );
    $button_icon = et_get_option( 'all_buttons_selected_icon', '5' );
    $button_spacing = intval( et_get_option( 'all_buttons_spacing', '0' ) );
    $button_icon_color = et_get_option( 'all_buttons_icon_color', '#ffffff' );
    $button_text_color_hover = et_get_option( 'all_buttons_text_color_hover', '#ffffff' );
    $button_bg_color_hover = et_get_option( 'all_buttons_bg_color_hover', 'rgba(255,255,255,0.2)' );
    $button_border_color_hover = et_get_option( 'all_buttons_border_color_hover', 'rgba(0,0,0,0)' );
    $button_border_radius_hover = absint( et_get_option( 'all_buttons_border_radius_hover', '3' ) );
    $button_spacing_hover = intval( et_get_option( 'all_buttons_spacing_hover', '0' ) );
    $button_icon_size = 1.6 * intval( $button_text_size );
    ?>
    <!--Customizer CSS-->
    <style type="text/css">

    <?php self::generate_css('a:hover', 'color', 'dst_general_href_hover_color'); ?>
    <?php self::generate_css('#footer-info a:hover', 'color', 'dst_footer_href_hover_color'); ?>
    <?php self::generate_css('body .et-pb-controllers a', 'background-color', 'dst_slider_dot_inactive_color'); ?>
    <?php self::generate_css('body .et-pb-controllers a.et-pb-active-control', 'background-color', 'dst_slider_dot_active_color', '', '!important'); ?>
    <?php self::generate_css('#main-footer', 'background-image', 'dst_footer_background_img', 'url(\'', '\')' ); ?>
    <?php self::generate_css('.woocommerce span.onsale, .woocommerce-page span.onsale', 'background', 'dst_woo_commerce_sale_color', '#'); ?>

    <?php self::generate_css('.et_mobile_menu li a:hover, .nav ul li a:hover', 'background-color', 'dst_submenu_background_hover_color'); ?>

    <?php self::generate_css('.et_mobile_menu li a:hover, .nav ul li a:hover', 'opacity', '1'); ?>
    /* ================================================= */
    /*  SUBMT BUTTONS                                    */
    /* ================================================= */
    /* Custom styles for buttons */
    input[type="submit"], button{
      color: <?php echo esc_html( $accent_color ); ?>;
      color: <?php echo esc_html( $button_text_color ); ?>;
      position: relative;
      padding: 0.2em 1em;
      border: 2px solid;
      line-height: 1.7em !important;
      -webkit-transition: all 0.2s;
      -moz-transition: all 0.2s;
      transition: all 0.2s;
      <?php if ( 20 !== $button_text_size ) { ?> font-size: <?php echo esc_html( $button_text_size ); ?>px; <?php } ?>
      <?php if ( 'rgba(0,0,0,0)' !== $button_bg_color ) { ?> background: <?php echo esc_html( $button_bg_color ); ?>; <?php } ?>
      <?php if ( 2 !== $button_border_width ) { ?> border-width: <?php echo esc_html( $button_border_width ); ?>px !important; <?php } ?>
      <?php if ( '#ffffff' !== $button_border_color ) { ?> border-color: <?php echo esc_html( $button_border_color ); ?>; <?php } ?>
      <?php if ( 3 !== $button_border_radius ) { ?> border-radius: <?php echo esc_html( $button_border_radius ); ?>px; <?php } ?>
      <?php if ( '' !== $button_text_style ) { ?> <?php echo esc_html( et_pb_print_font_style( $button_text_style ) ); ?>; <?php } ?>
      <?php if ( 0 !== $button_spacing ) { ?> letter-spacing: <?php echo esc_html( $button_spacing ); ?>px; <?php } ?>
    }

    input[type="submit"]:hover {
      <?php if ( '#ffffff' !== $button_text_color_hover ) { ?> color: <?php echo esc_html( $button_text_color_hover ); ?> !important; <?php } ?>
      <?php if ( 'rgba(255,255,255,0.2)' !== $button_bg_color_hover ) { ?> background: <?php echo esc_html( $button_bg_color_hover ); ?> !important; <?php } ?>
      <?php if ( 'rgba(0,0,0,0)' !== $button_border_color_hover ) { ?> border-color: <?php echo esc_html( $button_border_color_hover ); ?> !important; <?php } ?>
      <?php if ( 3 !== $button_border_radius_hover ) { ?> border-radius: <?php echo esc_html( $button_border_radius_hover ); ?>px; <?php } ?>
      <?php if ( 0 !== $button_spacing_hover ) { ?> letter-spacing: <?php echo esc_html( $button_spacing_hover ); ?>px; <?php } ?>
    }

    /* ================================================= */
    /*  INPUTS                                           */
    /* ================================================= */
    input.text:focus, input.title:focus, input[type=text]:focus, select:focus, textarea:focus {
      border-color: <?php echo $accent_color; ?> !important;
    }
    /* ================================================= */
    /*  WOOCOMMERCE                                      */
    /* ================================================= */
    .woocommerce-product-search input[type="search"]:focus, .woocommerce-product-search input[type="search"]:active {
      border-color: <?php echo $accent_color; ?>;
    }

    /* ================================================= */
    /*  FOOTER LINKS                                     */
    /* ================================================= */
    #footer-info a:hover {
      opacity: 1;
    }

    <?php
    $dst_blog_appearance = get_theme_mod('dst_blog_appearance', '');
    if($dst_blog_appearance == 'pic_left'): ?>

    /* =================================================
    BLOG APPEARANCE
    Smaller picture on left
    ================================================= */
    .et_pb_posts .et_pb_post {
      overflow: hidden;
    }
    .et_pb_posts .et_pb_post .entry-featured-image-url {
      display:block;
      /*float:left;*/
      position: absolute;
      height: 100%;
    }
    .et_pb_posts .et_pb_post a img {
      max-width: 360px;
      width: 100%;
      height: 100%;
      object-fit: cover;
      float:none;
    }
    .et_pb_posts .et_pb_post p.post-meta {
      font-size: 0.7em;
    }
    .et_pb_posts .et_pb_post h2.entry-title {
      display: block;
      float:right;
      width: calc(100% - 380px);
      margin-left: 380px;
      padding-left:0;
    }
    .et_pb_posts .et_pb_post .post-content,
    .et_pb_posts .et_pb_post p.post-meta {
      width: calc(100% - 380px);
      margin-left: 380px;
      display: block;
      float:right;
      padding-left: 5px;
      line-height: 1.8em;
    }
    .et_pb_posts .et_pb_post .post-content p {
      /*font-size: 0.8em;*/
    }
    .et_pb_posts .entry-title {
      padding: 5px 20px 0;
    }
    .et_pb_posts h2.entry-title {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 1.5em;
      margin-top: 0;
    }


    @media only screen and ( max-width:1200px ) {
      .et_pb_posts .et_pb_post a img {
        max-width: 230px;
        max-height: 230px;
      }
      .et_pb_posts .et_pb_post h2.entry-title,
      .et_pb_posts .et_pb_post .post-content,
      .et_pb_posts .et_pb_post p.post-meta {
        width: calc(100% - 250px);
        margin-left: 250px;
      }

    } /* end media only 1200 */

    @media only screen and ( max-width:767px ) {
      .et_pb_posts .et_pb_post h2.entry-title,
      .et_pb_posts .et_pb_post .post-content,
      .et_pb_posts .et_pb_post p.post-meta {
        width:50%;
        padding-left: 20px;
      }
      .et_pb_posts .et_pb_post .entry-featured-image-url {
        width: 50%;
      }
      .et_pb_posts .et_pb_post a img {
        width:100%;
        max-width: 100%;
      }
    } /* end media screen 767 */

    @media only screen and ( max-width:525px ) {
      .et_pb_posts .et_pb_post h2.entry-title,
      .et_pb_posts .et_pb_post .post-content,
      .et_pb_posts .et_pb_post p.post-meta {
        margin-left: 0;
        padding-left: 0;
        float:none;
        width:100%;
      }
      .et_pb_posts .et_pb_post .entry-featured-image-url {
        float:none;
        width:100%;
        position: relative;
      }

      .et_pb_posts .entry-title {
        padding-top: 10px;
      }
    }/* end media screen 525px */
    <?php
    endif; // end if($dst_blog_appearance == 'pic_left'): ?>

    <?php
    $entire_menu_highlight_status = get_theme_mod('dst_entire_menu_highlight_status', '');
    if($entire_menu_highlight_status == 'highlight_on'):

      $menu_height = absint( et_get_option( 'menu_height', '66' ) );
      $fixed_menu_height = absint( et_get_option( 'minimized_menu_height', '40' ) );
      $primary_nav_bg = et_get_option( 'primary_nav_bg', '#ffffff' );
      $primary_nav_dropdown_bg = et_get_option( 'primary_nav_dropdown_bg', $primary_nav_bg );
      $primary_nav_dropdown_link_color = et_get_option( 'primary_nav_dropdown_link_color', '#FFF' );
      ?>

      /* ================================================= */
      /*  MENU HIGHLIGHTING WITH CHILDREN                  */
      /* ================================================= */
      @media only screen and (min-width: 981px) {

        /* Allow the entire menu to be highlighted */
        #top-menu-nav #top-menu > li {
          padding-top: <?php echo esc_html( round ( $menu_height / 2 ) ); ?>px;
          transition: padding 0.4s ease-in-out;
        }

        .et-fixed-header #top-menu-nav #top-menu > li {
          padding-top: <?php echo esc_html( round ( $fixed_menu_height / 2 ) ); ?>px;
        }

        #top-menu>li, #top-menu>li:last-child { padding-left: 11px; padding-right: 11px; }
        #top-menu>li:first-of-type { padding-left: 0; }

        #et_top_search {
          margin-top:  <?php echo esc_html( round ( $menu_height / 2 ) ); ?>px;
          width: 0;
          transition: 0.4s ease-in-out;
        }
        .et-fixed-header #et_top_search {
          margin-top:  <?php echo esc_html( round ( $fixed_menu_height / 2 ) ); ?>px;
        }
        #top-menu li ul.sub-menu { left: 0; }

        body.et_header_style_left #et-top-navigation, body.et_header_style_split #et-top-navigation, body.et_header_style_left .et-fixed-header #et-top-navigation, body.et_header_style_split .et-fixed-header #et-top-navigation {
          padding-top: 0;
        }

        #top-menu-nav #top-menu > li.menu-item-has-children:hover {
          background-color: <?php echo esc_html( $primary_nav_dropdown_bg ); ?>;
        }
        #top-menu-nav #top-menu > li.menu-item-has-children:hover a {
          color: <?php echo esc_html( $primary_nav_dropdown_link_color ); ?>;
        }

        /* Fix for divi not having a submenu drop down color on fixed headers */
        .et-fixed-header #top-menu-nav #top-menu > li.menu-item-has-children ul li a, .et-fixed-header #top-menu-nav #top-menu li.menu-item-has-children:hover a {
          color: <?php echo esc_html( $primary_nav_dropdown_link_color ); ?> !important;
        }
      } /* end media min width 981 px */
      <?php endif; //if($entire_menu_highlight_status == 'highlight_on') ?>

      <?php
      $entire_menu_highlight_status = get_theme_mod('dst_submenu_auto_width', '');
      if($entire_menu_highlight_status == 'autowidth_on'):
        ?>
        /* ================================================= */
        /*  SUBMENU AUTO WIDTH               */
        /* ================================================= */


        @media only screen and (min-width: 981px) {
          #top-menu li ul.sub-menu {
            width: auto;
          }
          #top-menu ul.sub-menu li {
            padding: 0 12px;
          }
          #top-menu li li a {
            padding-left: 15px;
            padding-right: 15px;
            white-space: nowrap;
          }
          #top-menu ul.sub-menu li,
          #top-menu ul.sub-menu li a {
            width: 100%;
          }
        }/* end media min width 981 px */
        <?php endif; //if($entire_menu_highlight_status == 'highlight_on') ?>

      </style>
      <!--/Customizer CSS-->
    <?php
    $dst_blog_appearance = get_theme_mod('dst_blog_appearance', '');
    if($dst_blog_appearance == 'pic_left'): ?>
      <!--Customizer JS-->
      <script type="text/javascript">
        /* =================================================
        BLOG APPEARANCE
        Smaller picture on left
        Fixes for IE 11 not supporting object fit
        ================================================= */
        jQuery(function($) {
          $(document).ready(function() {
            if('objectFit' in document.documentElement.style === false) {
            //see if this is a blog page where we are applying our custom function
            var blog_img_left = $('.et_pb_posts .et_pb_post a img');
            if(blog_img_left.length > 0){
                // assign HTMLCollection with parents of images with objectFit to variable
                blog_img_left.each(function() {
                  $(this).css('height', 'auto');
                });
              } //end if(blog_img_left.length)
            } //end if('objectFit' in document.documentElement.style === false)
          });
        });
      </script>
      <?php
    endif; // end if($dst_blog_appearance == 'pic_left'): ?>
    <?php
  }

  /**
  * This outputs the javascript needed to automate the live settings preview.
  * Also keep in mind that this function isn't necessary unless your settings
  * are using 'transport'=>'postMessage' instead of the default 'transport'
  * => 'refresh'
  *
  * Used by hook: 'customize_preview_init'
  *
  * @see add_action('customize_preview_init',$func)
  * @since MyTheme 1.0
  */
  public static function dst_live_preview() {
    wp_enqueue_script(
      'mytheme-themecustomizer', // Give the script a unique ID
      get_stylesheet_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
      array(  'jquery', 'customize-preview' ), // Define dependencies
      '', // Define a version (optional)
      true // Specify whether to put in footer (leave this true)
    );
  }

  /**
  * This will generate a line of CSS for use in header output. If the setting
  * ($mod_name) has no defined value, the CSS will not be output.
  *
  * @uses get_theme_mod()
  * @param string $selector CSS selector
  * @param string $style The name of the CSS *property* to modify
  * @param string $mod_name The name of the 'theme_mod' option to fetch
  * @param string $prefix Optional. Anything that needs to be output before the CSS property
  * @param string $suffix Optional. Anything that needs to be output after the CSS property
  * @param bool $echo Optional. Whether to print directly to the page (default: true).
  * @return string Returns a single line of CSS with selectors and a property.
  * @since MyTheme 1.0
  */
  public static function generate_css( $selector, $style, $mod_name, $prefix='', $suffix='', $echo=true ) {
    $return = '';
    $mod = get_theme_mod($mod_name);
    if ( ! empty( $mod ) ) {
      $return = sprintf('%s { %s:%s; }',
      $selector,
      $style,
      $prefix.$mod.$suffix
      );
      if ( $echo ) {
        echo $return;
      }
    }
  return $return;
  }
} // end class DustySunTheme_Customize

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'DustySunTheme_Customize' , 'dst_register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'DustySunTheme_Customize' , 'dst_header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'DustySunTheme_Customize' , 'dst_live_preview' ) );
