<?php
/**
 * 404 page
 *
 * @package consultpresslite-pt
 */

get_header();

?>

<div id="primary" class="content-area  error-404  container">
	<div class="row">
		<main id="main" class="site-main  col-xs-12  col-lg-9">
			<p class="h2  error-404__subtitle"><?php esc_html_e( 'You landed on the wrong side of the page' , 'consultpress-lite' ); ?></p>
			<p class="error-404__text">
			<?php
				printf(
					/* translators: the first %s for line break, the second and third %s for link to home page wrap */
					esc_html__( 'Page you are looking for is not here. %1$s Go %2$sHome%3$s or try to search:' , 'consultpress-lite' ),
					'<br>',
					'<b><a href="' . esc_url( home_url( '/' ) ) . '">',
					'</a></b>'
				);
			?>
			</p>
			<div class="widget_search">
				<?php get_search_form(); ?>
			</div>
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
					<?php dynamic_sidebar( apply_filters( 'consultpresslite_regular_page_sidebar', 'regular-page-sidebar', get_the_ID() ) ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
