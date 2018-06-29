<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="description" content="<?php bloginfo( 'description' ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
	<header class="header">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-12 col-xs-12 site-logo">
					<?php xclean_logo(); ?>
				</div><!-- End .header-logo -->
				<div class="col-md-9 col-sm-12 col-xs-12 header-navigation">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
          		</button>
          			<div id="navbar" class="navbar-collapse collapse" aria-expanded="false" role="navigation">
					<?php
						if ( has_nav_menu( 'header-nav' ) ) {
						 	wp_nav_menu( array(
									'theme_location' => 'header-nav',
									'menu_class'     => 'header-nav'
							) );
						}
					?>

					</div>
					<div class="header-cart">

						<?php if ( xclean_is_woo_exists() ) : ?>

							<?php xclean_cart_link(); ?>
							<?php xclean_cart_dropdown(); ?>

						<?php endif; ?>

					</div><!-- End .header-cart -->

					<div class="header-search">
							<img src="<?php echo esc_url( XCLEAN_IMAGES . '/search.png' ); ?>" alt="img-search">
							<div class="search-inside">
								<?php get_search_form(); ?>
								<i class="fa fa-times"></i>
							</div>
					</div><!-- End .header-serch -->
				</div><!-- End .header-navigation -->
			</div><!-- End .header-top -->

			<?php if ( get_header_image() ) : ?>
				<img src="<?php esc_url( header_image() ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<?php endif; ?>

		</div><!-- End .container -->
	</header><!-- End .header -->
	<div id="content" class="site-content">
