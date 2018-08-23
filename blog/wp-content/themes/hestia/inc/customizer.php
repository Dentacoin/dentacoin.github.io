<?php
/**
 * Customizer functionality for the theme.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Load customizer paths.
 *
 * @since 1.1.38
 */
function hestia_load_customize_controls() {
	$control_paths = array();
	$control_paths = apply_filters( 'hestia_controls_path', $control_paths );

	if ( empty( $control_paths ) ) {
		return;
	}

	foreach ( $control_paths as $control_path ) {
		if ( file_exists( $control_path ) ) {
			require_once( $control_path );
		}
	}

}

add_action( 'customize_register', 'hestia_load_customize_controls', 0 );


/**
 * Add JS to enable live previews.
 *
 * @since Hestia 1.0
 */
function hestia_customizer_live_preview() {
	wp_enqueue_script(
		'hestia-customizer-preview', get_template_directory_uri() . '/assets/js/customizer.js', array(
			'jquery',
			'customize-preview',
		), HESTIA_VERSION, true
	);
}

add_action( 'customize_preview_init', 'hestia_customizer_live_preview' );

/**
 * Register and enqueue customizer script
 *
 * @since Hestia 1.0
 */
function hestia_customizer_controls() {
	wp_enqueue_style( 'hestia-customizer-style', get_template_directory_uri() . '/assets/css/customizer-style.css', array(), HESTIA_VERSION );
	wp_enqueue_script(
		'hestia_customize_controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array(
			'jquery',
			'customize-preview',
		), HESTIA_VERSION, true
	);

}

add_action( 'customize_controls_enqueue_scripts', 'hestia_customizer_controls' );

if ( ! function_exists( 'hestia_sanitize_checkbox' ) ) :
	/**
	 * Sanitize checkbox output.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_sanitize_checkbox( $input ) {
		return ( isset( $input ) && true === (bool) $input ? true : false );
	}
endif;

if ( ! function_exists( 'hestia_sanitize_multiselect' ) ) :
	/**
	 * Sanitize multi select output.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_sanitize_multiselect( $input ) {
		if ( ! is_array( $input ) ) {
			$output = explode( ',', $input );
		} else {
			$output = $input;
		}

		if ( ! empty( $output ) ) {
			return array_map( 'sanitize_text_field', $output );
		} else {
			return array();
		}
	}
endif;

// Load Customizer repeater control.
$repeater_path = get_template_directory() . '/inc/customizer-repeater/functions.php';
if ( file_exists( $repeater_path ) ) {
	require_once( $repeater_path );
}
// Load Customizer repeater control.
$plugin_installer = get_template_directory() . '/inc/plugin-install/class-hestia-plugin-install-helper.php';
if ( file_exists( $plugin_installer ) ) {
	require_once( $plugin_installer );
}

/**
 * Functions executed in customizer.
 * =================================
 */
/**
 * Register panels for Customizer.
 *
 * @since Hestia 1.0
 */
