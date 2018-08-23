<?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3. Note that it uses conditional logic to display
 * different content based on the post type.
 *
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<div class="container">
		<div class="row">
			<?php $settings = xclean_sidebars_setting(); ?>
			<div class="main-content <?php echo esc_attr( $settings['class'] ); ?>" role="main">

			<?php if ( have_posts() ) : ?>

				<!-- Post content. -->
				<?php while( have_posts() ) : the_post(); ?>
					<div class="single-post">
						<?php get_template_part( 'content', get_post_format() ); ?>
					</div><!-- End .single-post -->
				<?php endwhile; ?>
				
				<!-- Post tags. -->
				
					<?php 
						$tag_list = get_the_tag_list();
						
						if ( $tag_list ) : ?>
							<div class="single-tags">
								<?php echo $tag_list; ?>
							</div><!-- End .single-tags -->
						<?php endif;
					?>

				<!-- Post share buttons  -->
				<?php xclean_share_buttons(); ?>

				<!-- Post author section  -->
				<div class="post-by">
					<div class="user-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 106 ); ?>
					</div>
					<div class="post-by-content">
						<?php xclean_post_author_link(); ?>
						<p class="single-standart-paragraph"><?php echo get_the_author_meta( 'description' );?></p>		
					</div><!-- End .post-by-content -->
				</div><!-- End .post-by -->

				<!-- Comments section  -->
				<?php comments_template(); ?>

				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>

				<!-- End if have post-->
			<?php endif; ?>

			</div> <!-- End .main-content -->
			<?php get_sidebar( 'main' ); ?>
		</div><!-- End .row -->
	</div><!-- End .container -->
</div><!-- End #primary .content-area -->

<?php get_footer(); ?>