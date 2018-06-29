<?php
/**
 * Custom template tags for Hestia
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_layout' ) ) :
	/**
	 * Return class based on the layout.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.24
	 */
	function hestia_layout() {

		if ( is_page_template( 'page-templates/template-pagebuilder-full-width.php' ) ) {
			return 'main';
		}

		$hestia_general_layout = get_theme_mod( 'hestia_general_layout', 1 );
		if ( isset( $hestia_general_layout ) && $hestia_general_layout != 1 ) {
			$layout = 'main';
		} else {
			$layout = 'main main-raised';
		}

		return $layout;
	}
endif;

if ( ! function_exists( 'hestia_boxed_layout_header' ) ) :
	/**
	 * Return class based on the layout.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.24
	 */
	function hestia_boxed_layout_header() {
		$hestia_general_layout = get_theme_mod( 'hestia_general_layout', 1 );

		$header_class = '';
		if ( isset( $hestia_general_layout ) && $hestia_general_layout == 1 ) {
			$header_class = 'boxed-layout-header';
		}

		return $header_class;
	}
endif;

if ( ! function_exists( 'hestia_featured_header' ) ) :
	/**
	 * Returns the header image if the featured image isn't available.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_featured_header() {
		// Default header image
		$thumbnail                 = get_header_image();
		$use_header_image_sitewide = get_theme_mod( 'hestia_header_image_sitewide', false );

		// If the option to use Header Image Sitewide is enabled, return header image and exit function.
		if ( (bool) $use_header_image_sitewide === true ) {
			return esc_url( apply_filters( 'hestia_header_image_filter', $thumbnail ) );
		}

		/** Handle Pages and Posts Header.
		 *  Single Product: Product Category Image > Header Image > Gradient
		 *  Product Category: Product Category Image > Header Image > Gradient
		 *  Shop Page: Shop Page Featured Image > Header Image > Gradient
		 *  Blog Page: Page Featured Image > Header Image > Gradient
		 *  Single Post: Featured Image > Gradient
		 */
		$shop_id = get_option( 'woocommerce_shop_page_id' );
		if ( hestia_woocommerce_check() && is_woocommerce() ) {

			// Single product page
			if ( is_product() ) {
				$terms = get_the_terms( get_queried_object_id(), 'product_cat' );
				// If product has categories
				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						if ( ! empty( $term->term_id ) ) {
							$category_thumbnail = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
						}
						// Get product category's image
						if ( ! empty( $category_thumbnail ) ) {
							$thumb_tmp = wp_get_attachment_url( $category_thumbnail );
						} // End if().
					}
				}
			} // End if().
			elseif ( is_product_category() ) {
				global $wp_query;
				$category = $wp_query->get_queried_object();
				if ( ! empty( $category->term_id ) ) {
					$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
				}
				if ( ! empty( $thumbnail_id ) ) {
					// Get category featured image
					$thumb_tmp = wp_get_attachment_url( $thumbnail_id );
				} else {
					if ( ! empty( $shop_id ) ) {
						// Get shop page featured image
						$thumb_tmp = get_the_post_thumbnail_url( $shop_id );
						if ( ! empty( $thumb_tmp ) ) {
							$thumbnail = $thumb_tmp;
						}
					}
				}
			} else {
				// Shop page
				if ( ! empty( $shop_id ) ) {
					// Get shop page featured image
					$thumb_tmp = get_the_post_thumbnail_url( $shop_id );
				}
			}// End if().
		} else {
			// Get featured image
			if ( is_home() ) {
				$page_for_posts_id = get_option( 'page_for_posts' );
				if ( ! empty( $page_for_posts_id ) ) {
					$thumb_tmp = get_the_post_thumbnail_url( $page_for_posts_id );
				}
			} else {
				$thumb_tmp = get_the_post_thumbnail_url();
			}
		}// End if().

		if ( ! empty( $thumb_tmp ) ) {
			$thumbnail = $thumb_tmp;
		}

		return esc_url( apply_filters( 'hestia_header_image_filter', $thumbnail ) );
	}
endif;

if ( ! function_exists( 'hestia_output_wrapper_header_background' ) ) :
	/**
	 * Echoes The Header Background
	 * Case 1 - header image
	 * Case 2 - gradient, header image and background image not set
	 * Case 3 - background image
	 *
	 * @since Hestia 1.0
	 */
	function hestia_output_wrapper_header_background( $uses_default_header_image = true ) {
		if ( $uses_default_header_image == true ) {
			$background_image = get_header_image();
		} else {
			$background_image = hestia_featured_header();
		} ?>

		<?php
		$customizer_background_image = get_background_image();

		$header_filter_div = '<div data-parallax="active" class="header-filter';

		/* Header Image */
		if ( ! empty( $background_image ) ) {
			$header_filter_div .= '" style="background-image: url(' . esc_url( $background_image ) . ');"';
			/* Gradient Color */
		} elseif ( empty( $customizer_background_image ) ) {
			$header_filter_div .= ' header-filter-gradient"';
			/* Background Image */
		} else {
			$header_filter_div .= '"';
		}
		$header_filter_div .= '></div>';

		echo apply_filters( 'hestia_header_wrapper_background_filter', $header_filter_div );
	}
