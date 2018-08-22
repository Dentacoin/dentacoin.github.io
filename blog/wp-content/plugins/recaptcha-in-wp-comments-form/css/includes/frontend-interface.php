<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        backend-interface.php
 * Since:       0.0.2
 */
 
/*
 * Class:       griwpc_frontend_interface
 * Version:     0.0.8.2
 * Description: This class has a triple functionality.
 *              - It adds a Google reCAPTCHA field inside the WP comments form and verifies the results of user field interaction. 
 *              - While reCACPTCHA is not checked the class modifies the HTML of the <FORM></FORM> preventing a forced comment send
 *              - Before saving the comment, the class introduces a second check point that allows you to decide what do you want to 
 *                do with the comment in case of breaking reCAPTCHA.
 */

// Back-End Interface Class 
class griwpc_frontend_interface extends griwpc_interface {

	public $reCAPTCHA;

	public function __construct ( $version, $settingsClass ) {
		
		parent::__construct ( $version, $settingsClass );

		add_action ( 'wp', array ( $this, 'construct_frontend_interface' ), PHP_INT_MAX - 200, 0 );
		
	}

	// Constructing interface just in case of singular items
	public function construct_frontend_interface () {

		if ( is_singular() && comments_open() && ! is_user_logged_in() ) {

			// Constructing just when the plugin is active
			if ( TRUE === (boolean) $this->options['active'] ) {
				
				$this->reCAPTCHA = new griwpc_recaptcha ( $this->version, $this->settingsClass );
				
				// Modifying the comments form
				// We add the Google reRECAPTCHA field at the end of comment fields
				if ( $this->options['old_themes_compatibility'] == 0 ) {
					add_action ( 'comment_form_after_fields', array ( $this, 'additional_fields' ), PHP_INT_MAX - 200 );
				}

				// Loading possible styles
				if ( trim( $this->options['recaptcha_css'] ) != '' )
					add_action ( 'wp_enqueue_scripts', array ( $this, 'reCAPTCHA_styles' ), 1, 0 );

			}
		}
		
	}

	// Loading Front-End Styles
	public function reCAPTCHA_styles () {
		echo "\n" . '<style id="reCAPTCHA-style" >' . $this->options['recaptcha_css'] . "</style>\n";
	}

	// Modifying the comments form
	public function additional_fields () {
		
		// We add the Google reRECAPTCHA field at the end of comment fields; priority = PHP_INT_MAX - 200;
		echo $this->reCAPTCHA->render_HTML ( $this->options['recaptcha_tag'], $this->options );
		
	}
	
}
