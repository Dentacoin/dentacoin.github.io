<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        interfaces.php
 * Since:       0.0.9
 */
 
/*
 * Class:       griwpc_interface
 * Version:     0.0.9.0.2
 * Description: Base class for creating all interfaces
 */

// Back-End Interface Class 
class griwpc_interface {

	public $settingsClass;
	public $version;
	public $options;
	
	public function __construct( $version, $settingsClass ) {

		$this->version 		 = $version; 	// Plugin version
		$this->settingsClass = $settingsClass; // Class for controling settings and options
		$this->options		 = $this->settingsClass->get_options();	// The plugin options

	}
	
}


/*
 * Class:       griwpc_screen_interface
 * Version:     0.0.9.0.1
 * Description: Child class for creating all backend interfaces ( Wizards, Front-End, Back-End...)
 */
class griwpc_backend_interface extends griwpc_interface {

	public $strings;
	public $sections;
	public $reCAPTCHA;

	public function __construct( $version, $settingsClass ) {

		parent::__construct ( $version, $settingsClass );
		$this->reCAPTCHA	 = NULL;

		// Adding the settings submenu page
		add_action( 'admin_menu',		array( $this, 'create_pages' ) );
		
		// Register array of setting	
		add_action( 'admin_init',		array( $this, 'plugin_init' ) );
		
		// Creating Back-End side interface via current_screen
		add_action( 'current_screen',	array( $this, 'creating_admin_interface' ), 10, 1 );

	}


	/************************************************************************************************************************************ 
	 *
	 * Back-End side interface construction 
	 *
	 */
	 
	// Adding the settings submenu page
	public function create_pages () {

		add_options_page(
			__GRIWPC__, 
			__GRIWPC_SHORT__,
			'manage_options', 
			'google_recaptcha_in_wp_comments_settings', 
			array( $this, 'settings_page_function_callback' ) 
		);
		
	}

	// Actions to develop in admin_init hook
	public function plugin_init() {
		
		// Settings register
		$this->settingsClass->settings_register();
		
	}

	// Creating Back-End side interface via current_screen
	public function creating_admin_interface ( $screen ) {

		// Creating the basic Back-End strings
		$this->sections					 = griwpc_messages::get_section_names_array();
		$this->strings					 = griwpc_messages::get_screen_strings_array();

		// Modifying plugin interface: messages, etc.
		add_action ( 'admin_notices', 		array ( $this, 'plugin_interface' ), 9999 );

		// Creating Help text for plugin settings page
		add_action ( "load-$screen->base",	array ( $this, 'screen_help' ), 10, 0 );

		// Adding metaboxes for accordion sections
		add_action ( "load-$screen->base",	array ( $this, 'adding_metaboxes' ), 10, 0 );

		// Loading scripts and styles
		add_action ( "load-$screen->base",	array ( $this, 'enqueue_admin_scripts_and_styles' ) );
		
	}
	
	public function plugin_interface() {}
	public function adding_metaboxes() {}
	public function enqueue_admin_scripts_and_styles() {}
	
}