endif;

if ( ! function_exists( 'hestia_logo' ) ) :
	/**
	 * Display your custom logo if present.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_logo() {
		if ( get_theme_mod( 'custom_logo' ) ) {
			$logo          = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
			$alt_attribute = get_post_meta( get_theme_mod( 'custom_logo' ), '_wp_attachment_image_alt', true );
			if ( empty( $alt_attribute ) ) {
				$alt_attribute = get_bloginfo( 'name' );
			}
			$logo = '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( $alt_attribute ) . '">';
		} else {
			$logo = '<p>' . get_bloginfo( 'name' ) . '</p>';
		}

		return $logo;
	}
endif;

if ( ! function_exists( 'hestia_category' ) ) :
	/**
	 * Display the first category of the post.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_category() {
		$category = get_the_category();
		if ( $category ) {
			/* translators: %s is Category name */
			echo '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'hestia' ), $category[0]->name ) ) . '" ' . '>' . esc_html( $category[0]->name ) . '</a> ';
		}
	}
endif;

if ( ! function_exists( 'hestia_get_author' ) ) :
	/**
	 * Returns the author meta data outside the loop.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_get_author( $info ) {
		global $post;
		$author_id = $post->post_author;
		$author    = get_the_author_meta( $info, $author_id );

		return $author;
	}
endif;

if ( ! function_exists( 'hestia_author_box' ) ) :
	/**
	 * Display author box below the posts.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_author_box() {
		?>
		<div class="card card-profile card-plain">
			<div class="row">
				<div class="col-md-2">
					<div class="card-avatar">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php the_author(); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?></a>
					</div>
				</div>
				<div class="col-md-10">
					<h4 class="card-title"><?php esc_html( the_author() ); ?></h4>
					<p class="description"><?php esc_html( the_author_meta( 'description' ) ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_wp_link_pages' ) ) :
	/**
	 * Display a custom wp_link_pages for singular view.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_wp_link_pages( $args = '' ) {
		$defaults = array(
			'before'           => '<ul class="nav pagination pagination-primary">',
			'after'            => '</ul>',
			'link_before'      => '',
			'link_after'       => '',
			'next_or_number'   => 'number',
			'nextpagelink'     => esc_html__( 'Next page', 'hestia' ),
			'previouspagelink' => esc_html__( 'Previous page', 'hestia' ),
			'pagelink'         => '%',
			'echo'             => 1,
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			if ( 'number' == $r['next_or_number'] ) {
				$output .= $r['before'];
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j       = str_replace( '%', $i, $r['pagelink'] );
					$output .= ' ';
					$output .= $r['link_before'];
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= _wp_link_page( $i );
					} else {
						$output .= '<span class="page-numbers current">';
					}
					$output .= $j;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= '</a>';
					} else {
						$output .= '</span>';
					}
					$output .= $r['link_after'];
				}
				$output .= $r['after'];
			} else {
				if ( $more ) {
					$output .= $r['before'];
					$i       = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $r['link_before'] . $r['previouspagelink'] . $r['link_after'] . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $r['link_before'] . $r['nextpagelink'] . $r['link_after'] . '</a>';
					}
					$output .= $r['after'];
				}
			}// End if().
		}// End if().

		if ( $r['echo'] ) {
			echo wp_kses(
				$output, array(
					'div'  => array(
						'class' => array(),
						'id'    => array(),
					),
					'ul'   => array(
						'class' => array(),
					),
					'a'    => array(
						'href' => array(),
					),
					'li'   => array(),
					'span' => array(
						'class' => array(),
					),
				)
			);
		}

		return $output;
	}
endif;

if ( ! function_exists( 'hestia_comments_list' ) ) :
	/**
	 * Custom list of comments for the theme.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_comments_list( $comment, $args, $depth ) {
		?>
		<div <?php comment_class( empty( $args['has_children'] ) ? 'media' : 'parent media' ); ?>
				id="comment-<?php comment_ID(); ?>">
			<?php if ( $args['type'] != 'pings' ) : ?>
				<a class="pull-left" href="<?php echo esc_url( get_comment_author_url( $comment ) ); ?> ">
					<div class="comment-author avatar vcard">
						<?php
						if ( $args['avatar_size'] != 0 ) {
							echo get_avatar( $comment, 64 );
						}
						?>
					</div>
				</a>
			<?php endif; ?>
			<div class="media-body">
				<h4 class="media-heading">
					<?php echo get_comment_author_link(); ?>
					<small>
						<?php
						printf(
							/* translators: %1$s is Date, %2$s is Time */
							esc_html__( '&#183; %1$s at %2$s', 'hestia' ),
							get_comment_date(),
							get_comment_time()
						);
						edit_comment_link( esc_html__( '(Edit)', 'hestia' ), '  ', '' );
						?>
					</small>
				</h4>
				<?php comment_text(); ?>
				<div class="media-footer">
					<?php
					echo get_comment_reply_link(
						array(
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'reply_text' => sprintf( '<i class="fa fa-mail-reply"></i> %s', esc_html__( 'Reply', 'hestia' ) ),
						),
						$comment->comment_ID,
						$comment->comment_post_ID
					);
					?>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_comments_template' ) ) :
	/**
	 * Custom list of comments for the theme.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_comments_template() {
		if ( is_user_logged_in() ) {
			$current_user = get_avatar( wp_get_current_user(), 64 );
		} else {
			$current_user = '<img src="' . get_template_directory_uri() . '/assets/img/placeholder.jpg" height="64" width="64"/>';
		}
		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args     = array(
			'class_form'         => 'form',
			'class_submit'       => 'btn btn-primary pull-right',
			'title_reply_before' => '<h3 class="hestia-title text-center">',
			'title_reply_after'  => '</h3> <span class="pull-left author"> <div class="avatar">' . $current_user . '</div> </span> <div class="media-body">',
			'must_log_in'        => '<p class="must-log-in">' .
									sprintf(
										wp_kses(
											/* translators: %s is Link to login */
											__( 'You must be <a href="%s">logged in</a> to post a comment.', 'hestia' ), array(
												'a' => array(
													'href' => array(),
												),
											)
										), esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) )
									) . '</p> </div>',
			'fields'             => apply_filters(
				'comment_form_default_fields', array(
					'author' => '<div class="row"> <div class="col-md-4"> <div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'Name', 'hestia' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" name="author" class="form-control" type="text"' . $aria_req . ' /> <span class="hestia-input"></span> </div> </div>',
					'email'  => '<div class="col-md-4"> <div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'Email', 'hestia' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" name="email" class="form-control" type="email"' . $aria_req . ' /> <span class="hestia-input"></span> </div> </div>',
					'url'    => '<div class="col-md-4"> <div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'Website', 'hestia' ) . '</label><input id="url" name="url" class="form-control" type="url"' . $aria_req . ' /> <span class="hestia-input"></span> </div> </div> </div>',
				)
			),
			'comment_field'      => '<div class="form-group label-floating is-empty"> <label class="control-label">' . esc_html__( 'What\'s on your mind?', 'hestia' ) . '</label><textarea id="comment" name="comment" class="form-control" rows="6" aria-required="true"></textarea><span class="hestia-input"></span> </div> </div>',
		);

		return $args;
	}
