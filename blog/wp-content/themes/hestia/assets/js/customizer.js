/**
 * Main customize js file
 *
 * @package Hestia
 */

/* global initializeAllElements */
/* exported hestiaGetCss */

( function( $ ) {

    /**
     * Live refresh for container width
     */
    wp.customize(
        'hestia_container_width', function( value ) {
            'use strict';
            value.bind(
                function( to ) {
                    if ( to ) {
                        var values = JSON.parse( to );
                        if ( values ) {
                            if ( values.mobile ) {
                                var settings = {
                                    selectors: 'div.container',
                                    cssProperty: 'max-width',
                                    propertyUnit: 'px',
                                    styleClass: 'hestia-container-width-css'
                                }, val;
                                val          = JSON.parse( to );
                                hestiaSetCss( settings, val );
                            }
                        }
                    }
                }
            );
        }
    );

	// Site Identity > Site Title
	wp.customize(
		'blogname', function( value ) {
			value.bind(
				function( newval ) {
					$( '.navbar .navbar-brand p' ).text( newval );
				}
			);
		}
	);

	// Site Identity > Site Description
	wp.customize(
		'blogdescription', function( value ) {
			value.bind(
				function( newval ) {
					$( '.blog .page-header .title' ).text( newval );
				}
			);
		}
	);

	// Appearance Settings > General Settings > Boxed Layout
	wp.customize(
		'hestia_general_layout', function( value ) {
			value.bind(
				function() {
					if ( $( '.main' ).hasClass( 'main-raised' ) ) {
						$( '.main' ).removeClass( 'main-raised' );
					} else {
						$( '.main' ).addClass( 'main-raised' );
					}
				}
			);
		}
	);

	// Appearance Settings > General Settings > Footer Credits
	wp.customize(
		'hestia_general_credits', function( value ) {
			value.bind(
				function( newval ) {
					$( '.footer-black .copyright' ).html( newval );
				}
			);
		}
	);

	// Footer Options > Alternative Footer Style
	wp.customize(
		'hestia_alternative_footer_style', function( value ) {
			value.bind(
				function() {
					var footer = $( '.footer.footer-big' );
					if ( footer.hasClass( 'footer-black' ) ) {
						footer.removeClass( 'footer-black' );
					} else {
						footer.addClass( 'footer-black' );
					}
				}
			);
		}
	);

	// Appearance Settings > Appearance Settings > General Settings > Sidebar Width
	wp.customize(
		'hestia_sidebar_width', function( value ) {
			value.bind(
				function( newval ) {
					if ( $( 'body > .wrapper' ).width() > 991 ) {
						var layout = wp.customize._value.hestia_page_sidebar_layout(), hestia_content_width, content_width;
						if (layout !== 'full-width' && layout !== '') {
							hestia_content_width = 100 - newval;

							if (newval <= 3 || newval >= 80) {
								hestia_content_width = 100;
								newval               = 100;
							}
							content_width = hestia_content_width - 8.33333333;

							$( '.content-sidebar-left, .content-sidebar-right, .page-content-wrap' ).css( 'width', hestia_content_width + '%' );
							$( '.blog-sidebar-wrapper:not(.no-variable-width), .shop-sidebar.col-md-3' ).css( 'width', newval + '%' );
						}

						layout = wp.customize._value.hestia_blog_sidebar_layout();
						if (layout !== 'full-width' && layout !== '') {
							hestia_content_width = 100 - newval;

							if (newval <= 3 || newval >= 80) {
								hestia_content_width = 100;
								newval               = 100;
								if (layout === 'sidebar-left') {
									$( '.blog-posts-wrap, .archive-post-wrap' ).removeClass( 'col-md-offset-1' );
								} else {
									$( 'body:not(.page) .blog-sidebar-wrapper:not(.no-variable-width)' ).removeClass( 'col-md-offset-1' );
								}
							} else {
								if (layout === 'sidebar-left') {
									$( '.blog-posts-wrap, .archive-post-wrap' ).addClass( 'col-md-offset-1' );
								} else {
									$( 'body:not(.page) .blog-sidebar-wrapper:not(.no-variable-width)' ).addClass( 'col-md-offset-1' );
								}
							}
							content_width = hestia_content_width - 8.33333333;

							$( '.blog-posts-wrap, .archive-post-wrap, .single-post-wrap' ).css( 'width', content_width + '%' );
							$( '.blog-sidebar-wrapper:not(.no-variable-width), .shop-sidebar-wrapper' ).css( 'width', newval + '%' );
						}
					}
				}
			);
		}
	);

	// Frontpage Sections > Features  > Title
	wp.customize(
		'hestia_features_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-features .title' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Features  > Subtitle
	wp.customize(
		'hestia_features_subtitle', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-features .description' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > About  > Featured Image
	wp.customize(
		'hestia_feature_thumbnail', function( value ) {
			value.bind(
				function( newval ) {
					if ( newval === '' ) {
						$( 'section#about' ).removeClass( 'section-image' );
					} else {
						$( 'section#about' ).addClass( 'section-image' );
					}
				}
			);
		}
	);

	// Frontpage Sections > Portfolio  > Title
	wp.customize(
		'hestia_portfolio_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-work .title' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Portfolio  > Subtitle
	wp.customize(
		'hestia_portfolio_subtitle', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-work .description' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Team  > Title
	wp.customize(
		'hestia_team_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-team .title' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Team  > Subtitle
	wp.customize(
		'hestia_team_subtitle', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-team .description' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Pricing  > Title
	wp.customize(
		'hestia_pricing_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.pricing .title' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Pricing  > Subtitle
	wp.customize(
		'hestia_pricing_subtitle', function( value ) {
			value.bind(
				function( newval ) {
					$( '.pricing .text-gray' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Pricing  > Pricing Table One: Title
	wp.customize(
		'hestia_pricing_table_one_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.pricing .col-md-6:nth-child(1) .card-pricing .category' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Pricing  > Pricing Table One: Text
	wp.customize(
		'hestia_pricing_table_one_text', function( value ) {
			value.bind(
				function( newval ) {
					$( '.pricing .col-md-6:nth-child(1) .card-pricing .btn' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Pricing  > Pricing Table Two: Title
	wp.customize(
		'hestia_pricing_table_two_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.pricing .col-md-6:nth-child(2) .card-pricing .category' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Pricing  > Pricing Table Two: Text
	wp.customize(
		'hestia_pricing_table_two_text', function( value ) {
			value.bind(
				function( newval ) {
					$( '.pricing .col-md-6:nth-child(2) .card-pricing .btn' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Testimonials  > Title
	wp.customize(
		'hestia_testimonials_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-testimonials .title' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Testimonials  > Subtitle
	wp.customize(
		'hestia_testimonials_subtitle', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-testimonials .description' ).text( newval );
				}
			);
		}
	);

	// Frontpage Sections > Subscribe  > Background
	wp.customize(
		'hestia_subscribe_background', function( value ) {
			value.bind(
				function( newval ) {
					$( '.subscribe-line' ).css( 'background-image', 'url(' + newval + ')' );
				}
			);
		}
	);

	// Frontpage Sections > Contact  > Background
	wp.customize(
		'hestia_contact_background', function( value ) {
			value.bind(
				function( newval ) {
					$( '.contactus' ).css( 'background-image', 'url(' + newval + ')' );
				}
			);
		}
	);

	// Blog Settiungs > Authors Section > Background
	wp.customize(
		'hestia_authors_on_blog_background', function( value ) {
			value.bind(
				function( newval ) {
					$( '#authors-on-blog.authors-on-blog' ).css( 'background-image', 'url(' + newval + ')' );
				}
			);
		}
	);

	// Blog Settiungs > Subscribe Section > Title
	wp.customize(
		'hestia_blog_subscribe_title', function( value ) {
			value.bind(
				function( newval ) {
					$( '#subscribe-on-blog .title' ).text( newval );
				}
			);
		}
	);

	// Blog Settiungs > Subscribe Section > Subtitle
	wp.customize(
		'hestia_blog_subscribe_subtitle', function( value ) {
			value.bind(
				function( newval ) {
					$( '#subscribe-on-blog .description' ).text( newval );
				}
			);
		}
	);

	// Colors > Accent Color
	wp.customize(
		'accent_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.main section:not(.hestia-blogs) a:not(.btn):not(.blog-item-title-link):not(.shop-item-title-link):not(.moretag):not(.button), .hestia-blogs article:nth-child(6n+1) .category a, .card-product .category a, .navbar.navbar-color-on-scroll:not(.navbar-transparent) li.active a' ).css( 'color', newval );
					$( '.btn.btn-primary:not(.no-js-color), .card .header-primary, input#searchsubmit, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce ul.products li.product .onsale, .woocommerce span.onsale, article .section-text a, .woocommerce .button:not(.btn-just-icon), .woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a, .hestia-work .portfolio-item:nth-child(6n+1) .label, .pagination span.current' ).css( 'background-color', newval );

					var accentColorVariation2 = convertHex( newval, 20 );
					var accentColorVariation3 = convertHex( newval, 42 );

					// LINKS HOVER STYLE
					var style = '<style class="hover-styles">', el;

					style += '.card-blog a.moretag:hover, aside .widget a:hover' +
					'{ color: ' + newval + '!important; }';

					style += '.card-blog a.moretag:hover, aside .widget a:hover' +
					'{ color: ' + newval + '!important; }';

					style += '.dropdown-menu li > a:hover' +
					'{ background-color:' + newval + '!important; }';

					// BUTTONS BOX SHADOW
					style += 'input#searchsubmit:hover, .pagination span.current, .btn.btn-primary:hover, .btn.btn-primary:focus, .btn.btn-primary:active, .btn.btn-primary.active, .btn.btn-primary:active:focus, .btn.btn-primary:active:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .added_to_cart.wc-forward:hover, .woocommerce .single-product div.product form.cart .button:hover, .woocommerce #respond input#submit:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, #add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled]:hover, .woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs.wc-tabs li.active a:hover, .woocommerce-message a.button:hover, .woocommerce a.button.wc-backward:hover, .hestia-sidebar-open.btn.btn-rose:hover, .hestia-sidebar-close.btn.btn-rose:hover' +
					'{	' +
					'-webkit-box-shadow: 0 14px 26px -12px' + accentColorVariation3 + ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' + accentColorVariation2 + '!important;' +
					'box-shadow: 0 14px 26px -12px ' + accentColorVariation3 + ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' + accentColorVariation2 + '!important;' +
					'}	';

					style += '.form-group.is-focused .form-control, div.wpforms-container .wpforms-form .form-group.is-focused .form-control, .nf-form-cont input:not([type=button]):focus, .nf-form-cont select:focus, .nf-form-cont textarea:focus, .woocommerce-cart .shop_table .actions .coupon .input-text:focus, .woocommerce-checkout #customer_details .input-text:focus, .woocommerce-checkout #customer_details select:focus, .woocommerce-checkout #order_review .input-text:focus, .woocommerce-checkout #order_review select:focus, .woocommerce-checkout .woocommerce-form .input-text:focus, .woocommerce-checkout .woocommerce-form select:focus, .woocommerce div.product form.cart .variations select:focus, .woocommerce .woocommerce-ordering select:focus {' +
					'background-image: -webkit-gradient(linear,left top, left bottom,from(' + newval + '),to(' + newval + ')),-webkit-gradient(linear,left top, left bottom,from(#d2d2d2),to(#d2d2d2));' +
					'background-image: -webkit-linear-gradient(' + newval + '),to(' + newval + '),-webkit-linear-gradient(#d2d2d2,#d2d2d2);' +
					'background-image: linear-gradient(' + newval + '),to(' + newval + '),linear-gradient(#d2d2d2,#d2d2d2);' +
					'}';

					style += '</style>';
					el     = $( '.hover-styles' ); // look for a matching style element that might already be there
					if ( el.length ) {
						el.replaceWith( style ); // style element already exists, so replace it
					} else {
						$( 'head' ).append( style ); // style element doesn't exist so add it
					}
				}
			);
		}
	);

	// Colors > Gradient Color
	wp.customize(
		'hestia_header_gradient_color', function( value ) {
			value.bind(
				function( newval ) {

					var gradientColor1 = convertHex( newval, 100 );
					var gradientColor2 = generateGradientSecondColor( newval, 100 );

					var style = '<style class="gradient-styles">';

					style += '.header-filter-gradient { background: linear-gradient(45deg, ' + gradientColor1 + ' 0%, ' + gradientColor2 + ' 100%); }';

					style += '</style>';

					$( 'head' ).append( style );
				}
			);
		}
	);

	// Colors > Secondary Color
	wp.customize(
		'secondary_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.main .title, .main .title a, .card-title,.card-title a, .info-title, .info-title a, .footer-brand, .footer-brand a, .media .media-heading, .media .media-heading a, .hestia-info .info-title, .card-blog a.moretag, .card .author a, aside .widget h5, aside .widget a, .hestia-about:not(.section-image) h1, .hestia-about:not(.section-image) h2, .hestia-about:not(.section-image) h3, .hestia-about:not(.section-image) h4, .hestia-about:not(.section-image) h5' ).css( 'color', newval );
					$( '.section-image .title, .section-image .card-plain .card-title, .card [class*="header-"] .card-title, .contactus .hestia-info .info-title, .hestia-work h4.card-title' ).css( 'color', '#fff' );
				}
			);
		}
	);

	// Colors > Body Color
	wp.customize(
		'body_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.description, .card-description, .footer-big, .hestia-features .hestia-info p, .text-gray, .card-description p, .hestia-about:not(.section-image) p, .hestia-about:not(.section-image) h6' ).css( 'color', newval );
					$( '.contactus .description' ).css( 'color', '#fff' );
				}
			);
		}
	);

	// Colors > Header/Slider Text Color
	wp.customize(
		'header_text_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.page-header, .page-header .hestia-title, .page-header .sub-title' ).css( 'color', newval );
				}
			);
		}
	);

	// Header options > Top Bar > Background color
	wp.customize(
		'hestia_top_bar_background_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-top-bar' ).css( 'background-color', newval );
				}
			);
		}
	);

	// Header options > Top Bar > Text color
	wp.customize(
		'hestia_top_bar_text_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-top-bar' ).css( 'color', newval );
				}
			);
		}
	);

	// Header options > Top Bar > Link color
	wp.customize(
		'hestia_top_bar_link_color', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-top-bar a' ).css( 'color', newval );
				}
			);
		}
	);

	// Header options > Top Bar > Link color on hover
	wp.customize(
		'hestia_top_bar_link_color_hover', function( value ) {
			value.bind(
				function( newval ) {
					$( '.hestia-top-bar a' ).hover(
						function(){
							$( this ).css( 'color', newval );
						}, function(){
							var initial = wp.customize._value.hestia_top_bar_link_color();
							$( this ).css( 'color', initial );
						}
					);
				}
			);
		}
	);

	if ( 'undefined' !== typeof wp && 'undefined' !== typeof wp.customize && 'undefined' !== typeof wp.customize.selectiveRefresh ) {
		wp.customize.selectiveRefresh.bind(
			'partial-content-rendered', function( placement ) {
				initializeAllElements( $( placement.container ) );
			}
		);
	}

	wp.customize(
		'header_video', function( value ) {
			value.bind(
				function( newval ) {
					var linkedControl = wp.customize._value.external_header_video();
					trigger_slider_selective( newval, linkedControl );
				}
			);
		}
	);

	wp.customize(
		'external_header_video', function( value ) {
			value.bind(
				function( newval ) {
					var linkedControl = wp.customize._value.header_video();
					trigger_slider_selective( newval, linkedControl );
				}
			);
		}
	);

	function trigger_slider_selective( newval, linkedControl ){
		if ( newval || linkedControl ) {
			return;
		}
		var partial        = wp.customize.selectiveRefresh.partial( 'hestia_slider_content' );
		var refreshPromise = wp.customize.selectiveRefresh.requestPartial( partial );
		if ( ! partial._pendingRefreshPromise ) {
			_.each(
				partial.placements(), function( placement ) {
					partial.preparePlacement( placement );
				}
			);

			refreshPromise.done(
				function( placements ) {
						_.each(
							placements, function( placement ) {
								partial.renderContent( placement );
							}
						);
				}
			);

			refreshPromise.fail(
				function( data, placements ) {
						partial.fallback( data, placements );
				}
			);

			// Allow new request when this one finishes.
			partial._pendingRefreshPromise = refreshPromise;
			refreshPromise.always(
				function() {
						partial._pendingRefreshPromise = null;
				}
			);
		}
	}

	function convertHex(hex,opacity){
		hex   = hex.replace( '#','' );
		var r = parseInt( hex.substring( 0,2 ), 16 );
		var g = parseInt( hex.substring( 2,4 ), 16 );
		var b = parseInt( hex.substring( 4,6 ), 16 );

		var result = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity / 100 + ')';
		return result;
	}

	function generateGradientSecondColor(hex, opacity){
		hex   = hex.replace( '#','' );
		var r = parseInt( hex.substring( 0,2 ), 16 );
		var g = parseInt( hex.substring( 2,4 ), 16 );
		var b = parseInt( hex.substring( 4,6 ), 16 );

		var x = r + 66;
		var y = g + 28;
		var z = b - 21;

		if ( x >= 255 ) {
			x = 255; }
		if ( y >= 255 ) {
			y = 255; }
		if ( z <= 0 ) {
			z = 0; }

		var result = 'rgba(' + x + ',' + y + ',' + z + ',' + opacity / 100 + ')';
		return result;
	}

	$( document ).on(
		'DOMNodeInserted', '.customize-partial-edit-shortcut', function () {
			$( this ).on(
				'click', function(){
					var controls = ['hestia_page_editor', 'hestia_contact_content_new'];
					var clickedControl = $( this ).attr('class');
					var openControl = '';
                    $.each(controls, function(index, value){
						if (clickedControl.indexOf( value ) !== -1){
                            openControl = value;
                            return false;
						}
					});
                    if( openControl !== ''){
                        wp.customize.preview.send( 'trigger-open-editor', openControl );
					} else {
                        wp.customize.preview.send( 'trigger-close-editor');
                    }
				}
			);
		}
	);

} )( jQuery );





