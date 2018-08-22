<?php
/**
 * Customizer functionality for the Theme Info section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

$theme_info_path = trailingslashit( get_template_directory() ) . 'inc/customizer-theme-info/class-hestia-customizer-theme-info.php';
if ( file_exists( $theme_info_path ) ) {
	require_once( $theme_info_path );
}

/**
 * Hook controls for Features section to Customizer.
 *
 * @since Hestia 1.0
 */
function hestia_theme_info_customize_register( $wp_customize ) {

	if ( ! class_exists( 'Hestia_Control_Upsell_Theme_Info' ) ) {
		return;
	}

	$wp_customize->add_section(
		'hestia_theme_info_main_section', array(
			'title'    => esc_html__( 'View PRO Features', 'hestia' ),
			'priority' => 0,
		)
	);

	$wp_customize->add_setting(
		'hestia_theme_info_main_control', array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new Hestia_Control_Upsell_Theme_Info(
			$wp_customize, 'hestia_theme_info_main_control', array(
				'section'            => 'hestia_theme_info_main_section',
				'priority'           => 100,
				'options'            => array(
					esc_html__( 'Header Slider', 'hestia' ),
					esc_html__( 'Fully Customizable Colors', 'hestia' ),
					esc_html__( 'Jetpack Portfolio', 'hestia' ),
					esc_html__( 'Pricing Plans Section', 'hestia' ),
					esc_html__( 'Section Reordering', 'hestia' ),
					esc_html__( 'Quality Support', 'hestia' ),
				),
				'explained_features' => array(
					esc_html__( 'You will be able to add more content to your site header with an awesome slider.', 'hestia' ),
					esc_html__( 'Change colors for the header overlay, header text and navbar.', 'hestia' ),
					esc_html__( 'Portfolio section with two possible layouts.', 'hestia' ),
					esc_html__( 'A fully customizable pricing plans section.', 'hestia' ),
					esc_html__( 'The ability to reorganize your Frontpage Sections more easily and quickly.', 'hestia' ),
					esc_html__( '24/7 HelpDesk Professional Support', 'hestia' ),
				),
				'button_url'         => esc_url( 'https://themeisle.com/themes/hestia-pro/upgrade/' ),
				'button_text'        => esc_html__( 'Get the PRO version!', 'hestia' ),
			)
		)
	);

}

add_action( 'customize_register', 'hestia_theme_info_customize_register' );