endif;

if ( ! function_exists( 'hestia_comments_pagination' ) ) :
	/**
	 * Display a custom number page navigation for comments.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_comments_pagination() {
		$pages = paginate_comments_links(
			array(
				'echo' => false,
				'type' => 'array',
			)
		);
		if ( is_array( $pages ) ) {
			echo '<div class="text-center"><ul class="nav pagination pagination-primary">';
			foreach ( $pages as $page ) {
				echo '<li>' . $page . '</li>';
			}
			echo '</ul></div>';
		}
	}
endif;

if ( ! function_exists( 'hestia_related_posts' ) ) :
	/**
	 * Related posts for single view.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_related_posts() {
		global $post;
		$cats         = wp_get_object_terms(
			$post->ID, 'category', array(
				'fields' => 'ids',
			)
		);
		$args         = array(
			'posts_per_page'      => 3,
			'cat'                 => $cats,
			'orderby'             => 'date',
			'ignore_sticky_posts' => true,
			'post__not_in'        => array( $post->ID ),
		);
		$allowed_html = array(
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
			'i'      => array(
				'class' => array(),
			),
			'span'   => array(),
		);

		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) :
			?>
			<div class="section related-posts">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2 class="hestia-title text-center"><?php esc_html_e( 'Related Posts', 'hestia' ); ?></h2>
							<div class="row">
								<?php
								while ( $loop->have_posts() ) :
									$loop->the_post();
									?>
									<div class="col-md-4">
										<div class="card card-blog">
											<?php if ( has_post_thumbnail() ) : ?>
												<div class="card-image">
													<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
														<?php the_post_thumbnail( 'hestia-blog' ); ?>
													</a>
												</div>
											<?php endif; ?>
											<div class="content">
												<h6 class="category text-info"><?php hestia_category(); ?></h6>
												<h4 class="card-title">
													<a class="blog-item-title-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
														<?php echo wp_kses( force_balance_tags( get_the_title() ), $allowed_html ); ?>
													</a>
												</h4>
												<p class="card-description"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'hestia_social_icons' ) ) :
	/**
	 * Social sharing icons for single view.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_social_icons() {
		$enabled_socials = get_theme_mod( 'hestia_enable_sharing_icons', true );
		$post_link       = get_the_permalink();
		$post_title      = get_the_title();

		$social_links = '';
		$allowed_tags = array(
			'div' => array(
				'class' => array(),
			),
			'a'   => array(
				'href'                => array(),
				'target'              => array(),
				'title'               => array(),
				'rel'                 => array(),
				'class'               => array(),
				'data-original-title' => array(),
			),
			'i'   => array(
				'class' => array(),
			),
		);

		if ( (bool) $enabled_socials === true ) {
			$social_links = ' <div class="col-md-6">
			<div class="entry-social">
				<a target="_blank" rel="tooltip"
				   data-original-title="' . esc_attr( 'Share on Facebook', 'hestia-pro' ) . '"
				   class="btn btn-just-icon btn-round btn-facebook"
				   href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url( $post_link ) . '"><i
							class="fa fa-facebook"></i></a>
				<a target="_blank" rel="tooltip"
				   data-original-title="' . esc_attr( 'Share on Twitter', 'hestia-pro' ) . '"
				   class="btn btn-just-icon btn-round btn-twitter"
				   href="https://twitter.com/home?status=' . wp_strip_all_tags( $post_title ) . ' - ' . esc_url( $post_link ) . '"><i
							class="fa fa-twitter"></i></a>
				<a target="_blank" rel="tooltip"
				   data-original-title=" ' . esc_attr( 'Share on Google+', 'hestia-pro' ) . '"
				   class="btn btn-just-icon btn-round btn-google"
				   href="https://plus.google.com/share?url=' . esc_url( $post_link ) . '"><i class="fa fa-google"></i></a>
			</div></div>';
		}

		echo apply_filters( 'hestia_filter_blog_social_icons', wp_kses( $social_links, $allowed_tags ) );
	}
endif;

if ( ! function_exists( 'hestia_get_image_sizes' ) ) :
	/**
	 * Output image sizes for attachment single page.
	 *
	 * @since Hestia 1.0
	 */
	function hestia_get_image_sizes() {

		/* If not viewing an image attachment page, return. */
		if ( ! wp_attachment_is_image( get_the_ID() ) ) {
			return;
		}

		/* Set up an empty array for the links. */
		$links = array();

		/* Get the intermediate image sizes and add the full size to the array. */
		$sizes   = get_intermediate_image_sizes();
		$sizes[] = 'full';

		/* Loop through each of the image sizes. */
		foreach ( $sizes as $size ) {

			/* Get the image source, width, height, and whether it's intermediate. */
			$image = wp_get_attachment_image_src( get_the_ID(), $size );

			/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
			if ( ! empty( $image ) && ( true == $image[3] || 'full' == $size ) ) {
				$links[] = '<a target="_blank" class="image-size-link" href="' . esc_url( $image[0] ) . '">' . $image[1] . ' &times; ' . $image[2] . '</a>';
			}
		}

		/* Join the links in a string and return. */

		return join( ' <span class="sep">|</span> ', $links );
	}
