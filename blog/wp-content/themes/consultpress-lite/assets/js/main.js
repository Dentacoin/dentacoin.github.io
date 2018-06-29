/* global ConsultPressLiteVars, _ */

// config
require.config( {
	paths: {
		util:            'bower_components/bootstrap/js/dist/util',
		alert:           'bower_components/bootstrap/js/dist/alert',
		button:          'bower_components/bootstrap/js/dist/button',
		carousel:        'bower_components/bootstrap/js/dist/carousel',
		collapse:        'bower_components/bootstrap/js/dist/collapse',
		dropdown:        'bower_components/bootstrap/js/dist/dropdown',
		modal:           'bower_components/bootstrap/js/dist/modal',
		scrollspy:       'bower_components/bootstrap/js/dist/scrollspy',
		tab:             'bower_components/bootstrap/js/dist/tab',
		tooltip:         'bower_components/bootstrap/js/dist/tooltip',
		popover:         'bower_components/bootstrap/js/dist/popover',
	}
} );

require.config( {
	baseUrl: ConsultPressLiteVars.pathToTheme
} );

require( [
		'assets/js/TouchDropdown',
		'util',
		'collapse',
		'tab',
], function () {
	'use strict';

	jQuery( function ( $ ) {
		/**
		 * Animate the scroll, when back to top is clicked
		 */
		( function () {
			$( '.js-back-to-top' ).click( function ( ev ) {
				ev.preventDefault();

				$( 'body, html' ).animate( {
					scrollTop: 0
				}, 700 );
			});
		} )();


		/**
		 * Sidebar position
		 */
		(function () {
			var $sidebarContainer, $sidebarShifted;

			if ( $( 'body' ).hasClass( 'is-main-menu-undefined' ) ) {
				return;
			}

			var shiftBy = function () {
				return -( $sidebarContainer.offset().top - parseInt( $( 'html' ).css( 'marginTop' ) ) );
			};

			var shiftSidebar = function () {
				if ( Modernizr.mq( '(min-width: 992px)' ) ) {
					var shift = shiftBy();
					$sidebarShifted.css( 'transform', 'translateY( ' + shift + 'px )' );
					$sidebarContainer.css( 'height', $sidebarShifted.outerHeight() + shift );
				} else {
					$sidebarShifted.removeAttr( 'style' );
					$sidebarContainer.removeAttr( 'style' );
				}
			};

			// init
			$( document ).ready( function () {
				$sidebarContainer = $( '.js-sidebar' ).first();
				$sidebarShifted   = $sidebarContainer.children( '.sidebar__shift' );

				if ( ! $sidebarContainer.length || ! $sidebarShifted.length ) {
					$( '.sidebar' ).addClass( 'is-shown' ); // just in case something goes wrong
					return;
				}

				shiftSidebar();
				$sidebarContainer.addClass( 'is-shown' );

				// event listeners
				$( window ).on( 'resize.sidebarPos', _.debounce( shiftSidebar, 200 ) );
			} );
		}() );
	} );
});
