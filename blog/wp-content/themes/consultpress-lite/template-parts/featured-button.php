<?php
/**
 * Featured Button
 *
 * @package consultpresslite-pt
 */

$featured_page_data = ConsultPressLiteHelpers::get_featured_page_data();

?>

<?php if ( ! empty( $featured_page_data ) ) : ?>
	<a class="btn  btn-primary  btn-block  btn-featured  hidden-md-down" href="<?php echo esc_url( $featured_page_data['url'] ); ?>" target="<?php echo esc_attr( $featured_page_data['target'] ); ?>"><?php echo esc_html( $featured_page_data['title'] ); ?></a>
<?php endif; ?>
