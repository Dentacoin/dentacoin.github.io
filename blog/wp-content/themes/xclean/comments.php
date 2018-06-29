<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 *
 */
?>

<?php
	// Prevent the direct loading of comments.php.
	if ( ! empty( $_SERVER['SCRIPT-FILENAME'] ) && basename( $_SERVER['SCRIPT-FILENAME'] ) == 'comments.php' ) {
		die( esc_html__( 'you can not access to this page', 'xclean' ) );
	}
?>

<?php if ( post_password_required() ) : ?>
	<p class="message password-protected">
		<?php
			esc_html_e( 'This post is password protected. Enter the password to view the comments.', 'xclean' );
			return;
		?>
	</p><!-- End .message .password-protected -->
<?php endif ?>

<div id='comments' class="comments-area single-comments">
	<?php if ( have_comments() ) : ?>

		<div class="comment-heading">
			<h2 class="standart-comment-heading"><?php esc_html( printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comment title', 'xclean' ), number_format_i18n( get_comments_number() ) ) );?></h2>
		</div><!-- End .comment-heading -->

		<div class="comments">
			<ul class="single-comment">
				<?php
					$args = array(
								'reply_text'  => esc_html__( 'Reply to comment', 'xclean' ),
								'avatar_size' => 80,
							); 
				?>

				<?php wp_list_comments( $args ); ?>
			</ul><!-- End .single-comment -->

			<div class="pagination">
				<?php
					$args = array(
							'prev_text' => '<i class="fa fa-angle-left"></i>', 
							'next_text' => '<i class="fa fa-angle-right"></i>'
						);
				?>
					<?php paginate_comments_links( $args ); ?>
			</div><!-- End .pagination -->
		</div><!-- End .comments -->

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed', 'xclean' ) ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- End #comments .comment area -->