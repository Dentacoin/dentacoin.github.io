<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *
 * File with custom functions that output somethings.
 *
 */

if ( ! function_exists( 'xclean_post_galery_slider' ) ) :
/**
 *
 * Function that constract post galery sliger.
 * Get global $post then if post type galery,
 * getting post_gallery_images and 
 * for each galery image create their own slide.
 *
 */

function xclean_post_galery_slider() { ?>
	<?php 
		global $post; 
		$id = get_the_ID();
		$gallery = get_post_gallery( $id, false );
		$gallery = explode( ',', $gallery['ids'] );
	?>

	<div id="et-galery-<?php echo $id; ?>" class="galery-carousel">

		<?php foreach( $gallery as $image ) : ?>

			<div class="item">
				<?php echo wp_get_attachment_image( $image, 'large' ); ?>
			</div><!-- End .item -->

		<?php endforeach; ?>

	</div><!-- End #et-galery .galery-carousel -->

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#et-galery-<?php echo $id; ?>").owlCarousel({
				autoPlay: false, //Set AutoPlay to 3 seconds
		 		items : 1,
				itemsDesktop : [1199,3],
				itemsDesktopSmall : [979,3],
				navigation : true,
				pagination : false,
		 
			});
		});
	</script>
<?php
}
endif;


if ( ! function_exists( 'xclean_post_carousel' ) ) :
/**
 *
 * Function that constract post carousel.
 * 
 */

function xclean_post_carousel( $args, $class, $id ) { ?>

	<div class="post-carousel-wrapper">
		<div id="et-posts-<?php echo esc_attr( $id ); ?>" class="post-carousel<?php echo esc_attr( $class ); ?>">

			<?php $query = new WP_Query( $args ); ?>

			<?php if ( $query->have_posts() ) : ?>

				<?php while ( $query->have_posts() ) : ?>
					<?php $query->the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-section item' ); ?>>
						<header class="entry-header">

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-thumbnail post-thumbnail">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
								</div><!-- End .entry-thumbnail post-thumbnail -->
								<div class="entry-inside">
									<a href="<?php the_permalink(); ?>" class="read-more-button"><?php esc_html_e( 'Read more', 'xclean' ); ?></a>
								</div><!-- End .entry-inside -->
							<?php endif; ?>

						</header><!-- End .entry-header -->

						<div class="entry-description">
							<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php esc_html( the_title() ); ?></a></h2>
							<div class="entry-meta "><?php xclean_post_meta(); ?></div>
						</div><!-- End .entry-description -->

						<div class="entry-content standart-post-content">
							<?php the_excerpt(); ?>
						</div><!-- End .entry-content -->
					</article><!-- End .post-section .item -->

				<?php endwhile; ?>
			<?php endif; ?>

			<?php wp_reset_postdata(); // Use reset to restore original query. ?>

		</div><!-- End #et-posts .post-carousel --> 
	</div><!-- End .post-carousel-wrapper -->    
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#et-posts-<?php echo esc_attr( $id ) ;?>").owlCarousel({
				autoPlay: false, //Set AutoPlay to 3 seconds
				items : 3,
				itemsDesktop : [1199,3],
				itemsDesktopSmall : [979,3],
				navigation : false,
				pagination : false,
			}); 
		});
	</script>
<?php 
}
endif;


if ( ! function_exists( 'xclean_related_post' ) ) :
/**
 * Function that output carousel
 * with post thet have the same categori thet post thet output. 
 * 
 */

function xclean_related_post(){ 
	echo '<h2 class="single-standart-bot-heading">related post</h2>';
	$class = 'related-post';
	$id = rand(100,999);
		global $post;
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => '10',
			'category__in' => wp_get_post_categories( $post->ID ), 
			'post__not_in' => array( $post->ID )
		);
	et_post_carousel( $args, $class, $id );
}
endif;


if ( ! function_exists( 'xclean_breadcrumbs' )):
/*
 *
 * Breadcrumbs for WordPress
 * 
*/

