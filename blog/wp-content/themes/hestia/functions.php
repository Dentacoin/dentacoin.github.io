<?php
/**
 * Hestia functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
	define( 'ELEMENTOR_PARTNER_ID', 2112 );
}

define( 'HESTIA_VERSION', '1.1.62' );

define( 'HESTIA_VENDOR_VERSION', '1.0.1' );

define( 'HESTIA_PHP_INCLUDE', trailingslashit( get_template_directory() ) . 'inc/' );

$vendor_file = trailingslashit( get_template_directory() ) . 'vendor/autoload.php';
if ( is_readable( $vendor_file ) ) {
	require_once $vendor_file;
}
add_filter(
	'themeisle_sdk_products', function ( $products ) {
		$products[] = get_template_directory() . '/style.css';

		return $products;
	}
);

require_once( HESTIA_PHP_INCLUDE . 'template-tags.php' );
require_once( HESTIA_PHP_INCLUDE . 'hooks.php' );
require_once( HESTIA_PHP_INCLUDE . 'wp-bootstrap-navwalker/class-hestia-bootstrap-navwalker.php' );
require_once( HESTIA_PHP_INCLUDE . 'customizer.php' );
require_once( HESTIA_PHP_INCLUDE . 'page-builder-extras.php' );
require_once( get_template_directory() . '/demo-preview-images/init-prevdem.php' );
if ( hestia_woocommerce_check() ) {
	require_once( HESTIA_PHP_INCLUDE . 'woocommerce/functions.php' );
	require_once( HESTIA_PHP_INCLUDE . 'woocommerce/hooks.php' );
}

// Auto-loader for classes under Hestia namespace.
require_once( get_template_directory() . '/assets/autoloader/class-hestia-autoloader.php' );

// Individual layout feature
$individual_layout_path = HESTIA_PHP_INCLUDE . 'features/feature-individual-layout.php';
if ( file_exists( $individual_layout_path ) ) {
	require_once( $individual_layout_path );
}

Hestia_Autoloader::set_path( HESTIA_PHP_INCLUDE );
Hestia_Autoloader::define_namespaces( array( 'Hestia' ) );
/**
 * Invocation of the Autoloader::loader method.
 *
 * @since   1.0.0
 */
spl_autoload_register( 'Hestia_Autoloader::loader' );

if ( ! function_exists( 'hestia_setup_theme' ) ) {
	/**
	 * Get the number of items in the cart.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_setup_theme() {
		// Using this feature you can set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.  https://codex.wordpress.org/Content_Width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 750;
		}

		// Takes care of the <title> tag. https://codex.wordpress.org/Title_Tag
		add_theme_support( 'title-tag' );

		// Add theme support for custom logo. https://codex.wordpress.org/Theme_Logo
		add_theme_support(
			'custom-logo', array(
				'flex-width'  => true,
				'flex-height' => true,
				'height'      => 100,
			)
		);

		// Loads texdomain. https://codex.wordpress.org/Function_Reference/load_theme_textdomain
		load_theme_textdomain( 'hestia', get_template_directory() . '/languages' );

		// Add automatic feed links support. https://codex.wordpress.org/Automatic_Feed_Links
		add_theme_support( 'automatic-feed-links' );

		// Add post thumbnails support. https://codex.wordpress.org/Post_Thumbnails
		add_theme_support( 'post-thumbnails' );

		// Add custom background support. https://codex.wordpress.org/Custom_Backgrounds
		add_theme_support(
			'custom-background', array(
				'default-color' => apply_filters( 'hestia_default_background_color', 'E5E5E5' ),
			)
		);

		// Add custom header support. https://codex.wordpress.org/Custom_Headers
		$header_settings = apply_filters(
			'hestia_custom_header_settings', array(// Height
				'height'      => 2000,
				// Flex height
				'flex-height' => true,
				// Header text
				'header-text' => false,
			)
		);
		add_theme_support( 'custom-header', $header_settings );

		// Add selective Widget refresh support
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for html5
		add_theme_support( 'html5', array( 'search-form' ) );

		// This theme uses wp_nav_menu(). https://codex.wordpress.org/Function_Reference/register_nav_menu
		register_nav_menus(
			array(
				'primary'      => esc_html__( 'Primary Menu', 'hestia' ),
				'footer'       => esc_html__( 'Footer Menu', 'hestia' ),
				'top-bar-menu' => esc_html__( 'Very Top Bar', 'hestia' ) . ' ' . esc_html__( 'Menu', 'hestia' ),
			)
		);

		// Adding image sizes. https://developer.wordpress.org/reference/functions/add_image_size/
		add_image_size( 'hestia-blog', 360, 240, true );

		if ( hestia_woocommerce_check() ) {
			add_image_size( 'hestia-shop', 230, 350, true );
			add_image_size( 'hestia-shop-2x', 460, 700, true );
		}

		// Add Portfolio Image size if Jetpack Portfolio CPT is enabled.
		if ( class_exists( 'Jetpack' ) ) {
			if ( Jetpack::is_module_active( 'custom-content-types' ) ) {
				add_image_size( 'hestia-portfolio', 360, 300, true );
			}
		}

		// Added WooCommerce support.
		if ( hestia_woocommerce_check() ) {
			add_theme_support( 'woocommerce' );
		}

		// Added Jetpack Portfolio Support.
		if ( class_exists( 'Jetpack' ) ) {
			add_theme_support( 'jetpack-portfolio' );
		}

		/* Customizer upsell. */
		$info_path = HESTIA_PHP_INCLUDE . 'customizer-info/class/class-hestia-customizer-info-singleton.php';
		if ( file_exists( $info_path ) ) {
			require_once( $info_path );
		}

		/* WooCommerce support for latest gallery */
		if ( hestia_woocommerce_check() ) {
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		add_editor_style();
	}

	add_action( 'after_setup_theme', 'hestia_setup_theme' );
}// End if().

