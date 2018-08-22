<?php
/**
 * The template for displaying all single posts.
 *
 * @package consultpresslite-pt
 */

get_header();

?>

	<div id="primary" class="content-area  container">
		<div class="row">
			<main id="main" class="site-main  col-xs-12  col-lg-9">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>

				<?php endwhile; // End of the loop. ?>
			</main>

			<div class="col-xs-12  col-lg-3">
				<div class="sidebar  js-sidebar">
					<div class="sidebar__shift">
						<!-- Header widget area -->
						<?php get_template_part( 'template-parts/header-widget-area' ); ?>
						<!-- Featured Button -->
						<?php get_template_part( 'template-parts/featured-button' ); ?>
						<!-- Main Navigation -->
						<?php get_template_part( 'template-parts/main-navigation' ); ?>
						<!-- Sidebar -->
						<?php dynamic_sidebar( apply_filters( 'consultpresslite_blog_sidebar', 'blog-sidebar', get_the_ID() ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
