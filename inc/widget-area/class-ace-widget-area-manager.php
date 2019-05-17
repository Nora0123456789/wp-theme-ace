<?php
class AceWidgetAreaManager {

	/**
	 * Static
	**/
		/**
		 * Instance of this Class
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * Options
		 * @var array
		**/
		public $options = array();

		protected $deactivateWidgetAreas = array();

		protected $theme_mods = array();

		/**
		 * Optional Widget Area Data
		 * @var array
		**/
		public $standardWidgetAreas = array();

		public function getStandardWidgetAreas()
		{
			return $this->standardWidgetAreas;
		}

		/**
		 * Optional Widget Area Data
		 * @var array
		**/
		public $optionalWidgetAreas = array();

		public function getOptionalWidgetAreas()
		{
			return $this->optionalWidgetAreas;
		}

		/**
		 * Optional Widget Area Data
		 * @var array
		**/
		public $swaHsk = array(
			'in_header'          => 'in-header',
			'column_left'        => 'column-left',
			'column_left_fixed'  => 'column-left-fixed',
			'column_right'       => 'column-right',
			'column_right_fixed' => 'column-right-fixed',
			'slidebar_left'      => 'slidebar-left',
			'slidebar_right'     => 'slidebar-right',
			'sidebar_mobile'     => 'sidebar-mobile',
		);

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct() {

			$this->initSwaVars();
			$this->initHooks();

			do_action( ace()->getPrefixedActionHook( 'init_widget_area_manager' ) );

		}

		protected function initSwaVars()
		{

			$swa_names = array(
				'in_header'          => esc_html__( 'In Header', 'ace' ),
				'slidebar_left'          => esc_html__( 'Slidebar Left', 'ace' ),
				'column_left'          => esc_html__( 'Column Left', 'ace' ),
				'column_left_fixed'          => esc_html__( 'Column Left Fixed', 'ace' ),
				'slidebar_right'          => esc_html__( 'Slidebar Right', 'ace' ),
				'column_right'          => esc_html__( 'Column Right', 'ace' ),
				'column_right_fixed'          => esc_html__( 'Column Right Fixed', 'ace' ),
				'sidebar_mobile'          => esc_html__( 'Mobile Slidebar', 'ace' ),
			);

			$swa_descs = array(
				'in_header'          => esc_html__( 'Located in Header.', 'ace' ),
				'slidebar_left'      => esc_html__( 'Slidebar located on the left of the window. This widget area is NOT Displayed in Mobile.', 'ace' ),
				'column_left'        => esc_html__( 'Widget Area located on the left of the main content. This widget area is NOT Displayed in Mobile.', 'ace' ),
				'column_left_fixed'  => esc_html__( 'Widget Area located below Column Left that can be fixed. This widget area is NOT Displayed in Mobile.', 'ace' ),
				'slidebar_right'     => esc_html__( 'Slidebar located on the right of the window. This widget area is NOT Displayed in Mobile.', 'ace' ),
				'column_right'       => esc_html__( 'Widget Area located on the right of the main content. This widget area is NOT Displayed in Mobile.', 'ace' ),
				'column_right_fixed' => esc_html__( 'Widget Area located below Column Right that can be fixed. This widget area is NOT Displayed in Mobile.', 'ace' ),
				'sidebar_mobile'     => esc_html__( 'This is the Slidebar on Right Side which is displayed ONLY in Mobile Page. This Area Shows and Hides when Button "Widget" at the bottom is clicked.', 'ace' ),
			);

			$this->standardWidgetAreas = array();
			foreach ( $this->swaHsk as $id => $class_key ) {

				$enter_animation_key = sprintf( 'swa_%s_widget_animation_enter', $id );
				$hide_animation_key = sprintf( 'swa_%s_widget_animation_hide', $id );
				$enter_animation_classes = 'with-enter-animation ' . get_theme_mod( $enter_animation_key, 'none' ) . ' ready';
				$hide_animation_classes = 'with-hide-animation ' . get_theme_mod( $hide_animation_key, 'none' ) . '';
				$widget_class = 'widget ' . $enter_animation_classes . ' ' . $hide_animation_classes . ' %s';

				$this->standardWidgetAreas[ $id ] = array(
					'id'            => $id,
					'class'         => $class_key,
					'name'          => $swa_names[ $id ],
					'description'   => $swa_descs[ $id ],
					'before_widget' => '<li class="widget-li ' . $class_key . '"><div id="%s" class="' . $widget_class . '">',
					'after_widget'  => '</div></li>',
					'before_title'  => '<div class="widget-title ' . $class_key . '"><span class="widget-title-text hoverable running-underline hover-text-shadow">',
					'after_title'   => '</span></div>',
				);
			}

		}

