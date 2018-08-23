<?php 
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */
?>

<?php get_header(); ?>
<?php xclean_page_head(); ?>
<div class="container">
	<?php while( have_posts() ) : the_post(); ?>
		<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
			</div> <!-- End .entry-content -->
		</div>
	<?php endwhile; ?>
</div><!-- End .container -->

<?php get_footer(); ?>