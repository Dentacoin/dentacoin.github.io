<?php
/**
 * Customizer info singleton class file.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Hestia_Customizer_Info_Singleton {

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
	 * @modified 1.1.40
	 * @access public
	 * @param  object $manager WordPress customizer object.
	 * @return void
	 */
	public function sections( $manager ) {

		if ( ! class_exists( 'Hestia_Customizer_Info' ) ) {
			return;
		}

		if ( ! hestia_woocommerce_check() ) {
			$manager->add_section(
				new Hestia_Customizer_Info(
					$manager, 'hestia_info_woocommerce', array(
						'section_text'        =>
						sprintf(
							/* translators: %1$s is Plugin Name */
							esc_html__( 'To have access to a shop section please install and configure %1$s.', 'hestia' ),
							esc_html__( 'WooCommerce plugin', 'hestia' )
						),
						'slug'                => 'woocommerce',
						'panel'               => 'hestia_frontpage_sections',
						'priority'            => 451,
						'capability'          => 'install_plugins',
						'hide_notice'         => (bool) get_option( 'dismissed-hestia_info_woocommerce', false ),
						'button_screenreader' => '',
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

		wp_enqueue_script( 'hestia_customizer-info-js', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-info/js/customizer-info-controls.js', array( 'customize-controls' ), HESTIA_VERSION );
		wp_localize_script(
			'hestia_customizer-info-js', 'requestpost', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}

Hestia_Customizer_Info_Singleton::get_instance();
