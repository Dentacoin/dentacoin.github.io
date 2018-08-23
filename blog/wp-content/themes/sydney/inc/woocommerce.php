<?php
/**
 * Woocommerce wrappers
 *
 * @package Sydney
 */


if ( !class_exists('WooCommerce') )
    return;


/**
 * Add/remove actions
 */
function sydney_woo_actions() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    add_action('woocommerce_before_main_content', 'sydney_wc_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'sydney_wc_wrapper_end', 10);
}
add_action('wp','sydney_woo_actions');

/**
 * Theme wrappers
 */
function sydney_wc_wrapper_start() {
    echo '<div id="primary" class="content-area col-md-9">';
        echo '<main id="main" class="site-main" role="main">';
}

function sydney_wc_wrapper_end() {
        echo '</main>';
    echo '</div>';
}