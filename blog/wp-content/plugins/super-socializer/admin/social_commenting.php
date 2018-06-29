<?php defined('ABSPATH') or die("Cheating........Uh!!"); ?>
<div id="fb-root"></div>

<div class="metabox-holder columns-2" id="post-body">
	<form action="options.php" method="post">
		<?php settings_fields('the_champ_facebook_options'); ?>
		<div class="stuffbox" style="width:98.7%">
			<h3><label><?php _e('Master Control', 'super-socializer' );?></label></h3>
			<div class="inside">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr>
						<th>
							<label for="the_champ_enable_commenting"><?php _e( 'Enable Social Commenting', 'super-socializer' ) ?></label>
						</th>
						<td>
							<input type="checkbox" id="the_champ_enable_commenting" name="the_champ_facebook[enable_commenting]" <?php echo isset($theChampFacebookOptions['enable_commenting']) ? 'checked="checked"' : '' ?> value="1" />
						</td>
					</tr>

					<tr class="the_champ_help_content" id="the_champ_enable_commenting_help_cont">
						<td colspan="2">
						<div>
						<?php _e('Master control to enable Social Commenting', 'super-socializer') ?>
						</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="menu_div" id="tabs" <?php echo isset($theChampFacebookOptions['enable_commenting']) ? '' : 'style="display:none"' ?>>
					<h2 class="nav-tab-wrapper" style="height:34px">
					<ul>
						<li><a style="margin:0; height: 23px" class="nav-tab" href="#tabs-1"><?php _e('Social Commenting', 'super-socializer') ?></a></li>
						<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-2"><?php _e('Shortcode', 'super-socializer') ?></a></li>
						<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-3"><?php _e('FAQ', 'super-socializer') ?></a></li>
					</ul>
					</h2>					
					<div class="menu_containt_div" id="tabs-1">
						<div class="clear"></div>
						<div class="the_champ_left_column">
						<div class="stuffbox">
							<h3><label><?php _e('General Options', 'super-socializer');?></label></h3>
							<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<th>
									<img id="the_champ_commenting_tab_order_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_commenting_tab_order"><?php _e("Order of tabs in commenting interface", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_commenting_tab_order" name="the_champ_facebook[commenting_order]" type="text" value="<?php echo isset($theChampFacebookOptions['commenting_order']) ? $theChampFacebookOptions['commenting_order'] : '';?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_commenting_tab_order_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Order of the tabs shown in social commenting interface. Defaults to wordpress,facebook,googleplus,disqus', 'super-socializer') ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_commenting_title_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_commenting_title"><?php _e("Comment area label", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_commenting_title" name="the_champ_facebook[commenting_label]" type="text" value="<?php echo isset($theChampFacebookOptions['commenting_label']) ? $theChampFacebookOptions['commenting_label'] : '';?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_commenting_title_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Label for comment area', 'super-socializer') ?>
									<img width="550" src="<?php echo plugins_url('../images/snaps/sc_commenting_label.png', __FILE__); ?>" />
									</div>
									</td>
								</tr>

								<?php
								$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
								if ( count( $post_types ) > 0 ) {
									?>
									<tr>
										<th>
										<img id="the_champ_comments_location_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Enable Social Commenting at", 'super-socializer'); ?></label>
										</th>
										<td>
										<?php
										foreach ( $post_types as $post_type ) {
											if ( post_type_supports( $post_type, 'comments' ) ) {
												?>
												<input id="the_champ_comments_<?php echo $post_type ?>" name="the_champ_facebook[enable_<?php echo $post_type ?>]" type="checkbox" <?php echo isset($theChampFacebookOptions['enable_' . $post_type]) ? 'checked = "checked"' : '';?> value="1" />
												<label for="the_champ_comments_<?php echo $post_type ?>"><?php echo ucfirst( $post_type ) . '(s)'; ?></label><br/>
												<?php
											}
										}
										?>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_comments_location_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Specify the page/post groups where you want to enable Social Commenting', 'super-socializer') ?>
										</div>
										</td>
									</tr>
									<?php
								}
								?>

								<tr>
									<th>
									<img id="the_champ_commenting_id_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label><?php _e("HTML ID of comment form container", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_commenting_id" name="the_champ_facebook[commenting_id]" type="text" value="<?php echo isset($theChampFacebookOptions['commenting_id']) ? $theChampFacebookOptions['commenting_id'] : '';?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_commenting_id_help_cont">
									<td colspan="2">
									<div>
									<?php _e('HTML ID of container element of the default comment form at front end. Leave empty for default ID - "respond". You need to specify it if default comment form is appearing and Social Commenting is not getting enabled at front-end of your website.', 'super-socializer') ?>
									</div>
									</td>
								</tr>

							</table>
							</div>
						</div>

						<div class="stuffbox">
							<h3><label><?php _e('Labels', 'super-socializer');?></label></h3>
							<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<th>
									<label for="the_champ_wp_comment_label"><?php _e("Label for WordPress Commenting tab", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_wp_comment_label" name="the_champ_facebook[label_wordpress_comments]" type="text" value="<?php echo isset($theChampFacebookOptions['label_wordpress_comments']) ? $theChampFacebookOptions['label_wordpress_comments'] : '';?>" />
									</td>
								</tr>

								<tr>
									<th>
									<label for="the_champ_fb_comment_label"><?php _e("Label for Facebook Commenting tab", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_fb_comment_label" name="the_champ_facebook[label_facebook_comments]" type="text" value="<?php echo isset($theChampFacebookOptions['label_facebook_comments']) ? $theChampFacebookOptions['label_facebook_comments'] : '';?>" />
									</td>
								</tr>

								<tr>
									<th>
									<label for="the_champ_gp_comment_label"><?php _e("Label for G+ Commenting tab", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_gp_comment_label" name="the_champ_facebook[label_googleplus_comments]" type="text" value="<?php echo isset($theChampFacebookOptions['label_googleplus_comments']) ? $theChampFacebookOptions['label_googleplus_comments'] : '';?>" />
									</td>
								</tr>

								<tr>
									<th>
									<label for="the_champ_dq_comment_label"><?php _e("Label for Disqus Commenting tab", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_dq_comment_label" name="the_champ_facebook[label_disqus_comments]" type="text" value="<?php echo isset($theChampFacebookOptions['label_disqus_comments']) ? $theChampFacebookOptions['label_disqus_comments'] : '';?>" />
									</td>
								</tr>
							</table>
							</div>
						</div>

						<div class="stuffbox">
							<h3><label><?php _e('Facebook Commenting Options', 'super-socializer');?></label></h3>
							<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<td colspan="2">
									<div>
									<a href="https://www.heateor.com/add-ons" target="_blank"><input type="button" value="<?php _e('Enable Facebook Comments notification and moderation', 'super-socializer') ?>" class="ss_demo" /></a>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_fb_comment_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_enable_fbcomments"><?php _e("Enable Facebook Commenting", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_enable_fbcomments" name="the_champ_facebook[enable_fbcomments]" type="checkbox" <?php echo isset($theChampFacebookOptions['enable_fbcomments']) ? 'checked = "checked"' : '';?> value="1" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Enable Facebook Commenting', 'super-socializer') ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_fb_comment_url_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_comment_url"><?php _e('Url to comment on', 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_comment_url" name="the_champ_facebook[urlToComment]" type="text" value="<?php echo isset($theChampFacebookOptions['urlToComment']) ? $theChampFacebookOptions['urlToComment'] : '' ?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_url_help_cont">
									<td colspan="2">
									<div>
									<?php _e('The absolute URL that comments posted will be permanently associated with. Stories on Facebook about comments posted, will link to this URL.<br/>If left empty <strong>(Recommended)</strong>, url of the webpage will be used at which commenting is enabled.', 'super-socializer') ?>
									</div>
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
									<div>
									<a href="https://www.heateor.com/facebook-comments-moderation" target="_blank"><input type="button" value="<?php _e('Show Recent Facebook Comments in a Widget', 'super-socializer') ?>" class="ss_demo" /></a>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_fb_comment_width_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_fbcomment_width"><?php _e('Width', 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_fbcomment_width" name="the_champ_facebook[comment_width]" type="text" value="<?php echo isset($theChampFacebookOptions['comment_width']) ? $theChampFacebookOptions['comment_width'] : '' ?>" />px
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_width_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Leave empty to auto-adjust the width. The width (in pixels) of the Comments block.', 'super-socializer') ?>
									</div>
									</td>
								</tr>
								
								<tr>
									<th>
									<img id="the_champ_fb_comment_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_fbcomment_color"><?php _e('Color Scheme', 'super-socializer'); ?></label>
									</th>
									<td>
									<select id="the_champ_fbcomment_color" name="the_champ_facebook[comment_color]">
										<option value="light" <?php echo isset($theChampFacebookOptions['comment_color']) && $theChampFacebookOptions['comment_color'] == 'light' ? 'selected="selected"' : '' ?>><?php _e('Light', 'super-socializer') ?></option>
										<option value="dark" <?php echo isset($theChampFacebookOptions['comment_color']) && $theChampFacebookOptions['comment_color'] == 'dark' ? 'selected="selected"' : '' ?>><?php _e('Dark', 'super-socializer') ?></option>
									</select>
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_color_help_cont">
									<td colspan="2">
									<div>
									<?php _e('The color scheme used by the plugin. Can be "light" or "dark".', 'super-socializer') ?>
									</div>
									</td>
								</tr>
								
								<tr>
									<th>
									<img id="the_champ_fb_comment_numposts_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_fbcomment_numposts"><?php _e('Number of comments', 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_fbcomment_numposts" name="the_champ_facebook[comment_numposts]" type="text" value="<?php echo isset($theChampFacebookOptions['comment_numposts']) ? $theChampFacebookOptions['comment_numposts'] : '' ?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_numposts_help_cont">
									<td colspan="2">
									<div>
									<?php _e('The number of comments to show by default. The minimum value is 1. Defaults to 10', 'super-socializer') ?>
									</div>
									</td>
								</tr>
								
								<tr>
									<th>
									<img id="the_champ_fb_comment_orderby_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_fbcomment_orderby"><?php _e('Order by', 'super-socializer'); ?></label>
									</th>
									<td>
									<select id="the_champ_fbcomment_orderby" name="the_champ_facebook[comment_orderby]">
										<option value="social" <?php echo isset($theChampFacebookOptions['comment_orderby']) && $theChampFacebookOptions['comment_orderby'] == 'social' ? 'selected="selected"' : '' ?>><?php _e('Social', 'super-socializer') ?></option>
										<option value="reverse_time" <?php echo isset($theChampFacebookOptions['comment_orderby']) && $theChampFacebookOptions['comment_orderby'] == 'reverse_time' ? 'selected="selected"' : '' ?>><?php _e('Reverse Time', 'super-socializer') ?></option>
										<option value="time" <?php echo isset($theChampFacebookOptions['comment_orderby']) && $theChampFacebookOptions['comment_orderby'] == 'time' ? 'selected="selected"' : '' ?>><?php _e('Time', 'super-socializer') ?></option>
									</select>
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_orderby_help_cont">
									<td colspan="2">
									<div>
									<?php _e('The order to use when displaying comments.', 'super-socializer') ?>
									</div>
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
									<div>
									<a href="https://www.heateor.com/facebook-comments-moderation" target="_blank"><input type="button" value="<?php _e('Recover Facebook Comments Lost After Moving to SSL/Https', 'super-socializer') ?>" class="ss_demo" /></a>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_fb_comment_lang_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_fbcomment_lang"><?php _e('Language', 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_fbcomment_lang" name="the_champ_facebook[comment_lang]" type="text" value="<?php echo isset($theChampFacebookOptions['comment_lang']) ? $theChampFacebookOptions['comment_lang'] : '' ?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_fb_comment_lang_help_cont">
									<td colspan="2">
									<div>
									<?php echo sprintf(__('Enter the code of the language you want to use to display commenting. You can find the language codes at <a href="%s" target="_blank">this link</a>. Leave it empty for default language(English)', 'super-socializer'), 'https://fbdevwiki.com/wiki/Locales#Complete_List_.28as_of_2012-06-10.29') ?>
									</div>
									</td>
								</tr>
							</table>
							</div>
						</div>
						
						<div class="stuffbox">
							<h3><label><?php _e('Google Plus Commenting Options', 'super-socializer');?></label></h3>
							<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<th>
									<img id="the_champ_enable_gpcomments_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_enable_gpcomments"><?php _e("Enable Google Plus Commenting", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_enable_gpcomments" name="the_champ_facebook[enable_googlepluscomments]" type="checkbox" <?php echo isset($theChampFacebookOptions['enable_googlepluscomments']) ? 'checked = "checked"' : '';?> value="1" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_enable_gpcomments_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Enable Google Plus Commenting', 'super-socializer') ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_gpcomments_width_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_gpcomments_width"><?php _e("Width", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_gpcomments_width" name="the_champ_facebook[gpcomments_width]" type="text" value="<?php echo isset($theChampFacebookOptions['gpcomments_width']) ? $theChampFacebookOptions['gpcomments_width'] : ''; ?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_gpcomments_width_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Width of GooglePlus Commenting interface. Leave empty for auto adjust', 'super-socializer') ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_gpcomments_url_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_gpcomments_url"><?php _e("Url to comment on", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_gpcomments_url" name="the_champ_facebook[gpcomments_url]" type="text" value="<?php echo isset($theChampFacebookOptions['gpcomments_url']) ? $theChampFacebookOptions['gpcomments_url'] : ''; ?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_gpcomments_url_help_cont">
									<td colspan="2">
									<div>
									<?php _e('The absolute URL that comments posted will be permanently associated with. Stories on Google Plus about comments posted, will link to this URL.<br/>If left empty <strong>(Recommended)</strong>, url of the webpage will be used at which commenting is enabled.', 'super-socializer') ?>
									</div>
									</td>
								</tr>
							</table>
							</div>
						</div>

						<div class="stuffbox">
							<h3><label><?php _e('Disqus Commenting Options', 'super-socializer');?></label></h3>
							<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<th>
									<img id="the_champ_enable_dqcomments_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_enable_dqcomments"><?php _e("Enable Disqus Commenting", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_enable_dqcomments" name="the_champ_facebook[enable_disquscomments]" type="checkbox" <?php echo isset($theChampFacebookOptions['enable_disquscomments']) ? 'checked = "checked"' : '';?> value="1" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_enable_dqcomments_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Enable Disqus Commenting', 'super-socializer') ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
									<img id="the_champ_commenting_dq_shortname_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
									<label for="the_champ_commenting_dq_shortname"><?php _e("Disqus Shortname", 'super-socializer'); ?></label>
									</th>
									<td>
									<input id="the_champ_commenting_dq_shortname" name="the_champ_facebook[dq_shortname]" type="text" value="<?php echo isset($theChampFacebookOptions['dq_shortname']) ? $theChampFacebookOptions['dq_shortname'] : ''; ?>" />
									</td>
								</tr>
								
								<tr class="the_champ_help_content" id="the_champ_commenting_dq_shortname_help_cont">
									<td colspan="2">
									<div>
									<?php _e('<strong>Required to use Disqus commenting.</strong> For more info on shortname, visit following link.', 'super-socializer') ?> <a href="https://help.disqus.com/customer/portal/articles/466208" target="_blank">https://help.disqus.com/customer/portal/articles/466208</a>
									</div>
									</td>
								</tr>
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
							<h3><label><?php _e('Shortcode', 'super-socializer');?></label></h3>
							<div class="inside">
								<p><a style="text-decoration:none" href="http://support.heateor.com/social-commenting-shortcode/" target="_blank"><?php _e('Social Commenting Shortcode', 'super-socializer') ?></a></p>
							</div>
						</div>
						</div>
						<?php include 'help.php'; ?>
					</div>
					
					<div class="menu_containt_div" id="tabs-3">
						<div class="clear"></div>
						<div class="the_champ_left_column">
						<div class="stuffbox">
							<h3><label><?php _e('FAQ', 'super-socializer') ?></label></h3>
							<div class="inside">
								<p><?php _e('<strong>Note:</strong> Plugin will not work on local server. You should have an online website for the plugin to function properly.', 'super-socializer'); ?></p>
								<p><a style="text-decoration:none" href="https://www.heateor.com/facebook-comments-moderation" target="_blank"><?php _e('How to show recent Facebook Comments from all over the website in a widget?', 'super-socializer' ) ?></a></p>
								<p><a style="text-decoration:none" href="http://support.heateor.com/recover-facebook-comments-wordpress-moving-to-https-ssl/" target="_blank"><?php _e('How to recover the Facebook Comments lost after moving my website to SSL/Https?', 'super-socializer' ) ?></a></p>
								<p><a style="text-decoration:none" href="http://support.heateor.com/browser-blocking-social-features/" target="_blank"><?php _e('Why is my browser blocking some features of the plugin?', 'super-socializer' ) ?></a></p>
								<p><a style="text-decoration:none" href="http://support.heateor.com/how-can-i-disable-social-commenting-at-individual-pagepost/" target="_blank"><?php _e('How can I disable Social Commenting at individual page/post?', 'super-socializer') ?></a></p>
								<p><a style="text-decoration:none" href="http://support.heateor.com/how-to-disable-default-comment-form-from-social-commenting/" target="_blank"><?php _e('How to disable default comment form from Social Commenting?', 'super-socializer') ?></a></p>
							</div>
						</div>
						</div>
						<?php include 'help.php'; ?>
					</div>
		</div>
		<div class="the_champ_clear"></div>
		<p class="submit">
			<input id="the_champ_enable_fblike" style="margin-left:8px" type="submit" name="save" class="button button-primary" value="<?php _e("Save Changes", 'super-socializer'); ?>" />
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