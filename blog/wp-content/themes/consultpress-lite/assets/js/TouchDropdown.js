( function ( $ ) {
	'use strict';

	// We assume there is a global Moderniz object with test for touch
	if ( !! Modernizr && Modernizr.touchevents && Modernizr.mq( '(min-width: 992px)' ) ) {

		// Add the .js-dropdown class to all sub-menus
		$( 'ul.js-dropdown' ).find( '.sub-menu' ).addClass( 'js-dropdown' );

		// Each menu should where we want to add dropdown functionality should have a .js-dropdown class
		$( 'ul.js-dropdown' ).each( function ( i, elm ) {
			$( elm ).children( '.menu-item-has-children' ).on( 'click.td', 'a', function ( ev ) {
				ev.preventDefault();

				// Clear the hover state if you switch to other dropdown menu
				$( elm ).children( '.is-hover' ).removeClass( 'is-hover' );

				$( ev.delegateTarget ).addClass( 'is-hover' );
				$( ev.delegateTarget ).off( 'click.td' );
			} );
		} );
	}

}( jQuery ) );