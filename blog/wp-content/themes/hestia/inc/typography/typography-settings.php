<?php
/**
 * Typography settings for both Hestia and Hestia PRO
 *
 * @package Hestia
 * @since 1.1.38
 */

/**
 * Include functions file for Font Family controls.
 */
$font_selector_functions = HESTIA_PHP_INCLUDE . 'customizer-font-selector/functions.php';
if ( file_exists( $font_selector_functions ) ) {
	require_once( $font_selector_functions );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.1.38
 */
function hestia_customize_preview() {
	wp_enqueue_script( 'hestia_customizer', get_template_directory_uri() . '/inc/typography/js/customizer.js', array( 'customize-preview' ), HESTIA_VERSION, true );
}

add_action( 'customize_preview_init', 'hestia_customize_preview' );

/**
 * Customizer controls for typography settings.
 *
 * @param WP_Customize_Manager $wp_customize Customize manager.
 *
 * @since 1.1.38
 */
function hestia_typography_settings( $wp_customize ) {

	/**
	 * Main typography panel
	 */

	$wp_customize->add_section(
		'hestia_typography', array(
			'title'    => esc_html__( 'Typography', 'hestia' ),
			'panel'    => 'hestia_appearance_settings',
			'priority' => 25,
		)
	);

	/**
	 * ------------------
	 * 1. Font Family tab
	 * ------------------
	 */

	if ( class_exists( 'Hestia_Font_Selector' ) ) {

		/**
		 * ---------------------------------
		 * 1.a. Headings font family control
		 * This control allows the user to choose a font family for all Headings used in the theme ( h1 - h6 )
		 * --------------------------------
		 */

		$wp_customize->add_setting(
			'hestia_headings_font', array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Font_Selector(
				$wp_customize, 'hestia_headings_font', array(
					'label'    => esc_html__( 'Headings', 'hestia' ) . ' ' . esc_html__( 'font family', 'hestia' ),
					'section'  => 'hestia_typography',
					'priority' => 5,
					'type'     => 'select',
				)
			)
		);

		/**
		 * ---------------------------------
		 * 1.b. Body font family control
		 * This control allows the user to choose a font family for all elements in the body tag
		 * --------------------------------
		 */

		$wp_customize->add_setting(
			'hestia_body_font', array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Font_Selector(
				$wp_customize, 'hestia_body_font', array(
					'label'    => esc_html__( 'Body', 'hestia' ) . ' ' . esc_html__( 'font family', 'hestia' ),
					'section'  => 'hestia_typography',
					'priority' => 10,
					'type'     => 'select',
				)
			)
		);
	} // End if().

	if ( class_exists( 'Hestia_Select_Multiple' ) ) {

		/**
		 * --------------------
		 * 1.c. Font Subsets control
		 * This control allows the user to choose a subset for the font family ( for e.g. lating, cyrillic etc )
		 * --------------------
		 */

		$wp_customize->add_setting(
			'hestia_font_subsets', array(
				'sanitize_callback' => 'hestia_sanitize_array',
				'default'           => array( 'latin' ),
			)
		);

		$wp_customize->add_control(
			new Hestia_Select_Multiple(
				$wp_customize, 'hestia_font_subsets', array(
					'section'  => 'hestia_typography',
					'label'    => esc_html__( 'Font Subsets', 'hestia' ),
					'choices'  => array(
						'latin'        => 'latin',
						'latin-ext'    => 'latin-ext',
						'cyrillic'     => 'cyrillic',
						'cyrillic-ext' => 'cyrillic-ext',
						'greek'        => 'greek',
						'greek-ext'    => 'greek-ext',
						'vietnamese'   => 'vietnamese',
					),
					'priority' => 45,
				)
			)
		);
	} // End if().

	/**
	 * ------------------
	 * 2. Font Size tab
	 * ------------------
	 */
	if ( class_exists( 'Hestia_Customizer_Range_Value_Control' ) ) {

		/**
		 * -------------------------------------
		 * 2.a. Customizer headings for a better
		 * organization
		 * -------------------------------------
		 */
		if ( class_exists( 'Hestia_Customizer_Heading' ) ) {

			/**
			 * -------------------------------------
			 * Heading control that is displayed
			 * before font size controls for posts
			 * and pages.
			 * -------------------------------------
			 */
			$wp_customize->add_setting(
				'hestia_posts_and_pages_title', array(
					'sanitize_callback' => 'wp_kses',
				)
			);

			$wp_customize->add_control(
				new Hestia_Customizer_Heading(
					$wp_customize, 'hestia_posts_and_pages_title', array(
						'label'    => esc_html__( 'Posts & Pages', 'hestia' ),
						'section'  => 'hestia_typography',
						'priority' => 100,
					)
				)
			);

			/**
			 * -------------------------------------
			 * Heading control that is displayed
			 * before font size controls for
			 * frontpage.
			 * -------------------------------------
			 */
			$wp_customize->add_setting(
				'hestia_frontpage_sections_title', array(
					'sanitize_callback' => 'wp_kses',
				)
			);

			$wp_customize->add_control(
				new Hestia_Customizer_Heading(
					$wp_customize, 'hestia_frontpage_sections_title', array(
						'label'    => esc_html__( 'Frontpage Sections', 'hestia' ),
						'section'  => 'hestia_typography',
						'priority' => 200,
					)
				)
			);
		}

		/**
		 * --------------------------------------------------------------------------
		 * 2.b. Font size controls for Posts & Pages
		 * --------------------------------------------------------------------------
		 *
		 * Title control [Posts & Pages]
		 * This control allows the user to choose a font size for the main titles
		 * that appear in the header for pages and posts.
		 *
		 * The values area between -25 and +25 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_header_titles_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => '0',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_header_titles_fs', array(
					'label'       => esc_html__( 'Title', 'hestia' ),
					'section'     => 'hestia_typography',
					'type'        => 'range-value',
					'input_attr'  => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'    => 110,
					'media_query' => true,
					'sum_type'    => true,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * Headings control [Posts & Pages]
		 *
		 * This control allows the user to choose a font size for all headings
		 * ( h1 - h6 ) from pages and posts.
		 *
		 * The values area between -25 and +25 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_post_page_headings_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => 0,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_post_page_headings_fs', array(
					'label'      => esc_html__( 'Headings', 'hestia' ),
					'section'    => 'hestia_typography',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'   => 115,
					'sum_type'   => true,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * Content control [Posts & Pages]
		 *
		 * This control allows the user to choose a font size for the main content
		 * area in pages and posts.
		 *
		 * The values area between -25 and +25 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_post_page_content_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => 0,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_post_page_content_fs', array(
					'label'      => esc_html__( 'Content', 'hestia' ),
					'section'    => 'hestia_typography',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'   => 120,
					'sum_type'   => true,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * 2.c. Font size controls for Frontpage
		 * --------------------------------------------------------------------------
		 * Big Title Section / Header Slider font size control. [Frontpage Sections]
		 *
		 * This is changing the big title/slider titles, the
		 * subtitle and the button in the big title section.
		 *
		 * The values are between -25 and +25 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_big_title_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => '0',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_big_title_fs', array(
					'label'      => apply_filters( 'hestia_big_title_fs_label', esc_html__( 'Big Title Section', 'hestia' ) ),
					'section'    => 'hestia_typography',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'   => 210,
					'sum_type'   => true,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * Section Title [Frontpage Sections]
		 *
		 * This control is changing sections titles and card titles
		 * The values are between -25 and +25 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_section_primary_headings_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => '0',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_section_primary_headings_fs', array(
					'label'      => esc_html__( 'Section Title', 'hestia' ),
					'section'    => 'hestia_typography',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'   => 215,
					'sum_type'   => true,
				)
			)
		);

		/**
		 * -----------------------------------------------------
		 * Subtitles control [Frontpage Sections]
		 * This control allows the user to choose a font size
		 * for all Subtitles on Frontpage sections.
		 * The values area between -25 and +25 px.
		 * -----------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_section_secondary_headings_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => 0,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_section_secondary_headings_fs', array(
					'label'      => esc_html__( 'Section Subtitle', 'hestia' ),
					'section'    => 'hestia_typography',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'   => 220,
					'sum_type'   => true,
				)
			)
		);

		/**
		 * -----------------------------------------------------
		 * Content control [Frontpage Sections]
		 * This control allows the user to choose a font size
		 * for the Main content for Frontpage Sections
		 * The values area between -25 and +25 px.
		 * -----------------------------------------------------
		 */
		$wp_customize->add_setting(
			'hestia_section_content_fs', array(
				'sanitize_callback' => 'hestia_sanitize_range_value',
				'default'           => 0,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_section_content_fs', array(
					'label'      => esc_html__( 'Content', 'hestia' ),
					'section'    => 'hestia_typography',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => - 25,
						'max'  => 25,
						'step' => 1,
					),
					'priority'   => 225,
					'sum_type'   => true,
				)
			)
		);
	} // End if().
}

