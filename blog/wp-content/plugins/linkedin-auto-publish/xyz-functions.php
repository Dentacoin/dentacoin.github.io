<?php
if( !defined('ABSPATH') ){ exit();}

if(!function_exists('xyz_trim_deep'))
{

	function xyz_trim_deep($value) {
		if ( is_array($value) ) {
			$value = array_map('xyz_trim_deep', $value);
		} elseif ( is_object($value) ) {
			$vars = get_object_vars( $value );
			foreach ($vars as $key=>$data) {
				$value->{$key} = xyz_trim_deep( $data );
			}
		} else {
			$value = trim($value);
		}

		return $value;
	}

}

if(!function_exists('esc_textarea'))
{
	function esc_textarea($text)
	{
		$safe_text = htmlspecialchars( $text, ENT_QUOTES );
		return $safe_text;
	}
}

if(!function_exists('xyz_lnap_plugin_get_version'))
{
	function xyz_lnap_plugin_get_version()
	{
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_folder = get_plugins( '/' . plugin_basename( dirname( XYZ_LNAP_PLUGIN_FILE ) ) );
		// 		print_r($plugin_folder);
		return $plugin_folder['linkedin-auto-publish.php']['Version'];
	}
}


if(!function_exists('xyz_lnap_links')){
	function xyz_lnap_links($links, $file) {
		$base = plugin_basename(XYZ_LNAP_PLUGIN_FILE);
		if ($file == $base) {

			$links[] = '<a href="http://help.xyzscripts.com/docs/linkedin-auto-publish/faq/"  title="FAQ">FAQ</a>';
			$links[] = '<a href="http://help.xyzscripts.com/docs/linkedin-auto-publish/"  title="Read Me">README</a>';
			$links[] = '<a href="https://xyzscripts.com/support/" class="xyz_support" title="Support"></a>';
			$links[] = '<a href="http://twitter.com/xyzscripts" class="xyz_twitt" title="Follow us on twitter"></a>';
			$links[] = '<a href="https://www.facebook.com/xyzscripts" class="xyz_fbook" title="Facebook"></a>';
			$links[] = '<a href="https://plus.google.com/+Xyzscripts" class="xyz_gplus" title="+1"></a>';
			$links[] = '<a href="http://www.linkedin.com/company/xyzscripts" class="xyz_linkdin" title="Follow us on linkedIn"></a>';
		}
		return $links;
	}
}

if(!function_exists('xyz_lnap_string_limit')){
function xyz_lnap_string_limit($string, $limit) {

	$space=" ";$appendstr=" ...";
	if (function_exists('mb_strlen')) {
	if(mb_strlen($string) <= $limit) return $string;
	if(mb_strlen($appendstr) >= $limit) return '';
	$string = mb_substr($string, 0, $limit-mb_strlen($appendstr));
	$rpos = mb_strripos($string, $space);
	if ($rpos===false)
		return $string.$appendstr;
	else
		return mb_substr($string, 0, $rpos).$appendstr;
}
	else {
			if(strlen($string) <= $limit) return $string;
			if(strlen($appendstr) >= $limit) return '';
			$string = substr($string, 0, $limit-strlen($appendstr));
			$rpos = strripos($string, $space);
			if ($rpos===false)
				return $string.$appendstr;
				else
					return substr($string, 0, $rpos).$appendstr;
		}
}
}

if(!function_exists('xyz_lnap_getimage')){
function xyz_lnap_getimage($post_ID,$description_org)
{
	$attachmenturl="";
	$post_thumbnail_id = get_post_thumbnail_id( $post_ID );
	if($post_thumbnail_id!="")
	{
		$attachmenturl=wp_get_attachment_url($post_thumbnail_id);
		//$attachmentimage=wp_get_attachment_image_src( $post_thumbnail_id, full );

	}
	else {
		preg_match_all( '/< *img[^>]*src *= *["\']?([^"\']*)/is', $description_org, $matches );
		if(isset($matches[1][0]))
			$attachmenturl = $matches[1][0];
		else
		{
			apply_filters('the_content', $description_org);
		    preg_match_all( '/< *img[^>]*src *= *["\']?([^"\']*)/is', $description_org, $matches );
			if(isset($matches[1][0]))
				$attachmenturl = $matches[1][0];
		}


	}
	return $attachmenturl;
}

}

/* Local time formating */
if(!function_exists('xyz_lnap_local_date_time')){
	function xyz_lnap_local_date_time($format,$timestamp){
		return date($format, $timestamp + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ));
	}
}

add_filter( 'plugin_row_meta','xyz_lnap_links',10,2);

if (!function_exists("xyz_lnap_is_session_started")) {
function xyz_lnap_is_session_started()
{
   
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    
    return FALSE;
}
}

/*if (!function_exists("xyz_wp_smap_linkedin_attachment_metas")) {
	function xyz_wp_smap_linkedin_attachment_metas($contentln,$url)
	{
		$content_title='';$content_desc='';$utf="UTF-8";$content_img='';
		$aprv_me_data=wp_remote_get($url,array('sslverify'=> (get_option('xyz_lnap_peer_verification')=='1') ? true : false));
		if( is_array($aprv_me_data) ) {
			$aprv_me_data = $aprv_me_data['body']; // use the content
		}
		else {
			$aprv_me_data='';
		}

		$og_datas = new DOMDocument();
		@$og_datas->loadHTML('<?xml encoding="UTF-8">'.$aprv_me_data);
		$xpath = new DOMXPath($og_datas);
		if(isset($contentln['content']['title']))
		{
			$ogmetaContentAttributeNodes_tit = $xpath->query("/html/head/meta[@property='og:title']/@content");
			foreach($ogmetaContentAttributeNodes_tit as $ogmetaContentAttributeNode_tit) {
				$content_title=$ogmetaContentAttributeNode_tit->nodeValue;
			}
			if(get_option('xyz_lnap_utf_decode_enable')==1)
				$content_title=utf8_decode($content_title);
			// 			if(strcmp(get_option('blog_charset'),$utf)==0)
				// 				$content_title=utf8_decode($content_title);
			if($content_title!='')
				$contentln['content']['title']=$content_title;
		}
		if(isset($contentln['content']['description']))
		{
			$ogmetaContentAttributeNodes_desc = $xpath->query("/html/head/meta[@property='og:description']/@content");
			foreach($ogmetaContentAttributeNodes_desc as $ogmetaContentAttributeNode_desc) {
				$content_desc=$ogmetaContentAttributeNode_desc->nodeValue;
			}
			if(get_option('xyz_lnap_utf_decode_enable')==1)
				$content_desc=utf8_decode($content_desc);
			// 			if(strcmp(get_option('blog_charset'),$utf)==0)
				// 				$content_desc=utf8_decode($content_desc);
			if($content_desc!='')
				$contentln['content']['description']=$content_desc;
		}
		/*if(isset($contentln['content']['submitted-image-url']))
		 {
		$ogmetaContentAttributeNodes_img = $xpath->query("/html/head/meta[@property='og:image']/@content");
		foreach($ogmetaContentAttributeNodes_img as $ogmetaContentAttributeNode_img) {
		$content_img=$ogmetaContentAttributeNode_img->nodeValue;
		}
		if($content_img!='')
			$contentln['content']['submitted-image-url']=$content_img;
		}
		if(isset($contentln['content']['submitted-url']))
			$contentln['content']['submitted-url']=$url;

		return $contentln;
	}
}*/

?>