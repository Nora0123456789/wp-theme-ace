<?php
# Check if This is read by WordPress.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'AceThemeCustomizer' ) ) {

/**
 * Theme Customizer Init
**/
class AceThemeCustomizer extends AceSanitizeMethods {

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
		 * Theme Mods
		 * 
		 * @var $theme_mods
		**/
		public $theme_mods = array();

		/**
		 * Icons
		 * 
		 * @var $icons
		**/
		public $icons = array();

		/**
		 * Post Types
		 * 
		 * @var $post_types
		**/
		public $post_types = array();

		/**
		 * Page Types
		 * 
		 * @var $page_types
		**/
		public $page_types = array();

		/**
		 * Widget Areas Settings
		 * 
		 * @var $widget_areas_settings
		**/
		public $widget_areas_settings = array();

		/**
		 * Animate CSS
		 * 
		 * @var $animate_css
		**/
		public $animate_css = array();

		/**
		 * Font Families
		 * 
		 * @var $fontFamilies
		**/
		public $basicFontFamily = array(
			'basic'   => '"YuMincho", "游明朝体", serif',
			'content' => '"YuMincho", "游明朝体", serif',
		);

		/**
		 * Font Families
		 * 
		 * @var $fontFamilies
		**/
		public $fontFamilies = array();

		/**
		 * Edge Types
		 * @var $designedEdgeTypes
		 */
		public $designedEdgeTypes = array();

		/**
		 * Edge Types
		 * @var $designedEdgeTypes
		 */
		public $palletColorSet = array(
			'rgba(255,255,255,0)',
			'rgba(255,255,255,1)',
			'rgba(255,255,60,1)',
			'rgba(255,120,60,1)',
			'rgba(120,60,255,1)',
			'rgba(60,180,120,1)',
			'rgba(0,0,0,1)',
		);

		/**
		 * Register Widget Areas
		 * 
		 * @var $widget_manager
		**/
		public $widget_manager = array();

		/**
		 * Register Widget Areas
		 * 
		 * @var $ace_theme_customizer_settings
		**/
		public $ace_theme_customizer_settings = array();

		/**
		 * AceThemeCustomizer_Settings
		 * 
		 * @var object $wp_customize
		**/
		public $wp_customize;

		/**
		 * Selective Refresh Availability
		 * 
		 * @var bool $can_selective_refresh
		**/
		public $can_selective_refresh;

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
		 * Constructors
		**/
		protected function __construct()
		{

			$this->initHooks();
			$this->initVars();

			// Actions
			// End Trigger
			do_action( ace()->getPrefixedActionHook( 'trigger_theme_customizer' ) );

		}

		protected function initVars()
		{

			// Define
				// Font Families
				$this->fontFamilies = ace()->getThemeModManager()->getFontFamilies();

				// Animation
				$this->animationClasses = ace()->getThemeModManager()->getAnimationClasses();

				// Image Sizes
				$this->backgroundImageSizes = ace()->getThemeModManager()->getThemeModsChoicesBackgroundSize();
				// Background Position Row
				$this->backgroundPositionRow = ace()->getThemeModManager()->getThemeModsChoicesBackgroundPositionRow();
				// Background Position Column
				$this->backgroundPositionColumn = ace()->getThemeModManager()->getThemeModsChoicesBackgroundPositionColumn();
				// Background Repeat
				$this->backgroundRepeats = ace()->getThemeModManager()->getThemeModsChoicesBackgroundRepeats();
				// Background Attachment
				$this->backgroundAttachments = ace()->getThemeModManager()->getThemeModsChoicesBackgroundAttachments();

				// Singular Header Style
				$this->singularHeaderStyle = ace()->getThemeModManager()->getThemeModsChoicesSingularHeaderStyles();
				// Singular Title Style
				$this->singularTitleStyle = ace()->getThemeModManager()->getThemeModsChoicesSingularTitleStyles();

				// Footer Align
				$this->footerAlign = ace()->getThemeModManager()->getThemeModsChoicesFooterAligns();

				// Text Align
				$this->textAlign = ace()->getThemeModManager()->getThemeModsChoicesTextAligns();

				// Designed Edge Types
				$this->designedEdgeTypes = ace()->getThemeModManager()->getThemeModsDesignedEdgeTypes();

		}

