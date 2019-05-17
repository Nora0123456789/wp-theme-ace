<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Frontend
 * 
**/
class AceFrontendPostMetaManager {

	/**
	 * Static
	**/
		/**
		 * Instance
		 * @var AceFrontendPostMetaManager
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * Array
		 * @var array
		**/
		protected $postmeta = array();

		/**
		 * Is Max Width for the One Column
		 */
		protected $isMaxWidthOneColumn = false;

		/**
		 * Deactivate Widget Areas
		 * @var array
		**/
		public $deactivateWidgetAreas = array();

		public function getDeactivateWidgetAreas()
		{
			return $this->deactivateWidgetAreas;
		}

	/**
	 * Init
	**/
		/**
		 * Public initializer
		 * @return AceFrontendPostMetaManager
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
			$this->initVars();
			$this->initHooks();
		}

		/**
		 * Init vars
		**/
		protected function initVars()
		{
		}

		/**
		 * Init hooks
		**/
		protected function initHooks()
		{
			add_action( ace()->getPrefixedActionHook( 'init_frontend_post_meta' ), array( $this, 'setupPostMetaVarsForContents' ), 1 );
		}

	/**
	 * Setup for Post Meta
	**/
	function setupPostMetaVarsForContents()
	{

		if ( is_admin() ) {
			return;
		}

		global $wp_query, $post;

		if ( is_home() && is_front_page() ) { # Home
			return;
		} elseif ( is_front_page() ) { # Front Page

			$post_id = intval( $post->ID );

		} elseif ( is_home() ) { # Blog

			$home_id = intval( get_option( 'page_for_posts' ) );
			$post_id = intval( $home_id );

		} elseif ( is_singular() ) { # Singular

			$post_id = intval( $post->ID );

		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

			if ( is_shop() ) {
				$post_id = wc_get_page_id( 'shop' );
			} elseif ( is_product() ) {
				$post_id = absint( $post->ID );
			}


		} else {

		}

		// Setup for Post Meta
		if ( isset( $post_id ) ) 
			$this->setPostMetaVarsWithPostId( $post_id );

	}

	/**
	 * Setup for Post Meta
	 * 
	 * @param int $post_id
	**/
	function setPostMetaVarsWithPostId( $post_id )
	{

		$this->postmeta = get_post_meta( $post_id );

		// Remove Data Except "index: 0"
			if ( is_array( $this->postmeta ) ) { 
				foreach( $this->postmeta as $index => $data ) {
					$this->postmeta[ $index ] = esc_attr( 
						isset( $data[ 0 ] ) 
							&& ( $data[ 0 ] != '' ) 
						? $data[ 0 ]
						: ''
					);
				} 
			}

		// Settings for Deactivation of Widget Areas
			$deactivate_widget_area = get_post_meta( $post_id, ace()->getPrefixedThemePostMetaName( 'deactivate_widget_area' ), true );
			$this->deactivateWidgetAreas = ( 
				( is_array( $deactivate_widget_area ) 
					&& ! empty( $deactivate_widget_area )
				)
				? $deactivate_widget_area
				: array()
			);
			unset( $deactivate_widget_area );

		// For One Column Page Width Size Check
			$this->isMaxWidthOneColumn = (
				get_post_meta( $post_id, ace()->getPrefixedThemePostMetaName( 'is_one_column_page_width_size_max' ), false ) !== array()
				? get_post_meta( $post_id, ace()->getPrefixedThemePostMetaName( 'is_one_column_page_width_size_max' ), true )
				: false
			);

		// Do Action at the End
			do_action( ace()->getPrefixedActionHook( 'setup_post_meta_vars_with_post_id' ), $post_id );

	}


}