/**
 * This function builds two arrays of settings for each value from arraySizes. Those two arrays are parameters for
 * hestiaSetCss function. Those parameters are:
 * 	data: an object with desktop, tablet and mobile value
 * 	settings: an object with class of the style tag and the selectors on witch the style will be applied
 *
 *
 * @param arraySizes
 * An object with multiple sizes. Foreach size you have to specify:
 * 	selectors on which to apply sizes
 * 	list of values on mobile, tablet and desktop
 *
 * @param settings
 * An object with the following components:
 * cssProperty: what css property is changed (ex: font-size, width etc. )
 * propertyUnit: unit (ex: px, em etc.)
 * styleClass: the class of the temporary style tag that is added while changing the control.
 *
 * @param to
 * Current value of the control
 */
function hestiaGetCss( arraySizes, settings, to ) {
    'use strict';
    var data, desktopVal, tabletVal, mobileVal,
        className = settings.styleClass, i = 1;

    var val = JSON.parse( to );
    if ( typeof( val ) === 'object' && val !== null ) {
        if ('desktop' in val) {
            desktopVal = val.desktop;
        }
        if ('tablet' in val) {
            tabletVal = val.tablet;
        }
        if ('mobile' in val) {
            mobileVal = val.mobile;
        }
    }

    for ( var key in arraySizes ) {
        // skip loop if the property is from prototype
        if ( ! arraySizes.hasOwnProperty( key )) {
            continue;
        }
        var obj = arraySizes[key];
        var limit = 0;
        var correlation = [1,1,1];
        if ( typeof( val ) === 'object' && val !== null ) {

            if( typeof obj.limit !== 'undefined'){
                limit = obj.limit;
            }

            if( typeof obj.correlation !== 'undefined'){
                correlation = obj.correlation;
            }

            data = {
                desktop: ( parseInt(parseFloat( desktopVal ) / correlation[0]) + obj.values[0]) > limit ? ( parseInt(parseFloat( desktopVal ) / correlation[0]) + obj.values[0] ) : limit,
                tablet: ( parseInt(parseFloat( tabletVal ) / correlation[1]) + obj.values[1] ) > limit ? ( parseInt(parseFloat( tabletVal ) / correlation[1]) + obj.values[1] ) : limit,
                mobile: ( parseInt(parseFloat( mobileVal ) / correlation[2]) + obj.values[2] ) > limit ? ( parseInt(parseFloat( mobileVal ) / correlation[2]) + obj.values[2] ) : limit
            };
        } else {
            if( typeof obj.limit !== 'undefined'){
                limit = obj.limit;
            }

            if( typeof obj.correlation !== 'undefined'){
                correlation = obj.correlation;
            }
            data =( parseInt( parseFloat( to ) / correlation[0] ) ) + obj.values[0] > limit ? ( parseInt( parseFloat( to ) / correlation[0] ) ) + obj.values[0] : limit;
        }
        settings.styleClass = className + '-' + i;
        settings.selectors  = obj.selectors;

        hestiaSetCss( settings, data );
        i++;
    }
}

