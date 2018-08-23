<?php
/**
 * Loader for the ThemeIsle\ContentForms feature
 *
 * @package     ThemeIsle\ContentForms
 * @copyright   Copyright (c) 2017, Andrei Lupu
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

if ( ! function_exists( 'themeisle_content_forms_load' ) ) :

	/**
	 * Load the necessary resource for this library
	 */
	function themeisle_content_forms_load() {
		$path = dirname( __FILE__ );

		// @TODO we should autoload these
		// get base classes
		require_once $path . '/class-content-form-base.php';
		require_once $path . '/class-themeisle-content-forms-server.php';

		\Themeisle\ContentForms\RestServer::instance();

		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			// get builders generators
			require_once $path . '/class-themeisle-content-forms-elementor.php';
		}

		if ( class_exists( '\FLBuilderModel' ) ) {
			require_once $path . '/beaver/class-themeisle-content-forms-beaver-base.php';
			require_once $path . '/beaver/class-themeisle-content-forms-beaver-contact.php';
			require_once $path . '/beaver/class-themeisle-content-forms-beaver-newsletter.php';
			require_once $path . '/beaver/class-themeisle-content-forms-beaver-registration.php';
		}

		// @TODO Gutenberg is not working yet
		//require_once $path . '/class-themeisle-content-forms-gutenberg.php';

		// get forms
		require_once $path . '/class-themeisle-content-forms-contact.php';
		require_once $path . '/class-themeisle-content-forms-newsletter.php';
		require_once $path . '/class-themeisle-content-forms-registration.php';

		/**
		 * At this point all the PHP classes are available and the forms can be loaded
		 */
		do_action( 'init_themeisle_content_forms' );

		// Register CSS & JS assets + localizations
		add_action( 'wp_enqueue_scripts', 'themeisle_content_forms_register_public_assets' );
	}
endif;

if ( ! function_exists( 'themeisle_content_forms_register_public_assets' ) ) :
	/**
	 * Register the library assets, they will be enqueue later by builders.
	 * Also, localize REST params
	 */
	function themeisle_content_forms_register_public_assets() {
		$version = null; // a null version will go for a WordPress core version

		$package = json_decode( file_get_contents( dirname( __FILE__ ) . '/composer.json' ) );

		if ( isset( $package->version ) ) {
			$version = $package->version;
		}

		wp_register_script( 'content-forms', plugins_url( '/assets/content-forms.js', __FILE__ ), array( 'jquery' ), $version );

		wp_localize_script( 'content-forms', 'contentFormsSettings', array(
			'restUrl' => esc_url_raw( rest_url() . 'content-forms/v1/' ),
			'nonce'   => wp_create_nonce( 'wp_rest' ),
		) );

		/**
		 * Use this filter to force the js loading on all pages.
		 * Otherwise, it will be loaded only if a content form is present
		 */
		if ( apply_filters( 'themeisle_content_forms_force_js_enqueue', false ) ) {
			wp_enqueue_script( 'content-forms' );
		}

		/**
		 * Every theme with a better form style can disable the default content forms styles by returning a false
		 * to this filter `themeisle_content_forms_register_default_style`.
		 */
		if ( true === apply_filters( 'themeisle_content_forms_register_default_style', true ) ) {
			wp_register_style( 'content-forms', plugins_url( '/assets/content-forms.css', __FILE__ ), array(), $version );
		}
	}
endif;

// Run the show only for PHP 5.3 or highier
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	add_action( 'init', 'themeisle_content_forms_load', 9 );
}