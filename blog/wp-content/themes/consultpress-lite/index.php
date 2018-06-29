<?php
/**
 * The main template file.
 *
 * Main blog page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package consultpresslite-pt
 */

get_header();

?>

	<div id="primary" class="content-area  container">
		<div class="row">
			<main id="main" class="site-main  col-xs-12  col-lg-9">
				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						?>

					<?php endwhile; ?>

					<?php
						the_posts_pagination( array(
							'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
							'next_text' => '<i class="fa fa-long-arrow-right"></i>',
						) );
					?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/content', 'none' ); ?>

				<?php endif; ?>
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
	</div>

<?php get_footer(); ?>
