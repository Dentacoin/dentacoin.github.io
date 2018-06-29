<?php

namespace ThemeIsle\ContentForms;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * This class is used to create an Elementor widget based on a ContentForms config.
 * @package ThemeIsle\ContentForms
 */
class ElementorWidget extends \Elementor\Widget_Base {

	private $name;

	private $title;

	private $icon;

	private $form_type;

	private $forms_config = array();

	/**
	 * Widget base constructor.
	 *
	 * Initializing the widget base class.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $data Widget data. Default is an empty array.
	 * @param array|null $args Optional. Widget default arguments. Default is null.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		$this->setup_attributes( $data );
	}

	/**
	 * This method takes the given attributes and sets them as properties
	 *
	 * @param $data array
	 */
	private function setup_attributes( $data ) {

		$this->setFormType();

		if ( ! empty( $data['content_forms_config'] ) ) {
			$this->setFormConfig( $data['content_forms_config'] );
		} else {
			$this->setFormConfig( apply_filters( 'content_forms_config_for_' . $this->getFormType(), $this->getFormConfig() ) );
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
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		// first we need to make sure that we have some fields to build on
		if ( empty( $this->forms_config['fields'] ) ) {
			return;
		}

		// is important to keep the order of fields from the main config
		foreach ( $this->forms_config as $key => $val ) {
			if ( 'fields' === $key ) {
				$this->_register_fields_controls();
				continue;
			} elseif ( 'controls' === $key ) {
				$this->_register_settings_controls();
			}
		}

	}

	protected function _register_settings_controls() {
		$this->start_controls_section(
			'section_form_settings',
			array(
				'label' => __( 'Form Settings', 'themeisle-companion' ),
			)
		);

		$controls = $this->forms_config['controls'];

		foreach ( $controls as $control_name => $control ) {

			$control_args = array(
				'label'   => $control['label'],
				'type'    => $control['type'],
				'default' => isset( $control['default'] ) ? $control['default'] : '',
			);

			if ( isset( $control['options'] ) ) {
				$control_args['options'] = $control['options'];
			}

			$this->add_control(
				$control_name,
				$control_args
			);
		}

		$this->end_controls_section();
	}

	protected function _register_fields_controls() {

		$this->start_controls_section(
			$this->form_type . '_form_fields',
			array( 'label' => __( 'Fields', 'themeisle-companion' ) )
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'themeisle-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'placeholder',
			array(
				'label'   => __( 'Placeholder', 'themeisle-companion' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'requirement',
			array(
				'label'   => __( 'Requirement', 'themeisle-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'required' => esc_html__( 'Required', 'themeisle-companion' ),
					'optional' => esc_html__( 'Optional', 'themeisle-companion' )
				),
				'default' => 'optional',
			)
		);

		$field_types = array(
			'text'     => __( 'Text', 'themeisle-companion' ),
			'password' => __( 'Password', 'themeisle-companion' ),
//			'tel'      => __( 'Tel', 'textdomain' ),
			'email'    => __( 'Email', 'themeisle-companion' ),
			'textarea' => __( 'Textarea', 'themeisle-companion' ),
//			'number'   => __( 'Number', 'textdomain' ),
//			'select'   => __( 'Select', 'textdomain' ),
//			'url'      => __( 'URL', 'textdomain' ),
		);

		$repeater->add_control(
			'type',
			array(
				'label'   => __( 'Type', 'themeisle-companion' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $field_types,
				'default' => 'text'
			)
		);

		$repeater->add_control(
			'key',
			array(
				'label' => __( 'Key', 'themeisle-companion' ),
				'type'  => \Elementor\Controls_Manager::HIDDEN
			)
		);

		$fields = $this->forms_config['fields'];

		$default_fields = array();

		foreach ( $fields as $field_name => $field ) {
			$default_fields[] = array(
				'key'         => $field_name,
				'type'        => $field['type'],
				'label'       => $field['label'],
				'requirement' => $field['require'],
				'placeholder' => isset( $field['placeholder'] ) ? $field['placeholder'] : $field['label'],
				'width'       => '100',
			);
		}

		$this->add_control(
			'form_fields',
			array(
				'label'       => __( 'Form Fields', 'themeisle-companion' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'show_label'  => false,
				'separator'   => 'before',
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => $default_fields,
				'title_field' => '{{{ label }}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render content form widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render( $instance = array() ) {
		$form_id  = $this->get_data( 'id' );
		$settings = $this->get_settings();

		$this->maybe_load_widget_style();

		if ( empty( $this->forms_config['fields'] ) ) {
			return;
		}

		$fields = $settings['form_fields'];

		$controls = $this->forms_config['controls'];

		foreach ( $controls as $control_name => $control ) {
			$control_value = '';

			if ( isset( $settings[ $control_name ] ) ) {
				$control_value = $settings[ $control_name ];
			}
			if ( isset( $control['required'] ) && $control['required'] && empty( $control_value ) ) { ?>
				<div class="content-forms-required">
					<?php
					printf(
						esc_html__( 'The %s setting is required!', 'themeisle-companion' ),
						'<strong>' . $control['label'] . '</strong>'
					); ?>
				</div>
				<?php
			}
		}

		$this->render_form_header( $form_id );

		foreach ( $fields as $index => $field ) {
			$this->render_form_field( $field );
		}

		$btn_label = esc_html__( 'Submit', 'themeisle-companion' );

		if ( ! empty( $controls['submit_label'] ) ) {
			$btn_label = $this->get_settings( 'submit_label' );
		} ?>
		<fieldset>
			<button type="submit" name="submit" value="submit-<?php echo $this->form_type; ?>-<?php echo $form_id; ?>">
				<?php echo $btn_label; ?>
			</button>
		</fieldset>
		<?php

		$this->render_form_footer();
	}

	/**
	 * Either enqueue the widget style registered by the library
	 * or load an inline version for the preview only
	 */
	protected function maybe_load_widget_style() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() === true && apply_filters( 'themeisle_content_forms_register_default_style', true ) ) { ?>
			<style>
				<?php echo file_get_contents( plugin_dir_path( __FILE__ ) . '/assets/content-forms.css' ) ?>
			</style>
			<?php
		} else {
			// if `themeisle_content_forms_register_default_style` is false, the style won't be registered anyway
			wp_enqueue_script( 'content-forms' );
			wp_enqueue_style( 'content-forms' );
		}
	}

	/**
	 * Display method for the form's header
	 * It is also takes care about the form attributes and the regular hidden fields
	 *
	 * @param $id
	 */
	private function render_form_header( $id ) {
		// create an url for the form's action
		$url = admin_url( 'admin-post.php' );

		echo '<form action="' . esc_url( $url ) . '" method="post" name="content-form-' . $id . '" id="content-form-' . $id . '" class="content-form content-form-' . $this->getFormType() . ' ' . $this->get_name() . '">';

		wp_nonce_field( 'content-form-' . $id, '_wpnonce_' . $this->getFormType() );

		echo '<input type="hidden" name="action" value="content_form_submit" />';
		// there could be also the possibility to submit by type
		// echo '<input type="hidden" name="action" value="content_form_{type}_submit" />';
		echo '<input type="hidden" name="form-type" value="' . $this->getFormType() . '" />';
		echo '<input type="hidden" name="form-builder" value="elementor" />';
		echo '<input type="hidden" name="post-id" value="' . get_the_ID() . '" />';
		echo '<input type="hidden" name="form-id" value="' . $id . '" />';
	}

	/**
	 * Display method for the form's footer
	 */
	private function render_form_footer() {
		echo '</form>';
	}

	/**
	 * Print the output of an individual field
	 *
	 * @param $field
	 * @param bool $is_preview
	 */
	private function render_form_field( $field, $is_preview = false ) {
		$item_index = $field['_id'];
		$key        = ! empty( $field['key'] ) ? $field['key'] : sanitize_title( $field['label'] );
		$placeholder        = ! empty( $field['placeholder'] ) ? $field['placeholder'] : '';

		$required   = '';
		$form_id    = $this->get_data( 'id' );

		if ( $field['requirement'] === 'required' ) {
			$required = 'required="required"';
		}

//		 in case this is a preview, we need to disable the actual inputs and transform the labels in inputs
		$disabled = '';
		if ( $is_preview ) {
			$disabled = 'disabled="disabled"';
		}

		$field_name = 'data[' . $form_id . '][' . $key . ']';

		$this->add_inline_editing_attributes( $item_index . '_label', 'none' ); ?>
		<fieldset class="content-form-field-<?php echo $field['type'] ?>"
			<?php echo $this->get_render_attribute_string( 'fieldset' . $item_index ); ?> >

			<label for="<?php echo $field_name ?>"
				<?php echo $this->get_render_attribute_string( 'label' . $item_index ); ?>>
				<?php echo $field['label']; ?>
			</label>

			<?php
			switch ( $field['type'] ) {
				case 'textarea': ?>
					<textarea name="<?php echo $field_name ?>" id="<?php echo $field_name ?>"
						<?php echo $disabled; ?>
						<?php echo $required; ?>
                        placeholder="<?php echo esc_attr ( $placeholder ); ?>"
						      cols="30" rows="5"></textarea>
					<?php break;
				case 'password': ?>
					<input type="password" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>"
						<?php echo $required; ?> <?php echo $disabled; ?>>
					<?php break;
				default: ?>
					<input type="text" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>"
						<?php echo $required; ?> <?php echo $disabled; ?> placeholder="<?php echo esc_attr ( $placeholder ); ?>">
					<?php
					break;
			} ?>
		</fieldset>
		<?php
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

	private function setFormType() {
		$this->form_type = $this->get_data( 'widgetType' );

		if ( empty( $this->form_type ) ) {
			$this->form_type = $this->get_data( 'id' );
		}

		$this->form_type = str_replace( 'content_form_', '', $this->form_type );
	}

	private function setFormConfig( $config ) {
		$this->forms_config = $config;
	}

	private function getFormConfig( $field = null ) {

		if ( isset( $field ) ) {

			if ( isset( $this->forms_config[ $field ] ) ) {
				return $this->forms_config[ $field ];
			}

			return false;
		}

		return $this->forms_config;
	}

	private function getFormType() {
		return $this->form_type;
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

	/**
	 * Widget Category.
	 *
	 * @return array
	 */
	public function get_categories() {
		$category_args = apply_filters( 'content_forms_category_args', array() );
		$slug = isset( $category_args['slug'] ) ?  $category_args['slug'] : 'obfx-elementor-widgets';
		return [ $slug ];
	}

	/**
	 * Extract widget settings based on a widget id and a page id
	 *
	 * @param $post_id
	 * @param $widget_id
	 *
	 * @return bool
	 */
	static function get_widget_settings( $widget_id, $post_id ) {

		$el_data = \Elementor\Plugin::$instance->db->get_plain_editor( $post_id );
		$el_data = apply_filters( 'elementor/frontend/builder_content_data', $el_data, $post_id );

		if ( ! empty( $el_data ) ) {
			return self::get_widget_data_by_id( $widget_id, $el_data );
		}

		return $el_data;
	}

	/**
	 * Recursively look through Elementor data and extract the settings for a specific
	 *
	 * @param $widget_id
	 * @param $el_data
	 *
	 * @return bool
	 */
	static function get_widget_data_by_id( $widget_id, $el_data ) {

		if ( ! empty( $el_data ) ) {
			foreach ( $el_data as $el ) {

				if ( $el['elType'] === 'widget' && $el['id'] === $widget_id ) {
					return $el;
				} elseif ( ! empty( $el['elements'] ) ) {
					$el = self::get_widget_data_by_id( $widget_id, $el['elements'] );

					if ( $el ) {
						return $el;
					}
				}
			}
		}

		return false;
	}
}