/**
 * Check if function exists.
 */
if ( ! function_exists( 'hestia_editor_inline_style' ) ) {
	/**
	 * Add inline style for editor.
	 *
	 * @param string $init Setup TinyMCE.
	 *
	 * @return mixed
	 */
	function hestia_editor_inline_style( $init ) {

		$accent_color  = get_theme_mod( 'accent_color', apply_filters( 'hestia_accent_color_default', '#e91e63' ) );
		$headings_font = get_theme_mod( 'hestia_headings_font' );
		$body_font     = get_theme_mod( 'hestia_body_font' );

		$custom_css = '';

		// Check if accent color is exists.
		if ( ! empty( $accent_color ) ) {
			$custom_css .= 'body.mce-content-body a { color: ' . esc_attr( $accent_color ) . '; }';
		}

		// Check if font family for body exists.
		if ( ! empty( $body_font ) ) {
			$custom_css .= 'body, p { font-family: ' . esc_attr( $body_font ) . ' !important; }';
		}

		// Check if font family for headings exists.
		if ( ! empty( $headings_font ) ) {
			$custom_css .= 'h1, h2, h3, h4, h5, h6 { font-family: ' . esc_attr( $headings_font ) . ' !important; }';
		}

		?>

		<script type="text/javascript">
			function hestiaEditorInlineStyle( ed ) {
				ed.onInit.add( function() {
					<?php
					// Added font family for body in editor.
					if ( ! empty( $body_font ) ) {
					?>
						tinymce.activeEditor.dom.loadCSS('https://fonts.googleapis.com/css?family=<?php echo esc_attr( $body_font ); ?>');
					<?php
					}

					// Added font family for headings in editor.
					if ( ! empty( $headings_font ) ) {
					?>
					tinymce.activeEditor.dom.loadCSS('https://fonts.googleapis.com/css?family=<?php echo esc_attr( $headings_font ); ?>');
					<?php } ?>

					// Added custom CSS in editor.
					tinyMCE.activeEditor.dom.addStyle(<?php echo json_encode( $custom_css ); ?>);
				} );
			};
		</script>

		<?php
		if ( wp_default_editor() == 'tinymce' ) {
			$init['setup'] = 'hestiaEditorInlineStyle';
		}

		return $init;
	}
}
add_filter( 'tiny_mce_before_init', 'hestia_editor_inline_style' );

/**
 * Register widgets for the theme.
 *
 * @since Hestia 1.0
 * @modified 1.1.40
 */
function hestia_widgets_init() {

	/**
	 * Array of all the main sidebars registered in the theme
	 */
	$sidebars_array = array(
		'sidebar-1'              => esc_html__( 'Sidebar', 'hestia' ),
		'subscribe-widgets'      => esc_html__( 'Subscribe', 'hestia' ),
		'blog-subscribe-widgets' => esc_html__( 'Blog Subscribe Section', 'hestia' ),
		'sidebar-woocommerce'    => esc_html__( 'WooCommerce Sidebar', 'hestia' ),
		'sidebar-top-bar'        => esc_html__( 'Very Top Bar', 'hestia' ),
		'header-sidebar'         => esc_html__( 'Navigation', 'hestia' ),
	);

	/**
	 * Array of sidebars registered in the footer area.
	 * The hestia_footer_widget_areas_array filter is used in the PRO version to add the extra forth sidebar.
	 */
	$footer_sidebars_array = apply_filters(
		'hestia_footer_widget_areas_array', array(
			'footer-one-widgets'   => esc_html__( 'Footer One', 'hestia' ),
			'footer-two-widgets'   => esc_html__( 'Footer Two', 'hestia' ),
			'footer-three-widgets' => esc_html__( 'Footer Three', 'hestia' ),
		)
	);

	/**
	 * Number of footer sidebars that need to be registered.
	 * This option is available only in the PRO version. In Hestia, the value is always 3.
	 */
	$hestia_nr_footer_widgets = get_theme_mod( 'hestia_nr_footer_widgets', '3' );

	/**
	 * If the Number of widgets areas option is selected, add the specific number of footer sidebars in the main sidebars array to be registered.
	 */
	if ( ! empty( $hestia_nr_footer_widgets ) ) {
		$footer_sidebars_array = array_slice( $footer_sidebars_array, 0, $hestia_nr_footer_widgets );
	}

	if ( ! empty( $footer_sidebars_array ) ) {
		$sidebars_array = array_merge( $sidebars_array, $footer_sidebars_array );
	}

	/**
	 * Register the sidebars
	 */
	foreach ( $sidebars_array as $sidebar_id => $sidebar_name ) {
		$sidebar_settings = array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5>',
			'after_title'   => '</h5>',
		);
		if ( $sidebar_id === 'subscribe-widgets' || $sidebar_id === 'blog-subscribe-widgets' ) {
			$sidebar_settings['before_widget'] = '';
			$sidebar_settings['after_widget']  = '';
		}

		register_sidebar( $sidebar_settings );

	}
}