add_action( 'customize_register', 'hestia_typography_settings', 20 );

if ( ! file_exists( 'hestia_fonts_inline_style' ) ) {
	/**
	 * Add inline style for custom fonts.
	 *
	 * @since 1.1.59
	 */
	function hestia_fonts_inline_style() {

		/**
		 * Headings font family.
		 */
		$custom_css           = '';
		$default              = apply_filters( 'hestia_headings_default', false );
		$hestia_headings_font = get_theme_mod( 'hestia_headings_font', $default );

		if ( ! empty( $hestia_headings_font ) ) {
			hestia_enqueue_google_font( $hestia_headings_font );
			$custom_css .=
				'h1, h2, h3, h4, h5, h6, .hestia-title , .info-title, .card-title,
		.page-header.header-small .hestia-title, .page-header.header-small .title, .widget h5, .hestia-title, 
		.title, .card-title, .info-title, .footer-brand, .footer-big h4, .footer-big h5, .media .media-heading, 
		.carousel h1.hestia-title, .carousel h2.title, 
		.carousel span.sub-title, .woocommerce.single-product h1.product_title, .woocommerce section.related.products h2, .hestia-about h1, .hestia-about h2, .hestia-about h3, .hestia-about h4, .hestia-about h5 {
			font-family: ' . $hestia_headings_font . ';
		}';
			if ( class_exists( 'WooCommerce' ) ) {
				$custom_css .=
					'.woocommerce.single-product .product_title, .woocommerce .related.products h2, .woocommerce span.comment-reply-title {
				font-family: ' . $hestia_headings_font . ';
			}';
			}
		}

		/**
		 * Body font family.
		 */
		$default          = apply_filters( 'hestia_body_font_default', false );
		$hestia_body_font = get_theme_mod( 'hestia_body_font', $default );
		if ( ! empty( $hestia_body_font ) ) {
			hestia_enqueue_google_font( $hestia_body_font );
			$custom_css .= '
		body, ul, .tooltip-inner {
			font-family: ' . $hestia_body_font . ';
		}';

			if ( class_exists( 'WooCommerce' ) ) {
				$custom_css .= '
		.products .shop-item .added_to_cart,
		.woocommerce-checkout #payment input[type=submit], .woocommerce-checkout input[type=submit],
		.woocommerce-cart table.shop_table td.actions input[type=submit],
		.woocommerce .cart-collaterals .cart_totals .checkout-button, .woocommerce button.button,
		.woocommerce div[id^=woocommerce_widget_cart].widget .buttons .button, .woocommerce div.product form.cart .button,
		.woocommerce #review_form #respond .form-submit , .added_to_cart.wc-forward, .woocommerce div#respond input#submit,
		.woocommerce a.button {
			font-family: ' . $hestia_body_font . ';
		}';
			}
		}

		wp_add_inline_style( 'hestia_style', $custom_css );
	}

	add_action( 'wp_enqueue_scripts', 'hestia_fonts_inline_style' );
}