function xclean_breadcrumbs() {

	$text['home'] 	  = esc_html__( 'home', 'xclean' ); 
	$text['category'] = esc_html__( 'categori arcive for "%s"', 'xclean' );
	$text['search']   = esc_html__( 'search for "%s"', 'xclean' ); 
	$text['tag'] 	  = esc_html__( 'tag: "%s"', 'xclean' );
	$text['author']   = esc_html__( 'posts by autor %s', 'xclean' );
	$text['404'] 	  = esc_html__( 'error 404', 'xclean' );
	$text['page'] 	  = esc_html__( 'page %s', 'xclean' );
	$text['cpage'] 	  = esc_html__( 'comment page %s', 'xclean' );

	$wrap_before 	= '<div class="breadcrumbs">';
	$wrap_after 	= '</div><!-- End .breadcrumbs -->';
	$sep 			= '<i class="fa fa-angle-right"></i>';
	$sep_before 	= '<span class="sep">';
	$sep_after 		= '</span>';
	$show_home_link = 1;
	$show_on_home   = 1;
	$show_current   = 1;
	$before 		= '<span class="current">';
	$after 			= '</span>';

	global $post;
	$home_link 		= esc_url( home_url( '/' ) );
	$link_before 	= '<span>';
	$link_after 	= '</span>';
	$link_attr 		= '';
	$link_in_before = '<span>';
	$link_in_after  = '</span>';
	$link 			= $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
	$frontpage_id   = get_option( 'page_on_front' );

	if ( empty( $post ) ) {
		$parent_id=0;
	} else {
		$parent_id = $post->post_parent;
	}
	$sep = ' ' . $sep_before . $sep . $sep_after . ' ';

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home ) echo $wrap_before . '<a href="' . $home_link . '">' . $text['home'] . '</a>' . $wrap_after;

	} else {

	echo $wrap_before;
	if ( $show_home_link ) echo sprintf( $link, $home_link, $text['home'] );

	if ( is_category() ) {
		$cat = get_category( get_query_var( 'cat' ), false );
		if ( $cat->parent != 0 ) {
			$cats = get_category_parents( $cat->parent, TRUE, $sep );
			$cats = preg_replace( "#^(.+)$sep$#", "$1", $cats );
			$cats = preg_replace( '#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats );
			if ( $show_home_link ) echo $sep;
			echo $cats;
		}

		if ( get_query_var( 'paged' ) ) {
			$cat = $cat->cat_ID;
			echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ) ) . $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
		} else {
			if ( $show_current ) echo $sep . $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
		}

	} elseif ( is_search() ) {
		if ( have_posts() ) {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . sprintf( $text['search'], get_search_query() ) . $after;
		} else {
			if ( $show_home_link ) echo $sep;
			echo $before . sprintf( $text['search'], get_search_query() ) . $after;
		}

	} elseif ( is_day() ) {
		if ( $show_home_link ) echo $sep;
		echo sprintf( $link, get_year_link(get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $sep;
		echo sprintf( $link, get_month_link(get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) );
		if ( $show_current ) echo $sep . $before . get_the_time( 'd' ) . $after;

	} elseif ( is_month() ) {
		if ( $show_home_link ) echo $sep;
		echo sprintf( $link, get_year_link(get_the_time( 'Y' )), get_the_time( 'Y' ) );
		if ( $show_current ) echo $sep . $before . get_the_time( 'F' ) . $after;

	} elseif ( is_year() ) {
		if ( $show_home_link && $show_current ) echo $sep;
		if ( $show_current ) echo $before . get_the_time( 'Y' ) . $after;

    } elseif ( is_single() && ! is_attachment() ) {
		if ( $show_home_link ) echo $sep;
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug = $post_type->rewrite;
			printf( $link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
			if ( $show_current ) echo $sep . $before . get_the_title() . $after;
		} else {
			$cat = get_the_category(); $cat = $cat[0];
			$cats = get_category_parents( $cat, TRUE, $sep );
			if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
			$cats = preg_replace( '#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats );
			echo $cats;
			if ( get_query_var( 'cpage' ) ) {
				echo $sep . sprintf( $link, get_permalink(), get_the_title() ) . $sep . $before . sprintf( $text['cpage'], get_query_var('cpage') ) . $after;
			} else {
				if ( $show_current ) echo $before . get_the_title() . $after;
			}
		}

    // custom post type
    } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
		$post_type = get_post_type_object( get_post_type() );
		if ( get_query_var( 'paged' ) ) {
			echo $sep . sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label ) . $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
		} else {
			if ( $show_current ) echo $sep . $before . $post_type->label . $after;
		}

	} elseif ( is_attachment() ) {
		if ( $show_home_link ) echo $sep;
		$parent = get_post( $parent_id );
		$cat = get_the_category( $parent->ID ); $cat = $cat[0];
		if ( $cat ) {
			$cats = get_category_parents( $cat, TRUE, $sep );
			$cats = preg_replace( '#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats );
			echo $cats;
		}
		printf( $link, get_permalink( $parent ), $parent->post_title );
		if ( $show_current ) echo $sep . $before . get_the_title() . $after;

	} elseif ( is_page() && ! $parent_id ) {
		if ( $show_current ) echo $sep . $before . get_the_title() . $after;

	} elseif ( is_page() && $parent_id ) {
		if ( $show_home_link ) echo $sep;
		if ( $parent_id != $frontpage_id ) {
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				if ( $parent_id != $frontpage_id ) {
					$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
				}
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
				echo $breadcrumbs[$i];
				if ( $i != count( $breadcrumbs )-1 ) echo $sep;
			}
		}
		if ( $show_current ) echo $sep . $before . get_the_title() . $after;

	} elseif ( is_tag() ) {
		if ( get_query_var( 'paged' ) ) {
			$tag_id = get_queried_object_id();
			$tag = get_tag( $tag_id );
			echo $sep . sprintf( $link, get_tag_link( $tag_id ), $tag->name ) . $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
		} else {
			if ( $show_current ) echo $sep . $before . sprintf( $text['tag'], single_tag_title( '', false) ) . $after;
		}

	} elseif ( is_author() ) {
		global $author;
		$author = get_userdata( $author );
		if ( get_query_var( 'paged' ) ) {
			if ( $show_home_link ) echo $sep;
			echo sprintf( $link, get_author_posts_url( $author->ID ), $author->display_name ) . $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
		} else {
			if ( $show_home_link && $show_current ) echo $sep;
			if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
		}

	} elseif ( is_404() ) {
		if ( $show_home_link && $show_current ) echo $sep;
		if ( $show_current ) echo $before . $text['404'] . $after;

	} elseif ( has_post_format() && ! is_singular() ) {
		if ( $show_home_link ) echo $sep;
		echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
}
endif;


if ( ! function_exists( 'xclean_navigation' ) ) :
/**
 *
 * Function that constract page navigation,
 * 
 */

function xclean_pagination() {
	global $wp_query;
	$pages = '';
	$max = $wp_query->max_num_pages;

	if ( ! $current = get_query_var( 'paged' ) ) $current = 1;

	$a['base'] 	  	= str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) );
	$a['total']   	= $max;
	$a['current']   = $current;
	$a['mid_size']  = 3;
	$a['end_size']  = 1;
	$a['prev_text'] = '<i class="fa fa-angle-left"></i>';
	$a['next_text'] = '<i class="fa fa-angle-right"></i>';

	if ( $max > 1 ) echo '<div class="pagination">' . $pages . paginate_links( $a ) . '</div><!-- End .pagination -->';

}
endif;