		/**
		 * Init WP Hooks
		**/
		protected function initHooks() {

			// Register Widget Areas
			add_action( 'widgets_init', array( $this, 'registerWidgetAreas' ), 10 );

			// Enqueue Scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );

			// Render
				// Standard
					if ( ! wp_is_mobile() ) {
						add_action( ace()->getPrefixedActionHook( 'wp_footer' ), array( 'AceWidgetAreaManager', 'getSlidebarLeftt' ) );
						add_action( ace()->getPrefixedActionHook( 'wp_footer' ), array( 'AceWidgetAreaManager', 'getSlidebarRight' ) );	
					} else {
						add_action( ace()->getPrefixedActionHook( 'wp_footer' ), array( 'AceWidgetAreaManager', 'renderWidgetAreaMobileMenu' ) );	
					}
				
	}

	/**
	 * Actions
	**/
		/**
		 * Register Widget Areas
		**/
		function registerWidgetAreas() {

			foreach ( $this->standardWidgetAreas as $id => $data ) {
				$widget_area = AceWidgetArea::getInstance( $id, $data );
				if ( $widget_area instanceof AceWidgetArea ) {
					$this->standardWidgetAreaHolder[ $id ] = $widget_area;
				}
			}

			// 
			if ( ! in_array( current_filter(), array( 'widgets_init' ) ) 
				|| ! is_array( $this->standardWidgetAreas )
				|| 0 >= count( $this->standardWidgetAreas )
			) {
				return;
			}

			// Standard Widget Areas
			foreach( $this->standardWidgetAreas as $id => $data ) {
				$widget_area = $this->standardWidgetAreaHolder[ $id ];
				$widget_area->registerSidebar();
			}

			// Optional Widget Areas
			foreach( $this->optionalWidgetAreas as $id => $widget_area ) {
				register_sidebar( $widget_area );
			}

		}

		/**
		 * Enqueue Scripts
		 * 
		 * @param string $hook
		 * 
		 * @return void
		**/
		function adminEnqueueScripts( $hook ) {

			// ウィジェットの編集画面用
			//if( 'widgets.php' == $hook ){

				wp_enqueue_style( 'wp-color-picker' );		
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_media();
				
				wp_enqueue_style( 'ace-widget-settings-form' );
				wp_enqueue_script( 'ace-widget-settings' );


			//}

		}

	/**
	 * Render
	**/
		/**
		 * Standard Widget Areas
		**/
			/**
			 * Get Widget Area
			 * @param string $id
			 * @return bool|AceWidget_Area
			**/
			public function getWidgetArea( $id )
			{
				if ( is_string( $id )
					&& '' !== $id
					&& isset( $this->standardWidgetAreaHolder[ $id ] ) 
					&& $this->standardWidgetAreaHolder[ $id ] instanceof AceWidget_Area
				) {
					return $this->standardWidgetAreaHolder[ $id ];
				}
				return false;
			}

			/**
			 * Print Template for Standard Widget Areas
			 * 
			 * @param string $id
			 * @param string $class
			 * @param string $wrapper_start
			 * @param string $wrapper_end
			 * 
			 * @see self::getStandardWidgetAreaByHook( $id, $class, $wrapper_start, $wrapper_end )
			**/
			public static function renderStandardWidgetareaByHook( $id, $class, $wrapper_start, $wrapper_end ) {
				echo self::getStandardWidgetAreaByHook( $id, $class, $wrapper_start, $wrapper_end );
			}

