<?php
/**
 * Display notification message when plugin options are saved
 */
function the_champ_settings_saved_notification(){
	if(isset($_GET['settings-updated']) && sanitize_text_field($_GET['settings-updated']) == 'true'){
		return '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible below-h2"> 
<p><strong>' . __('Settings saved', 'super-socializer') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . __('Dismiss this notice', 'super-socializer') . '</span></button></div>';
	}
}

/**
 * Display Social Login notifications
 */
function the_champ_login_notifications($loginOptions){
	$errorHtml = '';
	if(isset($loginOptions['enable']) && isset($loginOptions['providers'])){
		if(in_array('facebook', $loginOptions['providers']) && (!isset($loginOptions['fb_key']) || $loginOptions['fb_key'] == '' || !isset($loginOptions['fb_secret']) || $loginOptions['fb_secret'] == '')){
			$errorHtml .= the_champ_error_message('Specify Facebook App ID and Secret in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Facebook Login to work');
		}
		if(in_array('xing', $loginOptions['providers']) && (!isset($loginOptions['xing_ck']) || $loginOptions['xing_ck'] == '' || !isset($loginOptions['xing_cs']) || $loginOptions['xing_cs'] == '')){
			$errorHtml .= the_champ_error_message('Specify Xing Consumer Key and Secret in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Xing Login to work');
		}
		if(in_array('twitter', $loginOptions['providers']) && (!isset($loginOptions['twitter_key']) || $loginOptions['twitter_key'] == '' || !isset($loginOptions['twitter_secret']) || $loginOptions['twitter_secret'] == '')){
			$errorHtml .= the_champ_error_message('Specify Twitter Consumer Key and Secret in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Twitter Login to work');
		}
		if(in_array('linkedin', $loginOptions['providers']) && (!isset($loginOptions['li_key']) || $loginOptions['li_key'] == '' || !isset($loginOptions['li_secret']) || $loginOptions['li_secret'] == '')){
			$errorHtml .= the_champ_error_message('Specify LinkedIn Client ID and Secret in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for LinkedIn Login to work');
		}
		if(in_array('google', $loginOptions['providers']) && (!isset($loginOptions['google_key']) || $loginOptions['google_key'] == '' || !isset($loginOptions['google_secret']) || $loginOptions['google_secret'] == '')){
			$errorHtml .= the_champ_error_message('Specify GooglePlus Client ID and Secret in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for GooglePlus Login to work');
		}
		if(in_array('vkontakte', $loginOptions['providers']) && (!isset($loginOptions['vk_key']) || $loginOptions['vk_key'] == '' || !isset($loginOptions['vk_secure_key']) || $loginOptions['vk_secure_key'] == '')){
			$errorHtml .= the_champ_error_message('Specify Vkontakte Application ID and Secret Key in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Vkontakte Login to work');
		}
		if(in_array('instagram', $loginOptions['providers']) && (!isset($loginOptions['insta_id']) || $loginOptions['insta_id'] == '')){
			$errorHtml .= the_champ_error_message('Specify Instagram Client ID in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Instagram Login to work');
		}
		if(in_array('steam', $loginOptions['providers']) && (!isset($loginOptions['steam_api_key']) || $loginOptions['steam_api_key'] == '')){
			$errorHtml .= the_champ_error_message('Specify Steam API Key in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Steam Login to work');
		}
		if(in_array('twitch', $loginOptions['providers']) && (!isset($loginOptions['twitch_client_id']) || $loginOptions['twitch_client_id'] == '' || !isset($loginOptions['twitch_client_secret']) || $loginOptions['twitch_client_secret'] == '')){
			$errorHtml .= the_champ_error_message('Specify Twitch Client ID and Secret in <strong>Super Socializer</strong> > <strong>Social Login</strong> section in admin panel for Twitch Login to work');
		}
	}
	return $errorHtml;
}

/**
 * General options page of plugin in admin area
 */
function the_champ_general_options_page(){
	// facebook options
	global $theChampGeneralOptions;
	// message on saving options
	echo the_champ_settings_saved_notification();
	require 'admin/general_options.php';
}

/**
 * Facebook option page of plugin in WP admin.
 */
function the_champ_facebook_page(){
	// facebook options
	global $theChampFacebookOptions;
	// message on saving options
	echo the_champ_settings_saved_notification();
	require 'admin/social_commenting.php';
}

/**
 * Social Login page of plugin in WP admin.
 */
function the_champ_social_login_page(){
	// social login options
	global $theChampLoginOptions, $theChampFacebookOptions, $theChampIsBpActive;
	// message on saving options
	echo the_champ_settings_saved_notification();
	echo the_champ_login_notifications($theChampLoginOptions);
	require 'admin/social_login.php';
}

/**
 * Social Sharing page of plugin in WP admin.
 */
function the_champ_social_sharing_page(){
	// social sharing options
	global $theChampSharingOptions, $theChampIsBpActive;
	if(!isset($theChampSharingOptions['horizontal_sharing_size'])){
		$theChampSharingOptions['horizontal_sharing_size'] = 30;
	}
	if(!isset($theChampSharingOptions['horizontal_sharing_shape'])){
		$theChampSharingOptions['horizontal_sharing_shape'] = 'round';
	}
	if(!isset($theChampSharingOptions['vertical_sharing_size'])){
		$theChampSharingOptions['vertical_sharing_size'] = 35;
	}
	if(!isset($theChampSharingOptions['vertical_sharing_shape'])){
		$theChampSharingOptions['vertical_sharing_shape'] = 'square';
	}
	// message on saving options
	echo the_champ_settings_saved_notification();
	require 'admin/social_sharing.php';
}

/**
 * Like buttons page of plugin in WP admin.
 */
function the_champ_like_buttons_page(){
	// social counter options
	global $theChampCounterOptions, $theChampIsBpActive;
	// message on saving options
	echo the_champ_settings_saved_notification();
	require 'admin/like_buttons.php';
}

/** 
 * Validate plugin options.
 *
 * IMPROVEMENT: complexity can be reduced (this function is called on each option page validation and "if($k == 'providers'){"
 * condition is being checked every time)
 */ 
function the_champ_validate_options($theChampOptions){
	foreach($theChampOptions as $k => $v){
		if(is_string($v)){
			$theChampOptions[$k] = esc_attr(trim($v));
		}
	}
	return $theChampOptions;
}

/**
 * Register plugin settings and its sanitization callback
 */
