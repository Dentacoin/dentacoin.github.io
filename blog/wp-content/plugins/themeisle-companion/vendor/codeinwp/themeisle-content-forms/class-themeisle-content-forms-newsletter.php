<?php

namespace ThemeIsle\ContentForms;

use ThemeIsle\ContentForms\ContentFormBase as Base;

/**
 * Class NewsletterForm
 * @package ThemeIsle\ContentForms
 */
class NewsletterForm extends Base {

	/**
	 * @var NewsletterForm
	 */
	public static $instance = null;

	/**
	 * The Call To Action
	 */
	public function init() {
		$this->set_type( 'newsletter' );

		$this->notices = array(
			'success' => esc_html__( 'Welcome to our newsletter!', 'themeisle-companion' ),
			'error'   => esc_html__( 'Action failed!', 'themeisle-companion' ),
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
			'id'                           => 'newsletter',
			'icon'                         => 'eicon-align-left',
			'title'                        => esc_html__( 'Newsletter Form', 'themeisle-companion' ),

			'controls' => array(
				'provider'     => array(
					'type'        => 'select',
					'label'       => esc_html__( 'Subscribe to', 'themeisle-companion' ),
					'description' => esc_html__( 'Where to send the email?', 'themeisle-companion' ),
					'options'     => array(
						'mailchimp'  => esc_html__( 'MailChimp', 'themeisle-companion' ),
						'sendinblue' => esc_html__( 'Sendinblue ', 'themeisle-companion' )
					)
				),
				'access_key'   => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Access Key', 'themeisle-companion' ),
					'description' => esc_html__( 'Provide an access key for the selected service', 'themeisle-companion' ),
					'required' => true
				),
				'list_id'      => array(
					'type'  => 'text',
					'label' => esc_html__( 'List ID', 'themeisle-companion' ),
					'description' => esc_html__( 'The List ID (based on the seleced service) where we should subscribe the user', 'themeisle-companion' ),
					'required' => true
				),
				'submit_label' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Submit Label', 'themeisle-companion' ),
					'default' => esc_html__( 'Join Newsletter', 'themeisle-companion' ),
				)
			),

			'fields' => array(
				'email' => array(
					'type'        => 'email',
					'label'       => esc_html__( 'Email', 'themeisle-companion' ),
					'default'     => esc_html__( 'Email', 'themeisle-companion' ),
					'placeholder' => esc_html__( 'Email', 'themeisle-companion' ),
					'require'     => 'required'
				)
			),

		);
	}

	/**
	 * This method is passed to the rest controller and it is responsible for submitting the data.
	 *
	 * @param $return array
	 * @param $data array Must contain the following keys: `email` but it can also have extra keys
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

		$email = $data['email'];

		// prepare settings for submit
		$settings = $this->get_widget_settings( $widget_id, $post_id, $builder );

		$provider = 'mailchimp';

		if ( ! empty( $settings['provider'] ) ) {
			$provider = $settings['provider'];
		}

		$providerArgs = array();

		if ( empty( $settings['access_key'] ) || empty( $settings['list_id'] ) ) {
			$return['msg'] = esc_html__( 'Wrong email configuration! Please contact administration!', 'themeisle-companion' );

			return $return;
		}

		$providerArgs['access_key'] = $settings['access_key'];
		$providerArgs['list_id']    = $settings['list_id'];

		$return = $this->_subscribe_mail( $return, $email, $provider, $providerArgs );

		return $return;
	}

	/**
	 * Subscribe the given email to the given provider; either mailchimp or sendinblue.
	 *
	 * @param $result
	 * @param $email
	 * @param string $provider
	 * @param array $provider_args
	 *
	 * @return bool|array
	 */
	private function _subscribe_mail( $result, $email, $provider = 'mailchimp', $provider_args = array() ) {

		$api_key = $provider_args['access_key'];
		$list_id = $provider_args['list_id'];

		switch ( $provider ) {

			case 'mailchimp':
				// add a pending subscription for the user to confirm
				$status = 'pending';

				$args = array(
					'method'  => 'PUT',
					'headers' => array(
						'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key )
					),
					'body'    => json_encode( array(
						'email_address' => $email,
						'status'        => $status
					) )
				);

				$url = 'https://' . substr( $api_key, strpos( $api_key, '-' ) + 1 ) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5( strtolower( $email ) );

				$response = wp_remote_post( $url, $args );

				if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
					return $response;
				}

				$body = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( $body->status == $status ) {
					$result['success'] = true;
					$result['msg']     = $this->notices['success'];
				} else {
					$result['success'] = false;
					$result['msg']    = $this->notices['error'];
				}

				return $result;
				break;
			case 'sendinblue':

				$url = 'https://api.sendinblue.com/v3/contacts';

				$args = array(
					'method'  => 'POST',
					'headers' => array(
						'content-type' => 'application/json',
						'api-key'      => $api_key
					),
					'body'    => json_encode( array(
						'email'            => $email,
						'listIds'          => array( (int) $list_id ),
						'emailBlacklisted' => false,
						'smsBlacklisted'   => false,
					) )
				);

				$response = wp_remote_post( $url, $args );

				if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {

					$body = json_decode( wp_remote_retrieve_body( $response ), true );

					if ( ! empty( $body['message'] ) ) {
						$result['msg'] = $body['message'];
					} else {
						$result['msg'] = $response;
					}

					return $result;
				}

				$result['success'] = true;
				$result['msg']     = $this->notices['success'];

				return $result;
				break;

			default;
				break;
		}

		return false;
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return NewsletterForm
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