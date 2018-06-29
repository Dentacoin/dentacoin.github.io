<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        tools.php
 * Since:       0.0.9
 */
 
/*
 * Class:       griwpc_settings
 * Version:     0.0.9.0.2
 * Description: The class controls the settings of the plugin: initialization, creation, fields, etc.
 */

class griwpc_settings {

	private $options;
	private $defaults;
	private $optionsKey;
	
	public function __construct() {
		
		$this->optionsKey	= 'griwpc-params';
		$this->set_defaults();
		$this->set_options();
		
	}
	
	/**
	 * Plugin default options values
	 */

	// Set default options values
	public function set_defaults () {
		$this->defaults	= 
			array(
				'active'			=> 0,
				'site_key'			=> '',
				'secret_key'		=> '',
				'recaptcha_theme'	=> 'light',
				'recaptcha_size'	=> 'normal',
				'recaptcha_type'	=> 'image',
				'recaptcha_lang'	=> -1,
				'recaptcha_mode'	=> 'spam',
				'recaptcha_align'   => 'left',
				'formID'			=> 'commentform',
				'buttonID'			=> 'submit',
				'recaptcha_tag'		=> 'p',
				'recaptcha_css'		=> '.google-recaptcha-container{display:block;clear:both;}',
				'old_themes_compatibility' => 0,
				'allowCreditMode'	=> 0,
			);		
	}

	// Get default options values
	public function get_defaults () {
		return $this->defaults;
	}


	/**
	 *
	 * Plugin option values
	 *
	 */

	// Create a new array of options on installation
	public function create_options() {
	 	add_option ( $this->optionsKey, $this->get_defaults() );
	}

	// Get the array of options	
	public function get_options( $key = NULL ) {
		return $this->options;		
	}

	// Set the array of options	
	public function set_options( $key = NULL ) {
		$this->options = get_option ( $this->optionsKey );
	}

	public function update_options( $options = NULL ) {
		update_option ( $this->optionsKey, $options );	
	}
		
	// Register array of settings	
	public function settings_register () {
		register_setting( 'griwpc_settings', $this->optionsKey, array ( $this, 'settings_sanitize_function_callback' ) );
	}

	// Register array of settings	
	public function settings_sanitize_function_callback ( $input ) {
		
		$input = wp_parse_args( $input, $this->get_defaults() );
		
	 	if ( count ( $input ) ) {
			
			add_settings_error(
				'saving_plugin_options', 
				'settings_updated', 
				// Avoid the forced <strong></strong> tag in settings messages
				'</strong>' . __( 'Plugin and reCAPTCHA settings saved.', 'recaptcha-in-wp-comments-form' ) . '<strong>', 
				'updated'
			);
		}
		
		if ( griwpc_tools::check_google_API_keys_pair( $input ) === FALSE ) {
			
			$strings	= griwpc_messages::get_screen_strings_array();
		
			add_settings_error(
				'empty_reCAPTCHA_API_Keys_pair',
				'settings_updated',
				// Avoid the forced <strong></strong> tag in settings messages
				'</strong>' . sprintf ( _x( 'One or both parts of the %1$s are empty. Plugin has switched to the Installation Wizard mode.', '1: reCAPTCHA pair string', 'recaptcha-in-wp-comments-form' ), $strings['googleKeysPair'] ) . '<strong>',
				'error'
			);
			
		}

		return $input;
		
	}
	

	/*
	 *
	 * Plugin settings field functions
	 *
	 */

	public function siteKey ( $value = NULL ) {
		echo '<p id="menu-item-sitekey-wrap" class="wp-clearfix">';
		echo '<label class="howto" for="griwpc_params_site_key">'   . __ ( 'Site key', 'recaptcha-in-wp-comments-form' )   . '</label>';
		echo '<input type="text" id="griwpc_params_site_key" name="griwpc-params[site_key]" class="code menu-item-textbox" value="' . $value . '" placeholder="' . __ ( 'Paste your Site key here', 'recaptcha-in-wp-comments-form' ) . '" />';
		echo '</p>';
	}