function hestia_customize_register( $wp_customize ) {

	$wp_customize->add_panel(
		'hestia_appearance_settings', array(
			'priority' => 25,
			'title'    => esc_html__( 'Appearance Settings', 'hestia' ),
		)
	);

	$wp_customize->add_panel(
		'hestia_frontpage_sections', array(
			'priority'    => 30,
			'title'       => esc_html__( 'Frontpage Sections', 'hestia' ),
			'description' => esc_html__( 'Drag and drop panels to change the order of sections.', 'hestia' ),
		)
	);

	$wp_customize->add_panel(
		'hestia_blog_settings', array(
			'priority' => 45,
			'title'    => esc_html__( 'Blog Settings', 'hestia' ),
		)
	);

	$wp_customize->get_section( 'header_image' )->panel        = 'hestia_appearance_settings';
	$wp_customize->get_section( 'header_image' )->description  = __return_empty_string();
	$wp_customize->get_section( 'background_image' )->panel    = 'hestia_appearance_settings';
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'custom_logo' )->transport     = 'postMessage';

	// Link to Header Background from Background Image section.
	if ( class_exists( 'Hestia_Display_Text' ) ) {
		$wp_customize->add_setting(
			'hestia_link_header_background', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			new Hestia_Display_Text(
				$wp_customize, 'hestia_link_header_background', array(
					'priority'     => 25,
					'section'      => 'background_image',
					'button_text'  => esc_html__( 'Header Background', 'hestia' ),
					'button_class' => 'focus-customizer-header-image',
					'icon_class'   => 'fa-image',
				)
			)
		);
	}

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'        => '.navbar .navbar-brand p',
				'settings'        => 'blogname',
				'render_callback' => 'hestia_blogname_callback',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'custom_logo', array(
				'selector'        => '.navbar-brand',
				'settings'        => 'custom_logo',
				'render_callback' => 'hestia_custom_logo_callback',
			)
		);
		/* Selective refresh for tagline. Just on latest posts page */
		if ( 'posts' === get_option( 'show_on_front' ) ) {
			$wp_customize->selective_refresh->add_partial(
				'blogdescription', array(
					'selector'        => '.home .hestia-title',
					'render_callback' => 'hestia_blogdescription_callback',
				)
			);
		}
	}

	/* Controls used for selective refresh on Sidebar placeholder */

	$wp_customize->add_setting(
		'hestia_placeholder_sidebar_1', array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'hestia_placeholder_sidebar_1', array(
			'type'     => 'hidden',
			'section'  => 'header_image',
			'priority' => 10,
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'hestia_placeholder_sidebar_1', array(
				'selector'        => '.hestia-widget-placeholder.sidebar-1',
				'settings'        => 'hestia_placeholder_sidebar_1',
				'render_callback' => '',
			)
		);
	}

	$wp_customize->add_setting(
		'hestia_placeholder_sidebar_woocommerce', array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'hestia_placeholder_sidebar_woocommerce', array(
			'type'     => 'hidden',
			'section'  => 'header_image',
			'priority' => 10,
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'hestia_placeholder_sidebar_woocommerce', array(
				'selector'        => '.hestia-widget-placeholder.sidebar-woocommerce',
				'settings'        => 'hestia_placeholder_sidebar_woocommerce',
				'render_callback' => '',
			)
		);
	}

}

add_action( 'customize_register', 'hestia_customize_register' );


/**
 * Register JS control types.
 *
 * @since  1.1.40
 * @access public
 * @return void
 */
function hestia_register_control_types( $wp_customize ) {

	// Register custom section types.
	$wp_customize->register_section_type( 'Hestia_Hiding_Section' );

	// Register JS sections type
	$wp_customize->register_section_type( 'Hestia_Customizer_Info' );

	// Register JS control types.
	$wp_customize->register_control_type( 'Hestia_Select_Multiple' );
	$wp_customize->register_control_type( 'Hestia_Customizer_Range_Value_Control' );
	$wp_customize->register_control_type( 'Hestia_Customizer_Heading' );

	$wp_customize->register_control_type( 'Hestia_Elementor_Edit' );
}

add_action( 'customize_register', 'hestia_register_control_types', 0 );


/**
 * Utils functions needed for controls.
 * ====================================
 */
/**
 * Custom logo callback function.
 *
 * @return string
 */
function hestia_custom_logo_callback() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		$logo = '<img src="' . esc_url( $logo[0] ) . '">';
	} else {
		$logo = '<p>' . get_bloginfo( 'name' ) . '</p>';
	}

	return $logo;
}

/**
 * Blog name callback function
 *
 * @return void
 */
function hestia_blogname_callback() {
	bloginfo( 'name' );
}

/**
 * Blog description callback function
 *
 * @return void
 */
function hestia_blogdescription_callback() {
	bloginfo( 'description' );
}

/**
 * Callback for WooCommerce customizer controls.
 *
 * @return bool
 */
function hestia_woocommerce_check() {
	if ( class_exists( 'woocommerce' ) ) {
		return true;
	}

	return false;
}

/**
 * Sanitize functions for custom controls
 * ======================================
 */

/**
 * Sanitize alignment control.
 *
 * @since 1.1.34
 *
 * @param string $value Control output.
 *
 * @return string
 */
function hestia_sanitize_alignment_options( $value ) {
	$value        = sanitize_text_field( $value );
	$valid_values = array(
		'left',
		'center',
		'right',
		'true',
		'false',
	);

	if ( ! in_array( $value, $valid_values ) ) {
		wp_die( 'Invalid value, go back and try again.' );
	}

	return $value;
}

/**
 * Sanitize Footer Layout control.
 *
 * @since 1.1.59
 *
 * @param string $value Control output.
 *
 * @return string
 */
