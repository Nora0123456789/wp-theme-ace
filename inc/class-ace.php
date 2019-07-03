<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Core Class
 * This will trigger Ace
**/
final class Ace {

	/**
	 * Consts
	**/
		/**
		 * Unique key to be used for prefixes
		**/
		const THEME_NAME       = 'Ace';
		const VERSION          = '1.0.16';
		const UNIQUE_KEY       = 'ace';
		const UPPER_UNIQUE_KEY = 'ACE';

		// For update checker
		const TEXTDOMAIN     = 'ace';
		const THEME_DIR_NAME = 'ace';

	/**
	 * Vars
	**/
		/**
		 * Admin
		 *
		 * @var $admin
		**/
		private static $instance;

		public static $postFormats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );

	/**
	 * Properties
	**/
		/**
		 * Theme Data
		 * @var array
		**/
		private $themeData = array();

		/**
		 * Get Theme Data
		 * @param string $key
		 * @return mixed
		 */
		public function getThemeData( $key )
		{
			if ( ! is_string( $key )
				|| ! isset( $this->themeData[ $key ] )
			) {
				return false;
			}
			return $this->themeData[ $key ];
		}

		/**
		 * Is Child
		 * @var bool
		**/
		private $isChild = false;

		/**
		 * Is AMP
		 * 		after 'parse_query' in frontend
		 */
		public function isAMP()
		{
			return $this->getFrontendManager()->isAMP();
		}

	/**
	 * Data
	**/
		// Options
			/**
			 * Options
			**/
			//private $options = array();

		// Theme Mods
			/**
			 * Theme Mods
			**/
			//private $themeMods = array();

			/**
			 * Get Theme Mods
			 * @return array
			**/
			public function getThemeMods()
			{
				return $this->getThemeModManager()->getThemeMods();
			}

			/**
			 * Get Theme Mod
			 * @param string $key
			 * @return mixed
			**/
			public function getThemeMod( $key )
			{
				return $this->getThemeModManager()->getThemeMod( $key );
			}

		// Widget Areas
			/**
			 * Widget Area
			**/
			//private $widgetAreas = array();

			/**
			 * Get Widget Areas
			 * @return array
			**/
			public function getWidgetAreas()
			{
				return $this->getWidgetAreaManager()->getWidgetAreas();
			}

			/**
			 * Get Widget Area
			 * @param string $key
			 * @return mixed
			**/
			public function getWidgetArea( $key )
			{
				return $this->getWidgetAreaManager()->getWidgetArea( $key );
			}

	/**
	 * Instances
	**/
		// ThemeMod
			/**
			 * Theme Mod Manager
			 * @var AceThemeModManager
			**/
			private $themeModManager;

			/**
			 * Get Theme Mod Manager
			 * @return AceThemeModManager
			**/
			public function getThemeModManager()
			{
				return $this->themeModManager;
			}

		// Widget Area
			/**
			 * Widget Area Manager
			 * @var AceWidgetAreaManager
			**/
			private $widgetAreaManager;

			/**
			 * Get Widget Area Manager
			 * @return AceWidgetAreaManager
			**/
			public function getWidgetAreaManager()
			{
				return $this->widgetAreaManager;
			}

		// Style
			/**
			 * Style Manager
			 * @var AceStyleManager
			**/
			private $styleManager;

			/**
			 * Get Style Manager
			 * @return AceStyleManager
			**/
			public function getStyleManager()
			{
				return $this->styleManager;
			}

		// NavMenu
			/**
			 * NavMenu Manager
			 * @var AceNavMenuManager
			**/
			private $navMenuManager;

			/**
			 * Get NavMenu Manager
			 * @return AceNavMenuManager
			**/
			public function getNavMenuManager()
			{
				return $this->navMenuManager;
			}


		// Frontend
			/**
			 * Frontend Manager
			 * @var AceFrontendManager
			**/
			private $frontendManager;

			/**
			 * Get Frontend Manager
			 * @return AceFrontendManager
			**/
			public function getFrontendManager()
			{
				return $this->frontendManager;
			}

		// Admin
			/**
			 * Admin Manager
			 * @var AceAdminManager
			**/
			private $adminManager;

			/**
			 * Get Admin Manager
			 * @return AceAdminManager
			**/
			public function getAdminManager()
			{
				return $this->adminManager;
			}

		// Theme Customizer
			/**
			 * Theme Customizer
			 * @var AceThemeCustomizer
			**/
			private $themeCustomizer;

			/**
			 * Get Theme Customizer
			 * @return AceThemeCustomizer
			**/
			public function getThemeCustomizer()
			{
				return $this->themeCustomizer;
			}

	/**
	 * Settings
	**/
		/**
		 * Cloning is forbidden.
		 * @since 1.0
		 */
		public function __clone()
		{
			ntvwc_doing_it_wrong( __FUNCTION__, esc_html__( 'DO NOT Clone.', 'ace' ), '1.0.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 * @since 1.0
		 */
		public function __wakeup()
		{
			ntvwc_doing_it_wrong( __FUNCTION__, esc_html__( 'DO NOT Unserialize', 'ace' ), '1.0.0' );
		}

	/**
	 * Initializations
	**/
		/**
		 * Public Initializer
		 *
		 * @uses self::$instance
		 *
		 * @return Ace
		**/
		public static function getInstance( $options = array() )
		{
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		private function __construct()
		{
			add_action( 'after_setup_theme', array( $this, 'init' ), 5 );
		}

		public function init()
		{
			load_theme_textdomain( 'ace', get_template_directory() . '/i18n/languages' );
			$this->initVars();
			$this->initHooks();
			$this->inc();
			$this->initClasses();
			$this->registerWPSupport();
		}

		private function initVars()
		{

			$this->themeData = wp_get_theme();
			if ( ! defined( 'ACE_THEME_NAME' ) ) define( 'ACE_THEME_NAME', $this->themeData['Name'] );
			if ( ! defined( 'ACE_THEME_NAME_HYPHEN' ) ) define( 'ACE_THEME_NAME_HYPHEN', preg_replace( '/[^\-0-9a-zA-Z]/i', '-', strtolower( ACE_THEME_NAME ) ) );
			if ( ! defined( 'ACE_THEME_NAME_UNDERSCORE' ) ) define( 'ACE_THEME_NAME_UNDERSCORE', preg_replace( '/[^\_0-9a-zA-Z]/i', '_', strtolower( ACE_THEME_NAME ) ) );
			if ( ! defined( 'ACE_SITE_NAME' ) ) define( 'ACE_SITE_NAME', get_bloginfo( 'name' ) );
			if ( ! defined( 'ACE_SITE_DESCRIPTION' ) ) define( 'ACE_SITE_DESCRIPTION', get_bloginfo( 'description' ) );
			if ( ! defined( 'ACE_SITE_URL' ) ) define( 'ACE_SITE_URL', site_url() );

		}

		private function initHooks()
		{
			add_action( 'wp_enqueue_scripts', array( $this, 'registerScripts' ), 0, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'registerScripts' ), 0, 1 );
			add_action( 'customize_preview_init', array( $this, 'registerScripts' ), 0, 1 );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'registerScripts' ), 0, 1 );
		}

		private function inc()
		{

			// Functions
			require_once( ACE_DIR_PATH . 'inc/function/functions.php' );

			// Abstract
			require_once( ACE_DIR_PATH . 'inc/abstract/class-ace-unique-abstract.php' );
			require_once( ACE_DIR_PATH . 'inc/abstract/class-ace-data-abstract.php' );
			require_once( ACE_DIR_PATH . 'inc/abstract/class-ace-data-crud-abstract.php' );
			require_once( ACE_DIR_PATH . 'inc/abstract/class-ace-data-manager-abstract.php' );
			require_once( ACE_DIR_PATH . 'inc/abstract/class-ace-metabox-abstract.php' );

			// Methods
			require_once( ACE_DIR_PATH . 'inc/method/class-ace-data-methods.php' );
			require_once( ACE_DIR_PATH . 'inc/method/class-ace-rendering-methods.php' );

			// Data
			require_once( ACE_DIR_PATH . 'inc/data/class-ace-data-option.php' );
			require_once( ACE_DIR_PATH . 'inc/data/class-ace-data-theme-option.php' );
			require_once( ACE_DIR_PATH . 'inc/data/class-ace-data-theme-mod.php' );
			require_once( ACE_DIR_PATH . 'inc/data/class-ace-data-html-class.php' );

			// Data Manager
			require_once( ACE_DIR_PATH . 'inc/data/class-ace-theme-mod-manager.php' );
			require_once( ACE_DIR_PATH . 'inc/data/class-ace-html-class-manager.php' );

			// Nav Menu
			require_once( ACE_DIR_PATH . 'inc/nav-menu/class-ace-nav-menu-manager.php' );

			// Shortcode
			require_once( ACE_DIR_PATH . 'inc/shortcode/class-ace-shortcode-manager.php' );

			// Widget Area
			require_once( ACE_DIR_PATH . 'inc/widget-area/class-ace-widget-area.php' );
			require_once( ACE_DIR_PATH . 'inc/widget-area/class-ace-widget-area-manager.php' );

			// Style
			require_once( ACE_DIR_PATH . 'inc/style/class-ace-style-manager.php' );

			// Frontend
			require_once( ACE_DIR_PATH . 'inc/frontend/class-ace-frontend-rendering-parts-methods.php' );
			require_once( ACE_DIR_PATH . 'inc/frontend/class-ace-frontend-rendering-methods.php' );
			require_once( ACE_DIR_PATH . 'inc/frontend/class-ace-frontend-rendering-manager.php' );
			require_once( ACE_DIR_PATH . 'inc/frontend/class-ace-frontend-nav-menu-methods.php' );
			require_once( ACE_DIR_PATH . 'inc/frontend/class-ace-frontend-manager.php' );

			// Admin | Theme Customizer
			if ( is_admin() || is_customize_preview() ) require_once( ACE_DIR_PATH . 'inc/exec/inc/admin-classes.php' );

			do_action( ace()->getPrefixedActionHook( 'include_required' ) );

		}

		/**
		 * Register CSS JS
		 * @param string $hook
		**/
		public function registerScripts( $hook )
		{

			// Style
				/**
				 *
				 */
				$main_style_file_handle = 'ace-fe-style-main';
				$main_file_name = 'frontend';
				if ( wp_is_mobile() ) {
					$main_style_file_handle = 'ace-mb-style-main';
					$main_file_name = 'mobile';
				}
				if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) $main_file_name .= '.min';
				$main_css_uri = esc_url( sprintf( ACE_DIR_URL . 'assets/css/frontend/%s.css', $main_file_name ) );
				wp_register_style( $main_style_file_handle, $main_css_uri, array(), false, false );

			// JS
				/**
				 * Main
				**/
				$main_file_handle = 'ace-fe-main';
				$main_file_name = 'fe-main';
				if ( wp_is_mobile() ) {
					$main_file_handle = 'ace-mb-main';
					$main_file_name = 'mb-main';
				}
				if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) $main_file_name .= '.min';
				$main_js_uri = esc_url( sprintf( ACE_DIR_URL . 'assets/js/frontend/%s.js', $main_file_name ) );
				wp_register_script( $main_file_handle, $main_js_uri, array(), false, false );

			// Admin / Theme Customizer
			if ( is_admin() || is_customize_preview() ) require_once( ACE_DIR_PATH . 'inc/exec/reg/admin-scripts.php' );

			do_action( ace()->getPrefixedActionHook( 'register_scripts' ) );

		}


		/**
		 * Init classes
		**/
		private function initClasses()
		{

			$this->themeModManager    = AceThemeModManager::getInstance();
			$this->widgetAreaManager  = AceWidgetAreaManager::getInstance();
			$this->styleManager       = AceStyleManager::getInstance();
			$this->navMenuManager     = AceNavMenuManager::getInstance();
			$this->frontendManager    = AceFrontendManager::getInstance();
			if ( is_admin() || is_customize_preview() ) {
				$this->adminManager       = AceAdminManager::getInstance();
				$this->themeCustomizer    = AceThemeCustomizer::getInstance();
			}

			do_action( ace()->getPrefixedActionHook( 'init_classes' ) );

		}

	/**
	 * WP Setup
	**/
		/**
		 * Register WP Support
		**/
		private function registerWPSupport()
		{
			/**
			 * Add Theme Supports
			**/
				// General Supports
				add_theme_support( 'custom-background' );
				add_theme_support( 'custom-logo', array(
					//'height'      => 50,
					//'width'       => 400,
					'flex-height' => true,
					'flex-width'  => true,
					'header-text' => array( 'site-title', 'site-description' ),
				) );
				add_theme_support( 'post-thumbnails' );
				add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
				add_theme_support( 'title-tag' );
				add_theme_support( 'editor-style' );
				add_theme_support( 'automatic-feed-links' );
				add_theme_support( 'customize-selective-refresh-widgets' );
				add_theme_support( 'post-formats', self::$postFormats );
				// WooCommerce
				add_theme_support( 'woocommerce' );
			/**
			 * Add Image Sizes
			**/
				add_image_size( 'ace-thumb80', 80, 80, true );
				add_image_size( 'ace-thumb100', 100, 100, true );
				add_image_size( 'archive-article-200', 200, 200, true );
				add_image_size( 'nav-menu-thumbnail', 240, 180, true );

			/**
			 * Add Image Sizes
			**/
				register_nav_menus(
					array(
						'primary'   => esc_html__( 'Primary Navi Menu', 'ace' ),
						'footer'    => esc_html__( 'Footer Navi Menu', 'ace' ),
						'mobile'    => esc_html__( 'Mobile Navi Menu', 'ace' ),
					)
				);
		}

	/**
	 * Tools
	**/
		/**
		 * Sanitize unique prefix
		 * @param  [string] $prefix
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function sanitizeUniquePrefix( $prefix, $sep = '_' )
		{
			if ( ! is_string( $sep ) || empty( $sep ) ) throw new Exception( esc_html__( 'Separator is not valid.', 'ace' ) );
			return strtolower( preg_replace( '/[^a-zA-Z0-9]+/i', $sep, $prefix ) );
		}

		/**
		 * Sanitize unique prefix
		 * @param  [string] $prefix
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function sanitizeInputNamePrefix( $prefix, $sep = '_' )
		{
			if ( ! is_string( $sep ) || empty( $sep ) ) throw new Exception( esc_html__( 'Separator is not valid.', 'ace' ) );
			return strtolower( preg_replace( '/[^a-zA-Z0-9\[\]]+/i', $sep, $prefix ) );
		}

		/**
		 * Returns the key
		 * @uses  [string] self::UNIQUE_KEY
		 * @return [string]
		**/
		public function getPrefixKey()
		{
			return self::UNIQUE_KEY;
		}

		/**
		 * Returns the key
		 * @uses  [string] $this->theme_data['Name']
		 * @return [string]
		**/
		public function getThemePrefixKey()
		{
			return str_replace( array( ' ', '-' ), '_', strtolower( ACE_THEME_NAME_UNDERSCORE ) );
		}

		/**
		 * Get prefixed name
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedName( $name, $sep = '_' )
		{

			return $this->sanitizeUniquePrefix( implode( $sep, array(
				self::UNIQUE_KEY,
				$name
			) ), $sep );

		}

		/**
		 * Get prefixed name with theme name
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getThemePrefixedName( $name, $sep = '_' )
		{
			return $this->sanitizeUniquePrefix( implode( $sep, array(
				ACE_THEME_NAME,
				$name
			) ), $sep );
		}

		/**
		 * Get prefixed option name
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedOptionName( $name, $sep = '_' )
		{
			return $this->sanitizeInputNamePrefix( implode( $sep, array(
				self::UNIQUE_KEY,
				$name
			) ), $sep );
		}

		/**
		 * Get prefixed option name
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedThemeOptionName( $name, $sep = '_' )
		{
			return $this->sanitizeInputNamePrefix( implode( $sep, array(
				ACE_THEME_NAME,
				$name
			) ), $sep );
		}

		/**
		 * Get prefixed option name
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedPostMetaName( $name, $sep = '_' )
		{
			return $this->sanitizeInputNamePrefix( '_' . implode( $sep, array(
				self::UNIQUE_KEY,
				$name
			) ), $sep );
		}

		/**
		 * Get prefixed option name
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedThemePostMetaName( $name, $sep = '_' )
		{
			return $this->sanitizeInputNamePrefix( '_' . implode( $sep, array(
				ACE_THEME_NAME,
				$name
			) ), $sep );
		}

		/**
		 * Get prefixed action hook
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedActionHook( $name, $sep = '_' )
		{
			return $this->sanitizeUniquePrefix( implode( $sep, array(
				self::UNIQUE_KEY,
				'action',
				$name
			) ), $sep );
		}

		/**
		 * Get prefixed filter hook
		 * @param  [string] $name
		 * @param  [string] $sep
		 * @return [string]
		**/
		public function getPrefixedFilterHook( $name, $sep = '_' )
		{
			return $this->sanitizeUniquePrefix( implode( $sep, array(
				self::UNIQUE_KEY,
				'filter',
				$name
			) ), $sep );
		}

}