function the_champ_options_init(){
	register_setting('the_champ_facebook_options', 'the_champ_facebook', 'the_champ_validate_options');
	register_setting('the_champ_login_options', 'the_champ_login', 'the_champ_validate_options');
	register_setting('the_champ_sharing_options', 'the_champ_sharing', 'the_champ_validate_options');
	register_setting('the_champ_counter_options', 'the_champ_counter', 'the_champ_validate_options');
	register_setting('the_champ_general_options', 'the_champ_general', 'the_champ_validate_options');
	if(the_champ_social_sharing_enabled() || the_champ_social_counter_enabled() || the_champ_social_commenting_enabled()){
		// show option to disable sharing on particular page/post
		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		$post_types = array_unique( array_merge( $post_types, array( 'post', 'page' ) ) );
		foreach($post_types as $type){
			add_meta_box('the_champ_meta', 'Super Socializer', 'the_champ_sharing_meta_setup', $type);
		}
		// save sharing meta on post/page save
		add_action('save_post', 'the_champ_save_sharing_meta');
	}
}
add_action('admin_init', 'the_champ_options_init');

/**
 * Include javascript files in admin
 */	
function the_champ_admin_scripts(){
	?>
	<script>var theChampWebsiteUrl = '<?php echo esc_url(home_url()) ?>', theChampHelpBubbleTitle = "<?php echo __('Click to show help', 'super-socializer') ?>", theChampHelpBubbleCollapseTitle = "<?php echo __('Click to hide help', 'super-socializer') ?>" </script>
	<?php
	wp_enqueue_script('the_champ_admin_script', plugins_url('js/admin/admin.js', __FILE__), array('jquery', 'jquery-ui-tabs'), THE_CHAMP_SS_VERSION);
}

/**
 * Include Javascript SDK in admin
 */	
function the_champ_fb_sdk_script(){
	wp_enqueue_script('the_champ_fb_sdk_script', plugins_url('js/admin/fb_sdk.js', __FILE__), false, THE_CHAMP_SS_VERSION);
}

/**
 * Include javascript files in admin sharing page.
 */	
function the_champ_admin_sharing_scripts(){
	?>
	<script type="text/javascript"> var theChampSharingAjaxUrl = '<?php echo get_admin_url() ?>admin-ajax.php';</script>
	<?php
	wp_enqueue_script('the_champ_sharing', plugins_url('js/admin/sharing/admin.js', __FILE__), array('jquery', 'jquery-ui-sortable'), THE_CHAMP_SS_VERSION);
}

/**
 * Include javascript files in admin counter page.
 */	
function the_champ_admin_counter_scripts(){
	?>
	<script type="text/javascript"> var theChampSharingAjaxUrl = '<?php echo get_admin_url() ?>admin-ajax.php';</script>
	<?php
	wp_enqueue_script('the_champ_counter', plugins_url('js/admin/counter/admin.js', __FILE__), array('jquery', 'jquery-ui-sortable'), THE_CHAMP_SS_VERSION);
}

/**
 * Include CSS files in admin.
 */	
function the_champ_admin_style(){
	wp_enqueue_style('the_champ_admin_style', plugins_url('css/admin.css', __FILE__), false, THE_CHAMP_SS_VERSION);
}

/**
 * Include CSS files at sharing options page in admin
 */	