if ( ! function_exists( 'xclean_page_head' ) ) :
/**
 *
 * Function that constract breadcrumb,
 * 
 */

function xclean_page_head() { ?>
	<?php if ( ! is_front_page() ) : ?>
		<div class="page-head">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12 information-block">
						<h1 class="page-title">
							<?php
								if ( xclean_is_woo_exists() && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
									woocommerce_page_title();
								} else {
									if( xclean_blog() ) { 
										$posts_page_id = get_option( 'page_for_posts' );
										echo get_the_title( $posts_page_id ); 
									} elseif ( is_search() ) {
										echo get_search_query(); 
									} elseif ( is_category() ) {
										$cat = get_category( get_query_var( 'cat' ), false );
										echo $cat->name;
									} elseif ( is_tag() ) {
										$tag_id = get_queried_object_id();
										$tag = get_tag( $tag_id );
										echo $tag->name;
									} elseif ( is_author() ) {
										echo get_the_author();
									} elseif ( is_year() ) {
										echo get_the_time( 'Y' );
									} elseif ( is_month() ) {
										echo get_the_time( 'Y - F' );
									} elseif ( is_day() ) {
										echo get_the_time( 'Y - F - d' );
									} else {
										the_title();
									}
								}
							?>
						</h1>
						<div class="breadcrumb-block">
							<?php
								if ( xclean_is_woo_exists() && ( is_woocommerce() || is_cart() || is_checkout() ) ) {
									woocommerce_breadcrumb();
								} else {
									xclean_breadcrumbs();
								}
							?>
						</div><!-- End .breadcrumb-block -->
					</div><!-- End .col-md-6 .blog-big-title -->
					<div class="col-md-6 col-sm-6 col-xs-12 return-block">
						<a href="javascript: history.go(-1)"><?php esc_html_e( 'Return to Previous Page', 'xclean' ) ?></a>
					</div><!-- End .col-md-6 .retur-blok -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</div><!-- End .page-head -->
	<?php endif; ?>
<?php
} 
endif;


