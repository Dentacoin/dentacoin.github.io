<?php
/**
 * Tabs test file
 *
 * @package Hestia
 * @since 1.1.43
 */

/**
 * Hook controls for Header to Customizer.
 *
 * @since 1.1.40
 */
function hestia_tabs_customize_register( $wp_customize ) {

	if ( class_exists( 'Hestia_Customize_Control_Tabs' ) ) {

		// Typography Tabs
		$wp_customize->add_setting(
			'hestia_typography_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Tabs(
				$wp_customize, 'hestia_typography_tabs', array(
					'section' => 'hestia_typography',
					'tabs'    => array(
						'font_family' => array(
							'nicename' => esc_html__( 'font family', 'hestia' ),
							'icon'     => 'font',
							'controls' => array(
								'hestia_headings_font',
								'hestia_body_font',
								'hestia_font_subsets',
							),
						),
						'font_sizes'  => array(
							'nicename' => esc_html__( 'font size', 'hestia' ),
							'icon'     => 'text-height',
							'controls' => array(
								'hestia_posts_and_pages_title',
								'hestia_header_titles_fs',
								'hestia_post_page_headings_fs',
								'hestia_post_page_content_fs',

								'hestia_frontpage_sections_title',
								'hestia_big_title_fs',
								'hestia_section_primary_headings_fs',
								'hestia_section_secondary_headings_fs',
								'hestia_section_content_fs',

								'hestia_generic_title',
								'hestia_menu_fs',
							),
						),
					),
				)
			)
		);

		// Very Top Bar Tabs
		$wp_customize->add_setting(
			'hestia_very_top_bar_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Tabs(
				$wp_customize, 'hestia_very_top_bar_tabs', array(
					'section' => 'hestia_top_bar',
					'tabs'    => array(
						'general'    => array(
							'nicename' => esc_html__( 'General Settings', 'hestia' ),
							'controls' => array(
								'hestia_top_bar_hide',
								'hestia_top_bar_alignment',
								'hestia_link_to_top_menu',
								'widgets',
							),
						),
						'appearance' => array(
							'nicename' => esc_html__( 'Appearance Settings', 'hestia' ),
							'controls' => array(
								'hestia_top_bar_text_color',
								'hestia_top_bar_link_color',
								'hestia_top_bar_link_color_hover',
								'hestia_top_bar_background_color',
							),
						),
					),
				)
			)
		);

		// Subscribe Section Tabs
		$wp_customize->add_setting(
			'hestia_subscribe_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Tabs(
				$wp_customize, 'hestia_subscribe_tabs', array(
					'section' => 'hestia_subscribe',
					'tabs'    => array(
						'general'    => array(
							'nicename' => esc_html__( 'General Settings', 'hestia' ),
							'controls' => array(
								'hestia_subscribe_hide',
								'hestia_subscribe_background',
								'hestia_subscribe_title',
								'hestia_subscribe_subtitle',
								'widgets',
							),
						),
						'sendinblue' => array(
							'nicename' => esc_html__( 'SendinBlue plugin', 'hestia' ),
							'controls' => array(
								'hestia_subscribe_info',
							),
						),
					),
				)
			)
		);

		// Contact Section Tabs
		$wp_customize->add_setting(
			'hestia_contact_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Tabs(
				$wp_customize, 'hestia_contact_tabs', array(
					'section' => 'hestia_contact',
					'tabs'    => array(
						'general' => array(
							'nicename' => esc_html__( 'General Settings', 'hestia' ),
							'icon'     => 'cogs',
							'controls' => array(
								'hestia_contact_hide',
								'hestia_contact_title',
								'hestia_contact_subtitle',
								'hestia_contact_background',
								'hestia_contact_area_title',
							),
						),
						'contact' => array(
							'nicename' => esc_html__( 'Contact Content', 'hestia' ),
							'icon'     => 'newspaper-o',
							'controls' => array(
								'hestia_contact_info',
								'hestia_contact_content_new',
								'hestia_contact_form_shortcode',
							),
						),
					),
				)
			)
		);

		// Shop Section Tabs
		$wp_customize->add_setting(
			'hestia_shop_tabs', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Tabs(
				$wp_customize, 'hestia_shop_tabs', array(
					'section' => 'hestia_shop',
					'tabs'    => array(
						'general' => array(
							'nicename' => esc_html__( 'General Settings', 'hestia' ),
							'icon'     => 'cogs',
							'controls' => array(
								'hestia_shop_hide',
								'hestia_shop_title',
								'hestia_shop_subtitle',
								'hestia_shop_items',
								'hestia_shop_categories',
							),
						),
						'contact' => array(
							'nicename' => esc_html__( 'Products', 'hestia' ),
							'icon'     => 'gift',
							'controls' => array(
								'hestia_shop_order',
								'hestia_shop_shortcode',
							),
						),
					),
				)
			)
		);

		$control_handle = $wp_customize->get_control( 'hestia_very_top_bar_tabs' );
		if ( ! empty( $control_handle ) ) {
			$control_handle->section  = 'sidebar-widgets-sidebar-top-bar';
			$control_handle->priority = -100;
		}
		$control_handle = $wp_customize->get_control( 'hestia_subscribe_tabs' );
		if ( ! empty( $control_handle ) ) {
			$control_handle->section  = 'sidebar-widgets-subscribe-widgets';
			$control_handle->priority = -100;
		}
	}

	if ( class_exists( 'Hestia_Customize_Control_Scroll' ) ) {
		$scroller = new Hestia_Customize_Control_Scroll();
	}
}
add_action( 'customize_register', 'hestia_tabs_customize_register' );
