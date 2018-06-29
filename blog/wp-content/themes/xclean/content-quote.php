<?php
/**
 *
 * The default template for displaying post's with quote post format .
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
	<div class="entry-content">
		<?php
			the_content( esc_html__( 'Continue reading, &rarr;', 'xclean' ) );
			wp_link_pages();
		?>
	</div><!-- End .entry-content -->

	<div class="entry-inside">
		<?php if ( ! is_single() ) : ?>
			<a href="<?php esc_url( the_permalink() ); ?>" class="read-more-button"><?php esc_html_e( 'Read more', 'xclean' ); ?></a>
		<?php endif; ?>
	</div><!-- End .entry-inside -->
</article><!-- End #post-## -->