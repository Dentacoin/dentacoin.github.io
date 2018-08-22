<?php
/**
 * Contact section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_contact' ) ) :
	/**
	 * Contact section content.
	 * This function can be called from a shortcode too.
	 * When it's called as shortcode, the title and the subtitle shouldn't appear and it should be visible all the time,
	 * it shouldn't matter if is disable on front page.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.51
	 */
	function hestia_contact( $is_shortcode = false ) {

		// When this function is called from selective refresh, $is_shortcode gets the value of WP_Customize_Selective_Refresh object. We don't need that.
		if ( ! is_bool( $is_shortcode ) ) {
			$is_shortcode = false;
		}

		$hide_section = get_theme_mod( 'hestia_contact_hide', false );
		if ( $is_shortcode === false && (bool) $hide_section === true ) {
			if ( is_customize_preview() ) {
				echo '<section class="hestia-contact contactus section-image" id="contact" data-sorder="hestia_contact" style="display: none"></section>';
			}
			return;
		}

		if ( current_user_can( 'edit_theme_options' ) ) {
			/* translators: 1 - link to customizer setting. 2 - 'customizer' */
			$hestia_contact_subtitle = get_theme_mod( 'hestia_contact_subtitle', sprintf( __( 'Change this subtitle in %s.', 'hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_contact_subtitle' ) ), __( 'customizer', 'hestia' ) ) ) );
		} else {
			$hestia_contact_subtitle = get_theme_mod( 'hestia_contact_subtitle' );
		}
		$hestia_contact_title      = get_theme_mod( 'hestia_contact_title', esc_html__( 'Get in Touch', 'hestia' ) );
		$hestia_contact_area_title = get_theme_mod( 'hestia_contact_area_title', esc_html__( 'Contact Us', 'hestia' ) );

		hestia_before_contact_section_trigger();

		$wrapper_class = $is_shortcode === true ? 'is-shortcode' : '';
		?>
		<section class="hestia-contact contactus section-image <?php echo esc_attr( $wrapper_class ); ?>" id="contact" data-sorder="hestia_contact" style="background-image: url('<?php echo get_theme_mod( 'hestia_contact_background', apply_filters( 'hestia_contact_background_default', get_template_directory_uri() . '/assets/img/contact.jpg' ) ); ?>')">
			<?php
			if ( is_customize_preview() ) {
			?>
				<div class="contact-image"></div>
				<?php
			}

			hestia_before_contact_section_content_trigger();
			?>
			<div class="container">
				<?php hestia_top_contact_section_content_trigger(); ?>
				<div class="row">
					<div class="col-md-5">
						<?php if ( ! empty( $hestia_contact_title ) || is_customize_preview() ) : ?>
							<h2 class="hestia-title"><?php echo wp_kses_post( $hestia_contact_title ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $hestia_contact_subtitle ) || is_customize_preview() ) : ?>
							<h5 class="description"><?php echo hestia_sanitize_string( $hestia_contact_subtitle ); ?></h5>
						<?php endif; ?>
						<?php

						/**
						 * Get the default value for the Contact Content option
						 * This first tries to get the old value ( we made some changes at some point ) and if that if empty, get the new default value
						 */
						$contact_content_default = hestia_contact_get_old_content( 'hestia_contact_content' );

						if ( empty( $contact_content_default ) && current_user_can( 'edit_theme_options' ) ) {
							$contact_content_default = hestia_contact_content_default();
						}

						$hestia_contact_content = get_theme_mod( 'hestia_contact_content_new', wp_kses_post( $contact_content_default ) );
						if ( ! empty( $hestia_contact_content ) ) {
							echo '<div class="hestia-description">';
								echo wp_kses_post( $hestia_contact_content );
							echo '</div>';
						}

						?>
					</div>
					<?php
					$hestia_contact_form_shortcode_default = '[pirate_forms]';
					$hestia_contact_form_shortcode         = get_theme_mod( 'hestia_contact_form_shortcode', $hestia_contact_form_shortcode_default );
					if ( defined( 'PIRATE_FORMS_VERSION' ) || ( $hestia_contact_form_shortcode != $hestia_contact_form_shortcode_default ) ) {
						?>
							<div class="col-md-5 col-md-offset-2">
								<div class="card card-contact">
									<?php if ( ! empty( $hestia_contact_area_title ) || is_customize_preview() ) : ?>
										<div class="header header-raised header-primary text-center">
											<h4 class="card-title"><?php echo esc_html( $hestia_contact_area_title ); ?></h4>
										</div>
									<?php endif; ?>
									<div class="content">
										<?php
										if ( function_exists( 'hestia_contact_form_callback' ) ) {
											hestia_contact_form_callback();
										} else {
											echo do_shortcode( '[pirate_forms]' );
										}
										?>
									</div>
								</div>
							</div>
						<?php

					} elseif ( is_customize_preview() ) {
						hestia_contact_form_placeholder();
					}
?>
				</div>
				<?php hestia_bottom_contact_section_content_trigger(); ?>
			</div>
			<?php hestia_after_contact_section_content_trigger(); ?>
		</section>
		<?php
		hestia_after_contact_section_trigger();
	}
endif;


if ( function_exists( 'hestia_contact' ) ) {
	$section_priority = apply_filters( 'hestia_section_priority', 65, 'hestia_contact' );
	add_action( 'hestia_sections', 'hestia_contact', absint( $section_priority ) );
}
