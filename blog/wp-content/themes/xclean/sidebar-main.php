<?php
/**
 *
 * The template for the sidebar containing the main widget area
 *
 */
?>

<?php $settings = xclean_sidebars_setting(); ?>
<?php if ( $settings['status'] == 'on' ) : ?>
	<aside class="col-md-3 col-sm-12 col-xs-12 sidebar">
		<?php dynamic_sidebar( 'main-sidebar' ); ?>
	</aside><!-- End .sidebar -->
<?php endif ?>