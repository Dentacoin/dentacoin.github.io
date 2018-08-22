<?php
/**
 * Theme info page
 *
 * @package Sydney
 */

//Add the theme page
add_action('admin_menu', 'sydney_add_theme_info');
function sydney_add_theme_info(){
	$theme_info = add_theme_page( __('Sydney Info','sydney'), __('Sydney Info','sydney'), 'manage_options', 'sydney-info.php', 'sydney_info_page' );
    add_action( 'load-' . $theme_info, 'sydney_info_hook_styles' );
}

//Callback
function sydney_info_page() {
?>
	<div class="info-container">
		<h2 class="info-title"><?php _e('Sydney Info','sydney'); ?></h2>
		<div class="info-block"><div class="dashicons dashicons-desktop info-icon"></div><p class="info-text"><a href="http://demo.athemes.com/sydney" target="_blank"><?php _e('Theme demo','sydney'); ?></a></p></div>
		<div class="info-block"><div class="dashicons dashicons-book-alt info-icon"></div><p class="info-text"><a href="http://athemes.com/documentation/sydney" target="_blank"><?php _e('Documentation','sydney'); ?></a></p></div>
		<div class="info-block"><div class="dashicons dashicons-sos info-icon"></div><p class="info-text"><a href="http://athemes.com/forums" target="_blank"><?php _e('Support','sydney'); ?></a></p></div>
		<div class="info-block"><div class="dashicons dashicons-smiley info-icon"></div><p class="info-text"><a href="http://athemes.com/theme/sydney-pro" target="_blank"><?php _e('Pro version','sydney'); ?></a></p></div>	
	</div>
<?php
}

//Styles
function sydney_info_hook_styles(){
   	add_action( 'admin_enqueue_scripts', 'sydney_info_page_styles' );
}
function sydney_info_page_styles() {
	wp_enqueue_style( 'sydney-info-style', get_template_directory_uri() . '/css/info-page.css', array(), true );
}