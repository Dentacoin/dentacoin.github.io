<?php 
defined('ABSPATH') or die("Cheating........Uh!!");
/**
 * Widget for Social Login
 */
class TheChampLoginWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct() { 
		parent::__construct( 
			'TheChampLogin', //unique id 
			__('Super Socializer - Login'), //title displayed at admin panel
			array(  
				'description' => __( 'Let your website users login/register using their favorite Social ID Provider, such as Facebook, Twitter, Google+, LinkedIn', 'super-socializer' )) 
			); 
	}
	
	/** This is rendered widget content */ 
	public function widget( $args, $instance ) {
		// if social login is disabled, return
		if(!the_champ_social_login_enabled()){
			return;
		}
		extract( $args ); 
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		echo $before_widget;
		if( !empty( $instance['before_widget_content'] ) ){ 
			echo '<div>' . $instance['before_widget_content'] . '</div>';
		}
		if(!is_user_logged_in()){
			if( !empty( $instance['title'] ) ){ 
				$title = apply_filters( 'widget_title', $instance[ 'title' ] ); 
				echo $before_title . $title . $after_title;
			}
			echo the_champ_login_button(true);
		}else{
			if( !empty( $instance['title_after'] ) ){ 
				$title = apply_filters( 'widget_title', $instance[ 'title_after' ] ); 
				echo $before_title . $title . $after_title;
			}
			global $theChampLoginOptions, $user_ID;
			$userInfo = get_userdata($user_ID);
			echo "<div style='height:80px;width:180px'><div style='width:63px;float:left;'>";
			echo @get_avatar($user_ID, 60, '', '');
			echo "</div><div style='float:left; margin-left:10px'>";
			echo str_replace('-', ' ', $userInfo -> user_login);
			do_action('the_champ_login_widget_hook', $userInfo -> user_login);
			echo '<br/><a href="' . wp_logout_url(esc_url(home_url())) . '">' .__('Log Out', 'super-socializer') . '</a></div></div>';
		}
		echo '<div style="clear:both"></div>';
		if( !empty( $instance['after_widget_content'] ) ){ 
			echo '<div>' . $instance['after_widget_content'] . '</div>';
		}
		echo $after_widget; 
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['title'] = strip_tags( $new_instance['title'] ); 
		$instance['title_after'] = strip_tags( $new_instance['title_after'] ); 
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content']; 
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget options in admin panel */ 
	public function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array( 'title' => __('Login with your Social Account', 'super-socializer'), 'title_after' => '', 'before_widget_content' => '', 'after_widget_content' => '' );  

		foreach( $instance as $key => $value ) {  
			if ( is_string( $value ) ) {
				$instance[ $key ] = esc_attr( $value );  
			}
		}

		$instance = wp_parse_args( (array)$instance, $defaults ); 
		?> 
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure Social Login is enabled at "Super Socializer > Social Login" page.', 'super-socializer') ?></p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (before login):', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'title_after' ); ?>"><?php _e( 'Title (after login):', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'title_after' ); ?>" name="<?php echo $this->get_field_name( 'title_after' ); ?>" type="text" value="<?php echo $instance['title_after']; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'before_widget_content' ); ?>"><?php _e( 'Before widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'before_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'before_widget_content' ); ?>" type="text" value="<?php echo $instance['before_widget_content']; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'after_widget_content' ); ?>"><?php _e( 'After widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'after_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'after_widget_content' ); ?>" type="text" value="<?php echo $instance['after_widget_content']; ?>" /> 
			<br /><br />
			<label for="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>"><?php _e( 'Hide for logged in users:', 'super-socializer' ); ?></label> 
			<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>" name="<?php echo $this->get_field_name( 'hide_for_logged_in' ); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in']) && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
<?php 
  } 
} 
add_action( 'widgets_init', function() { return register_widget( "TheChampLoginWidget" ); } ); 

/**
 * Widget for Social Sharing (Standard widget)
 */
class TheChampSharingWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct() { 
		parent::__construct( 
			'TheChampHorizontalSharing', //unique id 
			'Super Socializer - Sharing (Standard Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __( 'Standard sharing widget. Let your website users share content on popular Social networks like Facebook, Twitter, Tumblr, Google+ and many more', 'super-socializer' )) 
			); 
	}  

	/** This is rendered widget content */ 
	public function widget( $args, $instance ) { 
		// return if sharing is disabled
		if(!the_champ_social_sharing_enabled() || !the_champ_horizontal_sharing_enabled()){
			return;
		}
		extract( $args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampSharingOptions, $post;
		$postId = $post -> ID;
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$sharingUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				if(is_home()){
					$sharingUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$sharingUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$sharingUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				}elseif(get_permalink($post -> ID)){
					$sharingUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$sharingUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$sharingUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$sharingUrl = get_permalink($post->ID);
		}

		$sharingUrl = heateor_ss_apply_target_share_url_filter($sharingUrl, 'horizontal', !is_singular() ? true : false);

		$shareCountTransientId = heateor_ss_get_share_count_transient_id($sharingUrl);
		$cachedShareCount = heateor_ss_get_cached_share_count($shareCountTransientId);

		echo "<div class='the_champ_sharing_container the_champ_horizontal_sharing' " . ( the_champ_is_amp_page() ? '' : 'super-socializer-data-href="' . $sharingUrl . '"' ) . ($cachedShareCount === false || the_champ_is_amp_page() ? "" : "super-socializer-no-counts='1' ") .">";
		
		echo $before_widget;
		
		if( !empty( $instance['title'] ) ){ 
			$title = apply_filters( 'widget_title', $instance[ 'title' ] ); 
			echo $before_title . $title . $after_title;
		}

		if( !empty( $instance['before_widget_content'] ) ){ 
			echo '<div>' . $instance['before_widget_content'] . '</div>'; 
		}
		if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$sharingUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_username']) && isset($theChampSharingOptions['bitly_username']) && $theChampSharingOptions['bitly_username'] != '' && isset($theChampSharingOptions['bitly_key']) && $theChampSharingOptions['bitly_key'] != ''){
			$shortUrl = the_champ_generate_sharing_bitly_url($sharingUrl, $postId);
			if($shortUrl){
				$sharingUrl = $shortUrl;
			}
		}
		echo the_champ_prepare_sharing_html($sharingUrl, 'horizontal', isset($instance['show_counts']), isset($instance['total_shares']), $shareCountTransientId, !is_singular() ? true : false);

		if( !empty( $instance['after_widget_content'] ) ){ 
			echo '<div>' . $instance['after_widget_content'] . '</div>'; 
		}
		
		echo '</div>';
		if((isset($instance['show_counts']) || isset($instance['total_shares'])) && $cachedShareCount == false){
			echo '<script>theChampLoadEvent(
		function(){
			// sharing counts
			theChampCallAjax(function(){
				theChampGetSharingCounts();
			});
		}
	);</script>';
		}
		echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['title'] = strip_tags( $new_instance['title'] ); 
		$instance['show_counts'] = $new_instance['show_counts'];
		$instance['total_shares'] = $new_instance['total_shares']; 
		$instance['target_url'] = $new_instance['target_url'];
		$instance['target_url_custom'] = $new_instance['target_url_custom'];  
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content']; 
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array( 'title' => 'Share the joy', 'show_counts' => 0, 'total_shares' => 0, 'target_url' => 'default', 'target_url_custom' => '', 'before_widget_content' => '', 'after_widget_content' => '' );

		foreach( $instance as $key => $value ) {  
			if ( is_string( $value ) ) {
				$instance[ $key ] = esc_attr( $value );  
			}
		}
		
		$instance = wp_parse_args( (array)$instance, $defaults );
		?> 
		<script type="text/javascript">
			function theChampToggleHorSharingTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampHorSharingTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampHorSharingTargetUrl').css('display', 'none');
				}
			}
		</script>
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure "Standard Social Sharing" is enabled at "Super Socializer > Social Sharing" page.', 'super-socializer') ?></p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" /> <br/><br/>
			<label for="<?php echo $this->get_field_id( 'show_counts' ); ?>"><?php _e( 'Show individual share counts:', 'super-socializer' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'show_counts' ); ?>" name="<?php echo $this->get_field_name( 'show_counts' ); ?>" type="checkbox" value="1" <?php echo isset($instance['show_counts']) && $instance['show_counts'] == 1 ? 'checked' : ''; ?> /><br/><br/>
			<label for="<?php echo $this->get_field_id( 'total_shares' ); ?>"><?php _e( 'Show total shares:', 'super-socializer' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'total_shares' ); ?>" name="<?php echo $this->get_field_name( 'total_shares' ); ?>" type="checkbox" value="1" <?php echo isset($instance['total_shares']) && $instance['total_shares'] == 1 ? 'checked' : ''; ?> /><br/> <br/>
			<label for="<?php echo $this->get_field_id( 'target_url' ); ?>"><?php _e( 'Target Url:', 'super-socializer' ); ?></label> 
			<select style="width: 95%" onchange="theChampToggleHorSharingTargetUrl(this.value)" class="widefat" id="<?php echo $this->get_field_id( 'target_url' ); ?>" name="<?php echo $this->get_field_name( 'target_url' ); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>>Url of the webpage where icons are located (default)</option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>>Url of the homepage of your website</option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>>Custom Url</option>
			</select>
			<input placeholder="Custom url" style="margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampHorSharingTargetUrl" id="<?php echo $this->get_field_id( 'target_url_custom' ); ?>" name="<?php echo $this->get_field_name( 'target_url_custom' ); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? $instance['target_url_custom'] : ''; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'before_widget_content' ); ?>"><?php _e( 'Before widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'before_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'before_widget_content' ); ?>" type="text" value="<?php echo $instance['before_widget_content']; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'after_widget_content' ); ?>"><?php _e( 'After widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'after_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'after_widget_content' ); ?>" type="text" value="<?php echo $instance['after_widget_content']; ?>" /> 
			<br /><br /><label for="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>"><?php _e( 'Hide for logged in users:', 'super-socializer' ); ?></label> 
			<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>" name="<?php echo $this->get_field_name( 'hide_for_logged_in' ); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
	<?php 
    } 
} 
add_action( 'widgets_init', function() { return register_widget( "TheChampSharingWidget" ); } );

/**
 * Widget for Social Sharing (Floating widget)
 */
class TheChampVerticalSharingWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct() { 
		parent::__construct( 
			'TheChampVerticalSharing', //unique id 
			'Super Socializer - Sharing (Floating Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __( 'Floating sharing widget. Let your website users share content on popular Social networks like Facebook, Twitter, Tumblr, Google+ and many more', 'super-socializer' )) 
			); 
	}  

	/** This is rendered widget content */ 
	public function widget( $args, $instance ) { 
		// return if sharing is disabled
		if(!the_champ_social_sharing_enabled() || the_champ_is_amp_page() || !the_champ_vertical_sharing_enabled()){
			return;
		}
		extract( $args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampSharingOptions, $post;
		$postId = $post -> ID;
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$sharingUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				if(is_home()){
					$sharingUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$sharingUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$sharingUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				}elseif(get_permalink($post -> ID)){
					$sharingUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$sharingUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$sharingUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$sharingUrl = get_permalink($post->ID);
		}

		$sharingUrl = heateor_ss_apply_target_share_url_filter($sharingUrl, 'vertical', false);

		$ssOffset = 0;
		if(isset($instance['alignment']) && isset($instance[$instance['alignment'] . '_offset'])){
			$ssOffset = $instance[$instance['alignment'] . '_offset'];
		}

		$shareCountTransientId = heateor_ss_get_share_count_transient_id($sharingUrl);
		$cachedShareCount = heateor_ss_get_cached_share_count($shareCountTransientId);

		echo "<div class='the_champ_sharing_container the_champ_vertical_sharing" . ( isset( $theChampSharingOptions['hide_mobile_sharing'] ) ? ' the_champ_hide_sharing' : '' ) . ( isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? ' the_champ_bottom_sharing' : '' ) . "' " . ( the_champ_is_amp_page() ? "" : "ss-offset='". $ssOffset ."' " ) . "style='width:" . ((isset($theChampSharingOptions['vertical_sharing_size']) ? $theChampSharingOptions['vertical_sharing_size'] : 35) + 4) . "px;".(isset($instance['alignment']) && $instance['alignment'] != '' && isset($instance[$instance['alignment'].'_offset']) ? $instance['alignment'].': '. ( $instance[$instance['alignment'].'_offset'] == '' ? 0 : $instance[$instance['alignment'].'_offset'] ) .'px;' : '').(isset($instance['top_offset']) ? 'top: '. ( $instance['top_offset'] == '' ? 0 : $instance['top_offset'] ) .'px;' : '') . (isset($instance['vertical_bg']) && $instance['vertical_bg'] != '' ? 'background-color: '.$instance['vertical_bg'] . ';' : '-webkit-box-shadow:none;box-shadow:none;') . "' " . ( the_champ_is_amp_page() ? '' : 'super-socializer-data-href="' . $sharingUrl . '"' ) . ($cachedShareCount === false || the_champ_is_amp_page() ? "" : "super-socializer-no-counts='1' ") .">";
		
		if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$sharingUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_username']) && isset($theChampSharingOptions['bitly_username']) && $theChampSharingOptions['bitly_username'] != '' && isset($theChampSharingOptions['bitly_key']) && $theChampSharingOptions['bitly_key'] != ''){
			$shortUrl = the_champ_generate_sharing_bitly_url($sharingUrl, $postId);
			if($shortUrl){
				$sharingUrl = $shortUrl;
			}
		}
		//echo $before_widget;
		echo the_champ_prepare_sharing_html($sharingUrl, 'vertical', isset($instance['show_counts']), isset($instance['total_shares']), $shareCountTransientId);
		echo '</div>';
		if((isset($instance['show_counts']) || isset($instance['total_shares'])) && $cachedShareCount == false){
			echo '<script>theChampLoadEvent(
		function(){
			// sharing counts
			theChampCallAjax(function(){
				theChampGetSharingCounts();
			});
		}
	);</script>';
		}
		//echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['target_url'] = $new_instance['target_url'];
		$instance['show_counts'] = $new_instance['show_counts']; 
		$instance['total_shares'] = $new_instance['total_shares']; 
		$instance['target_url_custom'] = $new_instance['target_url_custom'];
		$instance['alignment'] = $new_instance['alignment'];
		$instance['left_offset'] = $new_instance['left_offset'];
		$instance['right_offset'] = $new_instance['right_offset'];
		$instance['top_offset'] = $new_instance['top_offset'];
		$instance['vertical_bg'] = $new_instance['vertical_bg'];
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array('alignment' => 'left', 'show_counts' => 0, 'total_shares' => 0, 'left_offset' => '40', 'right_offset' => '0', 'target_url' => 'default', 'target_url_custom' => '', 'top_offset' => '100', 'vertical_bg' => '');

		foreach( $instance as $key => $value ) {  
			if ( is_string( $value ) ) {
				$instance[ $key ] = esc_attr( $value );  
			}
		}
		
		$instance = wp_parse_args( (array)$instance, $defaults ); 
		?> 
		<p> 
			<script>
			function theChampToggleSharingOffset(alignment){
				if(alignment == 'left'){
					jQuery('.theChampSharingLeftOffset').css('display', 'block');
					jQuery('.theChampSharingRightOffset').css('display', 'none');
				}else{
					jQuery('.theChampSharingLeftOffset').css('display', 'none');
					jQuery('.theChampSharingRightOffset').css('display', 'block');
				}
			}
			function theChampToggleVerticalSharingTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampVerticalSharingTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampVerticalSharingTargetUrl').css('display', 'none');
				}
			}
			</script>
			<p><strong>Note:</strong> <?php _e('Make sure "Floating Social Sharing" is enabled at "Super Socializer > Social Sharing" page.', 'super-socializer') ?></p>
			<label for="<?php echo $this->get_field_id( 'show_counts' ); ?>"><?php _e( 'Show individual share counts:', 'super-socializer' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'show_counts' ); ?>" name="<?php echo $this->get_field_name( 'show_counts' ); ?>" type="checkbox" value="1" <?php echo isset($instance['show_counts']) && $instance['show_counts'] == 1 ? 'checked' : ''; ?> /><br/><br/> 
			<label for="<?php echo $this->get_field_id( 'total_shares' ); ?>"><?php _e( 'Show total shares:', 'super-socializer' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'total_shares' ); ?>" name="<?php echo $this->get_field_name( 'total_shares' ); ?>" type="checkbox" value="1" <?php echo isset($instance['total_shares']) && $instance['total_shares'] == 1 ? 'checked' : ''; ?> /><br/> <br/>
			<label for="<?php echo $this->get_field_id( 'target_url' ); ?>"><?php _e( 'Target Url:', 'super-socializer' ); ?></label> 
			<select style="width: 95%" onchange="theChampToggleVerticalSharingTargetUrl(this.value)" class="widefat" id="<?php echo $this->get_field_id( 'target_url' ); ?>" name="<?php echo $this->get_field_name( 'target_url' ); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>>Url of the webpage where icons are located (default)</option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>>Url of the homepage of your website</option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>>Custom Url</option>
			</select>
			<input placeholder="Custom url" style="width:95%; margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampVerticalSharingTargetUrl" id="<?php echo $this->get_field_id( 'target_url_custom' ); ?>" name="<?php echo $this->get_field_name( 'target_url_custom' ); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? $instance['target_url_custom'] : ''; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Alignment', 'super-socializer' ); ?></label> 
			<select onchange="theChampToggleSharingOffset(this.value)" style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
				<option value="left" <?php echo $instance['alignment'] == 'left' ? 'selected' : ''; ?>><?php _e( 'Left', 'super-socializer' ) ?></option>
				<option value="right" <?php echo $instance['alignment'] == 'right' ? 'selected' : ''; ?>><?php _e( 'Right', 'super-socializer' ) ?></option>
			</select>
			<div class="theChampSharingLeftOffset" <?php echo $instance['alignment'] == 'right' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo $this->get_field_id( 'left_offset' ); ?>"><?php _e( 'Left Offset', 'super-socializer' ); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'left_offset' ); ?>" name="<?php echo $this->get_field_name( 'left_offset' ); ?>" type="text" value="<?php echo $instance['left_offset']; ?>" />px<br/>
			</div>
			<div class="theChampSharingRightOffset" <?php echo $instance['alignment'] == 'left' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo $this->get_field_id( 'right_offset' ); ?>"><?php _e( 'Right Offset', 'super-socializer' ); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'right_offset' ); ?>" name="<?php echo $this->get_field_name( 'right_offset' ); ?>" type="text" value="<?php echo $instance['right_offset']; ?>" />px<br/>
			</div>
			<label for="<?php echo $this->get_field_id( 'top_offset' ); ?>"><?php _e( 'Top Offset', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'top_offset' ); ?>" name="<?php echo $this->get_field_name( 'top_offset' ); ?>" type="text" value="<?php echo $instance['top_offset']; ?>" />px<br/>
			
			<label for="<?php echo $this->get_field_id( 'vertical_bg' ); ?>"><?php _e( 'Background Color', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'vertical_bg' ); ?>" name="<?php echo $this->get_field_name( 'vertical_bg' ); ?>" type="text" value="<?php echo $instance['vertical_bg']; ?>" />
			
			<br /><br /><label for="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>"><?php _e( 'Hide for logged in users:', 'super-socializer' ); ?></label> 
			<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>" name="<?php echo $this->get_field_name( 'hide_for_logged_in' ); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
	<?php 
    } 
}
add_action( 'widgets_init', function() { return register_widget( "TheChampVerticalSharingWidget" ); } );