	public function secretKey ( $value = NULL ) {
		echo '<p id="menu-item-secretkey-wrap" class="wp-clearfix">';
		echo '<label class="howto" for="griwpc_params_secret_key">' . __ ( 'Secret key', 'recaptcha-in-wp-comments-form' ) . '</label>';
		echo '<input type="text" id="griwpc_params_secret_key" name="griwpc-params[secret_key]" class="code menu-item-textbox" value="' . $value . '" placeholder ="' . __ ( 'Paste your Secret key here', 'recaptcha-in-wp-comments-form' ) . '" />';
		echo '</p>';
	}

	public function reCaptchaTheme ( $value = NULL ) {
		echo '<p id="menu-item-recaptchatheme-wrap" class="radio-image-container wp-clearfix">';
			echo '<legend class="howto" >' . __ ( 'Theme', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';

			echo '<span class="options-switcher wp-ui-primary">';
				echo '<label for="griwpc_params_recaptcha_theme_1">';
				$check = checked( $value, 'light', FALSE );
				echo '<input data-part="recaptcha_theme" type="radio" id="griwpc_params_recaptcha_theme_1" name="griwpc-params[recaptcha_theme]" class="code menu-item-textbox radioImage" value="light" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-light.png" title="' . _x( 'Light', 'Google reCAPTCHA option name. Don\'t translate if it\'s not necessary.', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
				
				echo '<label for="griwpc_params_recaptcha_theme_2">';
				$check = checked( $value, 'dark', FALSE );
				echo '<input data-part="recaptcha_theme" type="radio" id="griwpc_params_recaptcha_theme_2" name="griwpc-params[recaptcha_theme]" class="code menu-item-textbox radioImage" value="dark" ' .  $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-dark.png" title="' . _x( 'Dark', 'Google reCAPTCHA option name. Don\'t translate if it\'s not  necessary.', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
			echo '</span>';
		
		echo '</p>';
	}

	public function reCaptchaSize ( $value = NULL ) {
		echo '<p id="menu-item-recaptchasize-wrap" class="radio-image-container wp-clearfix">';
			echo '<legend class="howto" >' . __ ( 'Size', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';
			echo '<span class="options-switcher wp-ui-primary">';
				echo '<label for="griwpc_params_recaptcha_size_1">';
				$check = checked( $value, 'normal', FALSE );
				echo '<input data-part="recaptcha_size" type="radio" id="griwpc_params_recaptcha_size_1" name="griwpc-params[recaptcha_size]" class="code menu-item-textbox radioImage" value="normal" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-normal.png" title="' . _x( 'Normal', 'Google reCAPTCHA option name. Don\'t translate if it\'s not necessary.', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
				
				echo '<label for="griwpc_params_recaptcha_size_2">';
				$check = checked( $value, 'compact', FALSE );
				echo '<input data-part="recaptcha_size" type="radio" id="griwpc_params_recaptcha_size_2" name="griwpc-params[recaptcha_size]" class="code menu-item-textbox radioImage" value="compact" ' .  $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-compact.png" title="' . _x( 'Compact', 'Google reCAPTCHA option name. Don\'t translate if it\'s not necessary.', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
			echo '</span>';
		echo '</p>';
	}

	public function reCaptchaType ( $value = NULL ) {
		echo '<p id="menu-item-recaptchatype-wrap" class=" radio-image-container wp-clearfix">';
			echo '<legend class="howto" >' . __ ( 'Type', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';
			echo '<span class="options-switcher wp-ui-primary">';
				echo '<label for="griwpc_params_recaptcha_type_1">';
				$check = checked( $value, 'image', FALSE );
				echo '<input data-part="recaptcha_type" type="radio" id="griwpc_params_recaptcha_type_1" name="griwpc-params[recaptcha_type]" class="code menu-item-textbox radioImage" value="image" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-image.png" title="' . _x( 'Image', 'Google reCAPTCHA option name. Don\'t translate if it\'s not necessary.', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
				
				echo '<label for="griwpc_params_recaptcha_type_2">';
				$check = checked( $value, 'audio', FALSE );
				echo '<input data-part="recaptcha_type" type="radio" id="griwpc_params_recaptcha_type_2" name="griwpc-params[recaptcha_type]" class="code menu-item-textbox radioImage" value="audio" ' .  $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-audio.png"  title="' . _x( 'Audio', 'Google reCAPTCHA option name. Don\'t translate if it\'s not necessary.', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
			echo '</span>';
		echo '</p>';
	}

	public function reCaptchaAlign ( $value = NULL ) {
		echo '<p id="menu-item-recaptchaalign-wrap" class=" radio-image-container wp-clearfix">';
			echo '<legend class="howto" >' . __ ( 'Align', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';
			echo '<span class="options-switcher wp-ui-primary">';
			
				echo '<label for="griwpc_params_recaptcha_align_1">';
				$check = checked( $value, 'left', FALSE );
				echo '<input data-part="recaptcha_align" type="radio" id="griwpc_params_recaptcha_align_1" name="griwpc-params[recaptcha_align]" class="code menu-item-textbox radioImage" value="left" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-left.png" title="' . _x( 'Left', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

				echo '<label for="griwpc_params_recaptcha_align_2">';
				$check = checked( $value, 'center', FALSE );
				echo '<input data-part="recaptcha_align" type="radio" id="griwpc_params_recaptcha_align_2" name="griwpc-params[recaptcha_align]" class="code menu-item-textbox radioImage" value="center" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-center.png" title="' . _x( 'Center', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

				echo '<label for="griwpc_params_recaptcha_align_3">';
				$check = checked( $value, 'right', FALSE );
				echo '<input data-part="recaptcha_align" type="radio" id="griwpc_params_recaptcha_align_3" name="griwpc-params[recaptcha_align]" class="code menu-item-textbox radioImage" value="right" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-switch-right.png" title="' . _x( 'Right', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

			echo '</span>';
		echo '</p>';
	}

	public function reCaptchaLanguage ( $value = NULL ) {
		
		require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
		
		// plugin v0.0.9 
		// Change minimum WP version to 4.0.0
		$alang = wp_get_available_translations();
		
		echo '<p id="menu-item-recaptcha_lang-wrap" class="wp-clearfix radio-image-container">';
		echo '<legend class="howto" for="griwpc_params_recaptcha_lang" >' . __ ( 'Language', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';
		echo '<select id="griwpc_params_recaptcha_lang" name="griwpc-params[recaptcha_lang]" value="' . $value . '" />';
		foreach ( griwpc_tools::get_languages() as $key => $v ) {
			switch ( $key ) {
				case 'es':
					$_key = 'es-ES'; break;
				case 'fr' :
					$_key = 'fr-FR'; break;
				case 'no' :
					$_key = 'nn-NO'; break;
				default :
				    $_key = $key;
			}
			$kLang = str_replace( '-', '_', $_key );
			
			if ( isset ( $alang[ $kLang ] ) ) {
				$stringName =  $alang[ $kLang ]['native_name'];
			} elseif ( ( $elem = griwpc_tools::search_language_by_name ( $v, $alang ) ) != FALSE ) {
				$stringName = $elem['native_name'];
			} else {
				$stringName	= $v;
			}
			
			if ( is_numeric( $key ) )
				echo '<option value="' . $key . '" ' . selected ( $key, $value, FALSE ) . ' data-englishname="' . $v . '"' . ' data-nativename="' . $stringName . '" >' . $stringName . '</option>';
			else		
				echo '<option value="' . $key . '" ' . selected ( $key, $value, FALSE ) . ' data-englishname="' . $v . '"' . ' data-nativename="' . $stringName . '" >' . $stringName . ' - ' . $v . '</option>';
			
		}
		echo '</select>';
		echo '<span id="language-selector-button-wrap">';
		echo '<span id="language-selector-button" class="wp-ui-highlight" >';
		echo '<img src="' . __GRIWPC_URL__ . '/images/g-select-language.png" title="' . __( 'Force the language in which reCAPTCHA field speaks', 'recaptcha-in-wp-comments-form' ) . '"/>';
		echo '</span>';
		echo '</span>';
		echo '</p>';
	}

	public function _reCaptchaLanguage ( $value = NULL ) {

		require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
		$alang = wp_get_available_translations();
		
		echo '<p id="menu-item-recaptcha_lang-wrap" class="wp-clearfix radio-image-container">';
		echo '<legend class="howto" for="griwpc_params_recaptcha_lang" >' . __ ( 'Language', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';
		
			echo '<span class="options-switcher wp-ui-primary">';
				echo '<label for="griwpc-params_recaptcha_language_1">';
				$check = checked( (int) $value, -1, FALSE );
				echo '<input type="radio" id="griwpc-params_recaptcha_language_1" class="code menu-item-textbox" value="-1" ' . $check . '/>';
				echo '<img title="' .__("Detect user's browser language", 'recaptcha-in-wp-comments-form' ) . '" src="' . __GRIWPC_URL__ . '/images/g-select-language-browser.png" title="' . __( 'Mark comment as SPAM', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
				
				echo '<label for="griwpc-params_recaptcha_language_2">';
				$check = checked( (int) $value, -2, FALSE );
				echo '<input type="radio" id="griwpc-params_recaptcha_language_2" class="code menu-item-textbox" value="-2" ' . $check . '/>';
				echo '<img title="' . __('Use always site language', 'recaptcha-in-wp-comments-form' ) . '" src="' . __GRIWPC_URL__ . '/images/g-select-language-site.png" title="' . __('Use always site language', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

				echo '<label for="griwpc-params_recaptcha_language_3">';
				$check = ( ! is_numeric ($value ) ) ? checked( TRUE, TRUE, FALSE ) : '';
				echo '<input type="radio" id="griwpc-params_recaptcha_language_3" class="code menu-item-textbox" value="TRUE" ' . $check . '/>';
				echo '<img title="' .__('Force language in which reCAPTCHA field speacks', 'recaptcha-in-wp-comments-form' ) . '" id="griwpc-params_recaptcha_language_3-img" src="' . __GRIWPC_URL__ . '/images/g-select-language.png" title="' . __( 'Directly DELETE comment', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

			echo '</span>';
			
			echo '<select id="griwpc_params_recaptcha_lang" name="griwpc-params[recaptcha_lang]" value="' . $value . '" />';
			foreach ( griwpc_tools::get_languages() as $key => $v ) {
				switch ( $key ) {
					case 'es':
						$_key = 'es-ES'; break;
					case 'fr' :
						$_key = 'fr-FR'; break;
					case 'no' :
						$_key = 'nn-NO'; break;
					default :
						$_key = $key;
				}
				$kLang = str_replace( '-', '_', $_key );
				
				if ( isset ( $alang[ $kLang ] ) ) {
					$stringName =  $alang[ $kLang ]['native_name'];
				} elseif ( ( $elem = griwpc_tools::search_language_by_name ( $v, $alang ) ) != FALSE ) {
					$stringName = $elem['native_name'];
				} else {
					$stringName	= $v;
				}
				
				if ( is_numeric( $key ) )
					echo '<option value="' . $key . '" ' . selected ( $key, $value, FALSE ) . ' data-englishname="' . esc_attr($v) . '"' . ' data-nativename="' . esc_attr($stringName) . '" >' . esc_attr( $stringName ) . '</option>';
				else		
					echo '<option value="' . $key . '" ' . selected ( $key, $value, FALSE ) . ' data-englishname="' . esc_attr($v) . '"' . ' data-nativename="' . esc_attr($stringName) . '" >' . esc_attr( $stringName . ' - ' . $v ) . '</option>';
				
			}
			echo '</select>';

		echo '</p>';
	}

	public function reCaptchaMode ( $value = NULL ) {
		
		echo '<p id="menu-item-recaptcha_mode-wrap" class="wp-clearfix radio-image-container">';
		echo '<legend class="howto">' . __ ( 'Action:', 'recaptcha-in-wp-comments-form' ) . '<span class="wp-ui-text-highlight actual-selection"></span></legend>';
			echo '<span class="options-switcher wp-ui-primary">';
				echo '<label for="griwpc-params_recaptcha_mode_1">';
				$check = checked( $value, 'spam', FALSE );
				echo '<input type="radio" id="griwpc-params_recaptcha_mode_1" name="griwpc-params[recaptcha_mode]" class="code menu-item-textbox radioImage" value="spam" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-spam-spam.png" title="' . __( 'Mark comment as SPAM', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
				
				echo '<label for="griwpc-params_recaptcha_mode_2">';
				$check = checked( $value, 'trash', FALSE );
				echo '<input type="radio" id="griwpc-params_recaptcha_mode_2" name="griwpc-params[recaptcha_mode]" class="code menu-item-textbox radioImage" value="trash" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-spam-trash.png" title="' . __( 'Send comment to TRASH', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

				echo '<label for="griwpc-params_recaptcha_mode_3">';
				$check = checked( $value, 'delete', FALSE );
				echo '<input type="radio" id="griwpc-params_recaptcha_mode_3" name="griwpc-params[recaptcha_mode]" class="code menu-item-textbox radioImage" value="delete" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-spam-delete.png" title="' . __( 'Directly DELETE comment', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';

				echo '<label for="griwpc-params_recaptcha_mode_4">';
				$check = checked( $value, 'die', FALSE );
				echo '<input type="radio" id="griwpc-params_recaptcha_mode_4" name="griwpc-params[recaptcha_mode]" class="code menu-item-textbox radioImage" value="die" ' . $check . '/>';
				echo '<img src="' . __GRIWPC_URL__ . '/images/g-spam-die.png" title="' . __( 'BLOCK access executing WP_DIE()', 'recaptcha-in-wp-comments-form' ) . '"' . (( $check ) ? ' class="wp-ui-highlight" ' : '' ) . '/></label>';
				
			echo '</span>';
		echo '</p>';
	}

	public function formID ( $value = NULL ) {
		$defaults = $this->get_defaults();
		echo '<p id="menu-item-secretkey-wrap" class="wp-clearfix">';
		echo '<label class="howto" for="griwpc_params_formID">' . __( 'Comments form ID', 'recaptcha-in-wp-comments-form' ) . '</label>';
		echo '<input data-defaultvalue="' . $defaults['formID'] . '" type="text" id="griwpc_params_formID" name="griwpc-params[formID]" class="code menu-item-textbox menu-item-input field-with-button-operation" value="' . $value . '" />';
		echo '<button class="button-restoredefaultvalue button button-field-operation" title="' . __ ( 'Press this button for restoring plugin default value', 'recaptcha-in-wp-comments-form' ) . '"><span class="dashicons dashicons-image-rotate"></span></button>';
		echo '</p>';
	}

	public function buttonID ( $value = NULL ) {
		$defaults = $this->get_defaults();
		echo '<p id="menu-item-secretkey-wrap" class="wp-clearfix">';
		echo '<label class="howto" for="griwpc_params_buttonID">' . __ ( 'Submit button ID', 'recaptcha-in-wp-comments-form' ) . '</label>';
		echo '<input data-defaultvalue="' . $defaults['buttonID'] . '" type="text" id="griwpc_params_buttonID" name="griwpc-params[buttonID]" class="code menu-item-textbox menu-item-input field-with-button-operation" value="' . $value . '" />';
		echo '<button class="button-restoredefaultvalue button button-field-operation" title="' . __ ( 'Press this button for restoring plugin default value', 'recaptcha-in-wp-comments-form' ) . '"><span class="dashicons dashicons-image-rotate"></span></button>';
		echo '</p>';
	}

	public function recaptchaTag ( $value = NULL ) {
		$defaults = $this->get_defaults();
		echo '<p id="menu-item-recaptcha_tag-wrap" class="wp-clearfix">';
		echo '<label class="howto" for="griwpc_params_recaptcha_tag">' . __ ( 'HTML tag container for reCAPTTCHA', 'recaptcha-in-wp-comments-form' ) . '</label>';
		echo '<select data-defaultvalue="' . $defaults['recaptcha_tag'] . '"  id="griwpc_params_recaptcha_tag" name="griwpc-params[recaptcha_tag]" value="' . $value . '" class="code menu-item-textbox menu-item-select field-with-button-operation" />';
			echo '<option value="p" '      . selected ( $value, 'p', FALSE )    . ' >&lt;p&gt;&lt;/p&gt;</option>';
			echo '<option value="span" '   . selected ( $value, 'span', FALSE ) . ' >&lt;span&gt;&lt;/span&gt;</option>';
			echo '<option value="div" '    . selected ( $value, 'div', FALSE )  . ' >&lt;div&gt;&lt;/div&gt;</option>';
		echo '</select>';
		echo '<button class="button-restoredefaultvalue button button-field-operation" title="' . __ ( 'Press this button for restoring plugin default value', 'recaptcha-in-wp-comments-form' ) . '"><span class="dashicons dashicons-image-rotate"></span></button>';
		echo '</p>';
	}

	public function recaptchaCSS ( $value = NULL ) {
		$defaults = $this->get_defaults();
		echo '<p id="menu-item-recaptcha_tag-wrap" class="wp-clearfix">';
		echo '<label class="howto" for="griwpc_params_recaptcha_css">' . __ ( 'reCAPTCHA container CSS', 'recaptcha-in-wp-comments-form' ) . '</label>';
		echo '<textarea data-defaultvalue="' . $defaults['recaptcha_css'] . '" name="griwpc-params[recaptcha_css]" class="code menu-item-textbox menu-item-textarea field-with-button-operation" id="griwpc_params_recaptcha_css">' . esc_attr ( $value ) . '</textarea>';
		echo '<button class="button-restoredefaultvalue button button-field-operation" title="' . __ ( 'Press this button for restoring plugin default value', 'recaptcha-in-wp-comments-form' ) . '"><span class="dashicons dashicons-image-rotate"></span></button>';
		echo '</p>';
	}

	public function reCaptchaActive ( $value = NULL ) {
		echo '<legend class="howto" >' . __ ( 'reCAPTCHA', 'recaptcha-in-wp-comments-form' ) . '</legend>';
		echo '<input type="hidden" name="griwpc-params[active]" value="0"/>';
		echo '<div class="slideThree wp-ui-primary">';
			echo '<input type="checkbox" id="griwpc_params_active" name="griwpc-params[active]" value="1" ' . checked( $value, 1, FALSE ) . '/>';
			echo '<label for="griwpc_params_active" class="wp-ui-highlight" ></label>';
		echo '</div>';
	}

	public function javascriptOutputMode ( $value = NULL ) {

		echo '<legend class="howto isOnlineBlock" >' .  __( 'Forced javascript output', 'recaptcha-in-wp-comments-form' ) . '</legend>';
		echo '<input type="hidden" name="griwpc-params[old_themes_compatibility]" value="0"/>';
		echo '<div class="slideThree isToRight small wp-ui-primary">';
			echo '<input type="checkbox" id="griwpc_params_old_themes_compatibility" name="griwpc-params[old_themes_compatibility]" value="1" ' . checked( $value, 1, FALSE ) . '/>';
			echo '<label for="griwpc_params_old_themes_compatibility" class="wp-ui-highlight" ></label>';
		echo '</div>';

	}

	public function allowCreditsModeCallback ( $value = NULL ) {

		echo '<legend class="howto isOnlineBlock" >' .  __( 'Credit Link', 'recaptcha-in-wp-comments-form' ) . '</legend>';
		echo '<input type="hidden" name="griwpc-params[allowCreditMode]" value="0"/>';
		echo '<div class="slideThree isToRight small wp-ui-primary">';
			echo '<input type="checkbox" id="griwpc_params_allowCreditMode" name="griwpc-params[allowCreditMode]" value="1" ' . checked( $value, 1, FALSE ) . '/>';
			echo '<label for="griwpc_params_allowCreditMode" class="wp-ui-highlight" ></label>';
		echo '</div>';

	}

}