add_action( 'widgets_init', 'hestia_widgets_init' );

/**
 * Register Fonts
 *
 * @return string
 */
function hestia_fonts_url() {
	$fonts_url = '';
	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto or Roboto Slab, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto      = _x( 'on', 'Roboto font: on or off', 'hestia' );
	$roboto_slab = _x( 'on', 'Roboto Slab font: on or off', 'hestia' );

	if ( 'off' !== $roboto || 'off' !== $roboto_slab ) {
		$font_families = array();

		if ( 'off' !== $roboto ) {
			$font_families[] = 'Roboto:300,400,500,700';
		}

		if ( 'off' !== $roboto_slab ) {
			$font_families[] = 'Roboto Slab:400,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Registering and enqueuing scripts/stylesheets to header/footer.
 *
 * @since Hestia 1.0
 */
function hestia_scripts() {

	// Bootstrap
	if ( ! class_exists( 'Elementor\Frontend' ) ) {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), HESTIA_VENDOR_VERSION );
		wp_style_add_data( 'bootstrap', 'rtl', 'replace' );
		wp_style_add_data( 'bootstrap', 'suffix', '.min' );
	}
	// FontAwesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', array(), HESTIA_VENDOR_VERSION );

	// Main Stylesheet
	if ( ! class_exists( 'Elementor\Frontend' ) ) {
		wp_enqueue_style( 'hestia-font-sizes', get_template_directory_uri() . '/assets/css/font-sizes.css', array(), HESTIA_VERSION );
	}
	wp_enqueue_style( 'hestia_style', get_stylesheet_uri(), array(), apply_filters( 'hestia_version_filter', HESTIA_VERSION ) );
	wp_style_add_data( 'hestia_style', 'rtl', 'replace' );

	// WooCommerce Style loaded only if WooCommerce exists on page.
	if ( hestia_woocommerce_check() ) {
		$disabled_products = get_theme_mod( 'hestia_shop_hide', false );
		if ( is_woocommerce() || is_checkout() || is_cart() || is_account_page() || ( is_front_page() && (bool) $disabled_products === false ) ) {
			wp_enqueue_style( 'hestia_woocommerce_style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), HESTIA_VERSION );
			wp_style_add_data( 'hestia_woocommerce_style', 'rtl', 'replace' );
		}
	}

	// Fonts
	$hestia_headings_font = get_theme_mod( 'hestia_headings_font' );
	$hestia_body_font     = get_theme_mod( 'hestia_body_font' );
	if ( empty( $hestia_headings_font ) || empty( $hestia_body_font ) ) {
		wp_enqueue_style( 'hestia_fonts', hestia_fonts_url(), array(), HESTIA_VERSION );
	}

	// Customizer Style
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'hestia-customizer-preview-style', get_template_directory_uri() . '/assets/css/customizer-preview.css', array(), HESTIA_VERSION );
	}

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'jquery-bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array( 'jquery' ), HESTIA_VENDOR_VERSION, true );
	wp_enqueue_script( 'jquery-hestia-material', get_template_directory_uri() . '/assets/js/material.js', array( 'jquery' ), HESTIA_VENDOR_VERSION, true );
	wp_enqueue_script(
		'hestia_scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(
			'jquery-hestia-material',
			'jquery-ui-core',
		), HESTIA_VERSION, true
	);

	$hestia_cart_url = '';
	if ( hestia_woocommerce_check() ) {
		if ( function_exists( 'wc_get_cart_url' ) ) {
			$hestia_cart_url = wc_get_cart_url();
		}
	}

	wp_localize_script(
		'hestia_scripts', 'hestiaViewcart', array(
			'view_cart_label' => esc_html__( 'View cart', 'hestia' ), // label of View cart button,
			'view_cart_link'  => esc_url( $hestia_cart_url ), // link of View cart button
		)
	);
}

add_action( 'wp_enqueue_scripts', 'hestia_scripts' );

/**
 * Enqueue font sizes before elementor.
 */
