<?php
if( !defined('ABSPATH') ){ exit();}
global $current_user;
$auth_varble=0;
wp_get_current_user();
$imgpath= plugins_url()."/linkedin-auto-publish/images/";
$heimg=$imgpath."support.png";

require( dirname( __FILE__ ) . '/authorization.php' );


if(!$_POST && isset($_GET['lnap_notice']) && $_GET['lnap_notice'] == 'hide')	
{
	if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'],'lnap-shw')){
		wp_nonce_ays( 'lnap-shw');
		exit;
	}
	update_option('xyz_lnap_dnt_shw_notice', "hide");
	?>
<style type='text/css'>
#ln_notice_td
{
display:none !important;
}
</style>
<div class="system_notice_area_style1" id="system_notice_area">
Thanks again for using the plugin. We will never show the message again.
 &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php
}



$lms1="";
$lms2="";
$lerf=0;

if(isset($_POST['linkdn']))
{
	if (! isset( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'xyz_lnap_ln_settings_nonce' )
			) {
	
				wp_nonce_ays( 'xyz_lnap_ln_settings_nonce' );
	
				exit();
	
			}
	$lnappikeyold=get_option('xyz_lnap_lnapikey');
	$lnapisecretold=get_option('xyz_lnap_lnapisecret');


	$lnappikey=sanitize_text_field($_POST['xyz_lnap_lnapikey']);
	$lnapisecret=sanitize_text_field($_POST['xyz_lnap_lnapisecret']);
	
	$lmessagetopost=trim($_POST['xyz_lnap_lnmessage']);
	
	$lnposting_permission=intval($_POST['xyz_lnap_lnpost_permission']);
	$xyz_lnap_ln_shareprivate=intval($_POST['xyz_lnap_ln_shareprivate']);
	$xyz_lnap_ln_sharingmethod=intval($_POST['xyz_lnap_ln_sharingmethod']);
	if($lnappikey=="" && $lnposting_permission==1)
	{
		$lms1="Please fill linkedin api key";
		$lerf=1;
	}
	elseif($lnapisecret=="" && $lnposting_permission==1)
	{
		$lms2="Please fill linked api secret";
		$lerf=1;
	}
/* 	elseif($lmessagetopost=="" && $lnposting_permission==1)
	{
		$lms3="Please fill mssage format for posting.";
		$lerf=1;
	} */
	else
	{

		$lerf=0;
		
		/* if($lmessagetopost=="")
		{
			$lmessagetopost="New post added at {BLOG_TITLE} - {POST_TITLE}";
		} */
		
		if($lnappikey!=$lnappikeyold || $lnapisecret!=$lnapisecretold )
		{
			update_option('xyz_lnap_lnaf',1);
		}

		
		update_option('xyz_lnap_lnapikey',$lnappikey);
		update_option('xyz_lnap_lnapisecret',$lnapisecret);
		update_option('xyz_lnap_lnpost_permission',$lnposting_permission);
		update_option('xyz_lnap_ln_shareprivate',$xyz_lnap_ln_shareprivate);
		update_option('xyz_lnap_ln_sharingmethod',$xyz_lnap_ln_sharingmethod);
		update_option('xyz_lnap_lnmessage',$lmessagetopost);
		
}	
}

