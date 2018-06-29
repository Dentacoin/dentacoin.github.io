<?php
defined('ABSPATH') or die("Cheating........Uh!!");
/**
 * File contains the functions necessary for Social Sharing functionality
 */

/**
 * Render sharing interface html.
 */
function the_champ_prepare_sharing_html( $postUrl, $sharingType = 'horizontal', $displayCount, $totalShares, $shareCountTransientId, $standardWidget = false ) {
	
	global $post, $theChampSharingOptions;

	if ( ( $sharingType == 'vertical' && !is_singular() ) || $standardWidget ) {
		$postTitle = get_bloginfo( 'name' ) . " - " . get_bloginfo( 'description' );
		if ( is_category() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_cat_title( '', false ) ), true ) );
		} elseif ( is_tag() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_tag_title( '', false ) ), true ) );
		} elseif ( is_tax() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_term_title( '', false ) ), true ) );
		} elseif ( is_search() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( __( 'Search for' ) .' "' .get_search_query() .'"' ), true ) );
		} elseif ( is_author() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ), true ) );
		} elseif ( is_archive() ) {
			if ( is_day() ) {
				$postTitle = esc_attr( wp_strip_all_tags( stripslashes( get_query_var( 'day' ) . ' ' .single_month_title( ' ', false ) . ' ' . __( 'Archives' ) ), true ) );
			} elseif ( is_month() ) {
				$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_month_title( ' ', false ) . ' ' . __( 'Archives' ) ), true ) );
			} elseif ( is_year() ) {
				$postTitle = esc_attr( wp_strip_all_tags( stripslashes( get_query_var( 'year' ) . ' ' . __( 'Archives' ) ), true ) );
			}
		}
	} else {
		$postTitle = $post->post_title;
	}

    $originalPostTitle = html_entity_decode($postTitle, ENT_QUOTES, 'UTF-8');
	$postTitle = heateor_ss_sanitize_post_title($postTitle);

	$output = apply_filters( 'the_champ_sharing_interface_filter', '', $postUrl, $sharingType, $theChampSharingOptions, $post, $displayCount, $totalShares );
	if ( $output != '' ) {
		return $output;
	}
	$html = '';
	
	$sharingMeta = get_post_meta( $post->ID, '_the_champ_meta', true );

	if ( isset( $theChampSharingOptions[$sharingType.'_re_providers'] ) ) {
		
		if ( the_champ_is_amp_page() ) {
			$sharingNetworks = heateor_ss_fetch_amp_sharing_networks();
		} else {
			$sharingNetworks = heateor_ss_fetch_sharing_networks();
		}

		$html = the_champ_is_amp_page() ? '' : '<ul ' . ( $sharingType == 'horizontal' && $theChampSharingOptions['hor_sharing_alignment'] == "center" ? "style='list-style: none;position: relative;left: 50%;'" : "" ) .' class="the_champ_sharing_ul">';
		$iconHeight = $theChampSharingOptions[$sharingType . '_sharing_shape'] != 'rectangle' ? $theChampSharingOptions[$sharingType . '_sharing_size'] : $theChampSharingOptions[$sharingType . '_sharing_height'];
		$style = 'style="width:' . ( $theChampSharingOptions[$sharingType . '_sharing_shape'] != 'rectangle' ? $theChampSharingOptions[$sharingType . '_sharing_size'] : $theChampSharingOptions[$sharingType . '_sharing_width'] ) . 'px;height:' . $iconHeight . 'px;';
		$counterContainerInitHtml = '<ss class="the_champ_square_count';
		$counterContainerEndHtml = '</ss>';
		$innerStyle = 'display:block;';
		$liClass = 'theChampSharingRound';
		if ( $theChampSharingOptions[$sharingType . '_sharing_shape'] == 'round' ) {
			$style .= 'border-radius:999px;';
			$innerStyle .= 'border-radius:999px;';
		} elseif ( $theChampSharingOptions[$sharingType . '_border_radius'] != '' ) {
			$style .= 'border-radius:' . $theChampSharingOptions[$sharingType . '_border_radius'] . 'px;';
		}
		if ( $sharingType == 'vertical' && $theChampSharingOptions[$sharingType . '_sharing_shape'] == 'square' ) {
			$style .= 'margin:0;';
			$liClass = '';
		}
		$style .= '"';
		$liItems = '';
		$language = $theChampSharingOptions['language'] != '' ? $theChampSharingOptions['language'] : '';
		$likeButtonCountContainer = '';
		if ( $displayCount ) {
			$likeButtonCountContainer = $counterContainerInitHtml . '">&nbsp;' . $counterContainerEndHtml;
		}

		// share count
		if ( $savedShareCount = heateor_ss_get_saved_share_counts( $shareCountTransientId, $postUrl ) ) {
			$shareCounts = $savedShareCount;
		} elseif ( false !== ( $cachedShareCount = heateor_ss_get_cached_share_count( $shareCountTransientId ) ) ) {
		    $shareCounts = $cachedShareCount;
		} else {
			$shareCounts = '&nbsp;';
		}

		$counterPlaceholder = '';
		$counterPlaceholderValue = '';
		$innerStyleConditional = '';

		if ( $displayCount ) {
			if ( ! isset( $theChampSharingOptions[$sharingType . '_counter_position'] ) ) {
				$counterPosition = $sharingType == 'horizontal' ? 'top' : 'inner_top';
			} else {
				$counterPosition = $theChampSharingOptions[$sharingType . '_counter_position'];
			}
			switch ( $counterPosition ) {
				case 'left':
					$innerStyleConditional = 'display:block;';
					$counterPlaceholder = '><i';
					break;
				case 'top':
					$counterPlaceholder = '><i';
					break;
				case 'right':
					$innerStyleConditional = 'display:block;';
					$counterPlaceholder = 'i><';
					break;
				case 'bottom':
					$innerStyleConditional = 'display:block;';
					$counterPlaceholder = 'i><';
					break;
				case 'inner_left':
					$innerStyleConditional = 'float:left;';
					$counterPlaceholder = '><ss';
					break;
				case 'inner_top':
					$innerStyleConditional = 'margin-top:0;';
					$counterPlaceholder = '><ss';
					break;
				case 'inner_right':
					$innerStyleConditional = 'float:left;';
					$counterPlaceholder = 'ss><';
					break;
				case 'inner_bottom':
					$innerStyleConditional = 'margin-top:0;';
					$counterPlaceholder = 'ss><';
					break;
				default:
			}
			$counterPlaceholderValue = str_replace( '>', '>' . $counterContainerInitHtml . ' the_champ_%network%_count">&nbsp;' . $counterContainerEndHtml, $counterPlaceholder );
		}
		
		$twitterUsername = $theChampSharingOptions['twitter_username'] != '' ? $theChampSharingOptions['twitter_username'] : '';
		$totalShareCount = 0;

		$toBeReplaced = array();
		$replaceBy = array();
		if(the_champ_is_amp_page()){
			$iconWidth = $theChampSharingOptions[$sharingType . '_sharing_shape'] != 'rectangle' ? $theChampSharingOptions[$sharingType . '_sharing_size'] : $theChampSharingOptions[$sharingType . '_sharing_width'];

			$toBeReplaced[] = '%width%';
			$toBeReplaced[] = '%height%';

			$replaceBy[] = $iconWidth;
			$replaceBy[] = $iconHeight;
		}

		$wpseoPostTitle = $postTitle;
		$decodedPostTitle = esc_html(str_replace(array('%23', '%27', '%22', '%21', '%3A'), array('#', "'", '"', '!', ':'), urlencode($originalPostTitle)));
		if($wpseoTwitterTitle = heateor_ss_wpseo_twitter_title($post)){
			$wpseoPostTitle = heateor_ss_sanitize_post_title($wpseoTwitterTitle);
			$decodedPostTitle = esc_html(str_replace(array('%23', '%27', '%22', '%21', '%3A'), array('#', "'", '"', '!', ':'), urlencode(html_entity_decode($wpseoTwitterTitle, ENT_QUOTES, 'UTF-8'))));
		}

		$shareCount = array();
		foreach ( $theChampSharingOptions[$sharingType.'_re_providers'] as $provider ) {
			$shareCount[$provider] = $shareCounts == '&nbsp;' ? '' : ( isset( $shareCounts[$provider] ) ? $shareCounts[$provider] : '' );
			$issetStartingShareCount = isset( $sharingMeta[$provider . '_' . $sharingType . '_count'] ) && intval($sharingMeta[$provider . '_' . $sharingType . '_count']) != 0 ? true : false;
			$totalShareCount += intval( $shareCount[$provider] ) + ($issetStartingShareCount ? $sharingMeta[$provider . '_' . $sharingType . '_count'] : 0) ;
			$sharingNetworks[$provider] = str_replace( $toBeReplaced, $replaceBy, $sharingNetworks[$provider] );
			$liItems .= str_replace(
				array(
					'%padding%',
					'%network%',
					'%ucfirst_network%',
					'%like_count_container%',
					'%encoded_post_url%',
					'%post_url%',
					'%post_title%',
					'%wpseo_post_title%',
					'%decoded_post_title%',
					'%twitter_username%',
					'%via_twitter_username%',
					'%language%',
					'%buffer_username%',
					'%style%',
					'%inner_style%',
					'%li_class%',
					$counterPlaceholder,
					'%title%'
				),
				array(
					( $theChampSharingOptions[$sharingType . '_sharing_shape'] == 'rectangle' ? $theChampSharingOptions[$sharingType . '_sharing_height'] : $theChampSharingOptions[$sharingType . '_sharing_size'] ) * 21/100,
					$provider,
					ucfirst( str_replace( array( ' ', '_', '.' ), '', $provider ) ),
					$likeButtonCountContainer,
					urlencode( $postUrl ),
					$postUrl,
					$postTitle,
					$wpseoPostTitle,
					$decodedPostTitle,
					$twitterUsername,
					$twitterUsername ? 'via=' . $twitterUsername . '&' : '',
					$language,
					$theChampSharingOptions['buffer_username'] != '' ? $theChampSharingOptions['buffer_username'] : '',
					$style,
					$innerStyle . ( $shareCount[$provider] || ($issetStartingShareCount && $shareCounts != '&nbsp;') ? $innerStyleConditional : '' ),
					$liClass,
					str_replace( '%network%', $provider, $issetStartingShareCount ? str_replace( '>&nbsp;', ' ss_st_count="' . $sharingMeta[$provider . '_' . $sharingType . '_count'] . '"' . ( $shareCounts == '&nbsp;' ? '>&nbsp;' : ' style="visibility:visible;' . ( $innerStyleConditional ? 'display:block;' : '' ) . '">' . heateor_ss_round_off_counts( $shareCount[$provider] + $sharingMeta[$provider . '_' . $sharingType . '_count'] ) ) , $counterPlaceholderValue ) : str_replace( '>&nbsp;', $shareCount[$provider] ? ' style="visibility:visible;' . ( $innerStyleConditional ? 'display:block;' : '' ) . '">' . heateor_ss_round_off_counts( $shareCount[$provider] ) : '>&nbsp;', $counterPlaceholderValue ) ),
					ucfirst( str_replace( '_', ' ', $provider ) )
				),
				$sharingNetworks[$provider]
			);
		}
		
		if(isset($theChampSharingOptions[$sharingType . '_more']) && !the_champ_is_amp_page()){
			$liItems .= '<li class="' . ( $liClass != '' ? $liClass : '' ) . '">';
			if ( $displayCount) {
				$liItems .= $counterContainerInitHtml . '">&nbsp;' . $counterContainerEndHtml;
			}
			$liItems .= '<i ' . $style . ' title="More" alt="More" class="theChampSharing theChampMoreBackground" onclick="theChampMoreSharingPopup(this, \'' . $postUrl . '\', \''.$postTitle.'\', \'' . heateor_ss_sanitize_post_title(heateor_ss_wpseo_twitter_title($post)) . '\')" ><ss style="display:block" class="theChampSharingSvg theChampMoreSvg"></ss></i></li>';
		}
		
		$totalSharesHtml = '';
		if ( $totalShares && ! the_champ_is_amp_page() ) {
			$totalSharesHtml = '<li class="' . $liClass . '">';
			if ( $displayCount) {
				$totalSharesHtml .= $counterContainerInitHtml . '">&nbsp;' . $counterContainerEndHtml;
			}
			if ( $sharingType == 'horizontal' ) {
				$addStyle = ';margin-left:9px !important;';
			} else {
				$addStyle = ';margin-bottom:9px !important;';
			}
			$addStyle .= ( $totalShareCount && $shareCounts != '&nbsp;' ? 'visibility:visible;' : '' ) . '"';
			$style = str_replace( ';"', $addStyle, $style );
			$totalSharesHtml .= '<i ' . $style . ' title="Total Shares" alt="Total Shares" class="theChampSharing theChampTCBackground">' . ( $totalShareCount ? '<div class="theChampTotalShareCount" style="font-size: ' . ( $iconHeight * 62/100 ) . 'px">' . heateor_ss_round_off_counts( $totalShareCount ) . '</div><div class="theChampTotalShareText" style="font-size: ' . ( $iconHeight * 38/100 ) . 'px">' . ( $totalShareCount < 2 ? __( 'Share', 'super-socializer' ) : __( 'Shares', 'super-socializer' ) ) . '</div>' : '' ) . '</i></li>';
		}

		if ( $sharingType == 'vertical' ) {
			$html .= $totalSharesHtml . $liItems;
		} else {
			$html .= $liItems . $totalSharesHtml;
		}

		$html .= the_champ_is_amp_page() ? '' : '</ul>';
		$html .= '<div style="clear:both"></div>';
	}
	return $html;
}

