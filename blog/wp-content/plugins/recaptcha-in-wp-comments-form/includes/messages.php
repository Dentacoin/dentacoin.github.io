<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        messages.php
 * Since:       0.0.9
 */
 
/*
 * Class:       griwpc_messages
 * Version:     0.0.9.0.2
 * Description: This class creates all messages, strings, and help pages of the plugin
 *
 */
// Screen Messages Class 
class griwpc_messages {

	// Accordion section names
	static function get_section_names_array() {

		$sections = array();
		
		$sections['activation']				= __( 'Plugin Activation',			'recaptcha-in-wp-comments-form' );
		$sections['apiKeys']				= __( 'reCAPTCHA API Keys',			'recaptcha-in-wp-comments-form' );
		$sections['recaptchaSettings']		= __( 'reCAPTCHA Customizer',		'recaptcha-in-wp-comments-form' );
		$sections['antispamSettings']		= __( 'Antispam Settings',			'recaptcha-in-wp-comments-form' );
		$sections['pluginSettings']			= __( 'Plugin Settings',			'recaptcha-in-wp-comments-form' ); 
		$sections['outputModeSettings']	 	= __( 'Output screen Settings',		'recaptcha-in-wp-comments-form' ); 
		
		$sections['instructions'] 			= __( 'Plugin installation Wizard', 'recaptcha-in-wp-comments-form' );

		return $sections;
		
	}

	// Screen Strings
	static function get_screen_strings_array() {

		$strings = array(
			'Amsg'					=> sprintf ( 
										__( 'For further information visit the <a href="%1$s" target="_blank" >Author\'s plugin</a> page.', 'recaptcha-in-wp-comments-form' ),
										__GRIWPC_SITE__
									),
			'isON'					=> _x( 
										'ON', 
										"String for 'active' state in switcher fields. It should be a short string, 2 to 5 letters.", 
										'recaptcha-in-wp-comments-form' 
									),
			'isOFF'					=> _x(
										'OFF', 
										"String for 'inactive' state in switcher fields. It should be a short string, 2 to 5 letters.", 
										'recaptcha-in-wp-comments-form'
									),
			'saveButtonText'		=> _x(
										'Save Changes', 
										'It could be a exact copy of the standard WP text used for `Save Changes` button translated to your native language',
										'recaptcha-in-wp-comments-form'
									),
			'saveButtonWizard'		=> __(
										'Save your Google reCAPTCHA API Keys pair', 
										'recaptcha-in-wp-comments-form'
									),
			'googleKeysPairString' 	=> _x(
										'Google reCAPTCHA API Keys pair',
										'reCAPTCHA pair string',
										'recaptcha-in-wp-comments-form'
									),
			
		);
		
		
		// Derivated strings
		$strings['googleKeysPair']	= sprintf( '<span class="warning"><strong>%s</strong></span>', $strings['googleKeysPairString'] );
		
		
		return $strings;
		
	}

