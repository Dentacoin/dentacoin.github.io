<?php
/**
 * Search form
 *
 * @package consultpresslite-pt
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'consultpress-lite' ); ?></span>
		<input type="search" class="form-control  search-field" placeholder="<?php esc_html_e( 'Search', 'consultpress-lite' ); ?>" value="" name="s">
	</label>
	<button type="submit" class="search-submit"><i class="fa  fa-search"></i></button>
</form>
