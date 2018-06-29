<?php
/**
 * Footer
 *
 * @package consultpresslite-pt
 */

$consultpress_footer_bottom_txt = get_theme_mod( 'footer_bottom_txt', sprintf(
	esc_html__( '%1$sConsultPress%2$s - WordPress theme made by ProteusThemes.' , 'consultpress-lite' ),
	'<b><a href="https://www.proteusthemes.com/wordpress-themes/consultpress-lite/">',
	'</a></b>'
) );

?>

	<footer class="footer__container">
		<div class="container">
			<div class="footer">
				<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
					<div class="footer-top">
						<div class="row">
							<?php dynamic_sidebar( 'footer-widgets' ); ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="footer-bottom">
					<div class="footer-bottom__text">
						<?php echo wp_kses_post( $consultpress_footer_bottom_txt ); ?>
					</div>
					<a class="footer-bottom__back-to-top  js-back-to-top" href="#"><span class="hidden-lg-up"><?php esc_html_e( 'Back to Top', 'consultpress-lite' ); ?></span> <i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</footer>
	</div><!-- end of .boxed-container -->

	<?php wp_footer(); ?>
	</body>
</html>
