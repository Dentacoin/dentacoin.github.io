<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * Woocommerce loops and filters.
 *
 */


if ( ! function_exists( 'xclean_woocommerce_support' ) ) :
/**
 *
 * Declare WooCommerce support.
 *
 */

function xclean_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'xclean_woocommerce_support' );
endif;


/**
 *
 * Unhook the WooCommerce wrappers.
 *
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


if ( ! function_exists( 'xclean_theme_wrapper_start' ) ) :
/**
 *
 * Start of theme wrappers.
 *
 */
function xclean_theme_wrapper_start() {
	echo '<div class="container entry-content">';
}
endif;


if ( ! function_exists( 'xclean_theme_wrapper_end' ) ) :
/**
 *
 * End of theme wrappers.
 *
 */
function xclean_theme_wrapper_end() {
	echo '</div>';
}
endif;


/**
 *
 * Hook functions to display the wrappers of htis theme.
 *
 */
add_action( 'woocommerce_before_main_content', 'xclean_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'xclean_theme_wrapper_end', 10 );

/**
 *
 * Deactivate woocommerce style.
 *
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


/**
 *
 * Change quantity of woocommerce products thet show .
 *
 */
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );


if ( ! function_exists('xclean_loop_columns') ) :
/**
 *
 * Change quantity of woocommerce columns .
 *
 */

function xclean_loop_columns() {
	return 3; // 4 products per row
}

add_filter( 'loop_shop_columns', 'xclean_loop_columns' );
endif;


if ( ! function_exists( 'xclean_change_breadcrumb_delimiter' ) ) :
/**
 *
 * Change the woocommerce breadcrumb delimeter.
 *
 */

function xclean_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '<span>/</span>';
	return $defaults;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'xclean_change_breadcrumb_delimiter' );
endif;


if ( ! function_exists('xclean_second_image') ) :
/**
 *
 * Second product image.
 *
 */

function xclean_second_image() {
	global $product;
	$attachment_ids = $product->get_gallery_image_ids();

	if ( ! empty( $attachment_ids ) ) {
		$image_title = esc_attr( get_the_title( $attachment_ids[0] ) );
		$image = wp_get_attachment_image( $attachment_ids[0], apply_filters( 'single_product_large_thumbnail_size', 'shop_catalog' ), 0, $attr = array(
			'class' => 'second-image',
			'alt'	=> $image_title
			) );
	echo $image;
	}
 }
endif;


if ( ! function_exists( 'xclean_products_category' ) ) :
/**
 *
 * Add category fild to products .
 *
 */

function xclean_products_category() {
	global $product;

	if ( wc_get_product_category_list( $product->get_id() ) != '' ) {
		echo '<div class="products-cats">';
		echo wc_get_product_category_list( $product->get_id() );
		echo '</div>';
	}
}

add_action( 'woocommerce_after_shop_loop_item_title', 'xclean_products_category', 5 );
add_action( 'woocommerce_single_product_summary', 'xclean_products_category', 5) ;
endif;


/**
 *
 * Change woocommerce before shop loop item.
 *
 */
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 15 );
add_action( 'woocommerce_before_shop_loop_item', 'xclean_second_image', 20 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 25 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_close', 30 );


/**
 *
 * Change woocommerce before shop loop item title.
 *
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 10 );

/**
 *
 * Change woocommerce after shop loop item.
 *
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


/**
 *
 * Change woocommerce after shop loop item title.
 *
 */
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 1 );


/**
 *
 * Change woocommerce before shop loop.
 *
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 30 );


/**
 *
 * Change woocommerce after shop loop.
 *
 */
add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 1 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 5 );


/**
 *
 * Deactivate woocommerce breadcrumb in woocommerce before main content loop.
 *
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


/**
 *
 * Change woocommerce single product summary loop.
 *
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );


/**
 *
 * Add share buttons to the product.
 *
 */
add_action( 'woocommerce_single_product_summary', 'xclean_share_buttons', 50 );


if ( ! function_exists( 'xclean_is_woo_exists()' ) ) :
/**
 *
 * Check if WooCommerce plagin is instal or active.
 *
 */

function xclean_is_woo_exists() {
	return class_exists( 'WooCommerce' );
}
endif;


/**
 *
 * Add xclean_cart_quantity function to woocommerce ajaks.
 *
 */
add_filter( 'add_to_cart_fragments', 'xclean_cart_quantity' );


if ( ! function_exists( 'xclean_cart_quantity' ) ) :
/**
 *
 * Get quantity of product thet add to the cart.
 *
 */

function xclean_cart_quantity( $fragments ) {
	ob_start();
	xclean_cart_link();
	$fragments['a.cart-quantity'] = ob_get_clean();
	return $fragments;
}
endif;


if ( ! function_exists( 'xclean_cart_link' ) ) :
/**
 *
 * Display cart link. 
 *
 */

function xclean_cart_link() { ?>
	<a class="cart-quantity" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_html_e( 'View your shopping cart', 'xclean' ); ?>">
		<span class="cart-count"><?php echo wp_kses_data( esc_html( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'xclean' ), WC()->cart->get_cart_contents_count() ) ) );?></span>
	</a>
<?php
}
endif;


if ( ! function_exists( 'xclean_cart_dropdown' ) ) :
/**
 *
 * Get list of product and display it.
 *
 */

function xclean_cart_dropdown() { ?>
	<?php if ( ! is_cart() ) : ?>
		<div class="dropdown">
			<h5 class="widget-title"><?php esc_html_e( 'Shopping cart', 'xclean' ) ?></h5>
			<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
		</div><!-- End .dropdown -->
	<?php endif; 
}
endif;
?>