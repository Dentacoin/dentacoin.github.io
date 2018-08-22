<?php
if( !defined('ABSPATH') ){ exit();}
function lnap_free_network_install($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				lnap_install_free();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	lnap_install_free();
}

function lnap_install_free()
{
	/*$pluginName = 'xyz-wp-smap/xyz-wp-smap.php';
	if (is_plugin_active($pluginName)) {
		wp_die( "The plugin LinkedIn Auto Publish cannot be activated unless the premium version of this plugin is deactivated. Back to <a href='".admin_url()."plugins.php'>Plugin Installation</a>." );
	}*/
	
	global $current_user;
	wp_get_current_user();
	if(get_option('xyz_credit_link')=="")
	{
		add_option("xyz_credit_link", '0');
	}
	
	$lnap_installed_date = get_option('lnap_installed_date');
	if ($lnap_installed_date=="") {
		$lnap_installed_date = time();
		update_option('lnap_installed_date', $lnap_installed_date);
	}
	
	add_option('xyz_lnap_application_lnarray', '');
	add_option('xyz_lnap_ln_shareprivate', '0');
	add_option('xyz_lnap_ln_sharingmethod', '0');
	add_option('xyz_lnap_lnapikey', '');
	add_option('xyz_lnap_lnapisecret', '');
	
// 	add_option('xyz_lnap_lnoauth_verifier', '');
// 	add_option('xyz_lnap_lnoauth_token', '');
// 	add_option('xyz_lnap_lnoauth_secret', '');
	add_option('xyz_lnap_lnpost_permission', '1');
	add_option('xyz_lnap_lnaf', '1');
	add_option('xyz_lnap_lnmessage', '{POST_TITLE} - {PERMALINK}');
	add_option('xyz_lnap_future_to_publish', '1');
	add_option('xyz_lnap_apply_filters', '');
	

	$version=get_option('xyz_lnap_free_version');
	$currentversion=xyz_lnap_plugin_get_version();
	update_option('xyz_lnap_free_version', $currentversion);
	
	add_option('xyz_lnap_include_pages', '0');
	add_option('xyz_lnap_include_posts', '1');
	add_option('xyz_lnap_include_categories', 'All');
	add_option('xyz_lnap_include_customposttypes', '');
	add_option('xyz_lnap_peer_verification', '1');
	add_option('xyz_lnap_post_logs', '');
	add_option('xyz_lnap_premium_version_ads', '1');
	add_option('xyz_lnap_default_selection_edit', '0');
// 	add_option('xyz_lnap_utf_decode_enable', '0');
	add_option('xyz_lnap_dnt_shw_notice','0');
	if(get_option('xyz_lnap_credit_dismiss') == "")
		add_option("xyz_lnap_credit_dismiss",0);
}


register_activation_hook(XYZ_LNAP_PLUGIN_FILE,'lnap_free_network_install');
?>