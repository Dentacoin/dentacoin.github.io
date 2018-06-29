<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        backend-interface.php
 * Since:       0.0.2
 */
 
/*
 * Class:       griwpc_standard_backend_interface
 * Version:     0.0.9.0.2
 * Description: This class creates the settings page and the fields for configuration. When plugin has not the Google reCAPTCHA API Keys pair, 
 *				this class doesn't works because the plugin switches to installation wizard.
 *
 * Primitive:	griwpc_backend_interface
 */

// Back-End Interface Class 
class griwpc_standard_backend_interface extends griwpc_backend_interface {
	
	public function creating_admin_interface ( $screen ) {
		
		if ( $screen->base != 'settings_page_google_recaptcha_in_wp_comments_settings' ) 
			return;
		parent::creating_admin_interface ( $screen );
		
		// Loading scripts and styles
		add_action ( "load-$screen->base",	array ( $this, 'create_reCAPTCHA' ), 10, 0 );
		
	}

	public function create_reCAPTCHA () {
		
		$this->reCAPTCHA = new griwpc_recaptcha ( $this->version, $this->settingsClass );
		
	}
	
	// Creating Help text for plugin settings page
	public function screen_help() {

		// Sidebar for help pages
		griwpc_messages::sidebar_help();
		
		// 'About' Tab
		griwpc_messages::tab_about( $this->options, NULL );
		
		// 'Change API Key pair' Tab
		griwpc_messages::tab_changing_API_Keys ( $this->options, NULL );

		// 'reCAPTCHA Customizer' Tab
		griwpc_messages::tab_reCAPTCHA_customizer( $this->options, NULL );

		// 'Plugin Settings' Tab
		griwpc_messages::tab_plugin_settings( $this->options, NULL );
		
		// 'Security' Tab
		griwpc_messages::tab_security( $this->options, NULL );
		
		// 'Accesibility' Tab
		griwpc_messages::tab_accessibility( $this->options, NULL );
		
		// 'I don't see recaPTCHA' Tab
		griwpc_messages::tab_idontseerecaptacha ( $this->options, NULL );
		
	}

	// Adding metaboxes to the accordion sections
	public function adding_metaboxes ( ) {
		
		$screen = get_current_screen();

		add_meta_box ( 'recaptcha_activation', $this->sections['activation'], array( $this, 'recaptcha_activation_function_callback' ), $screen, 'side', 'default' );
		add_meta_box ( 'recaptcha_keys', $this->sections['apiKeys'], array( $this, 'recaptcha_keys_function_callback' ), $screen, 'side', 'default' );
		add_meta_box ( 'recaptcha_settings', $this->sections['recaptchaSettings'], array( $this, 'recaptcha_settings_function_callback' ), $screen, 'side', 'default' );
		add_meta_box ( 'antispam_settings', $this->sections['antispamSettings'], array( $this, 'antispam_settings_function_callback' ), $screen, 'side', 'default' );
		add_meta_box ( 'plugin_settings', $this->sections['pluginSettings'],	array( $this, 'plugin_settings_function_callback' ), $screen, 'side', 'default' );
		add_meta_box ( 'output_settings', $this->sections['outputModeSettings'], array( $this, 'output_settings_function_callback' ), $screen, 'side', 'default' );
	
	}


	// Actions for enqueueing Scripts and Styles
	public function enqueue_admin_scripts_and_styles () {

		add_action ( 'admin_enqueue_scripts', array ( $this, 'register_scripts' ), 20, 0 );
		add_action ( 'admin_enqueue_scripts', array ( $this, 'register_styles'  ), 20, 0 );
		
	}

	// Loading Back-End Scripts and Styles
	public function register_scripts () {

		// Plugin Back-End script
		wp_enqueue_script ( 'griwpc-admin', __GRIWPC_URL__ . 'js/backend-interface.js', array ( 'common', 'jquery-ui-selectmenu', 'post', 'recaptcha-call' ), $this->version, TRUE  );

	}


