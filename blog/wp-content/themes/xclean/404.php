<?php
/**
 *
 * The template for displaying 404 pages (not found)
 *
 */
?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="container site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h2>404</h2>
					<h3 class="page-title"><?php esc_html_e( 'Oops! page not found', 'xclean' ); ?></h3>
					<p><?php esc_html_e( 'Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.', 'xclean' ); ?></p>
				</header><!-- End .page-header -->

				<div class="page-content">

					<?php get_search_form(); ?>

					<a href="<?php echo esc_url( get_home_url() ); ?>"><?php esc_html_e( 'Go to Home Page', 'xclean' ); ?></a>
				</div><!-- End .page-content -->
			</section><!-- End .error-404 -->

		</main><!-- End #main site-main -->
	</div><!-- End #primary .content-area -->
		
<?php get_footer(); ?>