<?php
if( !defined('ABSPATH') ){ exit();}
if(isset($_POST) && isset($_POST['lnauth'] ))
{
	ob_clean();
}
if ( xyz_lnap_is_session_started() === FALSE ) session_start();


$state=md5(get_home_url());

$redirecturl=urlencode(admin_url('admin.php?page=linkedin-auto-publish-settings'));

$lnappikey=get_option('xyz_lnap_lnapikey');
$lnapisecret=get_option('xyz_lnap_lnapisecret');

if(isset($_POST['lnauth']))
{
	if (! isset( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'xyz_lnap_auth_nonce' )
			) {

				wp_nonce_ays( 'xyz_lnap_auth_nonce' );

				exit();

			}

			if(!isset($_GET['code']))
			{
				$linkedin_auth_url='https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='.$lnappikey.'&redirect_uri='.$redirecturl.'&state='.$state.'&scope=w_share+rw_company_admin';//rw_groups not included as it requires linkedin partnership agreement
				wp_redirect($linkedin_auth_url);
				echo '<script>document.location.href="'.$linkedin_auth_url.'"</script>';
				die;

			}
}
if( isset($_GET['error']) && isset($_GET['error_description']) )//if any error
{
	header("Location:".admin_url('admin.php?page=linkedin-auto-publish-settings&msg=1'));
	exit();
}
else if(isset($_GET['code']) && isset($_GET['state']) && $_GET['state']==$state)
{

	// 	$fields='grant_type=authorization_code&code='.$_GET['code'].'&redirect_uri='.$redirecturl.'&client_id='.$lnappikey.'&client_secret='.$lnapisecret;
	// 	$ln_acc_tok_json=xyzsmap_getpage('https://www.linkedin.com/uas/oauth2/accessToken', '', false, $fields);
	// 	$ln_acc_tok_json=$ln_acc_tok_json['content'];

	$url = 'https://www.linkedin.com/uas/oauth2/accessToken?grant_type=authorization_code&code='.$_GET['code'].'&redirect_uri='.$redirecturl.'&client_id='.$lnappikey.'&client_secret='.$lnapisecret;
	// Access Token request
	$response = wp_remote_post( $url, array(
			'method' => 'POST',
			'sslverify'=> (get_option('xyz_lnap_peer_verification')=='1') ? true : false  )
			);
	
	$ln_acc_tok_json=$response['body'];
	update_option('xyz_lnap_application_lnarray', $ln_acc_tok_json);
	update_option('xyz_lnap_lnaf',0);

	header("Location:".admin_url('admin.php?page=linkedin-auto-publish-settings&msg=4'));
	exit();
}

?>