if ( ! function_exists( 'hestia_typography_inline_style' ) ) {
	/**
	 * Add inline style for font sizes.
	 *
	 * @since 1.1.48
	 */
	function hestia_typography_inline_style() {

		$custom_css = '';

		/**
		 * Title control [Posts & Pages]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_header_titles_fs', 'hestia_get_header_titles_style' );

		/**
		 * Headings control [Posts & Pages]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_post_page_headings_fs', 'hestia_get_post_page_headings_style' );

		/**
		 * Content control [Posts & Pages]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_post_page_content_fs', 'hestia_get_post_page_content_style' );

		/**
		 * Big Title Section / Header Slide [Frontpage sections]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_big_title_fs', 'hestia_get_big_title_content_style' );

		/**
		 * Titles control [Frontpage sections]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_section_primary_headings_fs', 'hestia_get_fp_titles_style' );

		/**
		 * Subitles control [Frontpage sections]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_section_secondary_headings_fs', 'hestia_get_fp_subtitles_style' );

		/**
		 * Content control [Blog, Frontpage & WooCommerce]
		 */
		$custom_css .= hestia_get_inline_style( 'hestia_section_content_fs', 'hestia_get_fp_content_style' );

		wp_add_inline_style( 'hestia_style', $custom_css );
	}

	add_action( 'wp_enqueue_scripts', 'hestia_typography_inline_style' );
}



