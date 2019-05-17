<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AceThemeModManager extends AceUniqueAbstract {

	/**
	 * Consts
	**/

	/**
	 * Static
	**/
		/**
		 * Admin
		 * 
		 * @var $admin
		**/
		protected static $instance;

	/**
	 * Properties
	**/
		/**
		 * Theme Mods
		 * @var array
		**/
		protected $themeMods = array();

		/**
		 * Get Theme Mods
		 * @return array
		**/
		public function getThemeMods()
		{
			return $this->themeMods;
		}

		/**
		 * Get Theme Mods
		 * @return array
		**/
		public function getThemeMod( $key )
		{
			if ( isset( $this->themeMods[ $key ] ) ) return $this->themeMods[ $key ];
			return false;
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
			$this->option_ids = apply_filters(
				ace()->getPrefixedFilterHook( 'option_ids' ),
				array( '', '' )
			);
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
			// Actions
			add_action( 'init', array( $this, 'setupThemeMods' ) );
			add_action( 'wp', array( $this, 'setupThemeMods' ) );

			// Filter
			add_filter( ace()->getPrefixedFilterHook( 'theme_mod_font_families' ), array( $this, 'appendFontFamilies' ) );
		}

		public function setupThemeMods()
		{
			if ( is_array( $this->themeMods ) && 0 < count( $this->themeMods ) && is_customize_preview() ) return;
			$this->themeMods = $this->getThemeModsWithDefaults( ACE_THEME_NAME_UNDERSCORE . '_' );
			do_action( ace()->getPrefixedActionHook( 'setup_theme_mods' ), $this );
		}

		public function appendFontFamilies( $font_families )
		{

			if( '' !== get_option( ace()->getPrefixedOptionName( 'google_fonts_api_key' ), '' ) ) {
				$applied_google_fonts_list = get_option( ace()->getPrefixedOptionName( 'applied_google_fonts_list' ) );
				if( is_array( $applied_google_fonts_list ) ) { foreach( $applied_google_fonts_list as $index => $data ) {
					$index_font_family = str_replace( array( '\\' ), '', $data['font-family-in-css'] );
					$value = esc_attr( $data['font-name-display'] );
					$font_families[ $index_font_family ] = $value;
				} }
				unset( $applied_google_fonts_list );
			}

			$custom_fonts = get_option( ace()->getPrefixedOptionName( 'custom_fonts' ), '' );
			if ( is_array( $custom_fonts ) ) { foreach( $custom_fonts as $font_family => $font_files ) {
				$font_families[ $font_family ] = $font_family;
			} }

			return $font_families;

		}


	/**
	 * Get Theme Mods
	 * 
	 * @param string $theme_options_prefix
	 * 
	 * @return array $theme_mods : apply_filters( ace()->getPrefixedFilterHook( 'ace_filters_default_theme_mods' ), wp_parse_args( $theme_mods, $default_theme_mods ), $theme_options_prefix, $widget_areas, $animated_elements_in_content )
	 		string $theme_options_prefix
	 		array  $widget_areas
	 		array  $animated_elements_in_content
	**/
	public function getThemeModsWithDefaults( $theme_options_prefix = 'ace_' ) {

		$theme_mods = get_theme_mods();

		// Basic Font
		$basic_font_family = '"YuMincho", "游明朝体", serif';
		if ( isset( $theme_mods['basic_font_family'] ) && ! empty( $theme_mods['basic_font_family'] ) ) {
			$basic_font_family = $theme_mods['basic_font_family'];
		}

		// Basic Content Font
		$basic_content_font_family = '"YuMincho", "游明朝体", serif';

		$content_area_background_color = esc_attr( 
			isset( $theme_mods['content_area_background_color'] ) 
				&&  $theme_mods['content_area_background_color'] != '' 
			? $theme_mods['content_area_background_color']
			: 'rgba(255,255,255,1)'
		);

		$main_content_background_color = esc_attr( 
			isset( $theme_mods['main_content_background_color'] ) 
				&&  $theme_mods['main_content_background_color'] != '' 
			? $theme_mods['main_content_background_color']
			: 'rgba(255,255,255,0)'
		);

		$default_theme_mods = array(

			// Basic Font Family
				'basic_font_family' => $basic_font_family,

			// Page Load Style
				'loading_page_type' => 'spinner',

			// Layout
				'column_left_max_width' => 300,
				'main_content_max_width' => 660,
				'column_right_max_width' => 300,

			// Page Design
				// Sidebar Left Container
					'content_area_sidebar_left_container_background_color' => 'rgba(255,255,255,0.9)',

				// Sidebar Right Container
					'content_area_sidebar_right_container_background_color' => 'rgba(255,255,255,0.9)',
			
			// Header
				// Layout
					'header_style_pattern' => 'plain',
					'header_layout_pattern' => 'vertical',
					'is_header_fixed' => false,
					'is_search_on_top' => false,

				// Header Edge: 'none', 'two-tone'
					'header_design_edge' => 'two-tone',
					'header_design_edge_color' => 'rgba(255,120,60,1)',

				// Font Family
					'header_site_name_font_family' => $basic_font_family,
					'header_site_description_font_family' => $basic_font_family,
					'header_nav_menu_font_family' => $basic_font_family,

				// Colors
					'header_background_color' => 'rgba(255,255,255,1)',
					'header_fixed_parts_background_color' => 'rgba(255,255,255,0.9)',
					'header_site_name_color' => 'rgba(0,20,100,1)',
					'header_site_description_color' => 'rgba(100,100,100,1)',
					'header_breadcrumb_color' => 'rgba(0,0,0,1)',
					'header_nav_menu_text_color' => 'rgba(0,0,0,0.9)',
					'header_nav_menu_text_color_hover' => 'rgba(200,200,200,0.9)',

				// Address
					'header_address_display' => false,
					'header_address_phone_number' => '0000-000-000',
					'header_address_message_above_number' => '',
					'header_address_message_below_number' => '',

			// Main Area
				// Design
					'main_area_design_edge' => 'two-tone',
					'main_area_design_edge_color' => 'rgba(255,120,60,1)',

				// Font
					'main_area_basic_font_family' => $basic_font_family,

				// Colors
					'main_area_background_color' => 'rgba(255,255,255,1)',
					'main_background_color' => 'rgba(255,255,255,1)',
					'main_text_color' => 'rgba(0,0,0,1)',
					'main_link_text_color' => 'rgba(0,0,0,1)',

			// Archive Page
				// Article Type
					'main_archive_article_type' => 'card',

				// Colors
					'main_archive_title_color' => 'rgba(0,0,0,1)',
					'main_archive_title_background_color' => 'rgba(255,255,255,1)',
					'main_archive_article_background_color' => 'rgba(255,255,255,1)',
					'main_archive_article_title_color' => 'rgba(0,0,0,1)',
					'main_archive_article_text_color' => 'rgba(0,0,0,1)',

				// Fonts
					'main_archive_basic_font_family' => $basic_font_family,
					'main_archive_title_font_family' => $basic_font_family,
					'main_archive_article_title_font_family' => $basic_font_family,
					'main_archive_article_text_font_family' => $basic_font_family,

			// Singular
				// Header
					'main_singular_header_style' => 'standard',
					'main_singular_title_style'  => 'in_content_box',

				// Colors
					'main_singular_title_background_color' => 'rgba(255,255,255,1)',
					'main_singular_title_text_color' => 'rgba(0,0,0,1)',

				// Fonts
					'main_singular_basic_font_family' => $basic_font_family,
					'main_singular_title_font_family' => $basic_font_family,

			// Footer
				// Layout
					'footer_hide_all' => false,
					'footer_text_align' => 'center',
					'footer_hide_theme_name' => false,
					'footer_hide_site_name_description' => false,
					'footer_copyright_year' => 2000,
					'footer_display_credit_type' => 'none',
					'footer_custom_site_info' => '',

				// Design
					'footer_design_edge' => 'two-tone',
					'footer_design_edge_color' => 'rgba(255,120,60,1)',

				// Colors
					'footer_background_color' => 'rgba(240,240,240,1)',
					'footer_text_color' => 'rgba(0,0,0,1)',
					'footer_link_text_color' => 'rgba(0,0,0,1)',
					'footer_nav_menu_text_color' => 'rgba(0,0,0,1)',

				// Fonts
					'footer_text_font_family' => $basic_font_family,
					'footer_link_text_font_family' => $basic_font_family,
					'footer_nav_menu_font_family' => $basic_font_family,

			// Widget Areas ( Specified Mods )

			// Others
				// Images
					'default_thumbnail_image' => ACE_DIR_URL . '/assets/images/no-img.png',
					'web_clip_icon_image' => '',
					'favicon_image' => '',

		);

		// Body
			$page_types = array( 'home', 'blog', 'front_page', 'archive', 'post', 'page' );
			foreach( $page_types as $page_type ) {
				$default_theme_mods['body_' . $page_type . '_background_color'] = '#FFFFFF';
				$default_theme_mods['body_' . $page_type . '_background_image'] = '';
				$default_theme_mods['body_' . $page_type . '_background_image_size'] = 'auto';
				$default_theme_mods['body_' . $page_type . '_background_image_position_row'] = 'center';
				$default_theme_mods['body_' . $page_type . '_background_image_position_column'] = 'center';
				$default_theme_mods['body_' . $page_type . '_background_image_repeat'] = 'repeat';
				$default_theme_mods['body_' . $page_type . '_background_image_attachment'] = 'scroll';
			}

	

		// Headlines
			$elements = array( 
				'h1' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_font_family,
				), 
				'h2' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_font_family,
				), 
				'h3' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_font_family,
				), 
				'h4' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_font_family,
				), 
				'h5' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_font_family,
				), 
				'h6' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_font_family,
				),
				'p' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_content_font_family,
				),
				'table' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_content_font_family,
				),
				'list' => array(
					'color'       => 'rgba(0,0,0,0.9)',
					'font_family' => $basic_content_font_family,
				),
			);
			foreach( $elements as $element => $data ) {

				$key = sprintf( 'main_singular_%s_font_family', $element );
				$default_theme_mods[ $key ] = $data['font_family'];

				$key = sprintf( 'main_singular_%s_color', $element );
				$default_theme_mods[ $key ] = $data['color'];

			}
			unset( $content_area_background_color );

		// Standard Widget Areas
			$widget_areas = array( 'in_header', 'column_left', 'column_left_fixed', 'column_right', 'column_right_fixed', 'slidebar_left', 'slidebar_right', 'sidebar_mobile' );

			foreach( $widget_areas as $index => $widget_area ) {

				// Prefix
				$id_prefix = sprintf( 'swa_%s_', $widget_area );
				
				// Animation
				//$default_theme_mods[ $id_prefix . 'area_animation_enter']   = 'none';
				$default_theme_mods[ $id_prefix . 'widget_animation_enter'] = 'none';
				$default_theme_mods[ $id_prefix . 'widget_animation_hide']  = 'none';

				// Widget Area
					$default_theme_mods[ $id_prefix . 'padding'] = 0;
					$default_theme_mods[ $id_prefix . 'border'] = false;
					
					$default_theme_mods[ $id_prefix . 'background_color'] = ( 
						in_array( $widget_area, array( 'slidebar_left', 'slidebar_right' ) ) 
						? 'rgba(255,255,255,0)' 
						: 'rgba(255,255,255,0)' 
					);

				// Widget
					// Widget Space
					$default_theme_mods[ $id_prefix . 'widget_space'] = 2;
					// Title
					$default_theme_mods[ $id_prefix . 'title_font_family'] = $basic_font_family;
					$default_theme_mods[ $id_prefix . 'title_color'] = '#000000';
					$default_theme_mods[ $id_prefix . 'title_text_align'] = 'center';
					// Text
					$default_theme_mods[ $id_prefix . 'text_font_family'] = $basic_font_family;
					$default_theme_mods[ $id_prefix . 'text_color'] = '#666666';
					$default_theme_mods[ $id_prefix . 'text_link_color'] = '#337ab7';

			}

		// CSS Animations by Animate.css
			$animated_elements_in_content = array( 'h1', 'postinfos', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'img', 'table' );
		/*
			foreach( $animated_elements_in_content as $element ) {
				$default_theme_mods[ 'singular_page_' . $element . '_animation_hover_select' ] = 'none';
				$default_theme_mods[ 'singular_page_' . $element . '_animation_enter_select' ] = 'none';
			}
		*/

		return apply_filters( ace()->getPrefixedFilterHook( 'default_theme_mods' ), wp_parse_args( $theme_mods, $default_theme_mods ), $theme_options_prefix, $widget_areas, $animated_elements_in_content );

	}

	/**
	 * Get Background Position Column for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesTextAligns() {

		return array(
			'center' => esc_html__( 'Center', 'ace' ),
			'left' => esc_html__( 'Left', 'ace' ),
			'right' => esc_html__( 'Right', 'ace' ),
		);

	}

	/**
	 * Get CSS Animation Class
	 * 
	 * @return array
	**/
	public function getAnimationClasses() {

		return apply_filters( ace()->getPrefixedFilterHook( 'animation_classes' ), array(
			'enter' => array(
				'none'       => __( 'None', 'ace' ),
				'enter-fade' => __( 'Fade In Down from Above', 'ace' ),
			),
			'hide' => array(
				'none'      => __( 'None', 'ace' ),
				'hide-fade' => __( 'Fade Out Up', 'ace' ),
			),
		) );

	}

	/**
	 * Get Font Families for Ace Theme Mods in Array
	 * 
	 * @return array filtered
	**/
	public function getFontFamilies() {

		return apply_filters( ace()->getPrefixedFilterHook( 'theme_mod_font_families' ), array( 
			'none' => __( 'Default', 'ace' ),
			'sans-serif' => __( 'sans-serif', 'ace' ),
				'arial, sans-serif' => __( 'arial', 'ace' ),
				'"arial black", sans-serif' => __( 'arial black', 'ace' ),
				'"arial narrow", sans-serif' => __( 'arial narrow', 'ace' ),
				'"arial unicode ms", sans-serif' => __( 'arial unicode ms', 'ace' ),
				'"Century Gothic", sans-serif' => __( 'Century Gothic', 'ace' ),
				'"Franklin Gothic Medium", sans-serif' => __( 'Franklin Gothic Medium', 'ace' ),
				'Gulim, sans-serif' => __( 'Gulim', 'ace' ),
				'Dotum, sans-serif' => __( 'Dotum', 'ace' ),
				'Haettenschweiler, sans-serif' => __( 'Haettenschweiler', 'ace' ),
				'Impact, sans-serif' => __( 'Impact', 'ace' ),
				'"Ludica Sans Unicode", sans-serif' => __( 'Ludica Sans Unicode', 'ace' ),
				'"Microsoft Sans Serif", sans-serif' => __( 'Microsoft Sans Serif', 'ace' ),
				'"MS Sans Serif", sans-serif' => __( 'MS Sans Serif', 'ace' ),
				'"MV Boil", sans-serif' => __( 'MV Boil', 'ace' ),
				'"New Gulim", sans-serif' => __( 'New Gulim', 'ace' ),
				'Tahoma, sans-serif' => __( 'Tahoma', 'ace' ),
				'Trebuchet, sans-serif' => __( 'Trebuchet', 'ace' ),
				'Verdana, sans-serif' => __( 'Verdana', 'ace' ),
			'serif' => __( 'serif', 'ace' ),
				'Batang, serif' => __( 'Batang', 'ace' ),
				'"Book Antiqua", serif' => __( 'Book Antiqua', 'ace' ),
				'"Bookman Old Style", serif' => __( 'Bookman Old Style', 'ace' ),
				'Century, serif' => __( 'Century', 'ace' ),
				'"Estrangelo Edessa", serif' => __( 'Estrangelo Edessa', 'ace' ),
				'Garamond, serif' => __( 'Garamond', 'ace' ),
				'Gautami, serif' => __( 'Gautami', 'ace' ),
				'Georgia, serif' => __( 'Georgia', 'ace' ),
				'Gungsuh, serif' => __( 'Gungsuh', 'ace' ),
				'Latha, serif' => __( 'Latha', 'ace' ),
				'Mangal, serif' => __( 'Mangal', 'ace' ),
				'"MS Serif", serif' => __( 'MS Serif', 'ace' ),
				'PMingLiU, serif' => __( 'PMingLiU', 'ace' ),
				'"Palatino Linotype", serif' => __( 'Palatino Linotype', 'ace' ),
				'Raavi, serif' => __( 'Raavi', 'ace' ),
				'Roman, serif' => __( 'Roman', 'ace' ),
				'Shruti, serif' => __( 'Shruti', 'ace' ),
				'Sylfaen, serif' => __( 'Sylfaen', 'ace' ),
				'"Times New Roman", serif' => __( 'Times New Roman', 'ace' ),
				'Tunga, serif' => __( 'Tunga', 'ace' ),
			'monospace' => __( 'Monospace', 'ace' ),
				'BatangChe,monospace' => __( 'BatangChe', 'ace' ),
				'Courier,monospace' => __( 'Courier', 'ace' ),
				'"Courier New",monospace' => __( 'Courier New', 'ace' ),
				'DotumChe,monospace' => __( 'DotumChe', 'ace' ),
				'GlimChe,monospace' => __( 'GlimChe', 'ace' ),
				'GungsuhChe,monospace' => __( 'GungsuhChe', 'ace' ),
				'HG行書体,monospace' => __( 'HG Gyoshotai', 'ace' ),
				'"Lucida Console",monospace' => __( 'Lucida Console', 'ace' ),
				'MingLiU,monospace' => __( 'MingLiU', 'ace' ),
				'OCRB,monospace' => __( 'OCRB', 'ace' ),
				'SimHei,monospace' => __( 'SimHei', 'ace' ),
				'SimSun,monospace' => __( 'SimSun', 'ace' ),
				'"Small Fonts",monospace' => __( 'Small Fonts', 'ace' ),
				'Terminal,monospace' => __( 'Terminal', 'ace' ),
			'fantasy,fantasy' => __( 'Fantasy', 'ace' ),
				'alba,fantasy' => __( 'alba', 'ace' ),
				'"alba matter",fantasy' => __( 'alba matter', 'ace' ),
				'"alba super",fantasy' => __( 'alba super', 'ace' ),
				'"baby kruffy",fantasy' => __( 'baby kruffy', 'ace' ),
				'Chick,fantasy' => __( 'Chick', 'ace' ),
				'Croobie,fantasy' => __( 'Croobie', 'ace' ),
				'Fat,fantasy' => __( 'Fat', 'ace' ),
				'Freshbot,fantasy' => __( 'Freshbot', 'ace' ),
				'Frosty,fantasy' => __( 'Frosty', 'ace' ),
				'GlooGun,fantasy' => __( 'GlooGun', 'ace' ),
				'Jokewood,fantasy' => __( 'Jokewood', 'ace' ),
				'Modern,fantasy' => __( 'Modern', 'ace' ),
				'"Monotype Corsiva",fantasy' => __( 'Monotype Corsiva', 'ace' ),
				'Poornut,fantasy' => __( 'Poornut', 'ace' ),
				'"Pussycat Snickers",fantasy' => __( 'Pussycat Snickers', 'ace' ),
				'"Weltron Urban",fantasy' => __( 'Weltron Urban', 'ace' ),
			'cursive' => __( 'Cursive', 'ace' ),
				'"Comic Sans MS",cursive' => __( 'Comic Sans MS', 'ace' ),
				'HGP行書体,cursive' => __( 'HGP Gyoshotai', 'ace' ),
				'HG正楷書体-PRO,cursive' => __( 'HG Seikaishotai-PRO', 'ace' ),
				'"Jenkins v2.0",cursive' => __( 'Jenkins v2.0', 'ace' ),
				'Script,cursive' => __( 'Script', 'ace' ),
			# Japanese
				'"MS UI Gothic", sans-serif' => __( 'MS UI Gothic', 'ace' ),
				'"MS PGothic", "ＭＳ Ｐゴシック", sans-serif' => __( 'MS PGothic', 'ace' ),
				'"MS Gothic", "ＭＳ ゴシック", sans-serif' => __( 'MS Gothic', 'ace' ),
				'"MS PMincho", "ＭＳ Ｐ明朝", serif' => __( 'MS PMincho', 'ace' ),
				'"MS Mincho", "ＭＳ 明朝", serif' => __( 'MS Mincho', 'ace' ),
				'"Meiryo", "メイリオ", sans-serif' => __( 'Meiryo', 'ace' ),
				'"Meiryo UI", sans-serif' => __( 'Meiryo UI', 'ace' ),
				'"Yu Gothic", "游ゴシック", sans-serif' => __( 'Yu Gothic', 'ace' ),
				'"Yu Mincho", "游明朝"' => __( 'Yu Mincho', 'ace' ),
				'"Hiragino Kaku Gothic Pro", "ヒラギノ角ゴ Pro W3", sans-serif' => __( 'Hiragino Kaku Gothic Pro', 'ace' ),
				'"HiraKakuProN-W3", "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN W3", sans-serif' => __( '"HiraKakuProN-W3", "Hiragino Kaku Gothic ProN"', 'ace' ),
				'"HiraKakuPro-W6", "ヒラギノ角ゴ Pro W6", sans-serif' => __( 'HiraKakuPro-W6', 'ace' ),
				'"HiraKakuProN-W6", "HiraKakuProN-W6", "ヒラギノ角ゴ ProN W6", sans-serif' => __( '"HiraKakuProN-W6", "HiraKakuProN-W6"', 'ace' ),
				'"Hiragino Kaku Gothic Std", "ヒラギノ角ゴ Std W8", sans-serif' => __( 'Hiragino Kaku Gothic Std', 'ace' ),
				'"Hiragino Kaku Gothic StdN", "ヒラギノ角ゴ StdN W8", sans-serif' => __( 'Hiragino Kaku Gothic StdN', 'ace' ),
				'"Hiragino Maru Gothic Pro", "ヒラギノ丸ゴ Pro W4", sans-serif' => __( 'Hiragino Maru Gothic Pro', 'ace' ),
				'"Hiragino Maru Gothic ProN", "ヒラギノ丸ゴ ProN W4", sans-serif' => __( 'Hiragino Maru Gothic ProN', 'ace' ),
				'"Hiragino Mincho Pro", "ヒラギノ明朝 Pro W3", serif' => __( 'Hiragino Mincho Pro', 'ace' ),
				'"HiraMinProN-W3", "Hiragino Mincho ProN", "ヒラギノ明朝 ProN W3", serif' => __( '"HiraMinProN-W3", "Hiragino Mincho ProN"', 'ace' ),
				'"HiraMinPro-W6", "ヒラギノ明朝 Pro W6", serif' => __( 'HiraMinPro-W6', 'ace' ),
				'"HiraMinProN-W6", "HiraMinProN-W6", "ヒラギノ明朝 ProN W6", serif' => __( '"HiraMinProN-W6", "HiraMinProN-W6"', 'ace' ),
				'"YuGothic", "游ゴシック体", sans-serif' => __( 'YuGothic', 'ace' ),
				'"YuMincho", "游明朝体", serif' => __( 'YuMincho', 'ace' ),
				'Osaka, sans-serif' => __( 'Osaka', 'ace' ),
				'"Osaka-Mono", "Osaka－等幅", sans-serif' => __( 'Osaka-Mono', 'ace' ),
				'"Droid Sans", sans-serif' => __( 'Droid Sans', 'ace' ),
				'Roboto, sans-serif' => __( 'Roboto', 'ace' )
		) );

	}

	/**
	 * Get Background Size for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesBackgroundSize() {

		return array(
			'auto' => esc_html( 'Auto', 'ace' ),
			'cover' => esc_html( 'Cover', 'ace' ),
			'contain' => esc_html( 'Contain', 'ace' ),
		);

	}

	/**
	 * Get Background Position Row for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesBackgroundPositionRow() {

		return array(
			'center' => esc_html__( 'Center', 'ace' ),
			'top' => esc_html__( 'Top', 'ace' ),
			'bottom' => esc_html__( 'Bottom', 'ace' ),
		);

	}

	/**
	 * Get Background Position Column for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesBackgroundPositionColumn() {

		return array(
			'center' => esc_html__( 'Center', 'ace' ),
			'left' => esc_html__( 'Left', 'ace' ),
			'right' => esc_html__( 'Right', 'ace' ),
		);

	}

	/**
	 * Get Background Repeat for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesBackgroundRepeats() {

		return array(
			'no-repeat' => esc_html__( 'No Repeat', 'ace' ),
			'repeat' => esc_html__( 'Repeat', 'ace' ),
			'repeat-x' => esc_html__( 'Horizontal Repeat', 'ace' ),
			'repeat-y' => esc_html__( 'Vertical Repeat', 'ace' ),
		);

	}

	/**
	 * Get Background Image Attachment for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesBackgroundAttachments() {

		return array(
			'scroll' => esc_html__( 'Scroll', 'ace' ),
			'fixed' => esc_html__( 'Fixed', 'ace' ),
		);

	}

	/**
	 * Get Singular Header Styles for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesSingularHeaderStyles() {

		return array(
			'standard' => esc_html__( 'Standard', 'ace' ),
		);

	}

	/**
	 * Get Singular Title Styles for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesSingularTitleStyles() {

		return array(
			'in_content_box' => esc_html__( 'In Content Box', 'ace' ),
			'max_width' => esc_html__( 'Max Width ( Works only for 1 Column Layout )', 'ace' ),
		);

	}

	# Footer Credit Type
	/**
	 * Get Footer Credit Types for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesCreditTypes() {

		return array(
			'none' => esc_html__( 'Not Display', 'ace' ),
			'all' => esc_html__( 'All Right Reserved', 'ace' ),
			'cc-by' => esc_html__( 'CC-BY', 'ace' ),
			'cc-by-sa' => esc_html__( 'CC-BY-SA', 'ace' ),
			'cc-by-nd' => esc_html__( 'CC-BY-ND', 'ace' ),
			'cc-by-nc' => esc_html__( 'CC-BY-NC', 'ace' ),
			'cc-by-nc-sa' => esc_html__( 'CC-BY-NC-SA', 'ace' ),
			'cc-by-nc-nd' => esc_html__( 'CC-BY-NC-ND', 'ace' ),
			'cc0' => esc_html__( 'CC0', 'ace' ),
			'public' => esc_html__( 'Public Domain', 'ace' ),
		);

	}

	/**
	 * Get Footer Aligns for Ace Theme Mods in Array
	 * 
	 * @return array
	**/
	public function getThemeModsChoicesFooterAligns() {

		return array(
			'center' => esc_html__( 'Center', 'ace' ),
			'left' => esc_html__( 'Left', 'ace' ),
			'right' => esc_html__( 'Right', 'ace' ),
		);

	}

	/**
	 * Get Designed Edge Types
	 * @return array
	**/
	public function getThemeModsDesignedEdgeTypes() {

		return array(
			'none' => esc_html__( 'None', 'ace' ),
			'thick-border' => esc_html__( 'Thick Border', 'ace' ),
			'two-tone' => esc_html__( 'Two Tone', 'ace' ),
		);

	}

}


