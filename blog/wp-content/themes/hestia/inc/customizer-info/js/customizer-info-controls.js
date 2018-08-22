/**
 * Customizer info controls
 *
 * @package Hestia
 */

/* global requestpost */

( function( api ) {

	// Extends our custom "customizer-info" section.
	api.sectionConstructor['customizer-info'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	// Extends our custom "hestia_info_jetpack" section.
	api.sectionConstructor.hestia_info_woocommerce = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


// shorthand no-conflict safe document-ready function
jQuery(function($) {
	// Hook into the "notice-my-class" class we added to the notice, so
	// Only listen to YOUR notices being dismissed
	$( document ).on( 'click', '.hestia-notice .notice-dismiss', function () {
		var control_id = $( this ).parent().attr( 'id' ).replace( 'accordion-section-', '' );
		$.ajax({
			url: requestpost.ajaxurl,
			type: 'POST',
			data: {
				action: 'dismissed_notice_handler',
				control: control_id
			},
			success: function(data) {
				$( '#accordion-section-' + data ).fadeOut( 300, function() { $( this ).remove(); } );
			}
		} );
	} );
});
