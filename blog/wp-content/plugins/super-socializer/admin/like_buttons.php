<?php defined('ABSPATH') or die("Cheating........Uh!!"); ?>

<div id="fb-root"></div>

<div class="metabox-holder columns-2" id="post-body">
	<form action="options.php" method="post">
		<?php settings_fields('the_champ_counter_options'); ?>
		
		<div class="stuffbox" style="width:98.7%">
			<h3><label><?php _e('Master Control', 'super-socializer' );?></label></h3>
			<div class="inside">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr>
						<th>
						<img id="the_champ_sc_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_counter_enable"><?php _e("Enable Like Buttons", 'super-socializer'); ?></label>
						</th>
						<td>
						<input id="the_champ_counter_enable" name="the_champ_counter[enable]" type="checkbox" <?php echo isset($theChampCounterOptions['enable']) ? 'checked = "checked"' : '';?> value="1" />
						</td>
					</tr>
					
					<tr class="the_champ_help_content" id="the_champ_sc_enable_help_cont">
						<td colspan="2">
						<div>
						<?php _e('Master control for like buttons. It must be checked to enable like buttons functionality', 'super-socializer') ?>
						</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="menu_div" id="tabs" <?php echo isset($theChampCounterOptions['enable']) ? '' : 'style="display:none"' ?>>
			<h2 class="nav-tab-wrapper" style="height:34px">
			<ul>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-1"><?php _e('Standard Interface', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-2"><?php _e('Floating Interface', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-3"><?php _e('Miscellaneous', 'super-socializer' ) ?></a></li>
				<?php
				if(heateor_ss_is_plugin_active('mycred/mycred.php')){
					?>
					<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-4"><?php _e('3rd Party Integration', 'super-socializer' ) ?></a></li>
					<?php
				}
				?>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-5"><?php _e('Shortcode & Widget', 'super-socializer') ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-6"><?php _e('FAQ', 'super-socializer' ) ?></a></li>
			</ul>
			</h2>
			<div class="menu_containt_div" id="tabs-1">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				
				<div class="stuffbox">
					<h3><label><?php _e('Standard Interface Options', 'super-socializer');?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_sc_horizontal_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_horizontal_enable"><?php _e("Enable standard interface", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_horizontal_enable" onclick="theChampHorizontalCounterOptionsToggle(this)" name="the_champ_counter[hor_enable]" type="checkbox" <?php echo isset($theChampCounterOptions['hor_enable']) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_horizontal_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Master control to enable horizontal like buttons', 'super-socializer') ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_horizontal_counter.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_horizontal_counter_options" <?php echo isset($theChampCounterOptions['hor_enable']) ? '' : 'style="display: none"'; ?>>
						<tr>
							<th>
							<img id="the_champ_sc_horizontal_target_url_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_target_url"><?php _e("Target Url", 'super-socializer'); ?></label>
							</th>
							<td id="the_champ_target_url_column">
							<input id="the_champ_target_url_default" name="the_champ_counter[horizontal_target_url]" type="radio" <?php echo !isset($theChampCounterOptions['horizontal_target_url']) || $theChampCounterOptions['horizontal_target_url'] == 'default' ? 'checked = "checked"' : '';?> value="default" />
							<label for="the_champ_target_url_default"><?php _e('Url of the webpage where icons are located (default)', 'super-socializer') ?></label><br/>
							<input id="the_champ_target_url_home" name="the_champ_counter[horizontal_target_url]" type="radio" <?php echo isset($theChampCounterOptions['horizontal_target_url']) && $theChampCounterOptions['horizontal_target_url'] == 'home' ? 'checked = "checked"' : '';?> value="home" />
							<label for="the_champ_target_url_home"><?php _e('Url of the homepage of your website', 'super-socializer') ?></label><br/>
							<input id="the_champ_target_url_custom" name="the_champ_counter[horizontal_target_url]" type="radio" <?php echo isset($theChampCounterOptions['horizontal_target_url']) && $theChampCounterOptions['horizontal_target_url'] == 'custom' ? 'checked = "checked"' : '';?> value="custom" />
							<label for="the_champ_target_url_custom"><?php _e('Custom url', 'super-socializer') ?></label><br/>
							<input id="the_champ_target_url_custom_url" name="the_champ_counter[horizontal_target_url_custom]" type="text" value="<?php echo isset($theChampCounterOptions['horizontal_target_url_custom']) ? $theChampCounterOptions['horizontal_target_url_custom'] : '' ?>" />
							</td>
						</tr>
						<tr class="the_champ_help_content" id="the_champ_sc_horizontal_target_url_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Url to like/share/tweet and display like/share/tweet counts', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_title_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_fblogin_title"><?php _e("Title", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_fblogin_title" name="the_champ_counter[title]" type="text" value="<?php echo isset($theChampCounterOptions['title']) ? $theChampCounterOptions['title'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_title_help_cont">
							<td colspan="2">
							<div>
							<?php _e('The text to display above the interface', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_providers_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Select and rearrange providers", 'super-socializer'); ?></label>
							</th>
							<td>
							<ul id="the_champ_sc_rearrange">
							<?php
							$counterProviders = array('facebook_share', 'facebook_like', 'facebook_recommend', 'twitter_tweet', 'linkedin_share', 'google_plusone', 'googleplus_share', 'pinterest_pin_it', 'xing', 'reddit', 'stumbleupon_badge', 'yummly', 'buffer');
							// show selected providers
							if(isset($theChampCounterOptions['horizontal_providers']) && is_array($theChampCounterOptions['horizontal_providers'])){
								foreach($theChampCounterOptions['horizontal_providers'] as $selected){
									$labelParts = explode('_', $selected);
									$labelParts = array_map('the_champ_first_letter_uppercase', $labelParts);
									$label = implode(' ', $labelParts);
									?>
									<li>
									<input id="the_champ_counter_<?php echo $selected ?>" name="the_champ_counter[horizontal_providers][]" type="checkbox" checked = "checked" value="<?php echo $selected ?>" />
									<label for="the_champ_counter_<?php echo $selected ?>"><?php _e($label, 'super-socializer'); ?></label>
									</li>
									<?php
								}
							}else{
								$theChampCounterOptions['horizontal_providers'] = array();
							}
							$remaining = array_diff($counterProviders, $theChampCounterOptions['horizontal_providers']);
							if(is_array($remaining)){
								foreach($remaining as $provider){
									$labelParts = explode('_', $provider);
									$labelParts = array_map('the_champ_first_letter_uppercase', $labelParts);
									$label = implode(' ', $labelParts);
									?>
									<li>
									<input id="the_champ_counter_<?php echo $provider ?>" name="the_champ_counter[horizontal_providers][]" type="checkbox" value="<?php echo $provider ?>" />
									<label for="the_champ_counter_<?php echo $provider ?>"><?php _e($label, 'super-socializer'); ?></label>
									</li>
									<?php
								}
							}
							?>
							</ul>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_providers_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Select the providers for interface. Drag them to rearrange.', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_hor_alignment_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_hor_alignment"><?php _e("Horizontal alignment", 'super-socializer'); ?></label>
							</th>
							<td>
							<select id="the_champ_sc_hor_alignment" name="the_champ_counter[hor_counter_alignment]">
								<option value="left" <?php echo isset($theChampCounterOptions['hor_counter_alignment']) && $theChampCounterOptions['hor_counter_alignment'] == 'left' ? 'selected="selected"' : '' ?>><?php _e('Left', 'super-socializer') ?></option>
								<option value="center" <?php echo isset($theChampCounterOptions['hor_counter_alignment']) && $theChampCounterOptions['hor_counter_alignment'] == 'center' ? 'selected="selected"' : '' ?>><?php _e('Center', 'super-socializer') ?></option>
								<option value="right" <?php echo isset($theChampCounterOptions['hor_counter_alignment']) && $theChampCounterOptions['hor_counter_alignment'] == 'right' ? 'selected="selected"' : '' ?>><?php _e('Right', 'super-socializer') ?></option>
							</select>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_hor_alignment_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Horizontal alignment of the interface', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_position_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Position with respect to content", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_counter_top" name="the_champ_counter[top]" type="checkbox" <?php echo isset($theChampCounterOptions['top']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_top"><?php _e('Top of the content', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_bottom" name="the_champ_counter[bottom]" type="checkbox" <?php echo isset($theChampCounterOptions['bottom']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_bottom"><?php _e('Bottom of the content', 'super-socializer') ?></label>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_position_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify position of the interface with respect to the content', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_location_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Interface location", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_counter_home" name="the_champ_counter[home]" type="checkbox" <?php echo isset($theChampCounterOptions['home']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_home"><?php _e('Homepage', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_post" name="the_champ_counter[post]" type="checkbox" <?php echo isset($theChampCounterOptions['post']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_post"><?php _e('Posts', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_page" name="the_champ_counter[page]" type="checkbox" <?php echo isset($theChampCounterOptions['page']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_page"><?php _e('Pages', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_excerpt" name="the_champ_counter[excerpt]" type="checkbox" <?php echo isset($theChampCounterOptions['excerpt']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_excerpt"><?php _e('Excerpts and Posts page', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_category" name="the_champ_counter[category]" type="checkbox" <?php echo isset($theChampCounterOptions['category']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_category"><?php _e('Category Archives', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_archive" name="the_champ_counter[archive]" type="checkbox" <?php echo isset($theChampCounterOptions['archive']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_archive"><?php _e('Archive Pages (Category, Tag, Author or Date based pages)', 'super-socializer') ?></label><br/>
							<?php
							$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
							$post_types = array_diff( $post_types, array( 'post', 'page' ) );
							if( count( $post_types ) ) {
								foreach ( $post_types as $post_type ) {
									?>
									<input id="the_champ_counter_<?php echo $post_type ?>" name="the_champ_counter[<?php echo $post_type ?>]" type="checkbox" <?php echo isset($theChampCounterOptions[$post_type]) ? 'checked = "checked"' : '';?> value="1" />
									<label for="the_champ_counter_<?php echo $post_type ?>"><?php echo ucfirst( $post_type ) . 's'; ?></label><br/>
									<?php
								}
							}
							if($theChampIsBpActive){
								?>
								<br/>
								<input id="the_champ_counter_bp_activity" name="the_champ_counter[bp_activity]" type="checkbox" <?php echo isset($theChampCounterOptions['bp_activity']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_bp_activity"><?php _e('BuddyPress activity', 'super-socializer') ?></label>
								<br/>
								<input id="the_champ_counter_bp_group" name="the_champ_counter[bp_group]" type="checkbox" <?php echo isset($theChampCounterOptions['bp_group']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_bp_group"><?php _e('BuddyPress group (only at top of content)', 'super-socializer') ?></label>
								<?php
							}
							if(function_exists('is_bbpress')){
								?>
								<br/>
								<input id="the_champ_counter_bb_forum" name="the_champ_counter[bb_forum]" type="checkbox" <?php echo isset($theChampCounterOptions['bb_forum']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_bb_forum"><?php _e('BBPress forum', 'super-socializer') ?></label>
								<br/>
								<input id="the_champ_counter_bb_topic" name="the_champ_counter[bb_topic]" type="checkbox" <?php echo isset($theChampCounterOptions['bb_topic']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_bb_topic"><?php _e('BBPress topic', 'super-socializer') ?></label>
								<br/>
								<input id="the_champ_counter_bb_reply" name="the_champ_counter[bb_reply]" type="checkbox" <?php echo isset($theChampCounterOptions['bb_reply']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_bb_reply"><?php _e('BBPress reply', 'super-socializer') ?></label>
								<?php
							}
							if(heateor_ss_is_plugin_active('woocommerce/woocommerce.php')){
								?>
								<br/>
								<input id="the_champ_counter_woocom_shop" name="the_champ_counter[woocom_shop]" type="checkbox" <?php echo isset($theChampCounterOptions['woocom_shop']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_woocom_shop"><?php _e('After individual product at WooCommerce Shop page', 'super-socializer') ?></label>
								<br/>
								<input id="the_champ_counter_woocom_product" name="the_champ_counter[woocom_product]" type="checkbox" <?php echo isset($theChampCounterOptions['woocom_product']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_woocom_product"><?php _e('WooCommerce Product Page', 'super-socializer') ?></label>
								<br/>
								<input id="the_champ_counter_woocom_thankyou" name="the_champ_counter[woocom_thankyou]" type="checkbox" <?php echo isset($theChampCounterOptions['woocom_thankyou']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_woocom_thankyou"><?php _e('WooCommerce Thankyou Page', 'super-socializer') ?></label>
								<br/>
								<?php
							}
							?>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_location_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify the pages where you want to enable interface', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
				</div>

				</div>
				<?php include 'help.php'; ?>
			</div>
			
			<div class="menu_containt_div" id="tabs-2">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				
				<div class="stuffbox">
					<h3><label><?php _e('Vertical (Floating) like buttons Options', 'super-socializer');?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_sc_vertical_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_vertical_enable"><?php _e("Enable floating like buttons", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_vertical_enable" onclick="theChampVerticalCounterOptionsToggle(this)" name="the_champ_counter[vertical_enable]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_enable']) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_vertical_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Master control to enable vertical (floating) counter widget', 'super-socializer') ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_vertical_counter.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_vertical_counter_options" <?php echo isset($theChampCounterOptions['vertical_enable']) ? '' : 'style="display: none"'; ?>>
						<tr>
							<th>
							<img id="the_champ_sc_vertical_target_url_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_vertical_target_url"><?php _e("Target Url", 'super-socializer'); ?></label>
							</th>
							<td id="the_champ_vertical_target_url_column">
							<input id="the_champ_vertical_target_url_default" name="the_champ_counter[vertical_target_url]" type="radio" <?php echo !isset($theChampCounterOptions['vertical_target_url']) || $theChampCounterOptions['vertical_target_url'] == 'default' ? 'checked = "checked"' : '';?> value="default" />
							<label for="the_champ_vertical_target_url_default"><?php _e('Url of the webpage where icons are located (default)', 'super-socializer') ?></label><br/>
							<input id="the_champ_vertical_target_url_home" name="the_champ_counter[vertical_target_url]" type="radio" <?php echo isset($theChampCounterOptions['vertical_target_url']) && $theChampCounterOptions['vertical_target_url'] == 'home' ? 'checked = "checked"' : '';?> value="home" />
							<label for="the_champ_vertical_target_url_home"><?php _e('Url of the homepage of your website', 'super-socializer') ?></label><br/>
							<input id="the_champ_vertical_target_url_custom" name="the_champ_counter[vertical_target_url]" type="radio" <?php echo isset($theChampCounterOptions['vertical_target_url']) && $theChampCounterOptions['vertical_target_url'] == 'custom' ? 'checked = "checked"' : '';?> value="custom" />
							<label for="the_champ_vertical_target_url_custom"><?php _e('Custom url', 'super-socializer') ?></label><br/>
							<input id="the_champ_vertical_target_url_custom_url" name="the_champ_counter[vertical_target_url_custom]" type="text" value="<?php echo isset($theChampCounterOptions['vertical_target_url_custom']) ? $theChampCounterOptions['vertical_target_url_custom'] : '' ?>" />
							</td>
						</tr>
						<tr class="the_champ_help_content" id="the_champ_sc_vertical_target_url_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Url to like/share/tweet and display like/share/tweet counts', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_vertical_providers_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Select and rearrange providers", 'super-socializer'); ?></label>
							</th>
							<td>
							<ul id="the_champ_sc_vertical_rearrange">
							<?php
							// show selected providers
							if(isset($theChampCounterOptions['vertical_providers']) && is_array($theChampCounterOptions['vertical_providers'])){
								foreach($theChampCounterOptions['vertical_providers'] as $selected){
									$labelParts = explode('_', $selected);
									$labelParts = array_map('the_champ_first_letter_uppercase', $labelParts);
									$label = implode(' ', $labelParts);
									?>
									<li>
									<input id="the_champ_vertical_counter_<?php echo $selected ?>" name="the_champ_counter[vertical_providers][]" type="checkbox" checked = "checked" value="<?php echo $selected ?>" />
									<label for="the_champ_vertical_counter_<?php echo $selected ?>"><?php _e($label, 'super-socializer'); ?></label>
									</li>
									<?php
								}
							}else{
								$theChampCounterOptions['vertical_providers'] = array();
							}
							$remaining = array_diff($counterProviders, $theChampCounterOptions['vertical_providers']);
							if(is_array($remaining)){
								foreach($remaining as $provider){
									$labelParts = explode('_', $provider);
									$labelParts = array_map('the_champ_first_letter_uppercase', $labelParts);
									$label = implode(' ', $labelParts);
									?>
									<li>
									<input id="the_champ_vertical_counter_<?php echo $provider ?>" name="the_champ_counter[vertical_providers][]" type="checkbox" value="<?php echo $provider ?>" />
									<label for="the_champ_vertical_counter_<?php echo $provider ?>"><?php _e($label, 'super-socializer'); ?></label>
									</li>
									<?php
								}
							}
							?>
							</ul>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_vertical_providers_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Select the providers for interface. Drag them to rearrange.', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_vertical_bg_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_vertical_bg_color"><?php _e("Background Color", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_vertical_bg_color" style="width: 100px" name="the_champ_counter[vertical_bg]" type="text" value="<?php echo isset($theChampCounterOptions['vertical_bg']) ? $theChampCounterOptions['vertical_bg'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_vertical_bg_color_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify the color or hex code (example #cc78e0) for the background of vertical interface. Leave empty for transparent. You can get the hex code of the required color from <a href="http://www.colorpicker.com/" target="_blank">this link</a>', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_alignment_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_alignment"><?php _e("Horizontal alignment", 'super-socializer'); ?></label>
							</th>
							<td>
							<select onchange="theChampToggleOffset(this.value)" id="the_champ_sc_alignment" name="the_champ_counter[alignment]">
								<option value="left" <?php echo isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] == 'left' ? 'selected="selected"' : '' ?>><?php _e('Left', 'super-socializer') ?></option>
								<option value="right" <?php echo isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] == 'right' ? 'selected="selected"' : '' ?>><?php _e('Right', 'super-socializer') ?></option>
							</select>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_alignment_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Horizontal alignment of the interface', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_sc_left_offset_rows" <?php echo (isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] == 'left') ? '' : 'style="display: none"' ?>>
						<tr>
							<th>
							<img id="the_champ_sc_left_offset_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_left_offset"><?php _e("Left offset", 'super-socializer'); ?></label>
							</th>
							<td>
							<input style="width: 100px" id="the_champ_sc_left_offset" name="the_champ_counter[left_offset]" type="text" value="<?php echo isset($theChampCounterOptions['left_offset']) ? $theChampCounterOptions['left_offset'] : '' ?>" />px
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_left_offset_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify a number. Increase in number will shift interface towards right and decrease will shift it towards left. Number can be negative too.', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						</tbody>
						
						<tbody id="the_champ_sc_right_offset_rows" <?php echo (isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] == 'right') ? '' : 'style="display: none"' ?>>
						<tr>
							<th>
							<img id="the_champ_sc_right_offset_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_right_offset"><?php _e("Right offset", 'super-socializer'); ?></label>
							</th>
							<td>
							<input style="width: 100px" id="the_champ_sc_right_offset" name="the_champ_counter[right_offset]" type="text" value="<?php echo isset($theChampCounterOptions['right_offset']) ? $theChampCounterOptions['right_offset'] : '' ?>" />px
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_right_offset_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify a number. Increase in number will shift interface towards left and decrease will shift it towards right. Number can be negative too.', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						</tbody>
						
						<tr>
							<th>
							<img id="the_champ_sc_top_offset_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_top_offset"><?php _e("Top offset", 'super-socializer'); ?></label>
							</th>
							<td>
							<input style="width: 100px" id="the_champ_sc_top_offset" name="the_champ_counter[top_offset]" type="text" value="<?php echo isset($theChampCounterOptions['top_offset']) ? $theChampCounterOptions['top_offset'] : '' ?>" />px
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_top_offset_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify a number. Increase in number will shift interface towards bottom and decrease will shift it towards top.', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_vertical_location_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Interface location", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_counter_vertical_home" name="the_champ_counter[vertical_home]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_home']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_vertical_home"><?php _e('Homepage', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_vertical_post" name="the_champ_counter[vertical_post]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_post']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_vertical_post"><?php _e('Posts', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_vertical_page" name="the_champ_counter[vertical_page]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_page']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_vertical_page"><?php _e('Pages', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_vertical_excerpt" name="the_champ_counter[vertical_excerpt]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_excerpt']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_vertical_excerpt"><?php _e('Excerpts and Posts page', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_vertical_category" name="the_champ_counter[vertical_category]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_category']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_vertical_category"><?php _e('Category Archives', 'super-socializer') ?></label><br/>
							<input id="the_champ_counter_vertical_archive" name="the_champ_counter[vertical_archive]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_archive']) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_counter_vertical_archive"><?php _e('Archive Pages (Category, Tag, Author or Date based pages)', 'super-socializer') ?></label><br/>
							<?php
							if( count( $post_types ) ) {
								foreach ( $post_types as $post_type ) {
									?>
									<input id="the_champ_counter_vertical_<?php echo $post_type ?>" name="the_champ_counter[vertical_<?php echo $post_type ?>]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_' . $post_type]) ? 'checked = "checked"' : '';?> value="1" />
									<label for="the_champ_counter_vertical_<?php echo $post_type ?>"><?php echo ucfirst( $post_type ) . 's'; ?></label><br/>
									<?php
								}
							}
							if($theChampIsBpActive){
								?>
								<br/>
								<input id="the_champ_counter_vertical_bp_group" name="the_champ_counter[vertical_bp_group]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_bp_group']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_vertical_bp_group"><?php _e('BuddyPress group', 'super-socializer') ?></label>
								<?php
							}
							if(function_exists('is_bbpress')){
								?>
								<br/>
								<input id="the_champ_counter_vertical_bb_forum" name="the_champ_counter[vertical_bb_forum]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_bb_forum']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_vertical_bb_forum"><?php _e('BBPress forum', 'super-socializer') ?></label>
								<br/>
								<input id="the_champ_counter_vertical_bb_topic" name="the_champ_counter[vertical_bb_topic]" type="checkbox" <?php echo isset($theChampCounterOptions['vertical_bb_topic']) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_counter_vertical_bb_topic"><?php _e('BBPress topic', 'super-socializer') ?></label>
								<?php
							}
							?>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_vertical_location_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify the pages where you want to enable vertical interface', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_ss_mobile_likeb_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_ss_mobile_likeb"><?php _e("Hide like buttons on mobile devices", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_ss_mobile_likeb" name="the_champ_counter[hide_mobile_likeb]" type="checkbox" <?php echo isset($theChampCounterOptions['hide_mobile_likeb']) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_ss_mobile_likeb_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, vertical like buttons will not appear on mobile devices', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
				</div>
				
				</div>

				<?php include 'help.php'; ?>
			</div>

			<div class="menu_containt_div" id="tabs-3">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				
				<div class="stuffbox">
					<h3><label><?php _e('Url shortener', 'super-socializer');?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_surl_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_surl_enable"><?php _e("Use shortlinks already installed, for tweet button", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_surl_enable" name="the_champ_counter[use_shortlinks]" type="checkbox" <?php echo isset($theChampCounterOptions['use_shortlinks']) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_surl_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Allows for shortened URLs to be used when sharing content if a shortening plugin is installed', 'super-socializer') ?>
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_sc_bitly_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_bitly_enable"><?php _e("Enable bit.ly url shortener for tweet button", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_bitly_enable" name="the_champ_counter[bitly_enable]" type="checkbox" <?php echo isset($theChampCounterOptions['bitly_enable']) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_bitly_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Master control to enable bit.ly url shortening for sharing', 'super-socializer') ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_bitly_login_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_bitly_login"><?php _e("bit.ly username", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_bitly_login" name="the_champ_counter[bitly_username]" type="text" value="<?php echo isset($theChampCounterOptions['bitly_username']) ? $theChampCounterOptions['bitly_username'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_bitly_login_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('Login to your bit.ly account and navigate to <a href="%s" target="_blank">this link</a> to get bit.ly username', 'super-socializer'), 'https://bitly.com/a/your_api_key') ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_bitly_username.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_sc_bitly_key_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_bitly_key"><?php _e("bit.ly API Key", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_bitly_key" name="the_champ_counter[bitly_key]" type="text" value="<?php echo isset($theChampCounterOptions['bitly_key']) ? $theChampCounterOptions['bitly_key'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_bitly_key_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('Login to your bit.ly account and navigate to <a href="%s" target="_blank">this link</a> to get your API key', 'super-socializer'), 'https://bitly.com/a/your_api_key') ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_bitly_apikey.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_clear_shorturl_cache_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<input type="button" class="button-primary" value="<?php _e('Clear Bitly Cache', 'super-socializer') ?>" onclick="theChampClearShorturlCache()" />
							</th>
							<td>
							<img src="<?php echo plugins_url('../images/ajax_loader.gif', __FILE__) ?>" id="shorturl_cache_loading" style="display:none" />
							<div id="the_champ_cache_clear_message" style="color:green;display:none;"><?php _e('ShortUrl cache cleared successfully.', 'super-socializer' ); ?></div>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_clear_shorturl_cache_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Use this to delete short urls saved in database. Handy, if urls of your website have been changed but short urls are still being generated for old urls.', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
					</table>
					</div>
				</div>
				
				<div class="stuffbox">
					<h3><label><?php _e('Language', 'super-socializer');?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_sc_language_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_language"><?php _e("Language", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_language" name="the_champ_counter[language]" type="text" value="<?php echo isset($theChampCounterOptions['language']) ? $theChampCounterOptions['language'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_language_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('Enter the code of the language you want to use to render counters. You can find the language codes at <a href="%s" target="_blank">this link</a>. Leave it empty for default language(English)', 'super-socializer'), 'https://fbdevwiki.com/wiki/Locales#Complete_List_.28as_of_2012-06-10.29') ?>
							</div>
							</td>
						</tr>
					</table>
					</div>
				</div>
						
				<div class="stuffbox">
					<h3><label><?php _e('Twitter Username', 'super-socializer');?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_sc_twitter_username_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_twitter_username"><?php _e("Twitter username for Tweet (without @)", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_twitter_username" name="the_champ_counter[twitter_username]" type="text" value="<?php echo isset($theChampCounterOptions['twitter_username']) ? $theChampCounterOptions['twitter_username'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_twitter_username_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Provided username will be appended after the content being tweeted as "via @USERNAME". Leave empty if you do not want any username.', 'super-socializer') ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_twitter_username.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_sc_buffer_username_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_buffer_username"><?php _e("Twitter username for Buffer sharing (without @)", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_buffer_username" name="the_champ_counter[buffer_username]" type="text" value="<?php echo isset($theChampCounterOptions['buffer_username']) ? $theChampCounterOptions['buffer_username'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_buffer_username_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Provided username will be appended after the content in Buffer sharing as "via @USERNAME". Leave empty if you do not want any username.', 'super-socializer') ?>
							</div>
							</td>
						</tr>
					</table>
					</div>
				</div>
				
				</div>
				<?php include 'help.php'; ?>
			</div>
			
			<?php
			if(heateor_ss_is_plugin_active('mycred/mycred.php')){
				?>
				<div class="menu_containt_div" id="tabs-4">
					<div class="clear"></div>
					<div class="the_champ_left_column">
					<div class="stuffbox">
						<h3><label><?php _e('myCRED', 'super-socializer' );?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
							<tr>
								<th>
								<img id="the_champ_mycred_referral_id_like_button_help" class="the_champ_help_bubble" src="<?php echo plugins_url( '../images/info.png', __FILE__ ) ?>" />
								<label for="the_champ_mycred_referral_id_like_button"><?php _e("Append myCRED referral ID to the urls being shared", 'super-socializer'); ?></label>
								</th>
								<td>
								<input id="the_champ_mycred_referral_id_like_button" name="the_champ_counter[mycred_referral]" type="checkbox" <?php echo isset( $theChampCounterOptions['mycred_referral'] ) ? 'checked = "checked"' : '';?> value="1" />
								</td>
							</tr>
						</table>
						</div>
					</div>
					</div>
					<?php include 'help.php'; ?>
				</div>
				<?php
			}
			?>

			<div class="menu_containt_div" id="tabs-5">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				<div class="stuffbox">
					<h3><label><?php _e('Shortcode & Widget', 'super-socializer');?></label></h3>
					<div class="inside">
						<p><a style="text-decoration:none" href="http://support.heateor.com/like-buttons-shortcode-and-widget/" target="_blank"><?php _e('Like Buttons Shortcode & Widget', 'super-socializer') ?></a></p>
					</div>
				</div>
				</div>
				<?php include 'help.php'; ?>
			</div>

			<div class="menu_containt_div" id="tabs-6">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				<div class="stuffbox">
					<h3><label><?php _e('FAQ', 'super-socializer' ) ?></label></h3>
					<div class="inside faq">
						<p><a href="http://support.heateor.com/why-is-there-so-much-space-between-like-buttons" target="_blank"><?php _e( 'Why is there so much space between like buttons?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/why-is-floating-share-like-button-not-appearing-at-homepage" target="_blank"><?php _e( 'Why are floating sharing/like buttons not appearing at homepage?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/place-title-social-share-icons-row/" target="_blank"><?php _e('How to Place Title and Social Share Icons in the Same Row?', 'super-socializer' ) ?></a></p>
					</div>
				</div>

				</div>
				<?php include 'help.php'; ?>
			</div>

		</div>

		<div class="the_champ_clear"></div>
		<p class="submit">
			<input style="margin-left:8px" type="submit" name="save" class="button button-primary" value="<?php _e("Save Changes", 'super-socializer'); ?>" />
		</p>
		</form>
		<div class="clear"></div>
		<div class="stuffbox">
			<h3><label><?php _e("Instagram Shoutout", 'super-socializer' ); ?></label></h3>
			<div class="inside">
			<p><?php _e( 'If you can send (to hello@heateor.com) how our plugin is helping your business, we can share it on Instagram. You can also send any relevant hashtags and people to mention in the Instagram post.', 'super-socializer' ) ?></p>
			<p><?php _e( '<b>Example</b> - Blah-Blah Online Coaching teaches various programming language courses through their website. They have emerged as one of the most popular online coaching websites in the past year. Anyone can become proficient in programming language of their choice in a very easy way in no time.', 'super-socializer' ) ?></p>
			<p><?php _e( '@blahblahonlinecoaching proudly use #SuperSocializer to enable social features at their website, such as - Social Login, Social Share and Social Commenting. Be sure to visit their website at blahblahonlinecoaching.com where you can browse a variety of programming language courses.', 'super-socializer' ) ?></p>
			</div>
		</div>
</div>