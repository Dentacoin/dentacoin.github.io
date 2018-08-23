<?php
/**
 * Extras functions for page builders
 *
 * @package Hestia
 * @since Hestia 1.1.24
 * @author Themeisle
 */

/**
 * Header for page builder blank template
 *
 * @since 1.1.24
 * @access public
 */
function hestia_no_content_get_header() {

	?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<?php
	do_action( 'hestia_page_builder_content_body_before' );

}

/**
 * Footer for page builder blank template
 *
 * @since 1.1.24
 * @access public
 */
function hestia_no_content_get_footer() {
	do_action( 'hestia_page_builder_content_body_after' );
	wp_footer();
	?>
	</body>
	</html>
	<?php
}


/**
 * Add header and footer support for beaver.
 *
 * @since 1.1.24
 * @access public
 */
function hestia_header_footer_render() {

	if ( ! class_exists( 'FLThemeBuilderLayoutData' ) ) {
		return;
	}

	// Get the header ID.
	$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();

	// If we have a header, remove the theme header and hook in Theme Builder's.
	if ( ! empty( $header_ids ) ) {
		remove_action( 'hestia_do_header', 'hestia_the_header_content' );
		add_action( 'hestia_do_header', 'FLThemeBuilderLayoutRenderer::render_header' );
	}

	// Get the footer ID.
	$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

	// If we have a footer, remove the theme footer and hook in Theme Builder's.
	if ( ! empty( $footer_ids ) ) {
		remove_action( 'hestia_do_footer', 'hestia_the_footer_content' );
		add_action( 'hestia_do_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
	}
}
add_action( 'wp', 'hestia_header_footer_render' );

/**
 * Add theme support for header and footer.
 *
 * @since 1.1.24
 * @access public
 */
function hestia_header_footer_support() {
	add_theme_support( 'fl-theme-builder-headers' );
	add_theme_support( 'fl-theme-builder-footers' );
}
add_action( 'after_setup_theme', 'hestia_header_footer_support' );
