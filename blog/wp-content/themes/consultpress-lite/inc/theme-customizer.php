<?php
/**
 * Load the Customizer with some custom extended addons
 *
 * @package consultpresslite-pt
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

/**
 * This funtion is only called when the user is actually on the customizer page
 *
 * @param  WP_Customize_Manager $wp_customize
 */
if ( ! function_exists( 'consultpresslite_customizer' ) ) {
	function consultpresslite_customizer( $wp_customize ) {
		// Add required files.
		ConsultPressLiteHelpers::load_file( '/inc/customizer/class-customize-base.php' );

		new ConsultPressLite_Customizer_Base( $wp_customize );
	}
	add_action( 'customize_register', 'consultpresslite_customizer' );
}


/**
 * Takes care for the frontend output from the customizer and nothing else
 */
if ( ! function_exists( 'consultpresslite_customizer_frontend' ) && ! class_exists( 'ConsultPressLite_Customize_Frontent' ) ) {
	function consultpresslite_customizer_frontend() {
		ConsultPressLiteHelpers::load_file( '/inc/customizer/class-customize-frontend.php' );
		$consultpresslite_customize_frontent = new ConsultPressLite_Customize_Frontent();
	}
	add_action( 'init', 'consultpresslite_customizer_frontend' );
}
