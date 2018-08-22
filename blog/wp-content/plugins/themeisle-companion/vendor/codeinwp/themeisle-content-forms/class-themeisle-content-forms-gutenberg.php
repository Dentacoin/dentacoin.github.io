<?php

namespace ThemeIsle\ContentForms;


/**
 * This class is used to create a Gutenberg block based on a ContentForms config
 * Class ContentFormsGutenbergModule
 * @TODO This is a work in progress and for now we will start from the basisc example of a Gutenberg block.
 */
class GutenbergModule {

	private $name;

	private $form_type;

	private $title;

	private $icon;

	private $forms_config = array();

	public function __construct( $data ) {

		$this->setup_attributes( $data );
		$this->gutenberg_register_attributes();
		add_action( 'enqueue_block_editor_assets', array( $this, 'gutenberg_enqueue_block_editor_assets' ) );
	}

	/**
	 * This method takes the given attributes and sets them as properties
	 *
	 * @param $data array
	 */
	private function setup_attributes( $data ) {
		$this->form_type = $data['type'];

		if ( ! empty( $data['content_forms_config'] ) ) {
			$this->forms_config = $data['content_forms_config'];
		} else {
			$this->forms_config = apply_filters( 'content_forms_config_for_' . $this->form_type, $this->forms_config );
		}

		if ( ! empty( $data['id'] ) ) {
			$this->set_name( $data['id'] );
		}

		if ( ! empty( $this->forms_config['title'] ) ) {
			$this->set_title( $this->forms_config['title'] );
		}

		if ( ! empty( $this->forms_config['icon'] ) ) {
			$this->set_icon( $this->forms_config['icon'] );
		}
	}

	/**
	 * Load our block generator once but for each type of form we need to localize the config
	 */
	function gutenberg_enqueue_block_editor_assets() {

		if ( ! wp_script_is( 'gutenberg-content-forms' ) ) {

			wp_enqueue_script(
				'gutenberg-content-forms',
				plugins_url( './assets/gutenberg-esnext/block.build.js', __FILE__ ),
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'underscore' ),
				filemtime( plugin_dir_path( __FILE__ ) . './assets/gutenberg-esnext/block.build.js' )
			);
		}

		wp_localize_script(
			'gutenberg-content-forms',
			'content_forms_config_for_' . $this->form_type,
			$this->forms_config
		);
	}

	function gutenberg_enqueue_block_assets() {
		wp_enqueue_style(
			'gutenberg-examples-05',
			plugins_url( 'style.css', __FILE__ ),
			array( 'wp-blocks' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
		);
	}

	function render_block( $attributes, $content ) {
		$form_content = '';
		$uid          = $attributes['uid'];
		$fields       = $attributes['fields'];
		wp_enqueue_script( 'content-forms' );

		$form_header = $this->render_form_header( $uid );
		$form_footer = $this->render_form_footer();


		$btn_label = esc_html__( 'Submit', 'themeisle-companion' );
		ob_start();
		if ( ! empty( $attributes['submit_label'] ) ) {
			$btn_label = $attributes['submit_label'];
		} ?>
		<fieldset>
			<button type="submit" name="submit" value="submit-<?php echo $this->getFormType(); ?>-<?php echo $uid; ?>">
				<?php echo $btn_label; ?>
			</button>
		</fieldset>
		<?php

		$form_submit = ob_get_clean();

		foreach ( $fields as $key => $field ) {
			ob_start(); ?>
			<fields>
				<label for="<?php echo $key; ?>"><?php echo $field['label']; ?></label>
				<input type="text" name="<?php echo $key; ?>">
			</fields>
			<?php
			$form_content .= ob_get_clean();
		}

		$block_content = sprintf(
			'<div class="content-form-fields" data-uid="%1$s">
<h3>%1$s</h3>
%2$s
%3$s
%4$s
%5$s
</div>',
			$uid,
			$form_header,
			$form_content,
			$form_submit,
			$form_footer
		);

		return $block_content;
	}

	public function render_form_header( $id ) {
		// create an url for the form's action
		$url = admin_url( 'admin-post.php' );

		ob_start();

		echo '<form action="' . esc_url( $url ) . '" method="post" name="content-form-' . $id . '" id="content-form-' . $id . '" class="content-form content-form-' . $this->getFormType() . ' ' . $this->get_name() . '">';

		wp_nonce_field( 'content-form-' . $id, '_wpnonce_' . $this->getFormType() );

		echo '<input type="hidden" name="action" value="content_form_submit" />';
		// there could be also the possibility to submit by type
		// echo '<input type="hidden" name="action" value="content_form_{type}_submit" />';
		echo '<input type="hidden" name="form-type" value="' . $this->getFormType() . '" />';
		echo '<input type="hidden" name="form-builder" value="gutenberg" />';
		echo '<input type="hidden" name="post-id" value="' . get_the_ID() . '" />';
		echo '<input type="hidden" name="form-id" value="' . $id . '" />';

		return ob_get_clean();
	}

	public function render_form_footer() {
		return '</form>';
	}

	function gutenberg_register_attributes() {
		$gutenberg_args = array(
			'attributes'      => array(
				'uid'    => array(
					'type'      => 'string',
					'selector'  => '.content-form-fields',
					'source'    => 'attribute',
					'attribute' => 'data-uid'
				),
				'fields' => array(
					'type'     => 'array',
					'source'   => 'query',
					'selector' => '.content-form-field-label',
					'query'    => array(
						'field_id'    => array(
							'type'      => 'string',
							'source'    => 'attribute',
							'attribute' => 'data-field_id'
						),
						'label'       => array(
							'type'      => 'string',
							'source'    => 'attribute',
							'attribute' => 'data-label'
						),
						'requirement' => array(
							'type'      => 'string',
							'source'    => 'attribute',
							'attribute' => 'data-requirement'
						),
						'type'        => array(
							'type'      => 'string',
							'source'    => 'attribute',
							'attribute' => 'data-field_type'
						),
					),
					'default'  => array(),
				),
			),
			'render_callback' => array( $this, 'render_block' ),
		);

		// Create form settings
		foreach ( $this->forms_config['controls'] as $name => $control ) {
			$gutenberg_args['attributes'][ $name ] = array(
				'type'    => 'string',
				'default' => isset( $control['default'] ) ? $control['default'] : '',
			);
		}

		foreach ( $this->forms_config['fields'] as $name => $field ) {
			$gutenberg_args['attributes']['fields']['default'][ $name ] = array(
				'field_id'    => $name,
				'label'       => $field['label'],
				'type'        => $field['type'],
				'requirement' => ( $field['require'] === 'required' ) ? 'true' : 'false',
			);
		}

		register_block_type( 'content-forms/' . $this->form_type, $gutenberg_args );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set the widget name property
	 */
	private function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Set the widget title property
	 */
	private function set_title( $title ) {
		$this->title = $title;
	}

	/**
	 * Retrieve content form widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return $this->icon;
	}

	/**
	 * Set the widget title property
	 */
	private function set_icon( $icon ) {
		$this->icon = $icon;
	}

	private function getFormType() {
		return $this->form_type;
	}
}