/**
 * Widget for Social Counter (Standard widget)
 */
class TheChampCounterWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct() { 
		parent::__construct( 
			'TheChampHorizontalCounter', //unique id 
			'Super Socializer - Like Buttons (Standard Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __( 'Standard like buttons widget. Let your website users share/like content on popular Social networks like Facebook, Twitter, Google+ and many more', 'super-socializer' )
			)
		); 
	}  

	/** This is rendered widget content */ 
	public function widget( $args, $instance ) { 
		// return if sharing is disabled
		if(!the_champ_social_counter_enabled() || !the_champ_horizontal_counter_enabled()){
			return;
		}
		extract( $args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampCounterOptions, $post;
		$postId = $post -> ID;
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$counterUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				if(is_home()){
					$counterUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$counterUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$counterUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				}elseif(get_permalink($post -> ID)){
					$counterUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$counterUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$counterUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$counterUrl = get_permalink($post->ID);
		}

		$counterUrl = heateor_ss_apply_target_like_button_url_filter($counterUrl, 'horizontal', !is_singular() ? true : false);
		echo "<div class='the_champ_counter_container the_champ_horizontal_counter'>";
		
		echo $before_widget;
		
		if( !empty( $instance['title'] ) ){ 
			$title = apply_filters( 'widget_title', $instance[ 'title' ] ); 
			echo $before_title . $title . $after_title;
		}

		if( !empty( $instance['before_widget_content'] ) ){ 
			echo '<div>' . $instance['before_widget_content'] . '</div>'; 
		}
		// if bit.ly integration enabled, generate bit.ly short url
		$shortUrl = $counterUrl;
		if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$shortUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_username']) && isset($theChampCounterOptions['bitly_username']) && $theChampCounterOptions['bitly_username'] != '' && isset($theChampCounterOptions['bitly_key']) && $theChampCounterOptions['bitly_key'] != ''){
			$tempShortUrl = the_champ_generate_counter_bitly_url($counterUrl, $postId);
			if($tempShortUrl){
				$shortUrl = $tempShortUrl;
			}
		}
		echo the_champ_prepare_counter_html($counterUrl, 'horizontal', $shortUrl, !is_singular() ? true : false);

		if( !empty( $instance['after_widget_content'] ) ){ 
			echo '<div>' . $instance['after_widget_content'] . '</div>'; 
		}
		
		echo "</div>";
		echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['title'] = strip_tags( $new_instance['title'] ); 
		$instance['target_url'] = strip_tags( $new_instance['target_url'] ); 
		$instance['target_url_custom'] = strip_tags( $new_instance['target_url_custom'] ); 
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content']; 
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];  

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array( 'title' => 'Share the joy', 'before_widget_content' => '', 'after_widget_content' => '', 'target_url_custom' => '', 'target_url' => 'default' );

		foreach( $instance as $key => $value ) {  
			if ( is_string( $value ) ) {
				$instance[ $key ] = esc_attr( $value );  
			}
		}
		
		$instance = wp_parse_args( (array)$instance, $defaults ); 
		?> 
		<script type="text/javascript">
			function theChampToggleHorCounterTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampHorCounterTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampHorCounterTargetUrl').css('display', 'none');
				}
			}
		</script>
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure "Standard Like Buttons" are enabled from "Super Socializer > Like Buttons" page.', 'super-socializer') ?></p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'target_url' ); ?>"><?php _e( 'Target Url:', 'super-socializer' ); ?></label> 
			<select style="width: 95%" onchange="theChampToggleHorCounterTargetUrl(this.value)" class="widefat" id="<?php echo $this->get_field_id( 'target_url' ); ?>" name="<?php echo $this->get_field_name( 'target_url' ); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>>Url of the webpage where icons are located (default)</option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>>Url of the homepage of your website</option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>>Custom Url</option>
			</select>
			<input placeholder="Custom url" style="width:95%; margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampHorCounterTargetUrl" id="<?php echo $this->get_field_id( 'target_url_custom' ); ?>" name="<?php echo $this->get_field_name( 'target_url_custom' ); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? $instance['target_url_custom'] : ''; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'before_widget_content' ); ?>"><?php _e( 'Before widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'before_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'before_widget_content' ); ?>" type="text" value="<?php echo $instance['before_widget_content']; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'after_widget_content' ); ?>"><?php _e( 'After widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'after_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'after_widget_content' ); ?>" type="text" value="<?php echo $instance['after_widget_content']; ?>" /> 
			<br /><br /><label for="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>"><?php _e( 'Hide for logged in users:', 'super-socializer' ); ?></label> 
			<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>" name="<?php echo $this->get_field_name( 'hide_for_logged_in' ); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> /> 
		</p> 
	<?php 
    } 
} 
add_action( 'widgets_init', function() { return register_widget( "TheChampCounterWidget" ); } );