if ( ! function_exists( 'xclean_share_buttons' ) ) :
/**
 *
 * Function that constract social share buttons,
 * 
 */ 

function xclean_share_buttons() { ?>
	<?php 
		if ( xclean_is_woo_exists() && is_product() ) {
			$class = 'product-social';
		} else {
			$class = '';
		}
	?>
	<ul class="post-social <?php echo $class; ?>">
		<li>Share post</li>
		<li><a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?> /&title=<?php esc_html( the_title() ); ?>"><i class="fa fa-facebook"></i></a></li>
		<li><a href="http://twitter.com/home?status=<?php esc_html( the_title() ); ?>+<?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a></li>
		<li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a></li>
		<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php esc_html( the_title() ); ?>&summary=&source=<?php esc_url( get_home_url() ); ?>"><i class="fa fa-linkedin"></i></a></li>
	</ul>

<?php 
} 
endif;


if ( ! function_exists( 'xclean_paging_nav' ) ) :
/**
 *
 * Display the Previous/next post navigation.
 *
 */

function xclean_paging_nav() { ?>
	<div class="single-pagination">
		<ul class="pagination">
			<li class="pagination-previous">
				<?php $label = esc_html__( 'previous', 'xclean' ) ?>
				<?php previous_post_link( '%link', '<i class="fa fa-chevron-left"></i> ' . $label . '' ); ?>
			</li>
			<li class="pagination-next">
				<?php $label = esc_html__( 'next', 'xclean' ) ?>
				<?php next_post_link( '%link', '' . $label . ' <i class="fa fa-chevron-right"></i>' ); ?>
			</li> 
		</ul><!-- End .pagination -->
	</div><!-- End .single-pagination -->
<?php
}
endif;


if ( ! function_exists( 'xclean_post_meta' ) ) :
/**
 *
 * Display the meta information for a specific post.
 *
 */

function xclean_post_meta(){
	echo '<div class="meta-post">';
	echo '<ul class="list-inline entry-meta">';

	if ( get_post_type() === 'post' ) {
		// If the post is sticky, mark it.
		if ( is_sticky() ) {
			echo '<li class="meta-featured-post"><i class="fa fa-thumb-tack"></i>' . esc_html__( 'Sticky', 'xclean' ) . '</li>';
		}

		/**
 		 *  Get the categories list.
 		 */
		$category_list = get_the_category_list( ',' );
		if ( $category_list ) {
			echo '<li class="meta-categories">' . $category_list . '</li>';
		}

		/**
 		 *  Get the date.
 		 */
		echo '<li class="meta-date">' . get_the_date( 'F d, Y' ) . '</li>';

		/**
 		 *  Get the post author.
 		 */
		printf(
			'<li class="meta-author">By <a href="%1$s" rel="author">%2$s</a></li>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);

		/**
 		 *  Comments link.
 		 */
		if ( comments_open() ) {
			echo '<li class="meta-comment">';
			echo '<span class="meta-reply">';
			comments_popup_link( esc_html__( 'Leave a comment', 'xclean' ), esc_html__( 'One comment so far', 'xclean' ), esc_html__( 'View all %s comments', 'xclean' ) );
			echo '</span>';
			echo '</li>';
		}

		/**
 		 *  Edit link.
 		 */
		if ( is_user_logged_in() ) {
			echo '<li class="meta-edit">';
			edit_post_link( esc_html__( 'Edit', 'xclean' ), '<span class="meta-edit">', '</span>' );
			echo '</li>';
		}
	}
	echo '</ul>';
	echo '</div>';
}
endif;


if ( ! function_exists( 'xclean_excerpt_more' ) ) :
/**
 *
 * Change read more symbols.
 *
 */

function xclean_excerpt_more() {
	return '...';
}
add_filter( 'excerpt_more', 'xclean_excerpt_more' );
endif;


if ( ! function_exists( 'xclean_logo' ) ) :
/**
 *
 * Get the logo.
 *
 */

function xclean_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
	}
}
endif;


