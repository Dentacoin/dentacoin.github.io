<?php
/**
 * Customizer info main class.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Pro customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Hestia_Customizer_Info extends WP_Customize_Section {

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'customizer-info';

	/**
	 * Label text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $section_text = '';

	/**
	 * Plugin slug for which to create install button.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $slug = '';

	/**
	 * Hide notice.
	 *
	 * @since  1.1.34
	 * @access public
	 * @var    string
	 */
	public $hide_notice = false;

	/**
	 * Screen reader text on dismiss button.
	 *
	 * @since  1.1.34
	 * @access public
	 * @var    string
	 */
	public $button_screenreader = '';

	/**
	 * Enqueue function.
	 */
	public function enqueue() {
		Hestia_Plugin_Install_Helper::instance()->enqueue_scripts();
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function json() {
		$json                          = parent::json();
		$json['section_text']          = $this->section_text;
		$json['hide_notice']           = $this->hide_notice;
		$json['button_screenreader']   = $this->button_screenreader;
		$json['plugin_install_button'] = $this->create_plugin_install_button( $this->slug );
		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() {
	?>
		<# if ( !data.hide_notice ) { #>
			<li id="accordion-section-{{ data.id }}" class="hestia-notice accordion-section control-section control-section-{{ data.type }} cannot-expand">
				<button type="button" class="notice-dismiss" style="z-index: 1;">
						<span class="screen-reader-text">
							<# if ( data.section_text ) { #>
								{{data.$button_screenreader}}
							<# } #>
						</span>
				</button>
				<h4 class="accordion-section-title" style="padding-right: 36px">
					<# if ( data.section_text ) { #>
						{{{data.section_text}}}
					<# } #>
					<# if ( data.plugin_install_button ) { #>
						{{{data.plugin_install_button}}}
					<# } #>
				</h4>

			</li>
		<# } #>
		<?php
	}

	/**
	 * Check plugin state.
	 *
	 * @param string $slug plugin slug.
	 *
	 * @return bool
	 */
	public function create_plugin_install_button( $slug ) {
		return Hestia_Plugin_Install_Helper::instance()->get_button_html( $slug );
	}
}
