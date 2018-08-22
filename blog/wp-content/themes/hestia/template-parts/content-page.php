<?php
/**
 * The default template for displaying content
 *
 * Used for pages.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
?>

<?php
$hestia_page_sidebar_layout = get_theme_mod( 'hestia_page_sidebar_layout', 'full-width' );
$individual_layout          = get_post_meta( get_the_ID(), 'hestia_layout_select', true );
if ( ! empty( $individual_layout ) && $individual_layout !== 'default' ) {
	$hestia_page_sidebar_layout = $individual_layout;
}

$args         = array(
	'sidebar-right' => 'col-md-9 page-content-wrap',
	'sidebar-left'  => 'col-md-9 page-content-wrap',
	'full-width'    => 'col-md-8 col-md-offset-2 page-content-wrap',
);
$class_to_add = hestia_get_content_classes( $hestia_page_sidebar_layout, 'sidebar-1', $args );
?>

	<article id="post-<?php the_ID(); ?>" class="section section-text">
		<div class="row">
			<?php
			if ( $hestia_page_sidebar_layout === 'sidebar-left' ) {
				hestia_get_sidebar();
			}
			?>
			<div class="<?php echo esc_attr( $class_to_add ); ?>">
				<?php the_content(); ?>
			</div>
			<?php
			if ( $hestia_page_sidebar_layout === 'sidebar-right' ) {
				hestia_get_sidebar();
			}
			?>
		</div>
	</article>
<?php
if ( is_paged() ) {
	hestia_single_pagination();
}