	// Loading Back-End Scripts and Styles
	public function register_styles () {

		wp_register_style (
			'jquery-ui-style',
			__GRIWPC_URL__ . 'css/jquery-ui.min.css',
			array ( 'wp-admin' ),
			'1.12.0',
			'all'
		);
		wp_register_style (
			'griwpc-admin',
			__GRIWPC_URL__ . 'css/backend-interface.css',
			array ( 'jquery-ui-style' ),
			$this->version,
			'all'
		);
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

			$outCSS .= '.slideThree.small { width: ' . ( 56 + $plus ) . 'px; }' . 
					   '.slideThree.small label {	width: ' . ( 25 + ( $plus / 2 )  ) . 'px; }' .
					   '.slideThree.small input[type=checkbox]:checked + label { left: ' . ( 28 + ($plus/2) ) . 'px; }';

		
		wp_add_inline_style ( 'griwpc-admin', $outCSS );
		
	}

	/*
	 *
	 * Screen construction callback functions
	 *
	 */
	 
	// Global callback function. 
	// It creates the three areas of the screen
	public function settings_page_function_callback () {

		$user_ID = wp_get_current_user()->ID;

		echo '<div class="wrap">';
		echo '<h2 class="recaptcha-plugin-title" >' . __GRIWPC__ . '</h2>';
		
		// Area 1: Plugin status
		echo '<div class="manage-menus">';
			echo '<div class="status-area">';
					$this->recaptcha_status();
			echo '</div>';
			echo '<div class="messages-area">';
					echo '<p>' . sprintf( __( 'If you like this plugin, please, consider activate the small <strong>credit link</strong> of the plugin in the accordion section <strong>%1$s</strong> and I would be grateful if you rate the plugin in <a href="%2$s" target="_blank" >Wordpress plugin page</a>.', 'recaptcha-in-wp-comments-form' ), $this->sections['outputModeSettings'], __GRIWPC_WP_SITE__ ) . '</p>';
			echo '</div>';
		echo '</div>';

		$this->google_recaptcha_assigned ( $user_ID );
			
		echo '</div>';
		
	}

	public function google_recaptcha_assigned ( $user_ID ) {

		echo '<div id="nav-menus-frame" class="wp-clearfix">';
		
			echo '<div id="menu-settings-column" class="metabox-holder">';
				echo '<div class="clear"></div>';
				echo '<form id="griwpc-form" class="griwpc-form" action="options.php" method="POST" >';
				
					echo '<input type="hidden" id="user-id" name="user_ID" value="' . (int) $user_ID .'" />';
					
					wp_nonce_field( 'meta-box-order',	'meta-box-order-nonce', false );
					wp_nonce_field( 'closedpostboxes',	'closedpostboxesnonce', false );
				
					// Area 2: Accordion Sections
					do_accordion_sections( get_current_screen(), 'side', $this->options );
					$this->saving_settings_function_callback();
					
				echo '</form>';
			echo '</div>';
			
			echo '<div id="menu-management-liquid">';
				echo '<div id="menu-management">';
				
					// Area 3: Example form sample
					$this->construct_form_example();
				echo '</div>';
			echo '</div>';
		
		echo '</div>';

	}

