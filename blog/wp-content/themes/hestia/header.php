<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the page header div.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset='<?php bloginfo( 'charset' ); ?>'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div 
	<?php
	if ( ! is_single() ) {
		echo 'class="wrapper"';
	} else {
		post_class( 'wrapper' );
	}

	$header_class = '';
	$hide_top_bar = get_theme_mod( 'hestia_top_bar_hide', true );
	if ( (bool) $hide_top_bar === false ) {
		$header_class .= 'header-with-topbar';
	}
?>
>
		<header class="header <?php echo esc_attr( $header_class ); ?>">
			<?php do_action( 'hestia_do_header' ); ?>
