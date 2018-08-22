<?php
/**
 * @package SH_V_HIDE
 * @version 1.0
 */
/*
Plugin Name: WP Version Remover
Plugin URI: https://superhosting.bg
Description: The plugin is hiding a public visibility of the WordPress version from the website source even if the system has been upgraded.
Author: SuperHosting.BG
Version: 1.0
Author URI: https://superhosting.bg
Text domain: sh_wp_version_hider
*/

function _sh_wp_version_hide()
{
	return '';
}

add_filter('the_generator', '_sh_wp_version_hide');

if(file_exists(ABSPATH . "/readme.html"))
{
	unlink(ABSPATH . "/readme.html");
}

?>