/**
 * This function checks if the value stored in the customizer control named '$control_name' is a json object.
 * If the value is json it means that the customizer range control stores a value for every device ( mobile, tablet,
 * desktop). In this case, for each of those devices it calls '$function_name' that with the following parameters:
 * the device and the value for the control on that device.
 * '$function_name' returns css code that will be added to inline style.
 * If the value is not json then it's int and the '$function_name' function will be called just once for all three
 * devices.
 *
 * @param string $control_name Control name.
 * @param string $function_name Function to be called.
 *
 * @since 1.1.38
 * @return string
 */
function hestia_get_inline_style( $control_name, $function_name ) {
	$control_value = get_theme_mod( $control_name );
	if ( empty( $control_value ) ) {
		return '';
	}
	$custom_css = '';
	if ( hestia_is_json( $control_value ) ) {
		$control_value = json_decode( $control_value, true );
		if ( ! empty( $control_value ) ) {

			foreach ( $control_value as $key => $value ) {
				$custom_css .= call_user_func( $function_name, $value, $key );
			}
		}
	} else {
		$custom_css .= call_user_func( $function_name, $control_value );
	}

	return $custom_css;
}

/**
 * [Posts and Pages] Title font size.
 *
 * This function is called by hestia_get_inline_style to change the font size for:
 * pages/posts titles
 * Slider/Big title title/subtitle
 *
 * @param string $value Font value.
 */
function hestia_get_header_titles_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
			$v3 = ( 42 + (int) $value ) > 0 ? ( 42 + (int) $value ) : 0;
			break;
		case 'tablet':
		case 'mobile':
			$v3 = ( 42 + (int) $value ) > 0 ? ( 42 + (int) $value ) : 0;
			break;
	}
	$custom_css .= '
	.page-header.header-small .hestia-title,
	.page-header.header-small .title {
		font-size: ' . $v3 . 'px;
	}';

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}

/**
 * [Posts & Pages] Headings.
 * This function is called by hestia_get_inline_style to change the font size for:
 * headings ( h1 - h6 ) on pages and single post pages
 *
 * @param string $value Font value.
 */
