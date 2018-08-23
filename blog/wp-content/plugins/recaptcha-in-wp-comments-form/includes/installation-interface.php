<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        installation-interface.php
 * Since:       0.0.9
 */
 
/*
 * Class:       griwpc_installation_interface
 * Version:     0.0.9.0.2
 * Description: When plugin has not got one or both parts of the Google reCAPTCHA API Keys pair, the plugin actives this class 
 *              that opens the installation wizard
 */

// Installation Interface Class 
class griwpc_installation_interface extends griwpc_backend_interface {

	public function __construct ( $version, $settingsClass ) {
		parent::__construct ( $version, $settingsClass );
	}

	// Creating Help text for plugin settings page
	public function screen_help() {

		// Sidebar for help pages
		griwpc_messages::sidebar_help();
		
		// 'Wiward' Tab
		griwpc_messages::tab_installation( $this->options, NULL );
		
	}


	// Adding metaboxes to the accordion sections
	public function adding_metaboxes ( ) {
		
		$screen = get_current_screen();
		// Future extensions of installation wizard
			
	}

	// Actions for enqueueing Scripts and Styles
	public function enqueue_admin_scripts_and_styles () {

		add_action ( 'admin_enqueue_scripts', array ( $this, 'register_backend_scripts' ) );
		add_action ( 'admin_enqueue_scripts', array ( $this, 'register_backend_styles'  ) );
		
	}

	// Loading Back-End Scripts and Styles
	public function register_backend_scripts () {

		// Future extensions of installation wizard

	}


	// Loading Back-End Scripts and Styles
	public function register_backend_styles () {

		wp_register_style ( 'griwpc-admin', __GRIWPC_URL__ . 'css/backend-interface.css', array ( 'wp-admin' ), $this->version, 'all' );
		wp_enqueue_style  ( 'griwpc-admin' );
		
		$len = max( strlen ( $this->strings['isOFF']) , strlen ( $this->strings['isON']) );
		$plus = 0;
		if ( $len > 3 ) {
			$plus = ( ( 14 * ( $len - 3 )) + 10 );
		}

		$outCSS = '.slideThree:after { content: "' . $this->strings['isOFF'] . '"; }' . '.slideThree:before { content: "' . $this->strings['isON'] . '"; }';
		if ( $plus > 0 )
			$outCSS .= '.slideThree { width: ' . ( 80 + $plus ) . 'px; }' . 
					   '.slideThree label {	width: ' . ( 34 + ( $plus / 2 )  ) . 'px; }' .
					   '.slideThree input[type=checkbox]:checked + label { left: ' . ( 43 + ($plus/2) ) . 'px; }';
		
		wp_add_inline_style ( 'griwpc-admin', $outCSS );
		wp_add_inline_style ( 'griwpc-admin', $this->options['recaptcha_css'] );
		
	}


	/************************************************************************************************************************************ 
	 *
	 * Screen construction callback functions
	 *
	 */
	 
	// Global callback function. 
	// It creates the three areas of the screen
	public function settings_page_function_callback () {

		echo '<div class="wrap">';
		echo '<h2 class="recaptcha-plugin-title" >' . __GRIWPC__ . '</h2>';
			
			echo '<div id="poststuff">';
			echo '<div id="post-body" class="metabox-holder columns-1">';
			echo '<div id="postbox-container-2" class="postbox-container">';
			
				$this->installation_instructions_function_callback( $this->options );
	
			echo '</div>';
			echo '</div>';
			echo '</div>';
			
		echo '</div>';
		
	}

