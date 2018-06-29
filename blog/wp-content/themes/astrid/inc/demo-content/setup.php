<?php
/**
 * Functions to provide support for the One Click Demo Import plugin (wordpress.org/plugins/one-click-demo-import)
 *
 * @package Astrid
 */


/**
 * Set import files
 */
function astrid_set_import_files() {
    return array(
        array(
            'import_file_name'           => __('Demo content', 'astrid'),
            'local_import_file'          => trailingslashit( get_template_directory() ) . 'inc/demo-content/demo-content.xml',           
            'local_import_widget_file'   => trailingslashit( get_template_directory() ) . 'inc/demo-content/demo-widgets.wie',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'astrid_set_import_files' );

/**
 * Create the homepage to hold the widgets, before the import
 */
function astrid_before_content_import( $selected_import ) {

    $homepage = array(
      'post_title'    => 'Homepage',
      'post_type'     => 'page',  
      'post_content'  => '',
      'post_status'   => 'publish',
    );
     
    wp_insert_post( $homepage );
    $front_page = get_page_by_title( 'Homepage' );
    update_post_meta( $front_page -> ID, '_wp_page_template', 'page-templates/page_widgetized.php' );
}
add_action( 'pt-ocdi/before_content_import', 'astrid_before_content_import' );

/**
 * Define actions that happen after import
 */
function astrid_set_after_import_mods() {

    //Assign the menu
    $main_menu = get_term_by( 'name', 'Menu', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
            'primary'   => $main_menu->term_id,
            'footer'    => $main_menu->term_id,
        )
    );

    //Set header text and button
    set_theme_mod( 'header_text', __('5 minute setup', 'astrid') );
    set_theme_mod( 'header_subtext', __('Welcome to Astrid', 'astrid') );
    set_theme_mod( 'header_button', __('Explore', 'astrid') );
    set_theme_mod( 'header_button_url', '#primary' );

    //Asign the static front page and the blog page
    $front_page = get_page_by_title( 'Homepage' );
    $blog_page  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page -> ID );
    update_option( 'page_for_posts', $blog_page -> ID );
}
add_action( 'pt-ocdi/after_import', 'astrid_set_after_import_mods' );