function the_champ_admin_sharing_style(){
	global $theChampSharingOptions;
	
	wp_enqueue_style( 'the_champ_admin_svg', plugins_url( 'css/share-svg.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
	if( $theChampSharingOptions['horizontal_font_color_default'] != '' ) {
		$updated = the_champ_update_css( 'horizontal_sharing_replace_color', 'horizontal_font_color_default', 'share-default-svg-horizontal' );
		wp_enqueue_style( 'the_champ_admin_svg_horizontal', plugins_url( 'css/share-default-svg-horizontal.css', __FILE__ ), false, ( $updated === true ? rand() :  THE_CHAMP_SS_VERSION ) );
	}
	if( $theChampSharingOptions['horizontal_font_color_hover'] != '' ) {
		$updated = the_champ_update_css( 'horizontal_sharing_replace_color_hover', 'horizontal_font_color_hover', 'share-hover-svg-horizontal' );
		wp_enqueue_style( 'the_champ_admin_svg_horizontal_hover', plugins_url( 'css/share-hover-svg-horizontal.css', __FILE__ ), false, ( $updated === true ? rand() :  THE_CHAMP_SS_VERSION ) );
	}
	if( $theChampSharingOptions['vertical_font_color_default'] != '' ) {
		$updated = the_champ_update_css( 'vertical_sharing_replace_color', 'vertical_font_color_default', 'share-default-svg-vertical' );
		wp_enqueue_style( 'the_champ_admin_svg_vertical', plugins_url( 'css/share-default-svg-vertical.css', __FILE__ ), false, ( $updated === true ? rand() :  THE_CHAMP_SS_VERSION ) );
	}
	if( $theChampSharingOptions['vertical_font_color_hover'] != '' ) {
		$updated = the_champ_update_css( 'vertical_sharing_replace_color_hover', 'vertical_font_color_hover', 'share-hover-svg-vertical' );
		wp_enqueue_style( 'the_champ_admin_svg_vertical_hover', plugins_url( 'css/share-hover-svg-vertical.css', __FILE__ ), false, ( $updated === true ? rand() :  THE_CHAMP_SS_VERSION ) );
	}
}

/**
 * Update CSS file
 */
function the_champ_update_css( $replace_color_option, $logo_color_option, $css_file ) {	
	global $theChampSharingOptions;
	if ( $theChampSharingOptions[$replace_color_option] != $theChampSharingOptions[$logo_color_option] ) {
		$path = plugin_dir_url( __FILE__ ) . 'css/' . $css_file . '.css';
		try{
			$content = file( $path );
			if ( $content !== false ) {
				$handle = fopen( dirname( __FILE__ ) . '/css/' . $css_file . '.css','w' );
				if ( $handle !== false ) {
					foreach ( $content as $value ) {
					    fwrite( $handle, str_replace( str_replace( '#', '%23', $theChampSharingOptions[$replace_color_option] ), str_replace( '#', '%23', $theChampSharingOptions[$logo_color_option] ), $value ) );
					}
					fclose( $handle );
					$theChampSharingOptions[$replace_color_option] = $theChampSharingOptions[$logo_color_option];
					update_option( 'the_champ_sharing', $theChampSharingOptions );
					return true;
				}
			}
		}catch(Exception $e){
			return false;
		}
	}
	return false;
}

function the_champ_add_settings_link($links){
    $addonsLink = '<a href="https://www.heateor.com/add-ons" target="_blank">' . __('Add-Ons', 'super-socializer') . '</a>';
    $supportLink = '<a href="http://support.heateor.com" target="_blank">' . __('Support Documentation', 'super-socializer') . '</a>';
    $settingsLink = '<a href="admin.php?page=heateor-ss-general-options">' . __('Settings', 'super-socializer') . '</a>';
    // place it before other links
	array_unshift( $links, $settingsLink );
	$links[] = $addonsLink;
	$links[] = $supportLink;
	return $links;
}
add_filter( 'plugin_action_links_super-socializer/super_socializer.php', 'the_champ_add_settings_link');

/**
 * Return ajax response
 */
function the_champ_ajax_response($response){
	$response = apply_filters('the_champ_ajax_response_filter', $response);
	die(json_encode($response));
}

/**
 * Show notification in popup
 */
function the_champ_notify(){
	if(isset($_GET['message'])){
		?>
		<div><?php echo sanitize_text_field($_GET['message']) ?></div>
		<?php
	}
	die;
}
add_action('wp_ajax_nopriv_the_champ_notify', 'the_champ_notify');

/**
 * Check if Social Login is enabled.
 */
function the_champ_social_login_enabled(){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['enable']) && $theChampLoginOptions['enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Social Sharing is enabled.
 */
function the_champ_social_sharing_enabled(){
	global $theChampSharingOptions;
	if(isset($theChampSharingOptions['enable']) && $theChampSharingOptions['enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Social Counter is enabled.
 */
function the_champ_social_counter_enabled(){
	global $theChampCounterOptions;
	if(isset($theChampCounterOptions['enable'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if vertical Social Counter is enabled.
 */
function the_champ_vertical_social_counter_enabled(){
	global $theChampCounterOptions;
	if(isset($theChampCounterOptions['vertical_enable']) && $theChampCounterOptions['vertical_enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Horizontal Social Sharing is enabled.
 */
function the_champ_horizontal_sharing_enabled(){
	global $theChampSharingOptions;
	if(isset($theChampSharingOptions['hor_enable']) && $theChampSharingOptions['hor_enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Vertical Social Sharing is enabled.
 */
function the_champ_vertical_sharing_enabled(){
	global $theChampSharingOptions;
	if(isset($theChampSharingOptions['vertical_enable']) && $theChampSharingOptions['vertical_enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Horizontal Social Counter is enabled.
 */
function the_champ_horizontal_counter_enabled(){
	global $theChampCounterOptions;
	if(isset($theChampCounterOptions['hor_enable']) && $theChampCounterOptions['hor_enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Vertical Social Counter is enabled.
 */
function the_champ_vertical_counter_enabled(){
	global $theChampCounterOptions;
	if(isset($theChampCounterOptions['vertical_enable']) && $theChampCounterOptions['vertical_enable'] == 1){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Social Login from particular provider is enabled.
 */
function the_champ_social_login_provider_enabled($provider){
	global $theChampLoginOptions;
	if(the_champ_social_login_enabled() && isset($theChampLoginOptions['providers']) && in_array($provider, $theChampLoginOptions['providers'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Facebook commenting is enabled
 */
function the_champ_facebook_commenting_enabled(){
	global $theChampFacebookOptions;
	if(isset($theChampFacebookOptions['enable_fbcomments'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Social commenting is enabled
 */
function the_champ_social_commenting_enabled(){
	global $theChampFacebookOptions;
	if(isset($theChampFacebookOptions['enable_commenting'])){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if any Facebook plugin is enabled
 */
function the_champ_facebook_plugin_enabled(){
	global $theChampFacebookOptions, $theChampCounterOptions;
	if((the_champ_social_commenting_enabled() && the_champ_facebook_commenting_enabled()) || the_champ_facebook_like_rec_enabled()){
		return true;
	}else{
		return false;
	}
}

/**
 * Check if Facebook Like/Recommend is enabled
 */
function the_champ_facebook_like_rec_enabled(){
	global $theChampCounterOptions, $theChampSharingOptions;
	if( ( the_champ_social_counter_enabled() && ( ( the_champ_horizontal_counter_enabled() && isset($theChampCounterOptions['horizontal_providers']) && ( in_array('facebook_share', $theChampCounterOptions['horizontal_providers']) || in_array('facebook_like', $theChampCounterOptions['horizontal_providers']) || in_array('facebook_recommend', $theChampCounterOptions['horizontal_providers']) ) ) || ( the_champ_vertical_counter_enabled() && isset($theChampCounterOptions['vertical_providers']) && ( in_array('facebook_share', $theChampCounterOptions['vertical_providers']) || in_array('facebook_like', $theChampCounterOptions['vertical_providers']) || in_array('facebook_recommend', $theChampCounterOptions['vertical_providers']) ) ) ) ) || ( the_champ_social_sharing_enabled() && ( ( the_champ_horizontal_sharing_enabled() && isset($theChampSharingOptions['horizontal_re_providers']) && ( in_array('facebook_share', $theChampSharingOptions['horizontal_re_providers']) || in_array('facebook_like', $theChampSharingOptions['horizontal_re_providers']) || in_array('facebook_recommend', $theChampSharingOptions['horizontal_re_providers']) ) ) || ( the_champ_vertical_sharing_enabled() && isset($theChampSharingOptions['vertical_re_providers']) && ( in_array('facebook_share', $theChampSharingOptions['vertical_re_providers']) || in_array('facebook_like', $theChampSharingOptions['vertical_re_providers']) || in_array('facebook_recommend', $theChampSharingOptions['vertical_re_providers']) ) ) ) ) ){
		return true;
	}
	return false;
}

/**
 * Log errors/exceptions
 */
function the_champ_log_error($error){
	error_log(PHP_EOL . '[' . date('m/d/Y h:i:s a', time()) . '] ' . $error, 3, plugin_dir_path(__FILE__) . 'log.txt');
}

/**
 * Return error message HTML
 */
function the_champ_error_message($error, $heading = false){
	$html = "";
	$html .= "<div class='the_champ_error'>";
	if($heading){
		$html .= "<p style='color: black'><strong>Super Socializer: </strong></p>";
	}
	$html .= "<p style ='color:red; margin: 0'>". __($error, 'super-socializer') ."</p></div>";
	return $html;
}

// if multisite is enabled and this is the main website
if(is_multisite() && is_main_site()){
	/**
	 * replicate the options to the new blog created
	 */
	function the_champ_replicate_settings($blogId){
		global $theChampFacebookOptions, $theChampLoginOptions, $theChampSharingOptions;
		add_blog_option($blogId, 'the_champ_facebook', $theChampFacebookOptions);
		add_blog_option($blogId, 'the_champ_login', $theChampLoginOptions);
		add_blog_option($blogId, 'the_champ_sharing', $theChampSharingOptions);
	}
	add_action('wpmu_new_blog', 'the_champ_replicate_settings');
	
	/**
	 * update the social login options in all the old blogs
	 */
	function the_champ_update_old_blogs($oldConfig){
		$optionParts = explode('_', current_filter());
		$option = $optionParts[2] . '_' . $optionParts[3] . '_' . $optionParts[4];
		$newConfig = get_option($option);
		if(isset($newConfig['config_multisite']) && $newConfig['config_multisite'] == 1){
			$blogs = get_blog_list(0, 'all');
			foreach($blogs as $blog){
				update_blog_option($blog['blog_id'], $option, $newConfig);
			}
		}
	}
    add_action('update_option_the_champ_login', 'the_champ_update_old_blogs');
	add_action('update_option_the_champ_facebook', 'the_champ_update_old_blogs');
	add_action('update_option_the_champ_sharing', 'the_champ_update_old_blogs');
}

function the_champ_account_linking(){
	if(is_user_logged_in()){
		// LiveJournal auth
		if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'LiveJournal'){
			the_champ_livejournal_auth();
		}
		wp_enqueue_style('the-champ-frontend-css', plugins_url('css/front.css', __FILE__), false, THE_CHAMP_SS_VERSION);
		global $theChampFacebookOptions, $theChampLoginOptions, $user_ID;
		$twitterRedirect = urlencode(the_champ_get_valid_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . html_entity_decode(esc_url(remove_query_arg(array('linked'))))));
		$currentPageUrl = urldecode($twitterRedirect);
		$theChampLJAuthUrl = remove_query_arg('action', the_champ_get_valid_url($currentPageUrl));
		?>
		<script>function theChampLoadEvent(e){var t=window.onload;if(typeof window.onload!="function"){window.onload=e}else{window.onload=function(){t();e()}}} var theChampCloseIconPath = '<?php echo plugins_url('images/close.png', __FILE__) ?>'; var theChampLJAuthUrl = '<?php echo $theChampLJAuthUrl . (strpos($theChampLJAuthUrl, '?') !== false ? '&' : '?') . 'SuperSocializerAuth=LiveJournal'; ?>'; var theChampLJLoginUsernameString = '<?php echo htmlspecialchars(__('Enter your LiveJournal username', 'super-socializer'), ENT_QUOTES); ?>';</script>
		<?php
		// general (required) scripts
		wp_enqueue_script('the_champ_ss_general_scripts', plugins_url('js/front/social_login/general.js', __FILE__), false, THE_CHAMP_SS_VERSION);
		$websiteUrl = esc_url(home_url());
		?>
		<script> var theChampLinkingRedirection = '<?php echo the_champ_get_http().$_SERVER["HTTP_HOST"] . html_entity_decode(esc_url(remove_query_arg(array( 'linked')))) ?>'; var theChampSiteUrl = '<?php echo $websiteUrl ?>'; var theChampVerified = 0; var theChampAjaxUrl = '<?php echo admin_url() ?>/admin-ajax.php'; var theChampPopupTitle = ''; var theChampEmailPopup = 0; var theChampEmailAjaxUrl = '<?php echo admin_url() ?>/admin-ajax.php'; var theChampEmailPopupTitle = ''; var theChampEmailPopupErrorMsg = ''; var theChampEmailPopupUniqueId = ''; var theChampEmailPopupVerifyMessage = ''; var theChampTwitterRedirect = '<?php echo $twitterRedirect; ?>';</script>
		<?php
		// scripts used for common Social Login functionality
		if(the_champ_social_login_enabled()){
			$loadingImagePath = plugins_url('images/ajax_loader.gif', __FILE__);
			$theChampAjaxUrl = get_admin_url().'admin-ajax.php';
			$redirectionUrl = the_champ_get_login_redirection_url();
			$regRedirectionUrl = the_champ_get_login_redirection_url('', true);
			global $theChampSteamLogin;
			?>
			<style type="text/css">
			#ss_openid{border:1px solid gray;display:inline;font-family:"Trebuchet MS";font-size:12px;width:98%;padding:.35em .325em .75em;margin-bottom:20px}#ss_openid form{margin-top:25px;margin-left:0;padding:0;background:transparent;-webkit-box-shadow:none;box-shadow:none}#ss_openid input{font-family:"Trebuchet MS";font-size:12px;width:100px;float:left}#ss_openid input[type=submit]{background:#767676;padding:.75em 2em;border:0;-webkit-border-radius:2px;border-radius:2px;-webkit-box-shadow:none;box-shadow:none;color:#fff;cursor:pointer;display:inline-block;font-weight:800;line-height:1;text-shadow:none;-webkit-transition:background .2s;transition:background .2s}#ss_openid legend{color:#FF6200;float:left;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:table;max-width:100%;padding:0;white-space:normal}#ss_openid input.openid_login{background-color:#fff;background-position:0 50%;color:#000;width:220px;margin-right:10px;height:30px;margin-bottom:5px;background:#fff;background-image:-webkit-linear-gradient(rgba(255,255,255,0),rgba(255,255,255,0));border:1px solid #bbb;-webkit-border-radius:3px;border-radius:3px;display:block;padding:.7em;line-height:1.5}#ss_openid a{color:silver}#ss_openid a:hover{color:#5e5e5e}
			</style>
			<script> var theChampLoadingImgPath = '<?php echo $loadingImagePath ?>'; var theChampAjaxUrl = '<?php echo $theChampAjaxUrl ?>'; var theChampRedirectionUrl = '<?php echo $redirectionUrl ?>'; var theChampRegRedirectionUrl = '<?php echo $regRedirectionUrl ?>', theChampSteamAuthUrl = "<?php echo $theChampSteamLogin ? $theChampSteamLogin->url( esc_url(home_url()) . '?SuperSocializerSteamAuth=' . $twitterRedirect ) : ''; ?>"; var heateorMSEnabled = 0; var theChampTwitterAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Twitter&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampFacebookAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Facebook&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampGoogleAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Google&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampVkontakteAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Vkontakte&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampTwitchAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Twitch&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampLinkedinAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Linkedin&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampXingAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Xing&super_socializer_redirect_to=" + theChampTwitterRedirect;</script>
			<?php
			$userVerified = false;
			$ajaxUrl = 'admin-ajax.php';
			$notification = '';
			wp_enqueue_script('the_champ_sl_common', plugins_url('js/front/social_login/common.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION);
		}
		// linking functions
		wp_enqueue_script('the_champ_ss_linking_script', plugins_url('js/front/social_login/linking.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION);
		// Instagram scripts
		if(the_champ_social_login_provider_enabled('instagram')){
			?>
			<script> var theChampInstaId = '<?php echo (isset($theChampLoginOptions["insta_id"]) && $theChampLoginOptions["insta_id"] != "") ? $theChampLoginOptions["insta_id"] : 0 ?>' </script>
			<?php
			wp_enqueue_script('the_champ_sl_instagram', plugins_url('js/front/social_login/instagram.js', __FILE__), false, THE_CHAMP_SS_VERSION);
		}
		$html = '<style type="text/css">table.superSocializerTable td{padding: 10px;}div.heateor_ss_sl_optin_container a{color:blue}div.heateor_ss_sl_optin_container label{font-size:11px;font-weight:normal}input.heateor_ss_social_login_optin{vertical-align:middle}</style>';

		$html .= '<div class="metabox-holder columns-2 super-socializer-linking-container" id="post-body">
            <div class="stuffbox" style="width:60%; padding-bottom:10px">
                <div class="inside" style="padding:0">
                    <table class="form-table editcomment superSocializerTable">
                        <tbody>';
                        if(isset($_GET['linked'])){
                        	if(intval($_GET['linked']) == 1){
	                        	$html .= '<tr>
	                        		<td colspan="2" style="color: green">' . __('Account linked successfully', 'super-socializer') . '</td>
	                        	</tr>';
                        	}elseif(intval($_GET['linked']) == 0){
	                        	$html .= '<tr>
	                        		<td colspan="2" style="color: red">' . __('Account already exists or linked', 'super-socializer') . '</td>
	                        	</tr>';
                        	}
                        }
                        $icons_container = '<div class="the_champ_login_container">';
                        if(isset($theChampLoginOptions['gdpr_enable'])){
							$icons_container .= '<div class="heateor_ss_sl_optin_container"><label><input type="checkbox" class="heateor_ss_social_login_optin" value="1" />'. str_replace($theChampLoginOptions['ppu_placeholder'], '<a href="'. $theChampLoginOptions['privacy_policy_url'] .'" target="_blank">'. $theChampLoginOptions['ppu_placeholder'] .'</a>', wp_strip_all_tags($theChampLoginOptions['privacy_policy_optin_text'])) .'</label></div>';
						}
                        $icons_container .= '<ul class="the_champ_login_ul">';
						$existingProviders = array();
						$primarySocialNetwork = get_user_meta($user_ID, 'thechamp_provider', true);
						$existingProviders[] = $primarySocialNetwork;
						$linkedAccounts = get_user_meta($user_ID, 'thechamp_linked_accounts', true);
						if($linkedAccounts){
							$linkedAccounts = maybe_unserialize($linkedAccounts);
							$linkedProviders = array_keys($linkedAccounts);
							$existingProviders = array_merge($existingProviders, $linkedProviders);
						}
						
						if(isset($theChampLoginOptions['providers'])){
							$existingProviders = array_diff($theChampLoginOptions['providers'], $existingProviders);
                        }
						if(count($existingProviders) > 0){
                        $html .= '<tr>
                            <td colspan="2"><strong>' . __('Link your social account to login to your account at this website', 'super-socializer') . '</strong><br/>';
							foreach($existingProviders as $provider){
								$icons_container .= '<li><i ';
								// id
								if( $provider == 'google' ){
									$icons_container .= 'id="theChamp'. ucfirst($provider) .'Button" ';
								}
								// class
								$icons_container .= 'class="theChampLogin theChamp'. ucfirst($provider) .'Background theChamp'. ucfirst($provider) .'Login" ';
								$icons_container .= 'alt="Login with ';
								$icons_container .= ucfirst($provider);
								$icons_container .= '" title="Login with ';
								if($provider == 'live'){
									$icons_container .= 'Windows Live';
								}else{
									$icons_container .= ucfirst($provider);
								}
								if(current_filter() == 'comment_form_top'){
									$icons_container .= '" onclick="theChampCommentFormLogin = true; theChampInitiateLogin(this)" >';
								}else{
									$icons_container .= '" onclick="theChampInitiateLogin(this)" >';
								}
								$icons_container .= '<div class="theChampLoginSvg theChamp'. ucfirst($provider) .'LoginSvg"></div></i></li>';
							}
							$icons_container .= '</ul></div>';
							$html .= $icons_container;
	                        $html .= '</td>
	                        </tr>';
	                    }
                        $html .= '<tr>
                            <td colspan="2">';
                            	if(is_array($linkedAccounts) || $primarySocialNetwork){
                            		$html .= '<table>
                            		<tbody>';
                            		$primarySocialId = get_user_meta($user_ID, 'thechamp_social_id', true);
                            		if($primarySocialNetwork && $primarySocialId){
                            			$current = get_user_meta($user_ID, 'thechamp_current_id', true) == get_user_meta($user_ID, 'thechamp_social_id', true);
	                            		$html .= '<tr>
	                            		<td style="padding: 0">'. ($current ? '<strong>'. __('Currently', 'super-socializer') . ' </strong>' : '') . __('Connected with', 'super-socializer') . ' <strong>'. ucfirst($primarySocialNetwork) .'</strong></td><td><input type="button" onclick="theChampUnlink(this, \''. $primarySocialNetwork .'\')" value="'. __('Remove', 'super-socializer') .'" /></td></tr>';
                            		}
                            		if(is_array($linkedAccounts) && count($linkedAccounts) > 0){
                            			foreach($linkedAccounts as $key => $value){
	                            			$current = get_user_meta($user_ID, 'thechamp_current_id', true) == $value;
	                            			$html .= '<tr>
	                            			<td style="padding: 0">'. ($current ? '<strong>'. __('Currently', 'super-socializer') . ' </strong>' : '') . __('Connected with', 'super-socializer') . ' <strong>'. ucfirst($key) .'</strong></td><td><input type="button" onclick="theChampUnlink(this, \''. $key .'\')" value="'. __('Remove', 'super-socializer') .'" /></td></tr>';
	                            		}
                            		}
                            		$html .= '</tbody>
                            		</table>';
                            	}
                            $html .= '</td>
                        </tr>
                    	</tbody>
                    </table>
                </div>
            </div>
        </div>';
        return $html;
	}
	return '';
}

add_action('admin_notices', 'the_champ_user_profile_account_linking');
add_action('bp_setup_nav', 'the_champ_add_linking_tab', 100);

function the_champ_user_profile_account_linking(){
	if(the_champ_social_login_enabled()){
		global $pagenow;
		if($pagenow == 'profile.php'){
			echo the_champ_account_linking();
		}
	}
}

/**
 * Unlink the social account
 */
function the_champ_unlink(){
	if(isset($_POST['provider'])){
		global $user_ID;
		$linkedAccounts = get_user_meta($user_ID, 'thechamp_linked_accounts', true);
		$primarySocialNetwork = get_user_meta($user_ID, 'thechamp_provider', true);
		if($linkedAccounts || $primarySocialNetwork){
			$socialNetworkToUnlink = sanitize_text_field($_POST['provider']);
			$linkedAccounts = maybe_unserialize($linkedAccounts);
			$currentSocialId = get_user_meta($user_ID, 'thechamp_current_id', true);
			if($primarySocialNetwork == $socialNetworkToUnlink){
				if($currentSocialId == get_user_meta($user_ID, 'thechamp_social_id', true)){
					delete_user_meta($user_ID, 'thechamp_current_id');
				}
				delete_user_meta($user_ID, 'thechamp_social_id');
				delete_user_meta($user_ID, 'thechamp_provider');
				delete_user_meta($user_ID, 'thechamp_large_avatar');
				delete_user_meta($user_ID, 'thechamp_avatar');
			}else{
				if($currentSocialId == $linkedAccounts[$socialNetworkToUnlink]){
					delete_user_meta($user_ID, 'thechamp_current_id');
				}
				unset($linkedAccounts[$socialNetworkToUnlink]);	
				update_user_meta($user_ID, 'thechamp_linked_accounts', maybe_serialize($linkedAccounts));
			}
			the_champ_ajax_response(array('status' => 1, 'message' => ''));
		}
	}
	die;
}
add_action('wp_ajax_the_champ_unlink', 'the_champ_unlink');

function the_champ_add_linking_tab() {
	if(bp_is_my_profile() && the_champ_social_login_enabled()){
		global $theChampLoginOptions;
		if(isset($theChampLoginOptions['bp_linking'])){
			global $bp, $user_ID;
			if($user_ID){
				bp_core_new_subnav_item( array(
						'name' => __('Social Account Linking', 'super-socializer'),
						'slug' => 'account-linking',
						'parent_url' => trailingslashit( bp_loggedin_user_domain() . 'profile' ),
						'parent_slug' => 'profile',
						'screen_function' => 'the_champ_bp_linking',
						'position' => 50
					)
				);
			}
		}
	}
}

function the_champ_bp_account_linking(){
	echo the_champ_account_linking();
}

// show social account linking when 'Social Account Linking' tab is clicked
function the_champ_bp_linking() {
	add_action('bp_template_content', 'the_champ_bp_account_linking');
	bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
}

/**
 * Set BP active flag to true
 */
function the_champ_bp_loaded(){
	global $theChampIsBpActive;
	$theChampIsBpActive = true;
}
add_action('bp_include', 'the_champ_bp_loaded');

/**
 * Return the string after capitalizing first letter
 */
function the_champ_first_letter_uppercase($word){
	return ucfirst($word);
}

/**
 * Show sharing meta options
 */
function the_champ_sharing_meta_setup(){
	global $post;
	$postType = $post->post_type;
	$sharingMeta = get_post_meta($post->ID, '_the_champ_meta', true);
	?>
	<p>
		<label for="the_champ_sharing">
			<input type="checkbox" name="_the_champ_meta[sharing]" id="the_champ_sharing" value="1" <?php checked('1', @$sharingMeta['sharing']); ?> />
			<?php _e('Disable Standard Social Sharing on this '.$postType, 'super-socializer') ?>
		</label>
		<br/>
		<label for="the_champ_vertical_sharing">
			<input type="checkbox" name="_the_champ_meta[vertical_sharing]" id="the_champ_vertical_sharing" value="1" <?php checked('1', @$sharingMeta['vertical_sharing']); ?> />
			<?php _e('Disable Floating Social Sharing on this '.$postType, 'super-socializer') ?>
		</label>
		<br/>
		<label for="the_champ_counter">
			<input type="checkbox" name="_the_champ_meta[counter]" id="the_champ_counter" value="1" <?php checked('1', @$sharingMeta['counter']); ?> />
			<?php _e('Disable Standard like buttons on this '.$postType, 'super-socializer') ?>
		</label>
		<br/>
		<label for="the_champ_vertical_counter">
			<input type="checkbox" name="_the_champ_meta[vertical_counter]" id="the_champ_vertical_counter" value="1" <?php checked('1', @$sharingMeta['vertical_counter']); ?> />
			<?php _e('Disable Floating like buttons on this '.$postType, 'super-socializer') ?>
		</label>
		<br/>
		<label for="the_champ_fb_comments">
			<input type="checkbox" name="_the_champ_meta[fb_comments]" id="the_champ_fb_comments" value="1" <?php checked('1', @$sharingMeta['fb_comments']); ?> />
			<?php _e('Disable Social Commenting on this '.$postType, 'super-socializer') ?>
		</label>
		<?php
		if(the_champ_social_sharing_enabled()){
			global $theChampSharingOptions;
			$validNetworks = array('facebook', 'twitter', 'linkedin', 'buffer', 'reddit', 'pinterest', 'stumbleupon', 'vkontakte', 'Odnoklassniki');
			if(isset($theChampSharingOptions['hor_enable']) && isset($theChampSharingOptions['horizontal_counts']) && isset($theChampSharingOptions['horizontal_re_providers']) && count($theChampSharingOptions['horizontal_re_providers']) > 0){
				?>
				<p>
				<strong style="font-weight:bold"><?php _e('Standard Sharing Interface', 'super-socializer') ?></strong>
				<?php
				foreach(array_intersect($theChampSharingOptions['horizontal_re_providers'], $validNetworks) as $sharingProvider){
					?>
					<br/>
					<label for="the_champ_<?php echo $sharingProvider ?>_horizontal_sharing_count">
						<span style="width: 242px; float:left"><?php _e('Starting share count for ' . ucfirst(str_replace('_', ' ', $sharingProvider)), 'super-socializer') ?></span>
						<input type="text" name="_the_champ_meta[<?php echo $sharingProvider ?>_horizontal_count]" id="the_champ_<?php echo $sharingProvider ?>_horizontal_sharing_count" value="<?php echo isset($sharingMeta[$sharingProvider.'_horizontal_count']) ? $sharingMeta[$sharingProvider.'_horizontal_count'] : '' ?>" />
					</label>
					<?php
				}
				?>
				</p>
				<?php
			}
			
			if(isset($theChampSharingOptions['vertical_enable']) && isset($theChampSharingOptions['vertical_counts']) && isset($theChampSharingOptions['vertical_re_providers']) && count($theChampSharingOptions['vertical_re_providers']) > 0){
				?>
				<p>
				<strong style="font-weight:bold"><?php _e('Floating Sharing Interface', 'super-socializer') ?></strong>
				<?php
				foreach(array_intersect($theChampSharingOptions['vertical_re_providers'], $validNetworks) as $sharingProvider){
					?>
					<br/>
					<label for="the_champ_<?php echo $sharingProvider ?>_vertical_sharing_count">
						<span style="width: 242px; float:left"><?php _e('Starting share count for ' . ucfirst(str_replace('_', ' ', $sharingProvider)), 'super-socializer') ?></span>
						<input type="text" name="_the_champ_meta[<?php echo $sharingProvider ?>_vertical_count]" id="the_champ_<?php echo $sharingProvider ?>_vertical_sharing_count" value="<?php echo isset($sharingMeta[$sharingProvider.'_vertical_count']) ? $sharingMeta[$sharingProvider.'_vertical_count'] : '' ?>" />
					</label>
					<?php
				}
				?>
				</p>
				<?php
			}
		}
		?>
	</p>
	<?php
    echo '<input type="hidden" name="the_champ_meta_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
}

/**
 * Save sharing meta fields.
 */
function the_champ_save_sharing_meta($postId){
    // make sure data came from our meta box
    if(!isset($_POST['the_champ_meta_nonce']) || !wp_verify_nonce( $_POST['the_champ_meta_nonce'], __FILE__ )){
		return $postId;
 	}
    // check user permissions
    if($_POST['post_type'] == 'page'){
        if(!current_user_can('edit_page', $postId)){
			return $postId;
    	}
	}else{
        if(!current_user_can('edit_post', $postId)){
			return $postId;
    	}
	}
    if ( isset( $_POST['_the_champ_meta'] ) ) {
		$newData = $_POST['_the_champ_meta'];
		foreach($newData as $k => $v){
			$newData[$k] = $v;
		}
	}else{
		$newData = array( 'sharing' => 0, 'vertical_sharing' => 0, 'counter' => 0, 'vertical_counter' => 0, 'fb_comments' => 0 );
	}
	update_post_meta($postId, '_the_champ_meta', $newData);
    return $postId;
}

/**
 * Override sanitize_user function to allow cyrillic usernames
 */
function the_champ_sanitize_user($username, $rawUsername, $strict) {
	$username = wp_strip_all_tags($rawUsername);
	$username = remove_accents($username);
	$username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
	$username = preg_replace('/&.+?;/', '', $username);
	// If strict, reduce to ASCII and Cyrillic characters for max portability.
	if($strict){
		$settings = get_option('wscu_settings');
		$username = preg_replace('|[^a-z\p{Arabic}\p{Cyrillic}0-9 _.\-@]|iu', '', $username);
	}
	$username = trim($username);
	// Consolidate contiguous whitespace
	$username = preg_replace('|\s+|', ' ', $username);

	return $username;
}
add_filter('sanitize_user', 'the_champ_sanitize_user', 10, 3);

/**
 * Show options to update social avatar at BuddyPress "Change Avatar" page
 */
function the_champ_social_avatar_options(){
	global $user_ID, $theChampLoginOptions;
	if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['avatar']) && isset($theChampLoginOptions['avatar_options'])){
		if(isset($_POST['ss_dontupdate_avatar'])){
			$dontUpdateAvatar = intval($_POST['ss_dontupdate_avatar']);
			update_user_meta($user_ID, 'thechamp_dontupdate_avatar', $dontUpdateAvatar);
		}else{
			$dontUpdateAvatar = get_user_meta($user_ID, 'thechamp_dontupdate_avatar', true);
		}
		if(isset($_POST['ss_small_avatar']) && heateor_ss_validate_url($_POST['ss_small_avatar']) !== false){
			$updatedSmallAvatar = str_replace('http://', '//', esc_url(trim($_POST['ss_small_avatar'])));
			update_user_meta($user_ID, 'thechamp_avatar', $updatedSmallAvatar);
		}
		if(isset($_POST['ss_large_avatar']) && heateor_ss_validate_url($_POST['ss_large_avatar']) !== false){
			$updatedLargeAvatar = str_replace('http://', '//', esc_url(trim($_POST['ss_large_avatar'])));
			update_user_meta($user_ID, 'thechamp_large_avatar', $updatedLargeAvatar);
		}
		?>
		<div class="profile" style="margin-bottom:20px">
			<form action="" method="post" class="standard-form base">
				<h4><?php _e('Social Avatar', 'super-socializer') ?></h4>
				<div class="clear"></div>
				<div class="editfield field_name visibility-public field_type_textbox">
					<label for="ss_dontupdate_avatar_1"><input id="ss_dontupdate_avatar_1" style="margin-right:5px" type="radio" name="ss_dontupdate_avatar" value="1" <?php echo $dontUpdateAvatar ? 'checked' : '' ?> /><?php _e('Do not fetch and update social avatar from my profile, next time I Social Login', 'super-socializer') ?></label>
					<label for="ss_dontupdate_avatar_0"><input id="ss_dontupdate_avatar_0" style="margin-right:5px" type="radio" name="ss_dontupdate_avatar" value="0" <?php echo ! $dontUpdateAvatar ? 'checked' : '' ?> /><?php _e('Update social avatar, next time I Social Login', 'super-socializer') ?></label>
				</div>
				<div class="editfield field_name visibility-public field_type_textbox">
					<label for="ss_small_avatar"><?php _e('Small Avatar', 'super-socializer') ?></label>
					<input id="ss_small_avatar" type="text" name="ss_small_avatar" value="<?php echo isset($updatedSmallAvatar) ? $updatedSmallAvatar : get_user_meta($user_ID, 'thechamp_avatar', true) ?>" />
				</div>
				<div class="editfield field_name visibility-public field_type_textbox">
					<label for="ss_large_avatar"><?php _e('Large Avatar', 'super-socializer') ?></label>
					<input id="ss_large_avatar" type="text" name="ss_large_avatar" value="<?php echo isset($updatedLargeAvatar) ? $updatedLargeAvatar : get_user_meta($user_ID, 'thechamp_large_avatar', true) ?>" />
				</div>
				<div class="submit">
					<input type="submit" value="<?php _e('Save Changes', 'super-socializer') ?>" />
				</div>
			</form>
		</div>
		<?php
	}
}
add_action('bp_before_profile_avatar_upload_content', 'the_champ_social_avatar_options');

function the_champ_clear_shorturl_cache(){
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_the_champ_ss_bitly_url'");
	die;
}
add_action('wp_ajax_the_champ_clear_shorturl_cache', 'the_champ_clear_shorturl_cache');

/**
 * Clear share counts cache
 */
function heateor_ss_clear_share_count_cache() {
	global $wpdb;
	$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_heateor_ss_share_count_%'" );
	die;
}
add_action('wp_ajax_heateor_ss_clear_share_count_cache', 'heateor_ss_clear_share_count_cache');

/**
 * Detect myCRED referred signups
 */
function heateor_ss_detect_mycred_referred_signups( $userId, $userdata, $profileData ) {
	if ( function_exists( 'mycred_detect_referred_signups' ) ) {
		mycred_detect_referred_signups( $userId );
	}
}
add_action( 'the_champ_user_successfully_created', 'heateor_ss_detect_mycred_referred_signups', 10, 3 );

// keep track of the unverified users' login attempts from traditional login form
$heateorSsLoginAttempt = 0;

/**
 * Stop unverified users from logging in.
 */
function heateor_ss_filter_login($user, $username, $password){
	$tempUser = get_user_by('login', $username);
	if(isset($tempUser->data->ID)){
		$id = $tempUser->data->ID;
		if($id != 1 && get_user_meta($id, 'thechamp_key', true) != ''){
			global $heateorSsLoginAttempt;
			$heateorSsLoginAttempt = 1;
			return null;
		}
	}
	return $user;
}
add_filter('authenticate', 'heateor_ss_filter_login', 40, 3);

/**
 * Show message, if an unverified user logs in via login form
 */
function heateor_ss_login_error_message($error){
	global $heateorSsLoginAttempt;
	//check if unverified user has attempted to login
	if($heateorSsLoginAttempt == 1){
		$error = __('Please verify your email address to login.', 'super-socializer');
	}
	return $error;
}
add_filter('login_errors', 'heateor_ss_login_error_message');

/**
 * Check if url is in valid format
 */
function heateor_ss_validate_url($url){
	return filter_var(trim($url), FILTER_VALIDATE_URL);
}

/**
 * Check if plugin is active
 */
function heateor_ss_is_plugin_active($pluginFile){
	return in_array($pluginFile, apply_filters('active_plugins', get_option('active_plugins')));
}

/**
 * Add column in the user list to delete social profile data
 */
function heateor_ss_add_custom_column($columns){
	$columns['heateor_ss_delete_profile_data'] = 'Delete Social Profile';
	return $columns;
}
add_filter('manage_users_columns', 'heateor_ss_add_custom_column');

/**
 * Show option to delete social profile in the custom column
 */
function heateor_ss_delete_profile_column($value, $columnName, $userId){
	if('heateor_ss_delete_profile_data' == $columnName){
		global $wpdb;
		$socialUser = $wpdb->get_var($wpdb->prepare('SELECT user_id FROM '. $wpdb->prefix .'usermeta WHERE user_id = %d and meta_key LIKE "thechamp%"', $userId));
		if($socialUser > 0){
			return '<a href="javascript:void(0)" title="'. __('Click to delete social profile data', 'super-socializer') .'" alt="'. __('Click to delete social profile data', 'super-socializer') .'" onclick="javascript:heateorSsDeleteSocialProfile(this, '. $userId .')">Delete</a>';
		}
	}
}
add_action('manage_users_custom_column', 'heateor_ss_delete_profile_column', 10, 3);

/**
 * Include thickbox js and css
 */
function heateor_ss_include_thickbox(){
	global $parent_file;
	if($parent_file == 'users.php'){
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox', null, array('jquery'));
		wp_enqueue_style('thickbox');
	}
}
add_action('admin_enqueue_scripts', 'heateor_ss_include_thickbox');

/**
 * Script to delete social profile
 */
function heateor_ss_delete_social_profile_script(){
	global $parent_file;
	if($parent_file == 'users.php'){
		?>
		<script type="text/javascript">
			function heateorSsDeleteSocialProfile(elem, userId){
               	var parentElement = jQuery(elem).parent();
                jQuery(parentElement).html('<span><?php _e('Deleting', 'super-socializer'); ?>...</span>');
                jQuery.ajax({
                    type: 'GET',
                    url: '<?php echo get_admin_url() ?>admin-ajax.php',
                    data: {
                        action: 'heateor_ss_delete_social_profile',
                        user_id: userId
                    },
                    success: function(data, textStatus, XMLHttpRequest){
                        if(data == 'done'){
                            jQuery(parentElement).html('<?php _e('Deleted', 'super-socializer'); ?>');
                        }else{
                            jQuery(parentElement).html('<?php _e('Something bad happened', 'super-socializer'); ?>');
                        }
                    }
                });
            }
		</script>
		<?php
	}
}
add_action('admin_head', 'heateor_ss_delete_social_profile_script');

/**
 * Delete social profile of the user
 */
function heateor_ss_delete_social_profile(){
	if(isset($_GET['user_id'])){
		$userId = intval(trim($_GET['user_id']));
		global $wpdb;
		$wpdb->query($wpdb->prepare('DELETE FROM '. $wpdb->prefix .'usermeta WHERE user_id = %d and meta_key LIKE "thechamp%"', $userId));
		die('done');
	}
	die;
}
add_action('wp_ajax_heateor_ss_delete_social_profile', 'heateor_ss_delete_social_profile');