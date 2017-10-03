.<?php

function rudr_mailchimp_curl_connect( $url, $request_type, $api_key, $data = array() ) {
    if( $request_type == 'GET' )
        $url .= '?' . http_build_query($data);

    $mch = curl_init();
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '.base64_encode( 'user:'. $api_key )
    );
    curl_setopt($mch, CURLOPT_URL, $url );
    curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
    curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
    curl_setopt($mch, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection

    if( $request_type != 'GET' ) {
        curl_setopt($mch, CURLOPT_POST, true);
        curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
    }

    return curl_exec($mch);
}

/**
*Gets the member count for our list.
* @param void
* @return int The count of all members to our list
*/
function get_member_count() {
   $api_key = 'd99f356cf2ef83cb6261f64b7cbf2417-us15';
   $list_id_ico = '871dc3bc90';
   $list_id_dentacoin_lp = '5728a03ef8';
   $list_id_newsletter_pp = '8b75934ff5';
   $list_id_newsletter_ap = 'ee212b20d7';
   $list_id_presale_calc = '4560bf97a4';
   $list_id_website = '6906b05278';
   $list_id_manufacturers = '646a94fc52';
   $list_id_presale = '5e1244481c';
   $dc = 'us15';

   $url = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_ico;
   $url2 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_dentacoin_lp;
   $url3 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_newsletter_pp;
   $url4 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_newsletter_ap;
   $url5 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_presale_calc;
   $url6 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_website;
   $url7 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_manufacturers;
   $url8 = 'https://us15.api.mailchimp.com/3.0/lists/'.$list_id_presale;
   
   $body = json_decode( rudr_mailchimp_curl_connect( $url, 'GET', $api_key ) );
   $body2 = json_decode( rudr_mailchimp_curl_connect( $url2, 'GET', $api_key ) );
   $body3 = json_decode( rudr_mailchimp_curl_connect( $url3, 'GET', $api_key ) );
   $body4 = json_decode( rudr_mailchimp_curl_connect( $url4, 'GET', $api_key ) );
   $body5 = json_decode( rudr_mailchimp_curl_connect( $url5, 'GET', $api_key ) );
   $body6 = json_decode( rudr_mailchimp_curl_connect( $url6, 'GET', $api_key ) );
   $body7 = json_decode( rudr_mailchimp_curl_connect( $url7, 'GET', $api_key ) );
   $body8 = json_decode( rudr_mailchimp_curl_connect( $url8, 'GET', $api_key ) );
   
   $ico = $body->stats->member_count;
   $dentacoin_lp = $body2->stats->member_count;
   $newsletter_pp = $body3->stats->member_count;
   $newsletter_ap = $body4->stats->member_count;
   $presale_calc = $body5->stats->member_count;
   $website = $body6->stats->member_count;
   $manufacturers = $body7->stats->member_count;
   $presale = $body8->stats->member_count;

   $full_count = $ico + $dentacoin_lp + $newsletter_pp + $newsletter_ap + $presale_calc + $website + $manufacturers + $presale;

   return $full_count;
}


?>












?>