function hestia_enqueue_before_elementor() {
	if ( class_exists( 'Elementor\Frontend' ) ) {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), HESTIA_VENDOR_VERSION );
		wp_style_add_data( 'bootstrap', 'rtl', 'replace' );
		wp_style_add_data( 'bootstrap', 'suffix', '.min' );
		wp_enqueue_style( 'hestia-font-sizes', get_template_directory_uri() . '/assets/css/font-sizes.css', array(), HESTIA_VERSION );
	}
}

add_action( 'elementor/frontend/before_register_styles', 'hestia_enqueue_before_elementor' );

/**
 * Add appropriate classes to body tag.
 *
 * @since Hestia 1.0
 */
function hestia_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'blog-post';
	}

	return $classes;
}

add_filter( 'body_class', 'hestia_body_classes' );

/**
 * Define excerpt length.
 *
 * @since Hestia 1.0
 */
function hestia_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	if ( ( 'page' === get_option( 'show_on_front' ) ) || is_single() ) {
		return 35;
	} elseif ( is_home() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			return 40;
		} else {
			return 75;
		}
	} else {
		return 50;
	}
}

add_filter( 'excerpt_length', 'hestia_excerpt_length', 999 );

/**
 * Replace excerpt "Read More" text with a link.
 *
 * @since Hestia 1.0
 */
function hestia_excerpt_more( $more ) {
	global $post;
	if ( ( ( 'page' === get_option( 'show_on_front' ) ) ) || is_single() || is_archive() || is_home() ) {
		return '<a class="moretag" href="' . esc_url( get_permalink( $post->ID ) ) . '"> ' . esc_html__( 'Read more&hellip;', 'hestia' ) . '</a>';
	}

	return $more;
}

add_filter( 'excerpt_more', 'hestia_excerpt_more' );

/**
 * Move comment field above user details.
 *
 * @since Hestia 1.0
 */
function hestia_comment_message( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'hestia_comment_message' );

/**
 * Define Allowed Files to be included.
 *
 * @since Hestia 1.0
 */
function hestia_filter_features( $array ) {
	$files_to_load = array(

		'features/feature-themeisle-lite-manager',

		'features/feature-navigation-tabs',
		'features/feature-general-settings',
		'features/feature-blog-settings',
		'features/feature-general-credits',
		'features/feature-slider-section',
		'features/feature-big-title-section',
		'features/feature-features-section',
		'features/feature-about-section',
		'features/feature-shop-section',
		'features/feature-portfolio-section',
		'features/feature-team-section',
		'features/feature-pricing-section',
		'features/feature-testimonials-section',
		'features/feature-subscribe-section',
		'features/feature-blog-section',
		'features/feature-contact-section',
		'features/feature-contact-form',
		'features/feature-color-settings',
		'features/feature-advanced-color-settings',
		'features/feature-section-ordering',
		'features/feature-theme-info-section',
		'features/feature-header-settings',
		'features/feature-ribbon-section',
		'features/feature-clients-bar-section',

		'sections/feature-blog-authors-section',
		'sections/feature-blog-subscribe-section',
		'sections/hestia-slider-section',
		'sections/hestia-big-title-section',
		'sections/hestia-features-section',
		'sections/hestia-about-section',
		'sections/hestia-shop-section',
		'sections/hestia-portfolio-section',
		'sections/hestia-team-section',
		'sections/hestia-pricing-section',
		'sections/hestia-testimonials-section',
		'sections/hestia-subscribe-section',
		'sections/hestia-blog-section',
		'sections/hestia-contact-section',
		'sections/hestia-authors-blog-section',
		'sections/hestia-subscribe-blog-section',
		'sections/hestia-ribbon-section',
		'sections/hestia-clients-bar-section',

		'customizer-theme-info/class-customizer-theme-info-root',
		'features/feature-pro-manager',
		'features/feature-about-page',
		'companion/customizer',

		'wpml-pll/functions',
		'legacy',
		'shortcodes/functions',

		'typography/typography-settings',
		'typography/typography-pro-settings',

		'navigation/cart-content',

		'hooks/functions',
		'hooks/class-hestia-hooks-settings',
	);

	if ( class_exists( 'WeDevs_Dokan' ) ) {
		array_push( $files_to_load, 'plugins-compatibility/dokan/functions' );
	}

	return array_merge(
		$array, $files_to_load
	);
}

add_filter( 'hestia_filter_features', 'hestia_filter_features' );

/**
 * Include page builder support for frontpage sections hiding
 */
function hestia_pagebuilders_support( $array ) {
	return array_merge(
		$array, array(
			'features/feature-pagebuilder-frontpage',
		)
	);
}

if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	add_filter( 'hestia_filter_features', 'hestia_pagebuilders_support' );
}

/**
 * Include features files.
 *
 * @since Hestia 1.0
 */
function hestia_include_features() {
	$hestia_allowed_phps = array();
	$hestia_allowed_phps = apply_filters( 'hestia_filter_features', $hestia_allowed_phps );

	foreach ( $hestia_allowed_phps as $file ) {
		$hestia_file_to_include = HESTIA_PHP_INCLUDE . $file . '.php';
		if ( file_exists( $hestia_file_to_include ) ) {
			include_once( $hestia_file_to_include );
		}
	}
}

