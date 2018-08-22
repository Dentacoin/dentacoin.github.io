<?php
/**
 * Customizer functionality for the General settings.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Get image for customizer sidebar layout control, left side
 *
 * @since Hestia 1.1.51
 * @return string - path to image
 */
function hestia_layout_control_left_image() {
	return trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/sidebar-left.png';
}

/**
 * Get image for customizer sidebar layout control, right side
 *
 * @since Hestia 1.1.51
 * @return string - path to image
 */
function hestia_layout_control_right_image() {
	return trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/sidebar-right.png';
}

/**
 * Hook controls for General section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.30
 */
function hestia_general_customize_register( $wp_customize ) {

	if ( is_rtl() ) {
		add_filter( 'hestia_layout_control_image_left', 'hestia_layout_control_right_image' );
		add_filter( 'hestia_layout_control_image_right', 'hestia_layout_control_left_image' );
	}

	// Add general panel.
	$wp_customize->add_section(
		'hestia_general', array(
			'title'    => esc_html__( 'General Settings', 'hestia' ),
			'panel'    => 'hestia_appearance_settings',
			'priority' => 25,
		)
	);

	if ( class_exists( 'Hestia_Customize_Control_Radio_Image' ) ) {

		$sidebar_choices = array(
			'full-width'    => array(
				'url'   => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/full-width.png',
				'label' => esc_html__( 'Full Width', 'hestia' ),
			),
			'sidebar-left'  => array(
				'url'   => apply_filters( 'hestia_layout_control_image_left', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/sidebar-left.png' ),
				'label' => esc_html__( 'Left Sidebar', 'hestia' ),
			),
			'sidebar-right' => array(
				'url'   => apply_filters( 'hestia_layout_control_image_right', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/sidebar-right.png' ),
				'label' => esc_html__( 'Right Sidebar', 'hestia' ),
			),
		);

		$wp_customize->add_setting(
			'hestia_page_sidebar_layout', array(
				'sanitize_callback' => 'sanitize_key',
				'default'           => 'full-width',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Radio_Image(
				$wp_customize, 'hestia_page_sidebar_layout', array(
					'label'    => esc_html__( 'Page Sidebar Layout', 'hestia' ),
					'section'  => 'hestia_general',
					'priority' => 15,
					'choices'  => $sidebar_choices,
				)
			)
		);

		$default_blog_layout = hestia_sidebar_on_single_post_get_default();
		$wp_customize->add_setting(
			'hestia_blog_sidebar_layout', array(
				'default'           => $default_blog_layout,
				'sanitize_callback' => 'sanitize_key',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Radio_Image(
				$wp_customize, 'hestia_blog_sidebar_layout', array(
					'label'    => esc_html__( 'Blog Sidebar Layout', 'hestia' ),
					'section'  => 'hestia_general',
					'priority' => 20,
					'choices'  => $sidebar_choices,
				)
			)
		);
	}// End if().

	$wp_customize->add_setting(
		'hestia_enable_sharing_icons', array(
			'default'           => true,
			'sanitize_callback' => 'hestia_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'hestia_enable_sharing_icons', array(
			'label'    => esc_html__( 'Enable Sharing Icons', 'hestia' ),
			'section'  => 'hestia_general',
			'priority' => 30,
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'hestia_enable_scroll_to_top', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'hestia_enable_scroll_to_top', array(
			'label'    => esc_html__( 'Enable Scroll to Top', 'hestia' ),
			'section'  => 'hestia_general',
			'priority' => 40,
			'type'     => 'checkbox',
		)
	);

	// Boxed layout toggle.
	$wp_customize->add_setting(
		'hestia_general_layout', array(
			'default'           => 1,
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'hestia_general_layout', array(
			'label'       => esc_html__( 'Boxed Layout', 'hestia' ),
			'description' => esc_html__( 'If enabled, the theme will use a boxed layout.', 'hestia' ),
			'section'     => 'hestia_general',
			'priority'    => 50,
			'type'        => 'checkbox',
		)
	);

}
add_action( 'customize_register', 'hestia_general_customize_register' );

/**
 * Get default option for sidebar layout
 *
 * @return string
 */
function hestia_sidebar_on_single_post_get_default() {
	$hestia_sidebar_on_single_post = get_theme_mod( 'hestia_sidebar_on_single_post', false );
	$hestia_sidebar_on_index       = get_theme_mod( 'hestia_sidebar_on_index', false );
	return $hestia_sidebar_on_single_post && $hestia_sidebar_on_index ? 'full-width' : 'sidebar-right';
}
