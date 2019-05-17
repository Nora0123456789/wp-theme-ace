<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Frontend
 * 
**/
class AceFrontendManager {

	/**
	 * Static
	**/
		/**
		 * Instance
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * Classes
		 * @var array
		**/
		public $classes = array();

		public function getHTMLClasses( $key )
		{
			if ( is_string( $key ) 
				&& '' !== $key 
				&& isset( $this->classes[ $key ] )
				&& is_array( $this->classes[ $key ] )
			) {
				return $this->classes[ $key ];
			}
			return false;
		}

		/**
		 * Content Width
		 * @var int
		**/
		public $contentWidth;

		/**
		 * Sidebar Left Width
		 * @var int
		**/
		public $columnLeftWidth;

		/**
		 * Content Inner Width
		 * @var int
		**/
		public $contentInnerWidth;

		/**
		 * Sidebar Right Width
		 * @var int
		**/
		public $columnRightWidth;

		/**
		 * Is AMP
		 * 		after 'parse_query' in frontend
		 */
		public function isAMP()
		{
			if ( 'parse_query' === current_filter() 
				|| did_action( 'parse_query' )
			) {
				return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
			}
			return false;
		}

		/**
		 * Content Area Layout Class
		 * @var string
		**/
		public $contentAreaLayoutClass;

		/**
		 * Post Formats
		 * 
		 * @var array $post_format_terms
		**/
		public $post_format_terms = array();

		/**
		 * Standard Widget Areas
		 * 
		 * @var array $standard_widget_areas
		**/
		public $standard_widget_areas = array();

		/**
		 * Post Meta
		 * 
		 * @var array $deactivateWidgetAreas
		**/
		public $deactivateWidgetAreas = array();

		/**
		 * Walker Class
		 * 
		 * @var string $walker_nav_menu_class
		**/
		public $walker_nav_menu_class;

	/**
	 * Instances
	**/
		/**
		 * Action Manager
		 * @var AceFrontendActionManager
		**/
		public $action_manager = null;

		/**
		 * Get Action Manager
		 * @return bool|AceFrontendActionManager
		**/
		public function getActionManager()
		{
			if ( $this->action_manager instanceof AceFrontendActionManager ) {
				return $this->action_manager;
			}
			return false;
		}

		/**
		 * Filter Manager
		 * @var AceFrontendFilterManager
		**/
		public $filter_manager = null;

		/**
		 * Get Filter Manager
		 * @return bool|AceFrontendFilterManager
		**/
		public function getFilterManager()
		{
			if ( $this->filter_manager instanceof AceFrontendFilterManager ) {
				return $this->filter_manager;
			}
			return false;
		}

		/**
		 * Post Meta Manager
		 * @var AceFrontendPostMetaManager
		**/
		public $postMetaManager = null;

		/**
		 * Get Post Meta Manager
		 * @return bool|AceFrontendPostMetaManager
		**/
		public function getPostMetaManager()
		{
			if ( $this->postMetaManager instanceof AceFrontendPostMetaManager ) {
				return $this->postMetaManager;
			}
			return false;
		}

		/**
		 * Nav menu walkders
		 * @var array
		**/
		public $walker_nav_menu_instances = array(
			''
		);

		/**
		 * Get nav menu walkders
		 * @param string $key
		 * @return array
		**/
		public function getWalkerNavMenuInstance( $key = '' )
		{
			if ( is_string( $key )
				&& '' !== $key
				&& isset( $this->walker_nav_menu_instances[ $key ] )
			) {
				return $this->walker_nav_menu_instances[ $key ];
			}
			return false;
		}

	/**
	 * Init
	**/
		/**
		 * Public initializer
		 * @return AceFrontendManager
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) {
				self::$instance = new Self();
			}
			return self::$instance;
		}

		/**
		 * Construct
		**/
		protected function __construct()
		{

			// Vars
			$this->initVars();

			// Hooks
			$this->initHooks();

			// End Trigger
			do_action( ace()->getPrefixedActionHook( 'init_frontend_manager' ) );

		}

		protected function initVars()
		{
			$this->styleManager     = AceStyleManager::getInstance();
			$this->renderingManager = AceFrontendRenderingManager::getInstance();
		}

