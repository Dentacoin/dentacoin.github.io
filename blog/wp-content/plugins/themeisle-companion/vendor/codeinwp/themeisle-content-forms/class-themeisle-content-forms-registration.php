<?php

namespace ThemeIsle\ContentForms;

use ThemeIsle\ContentForms\ContentFormBase as Base;

/**
 * Class RegistrationForm
 * @package ThemeIsle\ContentForms
 */
class RegistrationForm extends Base {

	/**
	 * @var RegistrationForm
	 */
	public static $instance = null;

	/**
	 * The Call To Action
	 */
	public function init() {
		$this->set_type( 'registration' );

		$this->notices = array(
			'success' => esc_html__( 'Your message has been sent!', 'themeisle-companion' ),
			'error'   => esc_html__( 'We failed to send your message!', 'themeisle-companion' ),
		);
	}

	/**
	 * Create an abstract array config which should define the form.
	 *
	 * @param $config
	 *
	 * @return array
	 */
	public function make_form_config( $config ) {

		return array(
			'id'    => $this->get_type(),
			'icon'  => 'eicon-align-left',
			'title' => esc_html__( 'User Registration Form', 'themeisle-companion' ),

			'fields' => array(
				'username' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'User Name', 'themeisle-companion' ),
					'default'     => esc_html__( 'User Name', 'themeisle-companion' ),
					'placeholder' => esc_html__( 'User Name', 'themeisle-companion' ),
					'require'     => 'required',
					'validation'  => ''// name a function which should allow only letters and numbers
				),
				'email'    => array(
					'type'        => 'email',
					'label'       => esc_html__( 'Email', 'themeisle-companion' ),
					'default'     => esc_html__( 'Email', 'themeisle-companion' ),
					'placeholder' => esc_html__( 'Email', 'themeisle-companion' ),
					'require'     => 'required'
				),
				'password' => array(
					'type'        => 'password',
					'label'       => esc_html__( 'Password', 'themeisle-companion' ),
					'default'     => esc_html__( 'Password', 'themeisle-companion' ),
					'placeholder' => esc_html__( 'Password', 'themeisle-companion' ),
					'require'     => 'required'
				)
			),

			'controls' => array(
				'submit_label' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Submit', 'themeisle-companion' ),
					'default'     => esc_html__( 'Register', 'themeisle-companion' ),
					'description' => esc_html__( 'The Call To Action label', 'themeisle-companion' )
				)
			)
		);
	}

	/**
	 * This method is passed to the rest controller and it is responsible for submitting the data.
	 * // @TODO we still have to check for the requirement with the field settings
	 *
	 * @param $return array
	 * @param $data array Must contain the following keys: `email`, `name` but it can also have extra keys
	 * @param $widget_id string
	 * @param $post_id string
	 * @param $builder string
	 *
	 * @return mixed
	 */
	public function rest_submit_form( $return, $data, $widget_id, $post_id, $builder ) {

		if ( empty( $data['email'] ) || ! is_email( $data['email'] ) ) {
			$return['msg'] = esc_html__( 'Invalid email.', 'themeisle-companion' );

			return $return;
		}

		$email = sanitize_email( $data['email'] );

		unset( $data['email'] );

		if ( empty( $data['username'] ) ) {
			$username = $email;
		} else {
			$username = sanitize_user( $data['username'] );
		}

		unset( $data['username'] );

		// if there is no password we will auto-generate one
		$password = null;

		if ( ! empty( $data['password'] ) ) {
			$password = $data['password'];
			unset( $data['password'] );
		}

		$return = $this->_register_user( $return, $email, $username, $password, $data );

		return $return;
	}

	/**
	 * Add a new user for the given details
	 *
	 * @param array $return
	 * @param string $user_email
	 * @param string $user_name
	 * @param null $password
	 * @param array $extra_data
	 *
	 * @return array mixed
	 */
	private function _register_user( $return, $user_email, $user_name, $password = null, $extra_data = array() ) {

		if ( ! get_option( 'users_can_register' ) ) {
			$return['msg'] = esc_html__( 'This website does not allow registrations at this moment!', 'themeisle-companion' );

			return $return;
		}

		if ( ! validate_username( $user_name ) ) {
			$return['msg'] = esc_html__( 'Invalid user name', 'themeisle-companion' );

			return $return;
		}

		if ( username_exists( $user_name ) ) {
			$return['msg'] = esc_html__( 'Username already exists', 'themeisle-companion' );

			return $return;
		}

		if ( email_exists( $user_email ) ) {
			$return['msg'] = esc_html__( 'This email is already registered', 'themeisle-companion' );
			return $return;
		}

		// no pass? ok
		if ( empty( $password ) ) {
			$password = wp_generate_password(
				$length = 12,
				$include_standard_special_chars = false
			);
		}

		$userdata = array(
			'user_login' => $user_name,
			'user_email' => $user_email,
			'user_pass'  => $password
		);

		$user_id = wp_insert_user( $userdata );

		if ( ! is_wp_error( $user_id ) ) {

			if ( ! empty( $extra_data ) ) {
				foreach ( $extra_data as $key => $value ) {
					update_user_meta( $user_id, sanitize_title( $key ), sanitize_text_field( $value ) );
				}
			}

			$return['success'] = true;
			$return['msg']     = esc_html__( 'Welcome, ', 'themeisle-companion' ) . $user_name;
		}

		return $return;
	}


	/**
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return RegistrationForm
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'themeisle-companion' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'themeisle-companion' ), '1.0.0' );
	}
}