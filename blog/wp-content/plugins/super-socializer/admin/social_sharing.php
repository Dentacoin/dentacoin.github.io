<?php defined('ABSPATH') or die("Cheating........Uh!!"); ?>
<div id="fb-root"></div>

<div class="metabox-holder columns-2" style="padding-bottom:8px" id="post-body">
	<form id="the_champ_form" action="options.php" method="post">
		<?php settings_fields( 'the_champ_sharing_options' ); ?>
		
		<div class="stuffbox" style="width:98.7%">
			<h3><label><?php _e('Master Control', 'super-socializer' );?></label></h3>
			<div class="inside">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr>
						<th>
							<label for="the_champ_enable_sharing"><?php _e( 'Enable Social Sharing', 'super-socializer' ) ?></label>
						</th>
						<td>
							<input type="checkbox" id="the_champ_enable_sharing" name="the_champ_sharing[enable]" <?php echo isset($theChampSharingOptions['enable']) ? 'checked="checked"' : '' ?> value="1" />
						</td>
					</tr>
					<tr class="the_champ_help_content" id="the_champ_enable_sharing_help_cont">
						<td colspan="2">
						<div>
						<?php _e('Master control to enable Social Sharing', 'super-socializer') ?>
						</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div style="clear:both"></div>
		<div>
		<a href="https://www.heateor.com/recover-social-share-counts" target="_blank"><input type="button" value="<?php _e('Recover Social Share Counts Lost After Moving to SSL/Https', 'super-socializer') ?>" class="ss_demo" /></a>
		</div>
		<div style="clear:both"></div>

		<div class="menu_div" id="tabs" <?php echo isset($theChampSharingOptions['enable']) ? '' : 'style="display:none"' ?>>

			<h2 class="nav-tab-wrapper" style="height:34px">
			<ul>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-1"><?php _e('Theme Selection', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-2"><?php _e('Standard Interface', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-3"><?php _e('Floating Interface', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-4"><?php _e('Miscellaneous', 'super-socializer' ) ?></a></li>
				<?php
				if(heateor_ss_is_plugin_active('mycred/mycred.php')){
					?>
					<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-5"><?php _e('3rd Party Integration', 'super-socializer' ) ?></a></li>
					<?php
				}
				?>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-6"><?php _e('Shortcode & Widget', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-7"><?php _e('Troubleshooter', 'super-socializer' ) ?></a></li>
				<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-8"><?php _e('FAQ', 'super-socializer' ) ?></a></li>
			</ul>
			</h2>
			
			<div class="menu_containt_div" id="tabs-1">
				<div class="clear"></div>
				<div class="the_champ_left_column">
					<div class="stuffbox">
						<h3><label><?php _e('Standard interface theme', 'super-socializer' );?></label></h3>
						<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<th>
										<label style="float:left"><?php _e("Icon Preview", 'super-socializer' ); ?></label>
									</th>
									<td>
										<?php
										$horizontal_bg = isset( $theChampSharingOptions['horizontal_bg_color_default'] ) ? $theChampSharingOptions['horizontal_bg_color_default'] : '';
										$border_width = isset( $theChampSharingOptions['horizontal_border_width_default'] ) ? $theChampSharingOptions['horizontal_border_width_default'] : '';
										$border_color = isset( $theChampSharingOptions['horizontal_border_color_default'] ) ? $theChampSharingOptions['horizontal_border_color_default'] : '';
										$sharing_color = isset( $theChampSharingOptions['horizontal_font_color_default'] ) ? $theChampSharingOptions['horizontal_font_color_default'] : '';
										$sharing_color_hover = isset( $theChampSharingOptions['horizontal_font_color_hover'] ) ? $theChampSharingOptions['horizontal_font_color_hover'] : '';
										$sharing_shape = isset( $theChampSharingOptions['horizontal_sharing_shape'] ) ? $theChampSharingOptions['horizontal_sharing_shape'] : 'round'; 
										$sharing_size = isset( $theChampSharingOptions['horizontal_sharing_size'] ) ? $theChampSharingOptions['horizontal_sharing_size'] : 32;
										$sharing_width = isset( $theChampSharingOptions['horizontal_sharing_width'] ) ? $theChampSharingOptions['horizontal_sharing_width'] : 32;
										$sharing_height = isset( $theChampSharingOptions['horizontal_sharing_height'] ) ? $theChampSharingOptions['horizontal_sharing_height'] : 32;
										$sharing_border_radius = isset( $theChampSharingOptions['horizontal_border_radius'] ) ? $theChampSharingOptions['horizontal_border_radius'] : '';
										$horizontal_bg_hover = isset( $theChampSharingOptions['horizontal_bg_color_hover'] ) ? $theChampSharingOptions['horizontal_bg_color_hover'] : '';
										$counter_position = isset( $theChampSharingOptions['horizontal_counter_position'] ) ? $theChampSharingOptions['horizontal_counter_position'] : '';
										$line_height = $sharing_shape == 'rectangle' ? $sharing_height : $sharing_size;
										?>
										<style type="text/css">
										#the_champ_preview{
											color:<?php echo $sharing_color ? $sharing_color : "#fff" ?>;
										}
										#the_champ_preview:hover{
											color:<?php echo $sharing_color_hover ?>;
										}
										</style>
										<div>
											<div class="theChampCounterPreviewTop" style="width:<?php echo 60 + ( isset( $theChampSharingOptions['horizontal_sharing_shape'] ) && $theChampSharingOptions['horizontal_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['horizontal_sharing_width'] : $theChampSharingOptions['horizontal_sharing_size'] ) ?>px">44</div>
											<div class="theChampCounterPreviewLeft">44</div>
											<div id="the_champ_preview" style="cursor:pointer;float:left">
												<div class="theChampCounterPreviewInnertop">44</div>
												<div class="theChampCounterPreviewInnerleft">44</div>
												<div id="horizontal_svg" style="float:left;width:100%;height:100%;background:url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%20viewBox%3D%22-4%20-4%2040%2040%22%3E%3Cpath%20d%3D%22M17.78%2027.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99%202.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123%200-5.26%201.905-5.26%205.405v3.016h-3.53v4.09h3.53V27.5h4.223z%22%20fill%3D%22<?php echo $sharing_color ? str_replace( '#', '%23', $sharing_color) : "%23fff" ?>%22%3E%3C%2Fpath%3E%3C%2Fsvg%3E') no-repeat center center; margin: auto"></div>
												<div class="theChampCounterPreviewInnerright">44</div>
												<div class="theChampCounterPreviewInnerbottom">44</div>
											</div>
											<div class="theChampCounterPreviewRight">44</div>
											<div class="theChampCounterPreviewBottom" style="width:<?php echo 60 + ( isset( $theChampSharingOptions['horizontal_sharing_shape'] ) && $theChampSharingOptions['horizontal_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['horizontal_sharing_width'] : $theChampSharingOptions['horizontal_sharing_size'] ) ?>px">44</div>
										</div>
										
										<script type="text/javascript">
										var tempHorShape = '<?php echo $sharing_shape ?>', tempHorSize = '<?php echo $sharing_size ?>', tempHorHeight = '<?php echo $sharing_height ?>', tempHorWidth = '<?php echo $sharing_width ?>', theChampSharingBgHover = '<?php echo $horizontal_bg_hover ?>', theChampSharingBg = '<?php echo $horizontal_bg ? $horizontal_bg : "#3C589A" ?>', theChampBorderWidth = '<?php echo $border_width ?>', theChampBorderColor = '<?php echo $border_color ?>', theChampSharingBorderRadius = '<?php echo $sharing_border_radius ? $sharing_border_radius . "px" : "0px" ?>';

										theChampSharingHorizontalPreview();

										jQuery('#the_champ_preview').hover(function(){
											if(theChampSharingBgHover && theChampSharingBgHover != '#3C589A'){
												jQuery(this).css('backgroundColor', theChampSharingBgHover);
											}
											if(jQuery('#the_champ_font_color_hover').val().trim()){
												jQuery(this).find('#horizontal_svg').attr('style', jQuery(this).find('#horizontal_svg').attr('style').replace(theChampSharingTempColor.replace('#', '%23'), jQuery('#the_champ_font_color_hover').val().trim().replace('#', '%23')));
												jQuery(this).css('color', jQuery('#the_champ_font_color_hover').val().trim());
											}
											jQuery(this).css('borderStyle', 'solid');
											jQuery(this).css('borderWidth', theChampBorderWidthHover ? theChampBorderWidthHover : theChampBorderWidth ? theChampBorderWidth : '0');
											jQuery(this).css('borderColor', theChampBorderColorHover ? theChampBorderColorHover : 'transparent');
										},function(){
											jQuery(this).css('backgroundColor', theChampSharingBg);
											if(jQuery('#the_champ_font_color_hover').val().trim()){
												jQuery(this).find('#horizontal_svg').attr('style', jQuery(this).find('#horizontal_svg').attr('style').replace(jQuery('#the_champ_font_color_hover').val().trim().replace('#', '%23'), theChampSharingTempColor.replace('#', '%23')));
												jQuery(this).css('color', theChampSharingTempColor);
											}
											jQuery(this).css('borderStyle', 'solid');
											jQuery(this).css('borderWidth', theChampBorderWidth ? theChampBorderWidth : theChampBorderWidthHover ? theChampBorderWidthHover : '0');
											jQuery(this).css('borderColor', theChampBorderColor ? theChampBorderColor : 'transparent');
										});
										</script>
									</td>
								</tr>

								<tr>
									<td colspan="2">
									<div id="the_champ_preview_message" style="color:green;display:none;margin-top:36px"><?php _e('Do not forget to save the configuration after making changes by clicking the save button below', 'super-socializer' ); ?></div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_icon_shape_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Shape", 'super-socializer' ); ?></label>
									</th>
									<td>
										<input id="the_champ_icon_round" onclick="tempHorShape = 'round';theChampSharingHorizontalPreview()" name="the_champ_sharing[horizontal_sharing_shape]" type="radio" <?php echo $sharing_shape == 'round' ? 'checked = "checked"' : '';?> value="round" />
										<label style="margin-right:10px" for="the_champ_icon_round"><?php _e("Round", 'super-socializer' ); ?></label>
										<input id="the_champ_icon_square" onclick="tempHorShape = 'square';theChampSharingHorizontalPreview()" name="the_champ_sharing[horizontal_sharing_shape]" type="radio" <?php echo $sharing_shape == 'square' ? 'checked = "checked"' : '';?> value="square" />
										<label style="margin-right:10px" for="the_champ_icon_square"><?php _e("Square", 'super-socializer' ); ?></label>
										<input id="the_champ_icon_rectangle" onclick="tempHorShape = 'rectangle';theChampSharingHorizontalPreview()" name="the_champ_sharing[horizontal_sharing_shape]" type="radio" <?php echo $sharing_shape == 'rectangle' ? 'checked = "checked"' : '';?> value="rectangle" />
										<label for="the_champ_icon_rectangle"><?php _e("Rectangle", 'super-socializer' ); ?></label>
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_icon_shape_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Shape of the sharing icons', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tbody id="the_champ_size_options" <?php echo ! isset( $theChampSharingOptions['horizontal_sharing_shape'] ) || $theChampSharingOptions['horizontal_sharing_shape'] != 'rectangle' ? '' : 'style="display: none"'; ?>>	
									<tr>
										<th>
											<img id="the_champ_icon_size_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Size (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_icon_size" name="the_champ_sharing[horizontal_sharing_size]" type="text" value="<?php echo $sharing_size; ?>" />
											<input id="the_champ_size_plus" type="button" value="+" onmouseup="tempHorSize = document.getElementById('the_champ_icon_size').value;theChampSharingHorizontalPreview()" />
											<input id="the_champ_size_minus" type="button" value="-" onmouseup="tempHorSize = document.getElementById('the_champ_icon_size').value;theChampSharingHorizontalPreview()" />
											<script type="text/javascript">
												theChampIncrement(document.getElementById('the_champ_size_plus'), "add", document.getElementById('the_champ_icon_size'), 300, 0.7);
												theChampIncrement(document.getElementById('the_champ_size_minus'), "subtract", document.getElementById('the_champ_icon_size'), 300, 0.7);
											</script>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_icon_size_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Size of the sharing icons', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>
								</tbody>

								<tbody id="the_champ_rectangle_options" <?php echo isset( $theChampSharingOptions['horizontal_sharing_shape'] ) && $theChampSharingOptions['horizontal_sharing_shape'] == 'rectangle' ? '' : 'style="display: none"'; ?>>
									<tr>
										<th>
											<img id="the_champ_icon_width_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Width (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_icon_width" name="the_champ_sharing[horizontal_sharing_width]" type="text" value="<?php echo $sharing_width; ?>" />
											<input id="the_champ_width_plus" type="button" value="+" onmouseup="tempHorWidth = document.getElementById('the_champ_icon_width').value;theChampSharingHorizontalPreview()" />
											<input id="the_champ_width_minus" type="button" value="-" onmouseup="tempHorWidth = document.getElementById('the_champ_icon_width').value;theChampSharingHorizontalPreview()" />
											<script type="text/javascript">
												theChampIncrement(document.getElementById('the_champ_width_plus'), "add", document.getElementById('the_champ_icon_width'), 300, 0.7);
												theChampIncrement(document.getElementById('the_champ_width_minus'), "subtract", document.getElementById('the_champ_icon_width'), 300, 0.7);
											</script>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_icon_width_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Width of the sharing icons', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>

									<tr>
										<th>
											<img id="the_champ_icon_height_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Height (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_icon_height" name="the_champ_sharing[horizontal_sharing_height]" type="text" value="<?php echo $sharing_height; ?>" />
											<input id="the_champ_height_plus" type="button" value="+" onmouseup="tempHorHeight = document.getElementById('the_champ_icon_height').value;theChampSharingHorizontalPreview()" />
											<input id="the_champ_height_minus" type="button" value="-" onmouseup="tempHorHeight = document.getElementById('the_champ_icon_height').value;theChampSharingHorizontalPreview()" />
											<script type="text/javascript">
												theChampIncrement(document.getElementById('the_champ_height_plus'), "add", document.getElementById('the_champ_icon_height'), 300, 0.7);
												theChampIncrement(document.getElementById('the_champ_height_minus'), "subtract", document.getElementById('the_champ_icon_height'), 300, 0.7);
											</script>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_icon_height_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Height of the sharing icons', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>
								</tbody>

								<tbody id="the_champ_border_radius_options" <?php echo isset( $theChampSharingOptions['horizontal_sharing_shape'] ) && $theChampSharingOptions['horizontal_sharing_shape'] != 'round' ? '' : 'style="display: none"'; ?>>
									<tr>
										<th>
											<img id="the_champ_icon_border_radius_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Border radius (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_icon_border_radius" name="the_champ_sharing[horizontal_border_radius]" type="text" value="<?php echo $sharing_border_radius; ?>" onkeyup="theChampSharingBorderRadius = this.value.trim() ? this.value.trim() + 'px' : '0px';theChampUpdateSharingPreview(theChampSharingBorderRadius, 'borderRadius', '0px', 'the_champ_preview')" />
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_icon_border_radius_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Specify a value for rounded corners. More the value, more rounded will the corners be. Leave empty for sharp corners.', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>
								</tbody>

								<tr>
									<th>
										<img id="the_champ_font_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Logo Color", 'super-socializer' ); ?></label>
									</th>
									<td>
										<script type="text/javascript">var theChampSharingTempColor = '<?php echo $sharing_color ? $sharing_color : "#fff" ?>';</script>
										<label for="the_champ_font_color_default"><?php _e("Default", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_font_color_default" onkeyup="if(this.value.trim() == '' || this.value.trim().length >= 3){ jQuery('#horizontal_svg').attr('style', jQuery('#horizontal_svg').attr('style').replace(theChampSharingTempColor.replace('#', '%23'), this.value.trim() ? this.value.trim().replace('#', '%23') : '%23fff')); theChampSharingTempColor = this.value.trim() ? this.value.trim() : '#fff';jQuery('#the_champ_preview').css('color', theChampSharingTempColor.replace('%23','#')) }" name="the_champ_sharing[horizontal_font_color_default]" type="text" value="<?php echo $sharing_color; ?>" />
										<input name="the_champ_sharing[horizontal_sharing_replace_color]" type="hidden" value="<?php echo isset( $theChampSharingOptions['horizontal_sharing_replace_color'] ) ? $theChampSharingOptions['horizontal_sharing_replace_color'] : ''; ?>" />
										<label style="margin-left:10px" for="the_champ_font_color_hover"><?php _e("On Hover", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_font_color_hover" name="the_champ_sharing[horizontal_font_color_hover]" type="text" onkeyup="" value="<?php echo $sharing_color_hover; ?>" />
										<input name="the_champ_sharing[horizontal_sharing_replace_color_hover]" type="hidden" value="<?php echo isset( $theChampSharingOptions['horizontal_sharing_replace_color_hover'] ) ? $theChampSharingOptions['horizontal_sharing_replace_color_hover'] : ''; ?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_font_color_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Specify the color or hex code (example #cc78e0) for the logo of icon. Leave empty for default. You can get the hex code of the required color from <a href="http://www.colorpicker.com/" target="_blank">this link</a>', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_bg_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Background Color", 'super-socializer' ); ?></label>
									</th>
									<td>
										<label for="the_champ_bg_color_default"><?php _e("Default", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_bg_color_default" name="the_champ_sharing[horizontal_bg_color_default]" type="text" onkeyup="theChampSharingBg = this.value.trim() ? this.value.trim() : '#3C589A'; theChampUpdateSharingPreview(this.value.trim(), 'backgroundColor', '#3C589A', 'the_champ_preview')" value="<?php echo $horizontal_bg ?>" />
										<label style="margin-left:10px" for="the_champ_bg_color_hover"><?php _e("On Hover", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_bg_color_hover" name="the_champ_sharing[horizontal_bg_color_hover]" type="text" onkeyup="theChampSharingBgHover = this.value.trim() ? this.value.trim() : '#3C589A';" value="<?php echo $horizontal_bg_hover ?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_bg_color_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Specify the color or hex code (example #cc78e0) for icon background. Save "transparent" for transparent background. Leave empty for default. You can get the hex code of the required color from <a href="http://www.colorpicker.com/" target="_blank">this link</a>', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_border_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Border", 'super-socializer' ); ?></label>
									</th>
									<td>
										<script type="text/javascript">var theChampBorderWidthHover = '<?php echo $border_width_hover = isset( $theChampSharingOptions['horizontal_border_width_hover'] ) ? $theChampSharingOptions['horizontal_border_width_hover'] : ''; ?>', theChampBorderColorHover = '<?php echo $border_color_hover = isset( $theChampSharingOptions['horizontal_border_color_hover'] ) ? $theChampSharingOptions['horizontal_border_color_hover'] : ''; ?>'</script>
										<label><strong><?php _e("Default", 'super-socializer' ); ?></strong></label>
										<br/>
										<label for="the_champ_border_width_default"><?php _e("Border Width", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_border_width_default" onkeyup="theChampBorderWidth = this.value.trim(); jQuery('#the_champ_preview').css('borderStyle', 'solid'); theChampUpdateSharingPreview(this.value.trim(), 'borderWidth', '0px', 'the_champ_preview'); theChampSharingHorizontalPreview();" name="the_champ_sharing[horizontal_border_width_default]" type="text" value="<?php echo $border_width ?>" />pixel(s)
										<label style="margin-left:10px" for="the_champ_border_color_default"><?php _e("Border Color", 'super-socializer' ); ?></label><input style="width: 100px" onkeyup="theChampBorderColor = this.value.trim(); jQuery('#the_champ_preview').css('borderStyle', 'solid'); theChampUpdateSharingPreview(this.value.trim(), 'borderColor', 'transparent', 'the_champ_preview')" id="the_champ_border_color_default" name="the_champ_sharing[horizontal_border_color_default]" type="text" value="<?php echo $border_color ?>" />
										<br/><br/>
										<label><strong><?php _e("On Hover", 'super-socializer' ); ?></strong></label>
										<br/>
										<label for="the_champ_border_width_hover"><?php _e("Border Width", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_border_width_hover" name="the_champ_sharing[horizontal_border_width_hover]" type="text" value="<?php echo $border_width_hover ?>" onkeyup="theChampBorderWidthHover = this.value.trim();" />pixel(s)
										<label style="margin-left:10px" for="the_champ_border_color_hover"><?php _e("Border Color", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_border_color_hover" name="the_champ_sharing[horizontal_border_color_hover]" type="text" value="<?php echo $border_color_hover ?>" onkeyup="theChampBorderColorHover = this.value.trim();" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_border_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Icon border', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_counter_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Counter Position", 'super-socializer' ); ?><br/><?php _e("(applies, if counter enabled)", 'super-socializer' ); ?></label>
									</th>
									<td>
										<input id="the_champ_counter_left" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'left' ? 'checked = "checked"' : '';?> value="left" />
										<label style="margin-right:10px" for="the_champ_counter_left"><?php _e("Left", 'super-socializer' ); ?></label>
										<input id="the_champ_counter_top" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'top' ? 'checked = "checked"' : '';?> value="top" />
										<label style="margin-right:10px" for="the_champ_counter_top"><?php _e("Top", 'super-socializer' ); ?></label>
										<input id="the_champ_counter_right" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'right' ? 'checked = "checked"' : '';?> value="right" />
										<label style="margin-right:10px" for="the_champ_counter_right"><?php _e("Right", 'super-socializer' ); ?></label>
										<input id="the_champ_counter_bottom" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'bottom' ? 'checked = "checked"' : '';?> value="bottom" />
										<label style="margin-right:10px" for="the_champ_counter_bottom"><?php _e("Bottom", 'super-socializer' ); ?></label><br/>
										<input id="the_champ_counter_inner_left" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'inner_left' ? 'checked = "checked"' : '';?> value="inner_left" />
										<label style="margin-right:10px" for="the_champ_counter_inner_left"><?php _e("Inner Left", 'super-socializer' ); ?></label>
										<input id="the_champ_counter_inner_top" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'inner_top' ? 'checked = "checked"' : '';?> value="inner_top" />
										<label style="margin-right:10px" for="the_champ_counter_inner_top"><?php _e("Inner Top", 'super-socializer' ); ?></label>
										<input id="the_champ_counter_inner_right" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'inner_right' ? 'checked = "checked"' : '';?> value="inner_right" />
										<label style="margin-right:10px" for="the_champ_counter_inner_right"><?php _e("Inner Right", 'super-socializer' ); ?></label>
										<input id="the_champ_counter_inner_bottom" name="the_champ_sharing[horizontal_counter_position]" onclick="theChampCounterPreview(this.value.trim())" type="radio" <?php echo $counter_position == 'inner_bottom' ? 'checked = "checked"' : '';?> value="inner_bottom" />
										<label style="margin-right:10px" for="the_champ_counter_inner_bottom"><?php _e("Inner Bottom", 'super-socializer' ); ?></label>
									</td>
								</tr>
								<script type="text/javascript">theChampCounterPreview('<?php echo $counter_position ?>');</script>

								<tr class="the_champ_help_content" id="the_champ_counter_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Position of share counter', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>
								
							</table>
						</div>	
					</div>
				
					<div class="stuffbox">
						<h3><label><?php _e('Floating interface theme', 'super-socializer' );?></label></h3>
						<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
								<tr>
									<th>
										<label style="float:left"><?php _e("Icon Preview", 'super-socializer' ); ?></label>
									</th>
									<td>
										<?php
										$vertical_bg = isset( $theChampSharingOptions['vertical_bg_color_default'] ) ? $theChampSharingOptions['vertical_bg_color_default'] : '';
										$vertical_bg_hover = isset( $theChampSharingOptions['vertical_bg_color_hover'] ) ? $theChampSharingOptions['vertical_bg_color_hover'] : '';
										$vertical_border_width = isset( $theChampSharingOptions['vertical_border_width_default'] ) ? $theChampSharingOptions['vertical_border_width_default'] : '';
										$vertical_border_color = isset( $theChampSharingOptions['vertical_border_color_default'] ) ? $theChampSharingOptions['vertical_border_color_default'] : '';
										$vertical_sharing_color = isset( $theChampSharingOptions['vertical_font_color_default'] ) ? $theChampSharingOptions['vertical_font_color_default'] : '';
										$vertical_sharing_color_hover = isset( $theChampSharingOptions['vertical_font_color_hover'] ) ? $theChampSharingOptions['vertical_font_color_hover'] : '';
										$vertical_sharing_shape = isset( $theChampSharingOptions['vertical_sharing_shape'] ) ? $theChampSharingOptions['vertical_sharing_shape'] : 'round'; 
										$vertical_sharing_size = isset( $theChampSharingOptions['vertical_sharing_size'] ) ? $theChampSharingOptions['vertical_sharing_size'] : 32;
										$vertical_sharing_width = isset( $theChampSharingOptions['vertical_sharing_width'] ) ? $theChampSharingOptions['vertical_sharing_width'] : 32;
										$vertical_sharing_height = isset( $theChampSharingOptions['vertical_sharing_height'] ) ? $theChampSharingOptions['vertical_sharing_height'] : 32;
										$vertical_sharing_border_radius = isset( $theChampSharingOptions['vertical_border_radius'] ) ? $theChampSharingOptions['vertical_border_radius'] : '';
										$vertical_vertical_bg_hover = isset( $theChampSharingOptions['vertical_bg_color_hover'] ) ? $theChampSharingOptions['vertical_bg_color_hover'] : '';
										$vertical_counter_position = isset( $theChampSharingOptions['vertical_counter_position'] ) ? $theChampSharingOptions['vertical_counter_position'] : '';
										$vertical_line_height = $vertical_sharing_shape == 'rectangle' ? $vertical_sharing_height : $vertical_sharing_size;
										?>
										<style type="text/css">
										#the_champ_vertical_preview{
											color:<?php echo $vertical_sharing_color ? $vertical_sharing_color : "#fff" ?>;
										}
										#the_champ_vertical_preview:hover{
											color:<?php echo $vertical_sharing_color_hover ?>;
										}
										</style>
										<div>
											<div class="theChampCounterVerticalPreviewTop" style="width:<?php echo 60 + ( isset( $theChampSharingOptions['vertical_sharing_shape'] ) && $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_width'] : $theChampSharingOptions['vertical_sharing_size'] ) ?>px">44</div>
											<div class="theChampCounterVerticalPreviewLeft">44</div>
											<div id="the_champ_vertical_preview" style="cursor:pointer;float:left">
												<div class="theChampCounterVerticalPreviewInnertop">44</div>
												<div class="theChampCounterVerticalPreviewInnerleft">44</div>
												<div id="vertical_svg" style="float:left;width:100%;height:100%;background:url('data:image/svg+xml;charset=utf8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22100%25%22%20height%3D%22100%25%22%20viewBox%3D%22-4%20-4%2040%2040%22%3E%3Cpath%20d%3D%22M17.78%2027.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99%202.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123%200-5.26%201.905-5.26%205.405v3.016h-3.53v4.09h3.53V27.5h4.223z%22%20fill%3D%22<?php echo $vertical_sharing_color ? str_replace( '#', '%23', $vertical_sharing_color) : "%23fff" ?>%22%3E%3C%2Fpath%3E%3C%2Fsvg%3E') no-repeat center center; margin: auto"></div>
												<div class="theChampCounterVerticalPreviewInnerright">44</div>
												<div class="theChampCounterVerticalPreviewInnerbottom">44</div>
											</div>
											<div class="theChampCounterVerticalPreviewRight">44</div>
											<div class="theChampCounterVerticalPreviewBottom" style="width:<?php echo 60 + ( isset( $theChampSharingOptions['vertical_sharing_shape'] ) && $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_width'] : $theChampSharingOptions['vertical_sharing_size'] ) ?>px">44</div>
										</div>
										
										<script type="text/javascript">
										var tempVerticalShape = '<?php echo $vertical_sharing_shape ?>', tempVerticalSize = '<?php echo $vertical_sharing_size ?>', tempVerticalHeight = '<?php echo $vertical_sharing_height ?>', tempVerticalWidth = '<?php echo $vertical_sharing_width ?>', theChampVerticalSharingBgHover = '<?php echo $vertical_bg_hover ?>', theChampVerticalSharingBg = '<?php echo $vertical_bg ? $vertical_bg : "#3C589A" ?>', theChampVerticalBorderWidth = '<?php echo $vertical_border_width ?>', theChampVerticalBorderColor = '<?php echo $vertical_border_color ?>', theChampVerticalBorderWidthHover = '<?php echo $vertical_border_width_hover = isset( $theChampSharingOptions['vertical_border_width_hover'] ) ? $theChampSharingOptions['vertical_border_width_hover'] : ''; ?>', theChampVerticalBorderColorHover = '<?php echo $vertical_border_color_hover = isset( $theChampSharingOptions['vertical_border_color_hover'] ) ? $theChampSharingOptions['vertical_border_color_hover'] : ''; ?>', theChampVerticalBorderRadius = '<?php echo $vertical_sharing_border_radius ? $vertical_sharing_border_radius . "px" : "0px" ?>';
										
										theChampSharingVerticalPreview();
										
										jQuery('#the_champ_vertical_preview').hover(function(){
											if(theChampVerticalSharingBgHover && theChampVerticalSharingBgHover != '#3C589A'){
												jQuery(this).css('backgroundColor', theChampVerticalSharingBgHover);
											}
											if(jQuery('#the_champ_vertical_font_color_hover').val().trim()){
												jQuery(this).find('#vertical_svg').attr('style', jQuery(this).find('#vertical_svg').attr('style').replace(theChampVerticalSharingTempColor.replace('#', '%23'), jQuery('#the_champ_vertical_font_color_hover').val().trim().replace('#', '%23')));
												jQuery(this).css('color', jQuery('#the_champ_vertical_font_color_hover').val().trim());
											}
											jQuery(this).css('borderStyle', 'solid');
											jQuery(this).css('borderWidth', theChampVerticalBorderWidthHover ? theChampVerticalBorderWidthHover : theChampVerticalBorderWidth ? theChampVerticalBorderWidth : '0');
											jQuery(this).css('borderColor', theChampVerticalBorderColorHover ? theChampVerticalBorderColorHover : 'transparent');
										},function(){
											jQuery(this).css('backgroundColor', theChampVerticalSharingBg);
											if(jQuery('#the_champ_vertical_font_color_hover').val().trim()){
												jQuery(this).find('#vertical_svg').attr('style', jQuery(this).find('#vertical_svg').attr('style').replace(jQuery('#the_champ_vertical_font_color_hover').val().trim().replace('#', '%23'), theChampVerticalSharingTempColor.replace('#', '%23')));
												jQuery(this).css('color', theChampVerticalSharingTempColor);
											}
											jQuery(this).css('borderStyle', 'solid');
											jQuery(this).css('borderWidth', theChampVerticalBorderWidth ? theChampVerticalBorderWidth : theChampVerticalBorderWidthHover ? theChampVerticalBorderWidthHover : '0');
											jQuery(this).css('borderColor', theChampVerticalBorderColor ? theChampVerticalBorderColor : 'transparent');
										});
										</script>
									</td>
								</tr>

								<tr>
									<td colspan="2">
										<div id="the_champ_vertical_preview_message" style="color:green;display:none"><?php _e('Do not forget to save the configuration after making changes by clicking the save button below', 'super-socializer' ); ?></div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_vertical_sharing_icon_shape_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Shape", 'super-socializer' ); ?></label>
									</th>
									<td>
										<input id="the_champ_vertical_icon_round" onclick="tempVerticalShape = 'round';theChampSharingVerticalPreview()" name="the_champ_sharing[vertical_sharing_shape]" type="radio" <?php echo $vertical_sharing_shape == 'round' ? 'checked = "checked"' : '';?> value="round" />
										<label style="margin-right:10px" for="the_champ_vertical_icon_round"><?php _e("Round", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_icon_square" onclick="tempVerticalShape = 'square';theChampSharingVerticalPreview()" name="the_champ_sharing[vertical_sharing_shape]" type="radio" <?php echo $vertical_sharing_shape == 'square' ? 'checked = "checked"' : '';?> value="square" />
										<label style="margin-right:10px" for="the_champ_vertical_icon_square"><?php _e("Square", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_icon_rectangle" onclick="tempVerticalShape = 'rectangle';theChampSharingVerticalPreview()" name="the_champ_sharing[vertical_sharing_shape]" type="radio" <?php echo $vertical_sharing_shape == 'rectangle' ? 'checked = "checked"' : '';?> value="rectangle" />
										<label for="the_champ_vertical_icon_rectangle"><?php _e("Rectangle", 'super-socializer' ); ?></label>
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_vertical_sharing_icon_shape_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Shape of the sharing icons', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tbody id="the_champ_vertical_size_options" <?php echo ! isset( $theChampSharingOptions['vertical_sharing_shape'] ) || $theChampSharingOptions['vertical_sharing_shape'] != 'rectangle' ? '' : 'style="display: none"'; ?>>	
									<tr>
										<th>
											<img id="the_champ_vertical_sharing_icon_size_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Size (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_vertical_sharing_icon_size" name="the_champ_sharing[vertical_sharing_size]" type="text" value="<?php echo $vertical_sharing_size; ?>" />
											<input id="the_champ_vertical_sharing_size_plus" type="button" value="+" onmouseup="tempVerticalSize = document.getElementById('the_champ_vertical_sharing_icon_size').value;theChampSharingVerticalPreview()" />
											<input id="the_champ_vertical_sharing_size_minus" type="button" value="-" onmouseup="tempVerticalSize = document.getElementById('the_champ_vertical_sharing_icon_size').value;theChampSharingVerticalPreview()" />
											<script type="text/javascript">
												theChampIncrement(document.getElementById('the_champ_vertical_sharing_size_plus'), "add", document.getElementById('the_champ_vertical_sharing_icon_size'), 300, 0.7);
												theChampIncrement(document.getElementById('the_champ_vertical_sharing_size_minus'), "subtract", document.getElementById('the_champ_vertical_sharing_icon_size'), 300, 0.7);
											</script>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_vertical_sharing_icon_size_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Size of the sharing icons', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>
								</tbody>

								<tbody id="the_champ_vertical_rectangle_options" <?php echo isset( $theChampSharingOptions['vertical_sharing_shape'] ) && $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? '' : 'style="display: none"'; ?>>
									<tr>
										<th>
											<img id="the_champ_vertical_icon_width_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Width (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_vertical_icon_width" name="the_champ_sharing[vertical_sharing_width]" type="text" value="<?php echo $vertical_sharing_width; ?>" />
											<input id="the_champ_vertical_width_plus" type="button" value="+" onmouseup="tempVerticalWidth = document.getElementById('the_champ_vertical_icon_width').value;theChampSharingVerticalPreview()" />
											<input id="the_champ_vertical_width_minus" type="button" value="-" onmouseup="tempVerticalWidth = document.getElementById('the_champ_vertical_icon_width').value;theChampSharingVerticalPreview()" />
											<script type="text/javascript">
												theChampIncrement(document.getElementById('the_champ_vertical_width_plus'), "add", document.getElementById('the_champ_vertical_icon_width'), 300, 0.7);
												theChampIncrement(document.getElementById('the_champ_vertical_width_minus'), "subtract", document.getElementById('the_champ_vertical_icon_width'), 300, 0.7);
											</script>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_vertical_icon_width_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Width of the sharing icons', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>

									<tr>
										<th>
											<img id="the_champ_vertical_icon_height_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Height (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_vertical_icon_height" name="the_champ_sharing[vertical_sharing_height]" type="text" value="<?php echo $vertical_sharing_height; ?>" />
											<input id="the_champ_vertical_height_plus" type="button" value="+" onmouseup="tempVerticalHeight = document.getElementById('the_champ_vertical_icon_height').value;theChampSharingVerticalPreview()" />
											<input id="the_champ_vertical_height_minus" type="button" value="-" onmouseup="tempVerticalHeight = document.getElementById('the_champ_vertical_icon_height').value;theChampSharingVerticalPreview()" />
											<script type="text/javascript">
												theChampIncrement(document.getElementById('the_champ_vertical_height_plus'), "add", document.getElementById('the_champ_vertical_icon_height'), 300, 0.7);
												theChampIncrement(document.getElementById('the_champ_vertical_height_minus'), "subtract", document.getElementById('the_champ_vertical_icon_height'), 300, 0.7);
											</script>
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_vertical_icon_height_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Height of the sharing icons', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>
								</tbody>

								<tbody id="the_champ_vertical_border_radius_options" <?php echo isset( $theChampSharingOptions['vertical_sharing_shape'] ) && $theChampSharingOptions['vertical_sharing_shape'] != 'round' ? '' : 'style="display: none"'; ?>>
									<tr>
										<th>
											<img id="the_champ_vertical_icon_border_radius_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
											<label><?php _e("Border radius (in pixels)", 'super-socializer' ); ?></label>
										</th>
										<td>
											<input style="width:50px" id="the_champ_vertical_icon_border_radius" name="the_champ_sharing[vertical_border_radius]" type="text" value="<?php echo $vertical_sharing_border_radius; ?>" onkeyup="theChampVerticalBorderRadius = this.value.trim() ? this.value.trim() + 'px' : '0px';theChampUpdateSharingPreview(theChampVerticalBorderRadius, 'borderRadius', '0px', 'the_champ_vertical_preview')" />
										</td>
									</tr>

									<tr class="the_champ_help_content" id="the_champ_vertical_icon_border_radius_help_cont">
										<td colspan="2">
										<div>
										<?php _e('Specify a value for rounded corners. More the value, more rounded will the corners be. Leave empty for sharp corners.', 'super-socializer' ) ?>
										</div>
										</td>
									</tr>
								</tbody>

								<tr>
									<th>
										<img id="the_champ_vertical_font_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Logo Color", 'super-socializer' ); ?></label>
									</th>
									<td>
										<script type="text/javascript">var theChampVerticalSharingTempColor = '<?php echo $vertical_sharing_color ? $vertical_sharing_color : "#fff" ?>';</script>
										<label for="the_champ_vertical_font_color_default"><?php _e("Default", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_vertical_font_color_default" name="the_champ_sharing[vertical_font_color_default]" onkeyup="if(this.value.trim() == '' || this.value.trim().length >= 3){ jQuery('#vertical_svg').attr('style', jQuery('#vertical_svg').attr('style').replace(theChampVerticalSharingTempColor.replace('#', '%23'), this.value.trim() ? this.value.trim().replace('#', '%23') : '%23fff')); theChampVerticalSharingTempColor = this.value.trim() ? this.value.trim() : '#fff';jQuery('#the_champ_vertical_preview').css('color', theChampVerticalSharingTempColor.replace('%23','#')) }" type="text" value="<?php echo $vertical_sharing_color ?>" />
										<input name="the_champ_sharing[vertical_sharing_replace_color]" type="hidden" value="<?php echo isset( $theChampSharingOptions['vertical_sharing_replace_color'] ) ? $theChampSharingOptions['vertical_sharing_replace_color'] : ''; ?>" />
										<label style="margin-left:10px" for="the_champ_vertical_font_color_hover"><?php _e("On Hover", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_vertical_font_color_hover" name="the_champ_sharing[vertical_font_color_hover]" type="text" value="<?php echo $vertical_sharing_color_hover; ?>" />
										<input name="the_champ_sharing[vertical_sharing_replace_color_hover]" type="hidden" value="<?php echo isset( $theChampSharingOptions['vertical_sharing_replace_color_hover'] ) ? $theChampSharingOptions['vertical_sharing_replace_color_hover'] : ''; ?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_vertical_font_color_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Specify the color or hex code (example #cc78e0) for the logo of icon. Leave empty for default. You can get the hex code of the required color from <a href="http://www.colorpicker.com/" target="_blank">this link</a>', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_vertical_icon_bg_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Background Color", 'super-socializer' ); ?></label>
									</th>
									<td>
										<label for="the_champ_vertical_icon_bg_color_default"><?php _e("Default", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_vertical_icon_bg_color_default" name="the_champ_sharing[vertical_bg_color_default]" type="text" onkeyup="theChampVerticalSharingBg = this.value.trim() ? this.value.trim() : '#3C589A'; theChampUpdateSharingPreview(this.value.trim(), 'backgroundColor', '#3C589A', 'the_champ_vertical_preview')" value="<?php echo $vertical_bg ?>" />
										<label style="margin-left:10px" for="the_champ_vertical_bg_color_hover"><?php _e("On Hover", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_vertical_bg_color_hover" name="the_champ_sharing[vertical_bg_color_hover]" type="text" onkeyup="theChampVerticalSharingBgHover = this.value.trim() ? this.value.trim() : '#3C589A';" value="<?php echo $vertical_bg_hover ?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_vertical_icon_bg_color_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Specify the color or hex code (example #cc78e0) for icon background. Save "transparent" for transparent background. Leave empty for default. You can get the hex code of the required color from <a href="http://www.colorpicker.com/" target="_blank">this link</a>', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_vertical_border_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Border", 'super-socializer' ); ?></label>
									</th>
									<td>
										<label><strong><?php _e("Default", 'super-socializer' ); ?></strong></label>
										<br/>
										<label for="the_champ_vertical_border_width_default"><?php _e("Border Width", 'super-socializer' ); ?></label><input style="width: 100px" onkeyup="theChampVerticalBorderWidth = this.value.trim(); jQuery('#the_champ_vertical_preview').css('borderStyle', 'solid'); theChampUpdateSharingPreview(this.value.trim(), 'borderWidth', '0px', 'the_champ_vertical_preview'); theChampSharingVerticalPreview();" id="the_champ_vertical_border_width_default" name="the_champ_sharing[vertical_border_width_default]" type="text" value="<?php echo $vertical_border_width ?>" />pixel(s)
										<label style="margin-left:10px" for="the_champ_vertical_border_color_default"><?php _e("Border Color", 'super-socializer' ); ?></label><input onkeyup="theChampVerticalBorderColor = this.value.trim(); jQuery('#the_champ_vertical_preview').css('borderStyle', 'solid'); theChampUpdateSharingPreview(this.value.trim(), 'borderColor', 'transparent', 'the_champ_vertical_preview')" style="width: 100px" id="the_champ_vertical_border_color_default" name="the_champ_sharing[vertical_border_color_default]" type="text" value="<?php echo $vertical_border_color = isset( $theChampSharingOptions['vertical_border_color_default'] ) ? $theChampSharingOptions['vertical_border_color_default'] : ''; ?>" />
										<br/><br/>
										<label><strong><?php _e("On Hover", 'super-socializer' ); ?></strong></label>
										<br/>
										<label for="the_champ_vertical_border_width_hover"><?php _e("Border Width", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_vertical_border_width_hover" name="the_champ_sharing[vertical_border_width_hover]" onkeyup="theChampVerticalBorderWidthHover = this.value.trim();" type="text" value="<?php echo $vertical_border_width_hover ?>" />pixel(s)
										<label style="margin-left:10px" for="the_champ_vertical_border_color_hover"><?php _e("Border Color", 'super-socializer' ); ?></label><input style="width: 100px" id="the_champ_vertical_border_color_hover" name="the_champ_sharing[vertical_border_color_hover]" onkeyup="theChampVerticalBorderColorHover = this.value.trim()" type="text" value="<?php echo $vertical_border_color_hover; ?>" />
									</td>
								</tr>

								<tr class="the_champ_help_content" id="the_champ_vertical_border_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Icon border', 'super-socializer' ) ?>
									</div>
									</td>
								</tr>

								<tr>
									<th>
										<img id="the_champ_vertical_counter_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
										<label><?php _e("Counter Position", 'super-socializer' ); ?><br/><?php _e("(applies, if counter enabled)", 'super-socializer' ); ?></label>
									</th>
									<td>
										<input id="the_champ_vertical_counter_left" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'left' ? 'checked = "checked"' : '';?> value="left" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_left"><?php _e("Left", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_counter_top" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'top' ? 'checked = "checked"' : '';?> value="top" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_top"><?php _e("Top", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_counter_right" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'right' ? 'checked = "checked"' : '';?> value="right" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_right"><?php _e("Right", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_counter_bottom" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'bottom' ? 'checked = "checked"' : '';?> value="bottom" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_bottom"><?php _e("Bottom", 'super-socializer' ); ?></label><br/>
										<input id="the_champ_vertical_counter_inner_left" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'inner_left' ? 'checked = "checked"' : '';?> value="inner_left" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_inner_left"><?php _e("Inner Left", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_counter_inner_top" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'inner_top' ? 'checked = "checked"' : '';?> value="inner_top" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_inner_top"><?php _e("Inner Top", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_counter_inner_right" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'inner_right' ? 'checked = "checked"' : '';?> value="inner_right" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_inner_right"><?php _e("Inner Right", 'super-socializer' ); ?></label>
										<input id="the_champ_vertical_counter_inner_bottom" name="the_champ_sharing[vertical_counter_position]" onclick="theChampVerticalCounterPreview(this.value.trim())" type="radio" <?php echo $vertical_counter_position == 'inner_bottom' ? 'checked = "checked"' : '';?> value="inner_bottom" />
										<label style="margin-right:10px" for="the_champ_vertical_counter_inner_bottom"><?php _e("Inner Bottom", 'super-socializer' ); ?></label>
									</td>
								</tr>
								<script type="text/javascript">theChampVerticalCounterPreview('<?php echo $vertical_counter_position ?>');</script>

								<tr class="the_champ_help_content" id="the_champ_vertical_counter_help_cont">
									<td colspan="2">
									<div>
									<?php _e('Position of share counter', 'super-socializer' ) ?>
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
					<h3><label><?php _e('Standard Sharing Interface Options', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_horizontal_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_horizontal_enable"><?php _e("Enable Standard sharing interface", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_horizontal_enable" onclick="theChampHorizontalSharingOptionsToggle(this)" name="the_champ_sharing[hor_enable]" type="checkbox" <?php echo isset( $theChampSharingOptions['hor_enable'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_horizontal_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Master control to enable standard sharing', 'super-socializer' ) ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_horizontal_sharing.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_horizontal_sharing_options" <?php echo isset( $theChampSharingOptions['hor_enable'] ) ? '' : 'style="display: none"'; ?>>
						<tr>
							<th>
							<img id="the_champ_horizontal_target_url_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_horizontal_target_url"><?php _e("Target Url", 'super-socializer' ); ?></label>
							</th>
							<td id="the_champ_target_url_column">
							<input id="the_champ_target_url_default" name="the_champ_sharing[horizontal_target_url]" type="radio" <?php echo !isset( $theChampSharingOptions['horizontal_target_url'] ) || $theChampSharingOptions['horizontal_target_url'] == 'default' ? 'checked = "checked"' : '';?> value="default" />
							<label for="the_champ_target_url_default"><?php _e('Url of the webpage where icons are located (default)', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_target_url_home" name="the_champ_sharing[horizontal_target_url]" type="radio" <?php echo isset( $theChampSharingOptions['horizontal_target_url'] ) && $theChampSharingOptions['horizontal_target_url'] == 'home' ? 'checked = "checked"' : '';?> value="home" />
							<label for="the_champ_target_url_home"><?php _e('Url of the homepage of your website', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_target_url_custom" name="the_champ_sharing[horizontal_target_url]" type="radio" <?php echo isset( $theChampSharingOptions['horizontal_target_url'] ) && $theChampSharingOptions['horizontal_target_url'] == 'custom' ? 'checked = "checked"' : '';?> value="custom" />
							<label for="the_champ_target_url_custom"><?php _e('Custom url', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_target_url_custom_url" name="the_champ_sharing[horizontal_target_url_custom]" type="text" value="<?php echo isset( $theChampSharingOptions['horizontal_target_url_custom'] ) ? $theChampSharingOptions['horizontal_target_url_custom'] : '' ?>" />
							</td>
						</tr>
						<tr class="the_champ_help_content" id="the_champ_horizontal_target_url_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Url to share', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_title_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_fblogin_title"><?php _e("Title", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_fblogin_title" name="the_champ_sharing[title]" type="text" value="<?php echo isset( $theChampSharingOptions['title'] ) ? $theChampSharingOptions['title'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_title_help_cont">
							<td colspan="2">
							<div>
							<?php _e('The text to display above the sharing interface', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<?php
						$instagramUsername = '';
						if(isset($theChampSharingOptions['instagram_username'])){
							$instagramUsername = $theChampSharingOptions['instagram_username'];
						}elseif(isset($theChampSharingOptions['vertical_instagram_username'])){
							$instagramUsername = $theChampSharingOptions['vertical_instagram_username'];
						}

						$commentFormContainerId = '';
						if(isset($theChampSharingOptions['comment_container_id'])){
							$commentFormContainerId = $theChampSharingOptions['comment_container_id'];
						}elseif(isset($theChampSharingOptions['vertical_comment_container_id'])){
							$commentFormContainerId = $theChampSharingOptions['vertical_comment_container_id'];
						}
						?>

						<tbody id="the_champ_instagram_options" <?php echo !in_array('instagram', $theChampSharingOptions['horizontal_re_providers']) ? 'style = "display: none"' : '';?> >
							<tr>
								<th>
								<img id="the_champ_instagram_username_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
								<label for="the_champ_instagram_username"><?php _e("Instagram username", 'super-socializer' ); ?></label>
								</th>
								<td>
								<input id="the_champ_instagram_username" name="the_champ_sharing[instagram_username]" type="text" value="<?php echo $instagramUsername ?>" />
								</td>
							</tr>
							
							<tr class="the_champ_help_content" id="the_champ_instagram_username_help_cont">
								<td colspan="2">
								<div>
								<?php _e('Username of the Instagram account you want to redirect users to, on clicking the icon', 'super-socializer' ) ?>
								</div>
								</td>
							</tr>
						</tbody>

						<tbody id="the_champ_comment_options" <?php echo ! in_array( 'Comment', $theChampSharingOptions['horizontal_re_providers'] ) ? 'style = "display: none"' : '';?> >
							<tr>
								<th>
								<img id="the_champ_comment_container_id_help" class="the_champ_help_bubble" src="<?php echo plugins_url( '../images/info.png', __FILE__ ) ?>" />
								<label for="the_champ_comment_container_id"><?php _e( "HTML ID of container element of comment form", 'super-socializer' ); ?></label>
								</th>
								<td>
								<input id="the_champ_comment_container_id" name="the_champ_sharing[comment_container_id]" type="text" value="<?php echo $commentFormContainerId ?>" />
								</td>
							</tr>
							
							<tr class="the_champ_help_content" id="the_champ_comment_container_id_help_cont">
								<td colspan="2">
								<div>
								<?php _e( 'HTML ID of the element you want to focus on the webpage, on click of Comment icon.', 'super-socializer' ) ?>
								</div>
								</td>
							</tr>
						</tbody>

						<?php
						$likeButtons = array('facebook_share', 'facebook_like', 'facebook_recommend', 'twitter_tweet', 'google_plusone', 'google_plus_share', 'linkedin_share', 'pinterest_pin', 'buffer_share', 'xing_share', 'yummly_share', 'reddit_badge', 'stumbleupon_badge');
						$sharingNetworks = array('facebook', 'twitter', 'linkedin', 'google_plus', 'print', 'email', 'yahoo', 'reddit', 'digg', 'delicious', 'stumbleupon', 'float_it', 'tumblr', 'vkontakte', 'pinterest', 'xing', 'whatsapp', 'instagram', 'yummly', 'buffer', 'AIM', 'Amazon_Wish_List', 'AOL_Mail', 'App.net', 'Baidu', 'Balatarin', 'BibSonomy', 'Bitty_Browser', 'Blinklist', 'Blogger_Post', 'BlogMarks', 'Bookmarks.fr', 'Box.net', 'BuddyMarks', 'Care2_News', 'CiteULike', 'Comment', 'Copy_Link', 'Diary.Ru', 'Diaspora', 'diHITT', 'Diigo', 'Douban', 'Draugiem', 'DZone', 'Evernote', 'Facebook_Messenger', 'Fark', 'Flipboard', 'Folkd', 'GentleReader', 'Google_Bookmarks', 'Google_Classroom', 'Google_Gmail', 'Hacker_News', 'Hatena', 'Instapaper', 'Jamespot', 'Kakao', 'Kik', 'Kindle_It', 'Known', 'Line', 'LiveJournal', 'Mail.Ru', 'Mendeley', 'Meneame', 'Mixi', 'MySpace', 'Netlog', 'Netvouz', 'NewsVine', 'NUjij', 'Odnoklassniki', 'Oknotizie', 'Outlook.com', 'Papaly', 'Pinboard', 'Plurk', 'Pocket', 'Polyvore', 'PrintFriendly', 'Protopage_Bookmarks', 'Pusha', 'Qzone', 'Rediff MyPage', 'Refind', 'Renren', 'Segnalo', 'Sina Weibo', 'SiteJot', 'Skype', 'Slashdot', 'SMS', 'StockTwits', 'Stumpedia', 'Svejo', 'Symbaloo_Feeds', 'Telegram', 'Trello', 'Tuenti', 'Twiddla', 'TypePad_Post', 'Viadeo', 'Viber', 'Wanelo', 'Webnews', 'WordPress', 'Wykop', 'Yahoo_Mail', 'Yahoo_Messenger', 'Yoolink', 'YouMob');
						?>
						
						<tr>
							<th>
							<img id="the_champ_ss_rearrange_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Rearrange icons", 'super-socializer' ); ?></label>
							</th>
						</tr>

						<tr>
							<td colspan="2">
							<script>
							<?php
							$horSharingStyle = 'width:' . ( $theChampSharingOptions['horizontal_sharing_shape'] != 'rectangle' ? $theChampSharingOptions['horizontal_sharing_size'] : $theChampSharingOptions['horizontal_sharing_width'] ) . 'px;height:' . $line_height . 'px;';
							$horDeliciousRadius = '';
							if($theChampSharingOptions['horizontal_sharing_shape'] == 'round'){
								$horSharingStyle .= 'border-radius:999px;';
								$horDeliciousRadius = 'border-radius:999px;';
							} elseif ( isset( $theChampSharingOptions['horizontal_border_radius'] ) && $theChampSharingOptions['horizontal_border_radius'] != '' ) {
								$horSharingStyle .= 'border-radius:' . $theChampSharingOptions['horizontal_border_radius'] . 'px;';
							}
							?>
							var theChampHorSharingStyle = '<?php echo $horSharingStyle ?>', theChampHorDeliciousRadius = '<?php echo $horDeliciousRadius ?>', theChampLikeButtons = ["<?php echo implode('","', $likeButtons) ?>"];
							</script>
							<style type="text/css">
							.theChampSharingBackground{
								<?php if($horizontal_bg){ ?>
								background-color: <?php echo $horizontal_bg ?>;
								<?php }if($border_width){ ?>
								border-width: <?php echo $border_width ?>px;
								border-style: solid;
								<?php } ?>
								border-color: <?php echo $border_color ? $border_color : 'transparent'; ?>;
							}
							.theChampSharingBackground:hover{
								<?php if($horizontal_bg_hover){ ?>
								background-color: <?php echo $horizontal_bg_hover ?>;
								<?php }if($border_width_hover){ ?>
								border-width: <?php echo $border_width_hover ?>px;
								border-style: solid;
								<?php } ?>
								border-color: <?php echo $border_color_hover ? $border_color_hover : 'transparent'; ?>;
							}
							</style>
							<ul id="the_champ_ss_rearrange">
								<?php 
								if ( isset( $theChampSharingOptions['horizontal_re_providers'] ) ) {
									foreach ( $theChampSharingOptions['horizontal_re_providers'] as $rearrange ) {
										?>
										<li title="<?php echo ucfirst( str_replace( '_', ' ', $rearrange ) ) ?>" id="the_champ_re_horizontal_<?php echo str_replace(array(' ', '.'), '_', $rearrange) ?>" >
										<i style="display:block;<?php echo $horSharingStyle ?>" class="<?php echo in_array($rearrange, $likeButtons) ? '' : 'theChampSharingBackground' ?> theChamp<?php echo ucfirst(str_replace(array('_', '.', ' '), '', $rearrange)) ?>Background"><div class="theChampSharingSvg theChamp<?php echo ucfirst(str_replace(array('_', ' ', '.'), '', $rearrange)) ?>Svg" style="<?php echo $horDeliciousRadius ?>"></div></i>
										<input type="hidden" name="the_champ_sharing[horizontal_re_providers][]" value="<?php echo $rearrange ?>">
										</li>
										<?php
									}
								}
								?>
							</ul>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_ss_rearrange_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Drag the icons to rearrange in desired order', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<th colspan="2">
							<img id="the_champ_providers_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Select Sharing Services", 'super-socializer' ); ?></label>
							</th>
						</tr>

						<tr class="the_champ_help_content" id="the_champ_providers_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Select sharing services to show in social share bar', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<td colspan="2" class="selectSharingNetworks">
							<?php
							foreach($likeButtons as $likeButton){
								?>
								<div class="theChampHorizontalSharingProviderContainer">
								<input id="the_champ_<?php echo $likeButton ?>" type="checkbox" <?php echo isset( $theChampSharingOptions['horizontal_re_providers'] ) && in_array($likeButton, $theChampSharingOptions['horizontal_re_providers'] ) ? 'checked = "checked"' : '';?> value="<?php echo $likeButton ?>" />
								<label for="the_champ_<?php echo $likeButton ?>"><img src="<?php echo plugins_url('../images/sharing/'. $likeButton .'.png', __FILE__) ?>" /></label>
								</div>
								<?php
							}
							?>
							<div style="clear:both"></div>
							<div style="width:100%; margin: 10px 0"><input type="text" onkeyup="theChampSearchSharingNetworks(this.value.trim())" placeholder="<?php _e( 'Search social network', 'super-socializer' ) ?>" class="search" /></div>
							<div style="clear:both"></div>
							<?php
							foreach($sharingNetworks as $sharingNetwork){
								?>
								<div class="theChampHorizontalSharingProviderContainer">
								<input id="the_champ_<?php echo $sharingNetwork ?>" type="checkbox" <?php echo isset( $theChampSharingOptions['horizontal_re_providers'] ) && in_array($sharingNetwork, $theChampSharingOptions['horizontal_re_providers'] ) ? 'checked = "checked"' : '';?> value="<?php echo $sharingNetwork ?>" />
								<label for="the_champ_<?php echo $sharingNetwork ?>"><i style="display:block;width:18px;height:18px;" class="theChampSharing theChamp<?php echo str_replace(array('_', '.', ' '), '', ucfirst($sharingNetwork)) ?>Background"><ss style="display:block;" class="theChampSharingSvg theChamp<?php echo str_replace(array('_', '.', ' '), '', ucfirst($sharingNetwork)) ?>Svg"></ss></i></label>
								<label for="the_champ_<?php echo $sharingNetwork ?>" class="lblSocialNetwork"><?php echo str_replace('_', ' ', ucfirst($sharingNetwork)) ?></label>
								</div>
								<?php
							}
							?>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_hor_alignment_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_hor_alignment"><?php _e("Horizontal alignment", 'super-socializer' ); ?></label>
							</th>
							<td>
							<select id="the_champ_hor_alignment" name="the_champ_sharing[hor_sharing_alignment]">
								<option value="left" <?php echo isset( $theChampSharingOptions['hor_sharing_alignment'] ) && $theChampSharingOptions['hor_sharing_alignment'] == 'left' ? 'selected="selected"' : '' ?>><?php _e('Left', 'super-socializer' ) ?></option>
								<option value="center" <?php echo isset( $theChampSharingOptions['hor_sharing_alignment'] ) && $theChampSharingOptions['hor_sharing_alignment'] == 'center' ? 'selected="selected"' : '' ?>><?php _e('Center', 'super-socializer' ) ?></option>
								<option value="right" <?php echo isset( $theChampSharingOptions['hor_sharing_alignment'] ) && $theChampSharingOptions['hor_sharing_alignment'] == 'right' ? 'selected="selected"' : '' ?>><?php _e('Right', 'super-socializer' ) ?></option>
							</select>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_hor_alignment_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Horizontal alignment of the sharing interface', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_position_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Position with respect to content", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_top" name="the_champ_sharing[top]" type="checkbox" <?php echo isset( $theChampSharingOptions['top'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_top"><?php _e('Top of the content', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_bottom" name="the_champ_sharing[bottom]" type="checkbox" <?php echo isset( $theChampSharingOptions['bottom'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_bottom"><?php _e('Bottom of the content', 'super-socializer' ) ?></label>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_position_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify position of the sharing interface with respect to the content', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_location_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Placement", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_home" name="the_champ_sharing[home]" type="checkbox" <?php echo isset( $theChampSharingOptions['home'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_home"><?php _e('Homepage', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_post" name="the_champ_sharing[post]" type="checkbox" <?php echo isset( $theChampSharingOptions['post'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_post"><?php _e('Posts', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_page" name="the_champ_sharing[page]" type="checkbox" <?php echo isset( $theChampSharingOptions['page'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_page"><?php _e('Pages', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_excerpt" name="the_champ_sharing[excerpt]" type="checkbox" <?php echo isset( $theChampSharingOptions['excerpt'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_excerpt"><?php _e('Excerpts and Posts page', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_category" name="the_champ_sharing[category]" type="checkbox" <?php echo isset( $theChampSharingOptions['category'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_category"><?php _e('Category Archives', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_archive" name="the_champ_sharing[archive]" type="checkbox" <?php echo isset( $theChampSharingOptions['archive'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_archive"><?php _e('Archive Pages (Category, Tag, Author or Date based pages)', 'super-socializer' ) ?></label><br/>
							<?php
							$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
							$post_types = array_diff( $post_types, array( 'post', 'page' ) );
							if( count( $post_types ) ) {	
								foreach ( $post_types as $post_type ) {
									?>
									<input id="the_champ_<?php echo $post_type ?>" name="the_champ_sharing[<?php echo $post_type ?>]" type="checkbox" <?php echo isset( $theChampSharingOptions[$post_type] ) ? 'checked = "checked"' : '';?> value="1" />
									<label for="the_champ_<?php echo $post_type ?>"><?php echo ucfirst( $post_type ) . 's'; ?></label><br/>
									<?php
								}
							}
							
							if($theChampIsBpActive){
								?>
								<input id="the_champ_bp_activity" name="the_champ_sharing[bp_activity]" type="checkbox" <?php echo isset( $theChampSharingOptions['bp_activity'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_bp_activity"><?php _e('BuddyPress activity', 'super-socializer' ) ?></label><br/>
								<input id="the_champ_bp_group" name="the_champ_sharing[bp_group]" type="checkbox" <?php echo isset( $theChampSharingOptions['bp_group'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_bp_group"><?php _e('BuddyPress group (only at top of content)', 'super-socializer' ) ?></label><br/>
								<?php
							}
							if(function_exists('is_bbpress')){
								?>
								<input id="the_champ_bb_forum" name="the_champ_sharing[bb_forum]" type="checkbox" <?php echo isset( $theChampSharingOptions['bb_forum'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_bb_forum"><?php _e('BBPress forum', 'super-socializer' ) ?></label>
								<br/>
								<input id="the_champ_bb_topic" name="the_champ_sharing[bb_topic]" type="checkbox" <?php echo isset( $theChampSharingOptions['bb_topic'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_bb_topic"><?php _e('BBPress topic', 'super-socializer' ) ?></label>
								<br/>
								<input id="the_champ_bb_reply" name="the_champ_sharing[bb_reply]" type="checkbox" <?php echo isset( $theChampSharingOptions['bb_reply'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_bb_reply"><?php _e('BBPress reply', 'super-socializer' ) ?></label>
								<br/>
								<?php
							}
							if(heateor_ss_is_plugin_active('woocommerce/woocommerce.php')){
								?>
								<input id="the_champ_woocom_shop" name="the_champ_sharing[woocom_shop]" type="checkbox" <?php echo isset( $theChampSharingOptions['woocom_shop'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_woocom_shop"><?php _e('After individual product at WooCommerce Shop page', 'super-socializer' ) ?></label>
								<br/>
								<input id="the_champ_woocom_product" name="the_champ_sharing[woocom_product]" type="checkbox" <?php echo isset( $theChampSharingOptions['woocom_product'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_woocom_product"><?php _e('WooCommerce Product Page', 'super-socializer' ) ?></label>
								<br/>
								<input id="the_champ_woocom_thankyou" name="the_champ_sharing[woocom_thankyou]" type="checkbox" <?php echo isset( $theChampSharingOptions['woocom_thankyou'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_woocom_thankyou"><?php _e('WooCommerce Thankyou Page', 'super-socializer' ) ?></label>
								<br/>
								<?php
							}
							?>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_location_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify the pages where you want to enable Sharing interface', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_count_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_counts"><?php _e("Show share counts", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_counts" name="the_champ_sharing[horizontal_counts]" type="checkbox" <?php echo isset( $theChampSharingOptions['horizontal_counts'] ) ? 'checked = "checked"' : '';?> value="1" />
							<br/>
							<span style="font-size:12px"><?php _e( 'Share counts are supported for Facebook, Twitter, Linkedin, Buffer, Reddit, Pinterest, Stumbleupon, Odnoklassniki and Vkontakte', 'super-socializer' ) ?></span>
							</td>
						</tr>
						
						<?php
						$tweetCountService = 'newsharecounts';
						if ( isset( $theChampSharingOptions['tweet_count_service'] ) ) {
							$tweetCountService = $theChampSharingOptions['tweet_count_service'];
						} elseif ( isset( $theChampSharingOptions['vertical_tweet_count_service'] ) ) {
							$tweetCountService = $theChampSharingOptions['vertical_tweet_count_service'];
						}
						?>

						<tr id="the_champ_twitter_share_count" <?php echo isset( $theChampSharingOptions['horizontal_counts'] ) ? '' : 'style="display:none"' ?>>
							<th>
							</th>
							<td>
							<input id="the_champ_newsharecounts" name="the_champ_sharing[tweet_count_service]" type="radio" <?php echo $tweetCountService == 'newsharecounts' ? 'checked = "checked"' : '';?> value="newsharecounts" /><label for="the_champ_newsharecounts"><?php echo sprintf( __( 'Use <a href="%s" target="_blank">NewShareCounts</a> to show Twitter share counts', 'super-socializer'), 'http://newsharecounts.com' ) ?></label>
							<br/>
							<span class="the_champ_help_content" style="display:block"><?php echo sprintf( __( 'For this to work, you have to enter your website url %s and sign in using Twitter at <a href="%s" target="_blank">their website</a>', 'super-socializer'), esc_url(home_url()), 'http://newsharecounts.com' ) ?></span>
							<br/>
							<input id="the_champ_opensharecount" name="the_champ_sharing[tweet_count_service]" type="radio" <?php echo $tweetCountService == 'opensharecount' ? 'checked = "checked"' : '';?> value="opensharecount" /><label for="the_champ_opensharecount"><?php echo sprintf( __( 'Use <a href="%s" target="_blank">OpenShareCount</a> to show Twitter share counts', 'super-socializer'), 'http://opensharecount.com' ) ?></label>
							<br/>
							<span class="the_champ_help_content" style="display:block"><?php echo sprintf( __( 'For this to work, you have to sign up and register your website url %s at <a href="%s" target="_blank">their website</a>', 'super-socializer'), esc_url(home_url()), 'http://opensharecount.com' ) ?></span>
							</td>
						</tr>

						<tr class="the_champ_help_content" id="the_champ_count_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, share counts are displayed above sharing icons.', 'super-socializer' ) ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_share_count.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_total_hor_shares_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_total_hor_shares"><?php _e("Show total shares", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_total_hor_shares" name="the_champ_sharing[horizontal_total_shares]" type="checkbox" <?php echo isset( $theChampSharingOptions['horizontal_total_shares'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_total_hor_shares_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, total shares will be displayed with sharing icons', 'super-socializer' ) ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_horizontal_total_shares.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_hmore_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_hmore"><?php _e("Enable 'More' icon", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_hmore" name="the_champ_sharing[horizontal_more]" type="checkbox" <?php echo isset( $theChampSharingOptions['horizontal_more'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_hmore_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, "More" icon will be displayed after selected sharing icons which shows additional sharing networks in popup', 'super-socializer' ) ?>
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
					<h3><label><?php _e('Floating Sharing Interface Options', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_vertical_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_vertical_enable"><?php _e("Enable Floating sharing interface", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_vertical_enable" onclick="theChampVerticalSharingOptionsToggle(this)" name="the_champ_sharing[vertical_enable]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_enable'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_vertical_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Master control to enable floating sharing widget', 'super-socializer' ) ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_vertical_sharing.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_vertical_sharing_options" <?php echo isset( $theChampSharingOptions['vertical_enable'] ) ? '' : 'style="display: none"'; ?>>
						<tr>
							<th>
							<img id="the_champ_vertical_target_url_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_vertical_target_url"><?php _e("Target Url", 'super-socializer' ); ?></label>
							</th>
							<td id="the_champ_vertical_target_url_column">
							<input id="the_champ_vertical_target_url_default" name="the_champ_sharing[vertical_target_url]" type="radio" <?php echo !isset( $theChampSharingOptions['vertical_target_url'] ) || $theChampSharingOptions['vertical_target_url'] == 'default' ? 'checked = "checked"' : '';?> value="default" />
							<label for="the_champ_vertical_target_url_default"><?php _e('Url of the webpage where icons are located (default)', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_target_url_home" name="the_champ_sharing[vertical_target_url]" type="radio" <?php echo isset( $theChampSharingOptions['vertical_target_url'] ) && $theChampSharingOptions['vertical_target_url'] == 'home' ? 'checked = "checked"' : '';?> value="home" />
							<label for="the_champ_vertical_target_url_home"><?php _e('Url of the homepage of your website', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_target_url_custom" name="the_champ_sharing[vertical_target_url]" type="radio" <?php echo isset( $theChampSharingOptions['vertical_target_url'] ) && $theChampSharingOptions['vertical_target_url'] == 'custom' ? 'checked = "checked"' : '';?> value="custom" />
							<label for="the_champ_vertical_target_url_custom"><?php _e('Custom url', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_target_url_custom_url" name="the_champ_sharing[vertical_target_url_custom]" type="text" value="<?php echo isset( $theChampSharingOptions['vertical_target_url_custom'] ) ? $theChampSharingOptions['vertical_target_url_custom'] : '' ?>" />
							</td>
						</tr>
						<tr class="the_champ_help_content" id="the_champ_vertical_target_url_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Url to share', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_vertical_instagram_options" <?php echo !in_array('instagram', $theChampSharingOptions['vertical_re_providers']) ? 'style = "display: none"' : '';?> >
							<tr>
								<th>
								<img id="the_champ_vertical_instagram_username_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
								<label for="the_champ_vertical_instagram_username"><?php _e("Instagram username", 'super-socializer' ); ?></label>
								</th>
								<td>
								<input id="the_champ_vertical_instagram_username" name="the_champ_sharing[vertical_instagram_username]" type="text" value="<?php echo $instagramUsername ?>" />
								</td>
							</tr>
							
							<tr class="the_champ_help_content" id="the_champ_vertical_instagram_username_help_cont">
								<td colspan="2">
								<div>
								<?php _e('Username of the Instagram account you want to redirect users to, on clicking the icon', 'super-socializer' ) ?>
								</div>
								</td>
							</tr>
						</tbody>

						<tbody id="the_champ_vertical_comment_options" <?php echo ! in_array( 'Comment', $theChampSharingOptions['vertical_re_providers'] ) ? 'style = "display: none"' : '';?> >
							<tr>
								<th>
								<img id="the_champ_vertical_comment_container_id_help" class="the_champ_help_bubble" src="<?php echo plugins_url( '../images/info.png', __FILE__ ) ?>" />
								<label for="the_champ_vertical_comment_container_id"><?php _e( "HTML ID of container element of comment form", 'super-socializer' ); ?></label>
								</th>
								<td>
								<input id="the_champ_vertical_comment_container_id" name="the_champ_sharing[vertical_comment_container_id]" type="text" value="<?php echo $commentFormContainerId ?>" />
								</td>
							</tr>
							
							<tr class="the_champ_help_content" id="the_champ_vertical_comment_container_id_help_cont">
								<td colspan="2">
								<div>
								<?php _e( 'HTML ID of the element you want to focus on the webpage, on click of Comment icon.', 'super-socializer' ) ?>
								</div>
								</td>
							</tr>
						</tbody>

						<tr>
							<th>
							<img id="the_champ_ss_vertical_rearrange_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Rearrange icons", 'super-socializer' ); ?></label>
							</th>
						</tr>
						
						<tr>
							<td colspan="2">
							<script>
							<?php
							$verticalSharingStyle = 'width:' . ( $theChampSharingOptions['vertical_sharing_shape'] != 'rectangle' ? $theChampSharingOptions['vertical_sharing_size'] : $theChampSharingOptions['vertical_sharing_width'] ) . 'px;height:' . $vertical_line_height . 'px;';
							$verticalDeliciousRadius = '';
							if($theChampSharingOptions['vertical_sharing_shape'] == 'round'){
								$verticalSharingStyle .= 'border-radius:999px;';
								$verticalDeliciousRadius = 'border-radius:999px;';
							} elseif ( isset( $theChampSharingOptions['vertical_border_radius'] ) && $theChampSharingOptions['vertical_border_radius'] != '' ) {
								$verticalSharingStyle .= 'border-radius:' . $theChampSharingOptions['vertical_border_radius'] . 'px;';
							}
							?>
							var theChampVerticalSharingStyle = '<?php echo $verticalSharingStyle ?>', theChampVerticalDeliciousRadius = '<?php echo $verticalDeliciousRadius ?>';
							</script>
							<style type="text/css">
							.theChampVerticalSharingBackground{
								<?php if($vertical_bg){ ?>
								background-color: <?php echo $vertical_bg ?>;
								<?php }if($vertical_border_width){ ?>
								border-width: <?php echo $vertical_border_width ?>px;
								border-style: solid;
								<?php } ?>
								border-color: <?php echo $vertical_border_color ? $vertical_border_color : 'transparent'; ?>;
							}
							.theChampVerticalSharingBackground:hover{
								<?php if($vertical_bg_hover){ ?>
								background-color: <?php echo $vertical_bg_hover ?>;
								<?php }if($vertical_border_width_hover){ ?>
								border-width: <?php echo $vertical_border_width_hover ?>px;
								border-style: solid;
								<?php } ?>
								border-color: <?php echo $vertical_border_color_hover ? $vertical_border_color_hover : 'transparent'; ?>;
							}
							</style>
							<ul id="the_champ_ss_vertical_rearrange">
								<?php
								if ( isset( $theChampSharingOptions['vertical_re_providers'] ) ) {
									foreach ( $theChampSharingOptions['vertical_re_providers'] as $rearrange ) {
										?>
										<li title="<?php echo ucfirst( str_replace( '_', ' ', $rearrange ) ) ?>" id="the_champ_re_vertical_<?php echo str_replace( array( ' ', '.' ), '_', $rearrange) ?>" >
										<i style="display:block;<?php echo $verticalSharingStyle ?>" class="<?php echo in_array($rearrange, $likeButtons) ? '' : 'theChampVerticalSharingBackground' ?> theChamp<?php echo ucfirst(str_replace( array('_', '.', ' '), '', $rearrange)) ?>Background"><div class="theChampSharingSvg theChamp<?php echo ucfirst(str_replace( array('_', '.', ' '), '', $rearrange ) ) ?>Svg" style="<?php echo $verticalDeliciousRadius ?>"></div></i>
										<input type="hidden" name="the_champ_sharing[vertical_re_providers][]" value="<?php echo $rearrange ?>">
										</li>
										<?php
									}
								}
								?>
							</ul>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_ss_vertical_rearrange_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Drag the icons to rearrange in desired order', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<th colspan="2">
							<img id="the_champ_vertical_providers_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Select Sharing Services", 'super-socializer' ); ?></label>
							</th>
						</tr>

						<tr class="the_champ_help_content" id="the_champ_vertical_providers_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Select sharing services to show in social share bar', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<td colspan="2" class="selectSharingNetworks">
							<?php
							foreach($likeButtons as $likeButton){
								?>
								<div class="theChampVerticalSharingProviderContainer">
								<input id="the_champ_vertical_<?php echo $likeButton ?>" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_re_providers'] ) && in_array($likeButton, $theChampSharingOptions['vertical_re_providers'] ) ? 'checked = "checked"' : '';?> value="<?php echo $likeButton ?>" />
								<label for="the_champ_vertical_<?php echo $likeButton ?>"><img src="<?php echo plugins_url('../images/sharing/'. $likeButton .'.png', __FILE__) ?>" /></label>
								</div>
								<?php
							}
							?>
							<div style="clear:both"></div>
							<div style="width:100%; margin: 10px 0"><input type="text" onkeyup="theChampSearchSharingNetworks(this.value.trim())" placeholder="<?php _e( 'Search social network', 'super-socializer' ) ?>" class="search" /></div>
							<div style="clear:both"></div>
							<?php
							foreach($sharingNetworks as $sharingNetwork){
								?>
								<div class="theChampVerticalSharingProviderContainer">
								<input id="the_champ_vertical_sharing_<?php echo $sharingNetwork ?>" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_re_providers'] ) && in_array($sharingNetwork, $theChampSharingOptions['vertical_re_providers'] ) ? 'checked = "checked"' : '';?> value="<?php echo $sharingNetwork ?>" />
								<label for="the_champ_vertical_sharing_<?php echo $sharingNetwork ?>"><i style="display:block;width:18px;height:18px;" class="theChampSharing theChamp<?php echo str_replace(array('_', '.', ' '), '', ucfirst($sharingNetwork)) ?>Background"><ss style="display:block;" class="theChampSharingSvg theChamp<?php echo str_replace(array('_', '.', ' '), '', ucfirst($sharingNetwork)) ?>Svg"></ss></i></label>
								<label for="the_champ_vertical_sharing_<?php echo $sharingNetwork ?>" class="lblSocialNetwork"><?php echo str_replace('_', ' ', ucfirst($sharingNetwork)) ?></label>
								</div>
								<?php
							}
							?>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_vertical_bg_color_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Background Color", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input style="width: 100px" name="the_champ_sharing[vertical_bg]" type="text" value="<?php echo isset( $theChampSharingOptions['vertical_bg'] ) ? $theChampSharingOptions['vertical_bg'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_vertical_bg_color_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify the color or hex code (example #cc78e0) for the background of vertical sharing bar. Leave empty for transparent. You can get the hex code of the required color from <a href="http://www.colorpicker.com/" target="_blank">this link</a>', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_alignment_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_alignment"><?php _e("Horizontal alignment", 'super-socializer' ); ?></label>
							</th>
							<td>
							<select onchange="theChampToggleOffset(this.value)" id="the_champ_alignment" name="the_champ_sharing[alignment]">
								<option value="left" <?php echo isset( $theChampSharingOptions['alignment'] ) && $theChampSharingOptions['alignment'] == 'left' ? 'selected="selected"' : '' ?>><?php _e('Left', 'super-socializer' ) ?></option>
								<option value="right" <?php echo isset( $theChampSharingOptions['alignment'] ) && $theChampSharingOptions['alignment'] == 'right' ? 'selected="selected"' : '' ?>><?php _e('Right', 'super-socializer' ) ?></option>
							</select>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_alignment_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Horizontal alignment of the sharing interface', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tbody id="the_champ_left_offset_rows" <?php echo (isset( $theChampSharingOptions['alignment'] ) && $theChampSharingOptions['alignment'] == 'left') ? '' : 'style="display: none"' ?>>
						<tr>
							<th>
							<img id="the_champ_left_offset_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_left_offset"><?php _e("Left offset", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input style="width: 100px" id="the_champ_left_offset" name="the_champ_sharing[left_offset]" type="text" value="<?php echo isset( $theChampSharingOptions['left_offset'] ) ? $theChampSharingOptions['left_offset'] : '' ?>" />px
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_left_offset_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify a number. Increase in number will shift sharing interface towards right and decrease will shift it towards left. Number can be negative too.', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						</tbody>
						
						<tbody id="the_champ_right_offset_rows" <?php echo (isset( $theChampSharingOptions['alignment'] ) && $theChampSharingOptions['alignment'] == 'right') ? '' : 'style="display: none"' ?>>
						<tr>
							<th>
							<img id="the_champ_right_offset_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_right_offset"><?php _e("Right offset", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input style="width: 100px" id="the_champ_right_offset" name="the_champ_sharing[right_offset]" type="text" value="<?php echo isset( $theChampSharingOptions['right_offset'] ) ? $theChampSharingOptions['right_offset'] : '' ?>" />px
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_right_offset_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify a number. Increase in number will shift sharing interface towards left and decrease will shift it towards right. Number can be negative too.', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						</tbody>
						
						<tr>
							<th>
							<img id="the_champ_top_offset_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_top_offset"><?php _e("Top offset", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input style="width: 100px" id="the_champ_top_offset" name="the_champ_sharing[top_offset]" type="text" value="<?php echo isset( $theChampSharingOptions['top_offset'] ) ? $theChampSharingOptions['top_offset'] : '' ?>" />px
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_top_offset_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify a number. Increase in number will shift sharing interface towards bottom and decrease will shift it towards top.', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_vertical_location_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label><?php _e("Placement", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_vertical_home" name="the_champ_sharing[vertical_home]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_home'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_vertical_home"><?php _e('Homepage', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_post" name="the_champ_sharing[vertical_post]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_post'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_vertical_post"><?php _e('Posts', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_page" name="the_champ_sharing[vertical_page]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_page'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_vertical_page"><?php _e('Pages', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_excerpt" name="the_champ_sharing[vertical_excerpt]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_excerpt'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_vertical_excerpt"><?php _e('Excerpts and Posts page', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_category" name="the_champ_sharing[vertical_category]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_category'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_vertical_category"><?php _e('Category Archives', 'super-socializer' ) ?></label><br/>
							<input id="the_champ_vertical_archive" name="the_champ_sharing[vertical_archive]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_archive'] ) ? 'checked = "checked"' : '';?> value="1" />
							<label for="the_champ_vertical_archive"><?php _e('Archive Pages (Category, Tag, Author or Date based pages)', 'super-socializer' ) ?></label><br/>
							<?php
							if( count( $post_types ) ) {
								foreach ( $post_types as $post_type ) {
									?>
									<input id="the_champ_vertical_<?php echo $post_type ?>" name="the_champ_sharing[vertical_<?php echo $post_type ?>]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_' . $post_type] ) ? 'checked = "checked"' : '';?> value="1" />
									<label for="the_champ_vertical_<?php echo $post_type ?>"><?php echo ucfirst( $post_type ) . 's'; ?></label><br/>
									<?php
								}
							}

							if($theChampIsBpActive){
								?>
								<input id="the_champ_vertical_bp_group" name="the_champ_sharing[vertical_bp_group]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_bp_group'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_vertical_bp_group"><?php _e('BuddyPress group', 'super-socializer' ) ?></label><br/>
								<?php
							}

							if(function_exists('is_bbpress')){
								?>
								<br/>
								<input id="the_champ_vertical_bb_forum" name="the_champ_sharing[vertical_bb_forum]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_bb_forum'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_vertical_bb_forum"><?php _e('BBPress forum', 'super-socializer' ) ?></label>
								<br/>
								<input id="the_champ_vertical_bb_topic" name="the_champ_sharing[vertical_bb_topic]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_bb_topic'] ) ? 'checked = "checked"' : '';?> value="1" />
								<label for="the_champ_vertical_bb_topic"><?php _e('BBPress topic', 'super-socializer' ) ?></label>
								<?php
							}
							?>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_vertical_location_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Specify the pages where you want to enable vertical Sharing interface', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_vertical_count_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_vertical_counts"><?php _e("Show share counts", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_vertical_counts" name="the_champ_sharing[vertical_counts]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_counts'] ) ? 'checked = "checked"' : '';?> value="1" />
							<br/>
							<span style="font-size:12px"><?php _e( 'Share counts are supported for Facebook, Twitter, Linkedin, Buffer, Reddit, Pinterest, Stumbleupon, Odnoklassniki and Vkontakte', 'super-socializer' ) ?></span>
							</td>
						</tr>
						
						<tr id="the_champ_twitter_vertical_share_count" <?php echo isset( $theChampSharingOptions['vertical_counts'] ) ? '' : 'style="display:none"' ?>>
							<th>
							</th>
							<td>
							<input id="the_champ_vertical_newsharecounts" name="the_champ_sharing[vertical_tweet_count_service]" type="radio" <?php echo $tweetCountService == 'newsharecounts' ? 'checked = "checked"' : '';?> value="newsharecounts" /><label for="the_champ_vertical_newsharecounts"><?php echo sprintf( __( 'Use <a href="%s" target="_blank">NewShareCounts</a> to show Twitter share counts', 'super-socializer'), 'http://newsharecounts.com' ) ?></label>
							<br/>
							<span class="the_champ_help_content" style="display:block"><?php echo sprintf( __( 'For this to work, you have to enter your website url %s and sign in using Twitter at <a href="%s" target="_blank">their website</a>', 'super-socializer'), esc_url(home_url()), 'http://newsharecounts.com' ) ?></span>
							<br/>
							<input id="the_champ_vertical_opensharecount" name="the_champ_sharing[vertical_tweet_count_service]" type="radio" <?php echo $tweetCountService == 'opensharecount' ? 'checked = "checked"' : '';?> value="opensharecount" /><label for="the_champ_vertical_opensharecount"><?php echo sprintf( __( 'Use <a href="%s" target="_blank">OpenShareCount</a> to show Twitter share counts', 'super-socializer'), 'http://opensharecount.com' ) ?></label>
							<br/>
							<span class="the_champ_help_content" style="display:block"><?php echo sprintf( __( 'For this to work, you have to sign up and register your website url %s at <a href="%s" target="_blank">their website</a>', 'super-socializer'), esc_url(home_url()), 'http://opensharecount.com' ) ?></span>
							</td>
						</tr>

						<tr class="the_champ_help_content" id="the_champ_vertical_count_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, share counts are displayed above sharing icons.', 'super-socializer' ) ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_vertical_sharing_count.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_total_vertical_shares_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_total_vertical_shares"><?php _e("Show total shares", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_total_vertical_shares" name="the_champ_sharing[vertical_total_shares]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_total_shares'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_total_vertical_shares_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, total shares will be displayed with sharing icons', 'super-socializer' ) ?>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_vertical_total_shares.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_vmore_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_vmore"><?php _e("Enable 'More' icon", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_vmore" name="the_champ_sharing[vertical_more]" type="checkbox" <?php echo isset( $theChampSharingOptions['vertical_more'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_vmore_help_cont">
							<td colspan="2">
							<div>
							<?php _e('If enabled, "More" icon will be displayed after selected sharing icons which shows additional sharing networks in popup', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_mobile_sharing_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_mobile_sharing"><?php _e("Vertical floating bar responsiveness", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_mobile_sharing" name="the_champ_sharing[hide_mobile_sharing]" type="checkbox" <?php echo isset( $theChampSharingOptions['hide_mobile_sharing'] ) ? 'checked = "checked"' : '';?> value="1" /><label><?php echo sprintf( __( 'Display vertical interface only when screen is wider than %s pixels', 'super-socializer' ), '<input style="width:46px" name="the_champ_sharing[vertical_screen_width]" type="text" value="' . ( isset( $theChampSharingOptions['vertical_screen_width'] ) ? $theChampSharingOptions['vertical_screen_width'] : '' ) . '" />' ) ?></label>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_mobile_sharing_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Display vertical interface only when screen is wider than the width specified.', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_mobile_sharing_bottom_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_mobile_sharing_bottom"><?php _e("Horizontal floating bar responsiveness", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_mobile_sharing_bottom" name="the_champ_sharing[bottom_mobile_sharing]" type="checkbox" <?php echo isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? 'checked = "checked"' : '';?> value="1" /><label><?php echo sprintf( __( 'Stick vertical floating interface horizontally at bottom only when screen is narrower than %s pixels', 'super-socializer' ), '<input style="width:46px" name="the_champ_sharing[horizontal_screen_width]" type="text" value="' . ( isset( $theChampSharingOptions['horizontal_screen_width'] ) ? $theChampSharingOptions['horizontal_screen_width'] : '' ) . '" />' ) ?></label>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_mobile_sharing_bottom_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Stick vertical floating interface horizontally at bottom only when screen is narrower than the width specified', 'super-socializer' ) ?>
							<img src="<?php echo plugins_url('../images/snaps/ss_mobile_sharing.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tbody id="the_champ_bottom_sharing_options" <?php echo isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? '' : 'style="display: none"'; ?>>
							<tr>
								<th>
								<img id="the_champ_mobile_sharing_position_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
								<label for="the_champ_mobile_sharing_position"><?php _e("Horizontal floating bar position", 'super-socializer'); ?></label>
								</th>
								<td>
								<input type="radio" id="bottom_sharing_position_radio_nonresponsive" <?php echo $theChampSharingOptions['bottom_sharing_position_radio'] == 'nonresponsive' ? 'checked' : ''; ?> name="the_champ_sharing[bottom_sharing_position_radio]" value="nonresponsive" /><label for="bottom_sharing_position_radio_nonresponsive"><?php echo sprintf( __( '%s pixels from %s', 'super-socializer' ), '<input id="the_champ_mobile_sharing_position" style="width:46px" name="the_champ_sharing[bottom_sharing_position]" type="text" value="' . ( isset( $theChampSharingOptions['bottom_sharing_position'] ) ? $theChampSharingOptions['bottom_sharing_position'] : '' ) . '" />', '<select style="width:63px" name="the_champ_sharing[bottom_sharing_alignment]"><option value="right" ' . ( ! isset( $theChampSharingOptions['bottom_sharing_alignment'] ) || $theChampSharingOptions['bottom_sharing_alignment'] == 'right' ? 'selected' : '' ) . '>right</option><option value="left" ' . ( isset( $theChampSharingOptions['bottom_sharing_alignment'] ) && $theChampSharingOptions['bottom_sharing_alignment'] == 'left' ? 'selected' : '' ) . '>left</option></select>' ) ?></label><br/>
								<input type="radio" id="bottom_sharing_position_radio_responsive" <?php echo $theChampSharingOptions['bottom_sharing_position_radio'] == 'responsive' ? 'checked' : ''; ?> name="the_champ_sharing[bottom_sharing_position_radio]" value="responsive" /><label for="bottom_sharing_position_radio_responsive"><?php _e( 'Auto-adjust according to screen width (responsive)', 'super-socializer' ); ?></label>
								</td>
							</tr>
							
							<tr class="the_champ_help_content" id="the_champ_mobile_sharing_position_help_cont">
								<td colspan="2">
								<div>
								<?php _e('Alignment of horizontal floating interface. Number can be negative too.', 'super-socializer' ) ?>
								</div>
								</td>
							</tr>
						</tbody>


						</tbody>
					</table>
					</div>
				</div>
				</div>
				<?php include 'help.php'; ?>
			</div>

			<div class="menu_containt_div" id="tabs-4">
				<div class="clear"></div>
				<div class="the_champ_left_column">

				<div class="stuffbox">
					<h3><label><?php _e('Url shortener', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_surl_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_surl_enable"><?php _e("Use shortlinks already installed", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_surl_enable" name="the_champ_sharing[use_shortlinks]" type="checkbox" <?php echo isset( $theChampSharingOptions['use_shortlinks'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_surl_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Uses default short url permalinks without using any additional plugin', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_bitly_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_bitly_enable"><?php _e("Enable bit.ly url shortener for sharing", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_bitly_enable" name="the_champ_sharing[bitly_enable]" type="checkbox" <?php echo isset( $theChampSharingOptions['bitly_enable'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_bitly_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Master control to enable bit.ly url shortening for sharing', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_bitly_login_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_bitly_login"><?php _e("bit.ly Login", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_bitly_login" name="the_champ_sharing[bitly_username]" type="text" value="<?php echo isset( $theChampSharingOptions['bitly_username'] ) ? $theChampSharingOptions['bitly_username'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_bitly_login_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('More details on how to get it <a href="%s" target="_blank">here</a>', 'super-socializer' ), 'https://support.bitly.com/hc/en-us/articles/231140388-How-do-I-find-my-API-key-') ?><br/>
							<img width="550" src="<?php echo plugins_url('../images/snaps/ss_bitly_username.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>
						
						<tr>
							<th>
							<img id="the_champ_bitly_key_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_bitly_key"><?php _e("bit.ly API Key", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_bitly_key" name="the_champ_sharing[bitly_key]" type="text" value="<?php echo isset( $theChampSharingOptions['bitly_key'] ) ? $theChampSharingOptions['bitly_key'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_bitly_key_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('More details on how to get it <a href="%s" target="_blank">here</a>', 'super-socializer' ), 'https://support.bitly.com/hc/en-us/articles/231140388-How-do-I-find-my-API-key-') ?><br/>
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
					<h3><label><?php _e( 'Share Count Cache', 'super-socializer' ) ?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_share_count_cache_help" class="the_champ_help_bubble" src="<?php echo plugins_url( '../images/info.png', __FILE__ ) ?>" />
							<label for="the_champ_share_count_cache"><?php _e( "Refresh Share Count cache every", 'super-socializer' ) ?></label>
							</th>
							<td>
							<input style="width: 50px;" id="the_champ_share_count_cache" name="the_champ_sharing[share_count_cache_refresh_count]" type="text" value="<?php echo $theChampSharingOptions['share_count_cache_refresh_count']; ?>" />
							<select name="the_champ_sharing[share_count_cache_refresh_unit]">
								<option value="seconds" <?php echo $theChampSharingOptions['share_count_cache_refresh_unit'] == 'seconds' ? 'selected' : ''; ?>><?php _e('Second(s)', 'super-socializer') ?></option>
								<option value="minutes" <?php echo $theChampSharingOptions['share_count_cache_refresh_unit'] == 'minutes' ? 'selected' : ''; ?>><?php _e('Minute(s)', 'super-socializer') ?></option>
								<option value="hours" <?php echo $theChampSharingOptions['share_count_cache_refresh_unit'] == 'hours' ? 'selected' : ''; ?>><?php _e('Hour(s)', 'super-socializer') ?></option>
								<option value="days" <?php echo $theChampSharingOptions['share_count_cache_refresh_unit'] == 'days' ? 'selected' : ''; ?>><?php _e('Day(s)', 'super-socializer') ?></option>
							</select>
							</td>
						</tr>

						<tr class="the_champ_help_content" id="the_champ_share_count_cache_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('Frequent cache refreshing results in slower loading of pages with share counts enabled. Leave empty to disable cache. More info <a href="%s" target="_blank">here</a>', 'super-socializer'), 'http://support.heateor.com/why-is-share-count-not-getting-updated'); ?>
							</div>
							</td>
						</tr>

						<tr>
							<th style="width:215px">
							<img id="the_champ_clear_share_count_cache_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<input type="button" class="button-primary" value="<?php _e( 'Clear Share Counts Cache', 'super-socializer') ?>" onclick="heateorSsClearShareCountCache()" />
							</th>
							<td>
							<img src="<?php echo plugins_url('../images/ajax_loader.gif', __FILE__) ?>" id="share_count_cache_loading" style="display:none" />
							<div id="the_champ_share_count_cache_clear_message" style="color:green;display:none;"><?php _e('Share Counts cache cleared successfully.', 'super-socializer' ); ?></div>
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_clear_share_count_cache_help_cont">
							<td colspan="2">
							<div>
							<?php _e( 'Use this to clear cached share counts', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
					</table>
					</div>
				</div>

				<div class="stuffbox">
					<h3><label><?php _e('Language', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_sc_language_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_sc_language"><?php _e("Language", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_sc_language" name="the_champ_sharing[language]" type="text" value="<?php echo $theChampSharingOptions['language'] ? $theChampSharingOptions['language'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_sc_language_help_cont">
							<td colspan="2">
							<div>
							<?php echo sprintf(__('Enter the code of the language you want to use for like buttons. You can find the language codes at <a href="%s" target="_blank">this link</a>. Leave it empty for default language(English)', 'super-socializer' ), 'https://fbdevwiki.com/wiki/Locales#Complete_List_.28as_of_2012-06-10.29') ?>
							</div>
							</td>
						</tr>
					</table>
					</div>
				</div>

				<div class="stuffbox">
					<h3><label><?php _e('Username in sharing', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_twitter_username_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_twitter_username"><?php _e("Twitter username (without @)", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_twitter_username" name="the_champ_sharing[twitter_username]" type="text" value="<?php echo isset( $theChampSharingOptions['twitter_username'] ) ? $theChampSharingOptions['twitter_username'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_twitter_username_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Provided username will be appended after the content being shared as "via @USERNAME". Leave empty if you do not want any username in the content being shared.', 'super-socializer' ) ?>
							<br/><img width="550" src="<?php echo plugins_url('../images/snaps/ss_twitter_username.png', __FILE__); ?>" />
							</div>
							</td>
						</tr>

						<tr>
							<th>
							<img id="the_champ_buffer_username_help" class="the_champ_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
							<label for="the_champ_buffer_username"><?php _e("Buffer username (without @)", 'super-socializer' ); ?></label>
							</th>
							<td>
							<input id="the_champ_buffer_username" name="the_champ_sharing[buffer_username]" type="text" value="<?php echo isset( $theChampSharingOptions['buffer_username'] ) ? $theChampSharingOptions['buffer_username'] : '' ?>" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_buffer_username_help_cont">
							<td colspan="2">
							<div>
							<?php _e('Provided username will be appended after the content being shared as "via @USERNAME". Leave empty if you do not want any username in the content being shared.', 'super-socializer' ) ?>
							</div>
							</td>
						</tr>
					</table>
					</div>
				</div>

				<div class="stuffbox">
					<h3><label><?php _e( 'AMP', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<th>
							<img id="the_champ_amp_enable_help" class="the_champ_help_bubble" src="<?php echo plugins_url( '../images/info.png', __FILE__ ) ?>" />
							<label for="the_champ_amp_enable"><?php _e("Enable sharing on AMP pages", 'super-socializer'); ?></label>
							</th>
							<td>
							<input id="the_champ_amp_enable" name="the_champ_sharing[amp_enable]" type="checkbox" <?php echo isset( $theChampSharingOptions['amp_enable'] ) ? 'checked = "checked"' : '';?> value="1" />
							</td>
						</tr>
						
						<tr class="the_champ_help_content" id="the_champ_amp_enable_help_cont">
							<td colspan="2">
							<div>
							<?php _e( 'Enable this option to render sharing icons on AMP pages', 'super-socializer' ) ?>
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
				<div class="menu_containt_div" id="tabs-5">
					<div class="clear"></div>
					<div class="the_champ_left_column">
					<div class="stuffbox">
						<h3><label><?php _e('myCRED', 'super-socializer');?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
							<tr>
								<th>
								<img id="the_champ_mycred_referral_id_help" class="the_champ_help_bubble" src="<?php echo plugins_url( '../images/info.png', __FILE__ ) ?>" />
								<label for="the_champ_mycred_referral_id"><?php _e("Append myCRED referral ID to the urls being shared", 'super-socializer'); ?></label>
								</th>
								<td>
								<input id="the_champ_mycred_referral_id" name="the_champ_sharing[mycred_referral]" type="checkbox" <?php echo isset($theChampSharingOptions['mycred_referral']) ? 'checked = "checked"' : '';?> value="1" />
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

			<div class="menu_containt_div" id="tabs-6">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				<div class="stuffbox">
					<h3><label><?php _e('Shortcode & Widget', 'super-socializer' );?></label></h3>
					<div class="inside">
						<p><a style="text-decoration:none" href="http://support.heateor.com/social-sharing-shortcode-and-widget/" target="_blank"><?php _e('Shortcode & Widget', 'super-socializer' ) ?></a></p>
					</div>
				</div>
				</div>
				<?php include 'help.php'; ?>
			</div>
			
			<div class="menu_containt_div" id="tabs-7">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				<div class="stuffbox">
					<h3><label><?php _e('Facebook Sharing Troubleshooter', 'super-socializer' );?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
							<td>
							<?php _e('If Facebook sharing is not working fine, click at the following link and enter the problematic url (where Facebook sharing is not working properly) of your website in the text field. Click "Fetch New Scrape Information" button.', 'super-socializer' ) ?><br/>
							<a style="text-decoration: none" target="_blank" href="https://developers.facebook.com/tools/debug/og/object/">https://developers.facebook.com/tools/debug/og/object/</a>
							</td>
						</tr>
					</table>
					</div>
				</div>
				</div>
				<?php include 'help.php'; ?>
			</div>
			
			<div class="menu_containt_div" id="tabs-8">
				<div class="clear"></div>
				<div class="the_champ_left_column">
				<div class="stuffbox">
					<h3><label><?php _e('FAQ', 'super-socializer' ) ?></label></h3>
					<div class="inside faq">
						<p><?php _e('<strong>Note:</strong> Plugin will not work on local server. You should have an online website for the plugin to function properly.', 'super-socializer'); ?></p>
						<p>
						<a href="javascript:void(0)"><?php _e('Why is Instagram icon redirecting to Instagram website?', 'super-socializer'); ?></a>
						<div><?php _e('Instagram icon is there to send website visitors to the Instagram page of your choice. You can save the desired Instagram handle in "Instagram Username" option in "Standard Interface" and "Floating Interface" sections.', 'super-socializer'); ?></div>
						</p>
						<p><a href="http://support.heateor.com/place-title-social-share-icons-row/" target="_blank"><?php _e('How to Place Title and Social Share Icons in the Same Row?', 'super-socializer' ) ?></a></p>
						<p><a href="https://www.heateor.com/recover-social-share-counts/" target="_blank"><?php _e('How to restore Social Share counts lost after moving my website to SSL/Https?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/browser-blocking-social-features/" target="_blank"><?php _e('Why is my browser blocking some features of the plugin?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/color-share-icons-not-being-updated" target="_blank"><?php _e('Why the color of share icons is not being updated?', 'super-socializer') ?></a></p>
						<p><a href="http://support.heateor.com/why-is-sharer-not-showing-the-correct-image-title-and-other-meta-tags-content" target="_blank"><?php _e('Why is sharer not showing the correct image, title and other meta tags content?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/browser-blocking-social-features/" target="_blank"><?php _e('Why Facebook share counts are not appearing?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-can-i-show-share-counts-of-my-website-rather-than-of-individual-pagepost/" target="_blank"><?php _e('How can I show share counts of my website rather than of individual pages/posts?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-can-i-disable-social-sharing-on-particular-pagepost/" target="_blank"><?php _e('How can I disable sharing on particular page/post?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-can-i-specify-minimum-sharing-count-for-sharing-networks/" target="_blank"><?php _e('How can I specify minimum sharing count for sharing networks?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-to-share-specific-page/" target="_blank"><?php _e('How to share specific page?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-to-integrate-google-analytics-with-sharing" target="_blank"><?php _e('How to integrate Google Analytics with sharing?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-to-customize-the-look-of-total-share-counts" target="_blank"><?php _e('How to customize the look of total share counts?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-to-customize-the-look-of-individual-share-counts" target="_blank"><?php _e('How to customize the look of individual share counts?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-to-show-whatsapp-icon-only-on-mobile-devices" target="_blank"><?php _e('How to show Whatsapp icon only on mobile devices?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/how-to-hide-arrow-after-floating-sharing-bar" target="_blank"><?php _e( 'How to hide arrow after floating sharing bar?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/why-is-share-count-not-getting-updated" target="_blank"><?php _e( 'Why is share count not getting updated?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/why-is-there-so-much-space-between-like-buttons" target="_blank"><?php _e( 'Why is there so much space between like buttons?', 'super-socializer' ) ?></a></p>
						<p><a href="http://support.heateor.com/why-is-floating-share-like-button-not-appearing-at-homepage" target="_blank"><?php _e( 'Why are floating sharing/like buttons not appearing at homepage?', 'super-socializer' ) ?></a></p>
					</div>
				</div>

				</div>
				<?php include 'help.php'; ?>
			</div>
			
		</div>
		<div class="the_champ_clear"></div>
		<p class="submit">
			<input style="margin-left:8px" type="submit" name="save" class="button button-primary" value="<?php _e("Save Changes", 'super-socializer' ); ?>" />
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