add_action( 'after_setup_theme', 'hestia_include_features', 0 );

// Add Related Posts to Single Posts.
add_action( 'hestia_blog_related_posts', 'hestia_related_posts' );

// Add Social Icons to Single Posts.
add_action( 'hestia_blog_social_icons', 'hestia_social_icons' );

/**
 * Filter the front page template so it's bypassed entirely if the user selects
 * to display blog posts on their homepage instead of a static page.
 */
function hestia_filter_front_page_template( $template ) {
	return is_home() ? '' : $template;
}

add_filter( 'frontpage_template', 'hestia_filter_front_page_template' );

/**
 * Filter to modify input label in repeater control
 * You can filter by control id and input name.
 *
 * @param string $string Input label.
 * @param string $id Input id.
 * @param string $control Control name.
 *
 * @modified 1.1.41
 *
 * @return string
 */
function hestia_repeater_labels( $string, $id, $control ) {

	if ( $id === 'hestia_slider_content' ) {
		if ( $control === 'customizer_repeater_text_control' ) {
			return esc_html__( 'Button Text', 'hestia' );
		}

		if ( $control === 'customizer_repeater_color_control' ) {
			return esc_html__( 'Button', 'hestia' ) . ' ' . esc_html__( 'Color', 'hestia' );
		}

		if ( $control === 'customizer_repeater_color2_control' ) {
			return esc_html__( 'Second', 'hestia' ) . ' ' . esc_html__( 'Button', 'hestia' ) . ' ' . esc_html__( 'Color', 'hestia' );
		}

		if ( $control === 'customizer_repeater_text2_control' ) {
			return esc_html__( 'Second', 'hestia' ) . ' ' . esc_html__( 'Button text', 'hestia' );
		}

		if ( $control === 'customizer_repeater_link2_control' ) {
			return esc_html__( 'Second', 'hestia' ) . ' ' . esc_html__( 'Link', 'hestia' );
		}
	}

	return $string;
}

add_filter( 'repeater_input_labels_filter', 'hestia_repeater_labels', 10, 3 );

/**
 * Filter to modify input type in repeater control
 * You can filter by control id and input name.
 *
 * @param string $string Input label.
 * @param string $id Input id.
 * @param string $control Control name.
 *
 * @modified 1.1.41
 *
 * @return string
 */
function hestia_repeater_input_types( $string, $id, $control ) {

	if ( $id === 'hestia_slider_content' ) {
		if ( $control === 'customizer_repeater_text_control' ) {
			return '';
		}
		if ( $control === 'customizer_repeater_text2_control' ) {
			return '';
		}
		if ( $control === 'customizer_repeater_subtitle_control' ) {
			return 'textarea';

		}
	}

	return $string;
}

add_filter( 'hestia_repeater_input_types_filter', 'hestia_repeater_input_types', 10, 3 );

add_action( 'wp_ajax_nopriv_request_post', 'hestia_requestpost' );
add_action( 'wp_ajax_request_post', 'hestia_requestpost' );
/**
 * Ajax function for refresh purposes.
 */
function hestia_requestpost() {
	$pid = absint( $_POST['pid'] );

	if ( ! empty( $pid ) && $pid !== 0 ) {
		hestia_sync_control_from_page( $pid, true );
	}
	echo '';
	die();
}

/**
 * Add starter content for fresh sites
 *
 * @since 1.1.8
 * @modified 1.1.31
 */
function hestia_starter_content() {
	$default_home_content        = '<div class="col-md-5"><h3>' . esc_html__( 'About Hestia', 'hestia' ) . '</h3>' . esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Hestia.', 'hestia' ) . '</div><div class="col-md-6 col-md-offset-1"><img class="size-medium alignright" src="' . esc_url( get_template_directory_uri() . '/assets/img/about-content.png' ) . '"/></div>';
	$default_home_featured_image = get_template_directory_uri() . '/assets/img/contact.jpg';

	/*
	 * Starter Content Support
	 */
	add_theme_support(
		'starter-content', array(
			'attachments' => array(
				'featured-image-home' => array(
					'post_title'   => 'Featured Image Homepage',
					'post_content' => 'The featured image for the front page.',
					'file'         => 'assets/img/contact.jpg',
				),
			),
			'posts'       => array(
				'home' => array(
					'post_content' => $default_home_content,
					'thumbnail'    => '{{featured-image-home}}',
				),
				'blog',
			),

			'nav_menus'   => array(
				'primary' => array(
					'name'  => esc_html__( 'Primary Menu', 'hestia' ),
					'items' => array(
						'page_home',
						'page_blog',
					),
				),
			),

			'options'     => array(
				'show_on_front'            => 'page',
				'page_on_front'            => '{{home}}',
				'page_for_posts'           => '{{blog}}',
				'hestia_page_editor'       => $default_home_content,
				'hestia_feature_thumbnail' => $default_home_featured_image,
			),
		)
	);
}

