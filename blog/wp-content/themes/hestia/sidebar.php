<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Hestia
 * @since Hestia 1.0.0
 * @modified 1.1.30
 */

$class_to_add          = '';
$hestia_sidebar_layout = '';

$default_blog_layout   = hestia_sidebar_on_single_post_get_default();
$hestia_sidebar_layout = get_theme_mod( 'hestia_blog_sidebar_layout', $default_blog_layout );
$hestia_sidebar_width  = get_theme_mod( 'hestia_sidebar_width', 25 );

$individual_layout = get_post_meta( get_the_ID(), 'hestia_layout_select', true );
if ( ! empty( $individual_layout ) && $individual_layout !== 'default' ) {
	$hestia_sidebar_layout = $individual_layout;
}

if ( $hestia_sidebar_layout === 'sidebar-right' && $hestia_sidebar_width > 3 && $hestia_sidebar_width < 80 && ! is_page() ) {
	$class_to_add = 'col-md-offset-1';
}

if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
	<div class="col-md-3 blog-sidebar-wrapper <?php echo esc_attr( $class_to_add ); ?>">
		<aside id="secondary" class="blog-sidebar" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside><!-- .sidebar .widget-area -->
	</div>
	<?php
} elseif ( is_customize_preview() ) {
	hestia_sidebar_placeholder( $class_to_add, 'sidebar-1' );
} ?>
