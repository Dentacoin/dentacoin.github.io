<?php
/*
Plugin Name: Super Socializer
Plugin URI: https://super-socializer-wordpress.heateor.com
Description: A complete 360 degree solution to provide all the social features like Social Login, Social Commenting, Social Sharing, Social Media follow and more.
Version: 7.11.16
Author: Team Heateor
Author URI: https://www.heateor.com
Text Domain: super-socializer
Domain Path: /languages
License: GPL2+
*/
defined('ABSPATH') or die("Cheating........Uh!!");
define('THE_CHAMP_SS_VERSION', '7.11.16');

require 'helper.php';

$theChampLoginOptions = get_option('the_champ_login');
if(the_champ_social_login_enabled()){
	if(isset($theChampLoginOptions['providers']) && in_array('twitter', $theChampLoginOptions['providers'])){
		require 'library/twitteroauth.php';
	}
	if(isset($theChampLoginOptions['providers']) && (in_array('xing', $theChampLoginOptions['providers']) || in_array('linkedin', $theChampLoginOptions['providers']))){
		$theChampOauthConfigurationFile = plugins_url('library/oauth_configuration.json', __FILE__);
		require 'library/http.php';
		require 'library/oauth_client.php';
	}
	if(isset($theChampLoginOptions['providers']) && in_array('steam', $theChampLoginOptions['providers'])){
		require 'library/SteamLogin/SteamLogin.php';
		$theChampSteamLogin = new SteamLogin();
	}
}

$theChampFacebookOptions = get_option('the_champ_facebook');
$theChampSharingOptions = get_option('the_champ_sharing');
$theChampCounterOptions = get_option('the_champ_counter');
$theChampGeneralOptions = get_option('the_champ_general');

$theChampIsBpActive = false;

// include social login functions
require 'inc/social_login.php';

// include social sharing functions
if(the_champ_social_sharing_enabled() || the_champ_social_counter_enabled()){
	require 'inc/social_sharing_networks.php';
	require 'inc/social_sharing.php';
}
//include widget class
require 'inc/widget.php';
//include shortcode
require 'inc/shortcode.php';

/**
 * Hook the plugin function on 'init' event.
 */
function the_champ_init(){
	global $theChampSharingOptions;
	add_action('wp_enqueue_scripts', 'the_champ_load_event');
	add_action('wp_enqueue_scripts', 'the_champ_frontend_scripts');
	add_action('wp_enqueue_scripts', 'the_champ_frontend_styles');
	add_action('login_enqueue_scripts', 'the_champ_load_event');
	add_action('login_enqueue_scripts', 'the_champ_frontend_scripts');
	add_action('login_enqueue_scripts', 'the_champ_frontend_styles');
	add_action('parse_request', 'the_champ_connect');
	load_plugin_textdomain('super-socializer', false, dirname(plugin_basename(__FILE__)).'/languages/');
	if(heateor_ss_is_plugin_active('woocommerce/woocommerce.php')){
		add_action('the_champ_user_successfully_created', 'the_champ_sync_woocom_profile', 10, 3);
	}
	if(isset($theChampSharingOptions['amp_enable'])){
		// CSS for AMP pages
		add_action('amp_post_template_css', 'the_champ_frontend_amp_css');
	}
}
add_action('init', 'the_champ_init');

/**
 * Sync social profile data with WooCommerce billing and shipping address
 */
function the_champ_sync_woocom_profile($userId, $userdata, $profileData){
	$billingFirstName = get_user_meta($userId, 'billing_first_name', true);
	$billingLastName = get_user_meta($userId, 'billing_last_name', true);
	$billingEmail = get_user_meta($userId, 'billing_email', true);
	
	$shippingFirstName = get_user_meta($userId, 'shipping_first_name', true);
	$shippingLastName = get_user_meta($userId, 'shipping_last_name', true);
	$shippingEmail = get_user_meta($userId, 'shipping_email', true);

	// create username, firstname and lastname
	$usernameFirstnameLastname = explode('|tc|', the_champ_create_username($profileData));
	$username = $usernameFirstnameLastname[0];
	$firstName = $usernameFirstnameLastname[1];
	$lastName = $usernameFirstnameLastname[2];
	

	if($firstName || $username){
		if(!$billingFirstName){
			update_user_meta($userId, 'billing_first_name', $firstName ? $firstName : $username);
		}
		if(!$shippingFirstName){
			update_user_meta($userId, 'shipping_first_name', $firstName ? $firstName : $username);
		}
	}
	if($lastName){
		if(!$billingLastName){
			update_user_meta($userId, 'billing_last_name', $lastName);
		}
		if(!$shippingLastName){
			update_user_meta($userId, 'shipping_last_name', $lastName);
		}
	}
	if(!empty($profileData['email'])){
		if(!$billingEmail){
			update_user_meta($userId, 'billing_email', $profileData['email']);
		}
		if(!$shippingEmail){
			update_user_meta($userId, 'shipping_email', $profileData['email']);
		}
	}
}

function the_champ_load_event(){
	?>
	<script type="text/javascript">function theChampLoadEvent(e){var t=window.onload;if(typeof window.onload!="function"){window.onload=e}else{window.onload=function(){t();e()}}}</script>
	<?php
}

/**
 * Check querystring variables
 */