if(isset($_POST['linkdn']) && $lerf==0)
{
	?>

<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php }
if(isset($_GET['msg']) && $_GET['msg']==1)
{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Unable to authorize the linkedin application. Please check the details. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
	<?php 
}
if(isset($_GET['msg']) && $_GET['msg'] == 4){
	?>
<div class="system_notice_area_style1" id="system_notice_area">
Account has been authenticated successfully.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if(isset($_POST['linkdn']) && $lerf==1)
{
	?>
<div class="system_notice_area_style0" id="system_notice_area">
	<?php 
	 if(isset($_POST['linkdn']))
	{
		echo esc_html($lms1);echo esc_html($lms2);
	}
	?>
	&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php } ?>
<script type="text/javascript">
function detdisplay_lnap(id)
{
	document.getElementById(id).style.display='';
}
function dethide_lnap(id)
{
	document.getElementById(id).style.display='none';
}

function drpdisplay()
{
	var shmethod= document.getElementById('xyz_lnap_ln_sharingmethod').value;
	if(shmethod==1)	
	{
		document.getElementById('shareprivate').style.display="none";
	}
	else
	{
		document.getElementById('shareprivate').style.display="";
	}
}
</script>

<div style="width: 100%">

		
	<h2>
		 <img	src="<?php echo plugins_url()?>/linkedin-auto-publish/images/lnap.png" height="16px"> Linkedin Settings
	</h2>
	

<?php
$lnappikey=esc_html(get_option('xyz_lnap_lnapikey'));
$lnapisecret=esc_html(get_option('xyz_lnap_lnapisecret'));
$lmessagetopost=esc_textarea(get_option('xyz_lnap_lnmessage'));


$lnaf=get_option('xyz_lnap_lnaf');
	if($lnaf==1 && $lnappikey!="" && $lnapisecret!="" )
	{
	?>
	
	<span style="color:red; ">Application needs authorisation</span><br>	
            <form method="post" >
			 <?php wp_nonce_field( 'xyz_lnap_auth_nonce' );?>
			<input type="submit" class="submit_lnap_new" name="lnauth" value="Authorize	" />
			<br><br>
			</form>
			<?php  }
			else if($lnaf==0 && $lnappikey!="" && $lnapisecret!="" )
			{
				?>
            <form method="post" >
			<?php wp_nonce_field( 'xyz_lnap_auth_nonce' );?>
			<input type="submit" class="submit_lnap_new" name="lnauth" value="Reauthorize" title="Reauthorize the account" />
			<br><br>
			</form>
			<?php }

			?>
			
			<table class="widefat" style="width: 99%;background-color: #FFFBCC">
	<tr>
<td id="bottomBorderNone" style="border: 1px solid #FCC328;">
	
	<div>
		<b>Note :</b> You have to create a Linkedin application before filling the following details.
		<b><a href="https://www.linkedin.com/secure/developer?newapp" target="_blank">Click here</a></b> to create new Linkedin application. 
		<br>Specify the website url for the application as : 
		<span style="color: red;"><?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?></span>
		<br>Specify the authorized redirect url as :  
		<span style="color: red;"><?php echo  admin_url().'admin.php'; ?></span>
		<br>For detailed step by step instructions <b><a href="http://help.xyzscripts.com/docs/social-media-auto-publish/faq/how-can-i-create-linkedin-application/" target="_blank">Click here</a></b>.
		</div>
	
		</td>
		</tr>
	</table>
	<form method="post" >
<?php wp_nonce_field( 'xyz_lnap_ln_settings_nonce' );?>
	<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
	
	<table class="widefat xyz_lnap_widefat_table" style="width: 99%">
	<tr valign="top">
	<td width="50%">Client ID </td>					
	<td>
		<input id="xyz_lnap_lnapikey" name="xyz_lnap_lnapikey" type="text" value="<?php if($lms1=="") {echo esc_html(get_option('xyz_lnap_lnapikey'));}?>"/>
	<a href="http://help.xyzscripts.com/docs/social-media-auto-publish/faq/how-can-i-create-linkedin-application/" target="_blank">How can I create a Linkedin Application?</a>
	</td></tr>
	

	<tr valign="top"><td>Client secret</td>
	<td>
		<input id="xyz_lnap_lnapisecret" name="xyz_lnap_lnapisecret" type="text" value="<?php if($lms2=="") { echo esc_html(get_option('xyz_lnap_lnapisecret')); }?>" />
	</td></tr>
	
	<tr valign="top">
					<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay_lnap('xyz_ln')" onmouseout="dethide_lnap('xyz_ln')" style="width:13px;height:auto;">
						<div id="xyz_ln" class="lnap_informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.<br />{POST_ID} - Insert the ID of your post.
							<br />{POST_PUBLISH_DATE} - Insert the publish date of your post.
							<br />{USER_DISPLAY_NAME} - Insert the display name of the author.
						</div><br/><span style="color: #0073aa;">[Optional]</span></td>
	<td>
	<select name="xyz_lnap_info" id="xyz_lnap_info" onchange="xyz_lnap_info_insert(this)">
		<option value ="0" selected="selected">--Select--</option>
		<option value ="1">{POST_TITLE}  </option>
		<option value ="2">{PERMALINK} </option>
		<option value ="3">{POST_EXCERPT}  </option>
		<option value ="4">{POST_CONTENT}   </option>
		<option value ="5">{BLOG_TITLE}   </option>
		<option value ="6">{USER_NICENAME}   </option>
		<option value ="7">{POST_ID}   </option>
		<option value ="8">{POST_PUBLISH_DATE}   </option>
		<option value= "9">{USER_DISPLAY_NAME}</option>
		</select> </td></tr><tr><td>&nbsp;</td><td>
		<textarea id="xyz_lnap_lnmessage"  name="xyz_lnap_lnmessage" style="height:80px !important;" ><?php echo esc_textarea(get_option('xyz_lnap_lnmessage'));?></textarea>
	</td></tr>

				
	<tr valign="top" id="shareprivate">
	<input type="hidden" name="xyz_lnap_ln_sharingmethod" id="xyz_lnap_ln_sharingmethod" value="0">
	<td>Share post content with</td>
	<td  class="switch-field">
		<label id="xyz_lnap_ln_shareprivate_yes" ><input type="radio" name="xyz_lnap_ln_shareprivate" value="1" <?php  if(get_option('xyz_lnap_ln_shareprivate')==1) echo 'checked';?>/>Connections</label>
		<label id="xyz_lnap_ln_shareprivate_no" ><input type="radio" name="xyz_lnap_ln_shareprivate" value="0" <?php  if(get_option('xyz_lnap_ln_shareprivate')==0) echo 'checked';?>/>Public</label>
	</td>
	</tr>
	
	<tr valign="top"><td>Enable auto publish posts to my linkedin account</td>
		<td  class="switch-field">
			<label id="xyz_lnap_lnpost_permission_yes"><input type="radio" name="xyz_lnap_lnpost_permission" value="1" <?php  if(get_option('xyz_lnap_lnpost_permission')==1) echo 'checked';?>/>Yes</label>
			<label id="xyz_lnap_lnpost_permission_no"><input type="radio" name="xyz_lnap_lnpost_permission" value="0" <?php  if(get_option('xyz_lnap_lnpost_permission')==0) echo 'checked';?>/>No</label>
		</td>
	</tr>
	
		<tr>
			<td   id="bottomBorderNone"></td>
					<td   id="bottomBorderNone"><div style="height: 50px;">
							<input type="submit" class="submit_lnap_new"
								style=" margin-top: 10px; "
								name="linkdn" value="Save" /></div>
					</td>
				</tr>

</table>


</form>


	<?php 

	if(isset($_POST['bsettngs']))
	{
		if (! isset( $_REQUEST['_wpnonce'] )
				|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'xyz_lnap_basic_settings_nonce' )
				) {
		
					wp_nonce_ays( 'xyz_lnap_basic_settings_nonce' );
		
					exit();
		
				}
		$xyz_lnap_include_pages=intval($_POST['xyz_lnap_include_pages']);
// 		$xyz_lnap_utf_decode_enable=intval($_POST['xyz_lnap_utf_decode_enable']);
		$xyz_lnap_include_posts=intval($_POST['xyz_lnap_include_posts']);

		if($_POST['xyz_lnap_cat_all']=="All")
			$lnap_category_ids=$_POST['xyz_lnap_cat_all'];//redio btn name
		else if(isset($_POST['xyz_lnap_catlist']))
		{
			$lnap_category_ids=$_POST['xyz_lnap_catlist'];//dropdown
			$lnap_category_ids=implode(',', $lnap_category_ids);
		}
		$xyz_customtypes="";
		
        if(isset($_POST['post_types']))
		$xyz_customtypes=$_POST['post_types'];
        
        $xyz_lnap_peer_verification=intval($_POST['xyz_lnap_peer_verification']);
        $xyz_lnap_premium_version_ads=intval($_POST['xyz_lnap_premium_version_ads']);
        $xyz_lnap_default_selection_edit=intval($_POST['xyz_lnap_default_selection_edit']);
        
        
        //$xyz_lnap_future_to_publish=$_POST['xyz_lnap_future_to_publish'];
        $lnap_customtype_ids="";
        
        $xyz_lnap_applyfilters="";
        if(isset($_POST['xyz_lnap_applyfilters']))
        	$xyz_lnap_applyfilters=$_POST['xyz_lnap_applyfilters'];
        
        
        
        
		$lnap_customtype_ids="";

		if($xyz_customtypes!="")
		{
			for($i=0;$i<count($xyz_customtypes);$i++)
			{
				$lnap_customtype_ids.=$xyz_customtypes[$i].",";
			}

		}
		$lnap_customtype_ids=rtrim($lnap_customtype_ids,',');

		
		$xyz_lnap_applyfilters_val="";
		if($xyz_lnap_applyfilters!="")
		{
			for($i=0;$i<count($xyz_lnap_applyfilters);$i++)
			{
				$xyz_lnap_applyfilters_val.=$xyz_lnap_applyfilters[$i].",";
			}
		}
		$xyz_lnap_applyfilters_val=rtrim($xyz_lnap_applyfilters_val,',');
		
		update_option('xyz_lnap_apply_filters',$xyz_lnap_applyfilters_val);
		update_option('xyz_lnap_include_pages',$xyz_lnap_include_pages);
		
		update_option('xyz_lnap_include_posts',$xyz_lnap_include_posts);
		if($xyz_lnap_include_posts==0)
			update_option('xyz_lnap_include_categories',"All");
		else
			update_option('xyz_lnap_include_categories',$lnap_category_ids);
		update_option('xyz_lnap_include_customposttypes',$lnap_customtype_ids);
		update_option('xyz_lnap_peer_verification',$xyz_lnap_peer_verification);
		update_option('xyz_lnap_premium_version_ads',$xyz_lnap_premium_version_ads);
		update_option('xyz_lnap_default_selection_edit',$xyz_lnap_default_selection_edit);
// 		update_option('xyz_lnap_utf_decode_enable',$xyz_lnap_utf_decode_enable);
		//update_option('xyz_lnap_future_to_publish',$xyz_lnap_future_to_publish);
	}

	//$xyz_lnap_future_to_publish=get_option('xyz_lnap_future_to_publish');
	$xyz_credit_link=get_option('xyz_credit_link');
	$xyz_lnap_include_pages=get_option('xyz_lnap_include_pages');
	$xyz_lnap_include_posts=get_option('xyz_lnap_include_posts');
	$xyz_lnap_include_categories=get_option('xyz_lnap_include_categories');
	if ($xyz_lnap_include_categories!='All')
	$xyz_lnap_include_categories=explode(',', $xyz_lnap_include_categories);
	$xyz_lnap_include_customposttypes=get_option('xyz_lnap_include_customposttypes');
	$xyz_lnap_apply_filters=get_option('xyz_lnap_apply_filters');
	$xyz_lnap_peer_verification=get_option('xyz_lnap_peer_verification');
	$xyz_lnap_premium_version_ads=get_option('xyz_lnap_premium_version_ads');
	$xyz_lnap_default_selection_edit=get_option('xyz_lnap_default_selection_edit');
	//$xyz_lnap_utf_decode_enable=get_option('xyz_lnap_utf_decode_enable');
	?>
		<h2>Basic Settings</h2>


		<form method="post">