/**
 * Sanitize post title
 */
function heateor_ss_sanitize_post_title($postTitle){
	$postTitle = html_entity_decode($postTitle, ENT_QUOTES, 'UTF-8');
    $postTitle = rawurlencode($postTitle);
    $postTitle = str_replace('#', '%23', $postTitle);
    $postTitle = esc_html($postTitle);

    return $postTitle;
}

/**
 * Get Yoast SEO post meta Twitter title
 */
function heateor_ss_wpseo_twitter_title($post){
	if($post && heateor_ss_is_plugin_active('wordpress-seo/wp-seo.php') && class_exists('WPSEO_Meta') && ($wpseoTwitterTitle = WPSEO_Meta::get_value('twitter-title', $post->ID))){
		return $wpseoTwitterTitle;
	}
	return '';
}

/**
 * Roud off share counts
 */
function heateor_ss_round_off_counts($sharingCount){
	if ( $sharingCount > 999 && $sharingCount < 10000 ) {
		$sharingCount = round( $sharingCount/1000, 1 ) . 'K';
	} elseif ( $sharingCount > 9999 && $sharingCount < 100000 ) {
		$sharingCount = round( $sharingCount/1000, 1 ) . 'K';
	} else if ( $sharingCount > 99999 && $sharingCount < 1000000 ) {
		$sharingCount = round( $sharingCount/1000, 1 ) . 'K';
	} else if ( $sharingCount > 999999 ) {
		$sharingCount = round( $sharingCount/1000000, 1 ) . 'M';
	}

	return $sharingCount;
}

/**
 * Get cached share counts for given post ID
 */
function heateor_ss_get_cached_share_count($postId){
	$shareCountTransient = get_transient( 'heateor_ss_share_count_' . $postId );
	do_action( 'heateor_ss_share_count_transient_hook', $shareCountTransient, $postId );
	return $shareCountTransient;
}

/**
 * Render counter interface html.
 */
