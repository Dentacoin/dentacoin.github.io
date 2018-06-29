<?php
/**
 * Customizer functionality for the Contact section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Contact section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.31
 */
function hestia_contact_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	if ( class_exists( 'Hestia_Hiding_Section' ) ) {
		$wp_customize->add_section(
			new Hestia_Hiding_Section(
				$wp_customize, 'hestia_contact', array(
					'title'          => esc_html__( 'Contact', 'hestia' ),
					'panel'          => 'hestia_frontpage_sections',
					'priority'       => apply_filters( 'hestia_section_priority', 65, 'hestia_contact' ),
					'hiding_control' => 'hestia_contact_hide',
				)
			)
		);
	} else {
		$wp_customize->add_section(
			'hestia_contact', array(
				'title'    => esc_html__( 'Contact', 'hestia' ),
				'panel'    => 'hestia_frontpage_sections',
				'priority' => apply_filters( 'hestia_section_priority', 65, 'hestia_contact' ),
			)
		);
	}

	$wp_customize->add_setting(
		'hestia_contact_hide', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'default'           => false,
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_contact_hide', array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Disable section', 'hestia' ),
			'section'  => 'hestia_contact',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'hestia_contact_background', array(
			'default'           => apply_filters( 'hestia_contact_background_default', get_template_directory_uri() . '/assets/img/contact.jpg' ),
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'hestia_contact_background', array(
				'label'    => esc_html__( 'Background Image', 'hestia' ),
				'section'  => 'hestia_contact',
				'priority' => 5,
			)
		)
	);

	$wp_customize->add_setting(
		'hestia_contact_title', array(
			'default'           => esc_html__( 'Get in Touch', 'hestia' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_contact_title', array(
			'label'    => esc_html__( 'Section Title', 'hestia' ),
			'section'  => 'hestia_contact',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'hestia_contact_subtitle', array(
			'default'           => esc_html__( 'Change this subtitle in the Customizer', 'hestia' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_contact_subtitle', array(
			'label'    => esc_html__( 'Section Subtitle', 'hestia' ),
			'section'  => 'hestia_contact',
			'priority' => 15,
		)
	);

	$wp_customize->add_setting(
		'hestia_contact_area_title', array(
			'default'           => esc_html__( 'Contact Us', 'hestia' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh,
		)
	);

	$wp_customize->add_control(
		'hestia_contact_area_title', array(
			'label'    => esc_html__( 'Form Title', 'hestia' ),
			'section'  => 'hestia_contact',
			'priority' => 20,
		)
	);

	if ( class_exists( 'Hestia_Contact_Info' ) ) {
		$wp_customize->add_setting(
			'hestia_contact_info', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Contact_Info(
				$wp_customize, 'hestia_contact_info', array(
					'label'      => esc_html__( 'Instructions', 'hestia' ),
					'section'    => 'hestia_contact',
					'capability' => 'install_plugins',
					'priority'   => 25,
				)
			)
		);
	}

	if ( class_exists( 'Hestia_Page_Editor' ) ) {
		$contact_content_default = hestia_contact_get_old_content( 'hestia_contact_content' );

		if ( empty( $contact_content_default ) ) {
			$contact_content_default = hestia_contact_content_default();
		}

		$wp_customize->add_setting(
			'hestia_contact_content_new', array(
				'default'           => wp_kses_post( $contact_content_default ),
				'sanitize_callback' => 'wp_kses_post',
				'transport'         => $selective_refresh,
			)
		);

		$wp_customize->add_control(
			new Hestia_Page_Editor(
				$wp_customize, 'hestia_contact_content_new', array(
					'label'                      => esc_html__( 'Contact Content', 'hestia' ),
					'section'                    => 'hestia_contact',
					'priority'                   => 30,
					'include_admin_print_footer' => true,
				)
			)
		);
	}

}

add_action( 'customize_register', 'hestia_contact_customize_register' );

/**
 * Add selective refresh for contact section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_contact_partials( $wp_customize ) {

	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_hide', array(
			'selector'            => '.contactus:not(.is-shortcode)',
			'render_callback'     => 'hestia_contact',
			'container_inclusive' => true,
			'fallback_refresh'    => false,
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_title', array(
			'selector'        => '.contactus h2.hestia-title',
			'settings'        => 'hestia_contact_title',
			'render_callback' => 'hestia_contact_title_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_subtitle', array(
			'selector'        => '.contactus .col-md-5 > h5.description',
			'settings'        => 'hestia_contact_subtitle',
			'render_callback' => 'hestia_contact_subtitle_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_area_title', array(
			'selector'        => '.contactus .card-contact .card-title',
			'settings'        => 'hestia_contact_area_title',
			'render_callback' => 'hestia_contact_area_title_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_content_new', array(
			'selector'        => '.contactus .col-md-5 > div.hestia-description',
			'settings'        => 'hestia_contact_content_new',
			'render_callback' => 'hestia_contact_content_new_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_background', array(
			'selector'        => '.contact-image',
			'settings'        => 'hestia_contact_background',
			'render_callback' => 'hestia_contact_image_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'hestia_contact_info', array(
			'selector' => '.contactus div.pirate-forms-placeholder h4.placeholder-text',
			'settings' => 'hestia_contact_info',
		)
	);
}
add_action( 'customize_register', 'hestia_register_contact_partials' );

/**
 * Render callback function for contact section title selective refresh
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_contact_title_callback() {
	return get_theme_mod( 'hestia_contact_title' );
}

/**
 * Render callback function for contact section subtitle selective refresh
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_contact_subtitle_callback() {
	return get_theme_mod( 'hestia_contact_subtitle' );
}

/**
 * Render callback function for contact section contact area title selective refresh
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_contact_area_title_callback() {
	return get_theme_mod( 'hestia_contact_area_title' );
}

/**
 * Render callback function for contact section content selective refresh
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_contact_content_new_callback() {
	return get_theme_mod( 'hestia_contact_content_new' );
}

/**
 * Render callback for contact image selective refresh.
 *
 * @since   1.1.30
 * @access public
 */
function hestia_contact_image_callback() {
	$hestia_contact_background = get_theme_mod( 'hestia_contact_background' );
	if ( ! empty( $hestia_contact_background ) ) { ?>
		<style class="contact-image-css">
			#contact {
				background-image: url(<?php echo esc_url( $hestia_contact_background ); ?>) !important;
			}
		</style>
		<?php
	}
}

/**
 * Render the contact form placeholder for the contact section.
 *
 * @since 1.1.31
 * @access public
 */
function hestia_contact_form_placeholder() {
	echo '
<div class="col-md-5 col-md-offset-2 pirate-forms-placeholder">
    <div class="card card-contact">
        <div class="header header-raised header-primary text-center">
            <h4 class="hestia-title">' . esc_html__( 'Contact', 'hestia' ) . '</h4>
        </div>
        <div class="pirate-forms-placeholder-overlay">
        	<div class="pirate-forms-placeholder-align">
            	<h4 class="placeholder-text"> ' . esc_html__( 'In order to add a contact form to this section, you need to install the Pirate Forms plugin.', 'hestia' ) . ' </h4>
            </div>
		</div>
        <div class="content">
        	
	        <div class="pirate_forms_wrap">
	            <form class="pirate_forms ">
	                <div class="pirate_forms_three_inputs_wrap">
	                    <div class="col-sm-4 col-lg-4 form_field_wrap contact_name_wrap pirate_forms_three_inputs  ">
	                        <label for="pirate-forms-contact-name"></label>
					        <input id="pirate-forms-contact-name" class="form-control" type="text" value="" placeholder="Your Name">
                        </div>
                        <div class="col-sm-4 col-lg-4 form_field_wrap contact_email_wrap pirate_forms_three_inputs">
                            <label for="pirate-forms-contact-email"></label>
                            <input id="pirate-forms-contact-email" class="form-control" type="email" value="" placeholder="Your Email">
					    </div>
					    <div class="col-sm-4 col-lg-4 form_field_wrap contact_subject_wrap pirate_forms_three_inputs">
					        <label for="pirate-forms-contact-subject"></label>
					        <input id="pirate-forms-contact-subject" class="form-control" type="text" value="" placeholder="Subject">
                        </div>
                    </div>
                </form>
                <div class="col-sm-12 col-lg-12 form_field_wrap contact_message_wrap">
    					<textarea id="pirate-forms-contact-message" required="" class="form-control" placeholder="Your message"></textarea>
                    </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 form_field_wrap contact_submit_wrap">
					    <button id="pirate-forms-contact-submit" class="pirate-forms-submit-button" type="submit">Send Message</button>
                    </div>
                <div class="pirate_forms_clearfix"></div>
            </div>
        </div>
    </div>
</div>';
}

/**
 * Render the contact content default.
 *
 * @since 1.1.31
 * @return string
 */
function hestia_contact_content_default() {
	$html = '<div class="hestia-info info info-horizontal">
			<div class="icon icon-primary">
				<i class="fa fa-map-marker"></i>
			</div>
			<div class="description">
				<h4 class="info-title"> Find us at the office </h4>
				<p>Bld Mihail Kogalniceanu, nr. 8,7652 Bucharest, Romania</p>
			</div>
		</div>
		<div class="hestia-info info info-horizontal">
			<div class="icon icon-primary">
				<i class="fa fa-mobile"></i>
			</div>
			<div class="description">
				<h4 class="info-title">Give us a ring</h4>
				<p>Michael Jordan <br> +40 762 321 762<br>Mon - Fri, 8:00-22:00</p>
			</div>
		</div>';

	return apply_filters( 'hestia_contact_content_default', $html );
}
