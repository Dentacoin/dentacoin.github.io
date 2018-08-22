<?php
/**
 * Sync functions for control.
 *
 * @package Hestia
 * @since Hestia 1.1.3
 */

/**
 * Display editor for page editor control.
 *
 * @since 1.1.51
 */
function hestia_customize_editor() {
	?>
	<div id="wp-editor-widget-container" style="display: none;">
		<a class="close" href="javascript:WPEditorWidget.hideEditor();"><span class="icon"></span></a>
		<div class="editor">
			<?php
			$settings = array(
				'textarea_rows' => 55,
				'editor_height' => 260,
			);
			wp_editor( '', 'wpeditorwidget', $settings );
			?>
			<p><a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php _e( 'Save and close', 'hestia' ); ?></a></p>
		</div>
	</div>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'hestia_customize_editor', 1 );


/**
 * When the frontpage is edited, we set a flag with 'sync_customizer' value to know that we should update
 * hestia_page_editor and hestia_feature_thumbnail customizer controls.
 *
 * @param int $post_id ID of the post that we need to update.
 * @since 1.1.60
 */
function hestia_trigger_sync_from_page( $post_id ) {
	$frontpage_id = get_option( 'page_on_front' );
	if ( empty( $frontpage_id ) ) {
		return;
	}

	if ( intval( $post_id ) === intval( $frontpage_id ) ) {
		update_option( 'hestia_sync_needed', 'sync_customizer' );
	};
}
add_action( 'save_post', 'hestia_trigger_sync_from_page', 10 );

/**
 * When customizer is saved, we set the flag to 'sync_page' value to know that we should update the frontpage content
 * and feature image.
 *
 * @since 1.1.60
 */
function hestia_trigger_sync_from_customizer() {
	$frontpage_id = get_option( 'page_on_front' );
	if ( ! empty( $frontpage_id ) ) {
		update_option( 'hestia_sync_needed', 'sync_page' );
	}
}
add_action( 'customize_save', 'hestia_trigger_sync_from_customizer', 10 );

/**
 * Here, based on 'hestia_sync_needed' option value, we update either page or customizer controls and then we update
 * the flag as false to know that we don't need to update anything.
 *
 * @since 1.1.60
 */
function hestia_sync_controls() {
	$should_sync = get_option( 'hestia_sync_needed' );
	if ( $should_sync === false ) {
		return;
	}
	$frontpage_id = get_option( 'page_on_front' );
	if ( empty( $frontpage_id ) ) {
		return;
	}
	switch ( $should_sync ) {
		// Synchronize customizer controls with page content
		case 'sync_customizer':
			$content = get_post_field( 'post_content', $frontpage_id );
			set_theme_mod( 'hestia_page_editor', $content );

			$hestia_frontpage_featured = '';
			if ( has_post_thumbnail( $frontpage_id ) ) {
				$hestia_frontpage_featured = get_the_post_thumbnail_url( $frontpage_id );
			} else {
				$thumbnail = get_theme_mod( 'hestia_feature_thumbnail', get_template_directory_uri() . '/assets/img/contact.jpg' );
				if ( $thumbnail === get_template_directory_uri() . '/assets/img/contact.jpg' ) {
					$hestia_frontpage_featured = get_template_directory_uri() . '/assets/img/contact.jpg';
				}
			}
			set_theme_mod( 'hestia_feature_thumbnail', $hestia_frontpage_featured );
			break;
		// Synchronize frontpage content with customizer values.
		case 'sync_page':
			$content = get_theme_mod( 'hestia_page_editor' );
			if ( ! empty( $frontpage_id ) && ! empty( $content ) ) {
				if ( ! wp_is_post_revision( $frontpage_id ) ) {

					// update the post, which calls save_post again
					$post = array(
						'ID'           => $frontpage_id,
						'post_content' => wp_kses_post( $content ),
					);
					wp_update_post( $post );
				}
			}
			$thumbnail    = get_theme_mod( 'hestia_feature_thumbnail', get_template_directory_uri() . '/assets/img/contact.jpg' );
			$thumbnail_id = attachment_url_to_postid( $thumbnail );
			update_post_meta( $frontpage_id, '_thumbnail_id', $thumbnail_id );

			break;
	}
	update_option( 'hestia_sync_needed', false );
}
add_action( 'after_setup_theme', 'hestia_sync_controls' );


/**
 * This function updates controls from customizer (about content and featured background) when you change your frontpage.
 */
function hestia_ajax_call() {
	$pid          = $_POST['pid'];
	$return_value = array();

	$content = get_post_field( 'post_content', $pid );
	set_theme_mod( 'hestia_page_editor', $content );

	$hestia_frontpage_featured = '';
	if ( has_post_thumbnail( $pid ) ) {
		$hestia_frontpage_featured = get_the_post_thumbnail_url( $pid );
	} else {
		$thumbnail = get_theme_mod( 'hestia_feature_thumbnail', get_template_directory_uri() . '/assets/img/contact.jpg' );
		if ( $thumbnail === get_template_directory_uri() . '/assets/img/contact.jpg' ) {
			$hestia_frontpage_featured = get_template_directory_uri() . '/assets/img/contact.jpg';
		}
	}

	set_theme_mod( 'hestia_feature_thumbnail', $hestia_frontpage_featured );

	$return_value['post_content']   = $content;
	$return_value['post_thumbnail'] = $hestia_frontpage_featured;
	echo json_encode( $return_value );

	die();
}
add_action( 'wp_ajax_hestia_ajax_call', 'hestia_ajax_call' );

/**
 * Hestia allow all HTML tags in TinyMce editor.
 *
 * @param array $init_array TinyMce settings.
 *
 * @return array
 */
function hestia_override_mce_options( $init_array ) {
	$opts                                  = '*[*]';
	$init_array['valid_elements']          = $opts;
	$init_array['extended_valid_elements'] = $opts;
	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'hestia_override_mce_options' );



/**
 * Sync frontpage content with customizer control
 *
 * @param string $value New value.
 *
 * @return mixed
 */
function hestia_sync_content_from_control( $value, $old_value = '' ) {
	if ( ! is_customize_preview() ) {
		return '';
	}
	$frontpage_id = get_option( 'page_on_front' );
	if ( ! empty( $frontpage_id ) && ! empty( $value ) ) {
		if ( ! wp_is_post_revision( $frontpage_id ) ) {
			// update the post, which calls save_post again
			$post = array(
				'ID'           => $frontpage_id,
				'post_content' => wp_kses_post( $value ),
			);
			wp_update_post( $post );
		}
	}
	return $value;
}

/**
 * Filters for text format
 */
add_filter( 'hestia_text', 'wptexturize' );
add_filter( 'hestia_text', 'convert_smilies' );
add_filter( 'hestia_text', 'convert_chars' );
add_filter( 'hestia_text', 'wpautop' );
add_filter( 'hestia_text', 'shortcode_unautop' );
add_filter( 'hestia_text', 'do_shortcode' );