function hestia_get_post_page_headings_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
			$v1 = ( 42 + (int) $value ) > 0 ? ( 42 + (int) $value ) : 0;
			$v2 = ( 37 + (int) $value ) > 0 ? ( 37 + (int) $value ) : 0;
			$v3 = ( 32 + (int) $value ) > 0 ? ( 32 + (int) $value ) : 0;
			$v4 = ( 27 + (int) $value ) > 0 ? ( 27 + (int) $value ) : 0;
			$v5 = ( 23 + (int) $value ) > 0 ? ( 23 + (int) $value ) : 0;
			$v6 = ( 18 + (int) $value ) > 0 ? ( 18 + (int) $value ) : 0;
			break;
		case 'tablet':
		case 'mobile':
			$v1 = ( 36 + (int) $value ) > 0 ? ( 36 + (int) $value ) : 0;
			$v2 = ( 32 + (int) $value ) > 0 ? ( 32 + (int) $value ) : 0;
			$v3 = ( 28 + (int) $value ) > 0 ? ( 28 + (int) $value ) : 0;
			$v4 = ( 24 + (int) $value ) > 0 ? ( 24 + (int) $value ) : 0;
			$v5 = ( 21 + (int) $value ) > 0 ? ( 21 + (int) $value ) : 0;
			$v6 = ( 18 + (int) $value ) > 0 ? ( 18 + (int) $value ) : 0;
			break;
	}

	if ( ! empty( $v1 ) ) {
		$custom_css .= '
		.single-post-wrap article h1,
		.page-content-wrap h1,
		.page-template-template-fullwidth article h1 {
			font-size: ' . intval( $v1 ) . 'px;
		}';
	}

	if ( ! empty( $v2 ) ) {
		$custom_css .= '
		.single-post-wrap article h2,
		.page-content-wrap h2,
		.page-template-template-fullwidth article h2 {
			font-size: ' . intval( $v2 ) . 'px;
		}';
	}

	if ( ! empty( $v3 ) ) {
		$custom_css .= '
		.single-post-wrap article h3,
		.page-content-wrap h3,
		.page-template-template-fullwidth article h3 {
			font-size: ' . intval( $v3 ) . 'px;
		}';
	}

	if ( ! empty( $v4 ) ) {
		$custom_css .= '
		.single-post-wrap article h4,
		.page-content-wrap h4,
		.page-template-template-fullwidth article h4 {
			font-size: ' . intval( $v4 ) . 'px;
		}';
	}

	if ( ! empty( $v5 ) ) {
		$custom_css .= '
		.single-post-wrap article h5,
		.page-content-wrap h5,
		.page-template-template-fullwidth article h5 {
			font-size: ' . intval( $v5 ) . 'px;
		}';
	}

	if ( ! empty( $v6 ) ) {
		$custom_css .= '
		.single-post-wrap article h6,
		.page-content-wrap h6,
		.page-template-template-fullwidth article h6 {
			font-size: ' . $v6 . 'px;
		}';
	}
	if ( function_exists( 'hestia_add_media_query' ) ) {
		$custom_css = hestia_add_media_query( $dimension, $custom_css );
	}

	return $custom_css;
}


/**
 * [Posts & Pages] Content.
 * This function is called by hestia_get_inline_style to change the font size for:
 * content ( p ) on pages
 * single post pages
 *
 * @param string $value Font value.
 */
function hestia_get_post_page_content_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
			$v1 = ( 18 + (int) $value ) > 0 ? ( 18 + (int) $value ) : 0;
			break;
		case 'tablet':
		case 'mobile':
			$v1 = ( 16 + (int) $value ) > 0 ? ( 16 + (int) $value ) : 0;
			break;
	}

	if ( ! empty( $v1 ) ) {
		$custom_css .= '.single-post-wrap article p, .page-content-wrap p, .single-post-wrap article ul, .page-content-wrap ul, .single-post-wrap article ol, .page-content-wrap ol, .single-post-wrap article dl, .page-content-wrap dl, .single-post-wrap article table, .page-content-wrap table, .page-template-template-fullwidth article p {
			font-size: ' . intval( $v1 ) . 'px;
		}';
	}

	if ( function_exists( 'hestia_add_media_query' ) ) {
		$custom_css = hestia_add_media_query( $dimension, $custom_css );
	}

	return $custom_css;
}

/**
 * [Frontpage Sections] Big Title Section / Header Slider.
 *
 * This function is called by hestia_get_inline_style to change big title/slider titles, the
 * subtitle and the button in the big title section.
 *
 * How to calculate values:
 * Hardcoded values (67, 18 and 14 on desktop or 36, 18, 14 on tablet and mobile) are the default values from css.
 * In this case 67 is for big title, 18 for subtitle and 14 for button.
 * The main formula for calculating is this:
 * $initial_value + ($variable_value / $correlation)
 * $initial_value -> value from css
 * $variable_value -> controls value that is between -25 and 25
 * $correlation -> this variable says we increase the value every X units.
 * There is another variable to set a lower limit. Just change the value compared to.
 *
 * @param string $value Font value.
 * @param string $dimension Dimension.
 */