/**
 * Widget for Social Counter (Floating widget)
 */
class TheChampVerticalCounterWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct() { 
		parent::__construct( 
			'TheChampVerticalCounter', //unique id 
			'Super Socializer - Like Buttons (Floating Widget)', //title displayed at admin panel 
			//Additional parameters 
			array(
				'description' => __( 'Floating like buttons widget. Let your website users share/like content on popular Social networks like Facebook, Twitter, Google+ and many more', 'super-socializer' )) 
			); 
	}  

	/** This is rendered widget content */ 
	public function widget( $args, $instance ) { 
		// return if counter is disabled
		if(!the_champ_social_counter_enabled() || !the_champ_vertical_counter_enabled()){
			return;
		}
		extract( $args );
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		global $theChampCounterOptions, $post;
		$postId = $post -> ID;
		$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);
		if($customUrl){
			$sharingUrl = $customUrl;
			$postId = 0;
		}elseif(isset($instance['target_url'])){
			if($instance['target_url'] == 'default'){
				$counterUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				if(is_home()){
					$counterUrl = esc_url(home_url());
					$postId = 0;
				}elseif(!is_singular()){
					$counterUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					$postId = 0;
				}elseif(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']){
					$counterUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				}elseif(get_permalink($post -> ID)){
					$counterUrl = get_permalink($post->ID);
				}
			}elseif($instance['target_url'] == 'homepage'){
				$counterUrl = esc_url(home_url());
				$postId = 0;
			}elseif($instance['target_url'] == 'custom'){
				$counterUrl = isset($instance['target_url_custom']) ? trim($instance['target_url_custom']) : get_permalink($post->ID);
				$postId = 0;
			}
		}else{
			$counterUrl = get_permalink($post->ID);
		}

		$counterUrl = heateor_ss_apply_target_like_button_url_filter($counterUrl, 'vertical', false);

		$ssOffset = 0;
		if(isset($instance['alignment']) && isset($instance[$instance['alignment'] . '_offset'])){
			$ssOffset = $instance[$instance['alignment'] . '_offset'];
		}
		echo "<div class='the_champ_counter_container the_champ_vertical_counter" . ( isset( $theChampCounterOptions['hide_mobile_likeb'] ) ? ' the_champ_hide_sharing' : '' ) . "' " . ( the_champ_is_amp_page() ? "" : "ss-offset='". $ssOffset ."' " ) . "style='".(isset($instance['alignment']) && $instance['alignment'] != '' && isset($instance[$instance['alignment'].'_offset']) ? $instance['alignment'].': '. ( $instance[$instance['alignment'].'_offset'] == '' ? 0 : $instance[$instance['alignment'].'_offset'] ) .'px;' : '').(isset($instance['top_offset']) ? 'top: '. ( $instance['top_offset'] == '' ? 0 : $instance['top_offset'] ) .'px;' : '') . (isset($instance['vertical_bg']) && $instance['vertical_bg'] != '' ? 'background-color: '.$instance['vertical_bg'] . ';' : '-webkit-box-shadow:none;box-shadow:none;') . "' >";
		// if bit.ly integration enabled, generate bit.ly short url
		$shortUrl = $counterUrl;
		if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
			$shortUrl = wp_get_shortlink();
			// if bit.ly integration enabled, generate bit.ly short url
		}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_username']) && isset($theChampCounterOptions['bitly_username']) && $theChampCounterOptions['bitly_username'] != '' && isset($theChampCounterOptions['bitly_key']) && $theChampCounterOptions['bitly_key'] != ''){
			$tempShortUrl = the_champ_generate_counter_bitly_url($counterUrl, $postId);
			if($tempShortUrl){
				$shortUrl = $tempShortUrl;
			}
		}
		//echo $before_widget;
		echo the_champ_prepare_counter_html($counterUrl, 'vertical', $shortUrl);
		echo "</div>";
		//echo $after_widget;
	}  

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['target_url'] = strip_tags( $new_instance['target_url'] ); 
		$instance['target_url_custom'] = strip_tags( $new_instance['target_url_custom'] ); 
		$instance['alignment'] = $new_instance['alignment'];
		$instance['left_offset'] = $new_instance['left_offset'];
		$instance['right_offset'] = $new_instance['right_offset'];
		$instance['top_offset'] = $new_instance['top_offset'];
		$instance['vertical_bg'] = $new_instance['vertical_bg'];
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];

		return $instance; 
	}  

	/** Widget edit form at admin panel */ 
	public function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array('alignment' => 'left', 'left_offset' => '40', 'right_offset' => '0', 'top_offset' => '100', 'vertical_bg' => '', 'target_url' => 'default', 'target_url_custom' => '');

		foreach( $instance as $key => $value ) {  
			if ( is_string( $value ) ) {
				$instance[ $key ] = esc_attr( $value );  
			}
		}
		
		$instance = wp_parse_args( (array)$instance, $defaults ); 
		?> 
		<p> 
			<script>
			function theChampToggleCounterOffset(alignment){
				if(alignment == 'left'){
					jQuery('.theChampCounterLeftOffset').css('display', 'block');
					jQuery('.theChampCounterRightOffset').css('display', 'none');
				}else{
					jQuery('.theChampCounterLeftOffset').css('display', 'none');
					jQuery('.theChampCounterRightOffset').css('display', 'block');
				}
			}
			function theChampToggleVerticalCounterTargetUrl(val){
				if(val == 'custom'){
					jQuery('.theChampVerticalCounterTargetUrl').css('display', 'block');
				}else{
					jQuery('.theChampVerticalCounterTargetUrl').css('display', 'none');
				}
			}
			</script>
		<p> 
			<p><strong>Note:</strong> <?php _e('Make sure "Floating Like Buttons" are enabled from "Super Socializer > Like Buttons" page.', 'super-socializer') ?></p>
			<label for="<?php echo $this->get_field_id( 'target_url' ); ?>"><?php _e( 'Target Url:', 'super-socializer' ); ?></label> 
			<select style="width: 95%" onchange="theChampToggleVerticalCounterTargetUrl(this.value)" class="widefat" id="<?php echo $this->get_field_id( 'target_url' ); ?>" name="<?php echo $this->get_field_name( 'target_url' ); ?>">
				<option value="">--<?php _e('Select', 'super-socializer') ?>--</option>
				<option value="default" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'default' ? 'selected' : '' ; ?>>Url of the webpage where icons are located (default)</option>
				<option value="homepage" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'homepage' ? 'selected' : '' ; ?>>Url of the homepage of your website</option>
				<option value="custom" <?php echo isset($instance['target_url']) && $instance['target_url'] == 'custom' ? 'selected' : '' ; ?>>Custom Url</option>
			</select>
			<input placeholder="Custom url" style="width:95%; margin-top: 5px; <?php echo !isset($instance['target_url']) || $instance['target_url'] != 'custom' ? 'display: none' : '' ; ?>" class="widefat theChampVerticalCounterTargetUrl" id="<?php echo $this->get_field_id( 'target_url_custom' ); ?>" name="<?php echo $this->get_field_name( 'target_url_custom' ); ?>" type="text" value="<?php echo isset($instance['target_url_custom']) ? $instance['target_url_custom'] : ''; ?>" /> 
			<label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Alignment', 'super-socializer' ); ?></label> 
			<select style="width: 95%" onchange="theChampToggleCounterOffset(this.value)" class="widefat" id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
				<option value="left" <?php echo $instance['alignment'] == 'left' ? 'selected' : ''; ?>><?php _e( 'Left', 'super-socializer' ) ?></option>
				<option value="right" <?php echo $instance['alignment'] == 'right' ? 'selected' : ''; ?>><?php _e( 'Right', 'super-socializer' ) ?></option>
			</select>
			<div class="theChampCounterLeftOffset" <?php echo $instance['alignment'] == 'right' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo $this->get_field_id( 'left_offset' ); ?>"><?php _e( 'Left Offset', 'super-socializer' ); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'left_offset' ); ?>" name="<?php echo $this->get_field_name( 'left_offset' ); ?>" type="text" value="<?php echo $instance['left_offset']; ?>" />px<br/>
			</div>
			<div class="theChampCounterRightOffset" <?php echo $instance['alignment'] == 'left' ? 'style="display: none"' : ''; ?>>
				<label for="<?php echo $this->get_field_id( 'right_offset' ); ?>"><?php _e( 'Right Offset', 'super-socializer' ); ?></label> 
				<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'right_offset' ); ?>" name="<?php echo $this->get_field_name( 'right_offset' ); ?>" type="text" value="<?php echo $instance['right_offset']; ?>" />px<br/>
			</div>
			<label for="<?php echo $this->get_field_id( 'top_offset' ); ?>"><?php _e( 'Top Offset', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'top_offset' ); ?>" name="<?php echo $this->get_field_name( 'top_offset' ); ?>" type="text" value="<?php echo $instance['top_offset']; ?>" />px<br/>
			
			<label for="<?php echo $this->get_field_id( 'vertical_bg' ); ?>"><?php _e( 'Background Color', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'vertical_bg' ); ?>" name="<?php echo $this->get_field_name( 'vertical_bg' ); ?>" type="text" value="<?php echo $instance['vertical_bg']; ?>" />
			
			<br /><br /><label for="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>"><?php _e( 'Hide for logged in users:', 'super-socializer' ); ?></label> 
			<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>" name="<?php echo $this->get_field_name( 'hide_for_logged_in' ); ?>" type="text" value="1" <?php if(isset($instance['hide_for_logged_in'])  && $instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> />
		</p> 
	<?php 
    } 
} 
add_action( 'widgets_init', function() { return register_widget( "TheChampVerticalCounterWidget" ); } );