function the_champ_connect(){
	global $theChampLoginOptions;

	// verify email
	if((isset($_GET['SuperSocializerKey']) && ($verificationKey = sanitize_text_field($_GET['SuperSocializerKey'])) != '') || (isset($_GET['supersocializerkey']) && ($verificationKey = sanitize_text_field($_GET['supersocializerkey'])) != '')){
		$users = get_users('meta_key=thechamp_key&meta_value='.$verificationKey);
		if(count($users) > 0 && isset($users[0] -> ID)){
			delete_user_meta($users[0] -> ID, 'thechamp_key');
			wp_redirect(esc_url(home_url()).'?SuperSocializerVerified=1');
			die;
		}
	}
	
	// Instagram auth
	if(isset($_GET['SuperSocializerInstaToken']) && trim($_GET['SuperSocializerInstaToken']) != ''){
		$instaAuthUrl = 'https://api.instagram.com/v1/users/self?access_token=' . sanitize_text_field($_GET['SuperSocializerInstaToken']);
		$response = wp_remote_get( $instaAuthUrl,  array( 'timeout' => 15 ) );
		if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
			$body = json_decode(wp_remote_retrieve_body( $response ));
			if(is_object($body -> data) && isset($body -> data) && isset($body -> data -> id)){
				$redirection = isset($_GET['super_socializer_redirect_to']) && heateor_ss_validate_url($_GET['super_socializer_redirect_to']) !== false ? esc_url($_GET['super_socializer_redirect_to']) : '';
				$profileData = the_champ_sanitize_profile_data($body -> data, 'instagram');
				if(strpos($redirection, 'heateorMSEnabled') !== false){
					$profileData['mc_subscribe'] = 1;
				}
				$response = the_champ_user_auth($profileData, 'instagram', $redirection);
				if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
					$redirectTo = the_champ_get_login_redirection_url($redirection, true);
				}elseif(isset($response['message']) && $response['message'] == 'linked'){
					$redirectTo = $redirection . (strpos($redirection, '?') !== false ? '&' : '?') . 'linked=1';
				}elseif(isset($response['message']) && $response['message'] == 'not linked'){
					$redirectTo = $redirection . (strpos($redirection, '?') !== false ? '&' : '?') . 'linked=0';
				}elseif(isset($response['url']) && $response['url'] != ''){
					$redirectTo = $response['url'];
				}else{
					$redirectTo = the_champ_get_login_redirection_url($redirection);
				}
				the_champ_close_login_popup($redirectTo);
			}
		}
	}
	// Steam auth
	if(isset($_GET['SuperSocializerSteamAuth']) && trim($_GET['SuperSocializerSteamAuth']) != '' && isset($theChampLoginOptions['steam_api_key']) && $theChampLoginOptions['steam_api_key'] != ''){
		global $theChampSteamLogin;
		$theChampSteamId = $theChampSteamLogin->validate();
    	$result = wp_remote_get("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$theChampLoginOptions['steam_api_key']."&steamids=".$theChampSteamId."/?xml=1",  array('timeout' => 15));
    	if(!is_wp_error($result) && isset($result['response']['code']) && 200 === $result['response']['code']){
			$data = json_decode(wp_remote_retrieve_body($result));
		    if($data && isset($data->response) && isset($data->response->players) && is_array($data->response->players)){
				$steamProfileData = $data->response->players;
				if(isset($steamProfileData[0]) && isset($steamProfileData[0]->steamid)){
					$steamRedirect = heateor_ss_validate_url($_GET['SuperSocializerSteamAuth']) !== false ? esc_url(trim($_GET['SuperSocializerSteamAuth'])) : '';
					$profileData = the_champ_sanitize_profile_data($steamProfileData[0], 'steam');
					if(strpos($steamRedirect, 'heateorMSEnabled') !== false){
						$profileData['mc_subscribe'] = 1;
					}
					$response = the_champ_user_auth($profileData, 'steam', $steamRedirect);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($steamRedirect, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $steamRedirect . (strpos($steamRedirect, '?') !== false ? '&' : '?') . 'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $steamRedirect . (strpos($steamRedirect, '?') !== false ? '&' : '?') . 'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($steamRedirect);
					}
					the_champ_close_login_popup($redirectTo);
				}
		    }
		}
		die;
	}
	
	// send request to Xing
	if((isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Xing')){
		if(function_exists('session_start')){
			session_start();
		}
		if(!isset($_GET['oauth_token']) && isset($_SESSION['OAUTH_ACCESS_TOKEN'])){
			Unset($_SESSION['OAUTH_ACCESS_TOKEN']);
		}
		if(isset($theChampLoginOptions['xing_ck']) && $theChampLoginOptions['xing_ck'] != '' && isset($theChampLoginOptions['xing_cs']) && $theChampLoginOptions['xing_cs'] != ''){
			$xingClient = new oauth_client_class;
			$xingClient->debug = 0;
			$xingClient->debug_http = 1;
			$xingClient->server = 'XING';
			$xingClient->redirect_uri = home_url() . '/index.php?SuperSocializerAuth=Xing&super_socializer_redirect_to=' . str_replace(array('http://', 'https://'), '', esc_url(urldecode(trim($_GET['super_socializer_redirect_to'])))) . (isset($_GET['heateorMSEnabled']) ? '&heateorMSEnabled=1' : '');
			$xingClient->client_id = $theChampLoginOptions['xing_ck'];
			$xingClient->client_secret = $theChampLoginOptions['xing_cs'];
			if(($success = $xingClient->Initialize())){
				if(($success = $xingClient->Process())){
					if(strlen($xingClient->access_token)){
						$success = $xingClient->CallAPI(
							'https://api.xing.com/v1/users/me', 
							'GET', array(), array('FailOnAccessError'=>true), $xingResponse);
					}
				}
				$success = $xingClient->Finalize($success);
			}
			if($xingClient->exit) die('exit');
			if($success){
				if(isset($xingResponse -> users) && is_array($xingResponse -> users) && isset($xingResponse -> users[0] -> id)){
					$xingRedirect = the_champ_get_http() . esc_attr($_GET['super_socializer_redirect_to']);
					$profileData = the_champ_sanitize_profile_data($xingResponse -> users[0], 'xing');
					if(isset($_GET['heateorMSEnabled'])){
						$profileData['mc_subscribe'] = 1;
					}
					$response = the_champ_user_auth($profileData, 'xing', $xingRedirect);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($xingRedirect, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $xingRedirect . (strpos($xingRedirect, '?') !== false ? '&' : '?') . 'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $xingRedirect . (strpos($xingRedirect, '?') !== false ? '&' : '?') . 'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($xingRedirect);
					}
					the_champ_close_login_popup($redirectTo);
				}
			}else{
				echo 'Error:' . $xingClient->error;
				die;
			}
		}
	}
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Linkedin'){
		if(isset($theChampLoginOptions['li_key']) && $theChampLoginOptions['li_key'] != '' && isset($theChampLoginOptions['li_secret']) && $theChampLoginOptions['li_secret'] != ''){
		    $linkedinScope = 'r_basicprofile r_emailaddress';
		    $linkedinClient = new oauth_client_class;

		    if(!isset($_GET['session_cleared']) && !isset($_GET['code']) && !isset($_GET['state'])){
		    	if(function_exists('session_start')){
			    	session_start();
			    	session_unset();
			    	session_destroy();
			    }
		    	wp_redirect(home_url() . '?SuperSocializerAuth=Linkedin&super_socializer_redirect_to=' . esc_url(trim($_GET['super_socializer_redirect_to'])) . '&session_cleared=1');
		    	die;
		    }
		    $linkedinClient->debug = false;
		    $linkedinClient->debug_http = true;
		    $linkedinClient->server = 'LinkedIn2';
		    $linkedinClient->redirect_uri = home_url() . '?SuperSocializerAuth=Linkedin&super_socializer_redirect_to=' . esc_url(trim($_GET['super_socializer_redirect_to']));

		    $linkedinClient->client_id = $theChampLoginOptions['li_key'];
		    $application_line = __LINE__;
		    $linkedinClient->client_secret = $theChampLoginOptions['li_secret'];

		    // API permissions
		    $linkedinClient->scope = $linkedinScope;
		    if(($success = $linkedinClient->Initialize())) {
				if(($success = $linkedinClient->Process())) {
					if(strlen($linkedinClient->authorization_error)) {
						$linkedinClient->error = $linkedinClient->authorization_error;
						$success = false;
					}elseif(strlen($linkedinClient->access_token)) {
						$success = $linkedinClient->CallAPI(
							'https://api.linkedin.com/v1/people/~:(email-address,id,picture-urls::(original),first-name,last-name,headline,picture-url,public-profile-url,num-connections)', 
							'GET', array(
							'format'=>'json'
						), array('FailOnAccessError'=>true), $user);
					}
				}
				$success = $linkedinClient->Finalize($success);
				if(isset($user) && is_object($user) && isset($user->id)){
					$profileData = the_champ_sanitize_profile_data((array)$user, 'linkedin');
					if(isset($_GET['heateorMSEnabled'])){
						$profileData['mc_subscribe'] = 1;
					}
					$linkedinRedirectUrl = isset($_GET['super_socializer_redirect_to']) ? esc_url(trim($_GET['super_socializer_redirect_to'])) : home_url();
					$response = the_champ_user_auth($profileData, 'linkedin', $linkedinRedirectUrl);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($linkedinRedirectUrl, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $linkedinRedirectUrl . (strpos($linkedinRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $linkedinRedirectUrl . (strpos($linkedinRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($linkedinRedirectUrl);
					}
					the_champ_close_login_popup($redirectTo);
				}
		    }
		    if($linkedinClient->exit) exit('exiting');
		}
	}
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Twitch'){
		if(function_exists('session_start')){
			session_start();
		}
		require 'library/Twitch/twitch.php';
		$twitchAuth = new TwitchTV($theChampLoginOptions['twitch_client_id'], $theChampLoginOptions['twitch_client_secret'], home_url() . '/?SuperSocializerAuth=Twitch', array('user_read'));
		if(!isset($_GET['code'])){
			$_SESSION['super_socializer_twitch_redirect'] = isset($_GET['super_socializer_redirect_to']) ? esc_url(trim($_GET['super_socializer_redirect_to'])) : home_url();
			wp_redirect($twitchAuth->authenticate());
			die;
		}else{
			$accessToken = $twitchAuth->get_access_token($_GET['code']);
			$username = $twitchAuth->authenticated_user($accessToken);
			if(isset($username)){
			    $profileData = $twitchAuth->get_userid($username, true);
			    if(is_array($profileData) && isset($profileData['_id'])){
					$profileData = the_champ_sanitize_profile_data($profileData, 'twitch');
					if(isset($_GET['heateorMSEnabled'])){
						$profileData['mc_subscribe'] = 1;
					}
					$twitchRedirectUrl = isset($_SESSION['super_socializer_twitch_redirect']) && $_SESSION['super_socializer_twitch_redirect'] ? $_SESSION['super_socializer_twitch_redirect'] : home_url();
					unset($_SESSION['super_socializer_twitch_redirect']);
					$response = the_champ_user_auth($profileData, 'twitch', $twitchRedirectUrl);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($twitchRedirectUrl, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $twitchRedirectUrl . (strpos($twitchRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $twitchRedirectUrl . (strpos($twitchRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($twitchRedirectUrl);
					}
					the_champ_close_login_popup($redirectTo);
				}
			}
		}
	}
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Facebook'){
		if(isset($theChampLoginOptions['fb_key']) && $theChampLoginOptions['fb_key'] != '' && isset($theChampLoginOptions['fb_secret']) && $theChampLoginOptions['fb_secret'] != ''){
			if(function_exists('session_start')){
				session_start();
				if(!isset($_GET['code'])){
					// save referrer url in state
					$_SESSION['super_socializer_facebook_redirect'] = isset($_GET['super_socializer_redirect_to']) ? esc_url(trim($_GET['super_socializer_redirect_to'])) : home_url();
				}
			}
			require 'library/Facebook/autoload.php';
		    $facebook = new Facebook\Facebook(array(
		      'app_id' => $theChampLoginOptions['fb_key'],
		      'app_secret' => $theChampLoginOptions['fb_secret'],
		      'default_graph_version' => 'v2.10',
		    ));

		    $helper = $facebook->getRedirectLoginHelper();

		    $permissions = array('email'); // Optional permissions
		    if(!isset($_GET['code'])){
		        $loginUrl = $helper->getLoginUrl(home_url() . '/?SuperSocializerAuth=Facebook', $permissions);
		        wp_redirect($loginUrl);
		        die;
		    }else{
			    try{
	               $accessToken = $helper->getAccessToken(home_url() . '/?SuperSocializerAuth=Facebook');
	            }catch(Facebook\Exceptions\FacebookResponseException $e){
	            	_e('Problem fetching access token: ', 'super-socializer');
					echo $e->getMessage();
					die;
	            }catch(Facebook\Exceptions\FacebookSDKException $e){
	               _e('Facebook SDK returned an error: ', 'super-socializer');
	               echo $e->getMessage();
	               die;
	            }

	            if(isset($accessToken)){
					$permissions = $facebook->get('/me/permissions', $accessToken);
					try{
						$response = $facebook->get('/me?fields=id,name,about,link,email,first_name,last_name', $accessToken);
					}catch(Facebook\Exceptions\FacebookResponseException $e){
						_e('Graph returned an error: ', 'super-socializer');
						echo $e->getMessage();
						die;
					}catch(Facebook\Exceptions\FacebookSDKException $e){
						_e('Facebook SDK returned an error: ', 'super-socializer');
						echo $e->getMessage();
						die;
					}
					
					$user = $response->getGraphUser();
					if(is_object($user) && isset($user['id'])){
						$profileData = the_champ_sanitize_profile_data($user, 'facebook');
						if(isset($_GET['heateorMSEnabled'])){
							$profileData['mc_subscribe'] = 1;
						}
						$facebookRedirectUrl = isset($_SESSION['super_socializer_facebook_redirect'])  && $_SESSION['super_socializer_facebook_redirect'] ? esc_url(trim($_SESSION['super_socializer_facebook_redirect'])) : home_url();
						unset($_SESSION['super_socializer_facebook_redirect']);
						$response = the_champ_user_auth($profileData, 'facebook', $facebookRedirectUrl);
						if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
							$redirectTo = the_champ_get_login_redirection_url($facebookRedirectUrl, true);
						}elseif(isset($response['message']) && $response['message'] == 'linked'){
							$redirectTo = $facebookRedirectUrl . (strpos($facebookRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
						}elseif(isset($response['message']) && $response['message'] == 'not linked'){
							$redirectTo = $facebookRedirectUrl . (strpos($facebookRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
						}elseif(isset($response['url']) && $response['url'] != ''){
							$redirectTo = $response['url'];
						}else{
							$redirectTo = the_champ_get_login_redirection_url($facebookRedirectUrl);
						}
						the_champ_close_login_popup($redirectTo);
					}
	            }
    		}
		}
	}
	if((isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Google') || (isset($_GET['code']) && isset($_GET['state']))){
		if(isset($theChampLoginOptions['google_key']) && $theChampLoginOptions['google_key'] != '' && isset($theChampLoginOptions['google_secret']) && $theChampLoginOptions['google_secret'] != ''){
			require_once 'library/Google/Config.php';
			require_once 'library/Google/Service.php';
			require_once 'library/Google/Task/Runner.php';
			require_once 'library/Google/Http/REST.php';
			require_once 'library/Google/Resource.php';
			require_once 'library/Google/Model.php';
			require_once 'library/Google/Oauth2.php';
			require_once 'library/Google/Utils.php';
			require_once 'library/Google/Http/Request.php';
			require_once 'library/Google/Auth/Abstract.php';
			require_once 'library/Google/Exception.php';
			require_once 'library/Google/Auth/Exception.php';
			require_once 'library/Google/Auth/OAuth2.php';
			require_once 'library/Google/Http/CacheParser.php';
			require_once 'library/Google/IO/Abstract.php';
			require_once 'library/Google/Task/Retryable.php';
			require_once 'library/Google/IO/Exception.php';
			require_once 'library/Google/IO/Curl.php';
			require_once 'library/Google/Logger/Abstract.php';
			require_once 'library/Google/Logger/Null.php';
			require_once 'library/Google/Client.php';
		    
		    $googleClient = new Google_Client();
		    $googleClient->setClientId($theChampLoginOptions['google_key']);
		    $googleClient->setClientSecret($theChampLoginOptions['google_secret']);
		    $googleClient->setRedirectUri(home_url());
		    $googleClient->setScopes(array('https://www.googleapis.com/auth/userinfo.email'));
		    //Send Client Request
		    $objOAuthService = new Google_Service_Oauth2($googleClient);
		    $gpAuthUrl = $googleClient->createAuthUrl() . '&state=' . (isset($_GET['super_socializer_redirect_to']) ? esc_url(trim($_GET['super_socializer_redirect_to'])) : '');
		    if(!isset($_GET['code']) && !isset($_GET['state'])){
		        wp_redirect($gpAuthUrl);
		        die;
		    }    
		}
	}
	if(isset($_GET['code']) && isset($_GET['state'])){
	    //Authenticate code from Google OAuth Flow
	    if(is_object($googleClient)){
		    $googleClient->authenticate($_GET['code']);
		    $accessTokenStr = $googleClient->getAccessToken();
		    if($accessTokenStr){
		        $userData = $objOAuthService->userinfo->get();
		        if(is_object($userData) && isset($userData -> id)){
		            $profileData = the_champ_sanitize_profile_data($userData, 'google');
					if(isset($_GET['heateorMSEnabled'])){
						$profileData['mc_subscribe'] = 1;
					}
					$googleRedirectUrl = isset($_GET['state']) ? esc_url(trim($_GET['state'])) : home_url();
					$response = the_champ_user_auth($profileData, 'google', $googleRedirectUrl);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($googleRedirectUrl, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $googleRedirectUrl . (strpos($googleRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $googleRedirectUrl . (strpos($googleRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($googleRedirectUrl);
					}
					the_champ_close_login_popup($redirectTo);
		        }
		    }
		}
	}
	// Vkontakte
	if((isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Vkontakte') || (isset($_GET['code']) && !isset($_GET['SuperSocializerAuth']))){
		if(function_exists('session_start')){
			session_start();
		}
		require 'library/Vkontakte/Vkontakte.php';
		$heateorSsVkontakte = new Vkontakte(array(
		    'client_id' => $theChampLoginOptions['vk_key'],
		    'client_secret' => $theChampLoginOptions['vk_secure_key'],
		    'redirect_uri' => home_url()
		));
		$heateorSsVkontakte->setScope(array('email'));
	}
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Vkontakte'){
		if(isset($theChampLoginOptions['providers']) && in_array('vkontakte', $theChampLoginOptions['providers']) && isset($theChampLoginOptions['vk_key']) && $theChampLoginOptions['vk_key'] != '' && isset($theChampLoginOptions['vk_secure_key']) && $theChampLoginOptions['vk_secure_key'] != ''){
			$_SESSION['super_socializer_vkontakte_redirect'] = isset($_GET['super_socializer_redirect_to']) ? esc_url(trim($_GET['super_socializer_redirect_to'])) : home_url();
			wp_redirect($heateorSsVkontakte->getLoginUrl());
			die;
		}
	}
	if(isset($_GET['code']) && !isset($_GET['SuperSocializerAuth'])){
		if(isset($heateorSsVkontakte)){
			$heateorSsVkontakte->authenticate($_GET['code']);
			$userId = $heateorSsVkontakte->getUserId();
			$email = $heateorSsVkontakte->getUserEmail();
			if($userId){
				$users = $heateorSsVkontakte->api('users.get', array(
				    'user_id' => $userId,
				    'fields' => array('first_name','last_name','nickname','screen_name','photo_rec','photo_big')
				));
				if(isset($users[0]) && isset($users[0]["id"]) && $users[0]["id"]){
					$profileData = the_champ_sanitize_profile_data($users[0], 'vkontakte');
					$profileData['email'] = '';
					if($email){
						$profileData['email'] = sanitize_email($email);
					}
					if(isset($_GET['heateorMSEnabled'])){
						$profileData['mc_subscribe'] = 1;
					}
					$vkontakteRedirectUrl = isset($_SESSION['super_socializer_vkontakte_redirect'])  && $_SESSION['super_socializer_vkontakte_redirect'] ? esc_url(trim($_SESSION['super_socializer_vkontakte_redirect'])) : home_url();
					$response = the_champ_user_auth($profileData, 'vkontakte', $vkontakteRedirectUrl);
					if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
						$redirectTo = the_champ_get_login_redirection_url($vkontakteRedirectUrl, true);
					}elseif(isset($response['message']) && $response['message'] == 'linked'){
						$redirectTo = $vkontakteRedirectUrl . (strpos($vkontakteRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
					}elseif(isset($response['message']) && $response['message'] == 'not linked'){
						$redirectTo = $vkontakteRedirectUrl . (strpos($vkontakteRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
					}elseif(isset($response['url']) && $response['url'] != ''){
						$redirectTo = $response['url'];
					}else{
						$redirectTo = the_champ_get_login_redirection_url($vkontakteRedirectUrl);
					}
					the_champ_close_login_popup($redirectTo);
				}
			}
		}
	}
	// send request to twitter
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Twitter' && !isset($_REQUEST['oauth_token'])){
		if(isset($theChampLoginOptions['twitter_key']) && $theChampLoginOptions['twitter_key'] != '' && isset($theChampLoginOptions['twitter_secret']) && $theChampLoginOptions['twitter_secret'] != ''){
			if(!function_exists('curl_init')){
				?>
				<div style="width: 500px; margin: 0 auto">
				<?php _e('cURL is not enabled at your website server. Please contact your website server administrator to enable it.', 'super-socializer') ?>
				</div>
				<?php
				die;
			}
			/* Build TwitterOAuth object with client credentials. */
			$connection = new TwitterOAuth($theChampLoginOptions['twitter_key'], $theChampLoginOptions['twitter_secret']);
			/* Get temporary credentials. */
			$requestToken = $connection->getRequestToken(esc_url(home_url()).'/index.php?SuperSocializerAuth=Twitter');
			if($connection->http_code == 200){
				// generate unique ID
				$uniqueId = mt_rand();
				// save oauth token and secret in db temporarily
				update_user_meta($uniqueId, 'thechamp_twitter_oauthtoken', $requestToken['oauth_token']);
				update_user_meta($uniqueId, 'thechamp_twitter_oauthtokensecret', $requestToken['oauth_token_secret']);
				if(isset($_GET['heateorMSEnabled'])){
					update_user_meta($uniqueId, 'thechamp_mc_subscribe', '1');
				}
				if(isset($_GET['super_socializer_redirect_to']) && heateor_ss_validate_url($_GET['super_socializer_redirect_to']) !== false){
					update_user_meta($uniqueId, 'thechamp_twitter_redirect', esc_url(trim($_GET['super_socializer_redirect_to'])));
				}
				wp_redirect($connection->getAuthorizeURL($requestToken['oauth_token']));
				die;
			}else{
				?>
				<div style="width: 500px; margin: 0 auto">
					<ol>
					<li><?php echo sprintf(__('Enter exactly the following url in <strong>Website</strong> option in your Twitter app (see step 3 %s)', 'super-socializer'), '<a target="_blank" href="http://support.heateor.com/how-to-get-twitter-api-key-and-secret/">here</a>') ?><br/>
					<?php echo esc_url(home_url()) ?>
					</li>
					<li><?php echo sprintf(__('Enter exactly the following url in <strong>Callback URLs</strong> option in your Twitter app (see step 3 %s)', 'super-socializer'), '<a target="_blank" href="http://support.heateor.com/how-to-get-twitter-api-key-and-secret/">here</a>') ?><br/>
					<?php echo esc_url(home_url().'/index.php?SuperSocializerAuth=Twitter') ?>
					</li>
					<li><?php _e('Make sure cURL is enabled at your website server. You may need to contact the server administrator of your website to verify this', 'super-socializer') ?></li>
					<li><?php echo sprintf(__('Make sure that "Enable Callback Locking" option is disabled. See step 4 %s', 'super-socializer'), '<a target="_blank" href="http://support.heateor.com/how-to-get-twitter-api-key-and-secret">here</a>') ?></li>
					</ol>
				</div>
				<?php
				die;
			}
		}
	}
	// twitter authentication
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'Twitter' && isset($_REQUEST['oauth_token'])){
		global $wpdb;
		$uniqueId = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'thechamp_twitter_oauthtoken' and meta_value = %s", sanitize_text_field($_REQUEST['oauth_token'])));
		$oauthTokenSecret = get_user_meta($uniqueId, 'thechamp_twitter_oauthtokensecret', true);
		// twitter redirect url
		$twitterRedirectUrl = get_user_meta($uniqueId, 'thechamp_twitter_redirect', true);
		if(empty($uniqueId) || $oauthTokenSecret == ''){
			// invalid request
			wp_redirect(esc_url(home_url()));
			die;
		}
		$connection = new TwitterOAuth($theChampLoginOptions['twitter_key'], $theChampLoginOptions['twitter_secret'], $_REQUEST['oauth_token'], $oauthTokenSecret);
		/* Request access tokens from twitter */
		$accessToken = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth($theChampLoginOptions['twitter_key'], $theChampLoginOptions['twitter_secret'], $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
		$content = $connection->get('account/verify_credentials', array('include_email' => 'true'));
		// delete temporary data
		delete_user_meta($uniqueId, 'thechamp_twitter_oauthtokensecret');
		delete_user_meta($uniqueId, 'thechamp_twitter_oauthtoken');
		delete_user_meta($uniqueId, 'thechamp_twitter_redirect');
		if(is_object($content) && isset($content -> id)){
			$profileData = the_champ_sanitize_profile_data($content, 'twitter');
			if(get_user_meta($uniqueId, 'thechamp_mc_subscribe', true) != ''){
				$profileData['mc_subscribe'] = 1;
			}
			delete_user_meta($uniqueId, 'thechamp_mc_subscribe');
			$response = the_champ_user_auth($profileData, 'twitter', $twitterRedirectUrl);
			if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
				$redirectTo = the_champ_get_login_redirection_url($twitterRedirectUrl, true);
			}elseif(isset($response['message']) && $response['message'] == 'linked'){
				$redirectTo = $twitterRedirectUrl . (strpos($twitterRedirectUrl, '?') !== false ? '&' : '?') . 'linked=1';
			}elseif(isset($response['message']) && $response['message'] == 'not linked'){
				$redirectTo = $twitterRedirectUrl . (strpos($twitterRedirectUrl, '?') !== false ? '&' : '?') . 'linked=0';
			}elseif(isset($response['url']) && $response['url'] != ''){
				$redirectTo = $response['url'];
			}else{
				$redirectTo = the_champ_get_login_redirection_url($twitterRedirectUrl);
			}
			the_champ_close_login_popup($redirectTo);
		}
	}

	// LiveJournal auth
	if(isset($_GET['SuperSocializerAuth']) && sanitize_text_field($_GET['SuperSocializerAuth']) == 'LiveJournal'){
		the_champ_livejournal_auth();
	}
}

/**
 * LiveJournal auth
 */
function the_champ_livejournal_auth(){
	require('library/LiveJournalLogin/class.openid.v3.php');
	$currentPageUrl = the_champ_get_valid_url(html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])));
	if(isset($_POST['openid_action']) && $_POST['openid_action'] == "SuperSocializerLogin"){ // Get identity from user and redirect browser to OpenID Server
		$theChampOpenId = new SimpleOpenID;
		$theChampOpenId->SetIdentity(sanitize_text_field($_POST['openid_url']).'.livejournal.com');
		$theChampOpenId->SetTrustRoot($currentPageUrl);
		$theChampOpenId->SetRequiredFields(array('email','fullname'));
		$theChampOpenId->SetOptionalFields(array('dob','gender','postcode','country','language','timezone'));
		if($theChampOpenId->GetOpenIDServer()){
			$theChampOpenId->SetApprovedURL($currentPageUrl);  	// Send Response from OpenID server to this script
			$theChampOpenId->Redirect(); 	// This will redirect user to OpenID Server
		}else{
			$error = $theChampOpenId->GetError();
			echo "ERROR CODE: " . $error['code'] . "<br>";
			echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		}
		exit;
	}elseif(isset($_GET['openid_mode']) && $_GET['openid_mode'] == 'id_res'){ 	// Perform HTTP Request to OpenID server to validate key
		$theChampOpenId = new SimpleOpenID;
		$theChampOpenId->SetIdentity($_GET['openid_identity']);
		$theChampOpenIdValidationResult = $theChampOpenId->ValidateWithServer();
		if($theChampOpenIdValidationResult == true){ 		// OK HERE KEY IS VALID
			$userpicUrl = '';
			if(isset($_GET['openid_claimed_id']) && $_GET['openid_claimed_id'] != ''){
				$usernameParts = explode('.', str_replace('http://', '', sanitize_text_field($_GET['openid_claimed_id'])));
				$response = wp_remote_get( 'http://www.livejournal.com/allpics.bml?user=' . $usernameParts[0],  array( 'timeout' => 15 ) );
				if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
					$body = wp_remote_retrieve_body( $response );
					if($body){
						$userpicsHtmlParts = explode('https://l-userpic.livejournal.com', $body);
						$userpicsId = explode("'", $userpicsHtmlParts[1]);
						$userpicUrl = 'https://l-userpic.livejournal.com' . $userpicsId[0];
					}
				}
				$profileData = array();
				$profileData['username'] = $usernameParts[0];
				$profileData['link'] = trim($_GET['openid_claimed_id']);
				$profileData['avatar'] = $userpicUrl;
				$profileData['name'] = $usernameParts[0];
				$profileData['first_name'] = $usernameParts[0];
				$profileData['last_name'] = $usernameParts[0];
				$redirection = isset($_GET['super_socializer_redirect_to']) && heateor_ss_validate_url($_GET['super_socializer_redirect_to']) !== false ? esc_url($_GET['super_socializer_redirect_to']) : '';
				$profileData = the_champ_sanitize_profile_data($profileData, 'liveJournal');
				if(isset($_GET['heateorMSEnabled'])){
					$profileData['mc_subscribe'] = 1;
				}
				$response = the_champ_user_auth($profileData, 'liveJournal', $redirection);
				if(is_array($response) && isset($response['message']) && $response['message'] == 'register' && (!isset($response['url']) || $response['url'] == '')){
					$redirectTo = the_champ_get_login_redirection_url($redirection, true);
				}elseif(isset($response['message']) && $response['message'] == 'linked'){
					$redirectTo = $redirection . (strpos($redirection, '?') !== false ? '&' : '?') . 'linked=1';
				}elseif(isset($response['message']) && $response['message'] == 'not linked'){
					$redirectTo = $redirection . (strpos($redirection, '?') !== false ? '&' : '?') . 'linked=0';
				}elseif(isset($response['url']) && $response['url'] != ''){
					$redirectTo = $response['url'];
				}else{
					$redirectTo = the_champ_get_login_redirection_url($redirection);
				}
				the_champ_close_login_popup($redirectTo);
			}
		}elseif($theChampOpenId->IsError() == true){			// Oops, WE GOT SOME ERROR
			$error = $theChampOpenId->GetError();
			echo "ERROR CODE: " . $error['code'] . "<br>";
			echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		}else{											// Signature Verification Failed
			echo "INVALID AUTHORIZATION";
		}
	}elseif(isset($_GET['openid_mode']) && $_GET['openid_mode'] == 'cancel'){ // User Canceled the Request
		the_champ_close_login_popup($currentPageUrl);
	}else{
		wp_redirect(remove_query_arg(array('SuperSocializerAuth', 'action'), html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]))), 301);
    	exit;
	}
	die;
}

/**
 * Close Social Login popup
 */
function the_champ_close_login_popup($redirectionUrl){
	?>
	<script>
	if(window.opener){
		window.opener.location.href="<?php echo trim($redirectionUrl); ?>";
		window.close();
	}else{
		window.location.href="<?php echo trim($redirectionUrl); ?>";
	}
	</script>
	<?php
	die;
}

/**
 * Validate url
 */
function the_champ_validate_url($url){
	$expression = "/^(http:\/\/|https:\/\/|ftp:\/\/|ftps:\/\/|)?[a-z0-9_\-]+[a-z0-9_\-\.]+\.[a-z]{2,4}(\/+[a-z0-9_\.\-\/]*)?$/i";
    return (bool)preg_match($expression, $url);
}

/**
 * Get http/https protocol at the website
 */
function the_champ_get_http(){
	if(isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
		return "https://";
	}else{
		return "http://";
	}
}

/**
 * Return valid redirection url
 */
function the_champ_get_valid_url($url){
	$decodedUrl = urldecode($url);
	if(html_entity_decode(esc_url(remove_query_arg(array('ss_message', 'SuperSocializerVerified', 'SuperSocializerUnverified'), $decodedUrl))) == wp_login_url() || $decodedUrl == home_url().'/wp-login.php?action=register' || $decodedUrl == home_url().'/wp-login.php?loggedout=true'){ 
		$url = esc_url(home_url()).'/';
	}elseif(isset($_GET['redirect_to'])){
		if(urldecode($_GET['redirect_to']) == admin_url()){
			$url = esc_url(home_url()).'/';
		}elseif(the_champ_validate_url(urldecode($_GET['redirect_to'])) && (strpos(urldecode($_GET['redirect_to']), 'http://') !== false || strpos(urldecode($_GET['redirect_to']), 'https://') !== false)){
			$url = $_GET['redirect_to'];
		}else{
			$url = esc_url(home_url()).'/';
		}
	}
	return $url;
}

/**
 * Return webpage url to redirect after login
 */
function the_champ_get_login_redirection_url($twitterRedirect = '', $register = false){
	global $theChampLoginOptions, $user_ID;
	if($register){
		$option = 'register';
	}else{
		$option = 'login';
	}
	$redirectionUrl = esc_url(home_url());
	if(isset($theChampLoginOptions[$option.'_redirection'])){
		if($theChampLoginOptions[$option.'_redirection'] == 'same'){
			$http = the_champ_get_http();
			if($twitterRedirect != ''){
				$url = $twitterRedirect;
			}else{
				$url = html_entity_decode(esc_url($http.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
			}
			$redirectionUrl = the_champ_get_valid_url($url);
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'homepage'){
			$redirectionUrl = esc_url(home_url());
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'account'){
			$redirectionUrl = admin_url();
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'custom' && $theChampLoginOptions[$option.'_redirection_url'] != ''){
			$redirectionUrl = esc_url($theChampLoginOptions[$option.'_redirection_url']);
		}elseif($theChampLoginOptions[$option.'_redirection'] == 'bp_profile' && $user_ID != 0){
			$redirectionUrl = function_exists('bp_core_get_user_domain') ? bp_core_get_user_domain($user_ID) : admin_url();
		}
	}
	$redirectionUrl = apply_filters('heateor_ss_login_redirection_url_filter', $redirectionUrl, $theChampLoginOptions, $user_ID, $twitterRedirect, $register);

	return $redirectionUrl;
}

/**
 * The javascript to load at front end
 */
function the_champ_frontend_scripts(){
	global $theChampFacebookOptions, $theChampLoginOptions, $theChampSharingOptions, $theChampGeneralOptions;
	$inFooter = isset($theChampGeneralOptions['footer_script']) ? true : false;
	$combinedScript = isset($theChampGeneralOptions['combined_script']) ? true : false;
	?>
	<script type="text/javascript">var theChampCloseIconPath = '<?php echo plugins_url('images/close.png', __FILE__) ?>';<?php if(isset($theChampGeneralOptions["browser_msg_enable"]) && $theChampGeneralOptions["browser_msg"] != ""){ ?>var heateorSsSDKBlockedMsg = `<?php echo str_replace("{support_url}", "<a href=\'http://support.heateor.com/browser-blocking-social-features/\' target=\'_blank\' style=\'color:#33a9d8\'>http://support.heateor.com/browser-blocking-social-features/</a>", htmlspecialchars($theChampGeneralOptions["browser_msg"], ENT_QUOTES)); ?>`<?php } ?></script>
	<?php
	if(!$combinedScript){
		wp_enqueue_script('the_champ_ss_general_scripts', plugins_url('js/front/social_login/general.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
	}
	$websiteUrl = esc_url(home_url());
	$fbKey = isset($theChampLoginOptions["fb_key"]) && $theChampLoginOptions["fb_key"] != "" ? $theChampLoginOptions["fb_key"] : "";
	$userVerified = false;
	$emailPopup = false;
	?>
	<script> var theChampSiteUrl = '<?php echo strtok($websiteUrl,"?"); ?>', theChampVerified = <?php echo intval($userVerified) ?>, theChampEmailPopup = <?php echo intval($emailPopup); ?>; </script>
	<?php
	// scripts used for common Social Login functionality
	if(the_champ_social_login_enabled() && !is_user_logged_in()){
		$loadingImagePath = plugins_url('images/ajax_loader.gif', __FILE__);
		$theChampAjaxUrl = get_admin_url().'admin-ajax.php';
		$redirectionUrl = the_champ_get_login_redirection_url();
		$regRedirectionUrl = the_champ_get_login_redirection_url('', true);
		?>
		<script> var theChampLoadingImgPath = '<?php echo $loadingImagePath ?>'; var theChampAjaxUrl = '<?php echo $theChampAjaxUrl ?>'; var theChampRedirectionUrl = '<?php echo $redirectionUrl ?>'; var theChampRegRedirectionUrl = '<?php echo $regRedirectionUrl ?>'; </script>
		<?php
		$ajaxUrl = 'admin-ajax.php';
		$notification = '';
		if(isset($_GET['SuperSocializerVerified']) || isset($_GET['SuperSocializerUnverified'])){
			$userVerified = true;
			$ajaxUrl = esc_url(add_query_arg( 
				array(
					'height' => 60,
					'width' => 300,
					'action' => 'the_champ_notify',
					'message' => urlencode(isset($_GET['SuperSocializerUnverified']) ? __('Please verify your email address to login.', 'super-socializer') : __('Your email has been verified. Now you can login to your account', 'super-socializer'))
				), 
				'admin-ajax.php'
			));
			$notification = __('Notification', 'super-socializer');
		}
		
		$emailAjaxUrl = 'admin-ajax.php';
		$emailPopupTitle = '';
		$emailPopupErrorMessage = '';
		$emailPopupUniqueId = '';
		$emailPopupVerifyMessage = '';
		if(isset($_GET['SuperSocializerEmail']) && isset($_GET['par']) && trim($_GET['par']) != ''){
			$emailPopup = true;
			$emailAjaxUrl = esc_url(add_query_arg( 
				array(
					'height' => isset($theChampLoginOptions['popup_height']) && $theChampLoginOptions['popup_height'] != '' ? esc_attr( $theChampLoginOptions['popup_height'] ) : 210,
					'width' => 300,
					'action' => 'the_champ_ask_email'
				), 
				'admin-ajax.php'
			));
			$emailPopupTitle = __('Email required', 'super-socializer');
			$emailPopupErrorMessage = isset($theChampLoginOptions["email_error_message"]) ? $theChampLoginOptions["email_error_message"] : "";
			$emailPopupUniqueId = isset($_GET['par']) ? sanitize_text_field($_GET['par']) : '';
			$emailPopupVerifyMessage = __('Please check your email inbox to complete the registration.', 'super-socializer');
		}
		global $theChampSteamLogin;
		$twitterRedirect = urlencode(the_champ_get_valid_url(html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]))));
		$currentPageUrl = urldecode($twitterRedirect);
		$theChampLJAuthUrl = remove_query_arg('action', the_champ_get_valid_url($currentPageUrl));
		?>
		<script> var theChampFBKey = '<?php echo $fbKey ?>', theChampVerified = <?php echo intval($userVerified) ?>; var theChampAjaxUrl = '<?php echo html_entity_decode(admin_url().$ajaxUrl) ?>'; var theChampPopupTitle = '<?php echo $notification; ?>'; var theChampEmailPopup = <?php echo intval($emailPopup); ?>; var theChampEmailAjaxUrl = '<?php echo html_entity_decode(admin_url().$emailAjaxUrl); ?>'; var theChampEmailPopupTitle = '<?php echo $emailPopupTitle; ?>'; var theChampEmailPopupErrorMsg = '<?php echo htmlspecialchars($emailPopupErrorMessage, ENT_QUOTES); ?>'; var theChampEmailPopupUniqueId = '<?php echo $emailPopupUniqueId; ?>'; var theChampEmailPopupVerifyMessage = '<?php echo $emailPopupVerifyMessage; ?>'; var theChampLJLoginUsernameString = '<?php echo htmlspecialchars(__('Enter your LiveJournal username', 'super-socializer'), ENT_QUOTES); ?>'; var theChampLJAuthUrl = '<?php echo $theChampLJAuthUrl . (strpos($theChampLJAuthUrl, '?') !== false ? '&' : '?') . "SuperSocializerAuth=LiveJournal"; ?>'; var theChampSteamAuthUrl = "<?php echo $theChampSteamLogin ? $theChampSteamLogin->url( esc_url(home_url()) . '?SuperSocializerSteamAuth=' . $twitterRedirect ) : ''; ?>"; var theChampTwitterRedirect = '<?php echo $twitterRedirect ?>'; <?php echo isset($theChampLoginOptions['disable_reg']) && isset($theChampLoginOptions['disable_reg_redirect']) && $theChampLoginOptions['disable_reg_redirect'] != '' ? 'var theChampDisableRegRedirect = "' . html_entity_decode(esc_url($theChampLoginOptions['disable_reg_redirect'])) . '";' : ''; ?> var heateorMSEnabled = 0; var theChampTwitterAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Twitter&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampFacebookAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Facebook&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampTwitchAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Twitch&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampGoogleAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Google&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampVkontakteAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Vkontakte&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampLinkedinAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Linkedin&super_socializer_redirect_to=" + theChampTwitterRedirect; var theChampXingAuthUrl = theChampSiteUrl + "?SuperSocializerAuth=Xing&super_socializer_redirect_to=" + theChampTwitterRedirect;</script>
		<?php
		if(!$combinedScript){
			wp_enqueue_script('the_champ_sl_common', plugins_url('js/front/social_login/common.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION, $inFooter);
		}
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}
	// Instagram scripts
	if(the_champ_social_login_provider_enabled('instagram')){
		?>
		<script> var theChampInstaId = '<?php echo (isset($theChampLoginOptions["insta_id"]) && $theChampLoginOptions["insta_id"] != "") ? $theChampLoginOptions["insta_id"] : 0 ?>'; var theChampTwitterRedirect = '<?php echo urlencode(the_champ_get_valid_url(html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])))); ?>';</script>
		<?php
		if(!$combinedScript){
			wp_enqueue_script('the_champ_sl_instagram', plugins_url('js/front/social_login/instagram.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
		}
	}
	// Facebook scripts
	if(the_champ_facebook_plugin_enabled()){
		?>
		<script> var theChampFBKey = '<?php echo $fbKey ?>', theChampFBLang = '<?php echo (isset($theChampFacebookOptions["comment_lang"]) && $theChampFacebookOptions["comment_lang"] != '') ? $theChampFacebookOptions["comment_lang"] : "en_US" ?>', theChampFbLikeMycred = <?php echo defined( 'HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION' ) && the_champ_facebook_like_rec_enabled() ? 1 : 0 ?>, theChampSsga = <?php echo defined( 'HEATEOR_SHARING_GOOGLE_ANALYTICS_VERSION' ) ? 1 : 0 ?>, theChampCommentNotification = <?php echo (defined('HEATEOR_FB_COM_NOT_VERSION') && version_compare('1.1.4', HEATEOR_FB_COM_NOT_VERSION) > 0) || function_exists('heateor_ss_check_querystring') || function_exists('the_champ_check_querystring') ? 1 : 0; ?>, theChampHeateorFcmRecentComments = <?php echo defined('HEATEOR_FB_COM_MOD_VERSION') && HEATEOR_FB_COM_MOD_VERSION == '1.1.4' ? 1 : 0 ?>, theChampFbIosLogin = <?php echo !is_user_logged_in() && isset($_GET['code']) && esc_attr(trim($_GET['code'])) != '' ? 1 : 0; ?>; </script>
		<?php
		add_action('wp_footer', 'the_champ_fb_root_div');
		if(!$combinedScript){
			wp_enqueue_script('the_champ_fb_sdk', plugins_url('js/front/facebook/sdk.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
		}
	}
	
	// Social commenting
	if(the_champ_social_commenting_enabled()){
		global $post;
		if($post){
			$postMeta = get_post_meta($post -> ID, '_the_champ_meta', true);
			if(isset($theChampFacebookOptions['enable_' . $post->post_type]) && !(isset($postMeta) && isset($postMeta['fb_comments']) && $postMeta['fb_comments'] == 1)){
				if(isset($theChampFacebookOptions['urlToComment']) && $theChampFacebookOptions['urlToComment'] != ''){
					$commentUrl = $theChampFacebookOptions['urlToComment'];
				}elseif(isset($post -> ID) && $post -> ID){
					$commentUrl = get_permalink($post -> ID);
				}else{
					$commentUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
				}

				$commentingTabsOrder = ($theChampFacebookOptions['commenting_order'] != '' ? $theChampFacebookOptions['commenting_order'] : 'wordpress,facebook,googleplus,disqus');
				$commentingTabsOrder = explode(',', str_replace('facebook', 'fb', $commentingTabsOrder));
				$enabledTabs = array();
				foreach($commentingTabsOrder as $tab){
					$tab = trim($tab);
					if($tab == 'wordpress'){
						$enabledTabs[] = 'wordpress';
					}elseif(isset($theChampFacebookOptions['enable_'. $tab .'comments'])){
						$enabledTabs[] = $tab;
					}
				}
				$labels = array();
				$labels['wordpress'] = $theChampFacebookOptions['label_wordpress_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_wordpress_comments'], ENT_QUOTES) : 'Default Comments';
				$commentsCount = wp_count_comments($post->ID);
				$labels['wordpress'] .= ' ('. ($commentsCount && isset($commentsCount -> approved) ? $commentsCount -> approved : '') .')';
				$labels['fb'] = $theChampFacebookOptions['label_facebook_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_facebook_comments'], ENT_QUOTES) : 'Facebook Comments';
				$labels['fb'] .= ' (<fb:comments-count href='. $commentUrl .'></fb:comments-count>)';
				$labels['googleplus'] = $theChampFacebookOptions['label_googleplus_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_googleplus_comments'], ENT_QUOTES) : 'GooglePlus Comments';
				$labels['disqus'] = $theChampFacebookOptions['label_disqus_comments'] != '' ? htmlspecialchars($theChampFacebookOptions['label_disqus_comments'], ENT_QUOTES) : 'Disqus Comments';
				global $heateor_fcm_options;
				if(defined('HEATEOR_FB_COM_MOD_VERSION') && version_compare('1.2.4', HEATEOR_FB_COM_MOD_VERSION) < 0 && isset($heateor_fcm_options['gdpr_enable'])){
					?>
					<script type="text/javascript">var theChampFacebookCommentsOptinText = '<?php echo str_replace($heateor_fcm_options['ppu_placeholder'], '<a href="'. $heateor_fcm_options['privacy_policy_url'] .'" target="_blank">'. $heateor_fcm_options['ppu_placeholder'] .'</a>', wp_strip_all_tags($heateor_fcm_options['privacy_policy_optin_text'])) ?>';</script>
					<?php
				}
				global $heateor_fcn_options;
				if(defined('HEATEOR_FB_COM_NOT_VERSION') && version_compare('1.1.6', HEATEOR_FB_COM_NOT_VERSION) < 0 && isset($heateor_fcn_options['gdpr_enable'])){
					?>
					<script type="text/javascript">var theChampFacebookCommentsNotifierOptinText = '<?php echo str_replace($heateor_fcn_options['ppu_placeholder'], '<a href="'. $heateor_fcn_options['privacy_policy_url'] .'" target="_blank">'. $heateor_fcn_options['ppu_placeholder'] .'</a>', wp_strip_all_tags($heateor_fcn_options['privacy_policy_optin_text'])) ?>';</script>
					<?php
				}
				?>
				<script type="text/javascript">var theChampFBCommentUrl = '<?php echo $commentUrl ?>'; var theChampFBCommentColor = '<?php echo (isset($theChampFacebookOptions['comment_color']) && $theChampFacebookOptions['comment_color'] != '') ? $theChampFacebookOptions["comment_color"] : ''; ?>'; var theChampFBCommentNumPosts = '<?php echo (isset($theChampFacebookOptions['comment_numposts']) && $theChampFacebookOptions['comment_numposts'] != '') ? $theChampFacebookOptions["comment_numposts"] : ''; ?>'; var theChampFBCommentWidth = '<?php echo (isset($theChampFacebookOptions['comment_width']) && $theChampFacebookOptions['comment_width'] != '') ? $theChampFacebookOptions["comment_width"] : '100%'; ?>'; var theChampFBCommentOrderby = '<?php echo (isset($theChampFacebookOptions['comment_orderby']) && $theChampFacebookOptions['comment_orderby'] != '') ? $theChampFacebookOptions["comment_orderby"] : ''; ?>'; var theChampCommentingTabs = "<?php echo isset($theChampFacebookOptions['commenting_order']) ? $theChampFacebookOptions['commenting_order'] : ''; ?>", theChampGpCommentsUrl = '<?php echo isset($theChampFacebookOptions['gpcomments_url']) && $theChampFacebookOptions['gpcomments_url'] != '' ? $theChampFacebookOptions['gpcomments_url'] : $commentUrl; ?>', theChampDisqusShortname = '<?php echo isset($theChampFacebookOptions['dq_shortname']) ? $theChampFacebookOptions['dq_shortname'] : ''; ?>', theChampScEnabledTabs = '<?php echo implode(',', $enabledTabs) ?>', theChampScLabel = '<?php echo $theChampFacebookOptions['commenting_label'] != '' ? htmlspecialchars(wp_specialchars_decode($theChampFacebookOptions['commenting_label'], ENT_QUOTES), ENT_QUOTES) : __('Leave a reply', 'super-socializer'); ?>', theChampScTabLabels = <?php echo json_encode($labels) ?>, theChampGpCommentsWidth = <?php echo isset($theChampFacebookOptions['gpcomments_width']) && $theChampFacebookOptions['gpcomments_width'] != '' ? $theChampFacebookOptions['gpcomments_width'] : 0; ?>, theChampCommentingId = '<?php echo isset($theChampFacebookOptions['commenting_id']) && $theChampFacebookOptions['commenting_id'] != '' ? $theChampFacebookOptions['commenting_id'] : 'respond' ?>'</script>
				<?php
				if(!$combinedScript){
					wp_enqueue_script('the_champ_fb_commenting', plugins_url('js/front/facebook/commenting.js', __FILE__), false, THE_CHAMP_SS_VERSION, $inFooter);
				}
			}
		}
	}
	// sharing script
	if(the_champ_social_sharing_enabled() || (the_champ_social_counter_enabled() && the_champ_vertical_social_counter_enabled())){
		global $theChampSharingOptions, $theChampCounterOptions, $post;
		?>
		<script> var theChampSharingAjaxUrl = '<?php echo get_admin_url() ?>admin-ajax.php', heateorSsUrlCountFetched = [], heateorSsSharesText = '<?php echo htmlspecialchars(__('Shares', 'super-socializer'), ENT_QUOTES); ?>', heateorSsShareText = '<?php echo htmlspecialchars(__('Share', 'super-socializer'), ENT_QUOTES); ?>', theChampPluginIconPath = '<?php echo plugins_url('images/logo.png', __FILE__) ?>', theChampHorizontalSharingCountEnable = <?php echo isset($theChampSharingOptions['enable']) && isset($theChampSharingOptions['hor_enable']) && ( isset($theChampSharingOptions['horizontal_counts']) || isset($theChampSharingOptions['horizontal_total_shares']) ) ? 1 : 0 ?>, theChampVerticalSharingCountEnable = <?php echo isset($theChampSharingOptions['enable']) && isset($theChampSharingOptions['vertical_enable']) && ( isset($theChampSharingOptions['vertical_counts']) || isset($theChampSharingOptions['vertical_total_shares']) ) ? 1 : 0 ?>, theChampSharingOffset = <?php echo (isset($theChampSharingOptions['alignment']) && $theChampSharingOptions['alignment'] != '' && isset($theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset']) && $theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'] != '' ? $theChampSharingOptions[$theChampSharingOptions['alignment'].'_offset'] : 0) ?>, theChampCounterOffset = <?php echo (isset($theChampCounterOptions['alignment']) && $theChampCounterOptions['alignment'] != '' && isset($theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset']) && $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] != '' ? $theChampCounterOptions[$theChampCounterOptions['alignment'].'_offset'] : 0) ?>, theChampMobileStickySharingEnabled = <?php echo isset($theChampSharingOptions['vertical_enable']) && isset($theChampSharingOptions['bottom_mobile_sharing']) && $theChampSharingOptions['horizontal_screen_width'] != '' ? 1 : 0; ?>, heateorSsCopyLinkMessage = "<?php echo htmlspecialchars(__('Link copied.', 'super-socializer'), ENT_QUOTES); ?>";
		<?php
		if(isset($theChampSharingOptions['horizontal_re_providers']) && (isset($theChampSharingOptions['horizontal_more']) || in_array('Copy_Link', $theChampSharingOptions['horizontal_re_providers']))){
			$postId = 0;
			$postUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
			if(isset($theChampSharingOptions['horizontal_target_url'])){
				if($theChampSharingOptions['horizontal_target_url'] == 'default'){
					if($post){
						$postUrl = get_permalink($post->ID);
						$postId = $post->ID;
					}
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'home'){
					$postUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampSharingOptions['horizontal_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['horizontal_target_url_custom']) ? trim($theChampSharingOptions['horizontal_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				if($post){
					$postUrl = get_permalink($post->ID);
					$postId = $post->ID;
				}
			}
			$postUrl = heateor_ss_apply_target_share_url_filter($postUrl, 'horizontal', false);
			$sharingShortUrl = the_champ_generate_social_sharing_short_url($postUrl, $postId);
			echo 'var heateorSsHorSharingShortUrl = "'. $sharingShortUrl .'";';
		}
		if(isset($theChampSharingOptions['vertical_re_providers']) && (isset($theChampSharingOptions['vertical_more']) || in_array('Copy_Link', $theChampSharingOptions['vertical_re_providers']))){
			$postId = 0;
			$postUrl = html_entity_decode(esc_url(the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]));
			if(isset($theChampSharingOptions['vertical_target_url'])){
				if($theChampSharingOptions['vertical_target_url'] == 'default'){
					if($post){
						$postUrl = get_permalink($post->ID);
						$postId = $post->ID;
					}
				}elseif($theChampSharingOptions['vertical_target_url'] == 'home'){
					$postUrl = esc_url(home_url());
					$postId = 0;
				}elseif($theChampSharingOptions['vertical_target_url'] == 'custom'){
					$postUrl = isset($theChampSharingOptions['vertical_target_url_custom']) ? trim($theChampSharingOptions['vertical_target_url_custom']) : get_permalink($post->ID);
					$postId = 0;
				}
			}else{
				if($post){
					$postUrl = get_permalink($post->ID);
					$postId = $post->ID;
				}
			}
			$postUrl = heateor_ss_apply_target_share_url_filter($postUrl, 'vertical', false);
			$sharingShortUrl = the_champ_generate_social_sharing_short_url($postUrl, $postId);
			echo 'var heateorSsVerticalSharingShortUrl = "'. $sharingShortUrl .'";';
		}
		if(isset($theChampSharingOptions['horizontal_counts']) && isset($theChampSharingOptions['horizontal_counter_position'])){
			echo in_array($theChampSharingOptions['horizontal_counter_position'], array('inner_left', 'inner_right')) ? 'var theChampReduceHorizontalSvgWidth = true;' : '';
			echo in_array($theChampSharingOptions['horizontal_counter_position'], array('inner_top', 'inner_bottom')) ? 'var theChampReduceHorizontalSvgHeight = true;' : '';
		}
		if(isset($theChampSharingOptions['vertical_counts'])){
			echo isset($theChampSharingOptions['vertical_counter_position']) && in_array($theChampSharingOptions['vertical_counter_position'], array('inner_left', 'inner_right')) ? 'var theChampReduceVerticalSvgWidth = true;' : '';
			echo !isset($theChampSharingOptions['vertical_counter_position']) || in_array($theChampSharingOptions['vertical_counter_position'], array('inner_top', 'inner_bottom')) ? 'var theChampReduceVerticalSvgHeight = true;' : '';
		}
		?>
		</script>
		<?php
		if(!$combinedScript){
			wp_enqueue_script('the_champ_share_counts', plugins_url('js/front/sharing/sharing.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION, $inFooter);
		}
	}

	if($combinedScript){
		wp_enqueue_script('the_champ_combined_script', plugins_url('js/front/combined.js', __FILE__), array('jquery'), THE_CHAMP_SS_VERSION, $inFooter);
	}
}

/**
 * Stylesheets to load at front end
 */
function the_champ_frontend_styles(){
	global $theChampSharingOptions, $theChampGeneralOptions;
	?>
	<style type="text/css">
	.the_champ_horizontal_sharing .theChampSharing{
		<?php if ( $theChampSharingOptions['horizontal_bg_color_default'] != '' ) { ?>
			background-color: <?php echo $theChampSharingOptions['horizontal_bg_color_default'] ?>;
		<?php  } ?>
			color: <?php echo $theChampSharingOptions['horizontal_font_color_default'] ? $theChampSharingOptions['horizontal_font_color_default'] : '#fff' ?>;
		<?php
		$border_width = 0;
		if ( $theChampSharingOptions['horizontal_border_width_default'] != '' ) {
			$border_width = $theChampSharingOptions['horizontal_border_width_default'];
		} elseif ( $theChampSharingOptions['horizontal_border_width_hover'] != '' ) {
			$border_width = $theChampSharingOptions['horizontal_border_width_hover'];
		}
		?>
		border-width: <?php echo $border_width ?>px;
		border-style: solid;
		border-color: <?php echo $theChampSharingOptions['horizontal_border_color_default'] != '' ? $theChampSharingOptions['horizontal_border_color_default'] : 'transparent'; ?>;
	}
	<?php if ( $theChampSharingOptions['horizontal_font_color_default'] == '' ) { ?>
	.the_champ_horizontal_sharing .theChampTCBackground{
		color:#666;
	}
	<?php } ?>
	.the_champ_horizontal_sharing .theChampSharing:hover{
		<?php if ( $theChampSharingOptions['horizontal_bg_color_hover'] != '' ) { ?>
			background-color: <?php echo $theChampSharingOptions['horizontal_bg_color_hover'] ?>;
		<?php }
		if ( $theChampSharingOptions['horizontal_font_color_hover'] != '' ) { ?>
			color: <?php echo $theChampSharingOptions['horizontal_font_color_hover'] ?>;
		<?php  } ?>
		border-color: <?php echo $theChampSharingOptions['horizontal_border_color_hover'] != '' ? $theChampSharingOptions['horizontal_border_color_hover'] : 'transparent'; ?>;
	}
	.the_champ_vertical_sharing .theChampSharing{
		<?php if ( $theChampSharingOptions['vertical_bg_color_default'] != '' ) { ?>
			background-color: <?php echo $theChampSharingOptions['vertical_bg_color_default'] ?>;
		<?php } ?>
			color: <?php echo $theChampSharingOptions['vertical_font_color_default'] ? $theChampSharingOptions['vertical_font_color_default'] : '#fff' ?>;
		<?php
		$verticalBorderWidth = 0;
		if ( $theChampSharingOptions['vertical_border_width_default'] != '' ) {
			$verticalBorderWidth = $theChampSharingOptions['vertical_border_width_default'];
		} elseif ( $theChampSharingOptions['vertical_border_width_hover'] != '' ) {
			$verticalBorderWidth = $theChampSharingOptions['vertical_border_width_hover'];
		}
		?>
		border-width: <?php echo $verticalBorderWidth ?>px;
		border-style: solid;
		border-color: <?php echo $theChampSharingOptions['vertical_border_color_default'] != '' ? $theChampSharingOptions['vertical_border_color_default'] : 'transparent'; ?>;
	}
	<?php if ( $theChampSharingOptions['horizontal_font_color_default'] == '' ) { ?>
	.the_champ_vertical_sharing .theChampTCBackground{
		color:#666;
	}
	<?php } ?>
	.the_champ_vertical_sharing .theChampSharing:hover{
		<?php if ( $theChampSharingOptions['vertical_bg_color_hover'] != '' ) { ?>
			background-color: <?php echo $theChampSharingOptions['vertical_bg_color_hover'] ?>;
		<?php }
		if ( $theChampSharingOptions['vertical_font_color_hover'] != '' ) { ?>
			color: <?php echo $theChampSharingOptions['vertical_font_color_hover'] ?>;
		<?php  } ?>
		border-color: <?php echo $theChampSharingOptions['vertical_border_color_hover'] != '' ? $theChampSharingOptions['vertical_border_color_hover'] : 'transparent'; ?>;
	}
	<?php
	if ( isset( $theChampSharingOptions['horizontal_counts'] ) ) {
		$svg_height = $theChampSharingOptions['horizontal_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['horizontal_sharing_height'] : $theChampSharingOptions['horizontal_sharing_size'];
		if ( isset( $theChampSharingOptions['horizontal_counter_position'] ) && in_array( $theChampSharingOptions['horizontal_counter_position'], array( 'inner_top', 'inner_bottom' ) ) ) {
			$line_height_percent = $theChampSharingOptions['horizontal_counter_position'] == 'inner_top' ? 38 : 19;
			?>
			div.the_champ_horizontal_sharing .theChampSharingSvg{height:70%;margin-top:<?php echo $svg_height*15/100 ?>px}div.the_champ_horizontal_sharing .the_champ_square_count{line-height:<?php echo $svg_height*$line_height_percent/100 ?>px;}
			<?php
		} elseif ( isset( $theChampSharingOptions['horizontal_counter_position'] ) && in_array( $theChampSharingOptions['horizontal_counter_position'], array( 'inner_left', 'inner_right' ) ) ) { ?>
			div.the_champ_horizontal_sharing .theChampSharingSvg{width:50%;margin:auto;}div.the_champ_horizontal_sharing .the_champ_square_count{float:left;width:50%;line-height:<?php echo $svg_height; ?>px;}
			<?php
		} elseif ( isset( $theChampSharingOptions['horizontal_counter_position'] ) && in_array( $theChampSharingOptions['horizontal_counter_position'], array( 'left', 'right' ) ) ) { ?>
			div.the_champ_horizontal_sharing .the_champ_square_count{float:<?php echo $theChampSharingOptions['horizontal_counter_position'] ?>;margin:0 8px;line-height:<?php echo $svg_height + 2 * $border_width; ?>px;}
			<?php
		} elseif ( ! isset( $theChampSharingOptions['horizontal_counter_position'] ) || $theChampSharingOptions['horizontal_counter_position'] == 'top' ) { ?>
			div.the_champ_horizontal_sharing .the_champ_square_count{display: block}
			<?php
		}

	}
	if ( isset( $theChampSharingOptions['vertical_counts'] ) ) {
		$vertical_svg_height = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size'];
		$vertical_svg_width = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_width'] : $theChampSharingOptions['vertical_sharing_size'];
		if ( ( isset( $theChampSharingOptions['vertical_counter_position'] ) && in_array( $theChampSharingOptions['vertical_counter_position'], array( 'inner_top', 'inner_bottom' ) ) ) || ! isset( $theChampSharingOptions['vertical_counter_position'] ) ) {
			$vertical_line_height_percent = ! isset( $theChampSharingOptions['vertical_counter_position'] ) || $theChampSharingOptions['vertical_counter_position'] == 'inner_top' ? 38 : 19;
			?>
			div.the_champ_vertical_sharing .theChampSharingSvg{height:70%;margin-top:<?php echo $vertical_svg_height*15/100 ?>px}div.the_champ_vertical_sharing .the_champ_square_count{line-height:<?php echo $vertical_svg_height*$vertical_line_height_percent/100; ?>px;}
			<?php
		} elseif ( isset( $theChampSharingOptions['vertical_counter_position'] ) && in_array( $theChampSharingOptions['vertical_counter_position'], array( 'inner_left', 'inner_right' ) ) ) { ?>
			div.the_champ_vertical_sharing .theChampSharingSvg{width:50%;margin:auto;}div.the_champ_vertical_sharing .the_champ_square_count{float:left;width:50%;line-height:<?php echo $vertical_svg_height; ?>px;}
			<?php
		}  elseif ( isset( $theChampSharingOptions['vertical_counter_position'] ) && in_array( $theChampSharingOptions['vertical_counter_position'], array( 'left', 'right' ) ) ) { ?>
			div.the_champ_vertical_sharing .the_champ_square_count{float:<?php echo $theChampSharingOptions['vertical_counter_position'] ?>;margin:0 8px;line-height:<?php echo $vertical_svg_height; ?>px; <?php echo $theChampSharingOptions['vertical_counter_position'] == 'left' ? 'min-width:' . $vertical_svg_width*30/100 . 'px;display: block' : '';?>}
			<?php
		} elseif ( isset( $theChampSharingOptions['vertical_counter_position'] ) && $theChampSharingOptions['vertical_counter_position'] == 'top' ) { ?>
			div.the_champ_vertical_sharing .the_champ_square_count{display: block}
			<?php
		}
	}
	echo isset( $theChampSharingOptions['hide_mobile_sharing'] ) && $theChampSharingOptions['vertical_screen_width'] != '' ? '@media screen and (max-width:' . $theChampSharingOptions['vertical_screen_width'] . 'px){.the_champ_vertical_sharing{display:none!important}}' : '';
	$bottom_sharing_postion_inverse = $theChampSharingOptions['bottom_sharing_alignment'] == 'left' ? 'right' : 'left';
	$bottom_sharing_responsive_css = '';
	if($theChampSharingOptions['bottom_sharing_position_radio'] == 'responsive'){
		$vertical_sharing_icon_height = $theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size'];
		$num_sharing_icons = isset($theChampSharingOptions['vertical_re_providers']) ? count($theChampSharingOptions['vertical_re_providers']) : 0;
		$total_share_count_enabled = isset($theChampSharingOptions['vertical_total_shares']) ? 1 : 0;
		$more_icon_enabled = isset($theChampSharingOptions['vertical_more']) ? 1 : 0;
		$bottom_sharing_responsive_css = 'div.the_champ_bottom_sharing{width:100%!important;left:0!important;}div.the_champ_bottom_sharing li{width:'.(100/($num_sharing_icons+$total_share_count_enabled+$more_icon_enabled)).'% !important;}div.the_champ_bottom_sharing .theChampSharing{width: 100% !important;}div.the_champ_bottom_sharing div.theChampTotalShareCount{font-size:1em!important;line-height:' . ( $vertical_sharing_icon_height*70/100 ) . 'px!important}div.the_champ_bottom_sharing div.theChampTotalShareText{font-size:.7em!important;line-height:0px!important}';
	}
	echo isset($theChampSharingOptions['vertical_enable']) && isset( $theChampSharingOptions['bottom_mobile_sharing'] ) && $theChampSharingOptions['horizontal_screen_width'] != '' ? 'div.heateor_ss_mobile_footer{display:none;}@media screen and (max-width:' . $theChampSharingOptions['horizontal_screen_width'] . 'px){'.$bottom_sharing_responsive_css.'div.heateor_ss_mobile_footer{display:block;height:'.($theChampSharingOptions['vertical_sharing_shape'] == 'rectangle' ? $theChampSharingOptions['vertical_sharing_height'] : $theChampSharingOptions['vertical_sharing_size']).'px;}.the_champ_bottom_sharing{padding:0!important;' . ( $theChampSharingOptions['bottom_sharing_position_radio'] == 'nonresponsive' && $theChampSharingOptions['bottom_sharing_position'] != '' ? $theChampSharingOptions['bottom_sharing_alignment'] . ':' . $theChampSharingOptions['bottom_sharing_position'] . 'px!important;' . $bottom_sharing_postion_inverse . ':auto!important;' : '' ) . 'display:block!important;width: auto!important;bottom:' . ( isset( $theChampSharingOptions['vertical_total_shares'] ) ? '-10' : '-2' ) . 'px!important;top: auto!important;}.the_champ_bottom_sharing .the_champ_square_count{line-height: inherit;}.the_champ_bottom_sharing .theChampSharingArrow{display:none;}.the_champ_bottom_sharing .theChampTCBackground{margin-right: 1.1em !important}}' : '';
	echo $theChampGeneralOptions['custom_css'];
	?>
	</style>
	<?php
	wp_enqueue_style( 'the_champ_frontend_css', plugins_url( 'css/front.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
	$default_svg = false;
	if ( isset( $theChampSharingOptions['enable'] ) ) {
		if ( isset( $theChampSharingOptions['hor_enable'] ) ) {
			if ( isset( $theChampSharingOptions['horizontal_more'] ) ) {
				$default_svg = true;
			}
			if ( $theChampSharingOptions['horizontal_font_color_default'] != '' ) {
				wp_enqueue_style( 'the_champ_sharing_svg', plugins_url( 'css/share-default-svg-horizontal.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
			} else {
				$default_svg = true;
			}
			if ( $theChampSharingOptions['horizontal_font_color_hover'] != '' ) {
				wp_enqueue_style( 'the_champ_sharing_svg_hover', plugins_url( 'css/share-hover-svg-horizontal.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
			}
		}
		if ( isset( $theChampSharingOptions['vertical_enable'] ) ) {
			if ( isset( $theChampSharingOptions['vertical_more'] ) ) {
				$default_svg = true;
			}
			if ( $theChampSharingOptions['vertical_font_color_default'] != '' ) {
				wp_enqueue_style( 'the_champ_vertical_sharing_svg', plugins_url( 'css/share-default-svg-vertical.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
			} else {
				$default_svg = true;
			}
			if ( $theChampSharingOptions['vertical_font_color_hover'] != '' ) {
				wp_enqueue_style( 'the_champ_vertical_sharing_svg_hover', plugins_url( 'css/share-hover-svg-vertical.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
			}
		}
	}
	if ( $default_svg ) {
		wp_enqueue_style( 'the_champ_sharing_default_svg', plugins_url( 'css/share-svg.css', __FILE__ ), false, THE_CHAMP_SS_VERSION );
	}
}

/**
 * Create plugin menu in admin.
 */	
function the_champ_create_admin_menu(){
	$page = add_menu_page('Super Socializer by Heateor', 'Super Socializer', 'manage_options', 'heateor-ss-general-options', 'the_champ_general_options_page', plugins_url('images/logo.png', __FILE__));
	// general options page
	$generalOptionsPage = add_submenu_page( 'heateor-ss-general-options', __( "Super Socializer - General Options", 'super-socializer' ), __( "General Options", 'super-socializer' ), 'manage_options', 'heateor-ss-general-options', 'the_champ_general_options_page' );
	// facebook page
	$facebookPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Social Commenting', 'Social Commenting', 'manage_options', 'heateor-social-commenting', 'the_champ_facebook_page');
	// social login page
	$loginPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Social Login', 'Social Login', 'manage_options', 'heateor-social-login', 'the_champ_social_login_page');
	// social sharing page
	$sharingPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Social Sharing', 'Social Sharing', 'manage_options', 'heateor-social-sharing', 'the_champ_social_sharing_page');
	// like buttons page
	$counterPage = add_submenu_page('heateor-ss-general-options', 'Super Socializer - Like Buttons', 'Like Buttons', 'manage_options', 'heateor-like-buttons', 'the_champ_like_buttons_page');
	add_action('admin_print_scripts-' . $page, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-' . $page, 'the_champ_admin_style');
	add_action('admin_print_scripts-' . $page, 'the_champ_fb_sdk_script');
	add_action('admin_print_scripts-' . $generalOptionsPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-' . $generalOptionsPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_styles-' . $generalOptionsPage, 'the_champ_admin_style');
	add_action('admin_print_scripts-' . $facebookPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-' . $facebookPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_styles-' . $facebookPage, 'the_champ_admin_style');
	add_action('admin_print_scripts-' . $loginPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-' . $loginPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_styles-' . $loginPage, 'the_champ_admin_style');
	add_action('admin_print_scripts-' . $sharingPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-' . $sharingPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_scripts-' . $sharingPage, 'the_champ_admin_sharing_scripts');
	add_action('admin_print_styles-' . $sharingPage, 'the_champ_admin_style');
	add_action('admin_print_styles-' . $sharingPage, 'the_champ_admin_sharing_style');
	add_action('admin_print_scripts-' . $counterPage, 'the_champ_admin_scripts');
	add_action('admin_print_scripts-' . $counterPage, 'the_champ_fb_sdk_script');
	add_action('admin_print_scripts-' . $counterPage, 'the_champ_admin_counter_scripts');
	add_action('admin_print_styles-' . $counterPage, 'the_champ_admin_style');
}
add_action('admin_menu', 'the_champ_create_admin_menu');

/** 
 * Auto-approve comments made by social login users
 */ 
function the_champ_auto_approve_comment($approved){
	global $theChampLoginOptions; 
	if(empty($approved)){
		if(isset($theChampLoginOptions['autoApproveComment'])){ 
			$userId = get_current_user_id(); 
			$commentUser = get_user_meta($userId, 'thechamp_current_id', true); 
			if($commentUser !== false){ 
				$approved = 1; 
			}  
		} 
	} 
	return $approved;
}
add_action('pre_comment_approved', 'the_champ_auto_approve_comment');

/**
 * Place "fb-root" div in website footer
 */
function the_champ_fb_root_div(){
	?>
	<div id="fb-root"></div>
	<?php
}

/**
 * Show Social Avatar options at profile page
 */
function the_champ_show_avatar_option( $user ) {
	global $user_ID, $theChampLoginOptions;
	if ( isset( $theChampLoginOptions['enable'] ) ) {
		$dontUpdateAvatar = get_user_meta($user_ID, 'thechamp_dontupdate_avatar', true);
		?>
		<h3><?php _e( 'Social Avatar', 'super-socializer' ) ?></h3>
		<table class="form-table">
	        <tr>
	            <th><label for="ss_small_avatar"><?php _e( 'Small Avatar Url', 'super-socializer' ) ?></label></th>
	            <td><input id="ss_small_avatar" type="text" name="the_champ_small_avatar" value="<?php echo esc_attr(get_user_meta( $user->ID, 'thechamp_avatar', true )); ?>" class="regular-text" /></td>
	        </tr>
	        <tr>
	            <th><label for="ss_large_avatar"><?php _e( 'Large Avatar Url', 'super-socializer' ) ?></label></th>
	            <td><input id="ss_large_avatar" type="text" name="the_champ_large_avatar" value="<?php echo esc_attr(get_user_meta( $user->ID, 'thechamp_large_avatar', true )); ?>" class="regular-text" /></td>
	        </tr>
	        <tr>
	            <th><label for="ss_dontupdate_avatar_1"><?php _e( 'Do not fetch and update social avatar from my profile, next time I Social Login', 'super-socializer' ) ?></label></th>
	            <td><input id="ss_dontupdate_avatar_1" style="margin-right:5px" type="radio" name="ss_dontupdate_avatar" value="1" <?php echo $dontUpdateAvatar ? 'checked' : '' ?> /></td>
	        </tr>
	        <tr>
	            <th><label for="ss_dontupdate_avatar_0"><?php _e( 'Update social avatar, next time I Social Login', 'super-socializer' ) ?></label></th>
	            <td><input id="ss_dontupdate_avatar_0" style="margin-right:5px" type="radio" name="ss_dontupdate_avatar" value="0" <?php echo ! $dontUpdateAvatar ? 'checked' : '' ?> /></td>
	        </tr>
	    </table>
		<?php
	}
}
add_action( 'edit_user_profile', 'the_champ_show_avatar_option' );
add_action( 'show_user_profile', 'the_champ_show_avatar_option' );

/**
 * Save social avatar options from profile page
 */
function the_champ_save_avatar( $user_id ) { 	
 	if ( ! current_user_can( 'edit_user', $user_id ) ) {
 		return false;
 	}
 	if ( isset( $_POST['the_champ_small_avatar'] ) ) {
 		update_user_meta( $user_id, 'thechamp_avatar', esc_url(trim($_POST['the_champ_small_avatar'])) );
 	}
 	if ( isset( $_POST['the_champ_large_avatar'] ) ) {
 		update_user_meta( $user_id, 'thechamp_large_avatar', esc_url(trim($_POST['the_champ_large_avatar'])) );
 	}
	if ( isset( $_POST['ss_dontupdate_avatar'] ) ) {
		update_user_meta( $user_id, 'thechamp_dontupdate_avatar', intval( $_POST['ss_dontupdate_avatar'] ) );
	}
}
add_action( 'personal_options_update', 'the_champ_save_avatar' );
add_action( 'edit_user_profile_update', 'the_champ_save_avatar' );

if(!function_exists('array_replace')){
	/**
	 * Custom 'array_replace' function for PHP version < 5.3
	 */
	function array_replace(){
		$args = func_get_args();
		$numArgs = func_num_args();
		$res = array();
		for($i = 0; $i < $numArgs; $i++){
			if(is_array($args[$i])){
				foreach($args[$i] as $key => $val){
					$res[$key] = $val;
				}
			}else{
				trigger_error(__FUNCTION__ .'(): Argument #'.($i+1).' is not an array', E_USER_WARNING);
				return NULL;
			}
		}
		return $res;
	}
}

/**
 * Replace a value in array
 */
function the_champ_replace_array_value($array, $value, $replacement){
	return array_replace($array,
	    array_fill_keys(
	        array_keys($array, $value),
	        $replacement
	    )
	);
}

/**
 * Default options when plugin is installed
 */
function the_champ_save_default_options(){
	// general options
	add_option('the_champ_general', array(
	   'footer_script' => '1',
	   'delete_options' => '1',
	   'browser_msg_enable' => '1',
	   'browser_msg' => __('Your browser is blocking some features of this website. Please follow the instructions at {support_url} to unblock these.', 'super-socializer'),
	   'custom_css' => '',
	));

	// login options
	add_option('the_champ_login', array(
	   'title' => __('Login with your Social ID', 'super-socializer'),
	   'email_error_message' => __('Email you entered is already registered or invalid', 'super-socializer'),
	   'avatar' => 1,
	   'email_required' => 1,
	   'password_email' => 1,
	   'new_user_admin_email' => 1,
	   'email_popup_text' => __('Please enter a valid email address. You might be required to verify it', 'super-socializer'),
	   'enableAtLogin' => 1,
	   'enableAtRegister' => 1,
	   'enableAtComment' => 1,
	   'link_account' => 1,
	   'gdpr_enable' => 1,
	   'privacy_policy_url' => '',
	   'privacy_policy_optin_text' => 'I agree to my personal data being stored and used as per Privacy Policy',
	   'ppu_placeholder' => 'Privacy Policy'
	));
	
	// social commenting options
	add_option('the_champ_facebook', array(
	   'enable_commenting' => '1',
	   'enable_fbcomments' => '1',
	   'enable_page' => '1',
	   'enable_post' => '1',
	   'comment_lang' => get_locale(),
	   'commenting_order' => 'wordpress,facebook,googleplus,disqus',
	   'commenting_label' => 'Leave a reply',
	   'label_wordpress_comments' => 'Default Comments',
	   'label_facebook_comments' => 'Facebook Comments',
	   'label_googleplus_comments' => 'G+ Comments',
	   'label_disqus_comments' => 'Disqus Comments',
	));
	
	// sharing options
	add_option('the_champ_sharing', array(
	   'enable' => '1',
	   'horizontal_sharing_shape' => 'round',
	   'horizontal_sharing_size' => '35',
	   'horizontal_sharing_width' => '70',
	   'horizontal_sharing_height' => '35',
	   'horizontal_border_radius' => '',
	   'horizontal_font_color_default' => '',
	   'horizontal_sharing_replace_color' => '#fff',
	   'horizontal_font_color_hover' => '',
	   'horizontal_sharing_replace_color_hover' => '#fff',
	   'horizontal_bg_color_default' => '',
	   'horizontal_bg_color_hover' => '',
	   'horizontal_border_width_default' => '',
	   'horizontal_border_color_default' => '',
	   'horizontal_border_width_hover' => '',
	   'horizontal_border_color_hover' => '',
	   'vertical_sharing_shape' => 'square',
	   'vertical_sharing_size' => '40',
	   'vertical_sharing_width' => '80',
	   'vertical_sharing_height' => '40',
	   'vertical_border_radius' => '',
	   'vertical_font_color_default' => '',
	   'vertical_sharing_replace_color' => '#fff',
	   'vertical_font_color_hover' => '',
	   'vertical_sharing_replace_color_hover' => '#fff',
	   'vertical_bg_color_default' => '',
	   'vertical_bg_color_hover' => '',
	   'vertical_border_width_default' => '',
	   'vertical_border_color_default' => '',
	   'vertical_border_width_hover' => '',
	   'vertical_border_color_hover' => '',
	   'hor_enable' => '1',
	   'horizontal_target_url' => 'default',
	   'horizontal_target_url_custom' => '',
	   'title' => 'Spread the love',
	   'instagram_username' => '',
	   'comment_container_id' => 'respond',
	   'horizontal_re_providers' => array( 'facebook', 'twitter', 'google_plus', 'linkedin', 'pinterest', 'reddit', 'delicious', 'stumbleupon', 'whatsapp' ),
	   'hor_sharing_alignment' => 'left',
	   'top' => '1',
	   'post' => '1',
	   'page' => '1',
	   'horizontal_more' => '1',
	   'vertical_enable' => '1',
	   'vertical_target_url' => 'default',
	   'vertical_target_url_custom' => '',
	   'vertical_instagram_username' => '',
	   'vertical_comment_container_id' => 'respond',
	   'vertical_re_providers' => array( 'facebook', 'twitter', 'google_plus', 'linkedin', 'pinterest', 'reddit', 'delicious', 'stumbleupon', 'whatsapp' ),
	   'vertical_bg' => '',
	   'alignment' => 'left',
	   'left_offset' => '-10',
	   'right_offset' => '-10',
	   'top_offset' => '100',
	   'vertical_post' => '1',
	   'vertical_page' => '1',
	   'vertical_home' => '1',
	   'vertical_more' => '1',
	   'hide_mobile_sharing' => '1',
	   'vertical_screen_width' => '783',
	   'bottom_mobile_sharing' => '1',
	   'horizontal_screen_width' => '783',
	   'bottom_sharing_position' => '0',
	   'bottom_sharing_alignment' => 'left',
	   'bottom_sharing_position_radio' => 'responsive',
	   'bitly_username' => '',
	   'bitly_key' => '',
	   'share_count_cache_refresh_count' => '10',
	   'share_count_cache_refresh_unit' => 'minutes',
	   'language' => get_locale(),
	   'twitter_username' => '',
	   'buffer_username' => '',
	   'tweet_count_service' => 'newsharecounts'
	));

	// counter options
	add_option('the_champ_counter', array(
	   'left_offset' => '-10',
	   'right_offset' => '-10',
	   'top_offset' => '100',
	   'alignment' => 'left',
	));

	add_option('the_champ_ss_version', THE_CHAMP_SS_VERSION);
}

/**
 * Plugin activation function
 */
function the_champ_activate_plugin($networkWide){
	global $wpdb;
	if(function_exists('is_multisite') && is_multisite()){
		//check if it is network activation if so run the activation function for each id
		if($networkWide){
			$oldBlog =  $wpdb->blogid;
			//Get all blog ids
			$blogIds =  $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

			foreach($blogIds as $blogId){
				switch_to_blog($blogId);
				the_champ_save_default_options();
			}
			switch_to_blog($oldBlog);
			return;
		}
	}
	the_champ_save_default_options();
}
register_activation_hook(__FILE__, 'the_champ_activate_plugin');

/**
 * Save default options for the new subsite created
 */
function the_champ_new_subsite_default_options($blogId, $userId, $domain, $path, $siteId, $meta){
    if(is_plugin_active_for_network('super-socializer/super_socializer.php')){ 
        switch_to_blog($blogId);
        the_champ_save_default_options();
        restore_current_blog();
    }
}
add_action('wpmu_new_blog', 'the_champ_new_subsite_default_options', 10, 6);

/**
 * Set flag in database if browser message notification has been read
 */
function heateor_ss_browser_notification_read(){
	update_option('heateor_ss_browser_notification_read', '1');
	die;
}
add_action('wp_ajax_heateor_ss_browser_notification_read', 'heateor_ss_browser_notification_read');

/**
 * Set flag in database if GDPR notification has been read
 */
function heateor_ss_gdpr_notification_read(){
	update_option('heateor_ss_gdpr_notification_read', '1');
	die;
}
add_action('wp_ajax_heateor_ss_gdpr_notification_read', 'heateor_ss_gdpr_notification_read');

/**
 * Set flag in database if Facebook redirection notification has been read
 */
function heateor_ss_fb_redirection_notification_read(){
	update_option('heateor_ss_fb_redirection_notification_read', '1');
	die;
}
add_action('wp_ajax_heateor_ss_fb_redirection_notification_read', 'heateor_ss_fb_redirection_notification_read');

/**
 * Set flag in database if Twitter callback notification has been read
 */
function heateor_ss_twitter_callback_notification_read(){
	update_option('heateor_ss_twitter_callback_notification_read', '1');
	die;
}
add_action('wp_ajax_heateor_ss_twitter_callback_notification_read', 'heateor_ss_twitter_callback_notification_read');

/**
 * Set flag in database if Linkedin redirection notification has been read
 */
function heateor_ss_linkedin_redirection_notification_read(){
	update_option('heateor_ss_linkedin_redirection_notification_read', '1');
	die;
}
add_action('wp_ajax_heateor_ss_linkedin_redirection_notification_read', 'heateor_ss_linkedin_redirection_notification_read');

/**
 * Set flag in database if Google redirection notification has been read
 */
function heateor_ss_google_redirection_notification_read(){
	update_option('heateor_ss_google_redirection_notification_read', '1');
	die;
}
add_action('wp_ajax_heateor_ss_google_redirection_notification_read', 'heateor_ss_google_redirection_notification_read');

/**
 * Show notification related to add-on update
 */
function the_champ_addon_update_notification(){
	if(current_user_can('manage_options')){
		global $theChampLoginOptions;
		if(defined('HEATEOR_FB_COM_MOD_VERSION') && version_compare('1.2.5', HEATEOR_FB_COM_MOD_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Facebook Comments Moderation</h3>
				<p><?php _e('Update "Facebook Comments Moderation" add-on for compatibility with current version of Super Socialzer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_FB_COM_NOT_VERSION') && version_compare('1.1.7', HEATEOR_FB_COM_NOT_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Facebook Comments Notifier</h3>
				<p><?php _e('Update "Facebook Comments Notifier" add-on for compatibility with current version of Super Socialzer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_LOGIN_BUTTONS_VERSION') && version_compare('1.1.2', HEATEOR_SOCIAL_LOGIN_BUTTONS_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Login Buttons</h3>
				<p><?php _e('Update "Social Login Buttons" add-on for compatibility with current version of Super Socialzer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION') && version_compare('1.3.3', HEATEOR_SOCIAL_SHARE_MYCRED_INTEGRATION_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Share - myCRED Integration</h3>
				<p><?php _e('Update "Social Share myCRED Integration" add-on for maximum compatibility with current version of Super Socialzer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		if(defined('HEATEOR_SOCIAL_LOGIN_MYCRED_INTEGRATION_VERSION') && version_compare('1.2.1', HEATEOR_SOCIAL_LOGIN_MYCRED_INTEGRATION_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Login - myCRED Integration</h3>
				<p><?php _e('Update "Social Login myCRED Integration" add-on for maximum compatibility with current version of Super Socialzer', 'super-socializer') ?></p>
			</div>
			<?php
		}elseif(defined('HEATEOR_SOCIAL_LOGIN_MYCRED_INTEGRATION_VERSION') && version_compare('1.2.7', HEATEOR_SOCIAL_LOGIN_MYCRED_INTEGRATION_VERSION) > 0){
			?>
			<div class="error notice">
				<h3>Social Login - myCRED Integration</h3>
				<p><?php _e('Update "Social Login myCRED Integration" add-on for compatibility with LiveJournal Login of Super Socialzer', 'super-socializer') ?></p>
			</div>
			<?php
		}

		$currentVersion = get_option('the_champ_ss_version');

		if(version_compare('7.10.5', $currentVersion) < 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) && in_array('steam', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['steam_api_key']) || $theChampLoginOptions['steam_api_key'] == '')){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using Steam login save Steam API key <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-social-login'); ?></p>
			</div>
			<?php
		}
		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['providers']) &&
			(
				(in_array('facebook', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['fb_secret']) || $theChampLoginOptions['fb_secret'] == '')) || 
				(in_array('linkedin', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['li_secret']) || $theChampLoginOptions['li_secret'] == '') ) || 
				(in_array('google', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['google_secret']) || $theChampLoginOptions['google_secret'] == '')) ||
				(in_array('vkontakte', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['vk_secure_key']) || $theChampLoginOptions['vk_secure_key'] == '')) ||
				(in_array('twitch', $theChampLoginOptions['providers']) && (!isset($theChampLoginOptions['twitch_client_secret']) || $theChampLoginOptions['twitch_client_secret'] == ''))
			)
		){
			?>
			<div class="error">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('To continue using Social Login, save the secret keys <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-social-login'); ?></p>
			</div>
			<?php
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && is_array($theChampLoginOptions['providers']) && in_array('facebook', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_fb_redirection_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsFbRedirectionNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							action: 'heateor_ss_fb_redirection_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_fb_redirection_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_fb_redirection_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Valid OAuth redirect URIs" option in your Facebook app settings for Facebook login to work. For more details, check step 9 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url() . '/?SuperSocializerAuth=Facebook', 'http://support.heateor.com/how-to-get-facebook-app-id/'); ?><input type="button" onclick="heateorSsFbRedirectionNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11.14', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && is_array($theChampLoginOptions['providers']) && in_array('twitter', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_twitter_callback_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsTwitterCbNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							action: 'heateor_ss_twitter_callback_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_twitter_callback_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_twitter_callback_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Callback URLs" option in your Twitter app settings for Twitter login to work. For more details, check step 4 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url() . '/index.php?SuperSocializerAuth=Twitter', 'http://support.heateor.com/how-to-get-twitter-api-key-and-secret/'); ?><input type="button" onclick="heateorSsTwitterCbNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && is_array($theChampLoginOptions['providers']) && in_array('linkedin', $theChampLoginOptions['providers'])){
			if(!get_option('heateor_ss_linkedin_redirection_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsLinkedinRedirectionNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							action: 'heateor_ss_linkedin_redirection_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_linkedin_redirection_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_linkedin_redirection_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Authorized Redirect URLs" option in your Linkedin app settings for Linkedin login to work. For more details, check step 4 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url(), 'http://support.heateor.com/how-to-get-linkedin-api-key/'); ?><input type="button" onclick="heateorSsLinkedinRedirectionNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11', $currentVersion) <= 0 && isset($theChampLoginOptions['enable']) && is_array($theChampLoginOptions['providers']) && in_array('google', $theChampLoginOptions['providers']) && home_url() != the_champ_get_http() . $_SERVER['HTTP_HOST']){
			if(!get_option('heateor_ss_google_redirection_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsGoogleRedirectionNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							action: 'heateor_ss_google_redirection_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_google_redirection_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_google_redirection_notification" class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Add %s in "Authorized redirect URIs" option in your Google client settings for Google login to work. For more details, check step 11 <a href="%s" target="_blank">here</a>', 'super-socializer'), home_url(), 'http://support.heateor.com/how-to-get-google-plus-client-id/'); ?><input type="button" onclick="heateorSsGoogleRedirectionNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}
		}

		if(version_compare('7.11.12', $currentVersion) <= 0){
			if(isset($theChampLoginOptions['enable']) && $theChampLoginOptions['privacy_policy_url'] == ''){
				?>
				<div class="error">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('Save the url of privacy policy page of your website <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-social-login#tabs-3'); ?></p>
				</div>
				<?php
			}
			if(!get_option('heateor_ss_gdpr_notification_read')){
				?>
				<script type="text/javascript">
				function heateorSsGDPRNotificationRead(){
					jQuery.ajax({
						type: 'GET',
						url: '<?php echo get_admin_url() ?>admin-ajax.php',
						data: {
							action: 'heateor_ss_gdpr_notification_read'
						},
						success: function(data, textStatus, XMLHttpRequest){
							jQuery('#heateor_ss_gdpr_notification').fadeOut();
						}
					});
				}
				</script>
				<div id="heateor_ss_gdpr_notification" class="update-nag">
					<h3>Super Socializer</h3>
					<p><?php echo sprintf(__('This plugin is GDPR compliant. You need to update the privacy policy of your website regarding the personal data this plugin saves, as mentioned <a href="%s" target="_blank">here</a>', 'super-socializer'), 'http://support.heateor.com/gdpr-and-our-plugins'); ?><input type="button" onclick="heateorSsGDPRNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
				</div>
				<?php
			}

		}

		if(!get_option('heateor_ss_browser_notification_read')){
			?>
			<script type="text/javascript">
			function heateorSsBrowserNotificationRead(){
				jQuery.ajax({
					type: 'GET',
					url: '<?php echo get_admin_url() ?>admin-ajax.php',
					data: {
						action: 'heateor_ss_browser_notification_read'
					},
					success: function(data, textStatus, XMLHttpRequest){
						jQuery('#heateor_ss_browser_notification').fadeOut();
					}
				});
			}
			</script>
			<div id="heateor_ss_browser_notification" class="update-nag">
				<h3>Super Socializer</h3>
				<p><?php echo sprintf(__('Your website visitors will see a popup notification (only once) if their browsers block any of the features of the plugin so that they can change their browser settings to unblock these. You can turn it OFF by disabling "Show popup notification to users if their browsers block the plugin features" option <a href="%s">here</a>', 'super-socializer'), 'admin.php?page=heateor-ss-general-options'); ?><input type="button" onclick="heateorSsBrowserNotificationRead()" style="margin-left: 5px;" class="button button-primary" value="<?php _e('Okay', 'super-socializer') ?>" /></p>
			</div>
			<?php
		}
	}
}
add_action('admin_notices', 'the_champ_addon_update_notification');

/**
 * Update options based on plugin version check
 */
function the_champ_update_db_check(){
	$currentVersion = get_option('the_champ_ss_version');

	if($currentVersion && $currentVersion != THE_CHAMP_SS_VERSION){
		if(version_compare("7.11.13", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['gdpr_enable'] = 1;
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.11.12", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['privacy_policy_optin_text'] = 'I agree to my personal data being stored and used as per Privacy Policy';
			$theChampLoginOptions['ppu_placeholder'] = 'Privacy Policy';
			$theChampLoginOptions['privacy_policy_url'] = '';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.9", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['comment_container_id'] = 'respond';
			$theChampSharingOptions['vertical_comment_container_id'] = 'respond';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.8.22", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['bottom_sharing_position_radio'] = 'responsive';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		if(version_compare("7.8.14", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['link_account'] = '1';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("7.8.13", $currentVersion) > 0){
			global $theChampGeneralOptions;
			$theChampGeneralOptions['browser_msg_enable'] = '1';
			$theChampGeneralOptions['browser_msg'] = __('Your browser is blocking some features of this website. Please follow the instructions at {support_url} to unblock these.', 'super-socializer');
			update_option('the_champ_general', $theChampGeneralOptions);
		}

		if(version_compare("7.7", $currentVersion) > 0){
			global $theChampSharingOptions;
			$theChampSharingOptions['instagram_username'] = '';
			$theChampSharingOptions['vertical_instagram_username'] = '';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}
		
		if(version_compare("7.6", $currentVersion) > 0){
			global $theChampLoginOptions;
			$theChampLoginOptions['new_user_admin_email'] = '1';
			update_option('the_champ_login', $theChampLoginOptions);
		}

		if(version_compare("6.0", $currentVersion) > 0){
			global $theChampFacebookOptions;
			$theChampFacebookOptions['enable_post'] = '1';
			$theChampFacebookOptions['enable_page'] = '1';
			update_option('the_champ_facebook', $theChampFacebookOptions);
		}

		if(version_compare('7.0', $currentVersion) > 0){
			global $theChampSharingOptions, $theChampLoginOptions, $theChampGeneralOptions;
			
			$theChampSharingOptions['horizontal_re_providers'] = the_champ_replace_array_value($theChampSharingOptions['horizontal_re_providers'], 'google', 'google_plus');
			$theChampSharingOptions['vertical_re_providers'] = the_champ_replace_array_value($theChampSharingOptions['vertical_re_providers'], 'google', 'google_plus');

			// general options
			if(isset($theChampLoginOptions['footer_script'])){
				$theChampGeneralOptions['footer_script'] = '1';
			}
			if(isset($theChampSharingOptions['delete_options'])){
				$theChampGeneralOptions['delete_options'] = '1';
			}

			$theChampSharingOptions['horizontal_sharing_width'] = '70';
			$theChampSharingOptions['horizontal_sharing_height'] = '35';
			$theChampSharingOptions['horizontal_sharing_height'] = '35';
			$theChampSharingOptions['horizontal_border_radius'] = '';
		    $theChampSharingOptions['horizontal_font_color_default'] = '';
		    $theChampSharingOptions['horizontal_sharing_replace_color'] = '#fff';
		    $theChampSharingOptions['horizontal_font_color_hover'] = '';
		    $theChampSharingOptions['horizontal_sharing_replace_color_hover'] = '#fff';
		    $theChampSharingOptions['horizontal_bg_color_default'] = '';
		    $theChampSharingOptions['horizontal_bg_color_hover'] = '';
		    $theChampSharingOptions['horizontal_border_width_default'] = '';
		    $theChampSharingOptions['horizontal_border_color_default'] = '';
		    $theChampSharingOptions['horizontal_border_width_hover'] = '';
		    $theChampSharingOptions['horizontal_border_color_hover'] = '';
		    $theChampSharingOptions['vertical_sharing_width'] = '80';
			$theChampSharingOptions['vertical_sharing_height'] = '40';
			$theChampSharingOptions['vertical_border_radius'] = '';
			$theChampSharingOptions['vertical_font_color_default'] = '';
			$theChampSharingOptions['vertical_sharing_replace_color'] = '#fff';
			$theChampSharingOptions['vertical_font_color_hover'] = '';
			$theChampSharingOptions['vertical_sharing_replace_color_hover'] = '#fff';
			$theChampSharingOptions['vertical_bg_color_default'] = '';
			$theChampSharingOptions['vertical_bg_color_hover'] = '';
			$theChampSharingOptions['vertical_border_width_default'] = '';
			$theChampSharingOptions['vertical_border_color_default'] = '';
			$theChampSharingOptions['vertical_border_width_hover'] = '';
			$theChampSharingOptions['vertical_border_color_hover'] = '';
			$theChampSharingOptions['vertical_screen_width'] = '783';
			$theChampSharingOptions['horizontal_screen_width'] = '783';
			$theChampSharingOptions['bottom_sharing_position'] = '0';
			$theChampSharingOptions['bottom_sharing_alignment'] = 'left';
			$theChampSharingOptions['buffer_username'] = '';
			$theChampSharingOptions['language'] = get_locale();
			$theChampSharingOptions['tweet_count_service'] = 'newsharecounts';

			$customCss = '';
			if(isset($theChampSharingOptions['horizontal_counts'])){
				$theChampSharingOptions['horizontal_counter_position'] = 'top';
				$customCss .= '.the_champ_horizontal_sharing .the_champ_square_count{
			display:block;
			text-indent:0!important;
			visibility:hidden;
			background-color:#58B8F8!important;
			width:auto;
			height:auto;
			text-align:center;
			min-width:8px!important;
			padding:1px 4px!important;
			color:#fff!important;
			font-family:\'Open Sans\',arial,sans-serif!important;
			font-size:10px!important;
			font-weight:600!important;
			-webkit-border-radius:15px!important;
			border-radius:15px!important;
			-webkit-box-shadow:0 2px 2px rgba(0,0,0,.4);
			box-shadow:0 2px 2px rgba(0,0,0,.4);
			text-shadow:0 -1px 0 rgba(0,0,0,.2);
			line-height:14px!important;
			border:2px solid #fff!important;
			z-index:1;
			margin:2px auto!important;
			box-sizing:content-box!important
		}';
			}
			if(isset($theChampSharingOptions['vertical_counts'])){
				if(!isset($theChampSharingOptions['vertical_sharing_shape']) || $theChampSharingOptions['vertical_sharing_shape'] == 'square'){
					$theChampSharingOptions['vertical_counter_position'] = 'inner_top';
				}elseif($theChampSharingOptions['vertical_sharing_shape'] == 'round'){
					$theChampSharingOptions['vertical_counter_position'] = 'top';
					$customCss .= '.the_champ_vertical_sharing .the_champ_square_count{
			display:block;
			text-indent:0!important;
			visibility:hidden;
			background-color:#58B8F8!important;
			width:auto;
			height:auto;
			text-align:center;
			min-width:8px!important;
			padding:1px 4px!important;
			color:#fff!important;
			font-family:\'Open Sans\',arial,sans-serif!important;
			font-size:10px!important;
			font-weight:600!important;
			-webkit-border-radius:15px!important;
			border-radius:15px!important;
			-webkit-box-shadow:0 2px 2px rgba(0,0,0,.4);
			box-shadow:0 2px 2px rgba(0,0,0,.4);
			text-shadow:0 -1px 0 rgba(0,0,0,.2);
			line-height:14px!important;
			border:2px solid #fff!important;
			z-index:1;
			margin:2px auto!important;
			box-sizing:content-box!important
		}';
				}
			}
			$theChampGeneralOptions['custom_css'] = $customCss;

			update_option('the_champ_sharing', $theChampSharingOptions);
			update_option('the_champ_general', $theChampGeneralOptions);
		}

		if(version_compare($currentVersion, '6.9') > 0){
			global $theChampSharingOptions;
			if ( $theChampSharingOptions['horizontal_sharing_replace_color'] != '#fff' ) {
				the_champ_update_svg_css( $theChampSharingOptions['horizontal_sharing_replace_color'], 'share-default-svg-horizontal' );
			}
			if ( $theChampSharingOptions['horizontal_sharing_replace_color_hover'] != '#fff' ) {
				the_champ_update_svg_css( $theChampSharingOptions['horizontal_sharing_replace_color_hover'], 'share-hover-svg-horizontal' );
			}
			if ( $theChampSharingOptions['vertical_sharing_replace_color'] != '#fff' ) {
				the_champ_update_svg_css( $theChampSharingOptions['vertical_sharing_replace_color'], 'share-default-svg-vertical' );
			}
			if ( $theChampSharingOptions['vertical_sharing_replace_color_hover'] != '#fff' ) {
				the_champ_update_svg_css( $theChampSharingOptions['vertical_sharing_replace_color_hover'], 'share-hover-svg-vertical' );
			}
		}

		if(version_compare('7.2', $currentVersion) > 0){
			$theChampSharingOptions['share_count_cache_refresh_count'] = '10';
			$theChampSharingOptions['share_count_cache_refresh_unit'] = 'minutes';
			update_option('the_champ_sharing', $theChampSharingOptions);
		}

		update_option('the_champ_ss_version', THE_CHAMP_SS_VERSION);
	}
}
add_action('plugins_loaded', 'the_champ_update_db_check');

/**
 * Updates SVG CSS file according to chosen logo color
 */
function the_champ_update_svg_css( $colorToBeReplaced, $cssFile ) {
	$path = plugin_dir_url( __FILE__ ) . 'css/' . $cssFile . '.css';
	try{
		$content = file( $path );
		if ( $content !== false ) {
			$handle = fopen( dirname( __FILE__ ) . '/css/' . $cssFile . '.css','w' );
			if ( $handle !== false ) {
				foreach ( $content as $value ) {
				    fwrite( $handle, str_replace( '%23fff', str_replace( '#', '%23', $colorToBeReplaced ), $value ) );
				}
				fclose( $handle );
			}
		}
	}catch(Exception $e){}
}

/**
 * CSS to load at front end for AMP
 */
function the_champ_frontend_amp_css(){
	global $theChampSharingOptions;
	// background color of amp icons
	$css = 'a.heateor_ss_amp{padding:0 4px;}div.heateor_ss_horizontal_sharing a amp-img{display:inline-block;margin:0 4px;}.heateor_ss_amp_instagram img{background-color:#624E47}.heateor_ss_amp_yummly img{background-color:#E16120}.heateor_ss_amp_buffer img{background-color:#000}.heateor_ss_amp_delicious img{background-color:#53BEEE}.heateor_ss_amp_facebook img{background-color:#3C589A}.heateor_ss_amp_digg img{background-color:#006094}.heateor_ss_amp_email img{background-color:#649A3F}.heateor_ss_amp_float_it img{background-color:#53BEEE}.heateor_ss_amp_google img{background-color:#dd4b39}.heateor_ss_amp_google_plus img{background-color:#dd4b39}.heateor_ss_amp_linkedin img{background-color:#0077B5}.heateor_ss_amp_pinterest img{background-color:#CC2329}.heateor_ss_amp_print img{background-color:#FD6500}.heateor_ss_amp_reddit img{background-color:#247CED}.heateor_ss_amp_stocktwits img{background-color: #40576F}.heateor_ss_amp_stumbleupon img{background-color:#EA4823}.heateor_ss_amp_tumblr img{background-color:#29435D}.heateor_ss_amp_twitter img{background-color:#55acee}.heateor_ss_amp_vkontakte img{background-color:#5E84AC}.heateor_ss_amp_yahoo img{background-color:#8F03CC}.heateor_ss_amp_xing img{background-color:#00797D}.heateor_ss_amp_instagram img{background-color:#527FA4}.heateor_ss_amp_whatsapp img{background-color:#55EB4C}.heateor_ss_amp_aim img{background-color: #10ff00}.heateor_ss_amp_amazon_wish_list img{background-color: #ffe000}.heateor_ss_amp_aol_mail img{background-color: #2A2A2A}.heateor_ss_amp_app_net img{background-color: #5D5D5D}.heateor_ss_amp_baidu img{background-color: #2319DC}.heateor_ss_amp_balatarin img{background-color: #fff}.heateor_ss_amp_bibsonomy img{background-color: #000}.heateor_ss_amp_bitty_browser img{background-color: #EFEFEF}.heateor_ss_amp_blinklist img{background-color: #3D3C3B}.heateor_ss_amp_blogger_post img{background-color: #FDA352}.heateor_ss_amp_blogmarks img{background-color: #535353}.heateor_ss_amp_bookmarks_fr img{background-color: #E8EAD4}.heateor_ss_amp_box_net img{background-color: #1A74B0}.heateor_ss_amp_buddymarks img{background-color: #ffd400}.heateor_ss_amp_care2_news img{background-color: #6EB43F}.heateor_ss_amp_citeulike img{background-color: #2781CD}.heateor_ss_amp_comment img{background-color: #444}.heateor_ss_amp_diary_ru img{background-color: #E8D8C6}.heateor_ss_amp_diaspora img{background-color: #2E3436}.heateor_ss_amp_dihitt img{background-color: #FF6300}.heateor_ss_amp_diigo img{background-color: #4A8BCA}.heateor_ss_amp_douban img{background-color: #497700}.heateor_ss_amp_draugiem img{background-color: #ffad66}.heateor_ss_amp_dzone img{background-color: #fff088}.heateor_ss_amp_evernote img{background-color: #8BE056}.heateor_ss_amp_facebook_messenger img{background-color: #0084FF}.heateor_ss_amp_fark img{background-color: #555}.heateor_ss_amp_flipboard img{background-color: #CC0000}.heateor_ss_amp_folkd img{background-color: #0F70B2}.heateor_ss_amp_google_classroom img{background-color: #FFC112}.heateor_ss_amp_google_bookmarks img{background-color: #CB0909}.heateor_ss_amp_google_gmail img{background-color: #E5E5E5}.heateor_ss_amp_hacker_news img{background-color: #F60}.heateor_ss_amp_hatena img{background-color: #00A6DB}.heateor_ss_amp_instapaper img{background-color: #EDEDED}.heateor_ss_amp_jamespot img{background-color: #FF9E2C}.heateor_ss_amp_kakao img{background-color: #FCB700}.heateor_ss_amp_kik img{background-color: #2A2A2A}.heateor_ss_amp_kindle_it img{background-color: #2A2A2A}.heateor_ss_amp_known img{background-color: #fff101}.heateor_ss_amp_line img{background-color: #00C300}.heateor_ss_amp_livejournal img{background-color: #EDEDED}.heateor_ss_amp_mail_ru img{background-color: #356FAC}.heateor_ss_amp_mendeley img{background-color: #A70805}.heateor_ss_amp_meneame img{background-color: #FF7D12}.heateor_ss_amp_mixi img{background-color: #EDEDED}.heateor_ss_amp_myspace img{background-color: #2A2A2A}.heateor_ss_amp_netlog img{background-color: #2A2A2A}.heateor_ss_amp_netvouz img{background-color: #c0ff00}.heateor_ss_amp_newsvine img{background-color: #055D00}.heateor_ss_amp_nujij img{background-color: #D40000}.heateor_ss_amp_odnoklassniki img{background-color: #F2720C}.heateor_ss_amp_oknotizie img{background-color: #fdff88}.heateor_ss_amp_outlook_com img{background-color: #0072C6}.heateor_ss_amp_papaly img{background-color: #3AC0F6}.heateor_ss_amp_pinboard img{background-color: #1341DE}.heateor_ss_amp_plurk img{background-color: #CF682F}.heateor_ss_amp_pocket img{background-color: #f0f0f0}.heateor_ss_amp_polyvore img{background-color: #2A2A2A}.heateor_ss_amp_printfriendly img{background-color: #61D1D5}.heateor_ss_amp_protopage_bookmarks img{background-color: #413FFF}.heateor_ss_amp_pusha img{background-color: #0072B8}.heateor_ss_amp_qzone img{background-color: #2B82D9}.heateor_ss_amp_refind img{background-color: #1492ef}.heateor_ss_amp_rediff_mypage img{background-color: #D20000}.heateor_ss_amp_renren img{background-color: #005EAC}.heateor_ss_amp_segnalo img{background-color: #fdff88}.heateor_ss_amp_sina_weibo img{background-color: #ff0}.heateor_ss_amp_sitejot img{background-color: #ffc800}.heateor_ss_amp_skype img{background-color: #00AFF0}.heateor_ss_amp_sms img{background-color: #6ebe45}.heateor_ss_amp_slashdot img{background-color: #004242}.heateor_ss_amp_stumpedia img{background-color: #EDEDED}.heateor_ss_amp_svejo img{background-color: #fa7aa3}.heateor_ss_amp_symbaloo_feeds img{background-color: #6DA8F7}.heateor_ss_amp_telegram img{background-color: #3DA5f1}.heateor_ss_amp_trello img{background-color: #1189CE}.heateor_ss_amp_tuenti img{background-color: #0075C9}.heateor_ss_amp_twiddla img{background-color: #EDEDED}.heateor_ss_amp_typepad_post img{background-color: #2A2A2A}.heateor_ss_amp_viadeo img{background-color: #2A2A2A}.heateor_ss_amp_viber img{background-color: #8B628F}.heateor_ss_amp_wanelo img{background-color: #fff}.heateor_ss_amp_webnews img{background-color: #CC2512}.heateor_ss_amp_wordpress img{background-color: #464646}.heateor_ss_amp_wykop img{background-color: #367DA9}.heateor_ss_amp_yahoo_mail img{background-color: #400090}.heateor_ss_amp_yahoo_messenger img{background-color: #400090}.heateor_ss_amp_yoolink img{background-color: #A2C538}.heateor_ss_amp_youmob img{background-color: #3B599D}';

	// css for horizontal sharing bar
	if ( $theChampSharingOptions['horizontal_sharing_shape'] == 'round' ) {
		$css .= '.heateor_ss_amp amp-img{border-radius:999px;}';
	} elseif ( $theChampSharingOptions['horizontal_border_radius'] != '' ) {
		$css .= '.heateor_ss_amp amp-img{border-radius:' . $theChampSharingOptions['horizontal_border_radius'] . 'px;}';
	}

	echo $css;
}