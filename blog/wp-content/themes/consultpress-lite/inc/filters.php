<?php
/**
 * Filters for ConsultPressLite WP theme
 *
 * @package consultpresslite-pt
 */

/**
 * ConsultPressLiteFilters class with filter hooks
 */
class ConsultPressLiteFilters {

	/**
	 * Runs on class initialization. Adds filters and actions.
	 */
	function __construct() {
		// Custom tag font size.
		add_filter( 'widget_tag_cloud_args', array( $this, 'set_tag_cloud_sizes' ) );

		// Custom text after excerpt.
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

		// Google fonts.
		add_filter( 'consultpresslite_pre_google_web_fonts', array( $this, 'additional_fonts' ) );
		add_filter( 'consultpresslite_subsets_google_web_fonts', array( $this, 'subsets_google_web_fonts' ) );

		// Embeds.
		add_filter( 'embed_oembed_html', array( $this, 'embed_oembed_html' ), 10, 1 );

		// Body and post class.
		add_filter( 'body_class', array( $this, 'body_class' ), 10, 1 );
		add_filter( 'post_class', array( $this, 'post_class' ), 10, 1 );
	}


	/**
	 * Custom tag font size.
	 *
	 * @param array $args default arguments.
	 * @return array
	 */
	function set_tag_cloud_sizes( $args ) {
		$args['smallest'] = 12;
		$args['largest']  = 12;
		$args['unit'] = 'px';
		return $args;
	}


	/**
	 * Custom text after excerpt.
	 *
	 * @param array $more default more value.
	 * @return array
	 */
	function excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		return ' &hellip;';
	}


	/**
	 * Return Google fonts and sizes.
	 *
	 * @see https://github.com/grappler/wp-standard-handles/blob/master/functions.php
	 * @param array $fonts google fonts used in the theme.
	 * @return array Google fonts and sizes.
	 */
	function additional_fonts( $fonts ) {
		/* translators: If there are characters in your language that are not supported by Roboto or Merriweather, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== esc_html_x( 'on', 'Roboto and Merriweather: on or off', 'consultpress-lite' ) ) {
			$fonts['Roboto'] = array(
				'400' => '400',
				'700' => '700',
			);
			$fonts['Merriweather'] = array(
				'400' => '400',
				'900' => '900',
			);
		}

		return $fonts;
	}


	/**
	 * Add subsets from customizer, if needed.
	 *
	 * @param array $subsets google font subsets used in the theme.
	 * @return array
	 */
	function subsets_google_web_fonts( $subsets ) {
		$additional_subset = get_theme_mod( 'charset_setting', 'latin' );

		array_push( $subsets, $additional_subset );

		return $subsets;
	}


	/**
	 * Embedded videos and video container around them.
	 *
	 * @param string $html html to be enclosed with responsive HTML.
	 * @return string
	 */
	function embed_oembed_html( $html ) {
		if (
			false !== strstr( $html, 'youtube.com' ) ||
			false !== strstr( $html, 'wordpress.tv' ) ||
			false !== strstr( $html, 'wordpress.com' ) ||
			false !== strstr( $html, 'vimeo.com' )
		) {
			$out = '<div class="embed-responsive  embed-responsive-16by9">' . $html . '</div>';
		} else {
			$out = $html;
		}
		return $out;
	}


	/**
	 * Append the right body classes to the <body>.
	 *
	 * @param  array $classes The default array of classes.
	 * @return array
	 */
	public static function body_class( $classes ) {
		$classes[] = 'consultpresslite-pt';

		// important to determine if the sidebar should be shifted to top via JS
		if ( has_nav_menu( 'main-menu' ) ) {
			$classes[] = 'is-main-menu-defined';
		} else {
			$classes[] = 'is-main-menu-undefined';
		}

		// Theme layout mode.
		if ( 'boxed' === get_theme_mod( 'layout_mode', 'wide' ) ) {
			$classes[] = 'boxed';
		}

		return $classes;
	}


	/**
	 * Append the right post classes.
	 *
	 * @param  array $classes The default array of classes.
	 * @return array
	 */
	public static function post_class( $classes ) {
		$classes[] = 'clearfix';
		$classes[] = 'article';

		// Remove the hentry class.
		$classes = array_diff( $classes , array( 'hentry' ) );

		return $classes;
	}
}

// Single instance.
$consultpresslite_filters = new ConsultPressLiteFilters();
