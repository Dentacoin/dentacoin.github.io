<?php
if( !defined('ABSPATH') ){ exit();}
function lnap_free_network_destroy($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				lnap_free_destroy();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	lnap_free_destroy();
}

function lnap_free_destroy()
{
	global $wpdb;
	
	if(get_option('xyz_credit_link')=="lnap")
	{
		update_option("xyz_credit_link", '0');
	}
	
	delete_option('xyz_lnap_future_to_publish');
	delete_option('xyz_lnap_apply_filters');
	delete_option('xyz_lnap_application_lnarray');
	delete_option('xyz_lnap_ln_shareprivate');
	delete_option('xyz_lnap_ln_sharingmethod');
	delete_option('xyz_lnap_lnapikey');
	delete_option('xyz_lnap_lnapisecret');
	delete_option('xyz_lnap_lnpost_permission');
	delete_option('xyz_lnap_lnaf');
	delete_option('xyz_lnap_lnmessage');
	
	delete_option('xyz_lnap_free_version');
	delete_option('xyz_lnap_include_pages');
	delete_option('xyz_lnap_include_posts');
	delete_option('xyz_lnap_include_categories');
	delete_option('xyz_lnap_include_customposttypes');
	delete_option('xyz_lnap_peer_verification');
	delete_option('xyz_lnap_post_logs');
	delete_option('xyz_lnap_premium_version_ads');
	delete_option('xyz_lnap_default_selection_edit');
// 	delete_option('xyz_lnap_utf_decode_enable');
	delete_option('lnap_installed_date');
	delete_option('xyz_lnap_dnt_shw_notice');
	delete_option('xyz_lnap_credit_dismiss');
}

register_uninstall_hook(XYZ_LNAP_PLUGIN_FILE,'lnap_free_network_destroy');


?>