function the_champ_prepare_counter_html($postUrl, $sharingType = 'horizontal', $shortUrl, $standardWidget = false){
	global $theChampCounterOptions, $post;

	if ( ( $sharingType == 'vertical' && !is_singular() ) || $standardWidget ) {
		$postTitle = get_bloginfo( 'name' ) . " - " . get_bloginfo( 'description' );
		if ( is_category() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_cat_title( '', false ) ), true ) );
		} elseif ( is_tag() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_tag_title( '', false ) ), true ) );
		} elseif ( is_tax() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_term_title( '', false ) ), true ) );
		} elseif ( is_search() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( __( 'Search for' ) .' "' .get_search_query() .'"' ), true ) );
		} elseif ( is_author() ) {
			$postTitle = esc_attr( wp_strip_all_tags( stripslashes( get_the_author_meta( 'display_name', get_query_var( 'author' ) ) ), true ) );
		} elseif ( is_archive() ) {
			if ( is_day() ) {
				$postTitle = esc_attr( wp_strip_all_tags( stripslashes( get_query_var( 'day' ) . ' ' .single_month_title( ' ', false ) . ' ' . __( 'Archives' ) ), true ) );
			} elseif ( is_month() ) {
				$postTitle = esc_attr( wp_strip_all_tags( stripslashes( single_month_title( ' ', false ) . ' ' . __( 'Archives' ) ), true ) );
			} elseif ( is_year() ) {
				$postTitle = esc_attr( wp_strip_all_tags( stripslashes( get_query_var( 'year' ) . ' ' . __( 'Archives' ) ), true ) );
			}
		}
	} else {
		$postTitle = $post->post_title;
	}

	$originalPostTitle = html_entity_decode($postTitle, ENT_QUOTES, 'UTF-8');
	$decodedPostTitle = esc_html(str_replace(array('%23', '%27', '%22', '%21', '%3A'), array('#', "'", '"', '!', ':'), urlencode($originalPostTitle)));
	if($wpseoTwitterTitle = heateor_ss_wpseo_twitter_title($post)){
		$decodedPostTitle = esc_html(str_replace(array('%23', '%27', '%22', '%21', '%3A'), array('#', "'", '"', '!', ':'), urlencode(html_entity_decode($wpseoTwitterTitle, ENT_QUOTES, 'UTF-8'))));
	}
	$postTitle = heateor_ss_sanitize_post_title($postTitle);

	$shortUrl = (isset($theChampCounterOptions['use_shortlink']) && function_exists('wp_get_shortlink')) ? wp_get_shortlink() : $shortUrl;
	$output = apply_filters('the_champ_counter_interface_filter', '', $postUrl, $shortUrl, $sharingType, $theChampCounterOptions, $post);
	if($output != ''){
		return $output;
	}
	$html = '<div id="fb-root"></div>';
	if(isset($theChampCounterOptions[$sharingType.'_providers']) && is_array($theChampCounterOptions[$sharingType.'_providers'])){
		$html = '<ul '. ($sharingType == 'horizontal' && isset($theChampCounterOptions['hor_counter_alignment']) && $theChampCounterOptions['hor_counter_alignment'] == "center" ? "style='list-style: none;position: relative;left: 50%;'" : "") .' class="the_champ_sharing_ul">';
		$language = isset($theChampCounterOptions['language']) && $theChampCounterOptions['language'] != '' ? $theChampCounterOptions['language'] : '';
		foreach($theChampCounterOptions[$sharingType.'_providers'] as $provider){
			if($provider == 'facebook_share'){
				$html .= '<li class="the_champ_facebook_share"><div class="fb-share-button" data-href="'. $postUrl .'" data-layout="button_count"></div></li>';
			}elseif($provider == 'facebook_like'){
				$html .= '<li class="the_champ_facebook_like"><div class="fb-like" data-href="'. $postUrl .'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></li>';
			}elseif($provider == 'facebook_recommend'){
				$html .= '<li class="the_champ_facebook_recommend"><div class="fb-like" data-href="'. $postUrl .'" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div></li>';
			}elseif($provider == 'twitter_tweet'){
				$html .= '<li class="the_champ_twitter_tweet" heateor-ss-data-href="'. $postUrl .'"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'. $shortUrl .'" data-counturl="'. $postUrl .'" data-text="'. $decodedPostTitle .'" data-via="'. (isset($theChampCounterOptions['twitter_username']) && $theChampCounterOptions['twitter_username'] != '' ? $theChampCounterOptions['twitter_username'] : '') .'" data-lang="'. $language .'" >Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></li>';
			}elseif($provider == 'linkedin_share'){
				$html .= '<li class="the_champ_linkedin_share"><script src="//platform.linkedin.com/in.js" type="text/javascript">lang: '. $language .'</script><script type="IN/Share" data-url="' . $postUrl . '" data-counter="right"></script></li>';
			}elseif($provider == 'google_plusone'){
				$html .= '<li class="the_champ_google_plusone"><script type="text/javascript" src="https://apis.google.com/js/platform.js">{lang: "'. $language .'"}</script><div class="g-plusone" data-size="medium" data-href="'. $postUrl .'" data-callback="heateorSsmiGpCallback"></div></li>';
			}elseif($provider == 'pinterest_pin_it'){
				$html .= '<li class="the_champ_pinterest_pin"><a data-pin-lang="'. $language .'" href="//www.pinterest.com/pin/create/button/?url='. $postUrl .'" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a><script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script></li>';
			}elseif($provider == 'googleplus_share'){
				$html .= '<li class="the_champ_google_plus_share"><script type="text/javascript" src="https://apis.google.com/js/platform.js">{lang: "'. $language .'"}</script><div class="g-plus" data-action="share" data-annotation="bubble" data-href="'. $postUrl .'"></div></li>';
			}elseif($provider == 'reddit'){
				$html .= '<li class="the_champ_reddit"><script type="text/javascript" src="//www.reddit.com/static/button/button1.js"></script></li>';
			}elseif($provider == 'yummly'){
				$html .= '<li class="the_champ_yummly"><a href="//yummly.com" class="YUMMLY-YUM-BUTTON">Yum</a><script src="https://www.yummly.com/js/widget.js?general"></script></li>';
			}elseif($provider == 'buffer'){
				$html .= '<li class="the_champ_buffer"><a href="http://bufferapp.com/add" class="buffer-add-button" data-text="' . $postTitle . '" data-url="' . $postUrl . '" data-count="horizontal" data-via="'. (isset($theChampCounterOptions['buffer_username']) && $theChampCounterOptions['buffer_username'] != '' ? $theChampCounterOptions['buffer_username'] : '') .'" ></a><script type="text/javascript" src="https://d389zggrogs7qo.cloudfront.net/js/button.js"></script></li>';
			}elseif($provider == 'xing'){
				$html .= '<li class="the_champ_xing"><div data-type="XING/Share" data-counter="right" data-url="'. $postUrl .'" data-lang="'. $language .'"></div><script>(function (d, s) {var x = d.createElement(s), s = d.getElementsByTagName(s)[0]; x.src = "https://www.xing-share.com/js/external/share.js"; s.parentNode.insertBefore(x, s); })(document, "script");</script></li>';
			}elseif($provider == 'stumbleupon_badge'){
				$html .= '<li class="the_champ_stumbleupon"><su:badge layout="1" location="'. $postUrl .'"></su:badge><script type="text/javascript">(function() {var li = document.createElement(\'script\'); li.type = \'text/javascript\'; li.async = true;li.src = (\'https:\' == document.location.protocol ? \'https:\' : \'http:\') + \'//platform.stumbleupon.com/1/widgets.js\';var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(li, s);})();</script></li>';
			}
		}
		$html .= '</ul><div style="clear:both"></div>';
	}
	return $html;
}

function the_champ_generate_sharing_bitly_url($url, $postId = 0){
    global $theChampSharingOptions;
    $bitlyUrl = get_post_meta($postId, '_the_champ_ss_bitly_url', true);
    if($bitlyUrl){
    	return $bitlyUrl;
    }else{
	    //generate the URL
	    $bitly = 'http://api.bit.ly/v3/shorten?format=txt&login='. $theChampSharingOptions['bitly_username'] .'&apiKey='. $theChampSharingOptions['bitly_key'] .'&longUrl='.urlencode($url);
		$response = wp_remote_get( $bitly,  array( 'timeout' => 15 ) );
		if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
			$shortUrl = trim(wp_remote_retrieve_body( $response ));
			update_post_meta($postId, '_the_champ_ss_bitly_url', $shortUrl);
			return $shortUrl;
		}
	}
	return false;
}

function the_champ_generate_counter_bitly_url($url, $postId = 0){
    global $theChampCounterOptions;
    $bitlyUrl = get_post_meta($postId, '_the_champ_ss_bitly_url', true);
    if($bitlyUrl){
    	return $bitlyUrl;
    }else{
	    //generate the URL
	    $bitly = 'http://api.bit.ly/v3/shorten?format=txt&login='. $theChampCounterOptions['bitly_username'] .'&apiKey='. $theChampCounterOptions['bitly_key'] .'&longUrl='.urlencode($url);
		$response = wp_remote_get( $bitly,  array( 'timeout' => 15 ) );
		if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
			$shortUrl = trim(wp_remote_retrieve_body( $response ));
			update_post_meta($postId, '_the_champ_ss_bitly_url', $shortUrl);
			return $shortUrl;
		}
	}
	return false;
}

