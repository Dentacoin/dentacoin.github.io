<?php
/**
 * Utils functions used in about page and in customizer notifications.
 *
 * @package hestia
 */

/**
 * Create the install/activate button link for plugins
 *
 * @param plugin-state $state The plugin state (not installed/inactive/active).
 * @param plugin-slug  $slug The plugin slug.
 */
function create_action_link( $state, $slug ) {
	switch ( $state ) {
		case 'install':
			return wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'install-plugin',
						'plugin' => $slug,
					),
					network_admin_url( 'update.php' )
				),
				'install-plugin_' . $slug
			);
			break;
		case 'deactivate':
			return add_query_arg(
				array(
					'action'        => 'deactivate',
					'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
					'plugin_status' => 'all',
					'paged'         => '1',
					'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $slug . '/' . $slug . '.php' ),
				), network_admin_url( 'plugins.php' )
			);
			break;
		case 'activate':
			return add_query_arg(
				array(
					'action'        => 'activate',
					'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
					'plugin_status' => 'all',
					'paged'         => '1',
					'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' ),
				), network_admin_url( 'plugins.php' )
			);
			break;
	}// End switch().
}
