<?php
/**
 * Plugin Name: Simple Custom CSS and JS 
 * Plugin URI: https://wordpress.org/plugins/custom-css-js/
 * Description: Easily add Custom CSS or JS to your website with an awesome editor.
 * Version: 3.17
 * Author: SilkyPress.com 
 * Author URI: https://www.silkypress.com
 * License: GPL2
 *
 * Text Domain: custom-css-js 
 * Domain Path: /languages/
 *
 * WC requires at least: 2.3.0
 * WC tested up to: 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'CustomCSSandJS' ) ) :
/**
 * Main CustomCSSandJS Class
 *
 * @class CustomCSSandJS 
 */
final class CustomCSSandJS {

    public $search_tree = false;
    protected static $_instance = null; 


    /**
     * Main CustomCSSandJS Instance
     *
     * Ensures only one instance of CustomCSSandJS is loaded or can be loaded
     *
     * @static
     * @return CustomCSSandJS - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
      * Cloning is forbidden.
      */
    public function __clone() {
         _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'custom-css-js' ), '1.0' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'custom-css-js' ), '1.0' );
    }

    /**
     * CustomCSSandJS Constructor
     * @access public
     */
    public function __construct() {

        include_once( 'includes/admin-install.php' );
        register_activation_hook(__FILE__, array('CustomCSSandJS_Install', 'install')); 
        add_action( 'init', array( 'CustomCSSandJS_Install', 'register_post_type' ) );

        $this->set_constants();

        if ( is_admin() ) {
            $this->load_plugin_textdomain();
            include_once( 'includes/admin-screens.php' );
            include_once( 'includes/admin-config.php' );
            include_once( 'includes/admin-addons.php' );
            include_once( 'includes/admin-warnings.php' );
            include_once( 'includes/admin-notices.php' );
        }

        $this->search_tree = get_option( 'custom-css-js-tree' );

        if ( ! $this->search_tree || count( $this->search_tree ) == 0 ) {
            return false;
        }

        if ( is_null( self::$_instance ) ) {
            $this->print_code_actions();
        } 
    }

    /**
     * Add the appropriate wp actions
     */
    function print_code_actions() {
        foreach( $this->search_tree as $_key => $_value ) {
            $action = 'wp_';
            if ( strpos( $_key, 'admin' ) !== false ) {
                $action = 'admin_';
            }
            if ( strpos( $_key, 'login' ) !== false ) {
                $action = 'login_';
            }
            if ( strpos( $_key, 'header' ) !== false ) {
                $action .= 'head';
            } else {
                $action .= 'footer';
            }

            $priority = ( $action == 'wp_footer' ) ? 40 : 10;

            add_action( $action, array( $this, 'print_' . $_key ), $priority );
        }
    }

    /**
     * Print the custom code.
     */
    public function __call( $function, $args ) {


        if ( strpos( $function, 'print_' ) === false ) {
            return false;
        }

        $function = str_replace( 'print_', '', $function );

        if ( ! isset( $this->search_tree[ $function ] ) ) {
            return false;
        } 

        $args = $this->search_tree[ $function ];

        if ( ! is_array( $args ) || count( $args ) == 0 ) {
            return false;
        }

        // print the `internal` code
        if ( strpos( $function, 'internal' ) !== false ) {

            $before = '<!-- start Simple Custom CSS and JS -->' . PHP_EOL; 
            $after = '<!-- end Simple Custom CSS and JS -->' . PHP_EOL;
            if ( strpos( $function, 'css' ) !== false ) {
                $before .= '<style type="text/css">' . PHP_EOL;
                $after = '</style>' . PHP_EOL . $after;
            }
            if ( strpos( $function, 'js' ) !== false ) {
                $before .= '<script type="text/javascript">' . PHP_EOL;
                $after = '</script>' . PHP_EOL . $after;
            }


            foreach( $args as $_post_id ) {
                if ( strstr( $_post_id, 'css' ) || strstr( $_post_id, 'js' ) ) {
                    @include_once( CCJ_UPLOAD_DIR . '/' . $_post_id );
                } else {
                    $post = get_post( $_post_id );
                    echo $before . $post->post_content . $after;
                }
            }            
        }

        // link the `external` code
        if ( strpos( $function, 'external' ) !== false) {
            $in_footer = false;
            if ( strpos( $function, 'footer' ) !== false ) {
                $in_footer = true;
            }
            
            if ( strpos( $function, 'js' ) !== false ) {
                foreach( $args as $_filename ) {
                    echo PHP_EOL . "<script type='text/javascript' src='".CCJ_UPLOAD_URL. '/' . $_filename."'></script>" . PHP_EOL;
                }
            }

            if ( strpos( $function, 'css' ) !== false ) {
                foreach( $args as $_filename ) {
                    $shortfilename = preg_replace( '@\.css\?v=.*$@', '', $_filename );
                    echo PHP_EOL . "<link rel='stylesheet' id='".$shortfilename ."-css'  href='".CCJ_UPLOAD_URL. '/' . $_filename ."' type='text/css' media='all' />" . PHP_EOL;
                }
            }
        }

        // link the HTML code
        if ( strpos( $function, 'html' ) !== false ) {
            foreach( $args as $_post_id ) {
                $_post_id = str_replace('.html', '', $_post_id);
                $post = get_post( $_post_id );
                echo $post->post_content . PHP_EOL;
            }            

        }
    }


    /**
     * Set constants for later use
     */
    function set_constants() {
        $dir = wp_upload_dir();
        $constants = array(
            'CCJ_VERSION'         => '3.17',
            'CCJ_UPLOAD_DIR'      => $dir['basedir'] . '/custom-css-js', 
            'CCJ_UPLOAD_URL'      => $dir['baseurl'] . '/custom-css-js', 
            'CCJ_PLUGIN_FILE'     => __FILE__,
        );
        foreach( $constants as $_key => $_value ) {
            if (!defined($_key)) {
                define( $_key, $_value );
            }
        }
    }

       
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'custom-css-js', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

}

endif; 

/**
 * Returns the main instance of CustomCSSandJS 
 *
 * @return CustomCSSandJS 
 */
if ( ! function_exists('CustomCSSandJS' ) ) {
function CustomCSSandJS() {
    return CustomCSSandJS::instance();
}

CustomCSSandJS();
}


/**
 * Plugin action link to Settings page
*/
if ( ! function_exists('custom_css_js_plugin_action_links') ) {
function custom_css_js_plugin_action_links( $links ) {

    $settings_link = '<a href="edit.php?post_type=custom-css-js">' .
        esc_html( __('Settings', 'custom-css-js' ) ) . '</a>';

    return array_merge( array( $settings_link), $links );
    
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'custom_css_js_plugin_action_links' );
}



/**
 * Compatibility with the WP Quads Pro plugin, 
 * otherwise on a Custom Code save there is a 
 * "The link you followed has expired." page shown.
 */
if ( ! function_exists('custom_css_js_quads_pro_compat') ) {
    function custom_css_js_quads_pro_compat( $post_types ) {
        $match = array_search('custom-css-js', $post_types);
        if ( $match ) {
            unset($post_types[$match]);
        }
        return $post_types;
    }
    add_filter('quads_meta_box_post_types', 'custom_css_js_quads_pro_compat', 20); 
}