add_action( 'after_setup_theme', 'hestia_starter_content' );

/**
 * Save activation time.
 *
 * @since 1.1.22
 * @access public
 */
function hestia_time_activated() {
	update_option( 'hestia_time_activated', time() );
}

add_action( 'after_switch_theme', 'hestia_time_activated' );

/**
 * Check if $no_seconds have passed since theme was activated.
 * Used to perform certain actions, like displaying upsells or add a new recommended action in About Hestia page.
 *
 * @since 1.1.45
 * @access public
 * @return bool
 */
function hestia_check_passed_time( $no_seconds ) {
	$activation_time = get_option( 'hestia_time_activated' );
	if ( ! empty( $activation_time ) ) {
		$current_time    = time();
		$time_difference = (int) $no_seconds;
		if ( $current_time >= $activation_time + $time_difference ) {
			return true;
		} else {
			return false;
		}
	}

	return true;
}

/**
 * Upgrade link to BeaverBuilder
 */
function hestia_bb_upgrade_link() {
	return 'https://www.wpbeaverbuilder.com/?fla=101&campaign=hestia';
}

add_filter( 'fl_builder_upgrade_url', 'hestia_bb_upgrade_link' );


add_action( 'wp_ajax_dismissed_notice_handler', 'hestia_ajax_notice_handler' );

add_action( 'wp_ajax_nopriv_dismissed_notice_handler', 'hestia_ajax_notice_handler' );
/**
 * AJAX handler to store the state of dismissible notices.
 */
function hestia_ajax_notice_handler() {
	$control_id = sanitize_text_field( wp_unslash( $_POST['control'] ) );
	update_option( 'dismissed-' . $control_id, true );
	echo $control_id;
	die();
}

/**
 * Check if URL is external
 */
function hestia_is_external_url( $url ) {
	$link_url = parse_url( $url );
	$home_url = parse_url( home_url() );

	if ( ! empty( $link_url['host'] ) ) {
		if ( $link_url['host'] !== $home_url['host'] ) {
			return ' target="_blank"';
		}
	} else {
		return '';
	}
}


if ( hestia_woocommerce_check() ) {
	/**
	 * Display WooCommerce product image responsive
	 */
	function hestia_shop_thumbnail( $post_id, $size = 'hestia-shop' ) {

		$image = '';

		$thumnail_id = get_post_thumbnail_id( $post_id );

		if ( ! empty( $thumnail_id ) ) {
			$thumbnail    = '';
			$thumbnail_2x = '';

			$thumbnail_tmp = wp_get_attachment_image_src( $thumnail_id, $size );
			if ( ! empty( $thumbnail_tmp ) ) {
				$thumbnail = $thumbnail_tmp[0];
			}
			$thumbnail_2x_tmp = wp_get_attachment_image_src( $thumnail_id, $size . '-2x' );
			if ( ! empty( $thumbnail_2x_tmp ) ) {
				$thumbnail_2x = $thumbnail_2x_tmp[0];
			}

			/**
			 * Alternative text for the Shop box image
			 * It first checks for the Alt Text option of the attachment
			 * If that field is empty, uses the Title of the Testimonial box as alt text
			 */
			$alt_image = '';
			$image_id  = function_exists( 'attachment_url_to_postid' ) ? attachment_url_to_postid( preg_replace( '/-\d{1,4}x\d{1,4}/i', '', $thumbnail ) ) : '';
			if ( ! empty( $image_id ) && $image_id !== 0 ) {
				$alt_image = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			}

			$image = '<img src="' . $thumbnail . '" srcset="' . $thumbnail . ' 230w,' . $thumbnail_2x . ' 460w" sizes="(max-width: 480px) 460px, (min-width: 480px) and (max-width: 600px) 230px, (min-width: 600px) and (max-width: 992px) 460px, (min-width: 992px) 230px, 100vw" ';
			if ( ! empty( $alt_image ) ) {
				$image .= ' alt="' . esc_attr( $alt_image ) . '" ';
			}
			$image .= '>';
		}

		return $image;
	}
}

/**
 * Return description for plugin available on wporg
 */
function hestia_get_wporg_plugin_description( $slug ) {

	$plugin_transient_name = 'hestia_t_' . $slug;

	$transient = get_transient( $plugin_transient_name );

	if ( ! empty( $transient ) ) {

		return $transient;

	} else {

		$plugin_description = '';

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		}

		$call_api = plugins_api(
			'plugin_information', array(
				'slug'   => $slug,
				'fields' => array(
					'short_description' => true,
				),
			)
		);

		if ( ! empty( $call_api ) ) {
			if ( ! empty( $call_api->short_description ) ) {
				$plugin_description = strtok( $call_api->short_description, '.' );
			}
		}

		set_transient( $plugin_transient_name, $plugin_description, 10 * DAY_IN_SECONDS );

		return $plugin_description;

	}
}

/**
 * Instantiates the class that handles the content import for Azera Shop, Parallax One and Llorix One.
 */
