<?php
/*
 * Plugin:      reCAPTCHA in WP comments form
 * Path:        /includes
 * File:        recaptcha.php
 * Since:       0.0.9
 */
 
/*
 * Class:       griwpc_recaptcha
 * Version:     9.0.3
 * Description: This class shows and controls the reCAPTCHA field in WP comments form 
 */

// Back-End Interface Class 
class griwpc_recaptcha extends griwpc_interface {
	
	public function  __construct ( $version, $settingsClass ) {
		parent::__construct ( $version, $settingsClass );
		$this->enqueue_admin_scripts_and_styles();
	}

	// Actions for enqueueing Scripts and Styles
	public function enqueue_admin_scripts_and_styles () {

		if ( is_admin() ) {
			
			add_action ( 'admin_enqueue_scripts', array ( $this, 'register_scripts' ) );
			add_action ( 'admin_enqueue_scripts', array ( $this, 'register_styles' ) );
			
		} else {

			// Constructing just when the plugin is active
			if ( TRUE === (boolean) $this->options['active'] ) {
				
				// Loading scripts
				add_action ( 'wp_enqueue_scripts',	array ( $this, 'register_scripts' ) );
				// Loading styles
				add_action ( 'wp_enqueue_scripts',	array ( $this, 'register_styles' ) );

			}
			
		}
		
		
	}

	public function register_styles () {
		
		wp_register_style ( 'griwpc-recaptcha-style', __GRIWPC_URL__ . 'css/recaptcha.css', array(), $this->version, 'all' );
		// Loading possible styles
		if ( trim( $this->options['recaptcha_css'] ) != '' )
			wp_add_inline_style ( 'griwpc-recaptcha-style', $this->options['recaptcha_css'] );
		wp_enqueue_style ( 'griwpc-recaptcha-style' );

	}




	// Loading Back-End Scripts and Styles
	public function register_scripts () {

		$translation_array = array(
			'ajax_url' 			=> get_bloginfo('url' ),								   
			'formID'			=> ( isset ( $this->options['formID'] )  		 ? $this->options['formID']  			: 'commentform' ),
			'buttonID'			=> ( isset ( $this->options['buttonID'] ) 		 ? $this->options['buttonID']  			: 'submit'  ),
			'recaptcha_elem'    => NULL,
			'recaptcha_id'		=> 'griwpc-widget-id',
			'recaptcha_skey'	=> ( isset ( $this->options['site_key'] ) 		 ? $this->options['site_key']  			: '' 		),
			'recaptcha_theme'	=> ( isset ( $this->options['recaptcha_theme'] ) ? $this->options['recaptcha_theme']	: 'light' 	),
			'recaptcha_size'	=> ( isset ( $this->options['recaptcha_size'] )  ? $this->options['recaptcha_size']		: 'normal'	),
			'recaptcha_type'	=> ( isset ( $this->options['recaptcha_type'] )  ? $this->options['recaptcha_type']		: 'image'	),
			'recaptcha_align'	=> ( isset ( $this->options['recaptcha_align'] ) ? $this->options['recaptcha_align']	: 'left'	),
			'recaptcha_otcm'	=> ( isset ( $this->options['old_themes_compatibility'] )  ? $this->options['old_themes_compatibility']	: '-1'	),
			'recaptcha_tag'		=> ( isset ( $this->options['recaptcha_tag'] )	 ? $this->options['recaptcha_tag']		: 'p' ),
			'recaptcha_lang'	=> '',		
			'allowCreditMode'	=> $this->options['allowCreditMode'],
			'home_link_address' => __GRIWPC_SITE__,
			'home_link_title'   => __( 'reCAPTCHA plugin homepage', 'recaptcha-in-wp-comments-form' ),
			'home_link_text'    => __( 'Get reCAPTCHA plugin', 'recaptcha-in-wp-comments-form' ),
		);

		// Comments form sample has always got the default ID's attributes
		if ( is_admin() ) {
			$translation_array[ 'formID'   ] = 'commentform';
			$translation_array[ 'buttonID' ] = 'submit';
			$translation_array[ 'allowCreditMode' ] = 1;
			$translation_array[ 'realAllowCreditMode' ] = $this->options['allowCreditMode'];
		}

		// Forcing language detection
		if ( -1 == (int) $this->options['recaptcha_lang'] ) {
			// Autdetected user browser language
//			$translation_array['language'] = griwpc_tools::adapt_language_code ( griwpc_tools::getDefaultLanguage() );
			$lang = $translation_array[ 'recaptcha_lang' ] = '';
		} elseif ( -2 == (int) $this->options['recaptcha_lang'] ) {
			// Site language
			$lang = $translation_array[ 'recaptcha_lang' ] = '&hl=' . griwpc_tools::adapt_language_code ( get_locale() ); 
		} else {
			// Forced language
			$lang = $translation_array[ 'recaptcha_lang' ] = '&hl=' . $this->options['recaptcha_lang'];
		}

		$dependencies = array ( 'jquery-core' );
		// When output mode is via javascript
		if ( (int) $this->options['old_themes_compatibility'] == 1 ) {
			wp_register_script ( 'google-recaptcha-compat-ini', __GRIWPC_URL__ . 'js/compatibility.js', $dependencies, $this->version, TRUE );								
			wp_enqueue_script  ( 'google-recaptcha-compat-ini' );
			wp_localize_script ( 'google-recaptcha-compat-ini', 'griwpco', $translation_array );
			$dependencies[] = 'google-recaptcha-compat-ini';
		}

		// reCAPTCHA plugin script
		wp_register_script ( 'google-recaptcha-ini', __GRIWPC_URL__ . 'js/recaptcha.js', $dependencies, $this->version, TRUE  );
		if ( (int) $this->options['old_themes_compatibility'] == 0 ) 
			wp_localize_script ( 'google-recaptcha-ini', 'griwpco', $translation_array );
		wp_enqueue_script  ( 'google-recaptcha-ini' );
		$dependencies[] = 'google-recaptcha-ini';
	
		// reCAPTCHA Google script
		wp_register_script ( 'recaptcha-call', __GRIWPC_RECAPTCHA_SHOW__ . 'onload=griwpcOnloadCallback&render=explicit' . $lang , $dependencies, '' , TRUE );
		wp_enqueue_script  ( 'recaptcha-call' );

	}

