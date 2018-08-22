<?php
/**
 * Blog section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_blog' ) ) :
	/**
	 * Blog section content.
	 * This function can be called from a shortcode too.
	 * When it's called as shortcode, the title and the subtitle shouldn't appear and it should be visible all the time,
	 * it shouldn't matter if is disable on front page.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.51
	 */
	function hestia_blog( $is_shortcode = false ) {

		// When this function is called from selective refresh, $is_shortcode gets the value of WP_Customize_Selective_Refresh object. We don't need that.
		if ( ! is_bool( $is_shortcode ) ) {
			$is_shortcode = false;
		}

		/* Don't show section if Disable section is checked or it doesn't have any content. Show it if it's called as a shortcode */
		$hide_section = get_theme_mod( 'hestia_blog_hide', false );
		if ( $is_shortcode === false && (bool) $hide_section === true ) {
			if ( is_customize_preview() ) {
				echo '<section class="hestia-blogs" id="blog" data-sorder="hestia_blog" style="display: none"></section>';
			}
			return;
		}

		if ( current_user_can( 'edit_theme_options' ) ) {
			/* translators: 1 - link to customizer setting. 2 - 'customizer' */
			$hestia_blog_subtitle = get_theme_mod( 'hestia_blog_subtitle', sprintf( __( 'Change this subtitle in the %s.', 'hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_blog_subtitle' ) ), __( 'Customizer', 'hestia' ) ) ) );
		} else {
			$hestia_blog_subtitle = get_theme_mod( 'hestia_blog_subtitle' );
		}
		$hestia_blog_title = get_theme_mod( 'hestia_blog_title', __( 'Blog', 'hestia' ) );
		if ( $is_shortcode ) {
			$hestia_blog_title    = '';
			$hestia_blog_subtitle = '';
		}

		$wrapper_class   = $is_shortcode === true ? 'is-shortcode' : '';
		$container_class = $is_shortcode === true ? '' : 'container';

		hestia_before_blog_section_trigger();
		?>
		<section class="hestia-blogs <?php echo esc_attr( $wrapper_class ); ?>" id="blog" data-sorder="hestia_blog">
			<?php hestia_before_blog_section_content_trigger(); ?>
			<div class="<?php echo esc_attr( $container_class ); ?>">
				<?php
				hestia_top_blog_section_content_trigger();
				if ( $is_shortcode === false ) {
				?>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center">
							<?php
							if ( ! empty( $hestia_blog_title ) || is_customize_preview() ) {
								echo '<h2 class="hestia-title">' . wp_kses_post( $hestia_blog_title ) . '</h2>';
							}
							if ( ! empty( $hestia_blog_subtitle ) || is_customize_preview() ) {
								echo '<h5 class="description">' . hestia_sanitize_string( $hestia_blog_subtitle ) . '</h5>';
							}
							?>
						</div>
					</div>
					<?php
				}
				hestia_blog_content();
				?>
				<?php hestia_bottom_blog_section_content_trigger(); ?>
			</div>
			<?php hestia_after_blog_section_content_trigger(); ?>
		</section>
		<?php
		hestia_after_blog_section_trigger();
	}

endif;

if ( ! function_exists( 'hestia_blog_content' ) ) {
	/**
	 * Get content for blog section.
	 *
	 * @since 1.1.31
	 * @access public
	 * @param bool $is_callback Flag to check if it's callback or not.
	 */
	function hestia_blog_content( $is_callback = false ) {

		$hestia_blog_items = get_theme_mod( 'hestia_blog_items', 3 );
		if ( ! $is_callback ) {
			?>
			<div class="hestia-blog-content">
			<?php
		}

		$args                   = array(
			'ignore_sticky_posts' => true,
		);
		$args['posts_per_page'] = ! empty( $hestia_blog_items ) ? absint( $hestia_blog_items ) : 3;

		$hestia_blog_categories = get_theme_mod( 'hestia_blog_categories' );

		if ( sizeof( $hestia_blog_categories ) >= 1 && ! empty( $hestia_blog_categories[0] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $hestia_blog_categories,
				),
			);
		}

		$loop = new WP_Query( $args );

		$allowed_html = array(
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
			'i'      => array(
				'class' => array(),
			),
			'span'   => array(),
		);

		if ( $loop->have_posts() ) :
			$i = 1;
			echo '<div class="row">';
			while ( $loop->have_posts() ) :
				$loop->the_post();
				?>
				<article class="col-xs-12 col-ms-10 col-ms-offset-1 col-sm-8 col-sm-offset-2 <?php echo apply_filters( 'hestia_blog_per_row_class', 'col-md-4' ); ?> hestia-blog-item">
					<div class="card card-plain card-blog">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="card-image">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'hestia-blog' ); ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="content">
							<h6 class="category"><?php hestia_category(); ?></h6>
							<h4 class="card-title">
								<a class="blog-item-title-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
									<?php echo wp_kses( force_balance_tags( get_the_title() ), $allowed_html ); ?>
								</a>
							</h4>
							<p class="card-description"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
						</div>
					</div>
				</article>
				<?php
				if ( $i % apply_filters( 'hestia_blog_per_row_no', 3 ) == 0 ) {
					echo '</div><!-- /.row -->';
					echo '<div class="row">';
				}
				$i++;
			endwhile;
			echo '</div>';

			wp_reset_postdata();
		endif;

		if ( ! $is_callback ) {
			?>
			</div>
			<?php
		}
	}
}

if ( function_exists( 'hestia_blog' ) ) {
	$section_priority = apply_filters( 'hestia_section_priority', 60, 'hestia_blog' );
	add_action( 'hestia_sections', 'hestia_blog', absint( $section_priority ), 2 );
}