endif;

if ( ! function_exists( 'hestia_contact_get_old_content' ) ) :
	/**
	 * Hestia Contact Old Defaults
	 */
	function hestia_contact_get_old_content( $theme_mod ) {
		$contact_section_default_old = get_theme_mod( $theme_mod );
		$output                      = '';

		if ( ! empty( $contact_section_default_old ) ) {
			$contact_section_default_old_content = json_decode( $contact_section_default_old );
			if ( ! empty( $contact_section_default_old_content ) ) {
				foreach ( $contact_section_default_old_content as $contact_item ) {
					if ( ! empty( $contact_item ) ) {
						$output .= '<div class="hestia-info info-horizontal">' . "\n";

						if ( ! empty( $contact_item->icon_value ) ) {
							$output .= '<div class="icon icon-primary"><i class="fa ' . esc_attr( $contact_item->icon_value ) . '"></i></div>' . "\n";
						}

						$output .= '<div class="description">' . "\n";

						if ( ! empty( $contact_item->title ) ) {
							$output .= '<h4 class="info-title">' . wp_kses_post( $contact_item->title ) . '</h4>' . "\n";
						}

						if ( ! empty( $contact_item->text ) ) {
							$output .= '<p>' . wp_kses_post( $contact_item->text ) . '</p>' . "\n";
						}
						$output .= '</div></div>';
					}
				}
			}
		}

		return $output;
	}
endif;

