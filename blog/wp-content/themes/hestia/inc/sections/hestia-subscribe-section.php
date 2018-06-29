<?php
/**
 * Subscribe section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_subscribe' ) ) :
	/**
	 * Subscribe section content.
	 * This function can be called from a shortcode too.
	 * When it's called as shortcode, the title and the subtitle shouldn't appear and it should be visible all the time,
	 * it shouldn't matter if is disable on front page.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.51
	 */
	function hestia_subscribe( $is_shortcode = false ) {

		// When this function is called from selective refresh, $is_shortcode gets the value of WP_Customize_Selective_Refresh object. We don't need that.
		if ( ! is_bool( $is_shortcode ) ) {
			$is_shortcode = false;
		}

		$hide_section = get_theme_mod( 'hestia_subscribe_hide', true );
		if ( $is_shortcode === false && (bool) $hide_section === true ) {
			if ( is_customize_preview() ) {
				echo '<section class="hestia-subscribe subscribe-line subscribe-line-image" id="subscribe" data-sorder="hestia_subscribe" style="display: none"></section>';
			}
			return;
		}

		if ( current_user_can( 'edit_theme_options' ) ) {
			/* translators: 1 - link to customizer setting. 2 - 'customizer' */
			$hestia_subscribe_subtitle = get_theme_mod( 'hestia_subscribe_subtitle', sprintf( __( 'Change this subtitle in %s.', 'hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_subscribe_subtitle' ) ), __( 'customizer', 'hestia' ) ) ) );
		} else {
			$hestia_subscribe_subtitle = get_theme_mod( 'hestia_subscribe_subtitle' );
		}

		$hestia_subscribe_title = get_theme_mod( 'hestia_subscribe_title', __( 'Subscribe to our Newsletter', 'hestia' ) );

		$wrapper_class = $is_shortcode === true ? 'is-shortcode' : '';

		hestia_before_subscribe_section_trigger();
			?>
		<section class="hestia-subscribe subscribe-line subscribe-line-image <?php echo esc_attr( $wrapper_class ); ?>" id="subscribe" data-sorder="hestia_subscribe" style="background-image: url('<?php echo get_theme_mod( 'hestia_subscribe_background', get_template_directory_uri() . '/assets/img/about.jpg' ); ?>');">
			<?php
			if ( is_customize_preview() ) {
			?>
				<div class="hestia-subscribe-image"></div>
				<?php
			}
			?>
			<?php hestia_before_subscribe_section_content_trigger(); ?>
			<div class="container">
				<?php hestia_top_subscribe_section_content_trigger(); ?>
				<div class="row text-center">
					<div class="col-md-8 col-md-offset-2 text-center">
					<?php if ( ! empty( $hestia_subscribe_title ) || is_customize_preview() ) : ?>
						<h2 class="title"><?php echo wp_kses_post( $hestia_subscribe_title ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $hestia_subscribe_subtitle ) || is_customize_preview() ) : ?>
						<h5 class="subscribe-description"><?php echo hestia_sanitize_string( $hestia_subscribe_subtitle ); ?></h5>
					<?php endif; ?>
					</div>
				</div>
				<?php if ( is_active_sidebar( 'subscribe-widgets' ) ) : ?>
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="card card-raised card-form-horizontal">
							<div class="content">
								<div class="row">
								<?php dynamic_sidebar( 'subscribe-widgets' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php hestia_bottom_subscribe_section_content_trigger(); ?>
			</div>
			<?php hestia_after_subscribe_section_content_trigger(); ?>
		</section>
		<?php
		hestia_after_subscribe_section_trigger();
	}
endif;

if ( function_exists( 'hestia_subscribe' ) ) {
	$old_priority     = apply_filters( 'hestia_section_priority', 55, 'hestia_subscribe' );
	$section_priority = apply_filters( 'hestia_section_priority', $old_priority, 'sidebar-widgets-subscribe-widgets' );
	add_action( 'hestia_sections', 'hestia_subscribe', absint( $section_priority ) );
}
