<?php
/**
 * Customizer functionality for the Shop section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Shop section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.49
 */
function hestia_shop_customize_register( $wp_customize ) {

	if ( ! hestia_woocommerce_check() ) {
		return;
	}

	if ( class_exists( 'Hestia_Hiding_Section' ) ) {
		$wp_customize->add_section(
			new Hestia_Hiding_Section(
				$wp_customize, 'hestia_shop', array(
					'title'          => esc_html__( 'Shop', 'hestia' ),
					'panel'          => 'hestia_frontpage_sections',
					'priority'       => apply_filters( 'hestia_section_priority', 20, 'hestia_shop' ),
					'hiding_control' => 'hestia_shop_hide',
				)
			)
		);
	} else {
		$wp_customize->add_section(
			'hestia_shop', array(
				'title'    => esc_html__( 'Shop', 'hestia' ),
				'panel'    => 'hestia_frontpage_sections',
				'priority' => apply_filters( 'hestia_section_priority', 20, 'hestia_shop' ),
			)
		);
	}

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	$wp_customize->add_setting(
		'hestia_shop_hide', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'default'           => false,
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_shop_hide', array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Disable section', 'hestia' ),
			'section'  => 'hestia_shop',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'hestia_shop_title', array(
			'default'           => esc_html__( 'Products', 'hestia' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_shop_title', array(
			'label'    => esc_html__( 'Section Title', 'hestia' ),
			'section'  => 'hestia_shop',
			'priority' => 5,
		)
	);

	$wp_customize->add_setting(
		'hestia_shop_subtitle', array(
			'default'           => esc_html__( 'Change this subtitle in the Customizer', 'hestia' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_shop_subtitle', array(
			'label'    => esc_html__( 'Section Subtitle', 'hestia' ),
			'section'  => 'hestia_shop',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'hestia_shop_items', array(
			'default'           => 4,
			'sanitize_callback' => 'absint',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_shop_items', array(
			'label'    => esc_html__( 'Number of Items', 'hestia' ),
			'section'  => 'hestia_shop',
			'priority' => 15,
			'type'     => 'number',
		)
	);

}
add_action( 'customize_register', 'hestia_shop_customize_register' );

/**
 * Add selective refresh for shop section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_shop_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'hestia_shop_hide', array(
			'selector'            => '.products:not(.is-shortcode)',
			'render_callback'     => 'hestia_shop',
			'container_inclusive' => true,
			'fallback_refresh'    => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_shop_title', array(
			'selector'         => '.products .hestia-title',
			'render_callback'  => 'hestia_shop_title_callback',
			'fallback_refresh' => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_shop_subtitle', array(
			'selector'         => '.products .description',
			'render_callback'  => 'hestia_shop_subtitle_callback',
			'fallback_refresh' => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_shop_items', array(
			'selector'            => '.hestia-shop-content',
			'render_callback'     => 'hestia_shop_content',
			'container_inclusive' => true,
		)
	);

}
add_action( 'customize_register', 'hestia_register_shop_partials' );


/**
 * Callback functions for selective refresh.
 * =========================================
 */
/**
 * Render callback function for products section title selective refresh
 *
 * @return string
 */
function hestia_shop_title_callback() {
	return get_theme_mod( 'hestia_shop_title' );
}

/**
 * Render callback function for products section subtitle selective refresh
 *
 * @return string
 */
function hestia_shop_subtitle_callback() {
	return get_theme_mod( 'hestia_shop_subtitle' );
}
