<?php
/**
 * Customizer Control: Hestia_Customizer_Heading.
 *
 * @since 1.1.56
 * @package hestia
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Heading control
 */
class Hestia_Customizer_Heading extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'hestia-heading';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_style( 'hestia-heading', get_template_directory_uri() . '/inc/customizer-heading/css/heading.css', null, HESTIA_VERSION );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<h4 class="hestia-customizer-heading">{{{ data.label }}}</h4>
		<?php
	}
}
