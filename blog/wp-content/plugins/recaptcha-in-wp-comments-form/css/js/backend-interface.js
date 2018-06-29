/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /js
 * File:        backend-interface.js
 * Since:       0.0.4
 */

/* 
 * Module:      Minor Back-End interface functions
 * Version:     0.0.9.0.2
 * Description: Minor HTML modifications for adding Save button to accordion section and rutine for saving hidden accordion sections
 */
jQuery ( document ).ready (function($) { 

	var id_alternate = griwpco.recaptcha_id, language, gr_elem = null;

	// Checkboxes control for accordion metaboxes
	$('.hide-postbox-tog').click(function () { var hidden = $( '.accordion-container li.accordion-section' ).filter(':hidden').map(function() { return this.id; }).get().join(','); $.post(ajaxurl, { action: 'closed-postboxes', hidden: hidden, closedpostboxesnonce: jQuery('#closedpostboxesnonce').val(), page: pagenow }); }); 
	
	
	// Save Matabox added to accordions
	$('#side-sortables').find('ul').append( $('#form-actions-section') );


	/** 
	 * Credits Link Output
	 */
	 $('#griwpc_params_allowCreditMode').on ( 'change', function () {
		if ( $('.plugin-credits').css('display') == 'none' )
			$('.plugin-credits').css('display', 'inherit');
		else
			$('.plugin-credits').css('display', 'none');
	 });
	 if ( parseInt( griwpco.realAllowCreditMode ) == 0 ) $('.plugin-credits').css('display', 'none' ); 


	/**
	 * Resetting reCAPTCHA field 
	 */
	function get_gr_elem () {
		window.setTimeout( function () {
			a = window.___grecaptcha_cfg.clients[0];
			$.each ( a, function ( i, v ) {
			if ( v != null ) {
								  
				if ( Object.keys(v).length ) {
					$.each ( v, function ( ii, vv ) {
						if ( ii == 'theme' )
							gr_elem = i;
					});
				}
			}
			});
		}, 1000 );
	};
	function put_new_recaptcha ( ) {
		window.___grecaptcha_cfg.clients[0][gr_elem]['size']  = griwpco.recaptcha_size;
		window.___grecaptcha_cfg.clients[0][gr_elem]['theme'] = griwpco.recaptcha_theme;
		window.___grecaptcha_cfg.clients[0][gr_elem]['type']  = griwpco.recaptcha_type;
		window.___grecaptcha_cfg.clients[0][gr_elem]['hl']    = language;
		grecaptcha.reset( griwpco.recaptcha_elem );
	}
	get_gr_elem();


	/**
	 * Radio Options
	 */
	function change_align_classes ( item ) {
		$( '#griwpc-container-id' ).removeClass ( 'recaptcha-align-left'   );
		$( '#griwpc-container-id' ).removeClass ( 'recaptcha-align-center' ); 
		$( '#griwpc-container-id' ).removeClass ( 'recaptcha-align-right'  );
		$( '#griwpc-container-id' ).addClass ( 'recaptcha-align-' + item.val() );
	}
	function put_options_tag ( item ) {
		item.closest( 'span' ).find ('img').removeClass ( 'wp-ui-highlight');
		item.closest('label').find ('img').addClass( 'wp-ui-highlight');
		t = item.closest ('label').find ('img').attr ('title');
		item.closest ('p').find ('.actual-selection').html ( t );
	}
	$(".radioImage").on( 'change', function () { 

		put_options_tag ( $(this) );
		part = $(this).data('part');
		
		if ( part == 'recaptcha_align' ) {
			change_align_classes ( $(this) );
		} else {
			if ( part != undefined ) {
				griwpco[ part ] = $(this).val();
				put_new_recaptcha();
			}
		}
		// fixing_credits_position ();
	});
	rImage = $(".radioImage");
	$.each ( rImage, function (i, v ) { 
		if ( $(v).is( ':checked' ) ) { 
			put_options_tag ( $(v) );											 
		}
	});
	
	/** 
	 * Subsection toggler
	 */
	$( '.subsection-toggler'). on('click', function () {
		$(this).toggleClass( '_closed _open');
		$(this).next().toggle( 300 );
	});
	 
	/**
	 * Restore default value buttons
	 */
	$('.button-restoredefaultvalue').on ( 'click', function (event) {
		event.preventDefault();															 
		target		= $(event.target).closest('p').find('input, textarea, select');
		target.val( target.data( 'defaultvalue' ) );
		target.trigger( 'change' );
		return false;
	});

	/**
	 * Language Selector
	 */
	function put_language_tag ( item ) {
		num = parseInt ( item.attr ( 'value' ) );
		oName = item.data('englishname');
		eName = item.data('nativename');
		if ( ( num == -1 ) || (num == -2 ) )
			$('#menu-item-recaptcha_lang-wrap' ). find ('.actual-selection').html ( eName );
		else
			$('#menu-item-recaptcha_lang-wrap' ). find ('.actual-selection').html ( eName + ' - <small>' + oName + '<small>' );
	}
    $.widget( "custom.langselectmenu", $.ui.selectmenu, {
		_renderItem: function( ul, item ) {
			var _isCurrent = item.element.attr( "selected" );
			var li = $( "<li>", { class: ( _isCurrent ) ? 'wp-ui-highlight is-current-language' : '' } );
			var wrapper = $( "<div>", { class: 'lang-item' } );
			var _eName  = $( "<span>", { text: item.element.data( "englishname" ), class: 'eName' } );
			var _oName  = $( "<span>", { text: item.element.data( "nativename" ) , class: 'oName' } );
			wrapper.append ( _eName );
			wrapper.append ( _oName );
			if ( item.disabled ) {
			  li.addClass( "ui-state-disabled" );
			}
			return li.append( wrapper ).appendTo( ul );
		}
    });
	$("#griwpc_params_recaptcha_lang")
	.langselectmenu({
		width: 314,
		position: { of: '#language-selector-button', my: 'center center', at: "center center" },
		select: function( event, ui ) { 
			$( event.currentTarget ).parent().find ('li').removeClass( 'wp-ui-highlight');
			$( event.currentTarget ).parent().find ('li').removeClass( 'is-current-language');
			$( event.currentTarget ).addClass( 'wp-ui-highlight is-current-language' );
			if ( ui.item.value == -1 ) {
				language = '';
			} else if ( ui.item.value == -2 ) {
				language = $('html').attr('lang');
			} else {
				language  = ui.item.value;
			}
			put_new_recaptcha ();
			put_language_tag ( ui.item.element );
		}
	});
	// Visual button trigger hidden select language jQueryUI field
	$( '#language-selector-button').on ( 'click', function () { $("#griwpc_params_recaptcha_lang-button").trigger('click') } );


	/**
	 * Initialization
	 */
	put_language_tag ( $( '#griwpc_params_recaptcha_lang').find ('option:selected') );
	$("#griwpc_params_recaptcha_lang-button").addClass( "ui-button wp-ui-highlight" );
	$("#griwpc_params_recaptcha_lang-button .ui-icon").addClass( "ui-selectmenu-icon" );

	cssHightLight = '.ui-button, .ui-button.ui-state-focus { background-color:'+ $("#griwpc_params_recaptcha_lang-button").css ( 'background-color' ) + '; color:'+ $("#griwpc_params_recaptcha_lang-button").css ( 'color' ) + ';} .slideThree label:hover, .ui-button:hover { background-color: #d5d5d5 !important; } .slideThree label:active, .ui-button:active { background-color: #C4C4C4 !important; }';
	$('head').append( '<style>' + cssHightLight + '</style>' );
	
});