/**
 * Check if current page is AMP page
 */
function the_champ_is_amp_page(){
	if((function_exists('is_amp_endpoint') && is_amp_endpoint()) || (function_exists('ampforwp_is_amp_endpoint') && ampforwp_is_amp_endpoint())){
		return true;
	}
	return false;
}

/**
 * Generate short url for like buttons
 */
function the_champ_generate_like_buttons_short_url($originalUrl, $postId){
	global $theChampCounterOptions;
	$counterUrl = $originalUrl;
	if(isset($theChampCounterOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
		$counterUrl = wp_get_shortlink();
		// if bit.ly integration enabled, generate bit.ly short url
	}elseif(isset($theChampCounterOptions['bitly_enable']) && isset($theChampCounterOptions['bitly_username']) && isset($theChampCounterOptions['bitly_username']) && $theChampCounterOptions['bitly_username'] != '' && isset($theChampCounterOptions['bitly_key']) && $theChampCounterOptions['bitly_key'] != ''){
		$shortUrl = the_champ_generate_counter_bitly_url($originalUrl, $postId);
		if($shortUrl){
			$counterUrl = $shortUrl;
		}
	}

	return $counterUrl;
}

/**
 * Generate short url for share icons
 */
function the_champ_generate_social_sharing_short_url($originalUrl, $postId){
	global $theChampSharingOptions;
	$sharingUrl = $originalUrl;
	if(isset($theChampSharingOptions['use_shortlinks']) && function_exists('wp_get_shortlink')){
		$sharingUrl = wp_get_shortlink();
		// if bit.ly integration enabled, generate bit.ly short url
	}elseif(isset($theChampSharingOptions['bitly_enable']) && isset($theChampSharingOptions['bitly_username']) && $theChampSharingOptions['bitly_username'] != '' && isset($theChampSharingOptions['bitly_key']) && $theChampSharingOptions['bitly_key'] != ''){
		$shortUrl = the_champ_generate_sharing_bitly_url($originalUrl, $postId);
		if($shortUrl){
			$sharingUrl = $shortUrl;
		}
	}

	return $sharingUrl;
}

/**
 * Apply share url filter to customize share target url 
 */
function heateor_ss_apply_target_share_url_filter($postUrl, $sharingType = 'horizontal', $standardWidget = false){
	$postUrl = apply_filters('heateor_ss_target_share_url_filter', $postUrl, $sharingType, $standardWidget);
	return $postUrl;
}

/**
 * Apply like button url filter to customize like button target url 
 */
function heateor_ss_apply_target_like_button_url_filter($postUrl, $sharingType = 'horizontal', $standardWidget = false){
	$postUrl = apply_filters('heateor_ss_target_like_button_url_filter', $postUrl, $sharingType, $standardWidget);
	return $postUrl;
}

$theChampVerticalHomeCount = 0;
$theChampVerticalExcerptCount = 0;
$theChampVerticalCounterHomeCount = 0;
$theChampVerticalCounterExcerptCount = 0;
/**
 * Enable sharing interface at selected areas.
 */
function the_champ_render_sharing($content){
	global $theChampSharingOptions, $theChampCounterOptions;

	// if sharing is disabled on AMP, return content as is
	if(!isset($theChampSharingOptions['amp_enable']) && the_champ_is_amp_page()){
		return $content;
	}

	global $post;
	if(!$post){
		return $content;
	}
	// hook to bypass sharing
	$disable = apply_filters('the_champ_bypass_sharing', $post, $content);
	// if $disable value is 1, return content without sharing interface
	if($disable === 1){ return $content; }
	$sharingMeta = get_post_meta($post->ID, '_the_champ_meta', true);
	
	$sharingBpActivity = false;
	$counterBpActivity = false;
	if(current_filter() == 'bp_activity_entry_meta'){
		if(isset($theChampSharingOptions['bp_activity'])){
			$sharingBpActivity = true;
		}
		if(isset($theChampCounterOptions['bp_activity'])){
			$counterBpActivity = true;
		}
	}
	
	$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
	$post_types = array_diff( $post_types, array( 'post', 'page' ) );
	
	$customUrl = apply_filters('heateor_ss_custom_share_url', '', $post);

	if(isset($theChampCounterOptions['enable'])){
		//counter interface
		if(isset($theChampCounterOptions['hor_enable']) && !(isset($sharingMeta['counter']) && $sharingMeta['counter'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if($customUrl != ''){
				$counterPostUrl = $customUrl;
			}elseif($counterBpActivity){
				$counterPostUrl = bp_get_activity_thread_permalink();
			}elseif(isset($theChampCounterOptions['horizontal_target_url'])){
				if($theChampCounterOptions['horizontal_target_url'] == 'default'){
					$counterPostUrl = get_permalink($post->ID);
					if((isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) || $counterPostUrl == ''){
						$counterPostUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					}
				}elseif($theChampCounterOptions['horizontal_target_url'] == 'home'){
					$counterPostUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampCounterOptions['horizontal_target_url'] == 'custom'){
					$counterPostUrl = isset($theChampCounterOptions['horizontal_target_url_custom']) ? trim($theChampCounterOptions['horizontal_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$counterPostUrl = get_permalink($post->ID);
			}
			
			$counterPostUrl = heateor_ss_apply_target_like_button_url_filter($counterPostUrl, 'horizontal', false);

			$counterUrl = the_champ_generate_like_buttons_short_url($counterPostUrl, $postId);
			
			$sharingDiv = the_champ_prepare_counter_html($counterPostUrl, 'horizontal', $counterUrl);
			$sharingContainerStyle = '';
			$sharingTitleStyle = 'style="font-weight:bold"';
			if(isset($theChampCounterOptions['hor_counter_alignment'])){
				if($theChampCounterOptions['hor_counter_alignment'] == 'right'){
					$sharingContainerStyle = 'style="float: right"';
				}elseif($theChampCounterOptions['hor_counter_alignment'] == 'center'){
					$sharingContainerStyle = 'style="float: right;position: relative;left: -50%;text-align: left;"';
					$sharingTitleStyle = 'style="font-weight: bold;list-style: none;position: relative;left: 50%;"';
				}
			}
			$horizontalDiv = "<div style='clear: both'></div><div ". $sharingContainerStyle ." class='the_champ_counter_container the_champ_horizontal_counter'><div class='the_champ_counter_title' ". $sharingTitleStyle .">".ucfirst($theChampCounterOptions['title'])."</div>".$sharingDiv."</div><div style='clear: both'></div>";
			if($counterBpActivity){
				echo $horizontalDiv;
			}
			// show horizontal counter		
			if((isset($theChampCounterOptions['home']) && is_front_page()) || (isset( $theChampCounterOptions['category']) && is_category()) || (isset( $theChampCounterOptions['archive']) && is_archive()) || ( isset( $theChampCounterOptions['post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampCounterOptions['page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampCounterOptions['excerpt'] ) && (is_home() || current_filter() == 'the_excerpt') ) || ( isset( $theChampCounterOptions['bb_reply'] ) && current_filter() == 'bbp_get_reply_content' ) || ( isset( $theChampCounterOptions['bb_forum'] ) && (isset( $theChampCounterOptions['top'] ) && current_filter() == 'bbp_template_before_single_forum' || isset( $theChampCounterOptions['bottom'] ) && current_filter() == 'bbp_template_after_single_forum' )) || ( isset( $theChampCounterOptions['bb_topic'] ) && (isset( $theChampCounterOptions['top'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic')) || isset( $theChampCounterOptions['bottom'] ) && in_array(current_filter(), array('bbp_template_after_single_topic', 'bbp_template_after_lead_topic')) )) || (isset( $theChampCounterOptions['woocom_shop'] ) && current_filter() == 'woocommerce_after_shop_loop_item') || (isset( $theChampCounterOptions['woocom_product'] ) && current_filter() == 'woocommerce_share') || (isset( $theChampCounterOptions['woocom_thankyou'] ) && current_filter() == 'woocommerce_thankyou') || (current_filter() == 'bp_before_group_header' && isset($theChampCounterOptions['bp_group'])) ) {	
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bbp_template_after_single_topic', 'bbp_template_after_lead_topic', 'bbp_template_after_single_forum','woocommerce_after_shop_loop_item', 'woocommerce_share', 'woocommerce_thankyou', 'bp_before_group_header') ) ){
					echo '<div style="clear:both"></div>'.$horizontalDiv.'<div style="clear:both"></div>';
				}else{
					if(isset($theChampCounterOptions['top'] ) && isset($theChampCounterOptions['bottom'])){
						$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
					}else{
						if(isset($theChampCounterOptions['top'])){
							$content = $horizontalDiv.$content;
						}elseif(isset($theChampCounterOptions['bottom'])){
							$content = $content.$horizontalDiv;
						}
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampCounterOptions[$post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						if(isset($theChampCounterOptions['top'] ) && isset($theChampCounterOptions['bottom'])){
							$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
						}else{
							if(isset($theChampCounterOptions['top'])){
								$content = $horizontalDiv.$content;
							}elseif(isset($theChampCounterOptions['bottom'])){
								$content = $content.$horizontalDiv;
							}
						}
					}
				}
			}
		}
		if(isset($theChampCounterOptions['vertical_enable']) && !the_champ_is_amp_page() && !(isset($sharingMeta['vertical_counter']) && $sharingMeta['vertical_counter'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if($customUrl != ''){
				$counterPostUrl = $customUrl;
			}elseif(isset($theChampCounterOptions['vertical_target_url'])){
				if($theChampCounterOptions['vertical_target_url'] == 'default'){
					$counterPostUrl = get_permalink($post->ID);
					if(!is_singular()){
						$counterPostUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
						$postId = 0;
					}elseif((isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) || $counterPostUrl == ''){
						$counterPostUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					}
				}elseif($theChampCounterOptions['vertical_target_url'] == 'home'){
					$counterPostUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampCounterOptions['vertical_target_url'] == 'custom'){
					$counterPostUrl = isset($theChampCounterOptions['vertical_target_url_custom']) ? trim($theChampCounterOptions['vertical_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$counterPostUrl = get_permalink($post->ID);
			}

			$counterPostUrl = heateor_ss_apply_target_like_button_url_filter($counterPostUrl, 'vertical', false);
			
			$counterUrl = the_champ_generate_like_buttons_short_url($counterPostUrl, $postId);
			
			$sharingDiv = the_champ_prepare_counter_html($counterPostUrl, 'vertical', $counterUrl);
			$offset = (isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] != '' && isset($theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset']) ? $theChampCounterOptions['alignment'].': '. ( $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] == '' ? 0 : $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] ) .'px;' : '').(isset($theChampCounterOptions['top_offset']) ? 'top: '. ( $theChampCounterOptions['top_offset'] == '' ? 0 : $theChampCounterOptions['top_offset'] ) .'px;' : '');
			$verticalDiv = "<div class='the_champ_counter_container the_champ_vertical_counter" . ( isset( $theChampCounterOptions['hide_mobile_likeb'] ) ? ' the_champ_hide_sharing' : '' ) . "' style='". $offset . (isset($theChampCounterOptions['vertical_bg']) && $theChampCounterOptions['vertical_bg'] != '' ? 'background-color: '.$theChampCounterOptions['vertical_bg'] . ';' : '-webkit-box-shadow:none;box-shadow:none;') . "'>".$sharingDiv."</div>";
			// show vertical counter
			if((isset($theChampCounterOptions['vertical_home']) && is_front_page()) || (isset( $theChampCounterOptions['vertical_category']) && is_category()) || (isset( $theChampCounterOptions['vertical_archive']) && is_archive()) || ( isset( $theChampCounterOptions['vertical_post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampCounterOptions['vertical_page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampCounterOptions['vertical_excerpt'] ) && (is_home() || current_filter() == 'the_excerpt') ) || ( isset( $theChampCounterOptions['vertical_bb_forum'] ) && current_filter() == 'bbp_template_before_single_forum') || ( isset( $theChampCounterOptions['vertical_bb_topic'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic'))) || (current_filter() == 'bp_before_group_header' && isset($theChampCounterOptions['vertical_bp_group'])) ){
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bp_before_group_header') ) ){
					echo $verticalDiv;
				}else{
					if(is_front_page()){
						global $theChampVerticalCounterHomeCount, $theChampVerticalCounterExcerptCount;
						if(current_filter() == 'the_content'){
							$var = 'theChampVerticalCounterHomeCount';
						}elseif((is_home() || current_filter() == 'the_excerpt')){
							$var = 'theChampVerticalCounterExcerptCount';
						}
						if($$var == 0){
							if(isset($theChampCounterOptions['vertical_target_url']) && $theChampCounterOptions['vertical_target_url'] == 'default'){
								$counterPostUrl = esc_url(home_url());

								$counterPostUrl = heateor_ss_apply_target_like_button_url_filter($counterPostUrl, 'vertical', false);
								$counterUrl = the_champ_generate_like_buttons_short_url($counterPostUrl, 0);
								
								$sharingDiv = the_champ_prepare_counter_html($counterPostUrl, 'vertical', $counterUrl);
								$verticalDiv = "<div class='the_champ_counter_container the_champ_vertical_counter" . ( isset( $theChampCounterOptions['hide_mobile_likeb'] ) ? ' the_champ_hide_sharing' : '' ) . "' style='". $offset . (isset($theChampCounterOptions['vertical_bg']) && $theChampCounterOptions['vertical_bg'] != '' ? 'background-color: '.$theChampCounterOptions['vertical_bg'] . ';' : '-webkit-box-shadow:none;box-shadow:none;') . "'>".$sharingDiv."</div>";
							}
							$content = $content.$verticalDiv;
							$$var++;
						}
					}else{
						$content = $content.$verticalDiv;
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampCounterOptions['vertical_' . $post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						$content = $content . $verticalDiv;
					}
				}
			}
		}
	}

	if(isset($theChampSharingOptions['enable'])){
		// sharing interface
		if(isset($theChampSharingOptions['hor_enable']) && !(isset($sharingMeta['sharing']) && $sharingMeta['sharing'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if($customUrl != ''){
				$postUrl = $customUrl;
			}elseif($sharingBpActivity){
				$postUrl = bp_get_activity_thread_permalink();
				$postId = 0;
			}elseif(isset($theChampSharingOptions['horizontal_target_url'])){
				if($theChampSharingOptions['horizontal_target_url'] == 'default'){
					$postUrl = get_permalink($post->ID);
					if((isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) || $postUrl == ''){
						$postUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					}
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'home'){
					$postUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['horizontal_target_url_custom']) ? trim($theChampSharingOptions['horizontal_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$postUrl = get_permalink($post->ID);
			}
			
			$postUrl = heateor_ss_apply_target_share_url_filter( $postUrl, 'horizontal', false );

			$sharingUrl = the_champ_generate_social_sharing_short_url($postUrl, $postId);
			
			$shareCountTransientId = heateor_ss_get_share_count_transient_id($postUrl);
			$sharingDiv = the_champ_prepare_sharing_html($sharingUrl, 'horizontal', isset($theChampSharingOptions['horizontal_counts']), isset($theChampSharingOptions['horizontal_total_shares']), $shareCountTransientId);
			$sharingContainerStyle = '';
			$sharingTitleStyle = 'style="font-weight:bold"';
			if(isset($theChampSharingOptions['hor_sharing_alignment'])){
				if($theChampSharingOptions['hor_sharing_alignment'] == 'right'){
					$sharingContainerStyle = 'style="float: right"';
				}elseif($theChampSharingOptions['hor_sharing_alignment'] == 'center'){
					$sharingContainerStyle = 'style="float: right;position: relative;left: -50%;text-align: left;"';
					$sharingTitleStyle = 'style="font-weight: bold;list-style: none;position: relative;left: 50%;"';
				}
			}
			$horizontalDiv = "<div style='clear: both'></div><div ". $sharingContainerStyle ." class='the_champ_sharing_container the_champ_horizontal_sharing' " . ( the_champ_is_amp_page() ? '' : 'super-socializer-data-href="' . $postUrl . '"' ) . ( heateor_ss_get_cached_share_count($shareCountTransientId) === false || the_champ_is_amp_page() ? "" : 'super-socializer-no-counts="1"' ) . "><div class='the_champ_sharing_title' ". $sharingTitleStyle ." >".ucfirst($theChampSharingOptions['title'])."</div>".$sharingDiv."</div><div style='clear: both'></div>";
			if($sharingBpActivity){
				echo $horizontalDiv;
			}
			// show horizontal sharing
			if((isset($theChampSharingOptions['home']) && is_front_page()) || (isset( $theChampSharingOptions['category']) && is_category()) || (isset( $theChampSharingOptions['archive']) && is_archive()) || ( isset( $theChampSharingOptions['post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampSharingOptions['page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampSharingOptions['excerpt'] ) && (is_home() || current_filter() == 'the_excerpt') ) || ( isset( $theChampSharingOptions['bb_reply'] ) && current_filter() == 'bbp_get_reply_content' ) || ( isset( $theChampSharingOptions['bb_forum'] ) && (isset( $theChampSharingOptions['top'] ) && current_filter() == 'bbp_template_before_single_forum' || isset( $theChampSharingOptions['bottom'] ) && current_filter() == 'bbp_template_after_single_forum' )) || ( isset( $theChampSharingOptions['bb_topic'] ) && (isset( $theChampSharingOptions['top'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic')) || isset( $theChampSharingOptions['bottom'] ) && in_array(current_filter(), array('bbp_template_after_single_topic', 'bbp_template_after_lead_topic')) )) || (isset( $theChampSharingOptions['woocom_shop'] ) && current_filter() == 'woocommerce_after_shop_loop_item') || (isset( $theChampSharingOptions['woocom_product'] ) && current_filter() == 'woocommerce_share') || (isset( $theChampSharingOptions['woocom_thankyou'] ) && current_filter() == 'woocommerce_thankyou') || (current_filter() == 'bp_before_group_header' && isset($theChampSharingOptions['bp_group'])) ) {
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bbp_template_after_single_topic', 'bbp_template_after_lead_topic', 'bbp_template_after_single_forum', 'woocommerce_after_shop_loop_item', 'woocommerce_share', 'woocommerce_thankyou', 'bp_before_group_header') ) ){
					echo '<div style="clear:both"></div>'.$horizontalDiv.'<div style="clear:both"></div>';
				}else{
					if(isset($theChampSharingOptions['top'] ) && isset($theChampSharingOptions['bottom'])){
						$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
					}else{
						if(isset($theChampSharingOptions['top'])){
							$content = $horizontalDiv.$content;
						}elseif(isset($theChampSharingOptions['bottom'])){
							$content = $content.$horizontalDiv;
						}
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampSharingOptions[$post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						if(isset($theChampSharingOptions['top'] ) && isset($theChampSharingOptions['bottom'])){
							$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
						}else{
							if(isset($theChampSharingOptions['top'])){
								$content = $horizontalDiv.$content;
							}elseif(isset($theChampSharingOptions['bottom'])){
								$content = $content.$horizontalDiv;
							}
						}
					}
				}
			}
		}
		if(isset($theChampSharingOptions['vertical_enable']) && !the_champ_is_amp_page() && !(isset($sharingMeta['vertical_sharing']) && $sharingMeta['vertical_sharing'] == 1 && (!is_front_page() || (is_front_page() && 'page' == get_option('show_on_front'))) )){
			$postId = $post -> ID;
			if($customUrl != ''){
				$postUrl = $customUrl;
			}elseif(isset($theChampSharingOptions['vertical_target_url'])){
				if($theChampSharingOptions['vertical_target_url'] == 'default'){
					$postUrl = get_permalink($post->ID);
					if(!is_singular()){
						$postUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
						$postId = 0;
					}elseif((isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) || $postUrl == ''){
						$postUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
					}
				}elseif($theChampSharingOptions['vertical_target_url'] == 'home'){
					$postUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampSharingOptions['vertical_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['vertical_target_url_custom']) ? trim($theChampSharingOptions['vertical_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				$postUrl = get_permalink($post->ID);
			}
			
			$postUrl = heateor_ss_apply_target_share_url_filter($postUrl, 'vertical', false);

			$sharingUrl = the_champ_generate_social_sharing_short_url($postUrl, $postId);
			
			$shareCountTransientId = heateor_ss_get_share_count_transient_id($postUrl);
			$sharingDiv = the_champ_prepare_sharing_html($sharingUrl, 'vertical', isset($theChampSharingOptions['vertical_counts']), isset($theChampSharingOptions['vertical_total_shares']), $shareCountTransientId);
			$offset = (isset($theChampSharingOptions['alignment']) && $theChampSharingOptions['alignment'] != '' && isset($theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset']) && $theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'] != '' ? $theChampSharingOptions['alignment'].': '.$theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'].'px;' : '').(isset($theChampSharingOptions['top_offset']) && $theChampSharingOptions['top_offset'] != '' ? 'top: '.$theChampSharingOptions['top_offset'].'px;' : '');
			$verticalDiv = "<div class='the_champ_sharing_container the_champ_vertical_sharing" . ( isset( $theChampSharingOptions['hide_mobile_sharing'] ) ? ' the_champ_hide_sharing' : '' ) . ( isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? ' the_champ_bottom_sharing' : '' ) . "' style='width:" . ($theChampSharingOptions['vertical_sharing_size'] + 4) . "px;" . $offset . (isset($theChampSharingOptions['vertical_bg']) && $theChampSharingOptions['vertical_bg'] != '' ? 'background-color: '.$theChampSharingOptions['vertical_bg'] : '-webkit-box-shadow:none;box-shadow:none;') . "' " . ( the_champ_is_amp_page() ? '' : 'super-socializer-data-href="' . $postUrl . '"' ) . ( heateor_ss_get_cached_share_count( $shareCountTransientId ) === false || the_champ_is_amp_page() ? "" : 'super-socializer-no-counts="1"' ) . ">".$sharingDiv."</div>";
			// show vertical sharing
			if((isset($theChampSharingOptions['vertical_home']) && is_front_page()) || (isset( $theChampSharingOptions['vertical_category']) && is_category()) || (isset( $theChampSharingOptions['vertical_archive']) && is_archive()) || ( isset( $theChampSharingOptions['vertical_post'] ) && is_single() && isset($post -> post_type) && $post -> post_type == 'post' ) || ( isset( $theChampSharingOptions['vertical_page'] ) && is_page() && isset($post -> post_type) && $post -> post_type == 'page' ) || ( isset( $theChampSharingOptions['vertical_excerpt'] ) && (is_home() || current_filter() == 'the_excerpt') ) || ( isset( $theChampSharingOptions['vertical_bb_forum'] ) && current_filter() == 'bbp_template_before_single_forum') || ( isset( $theChampSharingOptions['vertical_bb_topic'] ) && in_array(current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic'))) || (current_filter() == 'bp_before_group_header' && isset($theChampSharingOptions['vertical_bp_group']))) {
				if( in_array( current_filter(), array('bbp_template_before_single_topic', 'bbp_template_before_lead_topic', 'bbp_template_before_single_forum', 'bp_before_group_header') ) ){
					echo $verticalDiv;
				}else{
					if(is_front_page()){
						global $theChampVerticalHomeCount, $theChampVerticalExcerptCount;
						if(current_filter() == 'the_content'){
							$var = 'theChampVerticalHomeCount';
						}elseif((is_home() || current_filter() == 'the_excerpt')){
							$var = 'theChampVerticalExcerptCount';
						}
						if($$var == 0){
							if(isset($theChampSharingOptions['vertical_target_url']) && $theChampSharingOptions['vertical_target_url'] == 'default'){
								$postUrl = esc_url(home_url());
								$postUrl = heateor_ss_apply_target_share_url_filter($postUrl, 'vertical', false);
								$sharingUrl = the_champ_generate_social_sharing_short_url($postUrl, 0);
								$shareCountTransientId = heateor_ss_get_share_count_transient_id($postUrl);
								$sharingDiv = the_champ_prepare_sharing_html($sharingUrl, 'vertical', isset($theChampSharingOptions['vertical_counts']), isset($theChampSharingOptions['vertical_total_shares']), $shareCountTransientId);
								$verticalDiv = "<div class='the_champ_sharing_container the_champ_vertical_sharing" . ( isset( $theChampSharingOptions['hide_mobile_sharing'] ) ? ' the_champ_hide_sharing' : '' ) . ( isset( $theChampSharingOptions['bottom_mobile_sharing'] ) ? ' the_champ_bottom_sharing' : '' ) . "' style='width:" . ($theChampSharingOptions['vertical_sharing_size'] + 4) . "px;" . $offset . (isset($theChampSharingOptions['vertical_bg']) && $theChampSharingOptions['vertical_bg'] != '' ? 'background-color: '.$theChampSharingOptions['vertical_bg'] : '-webkit-box-shadow:none;box-shadow:none;') . "' " . ( the_champ_is_amp_page() ? '' : 'super-socializer-data-href="' . $postUrl . '"' ) . ( heateor_ss_get_cached_share_count($shareCountTransientId) === false || the_champ_is_amp_page() ? "" : 'super-socializer-no-counts="1"' ) . ">".$sharingDiv."</div>";
							}
							$content = $content.$verticalDiv;
							$$var++;
						}
					}else{
						$content = $content.$verticalDiv;
					}
				}
			} elseif( count( $post_types ) ) {
				foreach ( $post_types as $post_type ) {
					if( isset( $theChampSharingOptions['vertical_' . $post_type] ) && ( is_single() || is_page() ) && isset($post -> post_type) && $post -> post_type == $post_type ) {
						$content = $content . $verticalDiv;
					}
				}
			}
		}
	}
	return $content;
}

add_filter('the_content', 'the_champ_render_sharing', 99);
add_filter('the_excerpt', 'the_champ_render_sharing', 99);
if(isset($theChampSharingOptions['bp_activity']) || isset($theChampCounterOptions['bp_activity'])){
	add_action('bp_activity_entry_meta', 'the_champ_render_sharing', 999);
}
if(isset($theChampSharingOptions['bp_group']) || isset($theChampSharingOptions['vertical_bp_group']) || isset($theChampCounterOptions['bp_group']) || isset($theChampCounterOptions['vertical_bp_group'])){
	add_action('bp_before_group_header', 'the_champ_render_sharing');
}
add_filter('bbp_get_reply_content', 'the_champ_render_sharing');
add_filter('bbp_template_before_single_forum', 'the_champ_render_sharing');
add_filter('bbp_template_before_single_topic', 'the_champ_render_sharing');
add_filter('bbp_template_before_lead_topic', 'the_champ_render_sharing');
add_filter('bbp_template_after_single_forum', 'the_champ_render_sharing');
add_filter('bbp_template_after_single_topic', 'the_champ_render_sharing');
add_filter('bbp_template_after_lead_topic', 'the_champ_render_sharing');
// Sharing at WooCommerce pages
if(isset($theChampSharingOptions['woocom_shop']) || isset($theChampCounterOptions['woocom_shop'])){
	add_action('woocommerce_after_shop_loop_item', 'the_champ_render_sharing');
}
if(isset($theChampSharingOptions['woocom_product']) || isset($theChampCounterOptions['woocom_product'])){
	add_action('woocommerce_share', 'the_champ_render_sharing');
}
if(isset($theChampSharingOptions['woocom_thankyou']) || isset($theChampCounterOptions['woocom_thankyou'])){
	add_action('woocommerce_thankyou', 'the_champ_render_sharing');
}

/**
 * Remove render sharing action from Excerpts, as it gets nasty due to strip_tags()
 */
function the_champ_remove_render_sharing($content){
	if(is_home()){
		remove_action('the_content', 'the_champ_render_sharing', 99);
	}
	return $content;
}
add_filter('get_the_excerpt', 'the_champ_remove_render_sharing', 9);

/**
 * Get sharing count for providers
 */
function the_champ_sharing_count(){
	if(isset($_GET['urls']) && is_array($_GET['urls']) && count($_GET['urls']) > 0){
		$targetUrls = array_unique($_GET['urls']);
		foreach($targetUrls as $k => $v){
			if(heateor_ss_validate_url($v) !== false){
				$targetUrls[$k] = trim($v);
			}
		}
	}else{
		the_champ_ajax_response(array('status' => 0, 'message' => __('Invalid request')));
	}
	global $theChampSharingOptions;
	$horizontalSharingNetworks = isset($theChampSharingOptions['horizontal_re_providers']) ? $theChampSharingOptions['horizontal_re_providers'] : array();
	$verticalSharingNetworks = isset($theChampSharingOptions['vertical_re_providers']) ? $theChampSharingOptions['vertical_re_providers'] : array();
	$sharingNetworks = array_unique(array_merge($horizontalSharingNetworks, $verticalSharingNetworks));
	if(count($sharingNetworks) == 0){
		the_champ_ajax_response(array('status' => 0, 'message' => __('Providers not selected')));
	}

	$tweetCountService = 'newsharecounts';
	if ( isset( $theChampSharingOptions['tweet_count_service'] ) ) {
		$tweetCountService = $theChampSharingOptions['tweet_count_service'];
	} elseif ( isset( $theChampSharingOptions['vertical_tweet_count_service'] ) ) {
		$tweetCountService = $theChampSharingOptions['vertical_tweet_count_service'];
	}

	if ( $tweetCountService == 'opensharecount' ) {
		$twitterCountApi = 'http://opensharecount.com/count.json?url=';
	} elseif ( $tweetCountService == 'newsharecounts' ) {
		$twitterCountApi = 'http://public.newsharecounts.com/count.json?url=';
	}

	$responseData = array();
	$ajaxResponse = array();
	if(in_array('facebook', $sharingNetworks)){
		$ajaxResponse['facebook'] = 1;
	}
	$multiplier = 60;
	if ( $theChampSharingOptions['share_count_cache_refresh_count'] != '' ) {
		switch ( $theChampSharingOptions['share_count_cache_refresh_unit'] ) {
			case 'seconds':
				$multiplier = 1;
				break;

			case 'minutes':
				$multiplier = 60;
				break;
			
			case 'hours':
				$multiplier = 3600;
				break;

			case 'days':
				$multiplier = 3600*24;
				break;

			default:
				$multiplier = 60;
				break;
		}
		$transientExpirationTime = $multiplier * $theChampSharingOptions['share_count_cache_refresh_count'];
	}
	$targetUrlsArray = array();
	$targetUrlsArray[] = $targetUrls;
	$targetUrlsArray = apply_filters('heateor_ss_target_share_urls', $targetUrlsArray);
	$shareCountTransientArray = array();
	if(in_array('facebook', $sharingNetworks)){
		$ajaxResponse['facebook_urls'] = $targetUrlsArray;
	}
	foreach($targetUrlsArray as $targetUrls){
		$shareCountTransients = array();
		foreach($targetUrls as $targetUrl){
			$shareCountTransient = array();
			foreach($sharingNetworks as $provider){
				switch($provider){
					case 'twitter':
						$url = $twitterCountApi . $targetUrl;
						break;
					case 'linkedin':
						$url = 'http://www.linkedin.com/countserv/count/share?url='. $targetUrl .'&format=json';
						break;
					case 'reddit':
						$url = 'http://www.reddit.com/api/info.json?url='. $targetUrl;
						break;
					case 'pinterest':
						$url = 'http://api.pinterest.com/v1/urls/count.json?callback=theChamp&url='. $targetUrl;
						break;
					case 'buffer':
						$url = 'https://api.bufferapp.com/1/links/shares.json?url='. $targetUrl;
						break;
					case 'stumbleupon':
						$url = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='. $targetUrl;
						break;
					case 'vkontakte':
						$url = 'https://vk.com/share.php?act=count&url='. $targetUrl;
						break;
					case 'Odnoklassniki':
						$url = 'https://connect.ok.ru/dk?st.cmd=extLike&tp=json&ref='. $targetUrl;
						break;
					default:
						$url = '';
				}
				if($url == ''){ continue; }
				$response = wp_remote_get($url,  array('timeout' => 15, 'user-agent'  => 'Super-Socializer'));
				if(!is_wp_error($response) && isset($response['response']['code']) && 200 === $response['response']['code']){
					$body = wp_remote_retrieve_body($response);
					if($provider == 'pinterest'){
						$body = str_replace(array('theChamp(', ')'), '', $body);
					}
					if(!in_array($provider, array('google', 'vkontakte'))){
						$body = json_decode($body);
					}
					switch($provider){
						case 'twitter':
							if (!empty($body -> count)){
								$shareCountTransient['twitter'] = $body -> count;
							}else{
								$shareCountTransient['twitter'] = 0;
							}
							break;
						case 'linkedin':
							if(!empty($body -> count)){
								$shareCountTransient['linkedin'] = $body -> count;
							}else{
								$shareCountTransient['linkedin'] = 0;
							}
							break;
						case 'reddit':
							$shareCountTransient['reddit'] = 0;
							if(!empty($body -> data -> children)){
								$children = $body -> data -> children;
								$ups = $downs = 0;
								foreach($children as $child){
					                $ups += (int) $child->data->ups;
					                $downs += (int) $child->data->downs;
					            }
					            $score = $ups - $downs;
					            if($score < 0){
					            	$score = 0;
					            }
								$shareCountTransient['reddit'] = $score;
							}
							break;
						case 'pinterest':
							if(!empty($body -> count)){
								$shareCountTransient['pinterest'] = $body -> count;
							}else{
								$shareCountTransient['pinterest'] = 0;
							}
							break;
						case 'buffer':
							if(!empty($body -> shares)){
								$shareCountTransient['buffer'] = $body -> shares;
							}else{
								$shareCountTransient['buffer'] = 0;
							}
							break;
						case 'stumbleupon':
							if(!empty($body -> result) && isset($body -> result -> views)){
								$shareCountTransient['stumbleupon'] = $body -> result -> views;
							}else{
								$shareCountTransient['stumbleupon'] = 0;
							}
							break;
						case 'vkontakte':
							if(!empty($body)){
								$shareCountTransient['vkontakte'] = (int) str_replace(array('VK.Share.count(0, ', ');'), '', $body);
							}else{
								$shareCountTransient['vkontakte'] = 0;
							}
							break;
						case 'Odnoklassniki':
							if(!empty($body) && isset($body->count)){
								$shareCountTransient['Odnoklassniki'] = $body->count;
							}else{
								$shareCountTransient['Odnoklassniki'] = 0;
							}
							break;
					}
				}else{
					$shareCountTransient[$provider] = 0;
				}
			}  
			$shareCountTransients[] = $shareCountTransient;
		}
		$shareCountTransientArray[] = $shareCountTransients;
	}

	$finalShareCountTransient = array();
	for($i = 0; $i < count($targetUrlsArray[0]); $i++){
		$finalShareCountTransient = $shareCountTransientArray[0][$i];
		for($j = 1; $j < count($shareCountTransientArray); $j++){
			foreach($finalShareCountTransient as $key => $val){
				$finalShareCountTransient[$key] += $shareCountTransientArray[$j][$i][$key];
			}
		}
		$responseData[$targetUrlsArray[0][$i]] = $finalShareCountTransient;
		if ( $theChampSharingOptions['share_count_cache_refresh_count'] != '' ) {
			set_transient('heateor_ss_share_count_' . heateor_ss_get_share_count_transient_id($targetUrlsArray[0][$i]), $finalShareCountTransient, $transientExpirationTime);
			// update share counts saved in the database
			heateor_ss_update_share_counts($targetUrlsArray[0][$i], $finalShareCountTransient);
		}
	}

	do_action('heateor_ss_share_count_ajax_hook', $responseData);
	
	$ajaxResponse['status'] = 1;
	$ajaxResponse['message'] = $responseData;
	
	the_champ_ajax_response($ajaxResponse);
}

add_action('wp_ajax_the_champ_sharing_count', 'the_champ_sharing_count');
add_action('wp_ajax_nopriv_the_champ_sharing_count', 'the_champ_sharing_count');

/**
 * Save share counts in post-meta
 */
function heateor_ss_update_share_counts($targetUrl, $shareCounts){
	$postId = heateor_ss_get_share_count_transient_id($targetUrl);

	if(!isset($shareCounts['facebook'])){
		$savedShareCounts = heateor_ss_get_saved_share_counts( $postId, $targetUrl );
		$facebookShares = $savedShareCounts['facebook'];
		$shareCounts['facebook'] = $facebookShares;
	}

	if($postId == 'custom'){
		update_option('heateor_ss_custom_url_shares', maybe_serialize($shareCounts));
	}elseif($targetUrl == home_url()){
		update_option('heateor_ss_homepage_shares', maybe_serialize($shareCounts));
	}elseif($postId > 0){
		update_post_meta($postId, '_heateor_ss_shares_meta', $shareCounts);
	}
}

/**
 * Save Facebook share counts in transient
 */
function the_champ_save_facebook_shares(){
	if(isset($_GET['share_counts']) && is_array($_GET['share_counts']) && count($_GET['share_counts']) > 0){
		$targetUrls = $_GET['share_counts'];
		foreach($targetUrls as $k => $v){
			$targetUrls[$k] = esc_attr(trim($v));
		}
	}else{
		the_champ_ajax_response(array('status' => 0, 'message' => __('Invalid request')));
	}
	
	global $theChampSharingOptions;

	$multiplier = 60;
	if ( $theChampSharingOptions['share_count_cache_refresh_count'] != '' ) {
		switch ( $theChampSharingOptions['share_count_cache_refresh_unit'] ) {
			case 'seconds':
				$multiplier = 1;
				break;

			case 'minutes':
				$multiplier = 60;
				break;
			
			case 'hours':
				$multiplier = 3600;
				break;

			case 'days':
				$multiplier = 3600*24;
				break;

			default:
				$multiplier = 60;
				break;
		}
		$transientExpirationTime = $multiplier * $theChampSharingOptions['share_count_cache_refresh_count'];
	}
	foreach($targetUrls as $key => $value){
		$transientId = heateor_ss_get_share_count_transient_id($key);
		$shareCountTransient = get_transient('heateor_ss_share_count_' . $transientId);
		if($shareCountTransient !== false){
			$shareCountTransient['facebook'] = $value;
			if($theChampSharingOptions['share_count_cache_refresh_count'] != '' ){
				$savedShareCount = heateor_ss_get_saved_share_counts($transientId, $key);
				$savedShareCount['facebook'] = $value;
				set_transient('heateor_ss_share_count_' . $transientId, $shareCountTransient, $transientExpirationTime);
				heateor_ss_update_share_counts($key, $savedShareCount);
			}
		}
	}
	die;
}
add_action('wp_ajax_the_champ_save_facebook_shares', 'the_champ_save_facebook_shares');
add_action('wp_ajax_nopriv_the_champ_save_facebook_shares', 'the_champ_save_facebook_shares');

/**
 * Get saved share counts for given post ID
 */
function heateor_ss_get_saved_share_counts($postId, $postUrl){
	$shareCounts = false;

	if($postId == 'custom'){
		$shareCounts = maybe_unserialize(get_option('heateor_ss_custom_url_shares'));
	}elseif($postUrl == home_url()){
		$shareCounts = maybe_unserialize(get_option('heateor_ss_homepage_shares'));
	}elseif($postId > 0){
		$shareCounts = get_post_meta($postId, '_heateor_ss_shares_meta', true);
	}
	
	return $shareCounts;
}

/**
 * Get ID of the share count transient
 */
function heateor_ss_get_share_count_transient_id($targetUrl){
	global $theChampSharingOptions;
	if($theChampSharingOptions['horizontal_target_url_custom'] == $targetUrl || $theChampSharingOptions['vertical_target_url_custom'] == $targetUrl){
		$postId = 'custom';
	}else{
		$postId = url_to_postid($targetUrl);
	}
	return $postId;
}

/**
 * Append myCRED referral ID to share and like button urls
 */
function heateor_ss_append_mycred_referral_id($postUrl, $sharingType, $standardWidget){
	$mycred_referral_id = do_shortcode('[mycred_affiliate_id]');
	if($mycred_referral_id){
		$connector = strpos(urldecode($postUrl), '?') === false ? '?' : '&';
		$postUrl .= $connector . 'mref=' . $mycred_referral_id;
	}
	return $postUrl;
}
if(isset($theChampSharingOptions['mycred_referral'])){
	add_filter('heateor_ss_target_share_url_filter', 'heateor_ss_append_mycred_referral_id', 10, 3);
}
if(isset($theChampCounterOptions['mycred_referral'])){
	add_filter('heateor_ss_target_like_button_url_filter', 'heateor_ss_append_mycred_referral_id', 10, 3);
}