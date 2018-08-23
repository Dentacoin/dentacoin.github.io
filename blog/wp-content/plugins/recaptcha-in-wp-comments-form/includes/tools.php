<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        tools.php
 * Since:       0.0.4
 */
 
/*
 * Class:       griwpc_tools
 * Version:     9.0.3
 * Description: This class contains the support functions of the plugin. 
 *				The list of languages is not translated because the official Google translations page for reCAPTCHA has not been translated.
 *              This class also contains the basic rutines for plugin installation and updating
 */

class griwpc_tools {


	static function check_google_API_keys_pair ( $options ) {

// 		v0.0.9.0.1 
//		Change one line functions for incompatible function call trim() with old PHP versions (v < 5.4.0)
		$a = $b = FALSE;
		if ( isset ( $options['site_key'] ) ) {
			$p = trim ( $options['site_key'] );
			$a = ! empty ( $p );
		}
		if ( isset ( $options['secret_key'] ) ) {
			$pp = trim ( $options['secret_key'] );
			$b  = ! empty ( $pp );
		}
		return (boolean) ( $a && $b );

	}



	/**********************************************************************************************************************
	 *
	 * Translations and reCAPTCHA language module
	 *
	 */

	// Searching languages inside WP language array by name
	static function search_language_by_name ( $needle, $languages ) {
		foreach ( $languages as $key => $value ) {
			if ( $value['english_name'] == $needle ) 
				return $value;
		}
		return FALSE;
	}

		
	// Check Languages codes for name exceptions
	// For example, for Portuguese there are three variants: pt, pt-PT, pt-BR. In English there are two variants, etc.
	// For the rest of languages, we use just the two first letters in lowercase.
	static function adapt_language_code ( $code ) {
		
		$code = str_replace ( '_', '-', $code );
		$parts = explode ( '-', $code );
		
		if ( isset ( $parts[1] ) ) {
			
			$parts[1] = strtoupper( $parts[1] );
			
			if ( ( $parts[0] == 'es' ) && ( $parts[1] == '419' ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'en' ) && ( $parts[1] == 'GB'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'de' ) && ( $parts[1] == 'AT'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'de' ) && ( $parts[1] == 'CH'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'fr' ) && ( $parts[1] == 'CA'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'pt' ) && ( $parts[1] == 'BR'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'pt' ) && ( $parts[1] == 'PT'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'zh' ) && ( $parts[1] == 'HK'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'zh' ) && ( $parts[1] == 'CN'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
			if ( ( $parts[0] == 'zh' ) && ( $parts[1] == 'TW'  ) )
				$parts[0] = $parts[0] . '-' . $parts[1];
				
		}
		
		$code = $parts[0];			
		
		return $code;
		
	}


	// Create the language selector options list
	static function get_languages() {
		return 
			array (
				// First option is the default Google reCAPTCHA widget language mode: user's browser autodetect
				-1 => __( "Detect user's browser language", 'recaptcha-in-wp-comments-form' ),
				
				// Second option forces Google reCAPTCHA widget to use the site language via WP function get_locale()
				-2 => __( 'Use always site language', 'recaptcha-in-wp-comments-form' ),
				
				// Next array elements are the Google reCAPTCHA available languages codes, 
				// https://developers.google.com/recaptcha/docs/language
				
				// These language names are not translateble strings to always also keep the English language name
				// so that the plugin will automatically give the translated names for all languages found through 
				// the WP wp_get_available_translations() function
				'ar' => 'Arabic',
				'af' => 'Afrikaans',
				'am' => 'Amharic',
				'hy' => 'Armenian',
				'az' => 'Azerbaijani',
				'eu' => 'Basque',
				'bn' => 'Bengali',
				'bg' => 'Bulgarian',
				'ca' => 'Catalan',
				'zh-HK' => 'Chinese (Hong Kong)',
				'zh-CN' => 'Chinese (Simplified)',
				'zh-TW' => 'Chinese (Traditional)',
				'hr' => 'Croatian',
				'cs' => 'Czech',
				'da' => 'Danish',
				'nl' => 'Dutch',
				'en-GB' => 'English (UK)',
				'en' => 'English (US)',
				'et' => 'Estonian',
				'fil' => 'Filipino',
				'fi' => 'Finnish',
				'fr' => 'French',
				'fr-CA' => 'French (Canadian)',
				'gl' => 'Galician',
				
				'ka' => 'Georgian',
				'de' => 'German',
				'de-AT' => 'German (Austria)',
				'de-CH' => 'German (Switzerland)',
				'el' => 'Greek',
				'gu' => 'Gujarati',
				'iw' => 'Hebrew',
				'hi' => 'Hindi',
				'hu' => 'Hungarian',
				'is' => 'Icelandic',
				'id' => 'Indonesian',
				'it' => 'Italian',
				'ja' => 'Japanese',
				'kn' => 'Kannada',
				'ko' => 'Korean',
				'lo' => 'Laothian',
				'lv' => 'Latvian',
				'lt' => 'Lithuanian',
				'ms' => 'Malay',
				'ml' => 'Malayalam',
				'mr' => 'Marathi',
				'mn' => 'Mongolian',
				'no' => 'Norwegian',
				'fa' => 'Persian',
				
				'pl' => 'Polish',
				'pt' => 'Portuguese',
				'pt-BR' => 'Portuguese (Brazil)',
				'pt-PT' => 'Portuguese (Portugal)',
				'ro' => 'Romanian',
				'ru' => 'Russian',
				'sr' => 'Serbian',
				'si' => 'Sinhalese',
				'sk' => 'Slovak',
				'sl' => 'Slovenian',
				'es' => 'Spanish',
				'es-419' => 'Spanish (Latin America)',
				'sw' => 'Swahili',
				'sv' => 'Swedish',
				'ta' => 'Tamil',
				'te' => 'Telugu',
				'th' => 'Thai',
				'tr' => 'Turkish',
				'uk' => 'Ukrainian',
				'ur' => 'Urdu',
				'vi' => 'Vietnamese',
				'zu' => 'Zulu',
				
			);
			
	}


	/* 
	 * Detect language module
	 */
	
	#########################################################
	# Copyright © 2008 Darrin Yeager                        #
	# https://www.dyeager.org/                              #
	# Licensed under BSD license.                           #
	#   https://www.dyeager.org/downloads/license-bsd.txt   #
	#########################################################

	static function getDefaultLanguage() {
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
			return griwpc_tools::parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		else
			return griwpc_tools::parseDefaultLanguage(NULL);
	}
	
	static function parseDefaultLanguage($http_accept, $deflang = "en") {
		if(isset($http_accept) && strlen($http_accept) > 1)  {
			# Split possible languages into array
			$x = explode(",",$http_accept);
			foreach ($x as $val) {
				#check for q-value and create associative array. No q-value means 1 by rule
				if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i",$val,$matches))
					$lang[$matches[1]] = (float)$matches[2];
				else
					$lang[$val] = 1.0;
			}
			
			#return default language (highest q-value)
			$qval = 0.0;
			foreach ($lang as $key => $value) {
				if ($value > $qval) {
					$qval = (float)$value;
					$deflang = $key;
				}
			}
		}
		return strtolower($deflang);  
	}


	/**********************************************************************************************************************
	 *
	 * Activation and update plugin modules 
	 *
	 */
	 
	// Only show link on activation
	static function on_activation() {
		add_option ('cool-griwpc', 'installed' );
	}
	
	// To create the activation message
	static function on_activation_msg () {

		require_once ( __GRIWPC_ABS__ . '/includes/settings.php' );

		$settingsClass = new griwpc_settings();
		
		$a = get_option ('cool-griwpc');
		
		if ( $a ) {  
		
			// First installation
			delete_option ('cool-griwpc');
			add_option ('cool-griwpc-ver', __GRIWPC_VER__ );
			
			if ( ! $settingsClass->get_options() ) {
				$settingsClass->create_options();
			}

			echo '<div class="updated">';
			echo '<p>' . sprintf (
				_x( '<strong>%1$s</strong> %2$s <strong>%3$s</strong> %4$s.', '1: plugin name, 2: `version` word, 3: version number, 4: activation message', 'recaptcha-in-wp-comments-form' ),
				__GRIWPC__,
				_x( 'version', 'version word', 'recaptcha-in-wp-comments-form' ),
				__GRIWPC_VER__,
				_x( 'was succesfully activated', 'activation message', 'recaptcha-in-wp-comments-form' )
			) . '</p>';
			echo '<p>' . sprintf ( 
					_x( '%1$s <a href="%2$s">%3$s</a>.', '1: Go to settings page message, 2: Settings page WP admin URL, 3: Menu name of plugin', 'recaptcha-in-wp-comments-form' ),
					_x( 'To modify the plugin settings, go to Settings >', 'Go to settings page message', 'recaptcha-in-wp-comments-form' ),
					admin_url( 'options-general.php?page=google_recaptcha_in_wp_comments_settings'),
					__GRIWPC_SHORT__
			) . '</p>';
			echo '</div>';

		} else {
			
			// Updating
			$a = get_option ('cool-griwpc-ver');
			if ( ( $a == '' ) || version_compare ( __GRIWPC_VER__, $a, '>' ) ) {
				
				update_option ('cool-griwpc-ver', __GRIWPC_VER__ );

				echo '<div class="updated">';
				echo '<p>' . sprintf ( 
					_x( '<strong>%1$s</strong> %2$s <strong>%3$s</strong>.', '1: plugin name, 2: updating message, 3: plugin version', 'recaptcha-in-wp-comments-form' ),
					__GRIWPC__,
					__('was succesfully updated to the version', 'recaptcha-in-wp-comments-form' ), 
					__GRIWPC_VER__
				) . '</p>';
				
				echo '<p>' . sprintf ( 
					_x( '%1$s <a href="%2$s">%3$s</a>.', '1: Go to settings page message, 2: Settings page WP admin URL, 3: Menu name of plugin', 'recaptcha-in-wp-comments-form' ),
					_x( 'To modify the plugin settings, go to Settings >', 'Go to settings page message', 'recaptcha-in-wp-comments-form' ),
					admin_url( 'options-general.php?page=google_recaptcha_in_wp_comments_settings'),
					__GRIWPC_SHORT__
				) . '</p>';
				echo '</div>';
				
				// Call update settings module in case of...
				griwpc_tools::check_upgrade_settings ( __GRIWPC_VER__, $a, $settingsClass );
				
			}
		
		}
		
	}
	
	static function check_upgrade_settings ( $current, $old, $settingsClass ) {

		require_once ( __GRIWPC_ABS__ . '/includes/settings.php' );

		$settingsClass = new griwpc_settings();
		$options = $settingsClass->get_options();

		// current > 0.0.8.1 
		if ( version_compare ( $current, '0.0.8.1', '>' ) ) {
			
			if ( ! isset ( $options['allowCreditMode'] ) ) {
				$options['allowCreditMode'] = 0;
			}
			
		}

		if ( version_compare ( $current, '0.0.8.2', '>' ) ) {
			if ( ! isset ( $options['recaptcha_align'] ) ) {
				$options['recaptcha_align'] = is_rtl() ? 'right' : 'left';
			}
		}
		
		$settingsClass->update_options( $options );

	}

}