<?php
/**
 * Plugin install helper.
 *
 * @package Hestia
 * @since Hestia 1.1.31
 */

/**
 * Class Hestia_Plugin_Install_Helper
 */
class Hestia_Plugin_Install_Helper {
	/**
	 * Instance of class.
	 *
	 * @var bool $instance instance variable.
	 */
	private static $instance;

	/**
	 * Check if instance already exists.
	 *
	 * @return Hestia_Plugin_Install_Helper
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Hestia_Plugin_Install_Helper ) ) {
			self::$instance = new Hestia_Plugin_Install_Helper;
		}

		return self::$instance;
	}

	/**
	 * Generate action button html.
	 *
	 * @param string $slug plugin slug.
	 *
	 * @return string
	 */
	public function get_button_html( $slug ) {
		$button = '';
		$state  = $this->check_plugin_state( $slug );
		if ( ! empty( $slug ) ) {

			$button .= '<div class=" plugin-card-' . $slug . '" style="padding: 8px 0 5px;">';

			switch ( $state ) {
				case 'install':
					$nonce   = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'from'   => 'import',
								'plugin' => $slug,
							),
							network_admin_url( 'update.php' )
						),
						'install-plugin_' . $slug
					);
					$button .= '<a data-slug="' . $slug . '" class="install-now hestia-install-plugin button  " href="' . esc_url( $nonce ) . '" data-name="' . $slug . '" aria-label="Install ' . $slug . '">' . __( 'Install and activate', 'hestia' ) . '</a>';
					break;

				case 'activate':
					if ( $slug == 'mailin' ) {
						$plugin_link_suffix = $slug . '/sendinblue.php';
					} else {
						$plugin_link_suffix = $slug . '/' . $slug . '.php';
					}

					$nonce = add_query_arg(
						array(
							'action'        => 'activate',
							'plugin'        => rawurlencode( $plugin_link_suffix ),
							'plugin_status' => 'all',
							'paged'         => '1',
							'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin_link_suffix ),
						), network_admin_url( 'plugins.php' )
					);

					$button .= '<a data-slug="' . $slug . '" class="activate-now button button-primary" href="' . esc_url( $nonce ) . '" aria-label="Activate ' . $slug . '">' . __( 'Activate', 'hestia' ) . '</a>';
					break;
			}// End switch().
			$button .= '</div>';
		}// End if().

		return $button;
	}

	/**
	 * Check plugin state.
	 *
	 * @param string $slug plugin slug.
	 *
	 * @return bool
	 */
	private function check_plugin_state( $slug ) {
		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) || file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/index.php' ) ) {
			$needs = ( is_plugin_active( $slug . '/' . $slug . '.php' ) || is_plugin_active( $slug . '/index.php' ) || is_plugin_active( $slug . '/sendinblue.php' ) ) ? 'deactivate' : 'activate';

			return $needs;
		} else {
			return 'install';
		}
	}

	/**
	 * Enqueue Function.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'plugin-install' );
		wp_enqueue_script( 'updates' );
		wp_enqueue_script( 'hestia-plugin-install-helper', get_template_directory_uri() . '/inc/plugin-install/js/hestia-plugin-install.js', array( 'jquery' ), HESTIA_VERSION, true );
		wp_localize_script(
			'hestia-plugin-install-helper', 'hestia_plugin_helper',
			array(
				'activating' => esc_html__( 'Activating ', 'hestia' ),
			)
		);
		wp_localize_script(
			'hestia-plugin-install-helper', 'pagenow',
			array( 'import' )
		);
	}
}
