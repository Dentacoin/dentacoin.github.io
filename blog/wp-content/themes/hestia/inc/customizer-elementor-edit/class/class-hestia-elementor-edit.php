<?php
/**
 * This class allows developers to display a button in customizer that links to Elementor live edit if the page
 * that is set as frontpage was previously edited with Elementor. This control replace the text editor control
 * if the page was edited with Elementor.
 *
 * @package Hestia
 */

/**
 * Class Hestia_Elementor_Edit
 *
 * @since  1.1.60
 * @access public
 */
class Hestia_Elementor_Edit extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.1.60
	 * @access public
	 * @var    string
	 */
	public $type = 'elementor-edit';

	/**
	 * The post id of the page that is set as frontpage.
	 *
	 * @since  1.1.60
	 * @access public
	 * @var    string
	 */
	public $pid = '';

	/**
	 * Hestia_Elementor_Edit constructor.
	 *
	 * @param WP_Customize_Manager $manager Customize manager object.
	 * @param string               $id Control id.
	 * @param array                $args Control arguments.
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$frontpage_id = get_option( 'page_on_front' );
		if ( ! empty( $frontpage_id ) ) {
			$this->pid = $frontpage_id;
		}
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.1.60
	 * @access public
	 * @return array
	 */
	public function json() {
		$json = parent::json();
		if ( class_exists( '\Elementor\Utils' ) ) {
			$json['edit_link'] = \Elementor\Utils::get_edit_link( $this->pid );
		}
		return $json;
	}

	/**
	 * Don't render the content via PHP.  This control is handled with a JS template.
	 *
	 * @since  1.1.60
	 * @access public
	 * @return void
	 */
	protected function render_content() {}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.1.60
	 * @access public
	 * @return void
	 */
	public function content_template() {
	?>

		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<# if ( data.edit_link ) { #>
				<a href="{{ data.edit_link}}"><div id="elementor-editor-button" class="button button-primary">
						<i class="eicon-elementor" aria-hidden="true"></i>
						Edit with Elementor				</div></a>
			<# } #>
		</label>
		<?php
	}

}
