<?php
/**
 * ConsultPressLite functions and definitions
 *
 * @author ProteusThemes <info@proteusthemes.com>
 * @package consultpresslite-pt
 */

// Display informative message if PHP version is less than 5.3.2.
if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
	die( sprintf( esc_html_x( 'This theme requires %2$sPHP 5.3.2+%3$s to run. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', '%1$s - version ie. 5.4.0. %2$s, %3$s and %4$s  - html tags, must be included around the same words as original', 'consultpress-lite' ), esc_html( phpversion() ), '<strong>', '</strong>', '<br>' ) );
}


// Create a helper function for easy SDK access.
function consultpresslite_fs() {
	global $consultpresslite_fs;

	if ( ! isset( $consultpresslite_fs ) ) {
			// Include Freemius SDK.
			if( ! function_exists( 'fs_dynamic_init' ) ) {
				require_once dirname(__FILE__) . '/vendor/freemius/wordpress-sdk/start.php';
			}

			$consultpresslite_fs = fs_dynamic_init( array(
					'id'                  => '862',
					'slug'                => 'consultpress-lite',
					'type'                => 'theme',
					'public_key'          => 'pk_14da83677b7eb68ed258c917c92d0',
					'is_premium'          => false,
					'has_premium_version' => false,
					'has_addons'          => false,
					'has_paid_plans'      => false,
			) );
	}

	return $consultpresslite_fs;
}

// Init Freemius.
consultpresslite_fs();


// Composer autoloader.
require_once trailingslashit( get_template_directory() ) . 'vendor/autoload.php';


/**
 * Define the version variable to assign it to all the assets (css and js)
 */
define( 'CONSULTPRESSLITE_WP_VERSION', wp_get_theme()->get( 'Version' ) );


/**
 * Define the development constant
 */
if ( ! defined( 'CONSULTPRESSLITE_DEVELOPMENT' ) ) {
	define( 'CONSULTPRESSLITE_DEVELOPMENT', false );
}


/**
 * Helper functions used in the theme
 */
require_once get_template_directory() . '/inc/helpers.php';


/**
 * Theme support and thumbnail sizes
 */
if ( ! function_exists( 'consultpresslite_theme_setup' ) ) {
	function consultpresslite_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ConsultPressLite, use a find and replace
		 * to change 'consultpress-lite' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'consultpress-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Add support for Theme Logo -> https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo' );

		// Menus.
		add_theme_support( 'menus' );
		register_nav_menu( 'main-menu', esc_html__( 'Main Menu', 'consultpress-lite' ) );

		/**
		 * Switch default core markup for comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add excerpt support for pages.
		add_post_type_support( 'page', 'excerpt' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'consultpresslite_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
	add_action( 'after_setup_theme', 'consultpresslite_theme_setup' );
}


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @see https://codex.wordpress.org/Content_Width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}


/**
 * Enqueue CSS stylesheets
 */
if ( ! function_exists( 'consultpresslite_enqueue_styles' ) ) {
	function consultpresslite_enqueue_styles() {
		wp_enqueue_style( 'consultpresslite-main', get_stylesheet_uri(), array(), CONSULTPRESSLITE_WP_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'consultpresslite_enqueue_styles' );
}


/**
 * Enqueue Google Web Fonts.
 */
if ( ! function_exists( 'consultpresslite_enqueue_google_web_fonts' ) ) {
	function consultpresslite_enqueue_google_web_fonts() {
		wp_enqueue_style( 'consultpresslite-google-fonts', ConsultPressLiteHelpers::google_web_fonts_url(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'consultpresslite_enqueue_google_web_fonts' );
}


/**
 * Enqueue JS scripts
 */
if ( ! function_exists( 'consultpresslite_enqueue_scripts' ) ) {
	function consultpresslite_enqueue_scripts() {
		// Modernizr for the frontend feature detection.
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.20160801.min.js', array(), null );

		// Array for main.js dependencies.
		$main_deps = array( 'jquery', 'underscore' );

		// Main JS file, conditionally.
		if ( true === CONSULTPRESSLITE_DEVELOPMENT ) {
			// Requirejs.
			wp_register_script( 'require.js', get_template_directory_uri() . '/bower_components/requirejs/require.js', array(), null, true );

			$main_deps[] = 'require.js';
			wp_enqueue_script( 'consultpresslite-main', get_template_directory_uri() . '/assets/js/main.js', $main_deps, CONSULTPRESSLITE_WP_VERSION, true );
		}
		else {
			wp_enqueue_script( 'consultpresslite-main', get_template_directory_uri() . '/assets/js/main.min.js', $main_deps, CONSULTPRESSLITE_WP_VERSION, true );
		}

		// Pass data to the main script.
		wp_localize_script( 'consultpresslite-main', 'ConsultPressLiteVars', array(
			'pathToTheme'   => get_template_directory_uri(),
		) );

		// For nested comments.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'consultpresslite_enqueue_scripts' );
}


/**
 * Require the files in the folder /inc/
 */
$consultpresslite_files_to_require = array(
	'theme-sidebars',
	'filters',
	'theme-customizer',
);

// Conditionally require the includes files, based if they exist in the child theme or not.
foreach ( $consultpresslite_files_to_require as $file ) {
	ConsultPressLiteHelpers::load_file( sprintf( '/inc/%s.php', $file ) );
}


/**
 * WIA-ARIA nav walker and accompanying JS file
 */

if ( ! function_exists( 'consultpresslite_wai_aria_js' ) ) {
	function consultpresslite_wai_aria_js() {
		wp_enqueue_script( 'consultpresslite-wp-wai-aria', get_template_directory_uri() . '/vendor/proteusthemes/wai-aria-walker-nav-menu/wai-aria.js', array( 'jquery' ), null, true );
	}
	add_action( 'wp_enqueue_scripts', 'consultpresslite_wai_aria_js' );
}