	static function sidebar_help () {

		get_current_screen()->set_help_sidebar ( '<p>' . sprintf( __( 'For further information about the plugin, please, visit the <a href="%1$s" target="_blank">Author\'s plugin page</a>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_SITE__ ) . '</p>' );

	}

	// 'About' Tab
	static function tab_about ( $options, $args = array() ) {

		$strings	= griwpc_messages::get_screen_strings_array();
		$sections   = griwpc_messages::get_section_names_array();
		$tabtitle	= _x( 'About the plugin', 'Help tab title', 'recaptcha-in-wp-comments-form' );
		
		$overview  = '<h2>' . __( 'reCAPTCHA in WP comments form', 'recaptcha-in-wp-comments-form' ) . '</h2>';
		$overview .= '<p>'  . __( 'This screen is used for managing the plugin settings and the Google reCAPTCHA field settings.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		$overview .= '<p>'  . sprintf( __( 'The plugin is <strong>completely automatic</strong> so, it\'s not necesary that you configure anything for showing a reCAPTCHA field in your comments form, just active you the plugin in the <strong>%s</strong> accordion section.', 'recaptcha-in-wp-comments-form' ), $sections['activation'] ) . '</p>';
		$overview .= '<p>'  . sprintf( _x( 'On the other hand, it\'s important to understand that the <strong>Google reCAPTCHA field</strong> works thanks to a %1$s so that, for using this plugin, you always need an API Keys pair however, don\'t worry about these technical issues. Each time that the plugin detects the lack of this API Keys pair, it automatically starts an easy Installation Wizard that will help you to obtain a new API Keys pair for your site in just two steps.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'about-recaptcha-plugin',
			'title'   => $tabtitle,
			'content' => $overview
		) );

	}

	// 'Change API Key pair' Tab
	static function tab_changing_API_Keys ( $options, $args = array() ) {

		$strings	= griwpc_messages::get_screen_strings_array();
		$sections   = griwpc_messages::get_section_names_array();
		$tabtitle	= _x( 'Change API Key pair', 'Help tab title', 'recaptcha-in-wp-comments-form' );

		$get  = '<h2>' . sprintf( _x( 'Changing the %1$s', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPairString'] ) . '</h2>';
		$get .= '<p>' .  sprintf( _x( 'If you want to change the %1$s that the plugin is using, please, follow these simple instructions.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';
		
		$get .= '<ol>';
		
		$get .= '<li><p>' . sprintf ( __( 'Visit the <a href="%1$s" target="_blank" >Google reCAPTCHA official site</a> and press <strong>Get reCAPTCHA</strong> button. Perhaps you have to log in with your <strong>Google Account</strong>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_RECAPTCHA_SITE__ ) .  '</p></li>';
		
		$get .= '<img src="' . __GRIWPC_URL__ . '/images/g-log-in-google.png" />';
		
		$get .= '<li>'; 
			$get .= '<p>' . __( 'Now, you can <strong>CREATE</strong> a new reCAPTCHA field or you can <strong>SELECT</strong> one of your previously created reCAPTCHAS.', 'recaptcha-in-wp-comments-form' ) . '</p>';
			
			$get .= '<ul>'; 
			
				$get .= '<li>'; 
					$get .= '<p>' . __( 'In the case of creating a new reCAPTCHA, go to the <strong>Register a new Site</strong> and create a new <em>Label</em> for the new reCAPTCHA and afterwards, you have to write the list of <em>Domains</em> that will be able to use the new reCAPTCHA.', 'recaptcha-in-wp-comments-form' ) . '</p>';
					$get .= '<p>' . __( 'Pressing the <em>Register</em> button, you\'ll save the <strong>New Site</strong> and you\'ll go to the settings page of the new reCAPTCHA.', 'recaptcha-in-wp-comments-form' ) . '</p>';
					$get .= '<img src="' . __GRIWPC_URL__ . '/images/g-register.png"/>';
				$get .= '</li>'; 
			
				$get .= '<li>'; 
					$get .= '<p>'  . __( "In the case of selecting a previously created reCAPTCHA field, go to the <strong>Manage your reCAPTCHA API keys</strong> and select a reCAPTCHA that's identified by its label then you'll go to the settings page of this reCAPTCHA.", 'recaptcha-in-wp-comments-form' ) . '</p>';
					$get .= '<img src="' . __GRIWPC_URL__ . '/images/g-recaptcha-official-selector.png"/>';
				$get .= '</li>'; 
			
			$get .= '</ul>'; 
			
		$get .= '</li>'; 
		
		$get .= '<li>';
		$get .= '<p>' . __( 'Once in the reCAPTCHA settings page, you have to go to the <strong>Adding reCAPTCHA to your site</strong> section, and open the <strong>Keys</strong> subsection.', 'recaptcha-in-wp-comments-form' ) . '</p>'; 
		$get .= '<img src="' . __GRIWPC_URL__ . '/images/g-keys.png"/>';
		$get .= '</li>'; 
		
		
		$get .= '<li>';
		$get .= '<p>' . sprintf ( _x( 'And finally, one by one, you have to copy these new Site and Secret API Keys from the Google settings page and paste them into the plugin homonymous fields in the <strong>%1$s</strong> acordion section. Remember to press the <strong>%2$s</strong> button.', '1: reCAPTCHA API Keys accordion section name, 2: Save Changes button text', 'recaptcha-in-wp-comments-form' ), $sections['apiKeys'], $strings['saveButtonText'] ) . '</p>';
		$get .= '<img src="' . __GRIWPC_URL__ . '/images/g-keys-accordion.png"/>';
		$get .= '</li>'; 
		
		$get .= '</ol>';
		
		$get .= '<p>' . sprintf( _x( 'For further information and an step by step example of how to get or to change your %1$s, please visit the <a href="%2$s" target="_blank">Author\'s plugin reCAPTCHA API Key pair page</a>.', '1: reCAPTCHA pair string, 2: URL', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPairString'], __GRIWPC_SITE_KEYP__ ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'change-api-keys',
			'title'   => $tabtitle,
			'content' => $get
		) );
		
	}

	// 'reCAPTCHA Customizer' Tab
	static function tab_reCAPTCHA_customizer ( $options, $args = array() ) {

		$sections   = griwpc_messages::get_section_names_array();
		$tabtitle	= $sections['recaptchaSettings'];

		$cust  = '<h2>' . $tabtitle . '</h2>';
		$cust .= '<p>' . __( 'In this accordion section, you can configure completely the look of the recaptcha field. There are five options that allow you to change, respectively, the theme, size, mode, align and language of the Google reCAPTCHA field.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		
		$cust .= '<img src="' . __GRIWPC_URL__ . '/images/Google reCAPTCHA settings examples.jpg"  style="width:100%; max-width:unset; height: auto;"/>';
		
		$cust .= '<p>' . sprintf( __( 'For further information about all options of Google reCAPTCHA field and for seeing some examples, please visit the <a href="%1$s" target="_blank">Author\'s plugin settings help page</a>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_SITE_CONF__ ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'recaptcha-customizer',
			'title'   => $tabtitle,
			'content' => $cust
		) );
	
	}
	
	// 'Plugin Settings' Tab
	static function tab_plugin_settings ( $options, $args = array() ) {

		$sections   = griwpc_messages::get_section_names_array();
		$tabtitle	= $sections['pluginSettings'];
		
		$recap  = '<h2>' . $tabtitle . '</h2>';
		$recap .= '<p>' . __( 'In this accordion section, you can set up the technical and internal parameters of the plugin.', 'recaptcha-in-wp-comments-form' ) . '</p>'; 
							 
		$recap .= '<p>' . __( 'In most of WP themes, the plugin works automatically without any additional configuration but, if your WP theme has got a special comments form, it has got different ID attributes in form HTML tags, you need to configure the CSS styles, etc. through this set of settings you can change the operating mode of the plugin completely.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		
		$recap .= '<img src="' . __GRIWPC_URL__ . '/images/Area Plugin Settings.jpg"  style="width:100%; max-width:700px; height: auto;"/>';

		$recap .= '<h4>' . __( 'About <span class="dashicons dashicons-image-rotate"></span> button in all fields of this section', 'recaptcha-in-wp-comments-form' )  . '</h4>';
		$recap .= '<p>' . __( 'Press these buttons for <strong>restoring separately</strong> each one of the <strong>original plugin default values</strong>.', 'recaptcha-in-wp-comments-form' )  . '</p>';
		$recap .= '<p>' . __( 'So that, if you have deleted (or forgot) accidentally any of these next values, you\'ve changed your WP theme and the reCAPTCHA field doesn\'t appear, you are testing a new configuration or whatever... Don\'t worry, just relax you and press these buttons each time you need it: the plugin will recover the original state and setting values.', 'recaptcha-in-wp-comments-form' )  . '</p>';

		$recap .= '<p>' . sprintf( __( 'For further information about the plugin settings and for seeing some examples, please visit the <a href="%1$s" target="_blank">Author\'s plugin settings help page</a>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_SITE_CONF__ ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'plugin-settings',
			'title'   => $tabtitle,
			'content' => $recap
		) );
		
	}

	// 'Security/difficulty' Tab
	static function tab_security ( $options, $args = array() ) {

		$tabtitle = _x( 'reCAPTCHA Security Level', 'Help tab title', 'recaptcha-in-wp-comments-form' );
		
		$recap  = '<h2>' . $tabtitle . '</h2>';
		
		$recap .= '<p>' . sprintf( __( 'Nowadays, <strong>Google reCAPTCHA field doesn\'t allow to modify its level of security (difficulty) from outside of its official settings page</strong> so that, if you want that the plugin shows a more (or less) secure reCAPTCHA quiz, you have to visit the <a href="%1$s" target="_blank" >Google reCAPTCHA official site</a> and follow these simple instructions.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_RECAPTCHA_SITE__ )	. '</p>';

		$recap .= '<h4>' . __( 'Changing reCAPTCHA field security level', 'recaptcha-in-wp-comments-form' ) . '</h4>';

		$recap .= '<ol>';
		
			$recap .= '<li>' . sprintf ( __( 'Visit the <a href="%1$s" target="_blank" >Google reCAPTCHA official site</a> and press <strong>Get reCAPTCHA</strong> button. Perhaps you have to log in with your <strong>Google Account</strong>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_RECAPTCHA_SITE__ ) .  '</li>';
			
			$recap .= '<img src="' . __GRIWPC_URL__ . '/images/g-log-in-google.png" />';
	
			$recap .= '<li>' . sprintf ( __( 'Go to the <strong>Manage your reCAPTCHA API keys</strong> section and select your reCAPTCHA that\'s identified by its label.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_RECAPTCHA_SITE__ ) .  '</li>';
			
			$recap .= '<img src="' . __GRIWPC_URL__ . '/images/g-recaptcha-official-selector.png" />';
	
			$recap .= '<li>' . sprintf ( __( 'Now, go to the <strong>Key Configuraction</strong> section, open the <strong>Advanced Settings</strong> subsection and simply select the level of security using the slider <strong>Security Preference</strong> then press the <strong>Save Changes</strong> button.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_RECAPTCHA_SITE__ ) .  '</li>';
	
			$recap .= '<img src="' . __GRIWPC_URL__ . '/images/g-security-level-change.png" />';
	
		$recap .= '</ol>';

		$recap .= '<p>' . sprintf( __( 'For further information about the plugin settings and for seeing some examples, please visit the <a href="%1$s" target="_blank">Author\'s plugin settings help page</a>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_SITE_CONF__ ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'plugin-security',
			'title'   => $tabtitle,
			'content' => $recap
		) );

	}

	// 'Accesibility' Tab
	static function tab_accessibility ( $options, $args = array() ) {

		$sections   = griwpc_messages::get_section_names_array();
		$tabtitle	= _x( 'Accessibility', 'Help tab title', 'recaptcha-in-wp-comments-form' );
		
		$recap  = '<h2>' . $tabtitle . '</h2>';

		$recap .= '<p>' . sprintf ( __( 'From the accessibility point of view, you could worry about whether is always better to use a sound or image type verification quiz however, despite of you have fixed the reCAPTCHA <em>Type</em> parameter to <strong>Image</strong> in the <strong>%s</strong> accordion section, Google reCAPTCHA field automatically (and always) allows people that use screen readers to convert the reCAPTCHA quiz into a sound or text type verification field so that, you have not to configure anything else.', 'recaptcha-in-wp-comments-form' ), $sections['recaptchaSettings'] ) . '</p>';

		$recap .= '<img src="' . __GRIWPC_URL__ . '/images/g-accessibility.png" />';

		$recap .= '<p>' . __('Google reCAPTCHA field works with major screen readers (ChromeVox, JAWS, NVDA and VoiceOver) so that, it will alert screen readers of status changes, such as when the reCAPTCHA verification quiz is complete. The status changes are always visible and audible. See next example image.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		
		$recap .= '<img src="' . __GRIWPC_URL__ . '/images/g-accessibility-examples.png" />';
		
		$recap .= '<p>' . sprintf( __( 'For further information about the plugin settings and for seeing some examples, please visit the <a href="%1$s" target="_blank">Author\'s plugin settings help page</a>.', 'recaptcha-in-wp-comments-form' ), __GRIWPC_SITE_CONF__ ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'plugin-accessibility',
			'title'   => $tabtitle,
			'content' => $recap
		) );

	}

	// 'I don't see reCAPTCHA field' Tab
	static function tab_idontseerecaptacha ( $options, $args = array() ) {

		$sections   = griwpc_messages::get_section_names_array();
		$strings	= griwpc_messages::get_screen_strings_array();
		$tabtitle  = _x( 'I don\'t see reCAPTCHA field', 'Help tab title', 'recaptcha-in-wp-comments-form' );
		
		$idont  = '<h2>' . $tabtitle . '</h2>';

		$idont .= '<p>' . __( "Some times, directly after installing the plugin but mostly, after changing or updating your WP Theme, it's possible that the reCAPTCHA field doesn't appears of the screen. It's rare because the plugin is configured for operating with most of WP themes but, if it happens, please, check one by one these points to fix the problem.", 'recaptcha-in-wp-comments-form' ) . '</p>';

		$idont .= '<ol>';

			$idont .= '<li>' ;
	
				$idont .= '<p>' . sprintf( 
								_x( 'Check if the activation switcher is <strong>%1$s</strong> in the <strong>%2$s</strong> accordion section.', '1: switch ON string, 2: accordion section name', 'recaptcha-in-wp-comments-form' ),
								$strings['isON'],
								$sections['activation']
								) . '</p>';
	
				$idont .= '<img src="' . __GRIWPC_URL__ . '/images/g-activation-accordion.png" style="max-width: 250px;" />';
	
			$idont .= '</li>' ;


			$idont .= '<li>' ;
	
				$idont .= '<p>' . sprintf( 
								_x( 'Change the state of the <strong>%1$s</strong> switcher in the <strong>%2$s</strong> accordion section.', '1: setting field name, 2: accordion section name', 'recaptcha-in-wp-comments-form' ),
								__( 'Forced javascript output', 'recaptcha-in-wp-comments-form' ),
								$sections['outputModeSettings']
								) . '</p>';
	
				$idont .= '<img src="' . __GRIWPC_URL__ . '/images/g-forced-javascript.png" style="max-width: 250px;" />';
	
			$idont .= '</li>' ;


			$idont .= '<li>' ;
	
				$idont .= '<p>' . sprintf( 
								_x( 'Check the ID\'s of the &lt;FORM&gt; and &lt;BUTTON&gt; HTML elements in a real WP post comments form and afterwards, please, check whether these ID\'s are equal or different of the homonymous field values in the <strong>%1$s</strong> accordion section. Apply the changes if it\'s necessary.', '1: accordion section name', 'recaptcha-in-wp-comments-form' ),
								$sections['pluginSettings']
								) . '</p>';
	
				$idont .= '<img src="' . __GRIWPC_URL__ . '/images/g-change-html-ids.png" style="max-width: 250px;" />';
	
				$idont .= '<p>' . sprintf( _x( 'To find out the ID\'s, first desactivate the plugin via <strong>%1$s</strong> accordion section, then use the <strong>Inspect Element</strong> or the <strong>See HTML code</strong> options of your browser to see the HTML code of the post comments form of your WP theme, and after applying the changes in above indicated fields, remember to reactivate the plugin again.', '1: accordion section name', 'recaptcha-in-wp-comments-form' ), $sections['activation'] ) . '</p>';
	
			$idont .= '</li>';

			$idont .= '<li>';
	
				$idont .= '<p>' . sprintf( 
								_x( 'Check your %1$s in the <strong>%2$s</strong> accordion section.', '1: reCPATCHA pair string, 2: accordion section name', 'recaptcha-in-wp-comments-form' ),
								$strings['googleKeysPair'],
								$sections['apiKeys']
								) . '</p>';
				
			$idont .= '</li>';
			
			$idont .= '<li>';
			
				$idont .= '<p>' . sprintf( 
								_x( 'Finally, if you see an image like this next one, the plugin works properly but there is a problem with your %1$s. Please check your API Keys again.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), 
								$strings['googleKeysPair']
								)  . '</p>';
	
				$idont .= '<img src="' . __GRIWPC_URL__ . '/images/g-api-keys-error.png" style="max-width: 250px;" />';
	
			$idont .= '</li>';

		$idont .= '</ol>';
		
		get_current_screen()->add_help_tab( array(
			'id'      => 'i-dont-see-recaptcha',
			'title'   => $tabtitle,
			'content' => $idont
		) );

	}

	// 'Installation' Tab
	static function tab_installation ( $options, $args = array() ) {

		$strings	= griwpc_messages::get_screen_strings_array();

		$title 	   = __( 'Plugin installation', 'recaptcha-in-wp-comments-form' );
		
		$overview  = '<h2>' . $title . '</h2>';
		$overview .= '<p>' . sprintf( _x( 'This Installation Wizard is used for helping you in installations process from the scratch to obtain your %1$s.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';

		$overview .= '<h4>' . __( 'Plugin requirements', 'recaptcha-in-wp-comments-form' ) . '</h4>';

		$overview .= '<p>' . sprintf( _x( 'The plugin is <strong>completely automatic</strong> so, it\'s not necesary that you configure anything however, the plugin SHOWS a Google reCAPTCHA field that USES a pair of <strong>Site and Secret API Keys</strong> thus the plugin also NEED them so that, before using the plugin, first you have to follow this Two simple steps Installation Wizard for getting a new %1$s for your site.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';

		$overview .= '<img src="' . __GRIWPC_URL__ . '/images/g-working-scheme.png" style="width:100%; max-width:700px; height: auto;" />';

		$overview .= '<p>' . sprintf( _x( 'The installation wizard will appear each time that one or both parts of the %1$s are <strong>empty</strong> in the homonymous plugin settings fields.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';

		$overview .= '<h4>' . __( 'Installation Wizard', 'recaptcha-in-wp-comments-form' ) . '</h4>';
		
		$overview .= '<p>' . sprintf( _x( 'The Installation Wizard just works for helping you to create and get your %1$s.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';
		$overview .= '<p>'  . __( 'This Wizard is divided into two parts: in first one you CREATE your new Google reCAPTCHA API Keys pair and in the second one you GET it, simply copying these API Keys from Google reCAPTCHA settings page and pasting them into the homonymous fields of the form inside the itself Wizard. That\'s all.', 'recaptcha-in-wp-comments-form' ) . '</p>'; 

		$overview .= '<img src="' . __GRIWPC_URL__ . '/images/g-wizard-working-scheme.png" style="width:100%; max-width:700px; height: auto;" />';
		
		$overview .= '<p>' . sprintf( _x( 'After saving your %1$s, the Installation Wizard will disappear and you will be able to access to the normal plugin settings interface.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '</p>';
		
		$overview .= '<p>' . sprintf( _x( 'For further information and an step by step example of how to get or to change your %1$s, please visit the <a href="%2$s" target="_blank">Author\'s plugin reCAPTCHA API Key pair page</a>.', '1: reCAPTCHA pair string, 2: URL address', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'], __GRIWPC_SITE_KEYP__ ) . '</p>';

		get_current_screen()->add_help_tab( array(
			'id'      => 'overview',
			'title'   => $title,
			'content' => $overview
		) );

	}

}

