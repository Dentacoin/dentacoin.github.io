<?php
/**
 * Slider section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_slider' ) ) :
	/**
	 * Slider section content.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.30
	 */
	function hestia_slider( $is_callback = false ) {

		if ( ! $is_callback ) {
			hestia_before_big_title_section_trigger(); ?>
			<div id="carousel-hestia-generic" class="carousel slide" data-ride="carousel">
			<?php
		}
		?>
		<div class="carousel slide" data-ride="carousel">
			<?php
			if ( has_header_video() ) {
				the_custom_header_markup();
			}
			?>
			<div class="carousel-inner">
				<?php
				$hestia_slider_alignment = get_theme_mod( 'hestia_slider_alignment', 'center' );
				$class_to_add            = ( ! empty( $hestia_slider_alignment ) ? 'text-' . $hestia_slider_alignment : 'text-center' );
				$slider_default          = hestia_get_slider_default();
				$hestia_slider_content   = get_theme_mod( 'hestia_slider_content', json_encode( $slider_default ) );
				$i                       = 0;
				if ( ! empty( $hestia_slider_content ) ) :
					$hestia_slider_content = json_decode( $hestia_slider_content );
					if ( ! empty( $hestia_slider_content ) ) {
						foreach ( $hestia_slider_content as $slider_item ) :
							$title    = ! empty( $slider_item->title ) ? apply_filters( 'hestia_translate_single_string', $slider_item->title, 'Slider section' ) : '';
							$subtitle = ! empty( $slider_item->subtitle ) ? apply_filters( 'hestia_translate_single_string', $slider_item->subtitle, 'Slider section' ) : '';
							$button   = ! empty( $slider_item->text ) ? apply_filters( 'hestia_translate_single_string', $slider_item->text, 'Slider section' ) : '';
							$link     = ! empty( $slider_item->link ) ? apply_filters( 'hestia_translate_single_string', $slider_item->link, 'Slider section' ) : '';
							$button2  = ! empty( $slider_item->text2 ) ? apply_filters( 'hestia_translate_single_string', $slider_item->text2, 'Slider section' ) : '';
							$link2    = ! empty( $slider_item->link2 ) ? apply_filters( 'hestia_translate_single_string', $slider_item->link2, 'Slider section' ) : '';
							$image    = ! empty( $slider_item->image_url ) && ! has_header_video() ? apply_filters( 'hestia_translate_single_string', $slider_item->image_url, 'Slider section' ) : '';
							$color    = ! empty( $slider_item->color ) ? apply_filters( 'hestia_translate_single_string', $slider_item->color, 'Slider section' ) : '';
							$color2   = ! empty( $slider_item->color2 ) ? apply_filters( 'hestia_translate_single_string', $slider_item->color2, 'Slider section' ) : '';

							echo '<div class="item';
							$i ++;
							if ( $i == 1 ) {
								echo ' active ';
							}
							echo ' item-' . esc_attr( $i ) . '">';

							echo hestia_set_button_style( $color, $color2, $i );
							?>
								<div class="page-header">
										<?php hestia_before_big_title_section_content_trigger(); ?>
										<div class="container">
										<?php hestia_top_big_title_section_content_trigger(); ?>
											<div class="row">
												<div class="col-md-8 col-md-offset-2 <?php echo esc_attr( $class_to_add ); ?>">
													<?php
													if ( ! empty( $title ) ) :
														$title = html_entity_decode( $title );
														?>
														<h1 class="hestia-title"><?php echo wp_kses_post( $title ); ?></h1>
													<?php endif; ?>
													<?php
													if ( ! empty( $subtitle ) ) :
														$subtitle = html_entity_decode( $subtitle );
														?>
														<span class="sub-title"><?php echo wp_kses_post( $subtitle ); ?></span>
													<?php endif; ?>
													<?php if ( ! empty( $link ) || ! empty( $button ) || ! empty( $link2 ) || ! empty( $button2 ) ) : ?>
														<div class="buttons">
															<?php
															if ( ! empty( $link ) || ! empty( $button ) ) {
																echo '<a href="' . esc_url( $link ) . '" style="background-color:' . $color . '" title="' . esc_html( $button ) . '" class="btn btn-primary btn-lg btn-left no-js-color" ' . hestia_is_external_url( $link ) . '>' . esc_html( $button ) . '</a>';
															}
															if ( ! empty( $link2 ) || ! empty( $button2 ) ) {
																echo '<a href="' . esc_url( $link2 ) . '" style="background-color:' . $color2 . '" title="' . esc_html( $button2 ) . '" class="btn btn-primary btn-lg btn-right no-js-color" ' . hestia_is_external_url( $link2 ) . '>' . esc_html( $button2 ) . '</a>';
															}
															?>
														</div>
													<?php endif; ?>
												</div>
											</div>
											<?php hestia_bottom_big_title_section_content_trigger(); ?>
										</div>
										<?php if ( ! empty( $image ) ) { ?>
										<div class="header-filter" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
										<?php } else { ?>
										<div class="header-filter"></div>
										<?php } ?>
										<?php hestia_after_big_title_section_content_trigger(); ?>
									</div>
								</div>
								<?php
						endforeach;
					}// End if().
				endif;
				?>
				</div>
				<?php if ( $i >= 2 ) : ?>
					<a class="left carousel-control" href="#carousel-hestia-generic" data-slide="prev"> <i
							class="fa fa-angle-left"></i> </a>
					<a class="right carousel-control" href="#carousel-hestia-generic" data-slide="next"> <i
							class="fa fa-angle-right"></i> </a>
				<?php endif; ?>
			</div>
		<?php
		if ( ! $is_callback ) {
		?>
			</div>
			<?php
			hestia_after_big_title_section_trigger();
		}
	}

