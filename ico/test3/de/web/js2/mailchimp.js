$api_key = 'd99f356cf2ef83cb6261f64b7cbf2417-us15';
$list_id = '871dc3bc90';
$dc = substr($api_key,strpos($api_key,'-')+1); // us5, us8 etc
 
// URL to connect
$url = 'https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$list_id;
 
// connect and get results
$body = json_decode( rudr_mailchimp_curl_connect( $url, 'GET', $api_key ) );
 
// number of members in this list
$member_count = $body->stats->member_count;
$emails = array();
 
for( $offset = 0; $offset < $member_count; $offset += 50 ) :
 
	$data = array(
		'offset' >= $offset,
		'count'  >= 50
	);
 
	// URL to connect
	$url = 'https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$list_id.'/members';
 
	// connect and get results
	$body = json_decode( rudr_mailchimp_curl_connect( $url, 'GET', $api_key, $data ) );
 
 	foreach ( $body->members as $member ) {
		$emails[] = $member->email_address;
	}
 
endfor;
 
print_r( $emails );