function hestia_sanitize_footer_layout_control( $value ) {
	$value        = sanitize_text_field( $value );
	$valid_values = array(
		'white_footer',
		'black_footer',
	);

	if ( ! in_array( $value, $valid_values ) ) {
		wp_die( 'Invalid value, go back and try again.' );
	}

	return $value;
}

/**
 * Sanitize Blog Layout control.
 *
 * @since 1.1.59
 *
 * @param string $value Control output.
 *
 * @return string
 */
function hestia_sanitize_blog_layout_control( $value ) {
	$value        = sanitize_text_field( $value );
	$valid_values = array(
		'blog_alternative_layout',
		'blog_normal_layout',
	);

	if ( ! in_array( $value, $valid_values ) ) {
		wp_die( 'Invalid value, go back and try again.' );
	}

	return $value;
}

/**
 * Function to sanitize controls that returns arrays
 *
 * @since 1.1.40
 *
 * @param mixed $input Control output.
 */
function hestia_sanitize_array( $input ) {
	$output = $input;

	if ( ! is_array( $input ) ) {
		$output = explode( ',', $input );
	}

	if ( ! empty( $output ) ) {
		return array_map( 'sanitize_text_field', $output );
	}

	return array();
}

/**
 * Function to sanitize alpha color.
 *
 * @param string $input Hex or RGBA color.
 *
 * @return string
 */
function hestia_sanitize_colors( $input ) {
	// Is this an rgba color or a hex?
	$mode = ( false === strpos( $input, 'rgba' ) ) ? 'hex' : 'rgba';

	if ( 'rgba' === $mode ) {
		return hestia_sanitize_rgba( $input );
	} else {
		return sanitize_hex_color( $input );
	}
}

/**
 * Sanitize rgba color.
 *
 * @param string $value Color in rgba format.
 *
 * @return string
 */
function hestia_sanitize_rgba( $value ) {
	$red   = 'rgba(0,0,0,0)';
	$green = 'rgba(0,0,0,0)';
	$blue  = 'rgba(0,0,0,0)';
	$alpha = 'rgba(0,0,0,0)';   // If empty or an array return transparent
	if ( empty( $value ) || is_array( $value ) ) {
		return '';
	}

	// By now we know the string is formatted as an rgba color so we need to further sanitize it.
	$value = str_replace( ' ', '', $value );
	sscanf( $value, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
}

/**
 * Sanitize repeater control.
 *
 * @param object $input Control output.
 *
 * @return object
 */
function hestia_repeater_sanitize( $input ) {
	$input_decoded = json_decode( $input, true );

	if ( ! empty( $input_decoded ) ) {
		foreach ( $input_decoded as $boxk => $box ) {
			foreach ( $box as $key => $value ) {

				$input_decoded[ $boxk ][ $key ] = wp_kses_post( force_balance_tags( $value ) );

			}
		}

		return json_encode( $input_decoded );
	}

	return $input;
}

/**
 * Fix Jetpack causing tinymce editor issues.
 */
function hestia_jetpack_tinymce_fix() {
	remove_action( 'media_buttons', 'grunion_media_button', 999 );
	remove_action( 'admin_enqueue_scripts', 'grunion_enable_spam_recheck' );

	remove_action( 'admin_notices', array( 'Grunion_Editor_View', 'handle_editor_view_js' ) );
	remove_filter( 'mce_external_plugins', array( 'Grunion_Editor_View', 'mce_external_plugins' ) );
	remove_filter( 'mce_buttons', array( 'Grunion_Editor_View', 'mce_buttons' ) );
	remove_action( 'admin_head', array( 'Grunion_Editor_View', 'admin_head' ) );
}

if ( class_exists( 'Grunion_Editor_View' ) && is_customize_preview() ) {
	add_action( 'init', 'hestia_jetpack_tinymce_fix' );
}

/**
 * Allowed HTML tags for text controls
 *
 * @return - sanitized string and allowed HTML tags
 */
function hestia_sanitize_string( $input ) {

	$allowed_html = apply_filters(
		'hestia_sanitize_html_tags', array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'class' => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
			'i'      => array(
				'class' => array(),
			),
			'b'      => array(),
			'p'      => array(),
		)
	);

	$input = force_balance_tags( $input );

	return wp_kses( $input, $allowed_html );
}
