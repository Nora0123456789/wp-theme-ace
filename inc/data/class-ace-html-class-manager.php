<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * CSS Animation Manager
**/
class AceHTMLClassManager extends AceUniqueAbstract {

	/**
	 * Statics
	**/
		/**
		 * Instance of the Class
		 * 
		 * @var object AceDataOption
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * Data
		 * @var AceDataHTMLClass[]
		**/
		protected $data = array();

		/**
		 * Data
		 * @var AceDataHTMLClass[]
		**/
		protected $defaults = array(
			'body' => array( 'ace' ),
			'outer-wrapper' => array( 'outer-wrapper' ),
			'inner-wrapper' => array( 'inner-wrapper' ),
				'header' => array( 'header' ),
					'header-inner-wrapper' => array( 'header-inner-wrapper' ),
						'header-title-wrapper' => array( 'header-title-wrapper' ),
							'header-site-name' => array( 'header-site-name' ),
								'a' => array( '' ),
						'top-menu-nav' => array( 'top-menu-nav' ),
							'top-nav-div' => array( 'top-nav-div' ),
				'main-nav' => array( 'main-nav' ),
					'main-nav-wrapper' => array( 'main-nav-wrapper' ),
						'mobile-nav-top-title' => array( 'mobile-nav-top-title' ),
						'main-nav-wrapper' => array( 'main-nav-wrapper' ),
							'main-nav-menu' => array( 'main-nav-menu' ),
								'menu-item' => array( 'menu-item' ),
					'html' => array(),
				'after-main-nav' => array( 'after-main-nav' ),
				'content-area' => array( 'content-area' ),
					'content-outer' => array(),
						'sidebar-left-container' => array(),
							'widget-area-sidebar-left' => array( 'widget-area', 'sidebar-left' ),
							'widget-area-column-left-fixed' => array( 'widget-area', 'column-left-fixed' ),
						'content-inner' => array( 'content-inner' ),
							'main' => array( 'main-content' ),
								'breadcrumb' => array( 'breadcrumb' ),
								// Singular
								'article' => array(),
									'article-header' => array(),
										'singular-title-wrapper' => array(),
											'h1' => array( 'p-name', 'entry-title', 'ace-singular-title' ),
										'blogbox' => array( 'blogbox' ),
											'post-date' => array( 'post-date' ),
												'date-published' => array( 'dt-published', 'entry-date' ),
												'date-updated' => array( 'dt-updated', 'entry-date', 'date', 'updated' ),
											'cats-tags' => array( 'cats-tags' ),
												'author' => array( 'p-author', 'h-card', 'post-author', 'vcard', 'author', 'content-p' ),
												'category' => array( 'post-category' ),
												'tag' => array( 'post-tag' ),
									'content' => array( 'content', 'e-content', 'entry-content' ),
										'h2' => array(),
										'h3' => array(),
										'h4' => array(),
										'h5' => array(),
										'h6' => array(),
										'p' => array(),
								// Archive
								'pagination' => array( 'pagination' ),
									'prev' => array( 'prev', 'page-numbers' ),
									'current' => array( 'current', 'page-numbers' ),
									'page-numbers' => array( 'page-numbers' ),
									'next' => array( 'next', 'page-numbers' ),
								// Singular	
								'p-navi' => array( 'p-navi', 'clearfix', 'single-page-prev-next' ),
									'prev-post-title-link' => array( 'prev-post-title-link' ),
										'prev-post' => array( 'prev-post' ),
											'to-prev-post' => array( 'prev-post-link-p' ),
											'prev-post-title' => array( 'prev-post-title-p' ),
									'next-post-title-p-a' => array(),
										'next-post' => array( 'next-post' ),
											'to-next-post' => array( 'next-post-link-p' ),
											'next-post-title' => array( 'next-post-title-p' ),
						'sidebar-right-container' => array( 'widget-area', 'sidebar-right' ),
							'widget-area-sidebar-right' => array( 'widget-area', 'sidebar-right' ),
							'widget-area-column-right-fixed' => array( 'widget-area', 'column-right-fixed' ),
			'footer' => array( 'footer' ),
				'footer-items' => array(),
					'footer-nav-menu' => array( 'footer-nav-menu' ),
						'footer-nav-wrapper' => array( 'footer-nav-wrapper' ),
							'footer-nav-menu' => array( 'footer-nav-menu' ),
					'footer-description' => array( 'footer-description' ),
						'footer-description-text' => array( 'footer-description-text' ),
					'footer-license' => array( 'footer-license' ),
						'footer-license-text' => array( 'footer-license-text' ),
					'footer-theme' => array( 'footer-theme' ),
						'footer-theme-link' => array( 'footer-theme-link' ),
							'footer-theme-text' => array( 'footer-theme-text' ),
			// Others
			'others' => array(),
		);

		/**
		 * Set Data
		 * @param string $key
		 * @param array  $params
		 * @return bool
		**/
		protected function set_data( $key, $params = array() )
		{

			if ( ! is_string( $key )
				|| '' === $key
				|| ! is_array( $params )
				|| 0 >= count( $params )
			) {
				return false;
			}

			if ( isset( $this->data[ $key ] ) ) {
				$params = wp_parse_args( $this->data[ $key ]->getData() );
			}
			$this->data[ $key ] = AceDataHTMLClass::getInstance( $key, $params );
			return true;

		}

