<?php
if ( ! class_exists( 'AceAdminManager' ) ) {
/**
 * Admin
**/
class AceAdminManager {

	/**
	 * Static
	**/
		/**
		 * Instance of this Class
		 * 
		 * @var $instance
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * Options in Array
		 * 
		 * @var $options
		**/
		protected $options = array();

		/**
		 * Admin Page Manager
		 * @var AceAdminPageManager
		**/
		protected $adminPageManager = null;

		/**
		 * Get Admin Page Manager
		 * @return AceAdminPageManager
		**/
		public function getAdminPageManager()
		{
			return $this->adminPageManager;
		}

		/**
		 * Meta Box Manager
		 * @var AceAdminMetaBoxManager
		**/
		protected $metabox_manager = null;

		/**
		 * Get Meta Box Manager
		 * @return AceAdminMetaBoxManager
		**/
		public function get_metabox_manager()
		{
			return $this->metabox_manager;
		}

		/**
		 * Meta Box Manager
		 * @var AceAdminMetaBoxManager
		**/
		protected $notification_manager = null;

		/**
		 * Get Meta Box Manager
		 * @return AceAdminMetaBoxManager
		**/
		public function get_notification_manager()
		{
			return $this->notification_manager;
		}

	#
	# Init
	#
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
			$this->initClasses();
			$this->initHooks();
			do_action( ace()->getPrefixedActionHook( 'init_admin_manager' ), $this );
		}

		/**
		 * Init Classes
		**/
		protected function initClasses()
		{
			// Admin Page Manager
			$this->adminPageManager = AceAdminPageManager::getInstance();
		}

		/**
		 * Init WP Hooks
		**/
		protected function initHooks() {

			// Save Style
				// When Fonts Saved

				// Enqueue Scripts
					add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );

				// JS Templates
					add_action( 'admin_print_footer_scripts', array( $this, 'append_js_templates' ) );

			// Filters
				add_filter( 'default_content', array( $this, 'set_default_content_text' ) );

		}

	/**
	 * Hooks
	**/
		/**
		 * Enqueue Scripts
		 * 
		 * @param string $hook
		**/
		public function adminEnqueueScripts( $hook ) {

			wp_enqueue_media();
				
			// Theme Settings
			if( 'appearance_page_theme_settings_menu' == $hook ) {

			}

			// For Edit Widget
			//if( 'widgets.php' == $hook ){

				wp_enqueue_style( 'ace-widget-settings-form' );

				wp_enqueue_script( 'widgets-get-images_js' );
				wp_enqueue_script( 'ace-widget-settings' );

			//}

			// Script to update User Meta not to display message
			wp_enqueue_script( 'ace-user-meta-notifications-dismiss' );
			
		}

		/**
		 * JS Templates
		**/
		public function append_js_templates() {

			echo '<div class="ace-popup-background"></div>';

			//include_once( ACE_DIR_PATH . 'template/admin-js/page-builder.php' );

		}

		/**
		 * Default Content
		 * 
		 * @param string $content 
		 * 
		 * @return string
		**/
		public function set_default_content_text( $content ) {

			//return $content . html_entity_decode( $this->options['injections']->getProp( 'content_editor' ) );

		}

	/**
	 * Need fix
	**/

}
}

