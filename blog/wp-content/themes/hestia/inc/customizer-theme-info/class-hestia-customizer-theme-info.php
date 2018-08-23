<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @package Hestia Pro
 */

/**
 * Class Hestia_Customizer_Theme_Info
 *
 * @since  1.0.0
 * @access public
 */
final class Hestia_Customizer_Theme_Info {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param  object $manager - the wp_customizer object.
	 *
	 * @return void
	 */
	public function sections( $manager ) {

		if ( class_exists( 'Hestia_Customizer_Theme_Info_Main' ) ) {
			// Register custom section types.
			$manager->register_section_type( 'Hestia_Customizer_Theme_Info_Main' );

			// Main Documentation Link In Customizer Root.
			$manager->add_section(
				new Hestia_Customizer_Theme_Info_Main(
					$manager, 'hestia-theme-info', array(
						'theme_info_title' => esc_html__( 'Hestia', 'hestia' ),
						'label_url'        => esc_url( 'http://docs.themeisle.com/article/569-hestia-documentation' ),
						'label_text'       => esc_html__( 'Documentation', 'hestia' ),
					)
				)
			);
		}

		if ( class_exists( 'Hestia_Customizer_Theme_Info_Section' ) ) {
			// Register custom section types.
			$manager->register_section_type( 'Hestia_Customizer_Theme_Info_Section' );

			// Frontpage Sections Upsell.
			$manager->add_section(
				new Hestia_Customizer_Theme_Info_Section(
					$manager, 'hestia-theme-info-section', array(
						'panel'              => 'hestia_frontpage_sections',
						'priority'           => 500,
						'options'            => array(
							esc_html__( 'Jetpack Portfolio', 'hestia' ),
							esc_html__( 'Pricing Plans Section', 'hestia' ),
							esc_html__( 'Section Reordering', 'hestia' ),
						),

						'button_url'         => esc_url( 'https://themeisle.com/themes/hestia-pro/upgrade/' ),
						'button_text'        => esc_html__( 'Get the PRO version!', 'hestia' ),
						'explained_features' => array(
							esc_html__( 'Portfolio section with two possible layouts.', 'hestia' ),
							esc_html__( 'A fully customizable pricing plans section.', 'hestia' ),
							esc_html__( 'The ability to reorganize your Frontpage sections more easily and quickly.', 'hestia' ),
						),
					)
				)
			);
		}
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'hestia_theme-info-js', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-theme-info/js/hestia-theme-info-customize-controls.js', array( 'customize-controls' ), HESTIA_VERSION );

		wp_enqueue_style( 'hestia_theme-info-style', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-theme-info/css/hestia-theme-info-customize-controls.css', array(), HESTIA_VERSION );
	}
}

Hestia_Customizer_Theme_Info::get_instance();
