<?php

namespace ThemeIsle\ContentForms;

/**
 * This class is used to create an Beaver module based on a ContentForms config
 * Class BeaverModule
 * @package ThemeIsle\ContentForms
 */
abstract class BeaverModule extends \FLBuilderModule {

	public $name;

	protected $title;

	public $icon;

	protected $forms_config = array();

	public function __construct( $data ) {

		$this->setup_attributes();

		parent::__construct( $data );

		wp_enqueue_script( 'content-forms' );
		wp_enqueue_style( 'content-forms' );
	}

	public function register_widget() {
		$fields = array();

		foreach ( $this->forms_config['fields'] as $key => $field ) {
			$fields[] = array(
				'key'      => $key,
				'label'    => isset( $field['default'] ) ? $field['default'] : '',
				'type'     => $field['type'],
				'required' => $field['require'],
			);
		}

		$controls = array();

		if ( ! empty( $this->forms_config['controls'] ) ) {
			foreach ( $this->forms_config['controls'] as $key => $control ) {
				$control_settings = array(
					'type'        => $control['type'],
					'label'       => $control['label'],
					'description' => isset( $control['description'] ) ? $control['description'] : '',
					'default'     => isset( $control['default'] ) ? $control['default'] : '',
				);

				if ( isset( $control['options'] ) ) {
					$control_settings['options'] = $control['options'];
				}

				$controls[ $key ] = $control_settings;
			}
		}

		$args = array(
			'general' => array( // Tab
				'title'       => $this->get_title(),
				'description' => isset( $this->forms_config['description'] ) ? $this->forms_config['description'] : '',
				'sections'    => array(),
			)
		);

		// is important to keep the order of fields from the main config
		foreach ( $this->forms_config as $key => $val ) {
			if ( 'fields' === $key ) {
				$args['general']['sections']['settings'] = array(
					'title'  => esc_html__( 'Fields', 'themeisle-companion' ),
					'fields' => array(
						'fields' => array(
							'multiple'     => true,
							'type'         => 'form',
							'label'        => esc_html__( 'Field', 'themeisle-companion' ),
							'form'         => 'field',
							'preview_text' => 'label',
							'default'      => $fields
						),
					),
				);
				continue;
			} elseif ( 'controls' === $key ) {
				$args['general']['sections']['controls'] = array(
					'title'  => esc_html__( 'Form Settings', 'themeisle-companion' ),
					'fields' => $controls
				);
			}
		}

		\FLBuilder::register_module( get_called_class(), $args );

		\FLBuilder::register_settings_form(
			'field', array(
				'title' => esc_html__( 'Field', 'themeisle-companion' ),
				'tabs'  => array(
					'general' => array(
						'title'    => esc_html__( 'Field', 'themeisle-companion' ),
						'sections' => array(
							'fields' => array(
								'title'  => esc_html__( 'Field', 'themeisle-companion' ),
								'fields' => array(
									'label'    => array(
										'type'  => 'text',
										'label' => esc_html__( 'Label', 'themeisle-companion' ),
									),
									'type'     => array(
										'type'    => 'select',
										'label'   => esc_html__( 'Type', 'themeisle-companion' ),
										'options' => array(
											'text'     => esc_html__( 'Text', 'themeisle-companion' ),
											'email'     => esc_html__( 'Email', 'themeisle-companion' ),
											'textarea' => esc_html__( 'Textarea', 'themeisle-companion' ),
											'password' => esc_html__( 'Password', 'themeisle-companion' ),
										)
									),
									'required' => array(
										'type'    => 'select',
										'label'   => esc_html__( 'Is required?', 'themeisle-companion' ),
										'options' => array(
											'required' => esc_html__( 'Required', 'themeisle-companion' ),
											'optional' => esc_html__( 'Optional', 'themeisle-companion' )
										)
									)
								),
							),
						),
					),
				),
			)
		);
	}

	/**
	 * This method takes the given attributes and sets them as properties
	 *
	 * @param $data array
	 */
	public function setup_attributes( $data = array() ) {

		if ( ! empty( $data['content_forms_config'] ) ) {
			$this->forms_config = $data['content_forms_config'];
		} else {
			$this->forms_config = apply_filters( 'content_forms_config_for_' . $this->get_type(), $this->forms_config );
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
	 * Each inherited class will need to define it's type be returning it trough this method
	 * @return mixed
	 */
	abstract public function get_type();

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
	 *
	 * @param $name
	 */
	protected function set_name( $name ) {
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
	protected function set_title( $title ) {
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
//	public function get_icon() {
//		return $this->icon;
//	}

	/**
	 * Set the widget title property
	 */
	protected function set_icon( $icon ) {
		$this->icon = $icon;
	}

	/** == Render functions == */

	/**
	 * Render the header of the form based on the block id(for JS identification)
	 *
	 * @param $id
	 */
	public function render_form_header( $id ) {
		$url = admin_url( 'admin-post.php' );
		echo '<form action="' . esc_url( $url ) . '" method="post" name="content-form-' . $id . '" id="content-form-' . $id . '" class="content-form content-form-' . $this->get_type() . '">';

		wp_nonce_field( 'content-form-' . $id, '_wpnonce_' . $this->get_type() );

		echo '<input type="hidden" name="action" value="content_form_submit" />';
		// there could be also the possibility to submit by type
		// echo '<input type="hidden" name="action" value="content_form_{type}_submit" />';
		echo '<input type="hidden" name="form-type" value="' . $this->get_type() . '" />';
		echo '<input type="hidden" name="form-builder" value="beaver" />';
		echo '<input type="hidden" name="post-id" value="' . get_the_ID() . '" />';
		echo '<input type="hidden" name="form-id" value="' . $id . '" />';
	}

	public function render_form_field( $field ) {
		$key      = ! empty( $field['key'] ) ? $field['key'] : sanitize_title( $field['label'] );
		$required = '';
		$form_id  = $this->node;


		if ( $field['required'] === 'required' ) {
			$required = 'required="required"';
		}

		$field_name = 'data[' . $form_id . '][' . $key . ']'; ?>
		<fieldset class="content-form-field-<?php echo $field['type'] ?>">

			<label for="<?php echo $field_name ?>">
				<?php echo $field['label']; ?>
			</label>

			<?php
			switch ( $field['type'] ) {
				case 'textarea': ?>
					<textarea name="<?php echo $field_name ?>" id="<?php echo $field_name ?>"
						<?php echo $required; ?>
						      cols="30" rows="5"></textarea>
					<?php break;
				case 'password': ?>
					<input type="password" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>"
						<?php echo $required; ?>>
					<?php break;
				default: ?>
					<input type="text" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>"
						<?php echo $required; ?>>
					<?php
					break;
			} ?>
		</fieldset>
		<?php
	}

	public function render_form_footer() {
		echo '</form>';
	}

	/**
	 * Retrieve a setting value for a given key
	 *
	 * @param $key
	 *
	 * @return bool|mixed
	 */
	public function get_setting( $key ) {
		if ( ! empty( $this->settings->{$key} ) ) {
			return $this->settings->{$key};
		}

		return false;
	}
}