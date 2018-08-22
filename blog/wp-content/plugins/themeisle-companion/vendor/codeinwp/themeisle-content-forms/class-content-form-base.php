<?php

namespace ThemeIsle\ContentForms;

/**
 * An abstract class which should reflect how a Content Form should look like
 * Class ContentFormBase
 * @package ThemeIsle\ContentForms
 */
abstract class ContentFormBase {

	/**
	 * The content form type.
	 * Currently the possible values are: `contact`,`newsletter` and `registration`
	 * @var string $type
	 */
	private $type;

	/**
	 * Holds the shape of the content form, names, details and fields structure.
	 * @var array $config
	 */
	private $config;

	protected $notices = array();

	/**
	 * Create the Content Form Object and add initial hooks
	 * ContentFormBase constructor.
	 */
	function __construct() {
		$this->init();

		$this->add_base_hooks();
	}

	/**
	 * This method is passed to the rest controller and it is responsible for submitting the data.
	 *
	 * @param $return array
	 * @param $data array
	 * @param $widget_id string
	 * @param $post_id string
	 * @param $builder string
	 *
	 * @return mixed
	 */
	abstract public function rest_submit_form( $return, $data, $widget_id, $post_id, $builder );

	/**
	 * Create an abstract array config which should define the form.
	 * This method's body will be passed to a filter
	 *
	 * @param $config
	 *
	 * @return mixed
	 */
	abstract public function make_form_config( $config );

	/**
	 * Map the registration actions
	 */
	public function add_base_hooks() {

		// add the initial config for the Contact Content Form
		add_filter( 'content_forms_config_for_' . $this->get_type(), array( $this, 'make_form_config' ) );

		$config = apply_filters( 'content_forms_config_for_' . $this->get_type(), array() );
		$this->set_config( $config );

		// @TODO if we will ever think about letting users submit without AJAX
		// register the classic submission action
		//add_action( 'admin_post_nopriv_content_form_contact_submit', array( $this, 'submit_form' ) );
		//add_action( 'admin_post_content_form_contact_submit', array( $this, 'submit_form' ) );

		// add a rest api callback for the `submit` route
		add_filter( 'content_forms_submit_' . $this->get_type(), array( $this, 'rest_submit_form' ), 10, 5 );

		$this->maybe_register_elementor_category();

		// Register the Elementor Widget
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_elementor_widget' ) );

		// Register the Beaver Module
		$this->register_beaver_module();
		add_action( 'init', array( $this, 'register_beaver_module' ) );

		// Register the Gutenberg Block
		// @TODO This is not fully working at this moment
		// $this->register_gutenberg_block();
	}

	/**
	 * Elementor widget registration
	 */
	public function register_elementor_widget() {

		// We check if the Elementor plugin has been installed / activated.
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {

			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(
				new \ThemeIsle\ContentForms\ElementorWidget(
					array(
						'id'                   => 'content_form_' . $this->get_type(),
						'content_forms_config' => $this->get_config()
					),
					array(
						'content_forms_config' => $this->get_config()
					)
				)
			);
		}
	}

	/**
	 * Register a Beaver module
	 * https://www.wpbeaverbuilder.com/custom-module-documentation
	 */
	public function register_beaver_module() {
		if ( class_exists( '\FLBuilderModel' ) ) {

			$classname = __NAMESPACE__ . '\\BeaverModule' . ucfirst( $this->get_type() );

			$module = new $classname(
				array(
					'id'                   => 'content_form_' . $this->get_type(),
					'type'                 => $this->get_type(),
					'content_forms_config' => $this->get_config()
				)
			);

			$module->register_widget();
		}
	}

	/**
	 * Gutenberg block registration
	 */
	public function register_gutenberg_block() {

		if ( in_array( 'gutenberg/gutenberg.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			require_once( __DIR__ . '/class-themeisle-content-forms-gutenberg.php' );

			$block = new \ThemeIsle\ContentForms\GutenbergModule(
				array(
					'id'                   => 'content_form_' . $this->get_type(),
					'type'                 => $this->get_type(),
					'content_forms_config' => $this->get_config()
				)
			);
		}
	}

	/**
	 * Themeisle Companion may register an Elementor widgets category.
	 * But if not, we need to register it ourselfs.
	 */
	public function maybe_register_elementor_category() {

		if ( ! defined( 'ELEMENTOR_PATH' ) || ! class_exists( 'Elementor\Widget_Base' ) ) {
			return;
		}

		$categories = \Elementor\Plugin::instance()->elements_manager->get_categories();

		if ( ! isset( $categories['obfx-elementor-widgets'] ) ) {

			$category_args = apply_filters( 'content_forms_category_args', array(
				'slug' => 'obfx-elementor-widgets',
				'title' => __( 'Orbit Fox Addons', 'themeisle-companion' ),
				'icon'  => 'fa fa-plug',
			) );

			\Elementor\Plugin::instance()->elements_manager->add_category(
				$category_args['slug'],
				array(
					'title' => $category_args['title'],
					'icon'  => $category_args['slug'],
				),
				1
			);
		}
	}

	/**
	 * Get block settings depending on what builder is in use.
	 *
	 * @param $widget_id
	 * @param $post_id
	 * @param $builder
	 *
	 * @return bool
	 */
	protected function get_widget_settings( $widget_id, $post_id, $builder ) {
		if ( 'elementor' === $builder ) {
			$settings = ElementorWidget::get_widget_settings( $widget_id, $post_id );

			return $settings['settings'];
		} elseif ( 'beaver' === $builder ) {
			return $this->get_beaver_module_settings_by_id( $widget_id, $post_id );
		}

		// if gutenberg
		return false;
	}

	/**
	 * Each beaver module has data saved in the post metadata, and we need to extract it by its id.
	 *
	 * @param $node_id
	 * @param $post_id
	 *
	 * @return array|bool
	 */
	private function get_beaver_module_settings_by_id( $node_id, $post_id ) {
		$post_data = \FLBuilderModel::get_layout_data( null, $post_id );

		if ( isset( $post_data[ $node_id ] ) ) {
			$module = $post_data[ $node_id ];

			return (array) $module->settings;
		}

		return false;
	}

	/**
	 * Setter method for the form type
	 *
	 * @param $type
	 */
	protected function set_type( $type ) {
		$this->type = $type;
	}

	/**
	 * Getter method for the form type
	 *
	 * @return string
	 */
	final public function get_type() {
		return $this->type;
	}

	/**
	 * Setter method for the config property
	 *
	 * @param $config
	 */
	protected function set_config( $config ) {
		$this->config = $config;
	}

	/**
	 * Getter method for the config property
	 * @return mixed
	 */
	final public function get_config() {
		return $this->config;
	}

}