	// Area 1: Plugin status
	public function recaptcha_status() {
		
		$c 	   = ( isset ( $this->options['active'] ) && ! empty ( $this->options['active'] ) );
		$valid = griwpc_tools::check_google_API_keys_pair ( $this->options );
		
		$_class = ( $valid )	? '' : 'warning';
		$_clasx = ( $c ) 		? '' : 'warning';
		$_style	= ( $c ) 		? '' : 'style="display: none;"';

		$error1 = sprintf( 
				__( '<strong>Null API Keys</strong>. Visit <a href="%s" target="_blank" >Google reCAPTCHA</a> website, log in, register your site and get your API Keys.', 'recaptcha-in-wp-comments-form' ), 
				__GRIWPC_RECAPTCHA_SITE__ ) . ' ' . $this->strings['Amsg'];
		$error2 = sprintf( 
				__( '<strong>Invalid Site Key</strong>. Visit <a href="%s" target="_blank" >Google reCAPTCHA</a> website and check your <strong>Site</strong> Key.', 'recaptcha-in-wp-comments-form' ), 
				__GRIWPC_RECAPTCHA_SITE__ ) . ' ' . $this->strings['Amsg'];
		$error3 = sprintf( 
				__( '<strong>Invalid Secret Key</strong>. Visit <a href="%s" target="_blank" >Google reCAPTCHA</a> website and check your <strong>Secret</strong> Key.', 'recaptcha-in-wp-comments-form' ), 
				__GRIWPC_RECAPTCHA_SITE__ ) . ' ' . $this->strings['Amsg'];
		
		$ok 	= sprintf( 
				__( '<strong>OK</strong>. For further information see the <strong>Help</strong> tab of this screen, or visit the <a href="%1$s" target="_blank" >Author\'s plugin page</a> or the <a href="%2$s" target="_blank" >Google reCAPTCHA</a> website.', 'recaptcha-in-wp-comments-form' ), 
				__GRIWPC_SITE__,
				__GRIWPC_RECAPTCHA_SITE__ );
		
		echo '<p class="recaptcha-status-line" ><span class="recaptcha-lparams recaptcha-status">' . __( 'Plugin status:', 'recaptcha-in-wp-comments-form' ) . '</span>';
			$status =  ( $c ) ? __( 'Active', 'recaptcha-in-wp-comments-form' ) : __( 'Inactive', 'recaptcha-in-wp-comments-form' );
			echo sprintf( '<span class="recaptcha-msg %1$s"><strong>%2$s</strong> running in PHP v. %3$s</span>', $_clasx, $status, phpversion() );
		echo '</p>';

		echo '<p class="recaptcha-status-line"><span class="recaptcha-lparams recaptcha-operation">' . __( 'reCAPTCHA operation:', 'recaptcha-in-wp-comments-form' ) . '</span>';
			$status =  ( $valid ) ? __( 'Connected', 'recaptcha-in-wp-comments-form' ) : __( 'Disconnected', 'recaptcha-in-wp-comments-form' );
			echo sprintf( '<span class="recaptcha-msg %1$s">%2$s</span>', $_class, $status );
		echo '</p>';

		echo '<p class="recaptcha-status-line"><span class="recaptcha-lparams recaptcha-messages">' . __( 'Message:', 'recaptcha-in-wp-comments-form' ) . '</span>';
		echo '<span class="recaptcha-msg">';
		
			if ( ! ($valid ) ) {
				if ( $a == $b ) {
					echo $error1;
				} else {
					if ( ! $a ) 
						echo $error2;
					else
						echo $error3;
				}
			} else {
				echo $ok;
			}
			
		echo '</span>';
		echo '</p>';

	}


	// Area 2: Accordion Sections
	// 		   Area 2 is created via metaboxes, see Metaboxes callback functions for accordion sections below


