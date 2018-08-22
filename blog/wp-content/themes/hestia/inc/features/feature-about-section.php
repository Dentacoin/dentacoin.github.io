<?php
/**
 * Customizer functionality for the About section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

$page_editor_path = trailingslashit( get_template_directory() ) . 'inc/customizer-page-editor/customizer-page-editor.php';
if ( file_exists( $page_editor_path ) ) {
	require_once( $page_editor_path );
}

/**
 * Hook controls for About section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.49
 */
function hestia_about_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	if ( class_exists( 'Hestia_Hiding_Section' ) ) {
		$wp_customize->add_section(
			new Hestia_Hiding_Section(
				$wp_customize, 'hestia_about', array(
					'title'          => esc_html__( 'About', 'hestia' ),
					'panel'          => 'hestia_frontpage_sections',
					'priority'       => apply_filters( 'hestia_section_priority', 15, 'hestia_about' ),
					'hiding_control' => 'hestia_about_hide',
				)
			)
		);
	} else {
		$wp_customize->add_section(
			'hestia_about', array(
				'title'    => esc_html__( 'About', 'hestia' ),
				'panel'    => 'hestia_frontpage_sections',
				'priority' => apply_filters( 'hestia_section_priority', 15, 'hestia_about' ),
			)
		);
	}

	$wp_customize->add_setting(
		'hestia_about_hide', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'default'           => false,
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_about_hide', array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Disable section', 'hestia' ),
			'section'  => 'hestia_about',
			'priority' => 1,
		)
	);

	if ( class_exists( 'Hestia_Page_Editor' ) ) {
		$frontpage_id = get_option( 'page_on_front' );
		$default      = '';
		if ( ! empty( $frontpage_id ) ) {
			$default = get_post_field( 'post_content', $frontpage_id );
		}
		$wp_customize->add_setting(
			'hestia_page_editor', array(
				'default'           => $default,
				'sanitize_callback' => 'wp_kses_post',
				'transport'         => $selective_refresh,
			)
		);

		$wp_customize->add_control(
			new Hestia_Page_Editor(
				$wp_customize, 'hestia_page_editor', array(
					'label'           => esc_html__( 'About Content', 'hestia' ),
					'section'         => 'hestia_about',
					'priority'        => 10,
					'needsync'        => true,
					'active_callback' => 'hestia_display_content_editor',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'hestia_elementor_edit', array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new Hestia_Elementor_Edit(
			$wp_customize, 'hestia_elementor_edit', array(
				'label'           => esc_html__( 'About Content', 'hestia' ),
				'section'         => 'hestia_about',
				'priority'        => 14,
				'active_callback' => 'hestia_display_elementor_button',
			)
		)
	);

	$wp_customize->add_setting(
		'hestia_feature_thumbnail', array(
			'sanitize_callback' => 'esc_url_raw',
			'default'           => get_template_directory_uri() . '/assets/img/contact.jpg',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'hestia_feature_thumbnail', array(
				'label'           => esc_html__( 'About background', 'hestia' ),
				'section'         => 'hestia_about',
				'priority'        => 15,
				'active_callback' => 'hestia_is_static_page',
			)
		)
	);
}

add_action( 'customize_register', 'hestia_about_customize_register' );

/**
 * Add selective refresh for about section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_about_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'hestia_about_hide', array(
			'selector'            => '.hestia-about',
			'container_inclusive' => true,
			'render_callback'     => 'hestia_about',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_page_editor', array(
			'selector'        => '.hestia-about-content',
			'settings'        => 'hestia_page_editor',
			'render_callback' => 'hestia_about_content_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_feature_thumbnail', array(
			'selector'        => '.hestia-about-image',
			'settings'        => 'hestia_feature_thumbnail',
			'render_callback' => 'hestia_about_image_callback',
		)
	);
}
add_action( 'customize_register', 'hestia_register_about_partials' );


/**
 * Render callback for about image selective refresh.
 *
 * @since   1.1.25
 * @access  public
 */
function hestia_about_image_callback() {
	$hestia_feature_thumbnail = get_theme_mod( 'hestia_feature_thumbnail' );
	if ( ! empty( $hestia_feature_thumbnail ) ) { ?>
		<style class="hestia-about-image-css">
			#about {
				background-image: url(<?php echo ! empty( $hestia_feature_thumbnail ) ? esc_url( $hestia_feature_thumbnail ) : ''; ?>) !important;
			}
		</style>
		<?php
	} else {
	?>
		<style class="hestia-about-image-css">
			#about {
				background-image: none !important;
			}
		</style>
	<?php
	}
}

/**
 * Render callback for about section content selective refresh
 *
 * @since 1.1.31
 * @access public
 */
function hestia_about_content_callback() {
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'frontpage' );
		endwhile;
	else : // I'm not sure it's possible to have no posts when this page is shown, but WTH
		get_template_part( 'template-parts/content', 'none' );
	endif;
}

/**
 * Page editor control active callback function
 *
 * @return bool
 */
function hestia_is_static_page() {
	return 'page' === get_option( 'show_on_front' );
}

/**
 * Add an Edit with Elementor button in Customizer in the About section when the content has been added using Elementor
 *
 * @return bool
 */
function hestia_display_elementor_button() {
	$frontpage_id = get_option( 'page_on_front' );
	$post_meta    = ! empty( $frontpage_id ) ? get_post_meta( $frontpage_id ) : '';
	if ( ! empty( $post_meta ) && ! empty( $post_meta['_elementor_edit_mode'] ) && $post_meta['_elementor_edit_mode'][0] === 'builder' ) {
		return true;
	}
	return false;
}

/**
 * Callback for About section content editor
 *
 * @return bool
 */
function hestia_display_content_editor() {
	if ( 'page' === get_option( 'show_on_front' ) ) {
		$is_elementor = hestia_display_elementor_button();
		return ! $is_elementor;
	}
	return false;
}