/**
 * Add media query on settings from setStyle function.
 *
 * @param settings
 * An object with the following components:
 * 	styleClass class that will be on style tag
 * 	selectors specified selectors
 *
 * @param to
 * Current value of the control
 */
function hestiaSetCss( settings, to ){
    'use strict';
    var result     = '';
    var styleClass = jQuery( '.' + settings.styleClass );
    if ( to !== null && typeof to === 'object' ) {
        jQuery.each(
            to, function ( key, value ) {
                var style_to_add;
                if ( settings.selectors === '.container' ) {
                    style_to_add = settings.selectors + '{ ' + settings.cssProperty + ':' + value + settings.propertyUnit + '; max-width: 100%; }';
                } else {
                    style_to_add = settings.selectors + '{ ' + settings.cssProperty + ':' + value + settings.propertyUnit + '}';
                }
                switch ( key ) {
                    case 'desktop':
                        result += style_to_add;
                        break;
                    case 'tablet':
                        result += '@media (max-width: 767px){' + style_to_add + '}';
                        break;
                    case 'mobile':
                        result += '@media (max-width: 480px){' + style_to_add + '}';
                        break;
                }
            }
        );
        if ( styleClass.length > 0 ) {
            styleClass.text( result );
        } else {
            jQuery( 'head' ).append( '<style type="text/css" class="' + settings.styleClass + '">' + result + '</style>' );
        }
    } else {
        jQuery( settings.selectors ).css( settings.cssProperty, to + 'px' );
    }
}