	// Area 3: Example form sample
/*	    require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
        echo '<pre>';
		echo print_r( wp_get_available_translations() );
		echo '</pre>'; */
	public function construct_form_example() {

		$valueSite   = ( ( isset ( $this->options['site_key'] )   && ( $this->options['site_key']   != '' )) ? $this->options['site_key']   : FALSE );
		$valueSecret = ( ( isset ( $this->options['secret_key'] ) && ( $this->options['secret_key'] != '' )) ? $this->options['secret_key'] : FALSE );
		$htmlTag     = ( ( isset ( $this->options['recaptcha_tag'] ) && ( $this->options['recaptcha_tag'] != '' )) ? $this->options['recaptcha_tag'] : 'p' );
		$c 			 = ( isset ( $this->options['active'] ) && ! empty ( $this->options['active'] ) );

		echo '<div class="menu-edit ">';
			echo '<div id="nav-menu-header">';
				echo '<h3>' . __( 'Comments form sample', 'recaptcha-in-wp-comments-form' ) . '</h3>';
			echo '</div>';

			echo '<div id="post-body">';
			
				echo '<div id="post-body-content" class="wp-clearfix">';
					echo '<div id="commentformdiv" class="comment-form-example">';
						echo '<h2 id="reply-title" class="comment-reply-title">' . __( 'Leave a Reply', 'recaptcha-in-wp-comments-form' ) . '</h2>';
						
						echo '<form id="commentform" class="comment-form">';
						
							echo '<p class="comment-notes">';
							echo '<span id="email-notes">' . __( 'Your email address will not be published.', 'recaptcha-in-wp-comments-form' ) . '</span>';
							echo sprintf( ' ' . __('Required fields are marked %s', 'recaptcha-in-wp-comments-form' ), '<span class="required">*</span>');
							echo '</p>';
							echo '<p><label for="comment">' . _x( 'Comment', 'noun', 'recaptcha-in-wp-comments-form' ) . '</label> <textarea id="comment" class="field-example" rows="5" readonly>' . __( 'This is a comment text sample with one paragraph.', 'recaptcha-in-wp-comments-form' ) . '</textarea></p>';
							echo '<p><label for="author">'  . __( 'Name', 'recaptcha-in-wp-comments-form' ) . ' <span class="required">*</span>' . '</label> <input id="author" type="text" class="field-example" readonly value="' . __( 'John Doe Doe', 'recaptcha-in-wp-comments-form' ) . '"/></p>';
							echo '<p><label for="email">'   . __( 'Email', 'recaptcha-in-wp-comments-form' ) . ' <span class="required">*</span>' . '</label> <input id="email" type="email" class="field-example" readonly value="' . __( 'address@example.com', 'recaptcha-in-wp-comments-form' ) . '"></p>';
							echo '<p><label for="url">'     . __( 'Website', 'recaptcha-in-wp-comments-form' ) . '</label> <input id="url" type="url" class="field-example" readonly value="' . __( 'http://example.com', 'recaptcha-in-wp-comments-form' ) . '"></p>';
							
							if ( $c ) {
	
								if ( ( $valueSite === FALSE ) || ( $valueSecret === FALSE ) ) {
									
									echo '<p class="warning" >' . 
									sprintf( __( 'Plugin can\'t connect. You have to introduce a correct Site and Secret API Key pair in the <strong>%s</strong> accordion section.', 'recaptcha-in-wp-comments-form' ), $this->sections['apiKeys'] ) . '</p>';
									
								} else {
									
									if ( $this->options['old_themes_compatibility'] != 1 )
										echo $this->reCAPTCHA->render_HTML ( $htmlTag, $this->options );
										
								}
							
							} else {
								
									echo '<p class="warning" >' . 
									sprintf( __( 'Plugin Inactive. You have to activate the plugin in <strong>%s</strong> accordion section.', 'recaptcha-in-wp-comments-form' ), $this->sections['activation'] ) . '</p>';
								
							}
						
							echo '<p><input id="submit" class="submit button button-secondary" value="' . __( 'Post Comment', 'recaptcha-in-wp-comments-form' ) . '"></p>';
						
						echo '</form>';
						
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';

	}


	/*
	 *
	 * Metaboxes callback functions for accordion sections
	 *
	 */

	public function recaptcha_activation_function_callback ( $options ) {
		
		$active = (boolean) isset ( $options['active'] ) ? $options['active'] : 0;
		$this->settingsClass->reCaptchaActive( $active );

	}

	public function recaptcha_keys_function_callback ( $options ) {

		echo '<p>Paste the <span class="warning">Google reCAPTCHA API Keys pair</span> values here</p>';

		$vSite	 = isset ( $options['site_key'] )	? $options['site_key'] : NULL;
		$vSecret = isset ( $options['secret_key'] ) ? $options['secret_key'] : NULL;

		$this->settingsClass->siteKey( $vSite );
		$this->settingsClass->secretKey( $vSecret );

	}
	
	public function recaptcha_settings_function_callback ( $options ) {

		$valueTheme = isset ( $options['recaptcha_theme'] )	? $options['recaptcha_theme']	: 'light';
		$valueSize	= isset ( $options['recaptcha_size'] )	? $options['recaptcha_size']	: 'normal';
		$valueType	= isset ( $options['recaptcha_type'] )	? $options['recaptcha_type']	: 'image';
		$valueAlign	= isset ( $options['recaptcha_align'] )	? $options['recaptcha_align']	: 'left';
		$language	= isset ( $options['recaptcha_lang'] )	? $options['recaptcha_lang']	: '-1';

		$this->settingsClass->reCaptchaTheme( $valueTheme );
		$this->settingsClass->reCaptchaSize( $valueSize );
		$this->settingsClass->reCaptchaType( $valueType );
		$this->settingsClass->reCaptchaAlign( $valueAlign );
		$this->settingsClass->reCaptchaLanguage( $language );

	}
	
