<?php
/**
 * The template for displaying attachments.
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
						printf(
							/* translators: %1$s is Author name, %2$s is Date */
							esc_html__( 'Published by %1$s on %2$s', 'hestia' ),
							/* translators: %1$s is Author display name, %2$s is Author link */
							sprintf(
								'<a href="%2$s"><b>%1$s</b></a>',
								esc_html( hestia_get_author( 'display_name' ) ),
								esc_url( get_author_posts_url( hestia_get_author( 'ID' ) ) )
							),
							/* translators: %s is Date */
							sprintf(
								'<time>%s</time>',
								esc_html( get_the_time( get_option( 'date_format' ) ) )
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
?>

				<div class="entry-attachment section section-text">
					<?php
					if ( wp_attachment_is_image( $post->ID ) ) :
						$att_image = wp_get_attachment_image_src( $post->id, 'full' );
						?>
						<a href="<?php echo esc_url( wp_get_attachment_url( $post->id ) ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<img src="<?php echo esc_url( $att_image[0] ); ?>" width="<?php echo esc_attr( $att_image[1] ); ?>" height="<?php echo esc_attr( $att_image[2] ); ?>" class="attachment-medium" alt="<?php esc_attr( $post->post_excerpt ); ?>"/>
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_get_attachment_url( $post->ID ) ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
							<?php echo basename( $post->guid ); ?>
						</a>
					<?php endif; ?>

									<p class="sizes">
						<?php

						if ( wp_attachment_is_image( get_the_ID() ) ) {
						?>
					<div class="image-meta">
						<?php
						echo '<i class="fa fa-camera"></i> ';
						/* translators: %s is Image sizes for attachment single page. */
						printf( esc_html__( 'Size: %s', 'hestia' ), hestia_get_image_sizes() );
						?>
					</div>
				<?php } ?>
									</p>

									<?php
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
									?>
								</div>

							<?php endwhile; ?>

			<?php endif; ?>

		</div>
	</div>
</div>
<div class="<?php echo hestia_layout(); ?>">
	<?php get_footer(); ?>
