<?php
/**
 *
 * The default template for displaying post's with gallery post format.
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
	<?php if ( get_post_gallery_images() && ! post_password_required() ) : ?>
		<header class="entry-header">
			<div class="entry-thumbnail post-thumbnail">
				<?php xclean_post_galery_slider(); ?>
			</div>

			<div class="entry-inside">
				<?php if ( ! is_single() ) : ?>
					<a href="<?php esc_url( the_permalink() ); ?>" class="read-more-button"><?php esc_html_e( 'Read more', 'xclean' ); ?></a>
				<?php endif; ?>
			</div><!-- End .entry-inside -->
		</header><!-- End .entry-header -->
	<?php endif; ?>

	<div class="entry-description">
		<?php if ( is_single() ) : ?>
			<h2><?php esc_html( the_title() ); ?></h2>
		<?php else : ?>
			<h2><a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark"><?php esc_html( the_title() ); ?></a></h2>
		<?php endif; ?>

		<div class="entry-meta "><?php xclean_post_meta(); ?></div>
	</div><!-- End .entry-description -->

	<div class="entry-content">
		<?php
			if ( is_single() ) {
				the_content( '' );
				wp_link_pages();
			} else {
				the_excerpt();
			}
		?>
	</div><!-- End .entry-content -->
</article><!-- End #post-## -->