<?php
/**
 *
 * The default template for displaying post's with link post format .
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- End .entry-content -->
</article><!-- End #post-## -->