if ( ! function_exists( 'xclean_favicon' ) ) :
/**
 *
 * Get the favicon.
 *
 */

function xclean_favicon() {
	$default = XCLEAN_IMAGES . '/favicon.png';
	$new 	 = xclean_get_option( 'favicon' );
	
	if ( $new['url'] ) {
		$url = $new['url'];
	} else {
		$url = $default;
	}

	echo '<link rel="shortcut icon" href="' . esc_url( $url ) . '">';	
}

add_action( 'wp_head', 'xclean_favicon', 1000 );
endif;


if ( ! function_exists( 'xclean_custom_css' ) ) :
/**
 *
 * Add custom css.
 *
 */

function xclean_custom_css() { 
	if ( xclean_get_option( 'css_editor' ) ) {
		echo '<style type="text/css">' . xclean_get_option( 'css_editor' ) . '</style>';
	}
}
add_action( 'wp_head', 'xclean_custom_css', 1000 );
endif;


if ( ! function_exists( 'xclean_slider_class' ) ) :
/**
 *
 * Add custom css.
 *
 */

function xclean_slider_class() { ?>

	<?php if ( xclean_get_option( 'custom-style' ) == 'on' ) : ?>

		<script type="text/javascript">
			jQuery( document ).ready( function() {
				if ( jQuery( '.metaslider-flex' ).hasClass( 'metaslider' ) ){
					jQuery( 'body' ).addClass( 'wooslider' );
				}else{
					jQuery( 'body' ).removeClass( 'wooslider' );
				}
			});
		</script>

	<?php endif;
}
add_action( 'wp_footer', 'xclean_slider_class', 1000 );
endif;


if ( ! function_exists( 'xclean_count_posts' ) ) :
/**
 *
 * Display quantity of posts on the page.
 *
 */

function xclean_count_posts() {
	global $wp_query;
?>
<p class="coutn-posts">
	<?php
		$paged    = max( 1, $wp_query->get( 'paged' ) );
		$per_page = $wp_query->get( 'posts_per_page' );
		$total    = $wp_query->found_posts;
		$first    = ( $per_page * $paged ) - $per_page + 1;
		$last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
		$showing  = esc_html__( 'Showing', 'xclean' );

		if ( $total == 1 ) {
			$out = esc_html__( 'the single result', 'xclean' );
		} elseif ( $total <= $per_page || -1 === $per_page ) {
			$out = sprintf( '%1$s %2$d %3$s' , esc_html__( 'all', 'xclean' ), $total, esc_html__( 'posts', 'xclean' ) );
		} else {
			$out = sprintf( esc_html_x( ' %1$d&ndash;%2$d %4$s %3$d posts', '%1$d = first, %2$d = last, %3$d = total', 'xclean' ), $first, $last, $total, esc_html__( 'of', 'xclean' ) );
		}
		return printf( '<span>%1$s</span> %2$s ',$showing, $out );
	?>
</p>

<?php 
}
endif;


if ( ! function_exists( 'xclean_post_author_link' ) ) :
/**
 *
 * Get post author link end display it.
 *
 */

function xclean_post_author_link() {
	printf( '<h5 class="meta-author"><a href="%1$s" rel="author">%2$s</a></h5>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );						 
}
endif;


if ( ! function_exists( 'xclean_custom_link' ) ) :
/**
 *
 * Add link to the cart page.
 *
 */	
function xclean_custom_link() {
	if ( xclean_get_option( 'pages' ) ) {
		$title = esc_attr( xclean_get_option( 'pages' ) );
		$page  = get_page_by_title( $title );
		$url   = get_page_link( $page->ID );
		$title = $page->post_title;
		printf( '<a href="%1$s" class="coupon-link">%2$s %3$s</a>', esc_url( $url ), esc_html__( 'Go to', 'xclean' ), $title );
	}	
	
}
endif;
?>