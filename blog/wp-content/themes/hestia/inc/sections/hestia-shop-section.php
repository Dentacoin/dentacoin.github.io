<?php
/**
 * Shop section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_shop' ) ) :
	/**
	 * Shop section content.
	 *
	 * This function can be called from a shortcode too.
	 * When it's called as shortcode, the title and the subtitle shouldn't appear and it should be visible all the time,
	 * it shouldn't matter if is disable on front page.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.51
	 */
	function hestia_shop( $is_shortcode = false ) {

		// When this function is called from selective refresh, $is_shortcode gets the value of WP_Customize_Selective_Refresh object. We don't need that.
		if ( ! is_bool( $is_shortcode ) ) {
			$is_shortcode = false;
		}

		/* Don't show section if Disable section is checked or it doesn't have any content. Show it if it's called as a shortcode */
		$hide_section = get_theme_mod( 'hestia_shop_hide', false );
		if ( $is_shortcode === false && (bool) $hide_section === true ) {
			if ( is_customize_preview() ) {
				echo '<section class="hestia-shop products section-gray" id="products" data-sorder="hestia_shop" style="display: none"></section>';
			}
			return;
		}

		if ( hestia_woocommerce_check() ) :

			if ( current_user_can( 'edit_theme_options' ) ) {
				/* translators: 1 - link to customizer setting. 2 - 'customizer' */
				$hestia_shop_subtitle = get_theme_mod( 'hestia_shop_subtitle', sprintf( __( 'Change this subtitle in %s.', 'hestia' ), sprintf( '<a href="%1$s" class="default-link">%2$s</a>', esc_url( admin_url( 'customize.php?autofocus&#91;control&#93;=hestia_shop_subtitle' ) ), __( 'customizer', 'hestia' ) ) ) );
			} else {
				$hestia_shop_subtitle = get_theme_mod( 'hestia_shop_subtitle' );
			}

			$hestia_shop_title = get_theme_mod( 'hestia_shop_title', esc_html__( 'Products', 'hestia' ) );

			$wrapper_class   = $is_shortcode === true ? 'is-shortcode' : '';
			$container_class = $is_shortcode === true ? '' : 'container';

			hestia_before_shop_section_trigger();
			?>
			<section class="hestia-shop products section-gray <?php echo esc_attr( $wrapper_class ); ?>" id="products" data-sorder="hestia_shop">
				<?php hestia_before_shop_section_content_trigger(); ?>
				<div class="<?php echo esc_attr( $container_class ); ?>">
					<?php
					hestia_top_shop_section_content_trigger();
					if ( $is_shortcode === false ) {
					?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2 text-center">
								<?php if ( ! empty( $hestia_shop_title ) || is_customize_preview() ) : ?>
									<h2 class="hestia-title"><?php echo wp_kses_post( $hestia_shop_title ); ?></h2>
								<?php endif; ?>
								<?php if ( ! empty( $hestia_shop_subtitle ) || is_customize_preview() ) : ?>
									<h5 class="description"><?php echo hestia_sanitize_string( $hestia_shop_subtitle ); ?></h5>
								<?php endif; ?>
							</div>
						</div>
						<?php
					}
					hestia_shop_content();
					?>
					<?php hestia_bottom_shop_section_content_trigger(); ?>
				</div>
				<?php hestia_after_shop_section_content_trigger(); ?>
			</section>
			<?php
			hestia_after_shop_section_trigger();
		endif;
	}

endif;


/**
 * Get content for shop section.
 *
 * @since 1.1.31
 * @modified 1.1.45
 * @access public
 */
