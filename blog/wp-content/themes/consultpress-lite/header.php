<?php
/**
 * The Header for ConsultPressLite Theme
 *
 * @package consultpresslite-pt
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php endif; ?>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
	<div class="boxed-container<?php echo ( is_single() && 'post' === get_post_type() ) ? '  h-entry' : ''; ?>">

	<header class="header__container">
		<div class="container">
			<div class="header">
				<div class="container">
					<!-- Logo -->
					<a class="header__logo<?php echo ! has_custom_logo() ? '  header__logo--text' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php if ( has_custom_logo() ) : ?>

							<?php
								$custom_logo_id = get_theme_mod( 'custom_logo' );
								$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
								$consultpress_logo = $image[0];
							?>

							<img src="<?php echo esc_url( $consultpress_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="img-fluid" />
						<?php else : ?>
							<p class="h1  header__logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
						<?php endif; ?>
					</a>
					<!-- Only on mobile Header Widgets -->
					<?php if ( is_active_sidebar( 'header-widgets' ) ) : ?>
						<div class="sidebar__header-widgets  header-widgets  hidden-lg-up">
							<?php dynamic_sidebar( apply_filters( 'consultpresslite_header_widgets', 'header-widgets', get_the_ID() ) ); ?>
						</div>
					<?php endif; ?>
					<!-- Only on mobile Featured Button -->
					<?php
						$featured_page_data = ConsultPressLiteHelpers::get_featured_page_data();

						if ( ! empty( $featured_page_data ) ) :
					?>
						<a class="btn  btn-primary  btn-block  btn-featured  hidden-lg-up" href="<?php echo esc_url( $featured_page_data['url'] ); ?>" target="<?php echo esc_attr( $featured_page_data['target'] ); ?>"><?php echo esc_html( $featured_page_data['title'] ); ?></a>
					<?php endif; ?>
					<!-- Toggle button for Main Navigation on mobile -->
					<button class="btn  btn-dark  btn-block  header__navbar-toggler  hidden-lg-up  js-sticky-mobile-option" type="button" data-toggle="collapse" data-target="#consultpresslite-main-navigation"><i class="fa  fa-bars  hamburger"></i> <span><?php esc_html_e( 'MENU' , 'consultpress-lite' ); ?></span></button>
					<!-- Only on mobile Main Navigation -->
					<nav class="sidebar__main-navigation  collapse  navbar-toggleable-md  js-sticky-desktop-option  hidden-lg-up" id="consultpresslite-main-navigation" aria-label="<?php esc_html_e( 'Main Menu', 'consultpress-lite' ); ?>">
						<?php
						if ( has_nav_menu( 'main-menu' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'main-menu',
								'container'      => false,
								'menu_class'     => 'main-navigation  js-main-nav  js-dropdown',
								'walker'         => new Aria_Walker_Nav_Menu(),
								'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
							) );
						}
						?>
					</nav>
				</div>
				<!-- Page Header -->
				<?php get_template_part( 'template-parts/page-header' ); ?>
			</div>
		</div>
	</header>