function hestia_import_flagship_content() {
	if ( class_exists( 'Hestia_Content_Import' ) ) {
		$importer = new Hestia_Content_Import();
		$importer->import();
	}

	if ( class_exists( 'Hestia_Import_Zerif' ) ) {
		$importer = new Hestia_Import_Zerif();
		$importer->import();
	}
}

add_action( 'after_switch_theme', 'hestia_import_flagship_content', 0 );

/**
 * Allow html tags in descriptions.
 */
remove_filter( 'nav_menu_description', 'strip_tags' );


if ( ! function_exists( 'hestia_after_primary_navigation' ) ) :
	/**
	 * Function to display cart icon after primary navigation.
	 *
	 * @since 1.1.24
	 * @access public
	 */
	function hestia_after_primary_navigation() {

		$nav  = '<ul id="%1$s" class="%2$s">';
		$nav .= '%3$s';

		// If WooCommerce exists
		if ( hestia_woocommerce_check() ) {
			$is_in_topbar_sidebar = false;
			$is_in_header_sidebar = false;
			$nav_cart             = false;
			$top_bar_hide         = get_theme_mod( 'hestia_top_bar_hide', true );
			$header_alignment     = get_theme_mod( 'hestia_header_alignment', 'left' );

			// Check if WooCommerce cart is in the top bar sidebar
			if ( is_active_sidebar( 'sidebar-top-bar' ) ) {
				$active_widgets = get_option( 'sidebars_widgets' );

				// Check active widgets
				if ( $active_widgets['sidebar-top-bar'] ) {
					foreach ( $active_widgets['sidebar-top-bar'] as $item ) {

						if ( strpos( $item, 'woocommerce_widget_cart' ) !== false ) {
							$is_in_topbar_sidebar = true;
							break;
						}
					}
				}
			}

			// Check if WooCommerce cart is in the header sidebar
			if ( is_active_sidebar( 'header-sidebar' ) ) {
				$active_widgets = get_option( 'sidebars_widgets' );

				// Check active widgets
				if ( $active_widgets['header-sidebar'] ) {
					foreach ( $active_widgets['header-sidebar'] as $item ) {

						if ( strpos( $item, 'woocommerce_widget_cart' ) !== false ) {
							$is_in_header_sidebar = true;
							break;
						}
					}
				}
			}

			// Check if top bar is hide OR Topbar sidebar is active but with no cart widget inside OR Header sidebar is active but with no cart widget inside
			if ( ( ( ! $top_bar_hide && ! $is_in_topbar_sidebar ) || $top_bar_hide ) && ( $header_alignment !== 'right' || ( $header_alignment == 'right' && ! $is_in_header_sidebar ) ) ) {
				$nav_cart = true;
			}

			// Add cart after nav
			if ( $nav_cart && function_exists( 'hestia_cart_item' ) ) {
				$nav .= hestia_cart_item();
			}
		}

		// Add search after nav
		$hestia_search_in_menu = get_theme_mod( 'hestia_search_in_menu', false );
		if ( function_exists( 'hestia_search_in_menu' ) && $hestia_search_in_menu === true ) {
			$nav .= hestia_search_in_menu();
		}
		$nav .= '</ul>';

		return $nav;
	}
endif;


if ( ! function_exists( 'hestia_search_in_menu' ) ) :
	/**
	 * Display search form in menu.
	 */
	function hestia_search_in_menu() {
		$form = '
		<li class="hestia-search-in-menu">
			<form role="search" method="get" class="hestia-search-in-nav" action="' . esc_url( home_url( '/' ) ) . '">
				<div class="hestia-nav-search">
					<span class="screen-reader-text">' . _x( 'Search for:', 'label', 'hestia' ) . '</span>
					<span class="search-field-wrapper">
					
					<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder', 'hestia' ) . '" value="' . get_search_query() . '" name="s" />
					</span>
					<span class="search-submit-wrapper">
					<button type="submit" class="search-submit hestia-search-submit" ><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>
			<div class="hestia-toggle-search">
				<i class="fa fa-search"></i>
			</div>
		</li>';

		return $form;
	}
endif;

add_action( 'after_switch_theme', 'hestia_import_theme_mods_from_themeisle_child_themes' );

/**
 * Import theme mods when switching from a Themeisle Hestia child theme to Hestia
 */
function hestia_import_theme_mods_from_themeisle_child_themes() {

	// Get the name of the previously active theme.
	$previous_theme = strtolower( get_option( 'theme_switched' ) );

	if ( ! in_array( $previous_theme, array( 'christmas-hestia', 'tiny-hestia', 'orfeo', 'hestia-child', 'hestia-child-theme', 'hestia-child', 'hestia-child-theme' ) ) ) {
		return;
	}

	// Get the theme mods from the previous theme.
	$previous_theme_content = get_option( 'theme_mods_' . $previous_theme );

	if ( ! empty( $previous_theme_content ) ) {
		foreach ( $previous_theme_content as $previous_theme_mod_k => $previous_theme_mod_v ) {
			set_theme_mod( $previous_theme_mod_k, $previous_theme_mod_v );
		}
	}
}