function hestia_shop_content() {
	?>
	<div class="hestia-shop-content">
		<?php
		$hestia_shop_shortcode = get_theme_mod( 'hestia_shop_shortcode' );
		if ( ! empty( $hestia_shop_shortcode ) ) {
			echo do_shortcode( $hestia_shop_shortcode );
			echo '</div>';
			return;
		}
		$hestia_shop_items = get_theme_mod( 'hestia_shop_items', 4 );

		$args                   = array(
			'post_type' => 'product',
		);
		$args['posts_per_page'] = ! empty( $hestia_shop_items ) ? absint( $hestia_shop_items ) : 4;

		/* Exclude hidden products from the loop */
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',

			),
		);

		$hestia_shop_categories = get_theme_mod( 'hestia_shop_categories' );

		if ( ! empty( $hestia_shop_categories ) ) {
			array_push(
				$args['tax_query'],
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $hestia_shop_categories,
				)
			);
		}

		$hestia_shop_order = get_theme_mod( 'hestia_shop_order', 'DESC' );
		if ( ! empty( $hestia_shop_order ) ) {
			$args['order'] = $hestia_shop_order;
		}

		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) {
			$i = 1;
			echo '<div class="row">';
			while ( $loop->have_posts() ) {
				$loop->the_post();
				global $product;
				global $post;
				?>
				<div class="col-ms-6 col-sm-6 col-md-3 shop-item">
					<div class="card card-product">
						<?php
						$thumbnail = hestia_shop_thumbnail( null, 'hestia-shop' );
						if ( empty( $thumbnail ) && function_exists( 'wc_placeholder_img' ) ) {
							$thumbnail = wc_placeholder_img();
						}
						if ( ! empty( $thumbnail ) ) {
						?>
							<div class="card-image">
								<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
									<?php echo $thumbnail; ?>
								</a>
								<div class="ripple-container"></div>
							</div>
							<?php
						}
						?>
						<div class="content">
							<?php
							if ( function_exists( 'wc_get_product_category_list' ) ) {
								$prod_id            = get_the_ID();
								$product_categories = wc_get_product_category_list( $prod_id );
							} else {
								$product_categories = $product->get_categories();
							}

							if ( ! empty( $product_categories ) ) {
								/**
								 * Explode categories in words by ',' separator and show only the first 2. If the value is modified to -1 or lower in
								 * a function hooked at hestia_shop_category_words, then show all categories.
								 */
								$categories   = explode( ',', $product_categories );
								$nb_of_cat    = apply_filters( 'hestia_shop_category_words', 2 );
								$nb_of_cat    = intval( $nb_of_cat );
								$cat          = $nb_of_cat > -1 ? hestia_limit_content( $categories, $nb_of_cat, ',', false ) : $product_categories;
								$allowed_html = array(
									'a' => array(
										'href' => array(),
										'rel'  => array(),
									),
								);
								echo '<h6 class="category">';
									echo wp_kses( $cat, $allowed_html );
								echo '</h6>';
							}
							?>

							<h4 class="card-title">
								<?php
								/**
								 * Explode title in words by ' ' separator and show only the first 6 words. If the value is modified to -1 or lower in
								 * a function hooked at hestia_shop_title_words, then show the full title
								 */
								$title          = the_title( '', '', false );
								$title_in_words = explode( ' ', $title );
								$title_limit    = apply_filters( 'hestia_shop_title_words', 6 );
								$title_limit    = intval( $title_limit );
								$limited_title  = $title_limit > -1 ? hestia_limit_content( $title_in_words, $title_limit, ' ' ) : $title;
								?>
								<a class="shop-item-title-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html( $limited_title ); ?></a>

							</h4>

							<?php
							if ( $post->post_excerpt ) {
								/**
								 * Explode the excerpt in words by ' ' separator and show only the first 60 words. If the value is modified to -1 or lower in
								 * a function hooked at hestia_shop_excerpt_words, then use the normal behavior from woocommece ( show post excerpt )
								 */
								$excerpt_in_words = explode( ' ', $post->post_excerpt );
								$excerpt_limit    = apply_filters( 'hestia_shop_excerpt_words', 60 );
								$excerpt_limit    = intval( $excerpt_limit );
								$limited_excerpt  = $excerpt_limit > -1 ? hestia_limit_content( $excerpt_in_words, $excerpt_limit, ' ' ) : $post->post_excerpt;
								?>
								<div class="card-description"><?php echo apply_filters( 'woocommerce_short_description', $limited_excerpt ); ?></div>
								<?php
							}
							?>

							<div class="footer">

								<?php
								$product_price = $product->get_price_html();

								if ( ! empty( $product_price ) ) {

									echo '<div class="price"><h4>';

									echo wp_kses(
										$product_price, array(
											'span' => array(
												'class' => array(),
											),
											'del'  => array(),
										)
									);

									echo '</h4></div>';

								}
								?>

								<div class="stats">
									<?php hestia_add_to_cart(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				if ( $i % 4 == 0 ) {
					echo '</div><!-- /.row -->';
					echo '<div class="row">';
				}
				$i ++;
			}
			wp_reset_postdata();
			echo '</div>';
		}
		?>
	</div>
	<?php
}

if ( function_exists( 'hestia_shop' ) ) {
	$section_priority = apply_filters( 'hestia_section_priority', 20, 'hestia_shop' );
	add_action( 'hestia_sections', 'hestia_shop', absint( $section_priority ) );
}
