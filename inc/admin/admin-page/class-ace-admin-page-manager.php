<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class AceAdminPageManager extends AceUniqueAbstract {

	/**
	 * Static
	**/
		/**
		 * Instance
		 * @var AceAdminPageManager
		**/
		protected static $instance;

		/**
		 * Instance
		 * @var array
		**/
		public static $theme_menu = array();

	/**
	 * Properties
	**/
		private $options = array();

		private $enqueuedPage = array(
			'fe_settings' => 'ace_frontend_settings',
			'custom_css_settings' => 'ace_custom_css_settings',
			'custom_font_settings' => 'ace_custom_font_settings',
		);

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		 * @return AceAdminPageManager
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
			$this->initClasses();
			$this->initHooks();
		}
		
		protected function init()
		{

		}

		protected function initClasses()
		{
			$this->adminPage = AceAdminPage::getInstance();
		}

		protected function initHooks()
		{
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
		}

		public function adminEnqueueScripts( $hook )
		{

			if ( ! isset( $_GET['page'] ) || ! in_array( $_GET['page'], $this->enqueuedPage ) ) {
				return;
			}

			// CSS
				wp_enqueue_style( 'ace-admin-page' );
			// JS

			// Frontend Settings
			if( $this->enqueuedPage['fe_settings'] === $_GET['page'] ) {

				// CSS
					wp_enqueue_style( 'ace-admin-page-fe-settings' );

			}

			// Custom CSS Settings
			elseif ( $this->enqueuedPage['custom_css_settings'] === $_GET['page'] ) {

			}

			// Custom Font Settings
			elseif ( $this->enqueuedPage['custom_font_settings'] === $_GET['page'] ) {

				// JS
					wp_enqueue_script( 'ace-admin-custom-fonts' );

			}

		}

	// Separator 
		function addSdminMenuSeparator( $position ) {
			global $menu;
			$index = 0;
			foreach($menu as $offset => $section) {
				if (substr($section[2],0,9)=='separator')
					$index++;
				if ($offset>=$position) {
					$menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
					break;
				}
			}
			ksort( $menu );
		}



	/**
	 * Sanitize Methods
	 * @param  [type] $general [description]
	 * @return [type]          [description]
	**/
		public static function sanitizeGeneral( $general )
		{
			
			if( is_array( $general ) ) { foreach( $general as $index => $settings ) {
				if( $index == 'default_settings_tab' ) 
					$general[ $index ] =  sanitize_text_field( $settings );

			} }

			return $general;
		}

		public static function sanitizeActivations( $activations )
		{
			
			if( is_array( $activations ) ) { foreach( $activations as $index => $settings ) {
				$activations[ $index ] =  sanitize_text_field( $settings );
			} }

			return $activations;
		}

		public static function sanitizeNotDisplayPostFormats( $not_display_post_formats )
		{
			
			if( is_array( $not_display_post_formats ) ) { foreach( $not_display_post_formats as $index => $settings ) {
				$not_display_post_formats[ $index ] =  sanitize_text_field( $settings );
			} }

			return $not_display_post_formats;
		}

		public static function sanitizeRemoveActions( $remove_actions )
		{
			
			if( is_array( $remove_actions ) ) { foreach( $remove_actions as $index => $settings ) {
				$remove_actions[ $index ] =  sanitize_text_field( $settings );
			} }

			return $remove_actions;
		}

		public static function sanitizeInjections( $injections )
		{

			$for_sanitize_absint = array( 'excerpt_length' );

			$for_sanitize_text_field = array();
			
			$for_esc_textarea = array( 'content_editor', 'header_code', 'after_start_body_code', 'footer_code' );

			if( is_array( $injections ) ) { foreach( $injections as $index => $settings ) {
				if( in_array( $index, $for_sanitize_text_field ) )
					$injections[ $index ] = sanitize_text_field( $settings );
				if( in_array( $index, $for_esc_textarea ) )
					$injections[ $index ] = esc_textarea( html_entity_decode( preg_replace( '/\\\([\'"])/i', '$1', $settings ) ) );
				if( in_array( $index, $for_sanitize_absint ) ) {
					$injections[ $index ] = ( 
						intval( $settings ) < 1
						? 20 
						: intval( $settings ) 
					);
				}
			} }

			return $injections;

		}

		public static function sanitizeSpeedAdjust( $speed_adjust )
		{
			
			$for_sanitize_text_field = array( 
				'no_jetpack_css', 'no_jquery'
			);

			if( is_array( $speed_adjust ) ) { foreach( $speed_adjust as $index => $settings ) {
				if( in_array( $index, $for_sanitize_text_field ) )
					$speed_adjust[ $index ] =  sanitize_text_field( $settings );
			} }

			return $speed_adjust;

		}

		public static function sanitizeWidgetAreas( $widget_areas )
		{

			$for_sanitize_text_field = array( 'hook', 'width', 'is_on_mobile_menu', 'id', 'class' );

			$for_esc_textarea = array( 'description', 'before_widget', 'after_widget', 'before_title', 'after_title' );

			if( is_array( $widget_areas ) ) { foreach( $widget_areas as $number => $settings ) {

				if ( ! isset( $widget_areas[ $number ]['is_on_mobile_menu'] ) ) {
					$widget_areas[ $number ]['is_on_mobile_menu'] = '';
				}

				foreach( $settings as $index => $setting ) {

					if( in_array( $index, $for_sanitize_text_field ) )
						$widget_areas[ $number ][ $index ] =  sanitize_text_field( $setting );
					
					if( in_array( $index, $for_esc_textarea ) )
						$widget_areas[ $number ][ $index ] =  esc_textarea( html_entity_decode( preg_replace( '/\\\([\'"])/i', '$1', $setting ) ) );

				}
			} } else { $widget_aeras = array(); }

			return $widget_areas;

		}

		public static function sanitizeSeos( $seos )
		{

			$for_sanitize_text_field = array( 'json_ld_logo', 'json_ld_markup_on', 'canonical_link_on', 'meta_robots_on', 'meta_description_on', 'meta_keywords_on', 'twitter_card_on', 'twitter_card_account', 'open_graph_on', 'tc_og_image' );

			if( is_array( $seos ) ) { foreach( $seos as $index => $settings ) {
				if( in_array( $index, $for_sanitize_text_field ) )
					$seos[ $index ] =  sanitize_text_field( $settings );
			} }

			return $seos;

		}

		public static function sanitizeApiKeys( $api_keys )
		{

			$for_sanitize_text_field = array( 'google_fonts_api', 'google_map_api', 'pixabay_key' );

			if( is_array( $api_keys ) ) { foreach( $api_keys as $index => $settings ) {
				if( in_array( $index, $for_sanitize_text_field ) )
					$api_keys[ $index ] =  sanitize_text_field( $settings );
			} }

			return $api_keys;

		}

		public static function sanitizeOthers( $others )
		{

			$for_sanitize_text_field = array( 'reset_page_view_count', 'auto_page_view_count_reset', 'pixabay_key' );

			if( is_array( $others ) ) { foreach( $others as $index => $settings ) {
				if( in_array( $index, $for_sanitize_text_field ) )
					$others[ $index ] =  sanitize_text_field( $settings );
			} }

			return $others;

		}

}