/**
 * Function that limits a text to $limit words, words that are separated by $separator
 *
 * @param array  $input Content to limit.
 * @param int    $limit Max size.
 * @param string $separator Separator.
 * @param bool   $show_more Flag to decide if '...' should be added at the end of result.
 *
 * @return string
 */
function hestia_limit_content( $input, $limit, $separator = ',', $show_more = true ) {
	if ( $limit === 0 ) {
		return '';
	}
	$length = sizeof( $input );
	$more   = $length > $limit ? apply_filters( 'hestia_text_more', ' ...' ) : '';
	$result = '';
	$index  = 0;
	foreach ( $input as $word ) {
		if ( $index < $limit || $limit < 0 ) {
			$result .= $word;
			if ( $length > 1 && $index !== $length - 1 && $index !== $limit - 1 ) {
				$result .= $separator;
				if ( $separator === ',' ) {
					$result .= ' ';
				}
			}
		}
		$index ++;
	}
	if ( $show_more === true ) {
		$result .= $more;
	}
	return $result;
}

/**
 * Check if the hestia_setup_theme() function exists as this function exists only in Hestia ( the lite version )
 * and we want this notice to appear only in lite
 */
if ( function_exists( 'hestia_setup_theme' ) ) {

	add_action( 'admin_notices', 'hestia_multi_language_upsell_notice' );

	/**
	 * Add a dismissible notice in the dashboard to let users know that Hestia's ( the lite version ) frontpage is not multi-language compatible
	 * This notice appears only if we detect some plugins used for translations and the custom frontpage
	 */
	function hestia_multi_language_upsell_notice() {

		global $current_user;
		$user_id = $current_user->ID;

		/* Check that the user hasn't already clicked to ignore the message */
		if ( ! get_user_meta( $user_id, 'hestia_ignore_multi_language_upsell_notice' ) ) {

			/**
			 * Check if Polylang, TranslatePress or WPML are installed
			 * and the custom frontpage is selected
			 */
			if ( ( defined( 'POLYLANG_VERSION' ) || defined( 'TRP_PLUGIN_VERSION' ) || ( false !== get_option( 'icl_sitepress_settings' ) ) ) && ( get_option( 'show_on_front' ) === 'page' ) ) {
				echo '<div class="notice notice-warning" style="position:relative;">';
					printf( '<a href="%s" class="notice-dismiss" style="text-decoration:none;"></a>', '?hestia_nag_ignore=0' );
					echo '<p>';
					/* translators: Upsell to get the pro version */
					printf( esc_html__( 'Hestia front-page is not multi-language compatible, for this feature %s.', 'hestia' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( 'https://themeisle.com/themes/hestia/upgrade/' ), esc_html__( 'Get the PRO version!', 'hestia' ) ) );
					echo '</p>';
				echo '</div>';
			}
		}
	}

	add_action( 'admin_init', 'hestia_nag_ignore' );

	/**
	 * Update the hestia_ignore_multi_language_upsell_notice option to true, to dismiss the multi language upsell notice from the dashboard
	 */
	function hestia_nag_ignore() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['hestia_nag_ignore'] ) && '0' == $_GET['hestia_nag_ignore'] ) {
			add_user_meta( $user_id, 'hestia_ignore_multi_language_upsell_notice', 'true', true );
		}
	}

	add_action( 'admin_notices', 'hestia_orfeo_notice' );

	/**
	 * Add a dismissible notice in the dashboard to let users know that we have a new child theme for Hestia, Orfeo
	 * TODO: Remove this in Release 1.1.61
	 */
	function hestia_orfeo_notice() {

		global $current_user;
		$user_id = $current_user->ID;

		/* Check that the user hasn't already clicked to ignore the message */
		if ( ! get_user_meta( $user_id, 'hestia_ignore_orfeo_notice' ) ) {

			echo '<div class="notice updated" style="position:relative;">';
			printf( '<a href="%s" class="notice-dismiss" style="text-decoration:none;"></a>', '?hestia_nag_ignore_orfeo=0' );
			echo '<p>';
			/* translators: Install Orfeo link */
			printf( esc_html__( 'We just launched a new free Hestia %s, you might like it.', 'hestia' ), sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'theme-install.php?theme=orfeo' ), esc_html__( 'child theme', 'hestia' ) ) );
			echo '</p>';
			echo '</div>';

		}
	}

	add_action( 'admin_init', 'hestia_nag_ignore_orfeo' );

	/**
	 * Update the hestia_ignore_orfeo_notice option to true, to dismiss the notice from the dashboard
	 */
	function hestia_nag_ignore_orfeo() {
		global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['hestia_nag_ignore_orfeo'] ) && '0' == $_GET['hestia_nag_ignore_orfeo'] ) {
			add_user_meta( $user_id, 'hestia_ignore_orfeo_notice', 'true', true );
		}
	}
}
