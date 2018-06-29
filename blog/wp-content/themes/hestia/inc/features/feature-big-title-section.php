<?php
/**
 * Customizer functionality for the Slider section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Slider section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.30
 */
function hestia_big_title_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;

	$wp_customize->add_section(
		'hestia_big_title', array(
			'title'    => esc_html__( 'Big Title Section', 'hestia' ),
			'panel'    => 'hestia_frontpage_sections',
			'priority' => 1,
		)
	);

	/**
	 * Control for big title background
	 */

	$wp_customize->add_setting(
		'hestia_big_title_background', array(
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'hestia_big_title_background', array(
				'label'    => esc_html__( 'Big Title Background', 'hestia' ),
				'section'  => 'hestia_big_title',
				'priority' => 10,
			)
		)
	);

	/**
	 * Control for header title
	 */
	$wp_customize->add_setting(
		'hestia_big_title_title', array(
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_big_title_title', array(
			'label'    => esc_html__( 'Title', 'hestia' ),
			'section'  => 'hestia_big_title',
			'priority' => 15,
		)
	);

	/**
	 * Control for header text
	 */
	$wp_customize->add_setting(
		'hestia_big_title_text', array(
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_big_title_text', array(
			'label'    => esc_html__( 'Text', 'hestia' ),
			'section'  => 'hestia_big_title',
			'priority' => 20,
		)
	);

	/**
	 * Control for button text
	 */
	$wp_customize->add_setting(
		'hestia_big_title_button_text', array(
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'hestia_big_title_button_text', array(
			'label'    => esc_html__( 'Button text', 'hestia' ),
			'section'  => 'hestia_big_title',
			'priority' => 25,
		)
	);

	/**
	 * Control for button link
	 */
	$wp_customize->add_setting(
		'hestia_big_title_button_link', array(
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'hestia_big_title_button_link', array(
			'label'    => esc_html__( 'Button URL', 'hestia' ),
			'section'  => 'hestia_big_title',
			'priority' => 30,
		)
	);

	if ( class_exists( 'Hestia_Customize_Control_Radio_Image' ) ) {
		$wp_customize->add_setting(
			'hestia_slider_alignment', array(
				'default'           => 'center',
				'sanitize_callback' => 'hestia_sanitize_alignment_options',
				'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Radio_Image(
				$wp_customize, 'hestia_slider_alignment', array(
					'label'    => esc_html__( 'Layout', 'hestia' ),
					'priority' => 35,
					'section'  => 'hestia_big_title',
					'choices'  => array(
						'left'   => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/slider-layout-1.png',
						),
						'center' => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/slider-layout-2.png',
						),
						'right'  => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/slider-layout-3.png',
						),
					),
				)
			)
		);
	}

	$hestia_slider_content = get_theme_mod( 'hestia_slider_content' );

	if ( empty( $hestia_slider_content ) ) {
		$wp_customize->get_setting( 'hestia_big_title_background' )->default  = esc_url( apply_filters( 'hestia_big_title_background_default', get_template_directory_uri() . '/assets/img/slider2.jpg' ) );
		$wp_customize->get_setting( 'hestia_big_title_title' )->default       = esc_html__( 'Change in the Customizer', 'hestia' );
		$wp_customize->get_setting( 'hestia_big_title_text' )->default        = esc_html__( 'Change in the Customizer', 'hestia' );
		$wp_customize->get_setting( 'hestia_big_title_button_text' )->default = esc_html__( 'Change in the Customizer', 'hestia' );
		$wp_customize->get_setting( 'hestia_big_title_button_link' )->default = esc_url( '#' );
	}

}

add_action( 'customize_register', 'hestia_big_title_customize_register' );



/**
 * Add selective refresh for big title section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_big_title_partials( $wp_customize ) {
	$wp_customize->selective_refresh->add_partial(
		'hestia_big_title_title', array(
			'selector'        => '.carousel .hestia-title',
			'settings'        => 'hestia_big_title_title',
			'render_callback' => 'hestia_big_title_title_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_big_title_text', array(
			'selector'        => '.carousel .sub-title',
			'settings'        => 'hestia_big_title_text',
			'render_callback' => 'hestia_big_title_text_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_big_title_button', array(
			'selector'        => '.carousel .buttons',
			'settings'        => array( 'hestia_big_title_button_text', 'hestia_big_title_button_link' ),
			'render_callback' => 'hestia_big_title_button_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_big_title_background', array(
			'selector'        => '.big-title-image',
			'settings'        => 'hestia_big_title_background',
			'render_callback' => 'hestia_big_title_image_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_slider_alignment', array(
			'selector'        => '.hestia-big-title-content',
			'settings'        => 'hestia_slider_alignment',
			'render_callback' => 'hestia_slider_alignment_callback',
		)
	);
}
add_action( 'customize_register', 'hestia_register_big_title_partials' );

/**
 * Render callback function for header title selective refresh
 *
 * @return string
 */
function hestia_big_title_title_render_callback() {
	return get_theme_mod( 'hestia_big_title_title' );
}

/**
 * Render callback function for header subtitle selective refresh
 *
 * @return string
 */
function hestia_big_title_text_render_callback() {
	return get_theme_mod( 'hestia_big_title_text' );
}

/**
 * Render callback function for slider alignment selective refresh
 *
 * @since 1.1.41
 */
function hestia_slider_alignment_callback() {
	$section_content = hestia_get_big_title_content();
	hestia_show_big_title_content( $section_content );
}

/**
 * Render callback function for header button selective refresh
 *
 * @return string
 */
function hestia_big_title_button_render_callback() {
	$button_text = get_theme_mod( 'hestia_big_title_button_text' );
	$button_link = get_theme_mod( 'hestia_big_title_button_link' );

	$output = '';

	if ( ! empty( $button_text ) && ! empty( $button_link ) ) {
		$output = '<a href="' . $button_link . '" title="' . $button_text . '" class="btn btn-primary btn-lg">' . $button_text . '</a>';
	}

	return wp_kses_post( $output );
}

/**
 * Callback function for big title background selective refresh.
 *
 * @since 1.1.31
 * @access public
 */
function hestia_big_title_image_callback() {
	$hestia_big_title_background = get_theme_mod( 'hestia_big_title_background' );
	if ( ! empty( $hestia_big_title_background ) ) { ?>
		<style class="big-title-image-css">
			#carousel-hestia-generic .header-filter {
				background-image: url(<?php echo esc_url( $hestia_big_title_background ); ?>) !important;
			}
		</style>
		<?php
	}
}
