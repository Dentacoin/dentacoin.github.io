<?php
/**
 * Customizer
 *
 * @package consultpresslite-pt
 */

use ProteusThemes\CustomizerUtils\Setting;
use ProteusThemes\CustomizerUtils\Control;
use ProteusThemes\CustomizerUtils\CacheManager;
use ProteusThemes\CustomizerUtils\Helpers as WpUtilsHelpers;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class ConsultPressLite_Customizer_Base {
	/**
	 * The singleton manager instance
	 *
	 * @see wp-includes/class-wp-customize-manager.php
	 * @var WP_Customize_Manager
	 */
	protected $wp_customize;

	/**
	 * Instance of the DynamicCSS cache manager
	 *
	 * @var ProteusThemes\CustomizerUtils\CacheManager
	 */
	private $dynamic_css_cache_manager;

	/**
	 * Holds the array for the DynamiCSS.
	 *
	 * @var array
	 */
	private $dynamic_css = array();

	/**
	 * Constructor method for this class.
	 *
	 * @param WP_Customize_Manager $wp_customize The WP customizer manager instance.
	 */
	public function __construct( WP_Customize_Manager $wp_customize ) {
		// Set the private propery to instance of wp_customize.
		$this->wp_customize = $wp_customize;

		// Set the private propery to instance of DynamicCSS CacheManager.
		$this->dynamic_css_cache_manager = new CacheManager( $this->wp_customize );

		// Init the dynamic_css property.
		$this->dynamic_css = $this->dynamic_css_init();

		// Register the settings/panels/sections/controls.
		$this->register_settings();
		$this->register_sections();
		$this->register_partials();
		$this->register_controls();

		/**
		 * Action and filters
		 */

		// Render the CSS and cache it to the theme_mod when the setting is saved.
		add_action( 'wp_head', array( 'ProteusThemes\CustomizerUtils\Helpers', 'add_dynamic_css_style_tag' ), 50, 0 );
		add_action( 'customize_save_after', function() {
			$this->dynamic_css_cache_manager->cache_rendered_css( false );
		}, 10, 0 );
	}


	/**
	 * Initialization of the dynamic CSS settings with config arrays
	 *
	 * @return array
	 */
	private function dynamic_css_init() {
		$darken3   = new Setting\DynamicCSS\ModDarken( 3 );
		$darken6   = new Setting\DynamicCSS\ModDarken( 6 );
		$darken12  = new Setting\DynamicCSS\ModDarken( 12 );

		return array(
			'primary_color' => array(
				'default' => '#0bcda5',
				'css_props' => array(
					array(
						'name' => 'color',
						'selectors' => array(
							'noop' => array(
								'a',
								'a:focus',
								'.article__content .more-link:focus',
								'.widget_search .search-submit',
								'.header__logo:focus .header__logo-text',
								'.header__logo:hover .header__logo-text',
							),
						),
					),
					array(
						'name' => 'color',
						'selectors' => array(
							'noop' => array(
								'a:hover',
								'.article__content .more-link:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name' => 'color',
						'selectors' => array(
							'noop' => array(
								'a:active:hover',
								'.article__content .more-link:active:hover'
							),
						),
						'modifier'  => $darken12,
					),
					array(
						'name' => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.article__categories a',
								'.article__categories a:focus',
								'.btn-primary',
								'.btn-primary:focus',
								'.widget_calendar caption',
							),
						),
					),
					array(
						'name' => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.article__categories a:hover',
								'.btn-primary:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name' => 'background-color',
						'selectors' => array(
							'noop' => array(
								'.article__categories a:active:hover',
								'.btn-primary:active:hover',
							),
						),
						'modifier'  => $darken12,
					),
					array(
						'name' => 'background-color',
						'selectors' => array(
							'@media (min-width: 992px)' => array(
								'.main-navigation > .menu-item:focus::before',
								'.main-navigation > .menu-item:hover::before',
								'.main-navigation .sub-menu a',
							),
						),
					),
					array(
						'name' => 'background-color',
						'selectors' => array(
							'@media (min-width: 992px)' => array(
								'.main-navigation .sub-menu .menu-item:focus > a',
								'.main-navigation .sub-menu .menu-item:hover > a',
								'.main-navigation .sub-menu a::after',
							),
						),
						'modifier'  => $darken3,
					),
					array(
						'name' => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-primary',
								'.btn-primary:focus',
								'blockquote',
							),
						),
					),
					array(
						'name' => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-primary:hover',
							),
						),
						'modifier'  => $darken6,
					),
					array(
						'name' => 'border-color',
						'selectors' => array(
							'noop' => array(
								'.btn-primary:active:hover',
							),
						),
						'modifier'  => $darken12,
					),
				),
			),
		);
	}

	/**
	 * Register customizer settings
	 *
	 * @return void
	 */
	public function register_settings() {
		// Layout mode.
		$this->wp_customize->add_setting( 'layout_mode', array( 'default' => 'wide' ) );

		// Logo
		$this->wp_customize->add_setting( 'logo_top_margin', array( 'default' => 0 ) );

		// Featured page.
		$this->wp_customize->add_setting( 'featured_page_select', array( 'default' => 'none' ) );
		$this->wp_customize->add_setting( 'featured_page_custom_text' );
		$this->wp_customize->add_setting( 'featured_page_custom_url' );
		$this->wp_customize->add_setting( 'featured_page_open_in_new_window' );

		// Footer.
		$this->wp_customize->add_setting( 'footer_bottom_txt', array( 'default' => sprintf(
			esc_html__( '%1$sConsultPress%2$s - WordPress theme made by ProteusThemes.' , 'consultpress-lite' ),
			'<b><a href="https://www.proteusthemes.com/wordpress-themes/consultpress-lite/">',
			'</a></b>'
		) ) );

		// Theme Info.
		$this->wp_customize->add_setting( 'theme_info_text' );

		// All the DynamicCSS settings.
		foreach ( $this->dynamic_css as $setting_id => $args ) {
			$this->wp_customize->add_setting(
				new Setting\DynamicCSS( $this->wp_customize, $setting_id, $args )
			);
		}
	}


	/**
	 * Sections
	 *
	 * @return void
	 */
	public function register_sections() {
		$this->wp_customize->add_section( 'consultpresslite_theme_options', array(
			'title'       => esc_html__( 'Theme Options', 'consultpress-lite' ),
			'description' => esc_html__( 'All ConsultPress Lite theme specific settings.', 'consultpress-lite' ),
			'priority'    => 5,
		) );

		$this->wp_customize->add_section( 'consultpresslite_theme_info', array(
			'title'       => esc_html__( 'Theme Info', 'consultpress-lite' ),
			'description' => esc_html__( 'More information about ConsultPress.', 'consultpress-lite' ),
			'priority'    => 10,
		) );
	}


	/**
	 * Partials for selective refresh
	 *
	 * @return void
	 */
	public function register_partials() {
		$this->wp_customize->selective_refresh->add_partial( 'dynamic_css', array(
			'selector' => 'head > #wp-utils-dynamic-css-style-tag',
			'settings' => array_keys( $this->dynamic_css ),
			'render_callback' => function() {
				return $this->dynamic_css_cache_manager->render_css();
			},
		) );
	}


	/**
	 * Controls
	 *
	 * @return void
	 */
	public function register_controls() {
		$this->wp_customize->add_control(
			'logo_top_margin',
			array(
				'type'        => 'number',
				'label'       => esc_html__( 'Logo top margin', 'consultpress-lite' ),
				'description' => esc_html__( 'In pixels.', 'consultpress-lite' ),
				'priority'    => 9,
				'section'     => 'title_tagline',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 120,
					'step' => 5,
				),
			)
		);

		// Section: consultpresslite_theme_options.
		$this->wp_customize->add_control( 'layout_mode', array(
			'type'     => 'select',
			'priority' => 5,
			'label'    => esc_html__( 'Layout', 'consultpress-lite' ),
			'section'  => 'consultpresslite_theme_options',
			'choices'  => array(
				'wide'  => esc_html__( 'Wide', 'consultpress-lite' ),
				'boxed' => esc_html__( 'Boxed', 'consultpress-lite' ),
			),
		) );

		$this->wp_customize->add_control( 'featured_page_select', array(
			'type'        => 'select',
			'priority'    => 10,
			'label'       => esc_html__( 'Featured page', 'consultpress-lite' ),
			'description' => esc_html__( 'To which page should the Featured Page button link to?', 'consultpress-lite' ),
			'section'     => 'consultpresslite_theme_options',
			'choices'     => WpUtilsHelpers::get_all_pages_id_title(),
		) );

		$this->wp_customize->add_control( 'featured_page_custom_text', array(
			'priority'        => 15,
			'label'           => esc_html__( 'Custom Button Text', 'consultpress-lite' ),
			'section'         => 'consultpresslite_theme_options',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_specific_value( 'featured_page_select', 'custom-url' );
			},
		) );

		$this->wp_customize->add_control( 'featured_page_custom_url', array(
			'priority'        => 20,
			'label'           => esc_html__( 'Custom URL', 'consultpress-lite' ),
			'section'         => 'consultpresslite_theme_options',
			'active_callback' => function() {
				return WpUtilsHelpers::is_theme_mod_specific_value( 'featured_page_select', 'custom-url' );
			},
		) );

		$this->wp_customize->add_control( 'featured_page_open_in_new_window', array(
			'type'            => 'checkbox',
			'priority'        => 25,
			'label'           => esc_html__( 'Open link in a new window/tab.', 'consultpress-lite' ),
			'section'         => 'consultpresslite_theme_options',
			'active_callback' => function() {
				return ( ! WpUtilsHelpers::is_theme_mod_specific_value( 'featured_page_select', 'none' ) );
			},
		) );

		$this->wp_customize->add_control( new WP_Customize_Color_Control(
			$this->wp_customize,
			'primary_color',
			array(
				'priority' => 5,
				'label'    => esc_html__( 'Primary color', 'consultpress-lite' ),
				'section'  => 'consultpresslite_theme_options',
			)
		) );

		$this->wp_customize->add_control( 'footer_bottom_txt', array(
			'type'        => 'text',
			'priority'    => 30,
			'label'       => esc_html__( 'Footer bottom text', 'consultpress-lite' ),
			'description' => esc_html__( 'You can use HTML: a, span, i, em, strong, img.', 'consultpress-lite' ),
			'section'     => 'consultpresslite_theme_options',
		) );

		// Section: consultpresslite_theme_info.
		$this->wp_customize->add_control( 'theme_info_text', array(
			'type'        => 'hidden',
			'priority'    => 5,
			'description' => sprintf( esc_html__( '%1$sView Documentation%2$s %3$s %4$sView Demo%2$s %3$s %5$sView ConsultPress Pro%2$s' , 'consultpress-lite' ),
			'<b><a style="display: block; font-style: normal; height: 45px; line-height: 45px;" class="button" href="https://demo.proteusthemes.com/consultpress-lite/documentation/" target="_blank">',
			'</a></b>',
			'<hr>',
			'<b><a style="display: block; font-style: normal; height: 45px; line-height: 45px;" class="button" href="https://demo.proteusthemes.com/consultpress-lite/" target="_blank">',
			'<b><a style="display: block; font-style: normal; height: 45px; line-height: 45px;" class="button" href="https://www.proteusthemes.com/wordpress-themes/consultpress/" target="_blank">'
			),
			'section'     => 'consultpresslite_theme_info',
		) );
	}
}