	public function installation_instructions_function_callback ( $options ) {
		
		$user_ID = wp_get_current_user()->ID;
		
        $get  = '<div id="installation-wizard" class="postbox" >';
        $get .= '<div class="inside" >';

		$get .= '<h2><strong>' . $this->sections['instructions'] . '</strong></h2>';
		
//		$get .= '<p class="first-margin-message" >' .  __( 'This plugin works thanks to Google reCAPTCHA widget thus before beginning to use it, first you have to obtain your <span class="warning"><strong>Google reCAPTCHA API Keys pair</strong></span>. Follow these simple instructions.', 'recaptcha-in-wp-comments-form' ) . '</p>';

		$get .= '<p class="first-margin-message" >' .  sprintf( _x( 'This plugin works showing a Google reCAPTCHA widget but for working, Google reCAPTCHA need a pair of their API Keys thus, before beginning to use this plugin, first you have to obtain a %1$s so that, simply follow these easy instructions and <strong>get yours</strong>.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $this->strings['googleKeysPair'] ) . '</p>';


		$get .= '<h2>' . __( 'Obtaining your Google reCAPTCHA API Keys pair', 'recaptcha-in-wp-comments-form' ) . '</h2>';
		$get .= '<ol class="custom-counter" >';
			
			$get .= '<li>'; 
				$get .= '<p>' . sprintf ( __( 'Visit the <a href="%1$s" target="_blank" >Google reCAPTCHA official site</a> and press the <em>Get reCAPTCHA</em> button.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_RECAPTCHA_SITE__ ) . '</p>';
				$get .= '<p>' . __( 'Afterwards, perhaps you have to log in if you are not identified with your Google Account (typically your Gmail username and password).', 'recaptcha-in-wp-comments-form' ) . '</p>';
				$get .= '<p>' . '<img src="' . __GRIWPC_URL__ . '/images/g-log-in-google.png" />' . '</p>';
			$get .= '</li>';
	
			$get .= '<li>';
				$get .= '<p>' . __( 'Creating a new <strong>Google reCAPTCHA</strong>.', 'recaptcha-in-wp-comments-form' ) . '</p>';
				$get .= '<p>' . __( 'Go to a <strong>Register a New Site</strong> section where first, you have to create a new <em>Label</em> for the new reCAPTCHA and second, you have to write the list of <em>Domains</em> that will be able to use this new reCAPTCHA. In our case, you have to write the <strong>domain of your WordPress site</strong>.', 'recaptcha-in-wp-comments-form' ) . '</p>';
				$get .= '<p>' . '<img src="' . __GRIWPC_URL__ . '/images/g-register-example.png" />' . '</p>';
			$get .= '</li>';
				
			$get .= '<li>';
				$get .= '<p>' . __( 'Press the <em>Register</em> button for saving the new <strong>Google reCAPTCHA</strong>.', 'recaptcha-in-wp-comments-form' ) . '</p>';
				
				$get .= '<p>' . __( 'Once you\'ve registered the new Google reCAPTCHA, automatically you\'ll go to the <strong>Google reCAPTCHA settings page</strong> for your new reCAPTCHA. This page was identified by the <em>Label</em> that you have created in the prior step.', 'recaptcha-in-wp-comments-form' ) . '</p>';
				
				$get .= '<p>' . '<img src="' . __GRIWPC_URL__ . '/images/g-google-recaptcha-settings-page.png" />' . '</p>';
			
				$get .= '<p>' . sprintf( _x( 'And, as you can see in the next example image, the <strong>Keys</strong> subsection of this page already contains your new %1$s.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $this->strings['googleKeysPair'] ) . '</p>';
				
				$get .= '<p>' . '<img src="' . __GRIWPC_URL__ . '/images/g-keys-1.png" />' . '</p>';
			$get .= '</li>';
		
		$get .= '</ol>';
		
		
		
		$get .= '<h2>' . __( 'Copying Google reCAPTCHA API Keys pair to the plugin', 'recaptcha-in-wp-comments-form' ) . '</h2>';
		
		$get .= '<ol class="custom-counter" >';
		
		$get .= '<li>';
			$get .= '<p>' . __( '<strong>Copy</strong> these API Keys from Google reCAPTCHA settings page and <strong>paste</strong> them into these next form fields.', 'recaptcha-in-wp-comments-form' ) . '</p>';

			$get .= '<p>' . __( 'Now, one by one, copy the reCAPTCHA API Keys from the Google reCAPTCHA settings page and paste its content into the respective homonymous field in the below form.', 'recaptcha-in-wp-comments-form' ) . '</p>';
			
			$get .= '<p>' . sprintf ( _x( 'Once you have copied the Keys pair, simply press the <strong>%s</strong> button and the plugin will be ready to work.', 'Save installation button text', 'recaptcha-in-wp-comments-form' ), $this->strings['saveButtonText'] ) . '</p>';

			$get .= '<span id="installation-form" >';
			$get .= '<p style="font-size:160%;" >' . sprintf ( _x( 'Paste the <span class="warning">%1$s</span> values here', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $this->strings['googleKeysPairString'] ) . '</p>';
			$get .= '<form id="griwpc-form" class="griwpc-form" action="options.php" method="POST" >';
				
				ob_start();
				
					settings_fields( 'griwpc_settings' );
					echo '<input type="hidden" id="user-id" name="user_ID" value="' . (int) $user_ID .'" />';
					foreach ( $options as $key => $value ) {
						if ( ! in_array ( $key, array ( 'site_key', 'secret_key' ) ) )
							echo "<input type='hidden' name='griwpc-params[$key]' value='$value' />";
					}
					$this->recaptcha_keys_function_callback ( $options );
					echo '<p>Please, read next wizard step before pressing this <strong>save</strong> button.</p>';
					submit_button( $this->strings['saveButtonWizard'], 'primary', 'submit', TRUE, NULL );
					$get .= ob_get_contents();
					
				ob_clean();

			$get .= '</form>';
			$get .= '</span>';

			$get .= '<p>' . __( 'After saving the Google reCAPTCHA API Keys pair, you\'ll never see this wizard again but you\'ll access to the <strong>normal plugin settings interface</strong>.', 'recaptcha-in-wp-comments-form' ) . '</p>';

		$get .= '</li>';

		$get .= '<li>';
		
			$get .= '<p>' . __( '<strong>Activate</strong> the plugin operation.', 'recaptcha-in-wp-comments-form' ) . '</p>';
			$get .= '<p>' . sprintf( _x( 'Once in the normal plugin settings interface, you have <strong>to activate the plugin operation</strong> changing the activation switch to <strong>%1$s</strong> in the <strong>%2$s</strong> accordion section, automatically a reCAPTCHA field will appear in the comments form of your WP theme.', '1: string ON for switch button, 2: Plugin Activation accordion section name', 'recaptcha-in-wp-comments-form' ), $this->strings['isON'], $this->sections['activation'] ) . '</p>';
			$get .= '<p>' . '<img src="' . __GRIWPC_URL__ . '/images/g-activation-accordion.png" />' . '</p>';
			$get .= '<p>' . __( '<span class="warning"><strong>By the way but important</strong></span>. This plugin <strong>just appears</strong> inside the WP comments form <strong>when users are not logged in</strong> the site so that, if you want to check whether the plugin works or not with one of your real posts, please remember, first log out from WP.', 'Save installation button text', 'recaptcha-in-wp-comments-form' ) . '</p>';
			

		$get .= '</li>';
			
		$get .= '</ol>';
		
		$get .= '<p>' . sprintf( __( 'For further information and more examples of how to get or change your Google reCAPTCHA API Key pair, please visit the <a href="%1$s" target="_blank">Author\'s plugin reCAPTCHA API Key pair page</a>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_SITE_KEYP__ ) . '</p>';
		
		$get .= '</div>';
		$get .= '</div>';
		
		echo $get;
		

	}


	/*
	 *
	 * Metaboxes callback functions for accordion sections
	 *
	 */

	public function recaptcha_keys_function_callback ( $options ) {

		$vSite	 = isset ( $options['site_key'] )	? $options['site_key'] : NULL;
		$vSecret = isset ( $options['secret_key'] ) ? $options['secret_key'] : NULL;

		$this->settingsClass->siteKey( $vSite );
		$this->settingsClass->secretKey( $vSecret );

	}


}