		/**
		 * Get Data.
		 * @param string $key : Default ''
		 * @return bool|AceDataHTMLClass
		 */
		protected function get_data( $key = '' )
		{
			if ( ! is_string( $key ) 
				|| '' === $key 
				|| ! isset( $this->data[ $key ] )
			) {
				return false;
			}
			return $this->data[ $key ];
		}

		/**
		 * Get All Params.
		 * @param string $key : Default ''
		 * @return bool|array[]
		 */
		protected function get_all_params()
		{
			if ( ! is_array( $this->data )
				|| 0 >= count( $this->data )
			) {
				return false;
			}

			$data = array();
			foreach ( $this->data as $each_data_key => $each_data ) {
				if ( ! $each_data instanceof AceDataHTMLClass ) continue;
				$data[ $each_data_key ] = $each_data->getData();
			}
			return $data;
		}

		/**
		 * Get Params.
		 * @param string $key : Default ''
		 * @return bool|string[]
		 */
		protected function get_params( $key = '' )
		{
			$data = $this->get_data( $key );
			if ( false === $data 
				|| ! $data instanceof AceDataHTMLClass
			) {
				return false;
			}
			return $data->getData();
		}

		/**
		 * Get the Indexed Param.
		 * @param string $key   : Default ''
		 * @param string $index : Default ''
		 * @return AceDataHTMLClass|AceDataHTMLClass[]
		 */
		protected function get_param( $key = '', $index = '' )
		{
			$params = $this->get_params( $key );
			if ( is_array( $params )
				&& is_string( $params[ $key ] )
				&& '' !== $params[ $key ]
			) {
				return $params[ $key ];
			}
			return false;
		}

		/**
		 * Theme Mods
		 * @var array $theme_mods
		**/
		protected $theme_mods = array();

		/**
		 * Get Theme Mods
		 * @return array
		**/
		public function getThemeMods()
		{
			return $this->themeMods;
		}

	/**
	 * Init
	**/
		/**
		 * Public initializer
		 * @return AceHTMLClassManager
		**/
		public static function getInstance( $data = array() )
		{
			if ( null === self::$instance ) {
				self::$instance = new Self( $data );
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 * @param int|string $id
		 * @throws Ace_Exception
		**/
		protected function __construct( $data = array() )
		{
			$this->initVars( $data );
		}

		/**
		 * Init vars
		**/
		private function initVars( $data = array() )
		{
			if ( ! is_array( $data )
				|| 0 >= count( $data )
			) {
				$data = array();
			}
			$data = array_merge_recursive( $this->defaults, $data );

			foreach ( $data as $data_key => $data_values ) {
				$this->data[ $data_key ] = AceDataHTMLClass::getInstance( $data_key, $data_values );
			}
		}

		protected function initHooks()
		{
			add_action( ace()->getPrefixedActionHook( 'setup_theme_mods' ), array( $this, 'setup_theme_mods' ) );
		}

		public function setup_theme_mods()
		{
			$this->themeMods = ace()->getThemeMods();
		}

	/**
	 * Tools
	**/
		/**
		 * Get Classes
		 * @return mixed[]
		**/
		public function get_all_classes()
		{
			return $this->get_all_params();
		}

		/**
		 * Get Classes
		 * @param string $key
		 * @param string $type : 'string' or 'array'
		 * @return mixed[]
		**/
		public function get_classes( $key, $type = 'string' )
		{
			$params = $this->get_params( $key );
			switch ( $type ) {
				case 'string':
					if ( false !== $params ) {
						return implode( $params, ' ' );
					}
					return '';
					break;
				case 'array':
					if ( false !== $params ) {
						return $params;
					}
					return array();
					break;
				default:
					return false;
			}
		}


		/**
		 * Get HTML Classes
		 * @param string $key     : Default ''
		 * @param array  $classes : Default array()
		 * @return array|string[]
		**/
		public function set_classes( $key = '', $classes = array() )
		{
			$data_html_classes = $this->get_data( $key );
			if ( false === $data_html_classes
				|| 'AceDataHTMLClass' !== get_class( $data_html_classes )
			) {
				$data_html_classes = AceDataHTMLClass::getInstance( $key );
			}
			if ( ! is_array( $classes )
				|| 0 >= count( $classes )
			) {
				return false;
			}
			$data_html_classes->set_classes( $classes );
			$this->data[ $key ] = $data_html_classes;
			return true;
		}

		/**
		 * Get HTML Classes
		 * @param string $key   : Default ''
		 * @param string $class : Default array()
		 * @return array|string[]
		**/
		public function add_class( $key = '', $class )
		{
			$data_html_classes = $this->get_data( $key );
			if ( false === $data_html_classes
				|| 'AceDataHTMLClass' !== get_class( $data_html_classes )
			) {
				$data_html_classes = AceDataHTMLClass::getInstance( $key );
			}
			if ( ! is_string( $class ) 
				|| '' === $class
			) {
				return false;
			}
			$data_html_classes->set_class( $class );
			$this->data[ $key ] = $data_html_classes;
			return true;
		}

		/**
		 * Get HTML Classes
		 * @param string $key     : Default ''
		 * @param array  $classes : Default array()
		 * @return array|string[]
		**/
		public function delete_class( $key = '', $class )
		{
			$html_classes = $this->data[ $key ];
			if ( false === $html_classes
				|| ! is_array( $html_classes )
				|| 0 >= count( $html_classes )
			) {
				$html_classes = array();
			}
			if ( ! is_string( $class ) 
				|| '' === $class
				|| array_search( $class, $this->html_classes[ $key ] )
			) {
				return false;
			}
			$this->html_classes[ $key ][] = $classes;
			return true;
		}

}

