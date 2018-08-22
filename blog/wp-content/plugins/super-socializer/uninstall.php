<?php
//if uninstall not called from WordPress, exit
if(!defined('WP_UNINSTALL_PLUGIN')){
	exit();
}
$theChampGeneralOptions = get_option('the_champ_general');
if(isset($theChampGeneralOptions['delete_options'])){
	global $wpdb;
	$theChampOptions = array(
		'the_champ_login',
		'the_champ_facebook',
		'the_champ_sharing',
		'the_champ_counter',
		'the_champ_general',
		'the_champ_ss_version',
		'the_champ_feedback_submitted',
		'heateor_ss_browser_notification_read',
		'widget_thechamplogin',
		'widget_thechamphorizontalsharing',
		'widget_thechampverticalsharing',
		'widget_thechamphorizontalcounter',
		'widget_thechampverticalcounter'
	);
	// For Multisite
	if(function_exists('is_multisite') && is_multisite()){
		// For Multisite
		$theChampBlogIds = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		$theChampOriginalBlogId = $wpdb->blogid;
		foreach($theChampBlogIds as $blogId){
			switch_to_blog($blogId);
			foreach($theChampOptions as $option){
				delete_site_option($option);
			}
		}
		switch_to_blog($theChampOriginalBlogId);
	}else{
		foreach($theChampOptions as $option){
			delete_option( $option );
		}
	}
}