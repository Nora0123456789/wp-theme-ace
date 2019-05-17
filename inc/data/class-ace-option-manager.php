<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'AceOptionManager' ) ) {
/**
 * Data formats
**/
class AceOptionManager extends AceUniqueAbstract {

	/**
	 * Consts
	**/

	/**
	 * Vars
	**/
		/**
		 * Admin
		 * 
		 * @var $admin
		**/
		protected static $instance;

		public static $defaults = array(
			'general' => array(
				'default_settings_tab' => 'general-settings',
			),
			'activations' => array(
				'seos' => '',
			),
			'not_display_post_formats' => array(
				'aside' => false,
				'gallery' => false,
				'image' => false,
				'link' => false,
				'quote' => false,
				'status' => false,
				'video' => false,
				'audio' => false,
				'chat' => false,
			),
			'tax_query_post_format' => array(),
			'remove_action' => array(
				'rsd_link' => false,
				'wlwmanifest_link' => false,
				'wp_generator' => false,
				'feed_links_extra' => false,
				'feed_links' => false,
				'index_rel_link' => false,
				'parent_post_rel_link' => false,
				'start_post_rel_link' => false,
				'adjacent_posts_rel_link_wp_head' => false,
			),
			'injections' => array(
				'header_code' => '',
				'after_start_body_code' => '',
				'footer_code' => '',
			),
			'speed_adjust' => array(
				'no_jetpack_css' => false,
				'no_jquery'      => false,
			),
			'widget_areas' => array(),
			'seos' => array(
				'json_ld_markup_on' => false,
				'json_ld_logo' => ACE_DIR_URL . '/screenshot.png',
				'canonical_link_on' => false,
				'meta_robots_on' => false,
				'meta_description_on' => false,
				'meta_keywords_on' => false,
				'twitter_card_on' => false,
				'twitter_card_account' => '',
				'open_graph_on' => false,
				'tc_og_image' => '',
			),
			'api_keys' => array(
				'google_fonts_api' => '',
				'google_map_api'   => '',
				'pixabay_key'      => '',
			),
			'others' => array(
				'reset_page_view_count' => true,
				'auto_page_view_count_reset' => 'no',
			),
			'fonts' => array(
				1 => array( 
					'font-family' => '',
					'src' => array(),
				)
			),
			'icons' => array(),
		);

		public static function getDefault( string $key )
		{
			if ( '' === $key
				|| ! isset( self::$defaults[ $key ] )
			) {
				return false;
			}
			return self::$defaults[ $key ];
		}

	/**
	 * Properties
	**/
		/**
		 * AceDataOptions
		 * @var AceDataOption[]
		**/
		private $dataOptions = array();

		public function getDataOptions()
		{
			return $this->dataOptions;
		}

		public function getDataOption( string $key )
		{
			if ( '' === $key
				|| ! isset( $this->dataOptions[ $key ] )
				|| ! $this->dataOptions[ $key ] instanceof AceDataOption
			) {
				return false;
			}
			return $this->dataOptions[ $key ];
		}

		/**
		 * Options
		 * @var array[]
		**/
		private $options = array();

		public function getOptions()
		{

			if ( ! is_array( $this->dataOptions ) 
				|| 0 >= count( $this->dataOptions )
			) {
				return false;
			}

			$options = array();
			foreach ( $this->dataOptions as $index => $data_option ) {
				$options[ $index ] = $this->getOption( $index );
			}
			return $options;

		}

		public function getOption( string $key )
		{
			if ( '' === $key
				|| ! isset( $this->dataOptions[ $key ] )
				|| ! $this->dataOptions[ $key ] instanceof AceDataOption
			) {
				return false;
			}
			return $this->dataOptions[ $key ]->getData();
		}




	/**
	 * Initializer
	**/
		/**
		 * Public initializer
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) {
				self::$instance = new Self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct()
		{
			$this->initVars();
			$this->load();
			$this->initHooks();
		}

		/**
		 * Init Vars
		**/
		protected function initVars()
		{

			// Data Options
				// Generals
					$this->dataOptions['general'] = AceDataOption::getInstance( 'general', self::$defaults['general'] );
					
					$this->dataOptions['activations'] = AceDataOption::getInstance( 'activations', self::$defaults['activations'] );
					
					$this->dataOptions['not_display_post_formats'] = AceDataOption::getInstance( 'not_display_post_formats', self::$defaults['not_display_post_formats'] );
					$this->dataOptions['tax_query_post_format'] = AceDataOption::getInstance( 'tax_query_post_format', self::$defaults['tax_query_post_format'] );

					$this->dataOptions['remove_action'] = AceDataOption::getInstance( 'remove_action', self::$defaults['remove_action'] );

				// Auto Insert
					$this->dataOptions['injections'] = AceDataOption::getInstance( 'injections', self::$defaults['injections'] );

				// Speed Adjust
					$this->dataOptions['speed_adjust'] = AceDataOption::getInstance( 'speed_adjust', self::$defaults['speed_adjust'] );

				// Widget Areas
					$this->dataOptions['widget_areas'] = AceDataThemeOption::getInstance( 'widget_areas', self::$defaults['widget_areas'] );

				// SEOs
					$this->dataOptions['seos'] = AceDataOption::getInstance( 'seos', self::$defaults['seos'] );

				// API Keys
				$this->dataOptions['api_keys'] = AceDataOption::getInstance( 'api_keys', self::$defaults['api_keys'] );

				// Others
				$this->dataOptions['others'] = AceDataOption::getInstance( 'others', self::$defaults['others'] );

				// Fonts
					$this->dataOptions['fonts'] = AceDataThemeOption::getInstance( 'fonts', self::$defaults['fonts'] );

				// Icons
				if ( is_admin() || is_customize_preview() ) {
					// Others
					$this->dataOptions['icons'] = AceDataOption::getInstance( 'icons', self::$defaults['icons'] );
				}

			// Options
				// Generals
					$this->options['general'] = $this->dataOptions['general']->getData();
					$this->options['not_display_post_formats'] = $this->dataOptions['not_display_post_formats']->getData();
					$this->options['remove_action'] = $this->dataOptions['remove_action']->getData();

				// Auto Insert
					$this->options['injections'] = $this->dataOptions['injections']->getData();

				// Speed Adjust
					$this->options['speed_adjust'] = $this->dataOptions['speed_adjust']->getData();

				// Widget Areas
					$this->options['widget_areas'] = $this->dataOptions['widget_areas']->getData();

				// Others
					$this->options['others'] = $this->dataOptions['others']->getData();

				// Fonts
					$this->options['fonts'] = $this->dataOptions['fonts']->getData();
					//$this->options['fonts'] = get_option( ace()->getPrefixedOptionName( 'custom_fonts' ) );

				// Icons
				if ( is_admin() || is_customize_preview() ) {
					// Others
					$this->options['icons'] = $this->dataOptions['icons']->getData();
				}

		}

		/**
		 * Constructor
		**/
		protected function load()
		{

		}

		/**
		 * Init hooks
		**/
		protected function initHooks()
		{

		}

	/**
	 * 
	**/

}
}

