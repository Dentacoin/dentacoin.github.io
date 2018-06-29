<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 */
?>

<?php get_header(); ?>

<?php xclean_page_head(); ?>

<div class="container">
	<div class="row main-content" role="main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="col-md-4 blog-post">
				<?php get_template_part( 'content', get_post_format() ); ?>
			</div><!-- End .col-md-4 -->
		<?php endwhile; ?>
		
		<div class="pagination-block">
			<?php xclean_count_posts(); ?>
			<?php xclean_pagination(); ?>
		</div><!-- End .pagination-block -->
			
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div> <!-- End .row .main-content -->
</div><!-- End .container -->

<?php get_footer(); ?>