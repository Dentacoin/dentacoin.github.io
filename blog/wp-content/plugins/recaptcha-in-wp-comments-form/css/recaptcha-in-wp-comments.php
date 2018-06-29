<?php
/*
Plugin Name:	reCAPTCHA in WP comments form
Plugin URI:  	http://www.joanmiquelviade.com/plugin/google-recaptcha-in-wp-comments-form/
Description:	reCAPTCHA in WP comments form plugin is an ANTISPAM tool that adds a Google reCAPTCHA field inside the comments form of your WP theme when the user is not logged in so that, it protects your site from the spammers. Additionaly, in case of that any spam robot or user manually breaks reCAPTCHA field, the plugin introduces a second verification process that allows you to decide what you want to do with those comments.
Version: 		0.0.9.0.2
Author:			Joan Miquel Viad&eacute;
Author URI:		http://www.joanmiquelviade.com
License: 		GPL2
License URI: 	https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: 	/languages
Text Domain: 	recaptcha-in-wp-comments-form
*/

define( '__GRIWPC__',		_x( 'reCAPTCHA in WP comments form', 'Title name of plugin', 'recaptcha-in-wp-comments-form' ) );
define( '__GRIWPC_SHORT__',	_x( 'reCAPTCHA in Comments', 'Menu name of plugin', 'recaptcha-in-wp-comments-form' ) );
define( '__GRIWPC_KEY__', 	'griwpc' );
define( '__GRIWPC_VER__',	'0.0.9.0.2' );
define( '__GRIWPC_URL__',	plugin_dir_url  ( __FILE__ ) );
define( '__GRIWPC_ABS__',	plugin_dir_path ( __FILE__ ) );

define( '__GRIWPC_RECAPTCHA_SITE__',    'https://www.google.com/recaptcha/intro/index.html' );
define( '__GRIWPC_RECAPTCHA_SHOW__', 	'https://www.google.com/recaptcha/api.js?' );
define( '__GRIWPC_RECAPTCHA_VERIFY__',  'https://www.google.com/recaptcha/api/siteverify?' );
define( '__GRIWPC_RECAPTCHA_DOCS__',    'https://developers.google.com/recaptcha/docs/start' );

define( '__GRIWPC_WP_SITE__', 			'https://wordpress.org/plugins/recaptcha-in-wp-comments-form/' );

define( '__GRIWPC_SITE__', 				'http://www.joanmiquelviade.com/plugin/google-recaptcha-in-wp-comments-form/' );
define( '__GRIWPC_SITE_CONF__', 		'http://www.joanmiquelviade.com/plugin/google-recaptcha-in-wp-comments-form/plugin-settings-page/' );
define( '__GRIWPC_SITE_KEYP__',         'http://www.joanmiquelviade.com/plugin/google-recaptcha-in-wp-comments-form/getting-the-google-api-key-pair/' );

require_once ( __GRIWPC_ABS__ . '/includes/tools.php' );
require_once ( __GRIWPC_ABS__ . '/includes/settings.php' );
require_once ( __GRIWPC_ABS__ . '/includes/interfaces.php' );

$settingsClass = new griwpc_settings();

if ( is_admin() ) {
	
	require_once ( __GRIWPC_ABS__ . '/includes/messages.php' );

	if ( griwpc_tools::check_google_API_keys_pair( $settingsClass->get_options() ) ) {
		
		require_once ( __GRIWPC_ABS__ . '/includes/recaptcha.php' );
		require_once ( __GRIWPC_ABS__ . '/includes/backend-interface.php'   );
		new griwpc_standard_backend_interface ( __GRIWPC_VER__, $settingsClass );
		
	} else {
		
		require_once ( __GRIWPC_ABS__ . '/includes/installation-interface.php' );
		new griwpc_installation_interface ( __GRIWPC_VER__, $settingsClass );
		
	}
	
} else {
	
	require_once ( __GRIWPC_ABS__ . '/includes/recaptcha.php' );
	require_once ( __GRIWPC_ABS__ . '/includes/frontend-interface.php' );
	new griwpc_frontend_interface( __GRIWPC_VER__, $settingsClass );
	add_action ( 'pre_comment_on_post', array ( 'griwpc_recaptcha', 'after_griwpc_verify_reCAPTCHA' ), 10, 1 );
	
}
add_action( 'wp_ajax_griwpc_verify_recaptcha', 		  array ( 'griwpc_recaptcha', 'griwpc_verify_reCAPTCHA' ));
add_action( 'wp_ajax_nopriv_griwpc_verify_recaptcha', array ( 'griwpc_recaptcha', 'griwpc_verify_reCAPTCHA' ));

// Initial message on activation
register_activation_hook( __FILE__ , array( 'griwpc_tools', 'on_activation' ));
add_action ('admin_notices', 		 array( 'griwpc_tools', 'on_activation_msg'));

function griwpc_translations() {
    load_plugin_textdomain( 'recaptcha-in-wp-comments-form' );
}
add_action('plugins_loaded', 'griwpc_translations');