endif;

if ( ! function_exists( 'hestia_video_settings' ) ) {
	/**
	 * Function to change video settings.
	 *
	 * @param array $settings Video settings.
	 *
	 * @since 1.1.52
	 * @return array
	 */
	function hestia_video_settings( $settings ) {
		$settings['width']  = 1920;
		$settings['height'] = 1080;
		return $settings;
	}
	add_filter( 'header_video_settings', 'hestia_video_settings' );
}

/**
 * Import lite content to slider
 *
 * @return array
 */
function hestia_get_slider_default() {
	$default = array(
		array(
			'image_url' => get_template_directory_uri() . '/assets/img/slider1.jpg',
			'title'     => esc_html__( 'Lorem Ipsum', 'hestia' ),
			'subtitle'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia' ),
			'text'      => esc_html__( 'Button', 'hestia' ),
			'link'      => '#',
			'id'        => 'customizer_repeater_56d7ea7f40a56',
			'color'     => '#e91e63',
		),
		array(
			'image_url' => get_template_directory_uri() . '/assets/img/slider2.jpg',
			'title'     => esc_html__( 'Lorem Ipsum', 'hestia' ),
			'subtitle'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia' ),
			'text'      => esc_html__( 'Button', 'hestia' ),
			'link'      => '#',
			'id'        => 'customizer_repeater_56d7ea7f40a57',
			'color'     => '#e91e63',
		),
		array(
			'image_url' => get_template_directory_uri() . '/assets/img/slider3.jpg',
			'title'     => esc_html__( 'Lorem Ipsum', 'hestia' ),
			'subtitle'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia' ),
			'text'      => esc_html__( 'Button', 'hestia' ),
			'link'      => '#',
			'id'        => 'customizer_repeater_56d7ea7f40a58',
			'color'     => '#e91e63',
		),
	);

	$lite_content = get_option( 'theme_mods_hestia' );

	if ( $lite_content ) {

		$hestia_big_title_title       = '';
		$hestia_big_title_text        = '';
		$hestia_big_title_button_text = '';
		$hestia_big_title_button_link = '';
		$hestia_big_title_background  = '';
		if ( array_key_exists( 'hestia_big_title_title', $lite_content ) ) {
			$hestia_big_title_title = $lite_content['hestia_big_title_title'];
		}
		if ( array_key_exists( 'hestia_big_title_text', $lite_content ) ) {
			$hestia_big_title_text = $lite_content['hestia_big_title_text'];
		}
		if ( array_key_exists( 'hestia_big_title_button_text', $lite_content ) ) {
			$hestia_big_title_button_text = $lite_content['hestia_big_title_button_text'];
		}
		if ( array_key_exists( 'hestia_big_title_button_link', $lite_content ) ) {
			$hestia_big_title_button_link = $lite_content['hestia_big_title_button_link'];
		}
		if ( array_key_exists( 'hestia_big_title_background', $lite_content ) ) {
			$hestia_big_title_background = $lite_content['hestia_big_title_background'];
		}
		if ( ! empty( $hestia_big_title_title ) || ! empty( $hestia_big_title_text ) || ! empty( $hestia_big_title_button_text ) || ! empty( $hestia_big_title_button_link ) || ! empty( $hestia_big_title_background ) ) {
			array_unshift(
				$default, array(
					'id'        => 'customizer_repeater_56d7ea7f40a56',
					'title'     => $hestia_big_title_title,
					'subtitle'  => $hestia_big_title_text,
					'text'      => $hestia_big_title_button_text,
					'link'      => $hestia_big_title_button_link,
					'image_url' => $hestia_big_title_background,
				)
			);
		}
	}
	return $default;
}

/**
 * Function to style slider button colors.
 *
 * @param string $color1        string first color.
 * @param string $color2        string second color.
 * @param string $item_number   slide number.
 *
 * @return string
 */
function hestia_set_button_style( $color1, $color2, $item_number ) {
	$colors = array(
		$color1 => '.btn-left',
		$color2 => '.btn-right',
	);
	$style  = '';
	if ( ! empty( $colors ) ) {
		if ( ! empty( $item_number ) ) {
			$style .= '<style>';
			foreach ( $colors as $color => $class ) {
				if ( ! empty( $color ) ) {
					$style .= '
                    .item.item-' . $item_number . ' .buttons ' . esc_attr( $class ) . '{
                        -webkit-box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color, '0.12' ) . ';
                        box-shadow: 0 2px 2px 0 ' . hestia_hex_rgba( $color, '0.14' ) . ',0 3px 1px -2px ' . hestia_hex_rgba( $color, '0.2' ) . ',0 1px 5px 0 ' . hestia_hex_rgba( $color, '0.12' ) . ';
                    }
                    .item.item-' . $item_number . ' .buttons ' . esc_attr( $class ) . ':hover {
                        -webkit-box-shadow: 0 14px 26px -12px' . hestia_hex_rgba( $color, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color, '0.2' ) . ';
                        box-shadow: 0 14px 26px -12px ' . hestia_hex_rgba( $color, '0.42' ) . ',0 4px 23px 0 rgba(0,0,0,0.12),0 8px 10px -5px ' . hestia_hex_rgba( $color, '0.2' ) . ';
                    }';
				}
			}
			$style .= '</style>';
		}
	}
	return $style;
}