	/**
	 * Actions
	**/
	function initHooks()
	{

		// WP
		add_action( 'wp', array( $this, 'initFrontend' ) );
		add_action( ace()->getPrefixedActionHook( 'frontend_page_load' ), array( $this, 'initInLoadingPage' ) );

		// Dequeue CSS JS
		add_action( 'wp_enqueue_scripts', array( $this, 'deregisterScripts' ), 50 );

		// Enqueue CSS JS
		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'wpEnqueueScripts' ), 0 );
		}


		add_filter( 'style_loader_tag', array( $this, 'styleLoaderTag' ), 10, 3 );
		add_filter( 'script_loader_tag', array( $this, 'scriptLoaderTag' ), 10, 3 );

		// WP Head
		add_action( 'wp_head', array( $this, 'wp_head' ), 0 );

		// WP Footer
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

	}

		/**
		 * Dequeue CSS JS
		**/
		public function deregisterScripts()
		{

			// Dequeue
				wp_dequeue_style( 'wp-block-library' );

			// Action
				do_action( ace()->getPrefixedActionHook( 'init_deregister_scripts' ) );

		}

		/**
		 * Enqueue CSS JS
		**/
		public function wpEnqueueScripts()
		{

			if ( $this->isAMP() ) {
				return;
			}

			// CSS
				$main_style_file_handle = 'ace-fe-style-main';
				if ( wp_is_mobile() ) {
					$main_style_file_handle = 'ace-mb-style-main';
				}

				$device = 'pc';
				if ( wp_is_mobile() ) {
					$device = 'mobile';
				}
				wp_add_inline_style( $main_style_file_handle, $this->styleManager->getFirstStyles( $device ) );
				wp_add_inline_style( $main_style_file_handle, $this->styleManager->getModStyles( $device ) );
				wp_enqueue_style( $main_style_file_handle );

			// JS
				$main_file_handle = 'ace-fe-main';
				if ( wp_is_mobile() ) {
					$main_file_handle = 'ace-mb-main';
				}
				wp_localize_script( $main_file_handle, 'aceFrontendObject', array(
					'siteUrl' => site_url()
				) );
				wp_enqueue_script( $main_file_handle );

		}

		/**
		 * Maybe Only for dev mode
		**/
		public function styleLoaderTag( $tag, $handle, $src )
		{
			if ( in_array( $handle, array( 'ace-fe-style-main', 'ace-mb-style-main' ) ) ) {
				return '<noscript>' . $tag . '</noscript>';
			}
			return $tag;
		}

		/**
		 * Maybe Only for dev mode
		**/
		public function scriptLoaderTag( $tag, $handle, $src )
		{
			if ( in_array( $handle, array( 'ace-fe-main', 'ace-mb-main' ) ) ) {
				printf( '<script async id="%1$s" src="%2$s"></script>', esc_attr( $handle ), esc_url( $src ) );
				return;
			}
			return $tag;
		}

	// Methods Except Page Generators
		/**
		 * Hooked in Action Hook "wp"
		**/
		function initFrontend()
		{

			// WP Query
			global $wp_query;

			// Defines


			// Setup Post Meta
				/**
				 * Set up the following vars priority
				 * AceFrontendPostMetaManager::deactivateWidgetAreas
				**/
				do_action( ace()->getPrefixedActionHook( 'init_frontend_post_meta' ), $this );

			// After Setup Post Meta Vars
			if( ! is_admin() ) {
				/**
				 * Get the PostMeta data for Widget Area Manager Usage
				**/
				do_action( ace()->getPrefixedActionHook( 'setup_frontend_post_meta' ), $this );
			}

			// Widths
			$this->setupWidths();

			// Class Data
			$this->setupBodyClasses();

		}

			/**
			 * Setup Widths
			 * @uses int $this->contentWidth
			 * @uses int $this->contentInnerWidth
			 * @uses int $this->columnLeftWidth
			 * @uses int $this->columnRightWidth
			**/
			protected function setupWidths()
			{

				// Content Area Width
				$this->columnLeftWidth  = absint( AceDataMethods::getThemeMod( 'column_left_max_width' ) );
				$this->contentInnerWidth = absint( AceDataMethods::getThemeMod( 'main_content_max_width' ) );
				$this->columnRightWidth = absint( AceDataMethods::getThemeMod( 'column_right_max_width' ) );

				// Mobile Detect
				$has_sidebar_left_container = $has_sidebar_right_container = false;
				if ( ! wp_is_mobile() ) {

					$this->columnLeftContainer  = AceFrontendRenderingMethods::getColumnLeftContainer();
					$this->columnRightContainer = AceFrontendRenderingMethods::getColumnRightContainer();
					$has_sidebar_left_container  = ace_boolval( ! empty( $this->columnLeftContainer ) );
					$has_sidebar_right_container = ace_boolval( ! empty( $this->columnRightContainer ) );

				}

				// About Layout of Content Area
				if ( $has_sidebar_left_container && $has_sidebar_right_container ) {

					$this->contentWidth = $this->contentInnerWidth + $this->columnLeftWidth + $this->columnRightWidth + 20;
					$this->contentAreaLayoutClass = 'three-columns';

				} elseif ( $has_sidebar_left_container ) {

					$this->contentWidth = $this->contentInnerWidth + $this->columnLeftWidth + 10;
					$this->contentAreaLayoutClass = 'two-columns two-columns-left';

				} elseif ( $has_sidebar_right_container ) {

					$this->contentWidth = $this->contentInnerWidth + $this->columnRightWidth + 10;
					$this->contentAreaLayoutClass = 'two-columns two-columns-right';

				} else {

					$this->contentWidth = $this->contentInnerWidth = $this->contentInnerWidth + 210;
					$this->contentAreaLayoutClass = 'one-column';

				} unset( $has_sidebar_left_container, $has_sidebar_right_container );

				// Content Width
				global $content_width;
				$content_width = intval( $this->contentWidth );

				// After Define Content Area Layout
				do_action( ace()->getPrefixedActionHook( 'setup_frontend_layout' ), $this );

			}

			/**
			 * Setup Widths
			 * @uses int $this->contentWidth
			 * @uses int $this->contentInnerWidth
			 * @uses int $this->columnLeftWidth
			 * @uses int $this->columnRightWidth
			**/
			protected function setupBodyClasses()
			{

				// Body Classes
					$this->classes['body'] = array( 'ace', esc_attr( wp_is_mobile() ? 'mobile' : 'pc' ), 'ace-no-js' );

					$header_layout = ace()->getThemeMod( 'header_layout_pattern' );
					if ( is_string( $header_layout ) && '' !== $header_layout ) {
						array_push( $this->classes['body'], 'ace-with-header-inner-' . $header_layout );
					}

					// Column Num and Layout
					if ( ! wp_is_mobile() ) {
						array_push( $this->classes['body'], $this->contentAreaLayoutClass );
					}

					// Is Nav Menu Fixed
					if( isset( $GLOBALS['woocommerce'] ) ) {
						array_push( $this->classes['body'], 'woocommerce' );
					}

					if ( ace()->getThemeMod( 'is_responsive', false ) ) {
						array_push( $this->classes['body'], 'is-responsive' );
					}

					if ( ace()->getThemeMod( 'is_header_fixed', false ) ) {
						array_push( $this->classes['body'], 'header-nav-fixable' );
					}

					if ( ace()->getThemeMod( 'is_search_on_top', false ) ) {
						array_push( $this->classes['body'], 'header-has-searchbox' );
					}

					if ( ace()->getThemeMod( 'header_contact_info_display', false ) ) {
						array_push( $this->classes['body'], 'header-has-contact-info' );
					}

					if ( is_customize_preview() ) {
						array_push( $this->classes['body'], 'preview-theme-customizer' );
					}

					$this->classes = apply_filters( ace()->getPrefixedFilterHook( 'frontend_html_classes' ), $this->classes, $this );

					// After Define Body Class
					do_action( ace()->getPrefixedActionHook( 'setup_body_class' ), $this );

			}

		/**
		 * Hooked in Action Hook "frontend_page_load"
		**/
		public function initInLoadingPage()
		{

			$this->setupClasses();

			// After Define Classes
			do_action( ace()->getPrefixedActionHook( 'setup_frontend_classes' ), $this );

			// Nav Menus
			$this->setupNavMenus();

			// After Setup Nav Menu
			do_action( ace()->getPrefixedActionHook( 'setup_nav_menu' ), $this );

			// End of Loading Page
			do_action( ace()->getPrefixedActionHook( 'in_loading_page' ), $this );

		}

			/**
			 * Setup Classes
			 * @uses int $this->contentWidth
			 * @uses int $this->contentInnerWidth
			 * @uses int $this->columnLeftWidth
			 * @uses int $this->columnRightWidth
			**/
			protected function setupClasses()
			{

				// Header
					$this->classes['header'] = array( 'header', ace()->getThemeMod( 'header_style_pattern' ) );
					$header_design_edge = ace()->getThemeMod( 'header_design_edge' );
					if ( 'none' !== $header_design_edge ) {
						array_push( $this->classes['header'], 'designed-section' );
						array_push( $this->classes['header'], $header_design_edge );
					}

				// Main Area
					$this->classes['main-area'] = array( 'main-area' );
					$main_area_design_edge = ace()->getThemeMod( 'main_area_design_edge' );
					if ( 'none' !== $main_area_design_edge ) {
						array_push( $this->classes['main-area'], 'designed-section' );
						array_push( $this->classes['main-area'], $main_area_design_edge );
					}

				// Footer
					$this->classes['footer'] = array( 'footer' );
					$footer_design_edge = ace()->getThemeMod( 'footer_design_edge' );
					if ( 'none' !== $footer_design_edge ) {
						array_push( $this->classes['footer'], 'designed-section' );
						array_push( $this->classes['footer'], $footer_design_edge );
					}

					$this->classes = apply_filters( ace()->getPrefixedFilterHook( 'fe_html_classes' ), $this->classes );

			}


			/**
			 * Setup Widths
			 * @uses int $this->contentWidth
			 * @uses int $this->contentInnerWidth
			 * @uses int $this->columnLeftWidth
			 * @uses int $this->columnRightWidth
			**/
			protected function setupNavMenus()
			{

				// Header Nav Menu
				ob_start();
					do_action( ace()->getPrefixedActionHook( 'render_header_nav_menu' ) );
				$this->top_nav_menu = ob_get_clean();

				// Nav Menu
				// Mobile Nav Menu
				ob_start();
					do_action( ace()->getPrefixedActionHook( 'render_nav_menu' ) );
				$this->nav_menu = ob_get_clean();

				// Footer Nav Menu
				ob_start();
					do_action( ace()->getPrefixedActionHook( 'render_footer_nav_menu' ) );
				$this->footer_nav_menu = ob_get_clean();

			}

		/**
		 * WP Head
		**/
		function wp_head()
		{

		}

		function wp_footer()
		{

		}


} // End Closure

