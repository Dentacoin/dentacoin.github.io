<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * File with custom functions that check data and return the result.
 *
 */


if ( ! function_exists( 'xclean_blog' ) ) :
/**
 *
 * Checking if it page for posts.
 *
 */

function xclean_blog() {
	if ( is_home() && get_option( 'page_for_posts' ) ) {
		return true;
	} else {
		return false;
	}
}
endif;


if ( ! function_exists( 'xclean_get_option' ) ) :
/**
 *
 * Check if setings are available.
 *
 */

function xclean_get_option( $field ) {
	global $xclean_settings;
	if ( ! empty( $xclean_settings[ $field ] ) && isset( $xclean_settings[ $field ] ) ) {
		return $xclean_settings[ $field ];
	} else {
		return false;
	}
}
endif;


if ( ! function_exists( 'xclean_sidebars_setting' ) ) :
/**
 *
 * Sidebars setting.
 *
 */

function xclean_sidebars_setting() {

	$sidebar = $sidebar_position = '';

	if ( is_single() ) {
		$sidebar_position = xclean_get_option( 'sidebar-post' );
		$sidebar = 'main-sidebar';
	}

	if ( xclean_is_woo_exists() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		$sidebar_position = xclean_get_option( 'sidebar-shop' );
		$sidebar = 'shop-sidebar';
	}

	if ( ! is_active_sidebar( $sidebar ) || ( $sidebar_position == 'off' ) ) {
		$col = 'col-md-12 col-sm-12 col-xs-12';
		$position = 'without-sidebar';
	} else {
		$col = 'col-md-9 col-sm-12 col-xs-12';
		if ( ! empty( $sidebar_position ) ) {
			$position = 'pull-' . $sidebar_position;
		} else {
			$position = 'pull-left';
		}
		$sidebar_position = 'on';
	}

	$class  = '';
	$class .= $col;
	$class .= ' ' . $position;

	$args = array(
		'class' => $class,
		'status' => $sidebar_position,
	);

	return $args;
}
endif;

if ( ! function_exists( 'xclean_pages' ) ) :
/**
 *
 * Get pages.
 *
 */

function xclean_pages() {
	$pages = get_pages( 'ID' );
	$options = array();
	foreach ( $pages as $page ) {
		$title = $page->post_title;
		$options[ $title ] = $title;
	
	}
	return $options;
}
endif;