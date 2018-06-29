<?php
/**
 * Pagebuilder compatibility addition for front page.
 *
 * @package Hestia
 * @since Hestia 1.1.37
 */

if ( ! function_exists( 'hestia_elementor_flag' ) ) {

	/**
	 * Add a flag if the user has not had elementor before.
	 */
	function hestia_elementor_flag() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			update_option( 'hestia_had_elementor', 'no' );
		}
	}
}
add_action( 'after_switch_theme', 'hestia_elementor_flag' );

// Check if page builder plugins are available.
if ( ! defined( 'ELEMENTOR_VERSION' ) && ! defined( 'FL_BUILDER_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'hestia_pagebuilder_enqueue' ) ) {
	/**
	 * Enqueue Pagebuilder Specific Script
	 */
	function hestia_pagebuilder_enqueue() {
		$had_elementor = get_option( 'hestia_had_elementor' );

		if ( ( hestia_is_beaver_preview() || hestia_is_elementor_preview() ) && is_front_page() ) {
			wp_enqueue_script( 'hestia-builder-integration', get_template_directory_uri() . '/assets/js/hestia-pagebuilder.js', array(), HESTIA_VERSION );
			wp_localize_script(
				'hestia-builder-integration', 'hestiaBuilderIntegration', array(
					'ajaxurl'    => admin_url( 'admin-ajax.php' ),
					'nonce'      => wp_create_nonce( 'hestia-pagebuilder-nonce' ),
					'hideString' => esc_html__( 'Disable section', 'hestia' ),
				)
			);
		}

		// Ask user if he wants to disable default styling for plugin.
		if ( $had_elementor == 'no' && hestia_is_elementor_preview() ) {
			wp_enqueue_script( 'hestia-elementor-notice', get_template_directory_uri() . '/assets/js/hestia-elementor-notice.js', array(), HESTIA_VERSION );
			wp_localize_script(
				'hestia-elementor-notice', 'hestiaElementorNotice', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'hestia-elementor-notice-nonce' ),
				)
			);
		}
	}
}// End if().

add_action( 'wp_enqueue_scripts', 'hestia_pagebuilder_enqueue' );

if ( ! function_exists( 'hestia_elementor_default_styles' ) ) {
	/**
	 * Enqueue default hestia styles for elementor.
	 */
	function hestia_elementor_default_styles() {
		$disabled_color_schemes      = get_option( 'elementor_disable_color_schemes' );
		$disabled_typography_schemes = get_option( 'elementor_disable_typography_schemes' );

		if ( $disabled_color_schemes === 'yes' && $disabled_typography_schemes === 'yes' ) {
			wp_enqueue_style( 'hestia-elementor-style', get_template_directory_uri() . '/assets/css/page-builder-style.css', array(), HESTIA_VERSION );
		}
	}
}

if ( class_exists( 'Elementor\Plugin' ) ) {
	add_action( 'elementor/frontend/after_enqueue_styles', 'hestia_elementor_default_styles' );
	add_action( 'elementor/editor/after_enqueue_scripts', 'hestia_elementor_enqueue' );
}

if ( ! function_exists( 'hestia_pagebuilder_hide_frontpage_section' ) ) {
	/**
	 * Section deactivation
	 */
	function hestia_pagebuilder_hide_frontpage_section() {
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'hestia-pagebuilder-nonce' ) ) {
			return;
		}
		$section = $_POST['section'];
		if ( ! empty( $section ) ) {
			if ( $section == 'products' ) {
				$theme_mod = esc_html( 'hestia_shop_hide' );
			} else {
				$theme_mod = esc_html( 'hestia_' . $section . '_hide' );
			}
			if ( ! empty( $theme_mod ) ) {
				set_theme_mod( $theme_mod, 1 );
			}
		}
		die();
	}
}
add_action( 'wp_ajax_hestia_pagebuilder_hide_frontpage_section', 'hestia_pagebuilder_hide_frontpage_section' );

if ( ! function_exists( 'hestia_elementor_deactivate_default_styles' ) ) {
	/**
	 * Elementor default styles disabling.
	 */
	function hestia_elementor_deactivate_default_styles() {
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'hestia-elementor-notice-nonce' ) ) {
			return;
		}
		$reply = $_POST['reply'];
		if ( ! empty( $reply ) ) {
			if ( $reply == 'yes' ) {
				update_option( 'elementor_disable_color_schemes', 'yes' );
				update_option( 'elementor_disable_typography_schemes', 'yes' );
			}
			update_option( 'hestia_had_elementor', 'yes' );
		}
		die();
	}
}
add_action( 'wp_ajax_hestia_elementor_deactivate_default_styles', 'hestia_elementor_deactivate_default_styles' );

if ( ! function_exists( 'hestia_elementor_enqueue' ) ) {
	/**
	 * Enqueue Pagebuilder Specific Script
	 */
	function hestia_elementor_enqueue() {
		$had_elementor = get_option( 'hestia_had_elementor' );

		// Ask user if he wants to disable default styling for plugin.
		if ( $had_elementor == 'no' && hestia_is_elementor_preview() ) {
			wp_enqueue_script( 'hestia-elementor-notice', get_template_directory_uri() . '/assets/js/hestia-elementor-notice.js', array(), HESTIA_VERSION );
			wp_localize_script(
				'hestia-elementor-notice', 'hestiaElementorNotice', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'hestia-elementor-notice-nonce' ),
				)
			);
		}
	}
}// End if().

if ( ! function_exists( 'hestia_is_elementor_preview' ) ) {
	/**
	 * Check if we're in Elementor Preview.
	 *
	 * @return bool
	 */
	function hestia_is_elementor_preview() {
		if ( class_exists( 'Elementor\Plugin' ) ) {
			if ( Elementor\Plugin::$instance->preview->is_preview_mode() == true ) {
				return true;
			}
		}
		return false;
	}
}

if ( ! function_exists( 'hestia_is_beaver_preview' ) ) {
	/**
	 * Check if we're in Beaver Builder Preview.
	 *
	 * @return bool
	 */
	function hestia_is_beaver_preview() {
		if ( class_exists( 'FLBuilderModel' ) ) {
			if ( FLBuilderModel::is_builder_active() == true ) {
				return true;
			}
		}
		return false;
	}
}