function hestia_get_big_title_content_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
			$v1 = ( 67 + (int) $value ) > 0 ? ( 67 + (int) $value ) : 0;
			$v2 = ( 18 + intval( (int) $value / 8 ) ) > 0 ? ( 18 + intval( (int) $value / 8 ) ) : 0;
			$v3 = ( 14 + intval( (int) $value / 12 ) ) > 0 ? ( 14 + intval( (int) $value / 12 ) ) : 0;
			break;
		case 'tablet':
		case 'mobile':
			$v1 = ( 36 + intval( (int) $value / 4 ) ) > 0 ? ( 36 + intval( (int) $value / 4 ) ) : 0;
			$v2 = ( 18 + intval( (int) $value / 4 ) ) > 0 ? ( 18 + intval( (int) $value / 4 ) ) : 0;
			$v3 = ( 14 + intval( (int) $value / 6 ) ) > 0 ? ( 14 + intval( (int) $value / 6 ) ) : 0;
			break;
	}
	if ( ! empty( $v1 ) ) {
		$custom_css .= '#carousel-hestia-generic .hestia-title{
			font-size: ' . intval( $v1 ) . 'px;
		}';
	}
	if ( ! empty( $v2 ) ) {
		$custom_css .= '#carousel-hestia-generic span.sub-title{
			font-size: ' . intval( $v2 ) . 'px;
		}';
	}
	if ( ! empty( $v3 ) ) {
		$custom_css .= '#carousel-hestia-generic .btn{
			font-size: ' . intval( $v3 ) . 'px;
		}';
	}

	if ( function_exists( 'hestia_add_media_query' ) ) {
		$custom_css = hestia_add_media_query( $dimension, $custom_css );
	}

	return $custom_css;
}

/**
 * [Frontpage Sections] Frontpage Titles font size.
 *
 * This function is called by hestia_get_inline_style to change the font size for:
 * all frontpage sections titles and small headings ( Feature box title, Shop box title, Team box title, Testimonial box title, Blog box title )
 *
 * The main formula for calculating is this:
 * $initial_value + ($variable_value / $correlation)
 * $initial_value -> value from css
 * $variable_value -> controls value that is between -25 and 25
 * $correlation -> this variable says we increase the value every X units.
 * There is another variable to set a lower limit. Just change the value compared to.
 *
 * @param string $value Font value.
 */
function hestia_get_fp_titles_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
			$v1 = ( 37 + (int) $value ) > 18 ? ( 37 + (int) $value ) : 18;
			$v2 = ( 18 + intval( (int) $value / 3 ) ) > 14 ? ( 18 + intval( (int) $value / 3 ) ) : 14;
			$v3 = ( 23 + intval( (int) $value / 3 ) ) > 0 ? ( 23 + intval( (int) $value / 3 ) ) : 0;
			$h1 = ( 42 + intval( (int) $value / 3 ) ) > 0 ? ( 42 + intval( (int) $value / 3 ) ) : 0;
			$h2 = ( 37 + intval( (int) $value / 3 ) ) > 0 ? ( 37 + intval( (int) $value / 3 ) ) : 0;
			$h3 = ( 32 + intval( (int) $value / 3 ) ) > 0 ? ( 32 + intval( (int) $value / 3 ) ) : 0;
			$h4 = ( 27 + intval( (int) $value / 3 ) ) > 0 ? ( 27 + intval( (int) $value / 3 ) ) : 0;
			break;
		case 'tablet':
		case 'mobile':
			$v1 = ( 24 + (int) $value ) > 18 ? ( 24 + (int) $value ) : 18;
			$v2 = ( 18 + intval( (int) $value / 3 ) ) > 14 ? ( 18 + intval( (int) $value / 3 ) ) : 14;
			$v3 = ( 23 + intval( (int) $value / 3 ) ) > 0 ? ( 23 + intval( (int) $value / 3 ) ) : 0;
			$h1 = ( 42 + intval( (int) $value / 3 ) ) > 0 ? ( 42 + intval( (int) $value / 3 ) ) : 0;
			$h2 = ( 37 + intval( (int) $value / 3 ) ) > 0 ? ( 37 + intval( (int) $value / 3 ) ) : 0;
			$h3 = ( 32 + intval( (int) $value / 3 ) ) > 0 ? ( 32 + intval( (int) $value / 3 ) ) : 0;
			$h4 = ( 27 + intval( (int) $value / 3 ) ) > 0 ? ( 27 + intval( (int) $value / 3 ) ) : 0;
			break;
	}

	if ( ! empty( $v1 ) ) {
		$custom_css .= '
		section.hestia-features .hestia-title, 
		section.hestia-shop .hestia-title, 
		section.hestia-work .hestia-title, 
		section.hestia-team .hestia-title, 
		section.hestia-pricing .hestia-title, 
		section.hestia-ribbon .hestia-title, 
		section.hestia-testimonials .hestia-title, 
		section.hestia-subscribe h2.title, 
		section.hestia-blogs .hestia-title, 
		section.hestia-contact .hestia-title{
			font-size: ' . intval( $v1 ) . 'px;
		}';
	}

	if ( ! empty( $v2 ) ) {
		$custom_css .= '
		section.hestia-features .hestia-info h4.info-title, 
		section.hestia-shop h4.card-title, 
		section.hestia-team h4.card-title, 
		section.hestia-testimonials h4.card-title, 
		section.hestia-blogs h4.card-title, 
		section.hestia-contact h4.card-title, 
		section.hestia-contact .hestia-description h6{
			font-size: ' . intval( $v2 ) . 'px;
		}';
	}

	if ( ! empty( $v3 ) ) {
		$custom_css .= '	
		section.hestia-work h4.card-title, 
		section.hestia-contact .hestia-description h5{
			font-size: ' . intval( $v3 ) . 'px;
		}
		';
	}

	if ( ! empty( $h1 ) ) {
		$custom_css .= '
		section.hestia-contact .hestia-description h1{
			font-size: ' . intval( $h1 ) . 'px;
		}';
	}

	if ( ! empty( $h2 ) ) {
		$custom_css .= '
		section.hestia-contact .hestia-description h2{
			font-size: ' . intval( $h2 ) . 'px;
		}';
	}

	if ( ! empty( $h3 ) ) {
		$custom_css .= '
		section.hestia-contact .hestia-description h3{
			font-size: ' . intval( $h3 ) . 'px;
		}';
	}

	if ( ! empty( $h4 ) ) {
		$custom_css .= '
		section.hestia-contact .hestia-description h4{
			font-size: ' . intval( $h4 ) . 'px;
		}';
	}

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}