	// Creating the reCAPTCHA field for a non Explicit render
	public function render_HTML ( $tag, $options ) {

		$out  = '<' . $tag . ' id="griwpc-container-id" class="google-recaptcha-container recaptcha-align-' . $options[ 'recaptcha_align' ] . '">';
		$out .= '<span ' .
					'id="'			. 'griwpc-widget-id'	. '" ' .
					'class="'		. 'g-recaptcha'		 	. '" ' .
					'data-forced="' . 0             		. '" ' . 
					'>';
		$out .= '</span>';
		$out .= '</' . $tag . '>';

		return $out;
		
	}
	

	// reCAPTCHA Verification function
	static function griwpc_verify_reCAPTCHA () {
	
		require( __GRIWPC_ABS__ . '/recaptcha/src/autoload.php');
		
		if ( !isset ( $_POST['resp'] ) )
			die( json_encode ( array ( 'success' => FALSE ) ) );
			
		$params		= get_option ( 'griwpc-params' );
		$secret		= trim ( $params['secret_key']  );
		$reCaptcha  = new \ReCaptcha\ReCaptcha($secret);
		$response   = $reCaptcha->verify( $_POST['resp'], $_SERVER['REMOTE_ADDR'] );
	
		if ( $response->isSuccess() ) {
			$data = array ( 'success' => TRUE, 'data' => array( 'result' => 'OK', 'address' => $_SERVER['REMOTE_ADDR'] ) );
		} else {
			$data = array ( 'success' => TRUE, 'data' => $response->getErrorCodes() );
		}
		
		die ( json_encode ( $data ) );
	
	}

	// Send to Trash option
	static function to_trash ( $approved, $data ) {
		return 'trash';
	}
	
	// Mark as Spam
	static function to_spam ( $approved, $data ) {
		return 'spam';
	}

	// Second verification process, just in case of someone breaks reCAPTCHA manually
	static function after_griwpc_verify_reCAPTCHA ( $comment_post_ID ) {
		
		$user = wp_get_current_user();
		if ( $user->exists() ) return;
		
		require( __GRIWPC_ABS__ . '/recaptcha/src/autoload.php');
		
		$error 		= FALSE;	
		$options 	= get_option ( 'griwpc-params' );
		$pm 	 	= trim( $options['recaptcha_mode'] );
		$secret		= trim( $options['secret_key']  );
		
		if ( ! isset( $_POST['g-recaptcha-response'] ) ) {
			$error = TRUE;
		} else {
			if ( empty ( $_POST['g-recaptcha-response'] ) ) 
				$error = TRUE;
		}
		
		if ( ! isset( $_POST['griwpcva'] ) ) 
			$error = TRUE;

		// We rechecked captcha for possible robots g-recaptcha-response inputs
		if ( $error === FALSE ) {

			$reCaptcha  = new \ReCaptcha\ReCaptcha($secret);
			$response   = $reCaptcha->verify( $_POST['g-recaptcha-response'], $_POST['griwpcva'] );
			$LastTest   = $response->getErrorCodes();

			// we know that we'll obtain an error but the "correct" error
			if ( $LastTest[0] !== 'timeout-or-duplicate' )
				$error = TRUE;
				
		}

		if ( $error === TRUE ) {

			// reCAPTCHA Breaking options
			switch ( $pm ) {
				case 'die' :
					// go to a WP_DIE() page
					wp_die( __( '<p>Sorry, it seems you\'re a robot.</p>' , 'recaptcha-in-wp-comments-form' ), '', array( 'response' => 403, 'back_link' => false ) ); 
					break;
				case 'spam' :
					// Mark the comment as SPAM
					add_filter ( 'pre_comment_approved', array ( 'griwpc_recaptcha', 'to_spam'  ) , PHP_INT_MAX - 200, 2 ); 
					break;
				case 'trash' :
					// Send comment to Trash
					add_filter ( 'pre_comment_approved', array ( 'griwpc_recaptcha', 'to_trash' ) , PHP_INT_MAX - 200, 2 ); 
					break; 
				case 'delete' :
					if ( isset( $_POST ) ) 
						unset ( $_POST );
					$location = get_bloginfo ( 'url' );
					wp_safe_redirect( $location );
					exit;
			}
			
		}
			
	}

}