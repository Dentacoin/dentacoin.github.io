<?php

namespace ThemeIsle\ContentForms;

class BeaverModuleRegistration extends BeaverModule {

	/**
	 * Define the form type
	 * @return string
	 */
	public function get_type() {
		return 'registration';
	}

	public function __construct( $data = array(), $args = null ) {

		parent::__construct(
			array(
				'name'        => esc_html__( 'Registration', 'themeisle-companion' ),
				'description' => esc_html__( 'A sign up form.', 'themeisle-companion' ),
				'category'    => esc_html__( 'Orbit Fox Modules', 'themeisle-companion' ),
				'dir'         => dirname( __FILE__ ),
				'url'         => plugin_dir_url( __FILE__ )
			)
		);
	}
}