		protected function initHooks()
		{

			// Setup Theme Customizer
			add_action( 'customize_register', array( $this, 'initCustomizerControls' ), 0 ); 
			// Setup Theme Customizer
			add_action( 'customize_register', array( $this, 'setThemeCustomizer' ) ); 
			// Preview Scripts
			add_action( 'customize_preview_init', array( $this, 'themeCustomizerLivePreview' ), 11 );
			// Control Scripts
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'themeCustomizerControlScripts' ) );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'themeCustomizerControlFooterScripts' ) );

		}

		public function setupThemeMods()
		{
			// Theme Mods
			$this->themeMods = ace()->getThemeMods();
			$this->themeMods["blogname"] = ACE_SITE_NAME;
			$this->themeMods["blogdescription"] = ACE_SITE_DESCRIPTION;
		}

		/**
		 * Preview Scripts
		**/
		function themeCustomizerLivePreview()
		{

			$JSON = array(

				'themeDirectoryURI'         => get_template_directory_uri(),
				'themeAssetsJSDirectoryURI' => get_template_directory_uri() . '/assets/js/',

				'slidingItemType'           => esc_html__( 'Sliding Item Type', 'ace' ),
				'text'                      => esc_html__( 'Text', 'ace' ),
				'download'                  => esc_html__( 'Download', 'ace' ),
				'close'                     => esc_html__( 'Close', 'ace' ),
				'slidingImage'              => esc_html__( 'Sliding Images', 'ace' ),
				'itemD'                     => esc_html__( 'Item %d', 'ace' ),
				'select'                    => esc_html__( 'Select', 'ace' ),

				'topLeft'                   => esc_html__( 'Top Left', 'ace' ),
				'topCenter'                 => esc_html__( 'Top Center', 'ace' ),
				'topRight'                  => esc_html__( 'Top Right', 'ace' ),
				'bottomLeft'                => esc_html__( 'Bottom Left', 'ace' ),
				'bottomCenter'              => esc_html__( 'Bottom Center', 'ace' ),
				'bottomRight'               => esc_html__( 'Bottom Right', 'ace' ),
				'centerLeft'                => esc_html__( 'Center Left', 'ace' ),
				'centerCenter'              => esc_html__( 'Center', 'ace' ),
				'centerRight'               => esc_html__( 'CenterRight', 'ace' ),

				'itemContentTextD'          => esc_html__( 'Item Content Text %d', 'ace' ),
				'positionD'                 => esc_html__( 'Position %d', 'ace' ),
				'textColorD'                => esc_html__( 'Text Color %d', 'ace' ),
				'backgroundColorD'          => esc_html__( 'Background Color %d', 'ace' ),

				'mobileSidebar'             => esc_html__( 'Mobile Sidebar', 'ace' ),
				'beforePrimary'             => esc_html__( 'Before Content Area', 'ace' ),
				'beforeContent'             => esc_html__( 'Before the Content', 'ace' ),
				'beginningOfContent'        => esc_html__( 'At the Beginning of the Content', 'ace' ),
				'before1stH2OfContent'      => esc_html__( 'Before the First H2 tag of the Content', 'ace' ),
				'endOfContent'              => esc_html__( 'At the End of the Content', 'ace' ),
				'afterContent'              => esc_html__( 'After the Content', 'ace' ),
				'afterPrimary'              => esc_html__( 'After Content Area', 'ace' ),
				'inFooter'                  => esc_html__( 'In the Footer', 'ace' ),

				'all'         => __( 'Copyright © <span id="copyright-year">%1$d</span> <span class="ace-footer-site-name">%2$s</span> All Rights Reserved.', 'ace' ),
				'cc-by'       => __( 'CC-BY <span class="ace-footer-site-name">%1$s</span> Some Rights Reserved.', 'ace' ),
				'cc-by-sa'    => __( 'CC-BY-SA <span class="ace-footer-site-name">%1$s</span> Some Rights Reserved.', 'ace' ),
				'cc-by-nd'    => __( 'CC-BY-ND <span class="ace-footer-site-name">%1$s</span> Some Rights Reserved.', 'ace' ),
				'cc-by-nc'    => __( 'CC-BY-NC <span class="ace-footer-site-name">%1$s</span> Some Rights Reserved.', 'ace' ),
				'cc-by-nc-sa' => __( 'CC-BY-NC-SA <span class="ace-footer-site-name">%1$s</span> Some Rights Reserved.', 'ace' ),
				'cc-by-nc-nd' => __( 'CC-BY-NC-ND <span class="ace-footer-site-name">%1$s</span> Some Rights Reserved.', 'ace' ),
				'cc0'         => __( 'CC0 <span class="ace-footer-site-name">%1$s</span> No Rights Reserved.', 'ace' ),
				'public'      => __( 'Public Domain <span class="ace-footer-site-name">%1$s</span> No Rights Reserved.', 'ace' )
			);

			// Theme Customizer
			$theme_customizer_file_name = 'theme-customizer';
			if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) $theme_customizer_file_name .= '.min';
			wp_register_script( 'ace-theme-customizer', ACE_DIR_URL . sprintf( 'assets/js/theme-customizer/%s.js', $theme_customizer_file_name ), array( 'jquery', 'wp-i18n', 'customize-preview' ), true, false );

			wp_localize_script( 'ace-theme-customizer', 'aceThemeMods', $this->themeMods );
			wp_localize_script( 'ace-theme-customizer', 'aceThemeCustomizerObject', $JSON );
			wp_enqueue_script( 'ace-theme-customizer' );

		}

		/**
		 * Control Scripts
		**/
		function themeCustomizerControlScripts()
		{
			wp_enqueue_script( 'ace-link-ace-plus', ACE_DIR_URL . 'assets/js/theme-customizer/ace-plus.js', array( 'customize-controls' ) );
		}

		/**
		 * Control Scripts
		**/
		function themeCustomizerControlFooterScripts()
		{

			wp_enqueue_style( 'customizer-alpha-color-picker' );
			wp_enqueue_script( 'customizer-alpha-color-picker' );

		}

	/**
	 * 
	 * 
	 */
	public function initCustomizerControls( $wp_customize )
	{
		// Theme Mods
			$this->setupThemeMods();

		// 3rd
			if ( ! class_exists( 'Customizer_Alpha_Color_Control' ) ) require_once( 'customizer-controls/customizer-alpha-color-picker/class-customizer-alpha-color-control.php' );

			if ( ! class_exists( 'Font_Selector' ) ) require_once( 'customizer-controls/customizer-font-selector/class/class-font-selector.php' );

			if ( ! class_exists( 'Customizer_Page_Editor' ) ) require_once( 'customizer-controls/customizer-page-editor/class/class-customizer-page-editor.php' );

			if ( ! class_exists( 'Customize_Control_Radio_Image' ) ) require_once( 'customizer-controls/customizer-radio-image/class/class-customize-control-radio-image.php' );

			if ( ! class_exists( 'Customizer_Range_Value_Control' ) ) require_once( 'customizer-controls/customizer-range-control/class/class-customizer-range-value-control.php' );
			
			if ( ! class_exists( 'Customizer_Repeater' ) ) require_once( 'customizer-controls/customizer-repeater/class/class-customizer-repeater.php' );

			if ( ! class_exists( 'Customizer_Select_Multiple' ) ) require_once( 'customizer-controls/customizer-select-multiple/class/class-customizer-select-multiple.php' );
			
			if ( ! class_exists( 'Customizer_Tabs_Control' ) ) require_once( 'customizer-controls/customizer-tabs/class/class-customizer-tabs-control.php' );

		// Ace
			// Alpha Color Picker
			if ( ! class_exists( 'AceCustomizerAlphaColorControl' ) ) require_once( 'customizer-controls/class-ace-customizer-alpha-color-control.php' );
			// Font Selector
			if ( ! class_exists( 'AceFontSelector' ) ) require_once( 'customizer-controls/class-ace-customizer-font-selector.php' );
			// Page Editor
			if ( ! class_exists( 'AceCustomizerPageEditor' ) ) require_once( 'customizer-controls/class-ace-customizer-font-selector.php' );
			// Radio Image
			if ( ! class_exists( 'AceCustomizerControlRadioImage' ) ) require_once( 'customizer-controls/class-ace-customizer-control-radio-image.php' );
			// Range Control
			if ( ! class_exists( 'AceCustomizerPageEditor' ) ) require_once( 'customizer-controls/class-ace-customizer-font-selector.php' );
			// Customizer Repeater
			if ( ! class_exists( 'AceCustomizerRepeater' ) ) require_once( 'customizer-controls/class-ace-customizer-repeater.php' );
			// Section Order
			if ( ! class_exists( 'AceCustomizerSectionsOrder' ) ) require_once( 'customizer-controls/class-ace-customizer-sections-order.php' );
			// Select Multiple
			if ( ! class_exists( 'AceCustomizerSelectMultiple' ) ) require_once( 'customizer-controls/class-ace-customizer-select-multiple.php' );
			// Tabs Control
			if ( ! class_exists( 'AceCustomizerTabsControl' ) ) require_once( 'customizer-controls/class-ace-customizer-tabs-control.php' );
			// Link Section
			if ( ! class_exists( 'AceCustomizerLinkSection' ) ) require_once( 'customizer-controls/class-ace-customizer-link-section.php' );

	}

	/**
	 * Setup Theme Customizer
	 * 
	 * @see $this->set_wp_default_theme_mods()
	 * @see $this->set_wrapper_theme_mods()
	 * @see $this->set_header_theme_mods()
	 * @see $this->set_nav_menu_theme_mods()
	 * @see $this->set_content_area_theme_mods()
	 * @see $this->set_archive_page_theme_mods()
	 * @see $this->set_singular_page_theme_mods()
	 * @see $this->set_footer_theme_mods()
	 * @see $this->set_standard_widget_areas_theme_mods()
	 * @see $this->set_others_theme_mods()
	**/
	function setThemeCustomizer( $wp_customize )
	{

		// Layout
		include_once( 'parts/layout.php' );

		// Header
		include_once( 'parts/header.php' );

		// Content Area
		include_once( 'parts/main.php' );

			// Singular
			include_once( 'parts/singular.php' );

			// Archive
			include_once( 'parts/archive.php' );

		// Footer
		include_once( 'parts/footer.php' );

		// Standard Widget Areas
		include_once( 'parts/swa.php' );

		// Link to Ace+
		if ( ! class_exists( 'AcePlus' ) ) include_once( 'parts/ace-plus.php' );

		do_action( ace()->getPrefixedActionHook( 'customize_register' ), $wp_customize );

	}

		/**
		 * Optional Widget Areas
		**/
		public function setThemeCustomizerOwa()
		{
		}

		/**
		 * Skin
		**/
		public function setThemeModsSkin()
		{

		}

		public function setThemeModsArchiveArticle()
		{
			
		}

} // End Closure

}

