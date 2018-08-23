/*
 * Plugin:      Google reCAPTCHA in WP comments
 * Path:        /js
 * File:        recaptcha.js
 * Since:       0.0.2
 */

/* 
 * Module:      Recaptcha functions for init form and verify responses
 * Version:     0.0.9.0.2
 * Description: This module changes the HTML structure of the form when it's displayed for prevent automatic sending, then it verifies the user's response and when
 *              the user's response is correct it rewrites the HTML structure of the form.
 */
// Global var for storing the form attributes until the verification process is completed and correct.
var attrsa = {};

function fixing_credits_position () {
	window.setTimeout( function () {
		var target	= jQuery( '#griwpc-container-id' ),
			ifra	= jQuery( '#griwpc-widget-id').find ( 'iframe' ),
			credit	= jQuery('.plugin-credits'),
			size	= parseInt( ifra.attr ( 'width' ) );
		if ( target.hasClass ( 'recaptcha-align-left' ) ) {
			credit.css( 'right', 'unset' );
			credit.css( 'left', ( ( size - 20 ) / 2 ) + 'px' );
		} else if ( target.hasClass ( 'recaptcha-align-right' ) ) {
			credit.css( 'left', 'unset' );
			credit.css( 'right', ( ( size - 20 ) / 2 ) + 'px' );
		} else {
			credit.css( 'right', 'unset' );
			credit.css( 'left', '50%' );
		}
	}, 200 );
}

// Write/rewrite form HTML structure and block/unblock send button.
function change_button ( value, address  ) {
	
	var a, ele;
	
	if ( value === null ) {
		
		// ID compatibility	themes
		ele = jQuery( '#' + griwpco.formID ).find( '#' + griwpco.buttonID );
		if ( ele.length > 0 )
			ele.attr( 'disabled', '' );
		
		// Forcing blocked mode to all button, anchor, input, span type=submit HTML elements, even without ID
		ele = jQuery( '#' + griwpco.formID ).find( '[type=submit]' ); 
		if ( ele.length > 0 )
			ele.attr( 'disabled', '' );
		
		a = jQuery( '#' + griwpco.formID )[0].attributes;
		jQuery.each ( a, function (i, v ) {
			if ( v != undefined ) 
				attrsa[ v.name ] = v.value; 
		}); 
		jQuery.each ( attrsa, function (i, v ) {
			if ( ( i != 'id' ) && ( i != 'class' ) ) 
				jQuery( '#' + griwpco.formID ).removeAttr( i );
		});
		
		if ( 1 === parseInt( griwpco.allowCreditMode ) ) {
			jQuery( '.google-recaptcha-container' ).append ( '<span class="plugin-credits" style="font-size:0.62rem" ><a target="_blank" href="' + griwpco.home_link_address + '" title="' + griwpco.home_link_title + '" rel="nofollow" >' + griwpco.home_link_text + '</a></span>' );
		}
		
	}
	if ( value === true ) {
		
		// ID compatibility	themes
		ele = jQuery( '#' + griwpco.formID ).find( '#' + griwpco.buttonID );
		if ( ele.length > 0 )
			ele.removeAttr ('disabled');
		
		// Forcing blocked mode to all button, anchor, input, span type=submit HTML elements, even without ID
		ele = jQuery( '#' + griwpco.formID ).find( '[type=submit]' );
		if ( ele.length > 0 )
			ele.removeAttr ('disabled');
		
		jQuery.each ( attrsa, function (i, v ) { 
			jQuery( '#' + griwpco.formID ).attr( i, v );
		});
		
		jQuery( '#' + griwpco.formID ).append( '<input type="hidden" name="griwpcva" value="' + address + '">' );
		
	}
	
}

// Ajax connection for verifying response through the secret key
var griwpcVerifyCallback = function( griwpcr ) {
	jQuery.ajax({
		url		 : griwpco.ajax_url + '/wp-admin/admin-ajax.php',
		type	 : 'POST',
		data	 : { 
			'action' : 'griwpc_verify_recaptcha',
			'resp'	 : griwpcr,
		}, 
		dataType : 'json',
		success  : function( griwpcrr ) {
			if ( griwpcrr.data.result === 'OK' ) {
			   change_button ( true, griwpcrr.data.address );
			}
		},
		error : function( errorThrown ) {
			console.log(errorThrown);
		}
	});
};

// Global onload Method
var griwpcOnloadCallback = function() {
	griwpco.recaptcha_elem = grecaptcha.render( griwpco.recaptcha_id, {
	  'sitekey' : griwpco.recaptcha_skey,
	  'theme'	: griwpco.recaptcha_theme,
	  'type'	: griwpco.recaptcha_type,
	  'size'	: griwpco.recaptcha_size,
	  'tabindex' : 0,
	  'callback' : griwpcVerifyCallback
	});
};
(function ($) { change_button ( null, null); })(jQuery);