			/**
			 * Get Template for Standard Widget Areas
			 * 
			 * @param string $id
			 * @param string $class
			 * @param string $wrapper_start
			 * @param string $wrapper_end
			 * 
			 * @see $this->getFilteredStandardWidgetAreaByHook( $widget_area, $class )
			 * 
			 * @return string
			**/
			public static function getStandardWidgetAreaByHook( $id, $class, $wrapper_start, $wrapper_end ) {

				global $wp_registered_sidebars;

				$html = '';
				ob_start();


				// Outputs by Post Meta Setting of Plugin
				do_action( ace()->getPrefixedActionHook( 'render_in_widget_area' ), $wp_registered_sidebars[ $id ] );

				// Check Active or not
				$deactivateWidgetAreas = apply_filters( ace()->getPrefixedFilterHook( 'post_meta_deactivate_widget_areas' ), array() );
				//if ( in_array( $id, ace()->getFrontendManager()->getPostMetaManager()->deactivateWidgetAreas ) ) {
				if ( in_array( $id, $deactivateWidgetAreas ) ) {
				} else {
					if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( $id ) ) {}
				}

				$html .= ob_get_clean();
				if ( '' === $html ) {
					return '';
				}

				return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area' ), $wrapper_start . $html . $wrapper_end, $id );

			}

			// In Header
				/**
				 * Render Header Widget Area
				 * 
				 * @uses self::getHeaderWidgetArea()
				 * 
				 * @return void
				**/
				public static function renderHeaderWidgetArea() {
					echo self::getHeaderWidgetArea();
				}

				/**
				 * Get Header Widget Area
				 * 
				 * @uses self::getStandardWidgetAreaByHook()
				 * @return string
				**/
				public static function getHeaderWidgetArea() {
					return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_in_header' ), self::getStandardWidgetAreaByHook( 
						'in_header',
						'in-header',
						'<div class="widget-area in-header"><ul class="widget-list in-header">',
						'</ul></div>'
					) );
				}

			// Slider Left
				/**
				 * Print Template of Standard Widget Area Slidebar Left
				 * 
				 * @see self::getSlidebarLeft()
				**/
				public static function slidebarLeft() {
					echo self::getSlidebarLeft();
				}

				/**
				 * Get Template of Standard Widget Area Slidebar Left
				 * 
				 * @param string $html
				 * @param string $class
				 * 
				 * @see self::getStandardWidgetAreaByHook( $id, $class, $wrapper_start, $wrapper_end )
				 * 
				 * @return string
				**/
				public static function getSlidebarLeft() {

					$animate_class = '';
					$animation_type = '';
					$animation_enter = ace()->getThemeMod( 'slidebar_left_area_animation_enter' );
					if( $animation_enter !== 'none' ) {
						$animate_class = ' ace-hidden enter-animated';
						$animation_type = ' data-animation-enter="' . esc_attr( $animation_enter ) . '"';
					}

					return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_slidebar_left' ),
						self::getStandardWidgetAreaByHook( 
							'slidebar_left',
							'slidebar-left',
							'<div class="widget-area-wrapper slidebar-left"><div class="widget-area slidebar-left slide-box' . esc_attr( $animate_class ) . '"' . $animation_type . '><ul class="widget-list slidebar-left slide-box">',
							'</ul></div></div><a class="slidebar-left-container-trigger pulse" href="javascript: void( 0 );" data-open-class="slidebar-left-open" data-either="left"><i class="slide-trigger-icon nora-glyph circle arrows right font-size-3" data-icon="right"></i></a>'
						)
					);

				}

			// Slider Right
				/**
				 * Print Template of Standard Widget Area Slidebar Right
				 * 
				 * @see self::getSlidebarLeft()
				**/
				public static function slidebarRight() {
					echo self::getSlidebarRight();
				}

				/**
				 * Get Template of Standard Widget Area Slidebar Right
				 * 
				 * @see self::getStandardWidgetAreaByHook( $id, $class, $wrapper_start, $wrapper_end )
				 * 
				 * @return string
				**/
				public static function getSlidebarRight() {

					$animate_class = '';
					$animation_type = '';
					$animation_enter = ace()->getThemeMod('slidebar_right_area_animation_enter');
					if( $animation_enter !== 'none' ) {
						$animate_class = ' ace-hidden enter-animated';
						$animation_type = ' data-animation-enter="' . esc_attr( $animation_enter ) . '"';
					}

					return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_slidebar_right' ),
						self::getStandardWidgetAreaByHook( 
							'slidebar_right',
							'slidebar-right',
							'<div class="widget-area-wrapper slidebar-right"><div class="widget-area slidebar-right' . $animate_class . '"' . $animation_type . '><ul class="widget-list slidebar-right slide-box">',
							'</ul></div></div><a class="slidebar-right-container-trigger pulse" href="javascript: void( 0 );" data-open-class="slidebar-right-open" data-either="right"><i class="slide-trigger-icon nora-glyph circle arrows left font-size-3" data-icon="left"></i></a>'
						)
					);

				}

			// Mobile
				/**
				 * Print Template of Mobile Wdidget Area Right Side
				 * 
				 * @see $this->getWidgetAreasMobileMenu()
				**/
				public static function renderWidgetAreaMobileMenu() {
					echo self::getWidgetAreaMobileMenu();
				}

				/**
				 * Get Template of Mobile Wdidget Area Right Side
				 * 
				 * @see self::getStandardWidgetAreaByHook( $id, $class, $wrapper_start, $wrapper_end )
				 * 
				 * @return string
				**/
				public static function getWidgetAreaMobileMenu() {

					return apply_filters( 
						ace()->getPrefixedFilterHook( 'render_widget_area_sidebar_mobile' ),
						self::getStandardWidgetAreaByHook( 
							'sidebar_mobile',
							'sidebar-mobile',
							'<div class="widget-area sidebar-mobile"><ul class="widget-list sidebar-mobile">',
							'</ul></div>'
						)
					);

				}

			// Sidebar Left
				// Column Left
					public static function renderWidgetAreaColumnLeft()
					{
						echo self::getWidgetAreaColumnLeft();
					}

					public static function getWidgetAreaColumnLeft()
					{

						return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_column_left' ),
							self::getStandardWidgetAreaByHook( 
								'column_left',
								'column-left',
								'<div class="widget-area column-left"><ul class="widget-list column-left">',
								'</ul></div>'
							)
						);

					}

				// Column Left Fixed
					public static function renderWidgetAreaColumnLeftFixed()
					{
						echo self::getWidgetAreaColumnLeftFixed();
					}

					public static function getWidgetAreaColumnLeftFixed()
					{

						return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_column_left_fixed' ),
							self::getStandardWidgetAreaByHook( 
								'column_left_fixed',
								'column-left-fixed',
								'<div class="widget-area column-left-fixed"><ul class="widget-list column-left-fixed">',
								'</ul></div>'
							)
						);

					}


			// Sidebar Right
				// Column Left
					public static function renderWidgetAreaColumnRight()
					{
						echo self::getWidgetAreaColumnRight();
					}

					public static function getWidgetAreaColumnRight()
					{

						return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_column_right' ),
							self::getStandardWidgetAreaByHook( 
								'column_right',
								'column-right',
								'<div class="widget-area column-right"><ul class="widget-list column-right">',
								'</ul></div>'
							)
						);

					}

				// Column Left Fixed
					public static function renderWidgetAreaColumnRightFixed()
					{
						echo self::getWidgetAreaColumnRightFixed();
					}

					public static function getWidgetAreaColumnRightFixed()
					{

						return apply_filters( ace()->getPrefixedFilterHook( 'render_widget_area_column_right_fixed' ),
							self::getStandardWidgetAreaByHook( 
								'column_right_fixed',
								'column-right-fixed',
								'<div class="widget-area column-right-fixed"><ul class="widget-list column-right-fixed">',
								'</ul></div>'
							)
						);

					}


}