/**
 * [Frontpage Sections] Subtitles font size.
 *
 * This function is called by hestia_get_inline_style to change the font size for:
 * all frontpage sections subtitles
 *
 * The main formula for calculating is this:
 * $initial_value + ($variable_value / $correlation)
 * $initial_value -> value from css
 * $variable_value -> controls value that is between -25 and 25
 * $correlation -> this variable says we increase the value every X units.
 * There is another variable to set a lower limit. Just change the value compared to.
 *
 * @param string $value Font value.
 */
function hestia_get_fp_subtitles_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
		case 'tablet':
		case 'mobile':
			$v1 = ( 18 + intval( (int) $value / 3 ) ) > 12 ? ( 18 + intval( (int) $value / 3 ) ) : 12;
			break;
	}

	$custom_css .= ' 
	section.hestia-features h5.description,
	section.hestia-shop h5.description,
	section.hestia-work h5.description,
	section.hestia-team h5.description,
	section.hestia-testimonials h5.description,
	section.hestia-subscribe h5.subscribe-description,
	section.hestia-blogs h5.description,
	section.hestia-contact h5.description{
		font-size: ' . intval( $v1 ) . 'px;
	}';

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}

/**
 * [Frontpage Sections] Content font size.
 *
 * This function is called by hestia_get_inline_style to change the font size for:
 * all frontpage sections box content
 *
 * @param string $value Font value.
 */
function hestia_get_fp_content_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	switch ( $dimension ) {
		case 'desktop':
		case 'tablet':
		case 'mobile':
			$v1 = ( 16 + intval( (int) $value / 3 ) ) > 12 ? ( 16 + intval( (int) $value / 3 ) ) : 12;
			$v2 = ( 14 + intval( (int) $value / 3 ) ) > 12 ? ( 14 + intval( (int) $value / 3 ) ) : 12;
			$v3 = ( 12 + intval( (int) $value / 3 ) ) > 12 ? ( 12 + intval( (int) $value / 3 ) ) : 12;
			break;
	}

	if ( ! empty( $v1 ) ) {
		$custom_css .= '
		section.hestia-features .hestia-info p,
		section.hestia-shop .card-description p{
			font-size: ' . intval( $v1 ) . 'px;
		}';
	}

	if ( ! empty( $v2 ) ) {
		$custom_css .= '
		section.hestia-team p.card-description,
		section.hestia-pricing p.text-gray,
		section.hestia-testimonials p.card-description,
		section.hestia-blogs p.card-description,
		.hestia-contact p{
			font-size: ' . intval( $v2 ) . 'px;
		}';
	}

	if ( ! empty( $v3 ) ) {
		$custom_css .= '
		section.hestia-shop h6.category,
		section.hestia-work .label-primary,
		section.hestia-team h6.category,
		section.hestia-pricing .card-pricing h6.category,
		section.hestia-testimonials h6.category,
		section.hestia-blogs h6.category{
			font-size: ' . intval( $v3 ) . 'px;
		}';
	}

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}

