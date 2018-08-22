<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post, $product, $woocommerce;
$attachment_ids = $product->get_gallery_image_ids();
if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	<div id="et-products" class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php
		foreach ( $attachment_ids as $attachment_id ) {
			$classes = array( 'zoom' );
			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';
			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';
			$image_link = wp_get_attachment_url( $attachment_id );
			if ( ! $image_link )
				continue;
			$image_title 	= esc_attr( get_the_title( $attachment_id ) );
			$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );
			$image_class = esc_attr( implode( ' ', $classes ) );
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="item"><a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a></div>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );
			$loop++;
		}
	?></div>
	<script type="text/javascript">
		jQuery(document).ready(function() {
		 
		  jQuery("#et-products").owlCarousel({
		 
		      autoPlay: 3000, //Set AutoPlay to 3 seconds
		 
		      items : 3,
		      itemsDesktop : [1199,3],
		      itemsDesktopSmall : [979,3],
		      navigation : true,
		      pagination : false
		 
		  });
		 
		});
	</script>
	<?php
}