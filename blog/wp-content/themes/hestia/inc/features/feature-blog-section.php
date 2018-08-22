<?php
/**
 * Customizer functionality for the Blog section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Blog section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.49
 */
function hestia_blog_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	if ( class_exists( 'Hestia_Hiding_Section' ) ) {
		$wp_customize->add_section(
			new Hestia_Hiding_Section(
				$wp_customize, 'hestia_blog', array(
					'title'          => esc_html__( 'Blog', 'hestia' ),
					'panel'          => 'hestia_frontpage_sections',
					'priority'       => apply_filters( 'hestia_section_priority', 60, 'hestia_blog' ),
					'hiding_control' => 'hestia_blog_hide',
				)
			)
		);
	} else {
		$wp_customize->add_section(
			'hestia_blog', array(
				'title'    => esc_html__( 'Blog', 'hestia' ),
				'panel'    => 'hestia_frontpage_sections',
				'priority' => apply_filters( 'hestia_section_priority', 60, 'hestia_blog' ),
			)
		);
	}

	$wp_customize->add_setting(
		'hestia_blog_hide', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'default'           => false,
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_blog_hide', array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Disable section', 'hestia' ),
			'section'  => 'hestia_blog',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'hestia_blog_title', array(
			'default'           => esc_html__( 'Blog', 'hestia' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_blog_title', array(
			'label'    => esc_html__( 'Section Title', 'hestia' ),
			'section'  => 'hestia_blog',
			'priority' => 5,
		)
	);

	$wp_customize->add_setting(
		'hestia_blog_subtitle', array(
			'default'           => esc_html__( 'Change this subtitle in the Customizer', 'hestia' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_blog_subtitle', array(
			'label'    => esc_html__( 'Section Subtitle', 'hestia' ),
			'section'  => 'hestia_blog',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'hestia_blog_items', array(
			'default'           => 3,
			'sanitize_callback' => 'absint',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_blog_items', array(
			'label'    => esc_html__( 'Number of Items', 'hestia' ),
			'section'  => 'hestia_blog',
			'priority' => 15,
			'type'     => 'number',
		)
	);
}
add_action( 'customize_register', 'hestia_blog_customize_register' );


/**
 * Add selective refresh for blog section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_blog_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'hestia_blog_hide', array(
			'selector'            => '.hestia-blogs:not(.is-shortcode)',
			'render_callback'     => 'hestia_blog',
			'container_inclusive' => true,
			'fallback_refresh'    => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_blog_title', array(
			'selector'         => '.hestia-blogs h2.hestia-title',
			'settings'         => 'hestia_blog_title',
			'render_callback'  => 'hestia_blog_title_render_callback',
			'fallback_refresh' => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_blog_subtitle', array(
			'selector'         => '.hestia-blogs h5.description',
			'settings'         => 'hestia_blog_subtitle',
			'render_callback'  => 'hestia_blog_subtitle_render_callback',
			'fallback_refresh' => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_blog_items', array(
			'selector'        => '.hestia-blog-content',
			'settings'        => 'hestia_blog_items',
			'render_callback' => 'hestia_blog_content_callback',
		)
	);
}
add_action( 'customize_register', 'hestia_register_blog_partials' );


/**
 * Render callback function for header title selective refresh
 *
 * @return string
 */
function hestia_blog_title_render_callback() {
	return get_theme_mod( 'hestia_blog_title' );
}

/**
 * Render callback function for header title selective refresh
 *
 * @return string
 */
function hestia_blog_subtitle_render_callback() {
	return get_theme_mod( 'hestia_blog_subtitle' );
}


/**
 * Callback function for blog content selective refresh.
 *
 * @since 1.1.31
 * @access public
 */
function hestia_blog_content_callback() {
	hestia_blog_content( true );
}