<?php wp_nonce_field( 'xyz_lnap_basic_settings_nonce' );?>
			<table class="widefat xyz_lnap_widefat_table" style="width: 99%">

				<tr valign="top">

					<td  colspan="1" width="50%">Publish wordpress `pages` to linkedin
					</td>
					<td  class="switch-field">
						<label id="xyz_lnap_include_pages_yes"><input type="radio" name="xyz_lnap_include_pages" value="1" <?php  if($xyz_lnap_include_pages==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_lnap_include_pages_no"><input type="radio" name="xyz_lnap_include_pages" value="0" <?php  if($xyz_lnap_include_pages==0) echo 'checked';?>/>No</label>
					</td>
				</tr>

				<tr valign="top">

					<td  colspan="1">Publish wordpress `posts` to linkedin
					</td>
					<td  class="switch-field">
						<label id="xyz_lnap_include_posts_yes"><input type="radio" name="xyz_lnap_include_posts" value="1" <?php  if($xyz_lnap_include_posts==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_lnap_include_posts_no"><input type="radio" name="xyz_lnap_include_posts" value="0" <?php  if($xyz_lnap_include_posts==0) echo 'checked';?>/>No</label>
					</td>
				</tr>
				
				<tr valign="top" id="selPostCat">

					<td  colspan="1">Select post categories for auto publish
					</td>
					<td class="switch-field">
	                <input type="hidden" value="<?php echo esc_html($xyz_lnap_include_categories);?>" name="xyz_lnap_sel_cat" 
			id="xyz_lnap_sel_cat"> 
					<label id="xyz_lnap_include_categories_no">
					<input type="radio"	name="xyz_lnap_cat_all" id="xyz_lnap_cat_all" value="All" onchange="rd_cat_chn(1,-1)" <?php if($xyz_lnap_include_categories=="All") echo "checked"?>>All<font style="padding-left: 10px;"></font></label>
					<label id="xyz_lnap_include_categories_yes">
					<input type="radio"	name="xyz_lnap_cat_all" id="xyz_lnap_cat_all" value=""	onchange="rd_cat_chn(1,1)" <?php if($xyz_lnap_include_categories!="All") echo "checked"?>>Specific</label>
					<br /> <br /> <div class="scroll_checkbox"  id="cat_dropdown_span">
					<?php 
					$args = array(
							'show_option_all'    => '',
							'show_option_none'   => '',
							'orderby'            => 'name',
							'order'              => 'ASC',
							'show_last_update'   => 0,
							'show_count'         => 0,
							'hide_empty'         => 0,
							'child_of'           => 0,
							'exclude'            => '',
							'echo'               => 0,
							'selected'           => '1 3',
							'hierarchical'       => 1,
							'id'                 => 'xyz_lnap_catlist',
							'class'              => 'postform',
							'depth'              => 0,
							'tab_index'          => 0,
							'taxonomy'           => 'category',
							'hide_if_empty'      => false );

					if(count(get_categories($args))>0)
					{
						$lnap_categories=get_categories();
						foreach ($lnap_categories as $lnap_cat)
						{
							$cat_id[]=$lnap_cat->cat_ID;
							$cat_name[]=$lnap_cat->cat_name;
							?>
							<input type="checkbox" name="xyz_lnap_catlist[]"  value="<?php  echo $lnap_cat->cat_ID;?>" <?php if(is_array($xyz_lnap_include_categories)) if(in_array($lnap_cat->cat_ID, $xyz_lnap_include_categories)) echo "checked"; ?>/><?php echo $lnap_cat->cat_name; ?>
							<br/><?php }
					}
					else
						echo "NIL";
					?><br /> <br /> </div>
					</td>
				</tr>


				<tr valign="top">

					<td  colspan="1">Select wordpress custom post types for auto publish</td>
					<td><?php 

					$args=array(
							'public'   => true,
							'_builtin' => false
					);
					$output = 'names'; // names or objects, note names is the default
					$operator = 'and'; // 'and' or 'or'
					$post_types=get_post_types($args,$output,$operator);

					$ar1=explode(",",$xyz_lnap_include_customposttypes);
					$cnt=count($post_types);
					foreach ($post_types  as $post_type ) {

						echo '<input type="checkbox" name="post_types[]" value="'.$post_type.'" ';
						if(in_array($post_type, $ar1))
						{
							echo 'checked="checked"/>';
						}
						else
							echo '/>';

						echo $post_type.'<br/>';

					}
					if($cnt==0)
						echo 'NA';
					?>
					</td>
				</tr>
				<tr valign="top">

					<td scope="row" colspan="1" width="50%">Default selection of auto publish while editing posts/pages/custom post types
					</td>
					<td  class="switch-field">
						<label id="xyz_lnap_default_selection_edit_yes"><input type="radio" name="xyz_lnap_default_selection_edit" value="1" <?php  if($xyz_lnap_default_selection_edit==1) echo 'checked';?>/>Enabled</label>
						<label id="xyz_lnap_default_selection_edit_no"><input type="radio" name="xyz_lnap_default_selection_edit" value="0" <?php  if($xyz_lnap_default_selection_edit==0) echo 'checked';?>/>Disabled</label>
					</td>
				</tr>

				<tr valign="top">
				
				<td scope="row" colspan="1" width="50%">Enable SSL peer verification in remote requests</td>
				<td  class="switch-field">
					<label id="xyz_lnap_peer_verification_yes"><input type="radio" name="xyz_lnap_peer_verification" value="1" <?php  if($xyz_lnap_peer_verification==1) echo 'checked';?>/>Yes</label>
					<label id="xyz_lnap_peer_verification_no"><input type="radio" name="xyz_lnap_peer_verification" value="0" <?php  if($xyz_lnap_peer_verification==0) echo 'checked';?>/>No</label>
				</td>
				</tr>
				
					<tr valign="top">
					<td scope="row" colspan="1">Apply filters during publishing	</td>
					<td>
					<?php 
					$ar2=explode(",",$xyz_lnap_apply_filters);
					for ($i=0;$i<3;$i++ ) {
						$filVal=$i+1;
						
						if($filVal==1)
							$filName='the_content';
						else if($filVal==2)
							$filName='the_excerpt';
						else if($filVal==3)
							$filName='the_title';
						else $filName='';
						
						echo '<input type="checkbox" name="xyz_lnap_applyfilters[]"  value="'.$filVal.'" ';
						if(in_array($filVal, $ar2))
						{
							echo 'checked="checked"/>';
						}
						else
							echo '/>';
					
						echo '<label>'.$filName.'</label><br/>';
					
					}
					
					?>
					</td>
				</tr>
			<!--  	<tr valign="top">

					<td  colspan="1" width="50%">Enable utf-8 decoding before publishing
					</td>
					<td  class="switch-field">
						<label id="xyz_lnap_utf_decode_enable_yes"><input type="radio" name="xyz_lnap_utf_decode_enable" value="1" <?php // if($xyz_lnap_utf_decode_enable==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_lnap_utf_decode_enable_no"><input type="radio" name="xyz_lnap_utf_decode_enable" value="0" <?php // if($xyz_lnap_utf_decode_enable==0) echo 'checked';?>/>No</label>
					</td>
				</tr> -->
	
				<tr valign="top">

					<td  colspan="1">Enable credit link to author
					</td>
					<td  class="switch-field">
						<label id="xyz_credit_link_yes"><input type="radio" name="xyz_credit_link" value="lnap" <?php  if($xyz_credit_link=='lnap') echo 'checked';?>/>Yes</label>
						<label id="xyz_credit_link_no"><input type="radio" name="xyz_credit_link" value="<?php echo $xyz_credit_link!='lnap'?$xyz_credit_link:0;?>" <?php  if($xyz_credit_link!='lnap') echo 'checked';?>/>No</label>
					</td>
				</tr>
				
				<tr valign="top">

					<td  colspan="1">Enable premium version ads
					</td>
					<td  class="switch-field">
						<label id="xyz_lnap_premium_version_ads_yes"><input type="radio" name="xyz_lnap_premium_version_ads" value="1" <?php  if($xyz_lnap_premium_version_ads==1) echo 'checked';?>/>Yes</label>
						<label id="xyz_lnap_premium_version_ads_no"><input type="radio" name="xyz_lnap_premium_version_ads" value="0" <?php  if($xyz_lnap_premium_version_ads==0) echo 'checked';?>/>No</label>
					</td>
				</tr>


				<tr>

					<td id="bottomBorderNone">
							

					</td>

					
<td id="bottomBorderNone"><div style="height: 50px;">
<input type="submit" class="submit_lnap_new" style="margin-top: 10px;"	value=" Update Settings" name="bsettngs" /></div></td>
				</tr>


			</table>
		</form>
		
		
</div>		
<?php if (is_array($xyz_lnap_include_categories))
$xyz_lnap_include_categories1=implode(',', $xyz_lnap_include_categories);
else 
	$xyz_lnap_include_categories1=$xyz_lnap_include_categories;
	?>
	<script type="text/javascript">
	//drpdisplay(); 
var catval='<?php echo esc_html($xyz_lnap_include_categories1); ?>';
var custtypeval='<?php echo esc_html($xyz_lnap_include_customposttypes); ?>';
var get_opt_cats='<?php echo esc_html(get_option('xyz_lnap_include_posts'));?>';
jQuery(document).ready(function() {
	  if(catval=="All")
		  jQuery("#cat_dropdown_span").hide();
	  else
		  jQuery("#cat_dropdown_span").show();

	  if(get_opt_cats==0)
		  jQuery('#selPostCat').hide();
	  else
		  jQuery('#selPostCat').show();
   var xyz_credit_link=jQuery("input[name='xyz_credit_link']:checked").val();
   if(xyz_credit_link=='lnap')
	   xyz_credit_link=1;
   else
	   xyz_credit_link=0;
   XyzLnapToggleRadio(xyz_credit_link,'xyz_credit_link');
   
   var xyz_lnap_cat_all=jQuery("input[name='xyz_lnap_cat_all']:checked").val();
   if (xyz_lnap_cat_all == 'All') 
	   xyz_lnap_cat_all=0;
   else 
	   xyz_lnap_cat_all=1;
   XyzLnapToggleRadio(xyz_lnap_cat_all,'xyz_lnap_include_categories'); 
  

   var toggle_element_ids=['xyz_lnap_ln_shareprivate','xyz_lnap_lnpost_permission','xyz_lnap_include_pages','xyz_lnap_include_posts','xyz_lnap_default_selection_edit','xyz_lnap_peer_verification','xyz_lnap_premium_version_ads'];

   jQuery.each(toggle_element_ids, function( index, value ) {
		   checkedval= jQuery("input[name='"+value+"']:checked").val();
		   XyzLnapToggleRadio(checkedval,value); 
   	});
	}); 
	
function setcat(obj)
{
var sel_str="";
for(k=0;k<obj.options.length;k++)
{
if(obj.options[k].selected)
sel_str+=obj.options[k].value+",";
}


var l = sel_str.length; 
var lastChar = sel_str.substring(l-1, l); 
if (lastChar == ",") { 
	sel_str = sel_str.substring(0, l-1);
}

document.getElementById('xyz_lnap_sel_cat').value=sel_str;

}

//var d1='<?php echo esc_html($xyz_lnap_include_categories1);?>';
//splitText = d1.split(",");
//jQuery.each(splitText, function(k,v) {
//jQuery("#xyz_lnap_catlist").children("option[value="+v+"]").attr("selected","selected");
//});

function rd_cat_chn(val,act)
{//xyz_lnap_cat_all xyz_lnap_cust_all 
	if(val==1)
	{
		if(act==-1)
		  jQuery("#cat_dropdown_span").hide();
		else
		  jQuery("#cat_dropdown_span").show();
	}
	
}

function xyz_lnap_info_insert(inf){
	
    var e = document.getElementById("xyz_lnap_info");
    var ins_opt = e.options[e.selectedIndex].text;
    if(ins_opt=="0")
    	ins_opt="";
    var str=jQuery("textarea#xyz_lnap_lnmessage").val()+ins_opt;
    jQuery("textarea#xyz_lnap_lnmessage").val(str);
    jQuery('#xyz_lnap_info :eq(0)').prop('selected', true);
    jQuery("textarea#xyz_lnap_lnmessage").focus();

}
function xyz_lnap_show_postCategory(val)
{
	if(val==0)
		jQuery('#selPostCat').hide();
	else
		jQuery('#selPostCat').show();
}
var toggle_element_ids=['xyz_lnap_ln_shareprivate','xyz_lnap_lnpost_permission','xyz_lnap_include_pages','xyz_lnap_include_posts','xyz_lnap_default_selection_edit','xyz_lnap_peer_verification','xyz_credit_link','xyz_lnap_premium_version_ads','xyz_lnap_include_categories'];

jQuery.each(toggle_element_ids, function( index, value ) {
	jQuery("#"+value+"_no").click(function(){
		XyzLnapToggleRadio(0,value);
		if(value=='xyz_lnap_include_posts')
			xyz_lnap_show_postCategory(0);
	});
	jQuery("#"+value+"_yes").click(function(){
		XyzLnapToggleRadio(1,value);
		if(value=='xyz_lnap_include_posts')
			xyz_lnap_show_postCategory(1);
	});
	});
</script>
	<?php 
?>