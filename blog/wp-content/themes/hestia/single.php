<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

get_header();
?>
	<div id="primary" class="<?php echo hestia_boxed_layout_header(); ?> page-header header-small">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<h1 class="hestia-title"><?php single_post_title(); ?></h1>
					<h4 class="author">
						<?php
						echo apply_filters(
							'hestia_single_post_meta', sprintf(
								/* translators: %1$s is Author name wrapped, %2$s is Date*/
								esc_html__( 'Published by %1$s on %2$s', 'hestia' ),
								/* translators: %1$s is Author name, %2$s is Author link*/
								sprintf(
									'<a href="%2$s" class="vcard author"><strong class="fn">%1$s</strong></a>',
									esc_html( hestia_get_author( 'display_name' ) ),
									esc_url( get_author_posts_url( hestia_get_author( 'ID' ) ) )
								),
								/* translators: %s is Date */
								sprintf(
									'<time class="date updated published" datetime="%2$s">%1$s</time>',
									esc_html( get_the_time( get_option( 'date_format' ) ) ), esc_html( get_the_date( DATE_W3C ) )
								)
							)
						);
						?>
						</h4>
				</div>
			</div>
		</div>
		<?php hestia_output_wrapper_header_background( false ); ?>
	</div>
</header>
<div class="<?php echo hestia_layout(); ?>">
	<div class="blog-post blog-post-wrapper">
		<div class="container">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'single' );
				endwhile;
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
	</div>
</div>
<?php do_action( 'hestia_blog_related_posts' ); ?>
<div class="footer-wrapper">
	<?php get_footer(); ?>
