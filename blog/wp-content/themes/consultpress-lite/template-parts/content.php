<?php
/**
 * Template part for displaying posts.
 *
 * @package consultpresslite-pt
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'h-entry', 'clearfix' ) ); ?>>
	<!-- Featured Image and Date -->
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="article__featured-image-link" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-fluid  article__featured-image  u-photo' ) ); ?>
		</a>
	<?php endif; ?>

	<!-- Content Box -->
	<div class="article__content">
		<div class="article__meta">
			<!-- Categories -->
			<?php if ( has_category() ) : ?>
				<span class="article__categories"><?php the_category( ' ' ); ?></span>
			<?php endif; ?>
			<!-- Author -->
			<span class="article__author"><i class="fa fa-user" aria-hidden="true"></i><span class="p-author"><?php the_author(); ?></span></span>
			<!-- Date -->
			<a class="article__date" href="<?php the_permalink(); ?>"><time class="dt-published" datetime="<?php the_time( 'c' ); ?>"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo get_the_date(); ?></time></a>
		</div>
		<!-- Content -->
		<?php the_title( sprintf( '<h2 class="article__title  p-name"><a class="article__title-link  u-url" href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php
		$consultpresslite_is_excerpt = ( 1 === (int) get_option( 'rss_use_excerpt', 0 ) );
		if ( $consultpresslite_is_excerpt ) : ?>
			<p class="e-content">
				<?php echo wp_kses_post( get_the_excerpt() ); ?>
			</p>
			<p>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php printf( esc_html__( 'Read more %s', 'consultpress-lite' ), the_title( '<span class="screen-reader-text">', '</span>', false ) ); ?></a>
			</p>
		<?php else :
			/* translators: %s: Name of current post */
			the_content( sprintf(
				esc_html__( 'Read more %s', 'consultpress-lite' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		endif;
		?>
	</div><!-- .article__content -->
</article><!-- .article -->
