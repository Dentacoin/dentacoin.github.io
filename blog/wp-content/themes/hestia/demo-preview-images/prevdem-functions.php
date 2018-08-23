<?php
/**
 * Preview functions.
 *
 * @author Themeisle
 * @package hestia
 * @version 1.1.2
 * @since 1.1.21
 */

/**
 * Get a random image from demo content
 * Can be recursive if a specific img size is not found
 *
 * @param int $i Maximum number of recalls.
 *
 * @return mixed
 */
function hestia_get_prevdem_img_src( $i = 0 ) {
	// prevent infinite loop
	if ( 10 == $i ) {
		return '';
	}

	$path = get_template_directory() . '/demo-preview-images/img/';

	// Build or re-build the global dem img array
	if ( ! isset( $GLOBALS['prevdem_img'] ) || empty( $GLOBALS['prevdem_img'] ) ) {
		$imgs       = array( '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg' );
		$candidates = array();

		foreach ( $imgs as $img ) {
			$candidates[] = $img;
		}
		$GLOBALS['prevdem_img'] = $candidates;
	}
	$candidates = $GLOBALS['prevdem_img'];
	// get a random image name
	$rand_key = array_rand( $candidates );
	$img_name = $candidates[ $rand_key ];

	// if file does not exists, reset the global and recursively call it again
	if ( ! file_exists( $path . $img_name ) ) {
		unset( $GLOBALS['prevdem_img'] );
		$i++;
		return hestia_get_prevdem_img_src( $i );
	}

	// unset all sizes of the img found and update the global
	$new_candidates = $candidates;
	foreach ( $candidates as $_key => $_img ) {
		if ( substr( $_img, 0, strlen( "{$img_name}" ) ) === "{$img_name}" ) {
			unset( $new_candidates[ $_key ] );
		}
	}
	$GLOBALS['prevdem_img'] = $new_candidates;
	return get_template_directory_uri() . '/demo-preview-images/img/' . $img_name;
}

/**
 * Filter thumbnail image
 *
 * @param string $input Post thumbnail.
 */
function hestia_the_post_thumbnail( $input ) {
	if ( empty( $input ) ) {
		$placeholder = hestia_get_prevdem_img_src();
		return '<img width="360" height="240" src="' . esc_url( $placeholder ) . '" class="attachment-hestia-blog size-hestia-blog wp-post-image">';
	}
	return $input;
}

add_filter( 'post_thumbnail_html', 'hestia_the_post_thumbnail' );
