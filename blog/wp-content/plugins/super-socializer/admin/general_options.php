<?php
defined('ABSPATH') or die("Cheating........Uh!!");
?>
<div id="fb-root"></div>

<div class="metabox-holder columns-2" id="post-body">
	<form action="options.php" method="post">
		<?php settings_fields('the_champ_general_options'); ?>
		<div class="the_champ_left_column">
			<div class="stuffbox">
				<h3><label><?php _e('General Options', 'super-socializer');?></label></h3>
				<div class="inside">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr>
						<th>
						<img id="the_champ_footer_script_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_footer_script"><?php _e("Include Javascript in website footer", 'super-socializer'); ?></label>
						</th>
						<td>
						<input id="the_champ_footer_script" name="the_champ_general[footer_script]" type="checkbox" <?php echo isset($theChampGeneralOptions['footer_script']) ? 'checked = "checked"' : '';?> value="1" />
						</td>
					</tr>
					
					<tr class="the_champ_help_content" id="the_champ_footer_script_help_cont">
						<td colspan="2">
						<div>
						<?php _e('If enabled (recommended), Javascript files will be included in the footer of your website.', 'super-socializer') ?>
						</div>
						</td>
					</tr>

					<tr>
						<th>
						<img id="the_champ_combined_script_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_combined_script"><?php _e("Load all Javascript files in single file", 'super-socializer'); ?></label>
						</th>
						<td>
						<input id="the_champ_combined_script" name="the_champ_general[combined_script]" type="checkbox" <?php echo isset($theChampGeneralOptions['combined_script']) ? 'checked = "checked"' : '';?> value="1" />
						</td>
					</tr>
					
					<tr class="the_champ_help_content" id="the_champ_combined_script_help_cont">
						<td colspan="2">
						<div>
						<?php _e('Loads Javascript in single request.', 'super-socializer') ?>
						</div>
						</td>
					</tr>

					<tr>
						<th>
						<img id="the_champ_delete_options_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_delete_options"><?php _e("Delete all the options on plugin deletion", 'super-socializer'); ?></label>
						</th>
						<td>
						<input id="the_champ_delete_options" name="the_champ_general[delete_options]" type="checkbox" <?php echo isset($theChampGeneralOptions['delete_options']) ? 'checked = "checked"' : '';?> value="1" />
						</td>
					</tr>
					
					<tr class="the_champ_help_content" id="the_champ_delete_options_help_cont">
						<td colspan="2">
						<div>
						<?php _e('If enabled, plugin options will get deleted when plugin is deleted/uninstalled and you will need to reconfigure the options when you install the plugin next time.', 'super-socializer') ?>
						</div>
						</td>
					</tr>

					<tr>
						<th>
						<img id="the_champ_browser_msg_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_browser_msg_enable"><?php _e("Show popup notification to users if their browsers block the plugin features", 'super-socializer'); ?></label>
						</th>
						<td>
						<input id="the_champ_browser_msg_enable" name="the_champ_general[browser_msg_enable]" onclick="if(this.checked){jQuery('#the_champ_browser_msg_options').css('display', 'table-row-group')}else{ jQuery('#the_champ_browser_msg_options').css('display', 'none') }" type="checkbox" <?php echo isset($theChampGeneralOptions['browser_msg_enable']) ? 'checked = "checked"' : '';?> value="1" />
						</td>
					</tr>
					
					<tr class="the_champ_help_content" id="the_champ_browser_msg_enable_help_cont">
						<td colspan="2">
						<div>
						<?php _e('If enabled, your website visitors will see a popup notification (only once) if their browsers block any of the features of the plugin so that they can change their browser settings to unblock these.', 'super-socializer') ?>
						<img src="<?php echo plugins_url('../images/snaps/general_browser_notification.png', __FILE__); ?>" width="760" />
						</div>
						</td>
					</tr>

					<tbody id="the_champ_browser_msg_options" <?php echo !isset($theChampGeneralOptions['browser_msg_enable']) ? 'style = "display: none"' : '';?> >
					<tr>
						<th>
						<img id="the_champ_browser_msg_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_browser_msg"><?php _e("Message to show in popup notification", 'super-socializer'); ?></label>
						</th>
						<td>
						<textarea rows="7" cols="63" id="the_champ_browser_msg" name="the_champ_general[browser_msg]"><?php echo isset( $theChampGeneralOptions['browser_msg'] ) ? $theChampGeneralOptions['browser_msg'] : '' ?></textarea>
						</td>
					</tr>

					<tr class="the_champ_help_content" id="the_champ_browser_msg_help_cont">
						<td colspan="2">
						<div>
						<?php _e('Use {support_url} placeholder to show support documentation url in message', 'super-socializer') ?>
						</div>
						</td>
					</tr>
					</tbody>

					<tr>
						<th>
						<img id="the_champ_custom_css_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label for="the_champ_custom_css"><?php _e("Custom CSS", 'super-socializer' ); ?></label>
						</th>
						<td>
						<textarea rows="7" cols="63" id="the_champ_custom_css" name="the_champ_general[custom_css]"><?php echo isset( $theChampGeneralOptions['custom_css'] ) ? $theChampGeneralOptions['custom_css'] : '' ?></textarea>
						</td>
					</tr>
					
					<tr class="the_champ_help_content" id="the_champ_custom_css_help_cont">
						<td colspan="2">
						<div>
						<?php _e('You can specify any additional CSS rules (without &lt;style&gt; tag)', 'super-socializer' ) ?>
						</div>
						</td>
					</tr>	
				</table>
				
				<div class="the_champ_clear"></div>
				<p class="submit">
					<input id="the_champ_enable_fblike" style="margin-left:8px" type="submit" name="save" class="button button-primary" value="<?php _e("Save Changes", 'super-socializer'); ?>" />
				</p>

				</div>
			</div>

			</div>
			<?php include 'help.php'; ?>
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