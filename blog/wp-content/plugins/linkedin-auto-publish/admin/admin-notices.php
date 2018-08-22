<?php
if( !defined('ABSPATH') ){ exit();}
function wp_lnap_admin_notice()
{
	add_thickbox();
	$sharelink_text_array_ln = array
						(
						"I use WP to LinkedIn Auto Publish wordpress plugin from @xyzscripts and you should too.",
						"WP to LinkedIn Auto Publish wordpress plugin from @xyzscripts is awesome",
						"Thanks @xyzscripts for developing such a wonderful LinkedIn auto publishing wordpress plugin",
						"I was looking for a LinkedIn publishing plugin and I found this. Thanks @xyzscripts",
						"Its very easy to use WP to LinkedIn Auto Publish wordpress plugin from @xyzscripts",
						"I installed WP to LinkedIn Auto Publish from @xyzscripts,it works flawlessly",
						"WP to LinkedIn Auto Publish wordpress plugin that i use works terrific",
						"I am using WP to LinkedIn Auto Publish wordpress plugin from @xyzscripts and I like it",
						"The WP to LinkedIn Auto Publish plugin from @xyzscripts is simple and works fine",
						"I've been using this LinkedIn plugin for a while now and it is really good",
						"WP to LinkedIn Auto Publish wordpress plugin is a fantastic plugin",
						"WP to LinkedIn Auto Publish wordpress plugin is easy to use and works great. Thank you!",
						"Good and flexible  WP to LinkedIn Auto publish plugin especially for beginners",
						"The best WP to LinkedIn Auto publish wordpress plugin I have used ! THANKS @xyzscripts",
						);
$sharelink_text_ln = array_rand($sharelink_text_array_ln, 1);
$sharelink_text_ln = $sharelink_text_array_ln[$sharelink_text_ln];
$xyz_lnap_link = admin_url('admin.php?page=linkedin-auto-publish-settings&lnap_blink=en');
$xyz_lnap_link = wp_nonce_url($xyz_lnap_link,'lnap-blk');
$xyz_lnap_notice = admin_url('admin.php?page=linkedin-auto-publish-settings&lnap_notice=hide');
$xyz_lnap_notice = wp_nonce_url($xyz_lnap_notice,'lnap-shw');
	echo '
	<script type="text/javascript">
			function xyz_lnap_shareon_tckbox(){
			tb_show("Share on","#TB_inline?width=500&amp;height=75&amp;inlineId=show_share_icons_ln&class=thickbox");
		}
	</script>
	<div id="lnap_notice_td" class="error" style="color: #666666;margin-left: 2px; padding: 5px;line-height:16px;">
	<p>Thank you for using <a href="https://wordpress.org/plugins/linkedin-auto-publish/" target="_blank"> WP to LinkedIn Auto Publish </a> plugin from <a href="https://xyzscripts.com/" target="_blank">xyzscripts.com</a>. Would you consider supporting us with the continued development of the plugin using any of the below methods?</p>
	<p>
	<a href="https://wordpress.org/support/plugin/linkedin-auto-publish/reviews" class="button xyz_rate_btn" target="_blank">Rate it 5★\'s on wordpress</a>';
	if(get_option('xyz_credit_link')=="0")
		echo '<a href="'.$xyz_lnap_link.'" class="button xyz_backlink_btn xyz_blink">Enable Backlink</a>';
	
	echo '<a class="button xyz_share_btn" onclick=xyz_lnap_shareon_tckbox();>Share on</a>
		<a href="https://xyzscripts.com/donate/5" class="button xyz_donate_btn" target="_blank">Donate</a>
	
	<a href="'.$xyz_lnap_notice.'" class="button xyz_show_btn">Don\'t Show This Again</a>
	</p>
	
	<div id="show_share_icons_ln" style="display: none;">
	<a class="button" style="background-color:#3b5998;color:white;margin-right:4px;margin-left:100px;margin-top: 25px;" href="http://www.facebook.com/sharer/sharer.php?u=https://xyzscripts.com/wordpress-plugins/linkedin-auto-publish/" target="_blank">Facebook</a>
	<a class="button" style="background-color:#00aced;color:white;margin-right:4px;margin-left:20px;margin-top: 25px;" href="http://twitter.com/share?url=https://xyzscripts.com/wordpress-plugins/linkedin-auto-publish/&text='.$sharelink_text_ln.'" target="_blank">Twitter</a>
	<a class="button" style="background-color:#007bb6;color:white;margin-right:4px;margin-left:20px;margin-top: 25px;" href="http://www.linkedin.com/shareArticle?mini=true&url=https://xyzscripts.com/wordpress-plugins/linkedin-auto-publish/" target="_blank">LinkedIn</a>
	<a class="button" style="background-color:#dd4b39;color:white;margin-right:4px;margin-left:20px;margin-top: 25px;" href="https://plus.google.com/share?&hl=en&url=https://xyzscripts.com/wordpress-plugins/linkedin-auto-publish/" target="_blank">google+</a>
	</div>
	</div>';
	
	
}
$lnap_installed_date = get_option('lnap_installed_date');
if ($lnap_installed_date=="") {
	$lnap_installed_date = time();
}
if($lnap_installed_date < ( time() - (30*24*60*60) ))
{
	if (get_option('xyz_lnap_dnt_shw_notice') != "hide")
	{
		add_action('admin_notices', 'wp_lnap_admin_notice');
	}
}
?>