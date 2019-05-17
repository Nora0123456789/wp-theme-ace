<?php 
if( ! defined( 'ABSPATH' ) ) exit; 

/**
 * 
**/
class AceAdminPage extends AceUniqueAbstract {

	/**
	 * Static
	**/
		protected static $instance;

	/**
	 * Properties
	**/
		/**
		 * Page Title
		 * @var string
		**/
		protected $pageTitle = 'Ace';

		/**
		 * Menu Title
		 * @var string
		**/
		protected $menuTitle = 'Ace';

		/**
		 * Page
		 * @var string
		**/
		protected $menuSlug = 'ace-admin';

		/**
		 * Capability
		 * @var string
		**/
		protected $capability = 'manage_options';

		/**
		 * Page
		 * @var string
		**/
		protected $method = 'render';

		/**
		 * Form Template 
		 * @var string
		**/
		protected $formTemplate = 'view/admin-menu-page.php';

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		 * @return AceAdminPage
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct()
		{
			$this->init();
			$this->initHooks();
			do_action( ace()->getPrefixedActionHook( 'init_admin_menu_page' ), $this );
		}
		
		/**
		 * Init
		**/
		protected function init() {}

		/**
		 * Init hooks
		**/
		protected function initHooks()
		{
			add_action( 'admin_menu', array( $this, 'adminMenu' ) );
			add_action( 'admin_notices', array( $this, 'optionUpdateMessage' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
		}

		/**
		 * Init hooks
		 * @param string $hook
		**/
		public function adminEnqueueScripts( $hook ) {

			global $pagenow;
			if ( isset( $pagenow ) && is_string( $pagenow ) && 'themes.php' === $pagenow 
				&& isset( $_GET['page'] ) && is_string( $_GET['page'] ) && 'ace-admin' === $_GET['page']
			) {
				wp_enqueue_script( 'ace-admin-theme-page' );
			}

		}

		function optionUpdateMessage() {
			
			if( !empty( $_REQUEST['settings-updated'] )
				&& isset( $_REQUEST['page'] )
				&& $_REQUEST['page'] === $this->menuSlug
			) echo '<div class="updated"><p>' . __( 'Saved.', 'ace' ) . '</p></div>';
			
		}

		public function adminMenu() {

			$has_admin_page = apply_filters(
				ace()->getPrefixedFilterHook( 'init_admin_menu' ),
				false
			);

			if ( ! $has_admin_page ) {
				add_theme_page(
					$this->pageTitle,
					$this->menuTitle,
					$this->capability,
					$this->menuSlug,
					array( $this, $this->method )
				);
			}

		}
		
		public function render() {

            if ( ! is_string( $this->formTemplate ) || '' === $this->formTemplate ) return;

			include( $this->formTemplate );

		}

		public function renderFeed( $title, $uri )
		{

			$feed = fetch_feed( $uri );

			$items = $feed->get_items( 0, 5 );
			
			if ( ! is_array( $items ) || 0 >= count( $items ) ) {
				echo '<p class="admin-menu-page-notice no-feed-items">';
					esc_html_e( 'No Posts', 'ace' );
				echo '</p>';
				return;
			}

			echo '<div class="feed-wrapper">';
				echo '<h2 class="feed-title">' . $title . '</h2>';
				echo '<div class="feed-item-list">';
					foreach ( $items as $item ) {
						include( 'view/tab-menu-list/updates/feed-list-item.php' );
						//$this->renderFeedListItem( $item );
					}
				echo '</div>';
			echo '</div>';
			
		}


}

