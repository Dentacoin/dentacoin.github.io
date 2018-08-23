<?php
/**
 * Main Navigation
 *
 * @package consultpresslite-pt
 */

if ( has_nav_menu( 'main-menu' ) ) {
?>

<nav class="sidebar__main-navigation  collapse  navbar-toggleable-md  js-sticky-desktop-option  hidden-md-down" id="consultpresslite-main-navigation-desktop" aria-label="<?php esc_html_e( 'Main Menu', 'consultpress-lite' ); ?>">
	<?php
		wp_nav_menu( array(
			'theme_location' => 'main-menu',
			'container'      => false,
			'menu_class'     => 'main-navigation  js-main-nav  js-dropdown',
			'walker'         => new Aria_Walker_Nav_Menu(),
			'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
		) );
	?>
</nav>

<?php
}
