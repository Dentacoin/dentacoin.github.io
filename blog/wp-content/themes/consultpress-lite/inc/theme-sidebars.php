<?php
/**
 * Register sidebars for ConsultPressLite
 *
 * @package consultpresslite-pt
 */

function consultpresslite_sidebars() {
	// Blog Sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'consultpress-lite' ),
			'id'            => 'blog-sidebar',
			'description'   => esc_html__( 'Sidebar on the blog layout.', 'consultpress-lite' ),
			'class'         => 'blog  sidebar',
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>',
		)
	);

	// Regular Page Sidebar.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Regular Page Sidebar', 'consultpress-lite' ),
			'id'            => 'regular-page-sidebar',
			'description'   => esc_html__( 'Sidebar on the regular page.', 'consultpress-lite' ),
			'class'         => 'sidebar',
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="sidebar__headings">',
			'after_title'   => '</h4>',
		)
	);

	// Header Widgets.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header', 'consultpress-lite' ),
			'id'            => 'header-widgets',
			'description'   => esc_html__( 'Header widget area for Text Widget.', 'consultpress-lite' ),
			'before_widget' => '<div class="widget  %2$s">',
			'after_widget'  => '</div>',
		)
	);

	// Footer.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'consultpress-lite' ),
			'id'            => 'footer-widgets',
			'description'   => esc_html__( 'Footer area works best with 3 widgets.', 'consultpress-lite' ),
			'before_widget' => '<div class="col-xs-12  col-lg-4"><div class="widget  %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="footer-top__heading">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'consultpresslite_sidebars' );
