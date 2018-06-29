<?php
if( !defined('ABSPATH') ){ exit();}
add_action('admin_menu', 'xyz_lnap_menu');

function xyz_lnap_add_admin_scripts()
{
	wp_enqueue_script('jquery');
	wp_register_script( 'xyz_notice_script_lnap', plugins_url('linkedin-auto-publish/js/notice.js') );
	wp_enqueue_script( 'xyz_notice_script_lnap' );
	
	wp_register_style('xyz_lnap_style', plugins_url('linkedin-auto-publish/css/style.css'));
	wp_enqueue_style('xyz_lnap_style');
}

add_action("admin_enqueue_scripts","xyz_lnap_add_admin_scripts");

function xyz_lnap_menu()
{
	add_menu_page('LinkedIn Auto Publish - Manage settings', 'WP to LinkedIn Auto Publish', 'manage_options', 'linkedin-auto-publish-settings', 'xyz_lnap_settings',plugin_dir_url( XYZ_LNAP_PLUGIN_FILE ) . 'images/lnap.png');
	$page=add_submenu_page('linkedin-auto-publish-settings', 'LinkedIn Auto Publish - Manage settings', ' Settings', 'manage_options', 'linkedin-auto-publish-settings' ,'xyz_lnap_settings'); // 8 for admin
	add_submenu_page('linkedin-auto-publish-settings', 'Linkedin Auto Publish - Logs', 'Logs', 'manage_options', 'linkedin-auto-publish-log' ,'xyz_lnap_logs');
	add_submenu_page('linkedin-auto-publish-settings', 'LinkedIn Auto Publish - About', 'About', 'manage_options', 'linkedin-auto-publish-about' ,'xyz_lnap_about'); // 8 for admin
}


function xyz_lnap_settings()
{
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);	
	$_POST = xyz_trim_deep($_POST);
	$_GET = xyz_trim_deep($_GET);
	
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}



function xyz_lnap_about()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/about.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}


function xyz_lnap_logs()
{
	$_POST = stripslashes_deep($_POST);
	$_GET = stripslashes_deep($_GET);
	$_POST = xyz_trim_deep($_POST);
	$_GET = xyz_trim_deep($_GET);

	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/logs.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

?>