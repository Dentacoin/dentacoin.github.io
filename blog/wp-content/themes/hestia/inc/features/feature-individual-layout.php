<?php
/**
 * Feature to control layout on individual posts and pages.
 *
 * @package hestia
 * @since 1.1.58
 */

/**
 * Register metabox to control layout on pages and posts.
 *
 * @since 1.1.58
 */
function hestia_individual_layout_metabox() {
	global $post;
	if ( ! empty( $post ) ) {
		$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

		/**
		 * For now, we are registering the metabox only for the default and page with sidebar templates.
		 * Any further templates with sidebar should be added there too
		 */
		$allowed_templates = array(
			'default',
			'page-templates/template-page-sidebar.php',
		);
		if ( in_array( $page_template, $allowed_templates ) || empty( $page_template ) ) {
			add_meta_box(
				'hestia-individual-layout', esc_html__( 'Layout', 'hestia' ), 'hestia_individual_layout_metabox_content', array(
					'post',
					'page',
				), 'side', 'low'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'hestia_individual_layout_metabox' );

/**
 * The metabox content.
 *
 * @since 1.1.58
 */
function hestia_individual_layout_metabox_content() {
	// $post is already set, and contains an object: the WordPress post
	global $post;
	$values   = get_post_custom( $post->ID );
	$selected = isset( $values['hestia_layout_select'] ) ? esc_attr( $values['hestia_layout_select'][0] ) : '';
	// We'll use this nonce field later on when saving.
	wp_nonce_field( 'hestia_individual_layout_nonce', 'individual_layout_nonce' );
	?>
	<p>
		<select name="hestia_layout_select" id="hestia_layout_select">
			<option value="default" <?php selected( $selected, 'default' ); ?>><?php echo esc_html__( 'Default', 'hestia' ); ?></option>
			<option value="full-width" <?php selected( $selected, 'full-width' ); ?>><?php echo esc_html__( 'Full Width', 'hestia' ); ?></option>
			<option value="sidebar-left" <?php selected( $selected, 'sidebar-left' ); ?>><?php echo esc_html__( 'Left Sidebar', 'hestia' ); ?></option>
			<option value="sidebar-right" <?php selected( $selected, 'sidebar-right' ); ?>><?php echo esc_html__( 'Right Sidebar', 'hestia' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Save metabox data.
 *
 * @param string $post_id Post id.
 * @since 1.1.58
 */
function hestia_individual_layout_metabox_save( $post_id ) {
	// Bail if we're doing an auto save
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// if our nonce isn't there, or we can't verify it, bail
	if ( ! isset( $_POST['individual_layout_nonce'] ) || ! wp_verify_nonce( $_POST['individual_layout_nonce'], 'hestia_individual_layout_nonce' ) ) {
		return;
	}

	// if our current user can't edit this post, bail
	if ( ! current_user_can( 'edit_post' ) ) {
		return;
	}

	if ( isset( $_POST['hestia_layout_select'] ) ) {
		update_post_meta( $post_id, 'hestia_layout_select', esc_attr( $_POST['hestia_layout_select'] ) );
	}
}
add_action( 'save_post', 'hestia_individual_layout_metabox_save' );
