<?php
/**
 * The page title part of the header
 *
 * @package consultpresslite-pt
 */

$consultpresslite_blog_id = absint( get_option( 'page_for_posts' ) );

?>

<div class="header__page-header  page-header">
	<?php
	$consultpresslite_main_tag = 'h1';

	if ( is_home() || ( is_single() && 'post' === get_post_type() ) ) {
		$consultpresslite_title    = 0 === $consultpresslite_blog_id ? esc_html__( 'Blog', 'consultpress-lite' ) : get_the_title( $consultpresslite_blog_id );

		if ( is_single() ) {
			$consultpresslite_main_tag = 'h2';
		}
	}
	elseif ( is_category() || is_tag() || is_author() || is_post_type_archive() || is_tax() || is_day() || is_month() || is_year() ) {
		$consultpresslite_title = get_the_archive_title();
	}
	elseif ( is_search() ) {
		$consultpresslite_title = esc_html__( 'Search Results For' , 'consultpress-lite' ) . ' &quot;' . get_search_query() . '&quot;';
	}
	elseif ( is_404() ) {
		$consultpresslite_title = esc_html__( 'Error 404' , 'consultpress-lite' );
	}
	else {
		$consultpresslite_title    = get_the_title();
	}

	?>

	<?php printf( '<%1$s class="page-header__title">%2$s</%1$s>', tag_escape( $consultpresslite_main_tag ), wp_kses_post( $consultpresslite_title ) ); ?>

</div>
