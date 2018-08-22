<?php
/**
 * Big Title section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_big_title' ) ) :
	/**
	 * Big title section content.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_big_title() {
		hestia_before_big_title_section_trigger();
	?>
		<div id="carousel-hestia-generic" class="carousel slide" data-ride="carousel">
			<div class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<?php

					$section_content = hestia_get_big_title_content();

					$hestia_big_title_background = get_theme_mod( 'hestia_big_title_background', apply_filters( 'hestia_big_title_background_default', get_template_directory_uri() . '/assets/img/slider2.jpg' ) );

					if ( ! empty( $hestia_big_title_background ) || ! empty( $section_content ) ) {
					?>
						<div class="item active">
							<div class="page-header">
								<?php
								if ( is_customize_preview() ) {
								?>
									<div class="big-title-image"></div>
									<?php
								}
								hestia_before_big_title_section_content_trigger();
								?>
								<div class="container">
									<?php hestia_top_big_title_section_content_trigger(); ?>
									<div class="row hestia-big-title-content">
										<?php hestia_show_big_title_content( $section_content ); ?>
									</div>
									<?php hestia_bottom_big_title_section_content_trigger(); ?>
								</div>
								<div class="header-filter" 
								<?php
								if ( ! empty( $hestia_big_title_background ) ) {
									echo 'style="background-image: url(' . esc_url( $hestia_big_title_background ) . ')"';}
?>
></div>
								<?php hestia_after_big_title_section_content_trigger(); ?>
							</div>
						</div>
						<?php
					}// End if().
					?>
					</div>
				</div>
			</div>
			<?php hestia_after_big_title_section_trigger(); ?>
		</div>
		<?php
	}
endif;

/**
 * Display big title section content.
 *
 * @param array $content Section settings.
 * @since 1.1.41
 */
function hestia_show_big_title_content( $content ) {
?>
	<div class="col-md-8 col-md-offset-2 
	<?php
	if ( ! empty( $content['class_to_add'] ) ) {
		echo esc_attr( $content['class_to_add'] ); }
?>
">
		<?php if ( ! empty( $content['title'] ) ) { ?>
			<h1 class="hestia-title"><?php echo wp_kses_post( $content['title'] ); ?></h1>
		<?php } ?>
		<?php if ( ! empty( $content['text'] ) ) { ?>
			<span class="sub-title"><?php echo wp_kses_post( $content['text'] ); ?></span>
		<?php } ?>
		<?php if ( ! empty( $content['button_link'] ) && ! empty( $content['button_text'] ) ) { ?>
			<div class="buttons">
				<a href="<?php echo esc_url( $content['button_link'] ); ?>" title="<?php echo esc_html( $content['button_text'] ); ?>" class="btn btn-primary btn-lg" <?php echo hestia_is_external_url( $content['button_link'] ); ?>><?php echo esc_html( $content['button_text'] ); ?></a>
				<?php hestia_big_title_section_buttons_trigger(); ?>
			</div>
		<?php } ?>
	</div>
	<?php
}

/**
 * Get Big Title section content.
 *
 * @since 1.1.41
 */
function hestia_get_big_title_content() {
	$section_content = array();

	$hestia_slider_alignment = get_theme_mod( 'hestia_slider_alignment', 'center' );
	$class_to_add            = ( ! empty( $hestia_slider_alignment ) ? 'text-' . $hestia_slider_alignment : 'text-center' );
	if ( ! empty( $class_to_add ) ) {
		$section_content['class_to_add'] = $class_to_add;
	}

	/* translators: 1 - link to customizer setting. 2 - 'customizer' */
	$title_default          = current_user_can( 'edit_theme_options' ) ? sprintf( esc_html__( 'Change in the %s', 'hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_big_title_title' ) ), __( 'Customizer', 'hestia' ) ) ) : false;
	$hestia_big_title_title = get_theme_mod( 'hestia_big_title_title', $title_default );
	if ( ! empty( $hestia_big_title_title ) ) {
		$section_content['title'] = $hestia_big_title_title;
	}

	/* translators: 1 - link to customizer setting. 2 - 'customizer' */
	$text_default          = current_user_can( 'edit_theme_options' ) ? sprintf( esc_html__( 'Change in the %s', 'hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_big_title_text' ) ), __( 'Customizer', 'hestia' ) ) ) : false;
	$hestia_big_title_text = get_theme_mod( 'hestia_big_title_text', $text_default );
	if ( ! empty( $hestia_big_title_text ) ) {
		$section_content['text'] = $hestia_big_title_text;
	}

	$button_text_default          = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Change in the Customizer', 'hestia' ) : false;
	$hestia_big_title_button_text = get_theme_mod( 'hestia_big_title_button_text', $button_text_default );
	if ( ! empty( $hestia_big_title_button_text ) ) {
		$section_content['button_text'] = $hestia_big_title_button_text;
	}

	$button_link_default          = current_user_can( 'edit_theme_options' ) ? esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_big_title_button_text' ) ) : false;
	$hestia_big_title_button_link = get_theme_mod( 'hestia_big_title_button_link', $button_link_default );
	if ( ! empty( $hestia_big_title_button_link ) ) {
		$section_content['button_link'] = $hestia_big_title_button_link;
	}

	return $section_content;
}


if ( ! function_exists( 'hestia_slider_compatibility' ) ) :

	/**
	 * Check for previously set slider and make theme compatible.
	 */
	function hestia_slider_compatibility() {
		$hestia_big_title_background  = get_theme_mod( 'hestia_big_title_background' );
		$hestia_big_title_title       = get_theme_mod( 'hestia_big_title_title' );
		$hestia_big_title_text        = get_theme_mod( 'hestia_big_title_text' );
		$hestia_big_title_button_text = get_theme_mod( 'hestia_big_title_button_text' );
		$hestia_big_title_button_link = get_theme_mod( 'hestia_big_title_button_link' );

		$hestia_slider_content = get_theme_mod( 'hestia_slider_content' );

		if ( ! empty( $hestia_big_title_background ) || ! empty( $hestia_big_title_title ) || ! empty( $hestia_big_title_text ) || ! empty( $hestia_big_title_button_text ) || ! empty( $hestia_big_title_button_link ) ) {
			hestia_big_title();
		} else {
			if ( ! empty( $hestia_slider_content ) ) {
				hestia_slider();
			} else {
				hestia_big_title();
			}
		}
	}
endif;

add_action( 'hestia_header', 'hestia_slider_compatibility' );