if ( ! function_exists( 'hestia_the_footer_content' ) ) :
	/**
	 * Function to display footer content.
	 *
	 * @since 1.1.24
	 * @access public
	 */
	function hestia_the_footer_content() {
		/**
		 * Array holding all registered footer widgets areas
		 */
		$hestia_footer_widgets_ids = array(
			'footer-one-widgets',
			'footer-two-widgets',
			'footer-three-widgets',
			'footer-four-widgets',
		);
		$hestia_footer_class       = 'col-md-4';
		$footer_has_widgets        = false;
		$hestia_nr_footer_widgets  = get_theme_mod( 'hestia_nr_footer_widgets', '3' );

		/**
		 *  Enabling alternative footer style
		 */
		$footer_style = get_theme_mod( 'hestia_alternative_footer_style', 'black_footer' );
		switch ( $footer_style ) {
			case 'black_footer':
				$footer_class = 'footer-black';
				break;
			case 'white_footer':
				$footer_class = '';
				break;
			default:
				$footer_class = 'footer-black';
		}

		/**
		 *  Get the widgets areas ids and class corresponding to the number selected by the user
		 */
		if ( ! empty( $hestia_nr_footer_widgets ) ) {
			$hestia_footer_widgets_ids = array_slice( $hestia_footer_widgets_ids, 0, $hestia_nr_footer_widgets );
			switch ( $hestia_nr_footer_widgets ) {
				case 1:
					$hestia_footer_class = 'col-md-12';
					break;
				case 2:
					$hestia_footer_class = 'col-md-6';
					break;
				case 3:
					$hestia_footer_class = 'col-md-4';
					break;
				case 4:
					$hestia_footer_class = 'col-md-3';
					break;
			}
		}
		/**
		 * Check if the selected footer widgets areas are not empty
		 */
		if ( ! empty( $hestia_footer_widgets_ids ) ) {
			foreach ( $hestia_footer_widgets_ids as $hestia_footer_widget_item ) {
				$footer_has_widgets = is_active_sidebar( $hestia_footer_widget_item );
				if ( $footer_has_widgets ) {
					break;
				}
			}
		}

		hestia_before_footer_trigger();
		?>
		<footer class="footer <?php echo esc_attr( $footer_class ); ?> footer-big">
			<?php hestia_before_footer_content_trigger(); ?>
			<div class="container">
				<?php
				if ( $footer_has_widgets ) {
					?>
					<div class="content">
						<div class="row">
							<?php
							if ( ! empty( $hestia_footer_widgets_ids ) ) {
								foreach ( $hestia_footer_widgets_ids as $hestia_footer_widget_item ) {
									if ( is_active_sidebar( $hestia_footer_widget_item ) ) {
										echo '<div class="' . $hestia_footer_class . '">';
										dynamic_sidebar( $hestia_footer_widget_item );
										echo '</div>';
									}
								}
							}
							?>
						</div>
					</div>
					<hr/>
					<?php
				}
				?>
				<?php hestia_before_footer_widgets_trigger(); ?>
				<div class="hestia-bottom-footer-content">
					<?php
					hesta_bottom_footer_content();
					?>
				</div>
				<?php hestia_after_footer_widgets_trigger(); ?>
			</div>
			<?php hestia_after_footer_content_trigger(); ?>
		</footer>
		<?php
		hestia_after_footer_trigger();
	}
endif;

add_action( 'hestia_do_footer', 'hestia_the_footer_content' );

if ( ! function_exists( 'hesta_bottom_footer_content' ) ) :
	/**
	 * Function to display footer copyright and footer menu.
	 *
	 * @param bool $is_callback Callback flag.
	 */
	function hesta_bottom_footer_content( $is_callback = false ) {
		if ( ! $is_callback ) {
			?>
			<div class="hestia-bottom-footer-content">
			<?php
		}
		$hestia_general_credits = get_theme_mod(
			'hestia_general_credits',
			sprintf(
				/* translators: %1$s is Theme Name, %2$s is WordPress */
				esc_html__( '%1$s | Powered by %2$s', 'hestia' ),
				sprintf(
					/* translators: %s is Theme name */
					'<a href="https://themeisle.com/themes/hestia/" target="_blank" rel="nofollow">%s</a>',
					esc_html__( 'Hestia', 'hestia' )
				),
				/* translators: %s is WordPress */
				sprintf(
					'<a href="%1$s" rel="nofollow">%2$s</a>',
					esc_url( __( 'http://wordpress.org', 'hestia' ) ),
					esc_html__( 'WordPress', 'hestia' )
				)
			)
		);
		$hestia_copyright_alignment = get_theme_mod( 'hestia_copyright_alignment', 'right' );
		$menu_class                 = 'pull-left';
		$copyright_class            = 'pull-right';
		switch ( $hestia_copyright_alignment ) {
			case 'left':
				$menu_class      = 'pull-right';
				$copyright_class = 'pull-left';
				break;
			case 'center':
				$menu_class      = 'hestia-center';
				$copyright_class = 'hestia-center';
		}
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'depth'          => 1,
				'container'      => 'ul',
				'menu_class'     => 'footer-menu ' . esc_attr( $menu_class ),
			)
		);
		?>
		<?php if ( ! empty( $hestia_general_credits ) || is_customize_preview() ) : ?>
			<div class="copyright <?php echo esc_attr( $copyright_class ); ?>">
				<?php echo wp_kses_post( $hestia_general_credits ); ?>
			</div>
		<?php endif; ?>
		<?php
		if ( ! $is_callback ) {
			?>
			</div>
			<?php
		}
	}
endif;

