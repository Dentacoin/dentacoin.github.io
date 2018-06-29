/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /js
 * File:        compatibility.js
 * Since:       0.0.8
 */

/* 
 * Module:      forced javascript reCATPCHA captcha output
 * Version:     0.0.9.0.2
 * Description: This module forces a javascript reCAPCTCHA output in case of the theme doesn't use comment_form() function
 */
// Old themes forced output mode
function GetElementById( n, id ) {
	var r = null;
	if ( n.getAttribute('id') == id ) return n;
	for ( var i = 0; i < n.childNodes.length; i++ ) {
		if ( n.childNodes[i].nodeType == 1 ) {
			r = GetElementById( n.childNodes[i], id );
			if ( r != null ) break;
		}
	}
	return r;
}		  
(function(c){ 
	var x=document.getElementById(c.formID), a=GetElementById(x,c.buttonID).parentNode, o=document.createElement( c.recaptcha_tag ), s='<span' + ' id="griwpc-widget-id" class="'+'g-recaptcha'+'"'+' data-forced="1" ></span>', prev = a.previousElementSibling;
	o.innerHTML=s;
	o.id="griwpc-container-id";
	o.className='google-recaptcha-container recaptcha-align-' + c.recaptcha_align;
	try { x.insertBefore(o,a); }
	catch (error) { prev.parentNode.insertBefore(o,prev.nextSibling); }
})(griwpco);