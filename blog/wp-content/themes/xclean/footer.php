<?php
/**
 *
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after
 *
 */
?>
	</div><!-- End #content .site-content -->
	<footer class="footer">
		
		<div class="footer-main">
			<div class="container">
				<div class="row">

						<div class="col-md-4">

							<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>

								<?php dynamic_sidebar( 'First-footer Widget Area' ); ?>

							<?php  endif; ?> 

						</div><!-- End .col-md-4 -->

					<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
						<div class="col-md-8">
							<?php dynamic_sidebar( 'Second-footer Widget Area' ); ?> 
						</div><!-- End .col-md-8 -->
					<?php endif; ?>

				</div><!-- End .row -->

				<?php 
					if ( is_active_sidebar( 'footer-sidebar-3' ) ) {
						dynamic_sidebar( 'Full-width-footer Widget Area' );
					}
				?>

			</div><!-- End .container -->
		</div><!-- End .footer-main -->	
		

		<div class="footer-copyright">
			<div class="container">
				<div class="row">
					<div class="col-md-6">

						<?php 
							if ( is_active_sidebar( 'copyright-sidebar-1' ) ) { 
							 	dynamic_sidebar( 'First-copyright Widget Area' ); 
							}
						?> 

					</div><!-- End .col-md-6 -->

						<?php if ( is_active_sidebar( 'copyright-sidebar-2' ) ) : ?>
							<div class="col-md-6">
								<?php dynamic_sidebar( 'Second-copyright Widget Area' ); ?> 
							</div><!-- End .col-md-6 -->
						<?php endif; ?>

				</div><!-- End .row -->

				<?php 
					if ( is_active_sidebar( 'copyright-sidebar-3' ) ) {
						dynamic_sidebar( 'Full-width-copyright Widget Area' );
					}
				?>

			</div><!-- End .container -->
		</div><!-- End .footer-copyright -->
		
	</footer><!-- End .footer -->
</div><!-- End .wrapper -->
<?php wp_footer(); ?>
</body>
</html>