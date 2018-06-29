<?php
/**
 *
 * Template for displaying search forms in xclean.
 *
 */
?>

<?php
if ( xclean_is_woo_exists() ) {
	$value = 'product';
} else {
	$value = 'post';
}
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<input type="hidden" name="post_type" value="<?php echo $value; ?>" >
		<label class="screen-reader-text" for="s"><?php esc_html_x( 'Search for:', 'label' ,'xclean' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'xclean' ); ?>" />
	</div>
</form>