if ( ! function_exists( 'hestia_the_header_top_bar' ) ) :
	/**
	 * Function to display header top bar.
	 *
	 * @since 1.1.40
	 *
	 * @param bool $is_callback Check if we need to add hestia-top-bar div.
	 *
	 * @access public
	 */
	function hestia_the_header_top_bar( $is_callback = false ) {

		$hide_top_bar = get_theme_mod( 'hestia_top_bar_hide', true );
		if ( (bool) $hide_top_bar === true ) {
			return;
		}

		$hestia_top_bar_alignment = get_theme_mod( 'hestia_top_bar_alignment', apply_filters( 'hestia_top_bar_alignment_default', 'right' ) );
		$menu_class               = 'pull-right';
		$sidebar_class            = 'pull-left';
		if ( ! empty( $hestia_top_bar_alignment ) && $hestia_top_bar_alignment === 'left' ) {
			$menu_class    = 'pull-left';
			$sidebar_class = 'pull-right';
		}
		?>

		<?php
		if ( $is_callback !== true ) {
			?>
			<div class="hestia-top-bar">
			<?php
		}
		?>
		<div class="container">
			<div class="row">
				<?php
				/**
				 * Call for sidebar
				 */
				if ( is_active_sidebar( 'sidebar-top-bar' ) ) {
					$sidebar_class .= ' col-md-6';
					if ( ! has_nav_menu( 'top-bar-menu' ) && ! current_user_can( 'manage_options' ) ) {
						$sidebar_class .= ' col-md-12';
					}
					?>
					<div class="<?php echo esc_attr( $sidebar_class ); ?>">
						<?php dynamic_sidebar( 'sidebar-top-bar' ); ?>
					</div>
					<?php
				}
				if ( is_active_sidebar( 'sidebar-top-bar' ) ) {
					$menu_class .= ' col-md-6';
				} else {
					$menu_class .= ' col-md-12';
				}
				?>
				<div class="
					<?php echo esc_attr( $menu_class ); ?>">
					<?php
					/**
					 * Call for the menu
					 */
					wp_nav_menu(
						array(
							'theme_location' => 'top-bar-menu',
							'depth'          => 1,
							'container'      => 'div',
							'container_id'   => 'top-bar-navigation',
							'menu_class'     => 'nav top-bar-nav',
							'fallback_cb'    => 'hestia_bootstrap_navwalker::fallback',
							'walker'         => new hestia_bootstrap_navwalker(),
						)
					);
					?>
				</div>
			</div>
		</div>
		<?php
		if ( $is_callback !== true ) {
			?>
			</div>
			<?php
		}
		?>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_the_header_content' ) ) :
	/**
	 * Function to display header content.
	 *
	 * @since 1.1.24
	 * @access public
	 */
	function hestia_the_header_content() {
		$navbar_class = '';

		$hestia_navbar_transparent = get_theme_mod( 'hestia_navbar_transparent', true );
		if ( get_option( 'show_on_front' ) === 'page' && is_front_page() && ! is_page_template() && $hestia_navbar_transparent ) {
			$navbar_class = 'navbar-color-on-scroll navbar-transparent';
		}

		hestia_before_header_trigger();

		$hestia_header_alignment = get_theme_mod( 'hestia_header_alignment', 'left' );
		if ( ! empty( $hestia_header_alignment ) ) {
			$navbar_class .= ' hestia_' . $hestia_header_alignment;
		}

		$hestia_full_screen_menu = get_theme_mod( 'hestia_full_screen_menu', false );
		$navbar_class           .= (bool) $hestia_full_screen_menu === true ? ' full-screen-menu' : '';

		$hide_top_bar = get_theme_mod( 'hestia_top_bar_hide', true );
		if ( (bool) $hide_top_bar === false ) {
			$navbar_class .= ' header-with-topbar';
		}

		if ( ! is_home() && ! is_front_page() ) {
			$navbar_class .= ' navbar-not-transparent';
		}

		$navbar_class = apply_filters( 'hestia_header_classes', $navbar_class );

		hestia_the_header_top_bar();
		?>
		<nav class="navbar navbar-default navbar-fixed-top <?php echo esc_attr( $navbar_class ); ?>">
			<?php hestia_before_header_content_trigger(); ?>
			<div class="container">
				<div class="navbar-header">
					<div class="title-logo-wrapper">
						<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php echo hestia_logo(); ?></a>
					</div>
				</div>
				<?php
				if ( $hestia_header_alignment === 'right' && is_active_sidebar( 'header-sidebar' ) ) {
					?>
					<div class="header-sidebar-wrapper">
						<div class="header-widgets-wrapper">
							<?php
							dynamic_sidebar( 'header-sidebar' );
							?>
						</div>
					</div>
					<?php
				} elseif ( $hestia_header_alignment === 'right' && is_customize_preview() ) {
					hestia_sidebar_placeholder( 'hestia-sidebar-header', 'header-sidebar', 'no-variable-width' );
				}

				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container'       => 'div',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'main-navigation',
						'menu_class'      => 'nav navbar-nav navbar-right',
						'fallback_cb'     => 'hestia_bootstrap_navwalker::fallback',
						'walker'          => new hestia_bootstrap_navwalker(),
						'items_wrap'      => ( function_exists( 'hestia_after_primary_navigation' ) ) ? hestia_after_primary_navigation() : '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
				?>
				<?php if ( has_nav_menu( 'primary' ) || current_user_can( 'manage_options' ) ) : ?>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="sr-only"><?php esc_html_e( 'Toggle Navigation', 'hestia' ); ?></span>
					</button>
				<?php endif; ?>
			</div>

			<?php hestia_after_header_content_trigger(); ?>
		</nav>
		<?php
		hestia_after_header_trigger();
	}
endif;

add_action( 'hestia_do_header', 'hestia_the_header_content' );

if ( ! function_exists( 'hestia_sidebar_placeholder' ) ) :
	/**
	 * Display sidebar placeholder.
	 *
	 * @param string $class_to_add Classes to add on container.
	 * @param string $sidebar_id Id of the sidebar used as a class to differentiate hestia-widget-placeholder for blog and shop pages.
	 *
	 * @access public
	 * @since 1.1.24
	 */
	function hestia_sidebar_placeholder( $class_to_add, $sidebar_id, $bootstrap_class = 'col-md-3' ) {
		$content = apply_filters( 'hestia_sidebar_placeholder_content', esc_html__( 'This sidebar is active but empty. In order to use this layout, please add widgets in the sidebar', 'hestia' ) );
		?>
		<div class="<?php echo esc_attr( $bootstrap_class ); ?> blog-sidebar-wrapper">
			<aside id="secondary" class="blog-sidebar <?php echo esc_attr( $class_to_add ); ?>" role="complementary">
				<div class="hestia-widget-placeholder
			<?php
			if ( ! empty( $sidebar_id ) ) {
				echo esc_attr( $sidebar_id );
			}
				?>
			">
					<?php
					the_widget( 'WP_Widget_Text', 'text=' . $content );
					?>
				</div>
			</aside><!-- .sidebar .widget-area -->
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hestia_get_content_classes' ) ) :
	/**
	 * Function to decide which classes to add on content. It depends if sidebar is visible or not.
	 *
	 * $args format:
	 * array(
	 *  'full-width' => '.classes_to_add',
	 *  'sidebar-right' => '.classes_to_add'',
	 *  'sidebar-left' => '.classes_to_add',
	 *  'is_shop' => false
	 * )
	 *
	 * @param string $layout Control on page layout.
	 * @param string $sidebar_name Sidebar id.
	 * @param array  $args Arguments.
	 *
	 * @return string
	 */
	function hestia_get_content_classes( $layout, $sidebar_name, $args ) {
		if ( hestia_woocommerce_check() && ( is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
			return 'col-md-12';
		}
		$class_to_add = ! empty( $args['full-width'] ) ? $args['full-width'] : 'col-md-12';
		$is_shop      = ! empty( $args['is_shop'] ) ? $args['is_shop'] : false;
		if ( is_active_sidebar( $sidebar_name ) && ! empty( $layout ) || is_customize_preview() ) {
			switch ( $layout ) {
				case 'sidebar-right':
					$class_to_add = $args['sidebar-right'];
					if ( $is_shop && ! is_product() ) {
						add_filter( 'loop_shop_columns', 'hestia_shop_loop_columns' );
					}
					break;
				case 'sidebar-left':
					$class_to_add = $args['sidebar-left'];
					if ( $is_shop && ! is_product() ) {
						add_filter( 'loop_shop_columns', 'hestia_shop_loop_columns' );
					}
					break;
			}
		}

		return $class_to_add;
	}
endif;

if ( ! function_exists( 'hestia_get_sidebar' ) ) :
	/**
	 * Function to display the proper sidebar depending on the page ( WooCommerce sidebar or normal sidebar )
	 */
	function hestia_get_sidebar() {
		if ( hestia_woocommerce_check() && ( is_cart() || is_checkout() || is_account_page() ) ) {
			return;
		}
		if ( hestia_woocommerce_check() && is_shop() ) {
			get_sidebar( 'woocommerce' );
		} else {
			get_sidebar();
		}
	}
endif;

if ( ! function_exists( 'hestia_hidden_sidebars' ) ) :
	/**
	 * Fix for sections with widgets not appearing anymore after the hide button is selected for each section.
	 *
	 * @since 1.1.41
	 */
	function hestia_hidden_sidebars() {
		?>
		<div style="display: none">
			<?php
			if ( is_customize_preview() ) {
				dynamic_sidebar( 'sidebar-top-bar' );
				dynamic_sidebar( 'header-sidebar' );
				dynamic_sidebar( 'subscribe-widgets' );
			}
			?>
		</div>
		<?php
	}
endif;
add_action( 'hestia_do_footer', 'hestia_hidden_sidebars' );

/**
 * Changing Pirate Forms output.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
add_filter(
	'pirate_forms_public_controls', function ( $elements ) {

		foreach ( $elements as $key => $element ) {
			// Name field
			if ( $element['id'] === 'pirate-forms-contact-name' ) {
				$elements[ $key ]['wrap']['class']  = 'col-xs-12 col-sm-6 contact_name_wrap pirate_forms_three_inputs form_field_wrap';
				$elements[ $key ]['label']['html']  = $elements[ $key ]['placeholder'];
				$elements[ $key ]['label']['class'] = 'control-label';
				$elements[ $key ]['placeholder']    = '';
			}

			// E-mail field
			if ( $element['id'] === 'pirate-forms-contact-email' ) {
				$elements[ $key ]['wrap']['class']  = 'col-xs-12 col-sm-6 contact_email_wrap pirate_forms_three_inputs form_field_wrap';
				$elements[ $key ]['label']['html']  = $elements[ $key ]['placeholder'];
				$elements[ $key ]['label']['class'] = 'control-label';
				$elements[ $key ]['placeholder']    = '';
			}

			// Subject field
			if ( $element['id'] === 'pirate-forms-contact-subject' ) {
				$elements[ $key ]['wrap']['class']  = 'col-xs-12 contact_subject_wrap pirate_forms_three_inputs form_field_wrap';
				$elements[ $key ]['label']['html']  = $elements[ $key ]['placeholder'];
				$elements[ $key ]['label']['class'] = 'control-label';
				$elements[ $key ]['placeholder']    = '';
			}

			// Message field
			if ( $element['id'] === 'pirate-forms-contact-message' ) {
				$elements[ $key ]['wrap']['class']  = 'col-xs-12 form_field_wrap contact_message_wrap';
				$elements[ $key ]['label']['html']  = $elements[ $key ]['placeholder'];
				$elements[ $key ]['label']['class'] = 'control-label';
				$elements[ $key ]['placeholder']    = '';
			}
		}

		return $elements;
	}, 20
);

if ( ! function_exists( 'hestia_scroll_to_top' ) ) :
	/**
	 * Display scroll to top button.
	 *
	 * @since 1.1.54
	 */
	function hestia_scroll_to_top() {
		$hestia_enable_scroll_to_top = get_theme_mod( 'hestia_enable_scroll_to_top' );
		if ( empty( $hestia_enable_scroll_to_top ) ) {
			return;
		}
		?>
		<button class="hestia-scroll-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</button>
		<?php
	}

	add_action( 'wp_footer', 'hestia_scroll_to_top' );
endif;

/**
 * After changing the controls (alternative blog layout and footer alternative style) from checkbox which returns true
 * or false to radio control, we need to update them to the new values.
 *
 * @since 1.1.59
 */
function hestia_migrate_checkboxes_to_radio_images() {

	$execute = get_option( 'hestia_sync_checkboxes_to_radio_once' );
	if ( $execute !== false ) {
		return;
	}
	/**
	 * If the control was checked we update it to blog_alternative_layout else to blog_normal_layout
	 */
	$hestia_alternative_blog_layout = get_theme_mod( 'hestia_alternative_blog_layout' );
	if ( $hestia_alternative_blog_layout === true ) {
		set_theme_mod( 'hestia_alternative_blog_layout', 'blog_alternative_layout' );
	} elseif ( $hestia_alternative_blog_layout === false ) {
		set_theme_mod( 'hestia_alternative_blog_layout', 'blog_normal_layout' );
	}

	/**
	 * If the control was checked we update it to white_footer else to black_footer
	 */
	$hestia_alternative_footer_style = get_theme_mod( 'hestia_alternative_footer_style' );
	if ( $hestia_alternative_footer_style === true ) {
		set_theme_mod( 'hestia_alternative_footer_style', 'white_footer' );
	} elseif ( $hestia_alternative_blog_layout === false ) {
		set_theme_mod( 'hestia_alternative_footer_style', 'black_footer' );
	}

	update_option( 'hestia_sync_checkboxes_to_radio_once', true );
}
add_action( 'after_setup_theme', 'hestia_migrate_checkboxes_to_radio_images' );

/**
 * Display page header.
 */
function hestia_display_page_header() {

?>
	<div id="primary" class="<?php echo hestia_boxed_layout_header(); ?> page-header header-small">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<h1 class="hestia-title"><?php single_post_title(); ?></h1>
				</div>
			</div>
		</div>
		<?php hestia_output_wrapper_header_background( false ); ?>
	</div>
	<?php
}

/**
 * Display pagination on single page and single portfolio.
 */
function hestia_single_pagination() {

?>
	<div class="section section-blog-info">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="row">
					<div class="col-md-12">
						<?php
						hestia_wp_link_pages(
							array(
								'before'      => '<div class="text-center"> <ul class="nav pagination pagination-primary">',
								'after'       => '</ul> </div>',
								'link_before' => '<li>',
								'link_after'  => '</li>',
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
