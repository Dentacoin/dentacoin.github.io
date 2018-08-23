<?php
/**
 * Legacy Compatibility.
 *
 * ToDo: Remove in 1.1.41
 *
 * @package hestia
 * @since 1.1.37
 */


if ( ! function_exists( 'hestia_pll_string_register_helper' ) ) {
	/**
	 * Helper to register pll string.
	 *
	 * ToDo: Do not delete until 1.1.41
	 *
	 * @param String    $theme_mod Theme mod name.
	 * @param bool/json $default Default value.
	 * @param String    $name Name for polylang backend.
	 */
	function hestia_pll_string_register_helper( $theme_mod, $default = false, $name ) {
		return;
	}
}
