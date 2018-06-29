<?php

namespace ThemeIsle\ContentForms;

/**
 * Class RestServer
 *
 */
class RestServer extends \WP_Rest_Controller {

	/**
	 * @var RestServer
	 */
	public static $instance = null;

	public $namespace = 'content-forms/';
	public $version = 'v1';

	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		$namespace = $this->namespace . $this->version;

		register_rest_route( $namespace, '/check', array(
			array(
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => array( $this, 'rest_check' )
			),
		) );

		register_rest_route( $namespace, '/submit', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'submit_form' ),
				'permission_callback' => array( $this, 'submit_forms_permissions_check' ),
				'args'                => array(
					'form_type' => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'What type of form is submitted.', 'themeisle-companion' ),
					),
					'nonce'     => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'The security key', 'themeisle-companion' ),
					),
					'data'      => array(
						'type'        => 'json',
						'required'    => true,
						'description' => __( 'The form must have data', 'themeisle-companion' ),
					),
					'form_id'   => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'The form identifier.', 'themeisle-companion' ),
					),
					'post_id'   => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'The form identifier.', 'themeisle-companion' ),
					)
				),
			),
		) );
	}

	public function rest_check( \WP_REST_Request $request ) {
			return rest_ensure_response( 'success' );
	}

	/**
	 * @param \WP_REST_Request $request
	 *
	 * @return mixed|\WP_REST_Response
	 */
	public function submit_form( $request ) {
		$return = array(
			'success' => false,
			'msg'     => esc_html__( 'Something went wrong', 'themeisle-companion' )
		);

		$nonce   = $request->get_param( 'nonce' );
		$form_id = $request->get_param( 'form_id' );
		$post_id = $request->get_param( 'post_id' );

		if ( ! wp_verify_nonce( $nonce, 'content-form-' . $form_id ) ) {
			$return['msg'] = 'Invalid nonce';
			return rest_ensure_response( $return );
		}

		$form_type    = $request->get_param( 'form_type' );
		$form_builder = $request->get_param( 'form_builder' );
		$data         = $request->get_param( 'data' );

		if ( empty( $data[ $form_id ] ) ) {
			$return['msg'] = esc_html__( 'Invalid Data ', 'themeisle-companion' ) . $form_id;
			return $return;
		}

		$data = $data[ $form_id ];

		/**
		 * Each form type should be able to provide its own process of submitting data.
		 * Must return the success status and a message.
		 */
		$return = apply_filters( 'content_forms_submit_' . $form_type, $return, $data, $form_id, $post_id, $form_builder );

		return rest_ensure_response( $return );
	}

	public function submit_forms_permissions_check() {
		return 1;
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return RestServer
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