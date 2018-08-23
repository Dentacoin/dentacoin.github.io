<?php
	/**
	 * ReduxFramework Sample Config File
	 * For full documentation, please visit: http://docs.reduxframework.com/
	 */

	if ( ! class_exists( 'Redux' ) ) {
		return;
	}


	// This is your option name where all the Redux data is stored.
	$opt_name = "xclean_settings";

	// This line is only for altering the demo. Can be easily removed.
	$opt_name = apply_filters( 'xclean_settings/opt_name', $opt_name );

	/*
	 *
	 * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
	 *
	 */

	$theme = wp_get_theme(); // For use with some settings. Not necessary.

	$args = array(
		// TYPICAL -> Change these values as you need/desire
		'opt_name'             => $opt_name,
		// This is where your data is stored in the database and also becomes your global variable name.
		'display_name'         => $theme->get( 'Name' ),
		// Name that appears at the top of your panel
		'display_version'      => $theme->get( 'Version' ),
		// Version that appears at the top of your panel
		'menu_type'            => 'menu',
		//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
		'allow_sub_menu'       => true,
		// Show the sections below the admin menu item or not
		'menu_title'           => __( 'Theme Options', 'xclean' ),
		'page_title'           => __( 'Theme Options', 'xclean' ),
		// You will need to generate a Google API key to use this feature.
		// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
		'google_api_key'       => '',
		// Set it you want google fonts to update weekly. A google_api_key value is required.
		'google_update_weekly' => false,
		// Must be defined to add google fonts to the typography module
		'async_typography'     => true,
		// Use a asynchronous font on the front end or font string
		//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
		'admin_bar'            => true,
		// Show the panel pages on the admin bar
		'admin_bar_icon'       => 'dashicons-portfolio',
		// Choose an icon for the admin bar menu
		'admin_bar_priority'   => 50,
		// Choose an priority for the admin bar menu
		'global_variable'      => '',
		// Set a different name for your global variable other than the opt_name
		'dev_mode'             => false,
		// Show the time the page took to load, etc
		'update_notice'        => true,
		// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
		'customizer'           => true,
		// Enable basic customizer support
		//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
		//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

		// OPTIONAL -> Give you extra features
		'page_priority'        => null,
		// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
		'page_parent'          => 'themes.php',
		// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
		'page_permissions'     => 'manage_options',
		// Permissions needed to access the options panel.
		'menu_icon'            => '',
		// Specify a custom URL to an icon
		'last_tab'             => '',
		// Force your panel to always open to a specific tab (by id)
		'page_icon'            => 'icon-themes',
		// Icon displayed in the admin panel next to your menu_title
		'page_slug'            => '',
		// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
		'save_defaults'        => true,
		// On load save the defaults to DB before user clicks save or not
		'default_show'         => false,
		// If true, shows the default value next to each field that is not the default value.
		'default_mark'         => '',
		// What to print by the field's title if the value shown is default. Suggested: *
		'show_import_export'   => true,
		// Shows the Import/Export panel when not used as a field.

		// CAREFUL -> These options are for advanced use only
		'transient_time'       => 60 * MINUTE_IN_SECONDS,
		'output'               => true,
		// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
		'output_tag'           => true,
		// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
		// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

		// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
		'database'             => '',
		// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
		'use_cdn'              => true,
		// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
	);

	Redux::setArgs( $opt_name, $args );

	/*
	 * ---> END ARGUMENTS
	 */

	/*
	 *
	 * ---> START SECTIONS
	 *
	 */


	/*
	 *
	 * Sidebar options section.
	 *
	 */
	Redux::setSection( $opt_name, array(
		'title'            => __( 'Sidebar Options', 'xclean' ),
		'id'               => 'sidebar_options',
		'customizer_width' => '500px',
		'icon'             => 'el el-cogs',
		
	) );


	/*
	 *
	 * Sidebar options to post page.
	 *
	 */
	Redux::setSection( $opt_name, array(
		'title'      => __( 'Post Page', 'xclean' ),
		'id'         => 'post_page',
		'desc'       => __( 'Sidebar Option for single post page', 'xclean' ),
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'sidebar-post',
				'type'     => 'image_select',
				'title'    => __( 'Sidebar Option for Layout', 'xclean' ),
				'subtitle' => __( 'Choose sidebar position on the page', 'xclean' ),
				'options'  => array(
					'off' => array(
						'alt' => '1 Column',
						'img' => ReduxFramework::$_url . 'assets/img/1col.png'
					),
					'right' => array(
						'alt' => '2 Column Left',
						'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
					),
					'left' => array(
						'alt' => '2 Column Right',
						'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
					),
				),
				'default'  => 'off'
			),
		)
	) );


	if ( xclean_is_woo_exists() ) {

		/*
		 *
		 * Sidebar options to shop page.
		 *
		 */
		Redux::setSection( $opt_name, array(
			'title'      => __( 'Shop Page', 'xclean' ),
			'id'         => 'shop_page',
			'desc'       => __( 'Sidebar Option for shop page', 'xclean' ),
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'sidebar-shop',
					'type'     => 'image_select',
					'title'    => __( 'Sidebar Option for Layout', 'xclean' ),
					'subtitle' => __( 'Choose sidebar position on the page', 'xclean' ),
					'options'  => array(
						'off' => array(
							'alt' => '1 Column',
							'img' => ReduxFramework::$_url . 'assets/img/1col.png'
						),
						'right' => array(
							'alt' => '2 Column Left',
							'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
						),
						'left' => array(
							'alt' => '2 Column Right',
							'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
						),
					),
					'default'  => 'off'
				),
			)
		) );
	}
		

	if (class_exists('MetaSliderPlugin')) {
		
		/*
		 *
		 * Slider custom styles.
		 *
		 */
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Slider Styles', 'xclean' ),
			'desc'             => __( 'If you use Pro version of Meta Slider then disable custom styles', 'xclean' ),
			'id'               => 'style',
			'customizer_width' => '500px',
			'fields'           => array(
				array(
					'id'       => 'custom-style',
					'type'     => 'button_set', 
					'title'    => __( 'Theme Custom Styles', 'xclean' ),
					'subtitle' => __( 'Enable/Disable slider custom styles', 'xclean' ),
					'options'  => array(
						'on'   => 'ON', 
						'off'  => 'OFF' 
					), 
					'default'  => 'off'
				),
			)
		) );
	}


	if ( xclean_is_woo_exists() ) {

		/*
		 *
		 * Link to page.
		 *
		 */
		$options = xclean_pages();
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Checkout Page', 'xclean' ),
			'desc'             => __( 'Choose link to page', 'xclean' ),
			'id'               => 'coupon',
			'customizer_width' => '500px',
			'fields'           => array(
				array(
					'id'       => 'pages',
					'type'     => 'select',
					'title'    => __( 'Select Page', 'xclean' ), 
					'subtitle' => __( 'Choose the page from the list', 'xclean' ),
					'options'  => $options,
				),
			)
		) );
	}
?>