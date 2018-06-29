<?php
/**
 *
 * XClean Customizer functionality.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * Add title tag support.
 *
 */

add_theme_support( 'title-tag' );


/**
 *
 * Add style support.
 *
 */
add_editor_style( 'css/custom-style.css' );


/**
 *
 * Add logo support.
 *
 */
add_theme_support( 'custom-logo' );


if ( ! function_exists( 'xclean_header_customiz' ) ) :
/**
 *
 * Add custom header support.
 *
 */
function xclean_header_customiz(){
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);

	return $defaults;
}
add_theme_support( 'custom-header', xclean_header_customiz() );
endif;


if ( ! function_exists( 'xclean_background_customiz' ) ) :
/**
 *
 * Add custom background support.
 *
 */
function xclean_background_customiz(){
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'default-repeat'         => '',
		'default-position-x'     => '',
		'default-attachment'     => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);

	return $defaults;
}
add_theme_support( 'custom-background', xclean_background_customiz() );
endif;
?>