/**
 * Widget for Social Media follow icons
 */
class TheChampFollowWidget extends WP_Widget { 
	/** constructor */ 
	public function __construct() { 
		parent::__construct( 
			'TheChampFollow', //unique id 
			__('Super Socializer - Follow Icons', 'super-socializer'), //title displayed at admin panel
			array(  
				'description' => __( 'These icons link to your Social Media accounts', 'super-socializer' )) 
			); 
	}
	
	/** This is rendered widget content */ 
	public function widget( $args, $instance ) {
		extract( $args ); 
		echo $before_widget;
		if( !empty( $instance['before_widget_content'] ) ){ 
			echo '<div>' . $instance['before_widget_content'] . '</div>';
		}
		echo '<div class="heateor_ss_follow_icons_container">';
		if( !empty( $instance['title'] ) ){ 
			$title = apply_filters( 'widget_title', $instance[ 'title' ] ); 
			echo $before_title . $title . $after_title;
		}
		echo $this->follow_icons( $instance );
		echo '<div style="clear:both"></div>';
		echo '</div>';
		if( !empty( $instance['after_widget_content'] ) ){ 
			echo '<div>' . $instance['after_widget_content'] . '</div>';
		}
		echo $after_widget; 
	}  

	/** Render follow icons */
	private function follow_icons( $instance ) {
		$html = '';
		$iconStyle = 'width:'. $instance['size'] .'px;height:'. $instance['size'] .'px;'. ( $instance['icon_shape'] == 'round' ? 'border-radius:999px;' : '' );
		$html .= '<ul class="heateor_ss_follow_ul">';
		if ( $instance['facebook'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Facebook" title="Facebook" class="theChampSharing theChampFacebookBackground"><a target="_blank" href="'. $instance['facebook'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampFacebookSvg"></ss></a></i></li>';
		}
		if ( $instance['twitter'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Twitter" title="Twitter" class="theChampSharing theChampTwitterBackground"><a target="_blank" href="'. $instance['twitter'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampTwitterSvg"></ss></a></i></li>';
		}
		if ( $instance['instagram'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Instagram" title="Instagram" class="theChampSharing theChampInstagramBackground"><a target="_blank" href="'. $instance['instagram'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampInstagramSvg"></ss></a></i></li>';
		}
		if ( $instance['pinterest'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Pinterest" title="Pinterest" class="theChampSharing theChampPinterestBackground"><a target="_blank" href="'. $instance['pinterest'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampPinterestSvg"></ss></a></i></li>';
		}
		if ( $instance['behance'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Behance" title="Behance" class="theChampSharing theChampBehanceBackground"><a target="_blank" href="'. $instance['behance'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampBehanceSvg"></ss></a></i></li>';
		}
		if ( $instance['flickr'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Flickr" title="Flickr" class="theChampSharing theChampFlickrBackground"><a target="_blank" href="'. $instance['flickr'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampFlickrSvg"></ss></a></i></li>';
		}
		if ( $instance['foursquare'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Foursquare" title="Foursquare" class="theChampSharing theChampFoursquareBackground"><a target="_blank" href="'. $instance['foursquare'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampFoursquareSvg"></ss></a></i></li>';
		}
		if ( $instance['github'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Github" title="Github" class="theChampSharing theChampGithubBackground"><a target="_blank" href="'. $instance['github'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampGithubSvg"></ss></a></i></li>';
		}
		if ( $instance['google'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Google+" title="Google+" class="theChampSharing theChampGoogleplusBackground"><a target="_blank" href="'. $instance['google'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampGoogleplusSvg"></ss></a></i></li>';
		}
		if ( $instance['linkedin'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Linkedin" title="Linkedin" class="theChampSharing theChampLinkedinBackground"><a target="_blank" href="'. $instance['linkedin'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampLinkedinSvg"></ss></a></i></li>';
		}
		if ( $instance['linkedin_company'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Linkedin Company" title="Linkedin Company" class="theChampSharing theChampLinkedinBackground"><a target="_blank" href="'. $instance['linkedin_company'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampLinkedinSvg"></ss></a></i></li>';
		}
		if ( $instance['snapchat'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Snapchat" title="Snapchat" class="theChampSharing theChampSnapchatBackground"><a target="_blank" href="'. $instance['snapchat'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampSnapchatSvg"></ss></a></i></li>';
		}
		if ( $instance['tumblr'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Tumblr" title="Tumblr" class="theChampSharing theChampTumblrBackground"><a target="_blank" href="'. $instance['tumblr'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampTumblrSvg"></ss></a></i></li>';
		}
		if ( $instance['vimeo'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Vimeo" title="Vimeo" class="theChampSharing theChampVimeoBackground"><a target="_blank" href="'. $instance['vimeo'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampVimeoSvg"></ss></a></i></li>';
		}
		if ( $instance['youtube'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Youtube" title="Youtube" class="theChampSharing theChampYoutubeBackground"><a target="_blank" href="'. $instance['youtube'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampYoutubeSvg"></ss></a></i></li>';
		}
		if ( $instance['youtube_channel'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="Youtube Channel" title="Youtube Channel" class="theChampSharing theChampYoutubeBackground"><a target="_blank" href="'. $instance['youtube_channel'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampYoutubeSvg"></ss></a></i></li>';
		}
		if ( $instance['rss_feed'] ) {
			$html .= '<li class="theChampSharingRound"><i style="'. $iconStyle .'" alt="RSS Feed" title="RSS Feed" class="theChampSharing theChampRSSBackground"><a target="_blank" href="'. $instance['rss_feed'] .'" rel="noopener"><ss style="display:block" class="theChampSharingSvg theChampRSSSvg"></ss></a></i></li>';
		}
		$html = apply_filters( 'heateor_ss_follow_icons', $html, $instance, $iconStyle );
		$html .= '<ul>';

		return $html;
	}

	/** Everything which should happen when user edit widget at admin panel */ 
	public function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['size'] = intval( $new_instance['size'] );
		$instance['icon_shape'] = $new_instance['icon_shape'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['instagram'] = $new_instance['instagram'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['behance'] = $new_instance['behance'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['foursquare'] = $new_instance['foursquare'];
		$instance['github'] = $new_instance['github'];
		$instance['google'] = $new_instance['google'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['linkedin_company'] = $new_instance['linkedin_company'];
		$instance['snapchat'] = $new_instance['snapchat'];
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['youtube_channel'] = $new_instance['youtube_channel'];
		$instance['rss_feed'] = $new_instance['rss_feed'];
		$instance['before_widget_content'] = $new_instance['before_widget_content']; 
		$instance['after_widget_content'] = $new_instance['after_widget_content'];

		return $instance; 
	}  

	/** Widget options in admin panel */ 
	public function form( $instance ) { 
		/* Set up default widget settings. */ 
		$defaults = array( 'title' => '', 'size' => '32', 'icon_shape' => 'round', 'facebook' => '', 'twitter' => '', 'instagram' => '', 'pinterest' => '', 'behance' => '', 'flickr' => '', 'foursquare' => '', 'github' => '', 'google' => '', 'linkedin' => '', 'linkedin_company' => '', 'snapchat' => '', 'tumblr' => '', 'vimeo' => '', 'youtube' => '', 'youtube_channel' => '', 'rss_feed' => '', 'before_widget_content' => '', 'after_widget_content' => '' );  

		foreach( $instance as $key => $value ) {  
			if ( is_string( $value ) ) {
				$instance[ $key ] = esc_attr( $value );  
			}
		}

		$instance = wp_parse_args( (array)$instance, $defaults ); 
		?> 
		<p>
			<label for="<?php echo $this->get_field_id( 'before_widget_content' ); ?>"><?php _e( 'Before widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'before_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'before_widget_content' ); ?>" type="text" value="<?php echo $instance['before_widget_content']; ?>" /><br/><br/>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" /><br/><br/>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size of icons', 'super-socializer' ); ?></label> 
			<input style="width: 82%" class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" type="text" value="<?php echo $instance['size']; ?>" />pixels<br/><br/>
			<label for="<?php echo $this->get_field_id( 'icon_shape' ); ?>"><?php _e( 'Icon Shape', 'super-socializer' ); ?></label> 
			<select style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'icon_shape' ); ?>" name="<?php echo $this->get_field_name( 'icon_shape' ); ?>">
				<option value="round" <?php echo !isset($instance['icon_shape']) || $instance['icon_shape'] == 'round' ? 'selected' : '' ; ?>><?php _e( 'Round', 'super-socializer' ); ?></option>
				<option value="square" <?php echo isset($instance['icon_shape']) && $instance['icon_shape'] == 'square' ? 'selected' : '' ; ?>><?php _e( 'Square', 'super-socializer' ); ?></option>
			</select><br/><br/>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo $instance['facebook']; ?>" /><br/>
			<span>https://www.facebook.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo $instance['twitter']; ?>" /><br/>
			<span>https://twitter.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo $instance['instagram']; ?>" /><br/>
			<span>https://www.instagram.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Pinterest ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" value="<?php echo $instance['pinterest']; ?>" /><br/>
			<span>https://www.pinterest.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'behance' ); ?>"><?php _e( 'Behance ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" type="text" value="<?php echo $instance['behance']; ?>" /><br/>
			<span>https://www.behance.net/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e( 'Flickr ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" type="text" value="<?php echo $instance['flickr']; ?>" /><br/>
			<span>https://www.flickr.com/photos/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'foursquare' ); ?>"><?php _e( 'Foursquare ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'foursquare' ); ?>" name="<?php echo $this->get_field_name( 'foursquare' ); ?>" type="text" value="<?php echo $instance['foursquare']; ?>" /><br/>
			<span>https://foursquare.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e( 'Github ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" type="text" value="<?php echo $instance['github']; ?>" /><br/>
			<span>https://github.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'google' ); ?>"><?php _e( 'Google+ ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'google' ); ?>" name="<?php echo $this->get_field_name( 'google' ); ?>" type="text" value="<?php echo $instance['google']; ?>" /><br/>
			<span>https://plus.google.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'LinkedIn ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo $instance['linkedin']; ?>" /><br/>
			<span>https://www.linkedin.com/in/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'linkedin_company' ); ?>"><?php _e( 'LinkedIn Company ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'linkedin_company' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_company' ); ?>" type="text" value="<?php echo $instance['linkedin_company']; ?>" /><br/>
			<span>https://www.linkedin.com/company/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'snapchat' ); ?>"><?php _e( 'Snapchat ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'snapchat' ); ?>" name="<?php echo $this->get_field_name( 'snapchat' ); ?>" type="text" value="<?php echo $instance['snapchat']; ?>" /><br/>
			<span>https://www.snapchat.com/add/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?php _e( 'Tumblr ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" type="text" value="<?php echo $instance['tumblr']; ?>" /><br/>
			<span>https://ID.tumblr.com</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e( 'Vimeo ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" type="text" value="<?php echo $instance['vimeo']; ?>" /><br/>
			<span>https://vimeo.com/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Youtube ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo $instance['youtube']; ?>" /><br/>
			<span>https://www.youtube.com/user/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'youtube_channel' ); ?>"><?php _e( 'Youtube Channel ID:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'youtube_channel' ); ?>" name="<?php echo $this->get_field_name( 'youtube_channel' ); ?>" type="text" value="<?php echo $instance['youtube_channel']; ?>" /><br/>
			<span>https://www.youtube.com/channel/ID</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'rss_feed' ); ?>"><?php _e( 'RSS Feed URL:', 'super-socializer' ); ?></label> 
			<input style="width: 95%" class="widefat" id="<?php echo $this->get_field_id( 'rss_feed' ); ?>" name="<?php echo $this->get_field_name( 'rss_feed' ); ?>" type="text" value="<?php echo $instance['rss_feed']; ?>" /><br/>
			<span>http://www.example.com/feed/</span><br/><br/>
			<label for="<?php echo $this->get_field_id( 'after_widget_content' ); ?>"><?php _e( 'After widget content:', 'super-socializer' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'after_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'after_widget_content' ); ?>" type="text" value="<?php echo $instance['after_widget_content']; ?>" /> 
		</p> 
<?php 
  } 
} 
add_action( 'widgets_init', function() { return register_widget( "TheChampFollowWidget" ); } ); 