/**
 * Check if a string is in json format
 *
 * @param  string $string Input.
 *
 * @since 1.1.38
 * @return bool
 */
function hestia_is_json( $string ) {
	return is_string( $string ) && is_array( json_decode( $string, true ) ) ? true : false;
}

/**
 * Function to import font sizes from old controls to new ones.
 *
 * @since 1.1.58
 */
function hestia_sync_new_fs() {
	$execute = get_option( 'hestia_sync_font_sizes' );
	if ( $execute !== false ) {
		return;
	}
	$headings_fs_old = get_theme_mod( 'hestia_headings_font_size' );
	$body_fs_old     = get_theme_mod( 'hestia_body_font_size' );
	if ( empty( $body_fs_old ) && empty( $headings_fs_old ) ) {
		return;
	}

	if ( ! empty( $headings_fs_old ) ) {
		$decoded = hestia_calculate_fs_value( $headings_fs_old, 37 );
		set_theme_mod( 'hestia_section_primary_headings_fs', $decoded );
		set_theme_mod( 'hestia_section_secondary_headings_fs', $decoded );
		set_theme_mod( 'hestia_header_titles_fs', $decoded );
		set_theme_mod( 'hestia_post_page_headings_fs', $decoded );
	}

	if ( ! empty( $body_fs_old ) ) {
		$decoded = hestia_calculate_fs_value( $body_fs_old, 12 );
		set_theme_mod( 'hestia_section_content_fs', $decoded );
		set_theme_mod( 'hestia_post_page_content_fs', $decoded );
	}
	update_option( 'hestia_sync_font_sizes', true );

}
add_action( 'after_setup_theme', 'hestia_sync_new_fs' );

/**
 * Calculate new value for the new font size control based on the old control.
 *
 * @param string $old_value Value from the old control.
 * @param int    $decrease_rate Value to substract from the old value.
 */
function hestia_calculate_fs_value( $old_value, $decrease_rate ) {
	$decoded = json_decode( $old_value );
	if ( ! hestia_is_json( $old_value ) ) {
		$tmp_array = array(
			'desktop' => floor( $decoded - $decrease_rate ) > 25 ? 25 : ( floor( $decoded - $decrease_rate ) < - 25 ? - 25 : floor( $decoded - $decrease_rate ) ),
			'mobile'  => 0,
			'tablet'  => 0,
		);
		$decoded   = json_encode( $tmp_array );
	} else {
		$decoded->desktop = floor( $decoded->desktop - $decrease_rate ) > 25 ? 25 : ( floor( $decoded->desktop - $decrease_rate ) < - 25 ? - 25 : floor( $decoded->desktop - $decrease_rate ) );
		$decoded->tablet  = floor( $decoded->tablet - $decrease_rate ) > 25 ? 25 : ( floor( $decoded->tablet - $decrease_rate ) < - 25 ? - 25 : floor( $decoded->tablet - $decrease_rate ) );
		$decoded->mobile  = floor( $decoded->mobile - $decrease_rate ) > 25 ? 25 : ( floor( $decoded->mobile - $decrease_rate ) < - 25 ? - 25 : floor( $decoded->mobile - $decrease_rate ) );
		$decoded          = json_encode( $decoded );
	}
	return $decoded;
}


/**
 * This function is called by each function that adds css if the control have media queries enabled.
 *
 * @param string $dimension Query dimension.
 * @param string $custom_css Css.
 *
 * @return string
 */
function hestia_add_media_query( $dimension, $custom_css ) {
	switch ( $dimension ) {
		case 'desktop':
			$custom_css = '@media (min-width: 769px){' . $custom_css . '}';
			break;
			break;
		case 'tablet':
			$custom_css = '@media (max-width: 768px){' . $custom_css . '}';
			break;
		case 'mobile':
			$custom_css = '@media (max-width: 480px){' . $custom_css . '}';
			break;
	}

	return $custom_css;
}
