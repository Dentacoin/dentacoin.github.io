jQuery(document).ready( function($) { 

    $('.page-title-action').hide();

    // Initialize the CodeMirror editor
    if ( $('#content').length > 0 ) {
        var content_mode = $("#content").attr('mode');
        if ( content_mode == 'html' ) {
              var content_mode = {
                name: "htmlmixed",
                scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                mode: null}]
                 };
        }
        var options = {
            lineNumbers: true,
            mode: content_mode,
            matchBrackets: true
        };
        if ( typeof CCJ !== 'undefined' && CCJ.scroll !== '0' ) {
            options['scrollbarStyle'] = "simple";
        }


        var cm_width = $('#title').width() + 16;
        var cm_height = 500;

        var editor = CodeMirror.fromTextArea(document.getElementById("content"), options);

        editor.setSize(cm_width, cm_height);

        $('.CodeMirror').resizable({
            resize: function() {
                editor.setSize($(this).width(), $(this).height());
            } ,
            maxWidth: cm_width,
            minWidth: cm_width,
            minHeight: 200
            
        });

        $(window).resize(function () { 
            var cm_width = $('#title').width() + 16;
            var cm_height = $('.CodeMirror').height();
            editor.setSize(cm_width, cm_height);
        });



    }


    // For post.php or post-new.php pages show the code's title in the page title
    if ( $('#titlediv #title').length > 0 ) {
        var new_title = $("input[name=custom_code_language]").val().toUpperCase() + ' - ' + $('#titlediv #title').val();
        if( $('#titlediv #title').val().length > 0 ) {
            $(document).prop('title', new_title );
        }
        $('#titlediv #title').change(function() {
            if ( $(this).val().length > 0 ) {
                $(document).prop('title', new_title);
            } 
        });
    }


    // Make the inactive rows opaque
    if ( $('.dashicons-star-empty.ccj_row').length > 0 ) {
        $('.dashicons-star-empty.ccj_row').each(function(){
            $(this).parent().parent().parent().css('opacity', '0.4');
        });
    }

    // Activate/deactivate codes with AJAX
    $(".ccj_activate_deactivate").click( function(e) {
        var url = $(this).attr('href');
        var code_id = $(this).attr('data-code-id');
        e.preventDefault(); 
        $.ajax({
            url: url, 
            success: function(data){
                if (data === 'yes') {
                    ccj_activate_deactivate(code_id, false);
                }
                if (data === 'no') {
                    ccj_activate_deactivate(code_id, true);
                }
            }
        });
    });

    // Toggle the signs for activating/deactivating codes
    function ccj_activate_deactivate(code_id, action) {
        var row = $('tr#post-'+code_id);
        if ( action === true ) {
            row.css('opacity', '1');
            row.find('.row-actions .ccj_activate_deactivate')
                .text(CCJ.deactivate)
                .attr('title', CCJ.active_title);
            row.find('td.active .dashicons')
                .removeClass('dashicons-star-empty')
                .addClass('dashicons-star-filled');
            row.find('td.active .ccj_activate_deactivate')
                .attr('title', CCJ.active_title);
            $('#activate-action span').text(CCJ.active);
            $('#activate-action .ccj_activate_deactivate').text(CCJ.deactivate);
        } else {
            row.css('opacity', '0.4');
            row.find('.row-actions .ccj_activate_deactivate')
                .text(CCJ.activate)
                .attr('title', CCJ.deactive_title);
            row.find('td.active .dashicons')
                .removeClass('dashicons-star-filled')
                .addClass('dashicons-star-empty');
            row.find('td.active .ccj_activate_deactivate')
                .attr('title', CCJ.deactive_title);
            $('#activate-action span').text(CCJ.inactive);
            $('#activate-action .ccj_activate_deactivate').text(CCJ.activate);
        }
    }


    // Permalink slug
    $( '#titlediv' ).on( 'click', '.ccj-edit-slug', function() {
		var i, 
			$el, revert_e,
			c = 0,
            slug_value = $('#editable-post-name').html(),
			real_slug = $('#post_name'),
			revert_slug = real_slug.val(),
			permalink = $( '#sample-permalink' ),
			permalinkOrig = permalink.html(),
			permalinkInner = $( '#sample-permalink a' ).html(),
            permalinkHref = $('#sample-permalink a').attr('href'),
			buttons = $('#ccj-edit-slug-buttons'),
			buttonsOrig = buttons.html(),
			full = $('#editable-post-name-full');

		// Deal with Twemoji in the post-name.
		full.find( 'img' ).replaceWith( function() { return this.alt; } );
		full = full.html();

		permalink.html( permalinkInner );

		// Save current content to revert to when cancelling.
		$el = $( '#editable-post-name' );
		revert_e = $el.html();

        buttons.html( '<button type="button" class="save button button-small">' + postL10n.ok + '</button> <button type="button" class="cancel button- link">' + postL10n.cancel + '</button>' );


        // Save permalink changes.
		buttons.children( '.save' ).click( function() {
			var new_slug = $el.children( 'input' ).val();

			if ( new_slug == $('#editable-post-name-full').text() ) {
				buttons.children('.cancel').click();
				return;
			}

			$.post(
				ajaxurl,
				{
					action: 'ccj_permalink',
					code_id: $('#post_ID').val(),
					new_slug: new_slug,
                    permalink: permalinkHref, 
					ccj_permalink_nonce: $('#ccj-permalink-nonce').val()
				},
				function(data) {
					var box = $('#edit-slug-box');
					box.html(data);
					if (box.hasClass('hidden')) {
						box.fadeIn('fast', function () {
							box.removeClass('hidden');
						});
					}
				}
			);
		});

		// Cancel editing of permalink.
		buttons.children( '.cancel' ).click( function() {
			$('#view-post-btn').show();
			$el.html(revert_e);
			buttons.html(buttonsOrig);
			permalink.html(permalinkOrig);
			real_slug.val(revert_slug);
			$( '.ccj-edit-slug' ).focus();
		});

		$el.html( '<input type="text" name="new_slug" id="new-post-slug" value="' + slug_value + '" autocomplete="off" />' ).children( 'input' ).keydown( function( e ) {
			var key = e.which;
			// On [enter], just save the new slug, don't save the post.
			if ( 13 === key ) {
				e.preventDefault();
				buttons.children( '.save' ).click();
			}
			// On [esc] cancel the editing.
			if ( 27 === key ) {
				buttons.children( '.cancel' ).click();
			}
		} ).keyup( function() {
			real_slug.val( this.value );
		}).focus();


    });


});