	public function antispam_settings_function_callback ( $options ) {
		
		$mode		= isset ( $options['recaptcha_mode'] )	? $options['recaptcha_mode']	: 'spam';

		echo '<p>' . __( 'When the plugin detects an unauthorized comment or a security breach, which action do you want to do?', 'recaptcha-in-wp-comments-form' ) . '</p>';
		$this->settingsClass->reCaptchaMode( $mode );
//		echo '<hr style="margin:2rem 0rem 1.5rem 0rem;" />';

	}
	
	public function plugin_settings_function_callback ( $options ) {

		$formID		= isset ( $options['formID'] )			? $options['formID']			: 'commentform';
		$buttonID	= isset ( $options['buttonID'] )		? $options['buttonID']			: 'submit';
		$tag		= isset ( $options['recaptcha_tag'] )	? $options['recaptcha_tag']		: 'p';
		$css		= isset ( $options['recaptcha_css'] )	? $options['recaptcha_css']		: '.google-recaptcha-container{display:block;clear:both;}';


		echo '<h4 class="subsection-toggler _closed" >' . __( 'About <span class="dashicons dashicons-image-rotate"></span> button in all fields of this section', 'recaptcha-in-wp-comments-form' )  . '</h4>';
		echo '<div class="subsection-content _closed" >';
			echo '<p>' . __( 'Press these buttons for <strong>restoring separately</strong> each one of the <strong>original plugin default values</strong>.', 'recaptcha-in-wp-comments-form' )  . '</p>';
			echo '<p>' . __( 'So that, if you have deleted (or forgot) accidentally any of these next values, you\'ve changed your WP theme and the reCAPTCHA field doesn\'t appear, you are testing a new configuration or whatever... Don\'t worry, just relax you and press these buttons each time you need it.', 'recaptcha-in-wp-comments-form' )  . '</p>';
		echo '</div>';

		echo '<hr style="margin:2rem 0rem 1.5rem 0rem;" />';

		echo '<p>' . __( 'Change the value of these setting, only if the comments form of your theme, or its submit button have got different HTML <strong>id</strong> attributtes.', 'recaptcha-in-wp-comments-form' ) . '</p>';

		$this->settingsClass->formID( $formID );
		$this->settingsClass->buttonID( $buttonID );
		echo '<hr style="margin:2rem 0rem 1.5rem 0rem;" />';
		
		echo '<p>' . __( 'You can modify the HTML tag container for reCAPTCHA field.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		$this->settingsClass->recaptchaTag( $tag );

		echo '<hr style="margin:2rem 0rem 1.5rem 0rem;" />';

		echo '<p>' . __( 'You can modify the reCAPTCHA container style via CSS using the <code>.google-recaptcha-container</code> class.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		$this->settingsClass->recaptchaCSS( $css );

	}
	
	public function output_settings_function_callback ( $options ) {

		$oldThemeMode = isset ( $options['old_themes_compatibility'] )	? $options['old_themes_compatibility']	: -1;
		$allowCreditMode = isset ( $options['allowCreditMode'] ) ? $options['allowCreditMode']	: 0;
		
		echo '<p>' . __( 'If your theme doesn\'t use the WP function <code>comment_form()</code> but it makes a direct PHP output of the form code, you should activate the <strong>Javascript Output Mode</strong> to see the reCAPTCHA field.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		$this->settingsClass->javascriptOutputMode( $oldThemeMode );
		
		echo '<hr style="margin:2rem 0rem 1.5rem 0rem;" />';

		echo '<p>' . __( 'Do you like this plugin? Please, allow you a little credits output.', 'recaptcha-in-wp-comments-form' ) . '</p>';
		$this->settingsClass->allowCreditsModeCallback( $allowCreditMode );


	}
	

	// It works as a callback function but it's not a call back function for any accordion section.
	// A jQuery function puts this pseudo-section code at the end of accordion sections list for showing just the save button
	public function saving_settings_function_callback () {
		
		echo '<div id="form-actions-section" class="control-section accordion-section form-actions-section">';
			echo '<div class="accordion-section-content ">';
				echo '<div class="inside">';

					settings_fields( 'griwpc_settings' );
					echo '<div class="major-publishing-actions wp-clearfix">';
						echo'<div class="publishing-action">';
							submit_button();
						echo '</div><!-- END .publishing-action -->';
					echo '</div><!-- END .major-publishing-actions -->';


				echo '</div><!-- .inside -->';
			echo '</div><!-- .accordion-section-content -->';
		echo '</div>';

	}
	

}
