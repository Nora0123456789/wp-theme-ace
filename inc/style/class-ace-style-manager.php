<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class AceStyleManager {

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
		 * Options
		 * 
		 * @var $options
		**/
		public $options = array();

		/**
		 * Font Families
		 * 
		 * @var $font_families
		**/
		public $fontFamilies;

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
		 * Theme Mods
		 * @var array $themeMods
		**/
		public $themeMods = array();

		/**
		 * Get Theme Mods
		 * @param string $key
		 * @return array
		**/
		public function getThemeMods()
		{
			return $this->themeMods;
		}

		/**
		 * Get Theme Mods
		 * @param string $key
		 * @return null|mixed
		**/
		public function getThemeMod( $key = '' )
		{
			if ( is_string( $key ) 
				&& '' !== $key
				&& isset( $this->themeMods[ $key ] )
				&& null === $this->themeMods[ $key ]
			) {
				ace()->getThemeMods[ $key ];
			}
			return false;
		}

		/**
		 * Get Font Face Styles
		 * @param string $key
		 * @return null|mixed
		**/
		public function getFontFaceStyles()
		{

			$upload_dir = wp_upload_dir();
			$fonts_dir = $upload_dir['baseurl'] . '/custom-fonts/';
			$font_face_style = '';
			$font_families = get_option( ace()->getPrefixedOptionName( 'custom_fonts' ), '' );
			if ( is_array( $font_families ) ) { foreach( $font_families as $font_family => $font_files ) {

				$font_face_style .= ' @font-face {';
				$font_face_style .= ' font-family: "' . sanitize_text_field( $font_family ) . '";';
				$font_face_style .= ' font-display: auto;';
				$font_face_style .= ' font-style: normal;';
				$font_face_style .= ' src:';

				foreach( $font_files as $index => $font_file ) {

					$font_file = sanitize_text_field( $font_file );

					preg_match( '/([^\s]+)\.(otf|ttf|eot|woff|woff2)$/', $font_file, $matched );

					if ( in_array( $matched[ 2 ], array( 'woff', 'woff2' ) ) ) {
						$font_format = $matched[ 2 ];
					} elseif ( $matched[ 2 ] == 'otf' ) {
						$font_format = 'opentype';
					} elseif ( $matched[ 2 ] == 'ttf' ) {
						$font_format = 'truetype';
					} elseif ( $matched[ 2 ] == 'eot' ) {
						$font_format = 'embedded-opentype';
					}
					$font_face_style .= ' url("' . esc_url_raw( $fonts_dir . $font_file ) . '") format("' . sanitize_text_field( $font_format ) . '"), ';

				}
				$font_face_style = substr( $font_face_style, 0, -2 );

				$font_face_style .= '; }';

			} }

			return $font_face_style;

		}

		/**
		 * Content Width
		 */
		public $contentWidth = 1024;

		public function getContentWidth()
		{
			return $this->contentWidth;
		}

		/**
		 * Column Left Width
		 */
		public $columnLeftWidth = 300;

		public function getColumnLeftWidth()
		{
			return $this->columnLeftWidth;
		}

		/**
		 * Column Right Width
		 */
		public $columnRightWidth = 300;

		public function getColumnRightWidth()
		{
			return $this->$columnRightWidth;
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
			$this->initVars();
			$this->initHooks();
		}

		protected function initVars()
		{
		}

		protected function initHooks()
		{
			add_action( ace()->getPrefixedActionHook( 'setup_frontend_layout' ), array( $this, 'setupThemeMods' ) );
		}

		/**
		 * At the end of hook "wp" 
		**/
		public function setupThemeMods()
		{
			$this->themeMods = ace()->getThemeMods();
			$this->contentWidth = $this->themeMods['main_content_max_width'];
			$this->columnLeftWidth = $this->themeMods['column_left_max_width'];
			$this->columnRightWidth = $this->themeMods['column_right_max_width'];
		}

	/**
	 * Tools
	**/
		public function trimStyles( $styles )
		{
			return wp_strip_all_tags( 
				preg_replace( 
					'/(\n|\r|\t)/', 
					'', 
					$styles
				)
			);
		}

	/**
	 * Get Styles
	**/
		/**
		 * First
		 */
		public function getFirstStyles( $device = 'pc' )
		{
			ob_start();
				// Required
				// Width and Loading Page
				echo '
					.define {
						display: none;
						position: absolute;
						visibility: hidden;
					}

					.define.svg {
						/*display: block;
						position: absolute;
						visibility: hidden;*/
						overflow: hidden;
						width: 0;
						height: 0;
					}

					.loading-page {
						position: fixed;
						top: 0;
						bottom: 0;
						left: 0;
						right: 0;
						width: 100%;
						height: 100%;
						background: rgba(255,255,255,1);
						z-index: 1000;
					}

					.loading-page-inner.spinner {
						position: fixed;
						top: 0;
						bottom: 0;
						left: 0;
						right: 0;

						display: block;
						width: 100px;
						height: 100px;
						margin: auto;
						padding: 0;

					}

					.loading-page-inner.spinner .spinner-icon {
						position: fixed;
						top: 0;
						bottom: 0;
						left: 0;
						right: 0;

						display: block;
						width: 100px;
						height: 100px;
						margin: auto;
						padding: 0;

					}

					.loading-page-inner.spinner .spinner-icon::before {
						position: absolute;
						top: 0;
						bottom:0;
						left: 0;
						right: 0;

						
						content: "";
						display: block;
						width: 100%;
						height: 100%;
						border-radius: 50%;
						border: solid 1px rgba(200,200,200,0.9);
					}

					.loading-page-inner.spinner .spinner-icon::after {
						position: absolute;
						top: 0;
						bottom:0;
						left: 0;
						right: 0;

						content: "";
						display: block;
						width: 100%;
						height: 100%;
						border-radius: 50%;
						border-top: solid 1px rgba(100,100,100,0.9);
						border-bottom: solid 1px rgba(100,100,100,0.9);
						animation: spin 4s infinite;
					}


					.loading-page-inner.shutter-up {
						position: absolute;
						top: 0;
						left: 0;
						right: 0;
						bottom: 50%;

						border-bottom: solid 1px rgba(200,200,200,0.9);
					}

					.loading-page-inner.shutter-down {
						position: absolute;
						top: 50%;
						left: 0;
						right: 0;
						bottom: 0;
					}

					.full-wrapper {
						overflow: hidden;
					}

					.ace-no-js .lazy {
						width: 0 !important;
						height: 0 !important;
					}					

					@media screen and ( max-width: 1200px ) {

					}
						
						
					@media screen and ( max-width: 1024px ) {
					.is-responsive #primary {
						min-width: unset;
					}
					}

					@media screen and ( max-width: 768px ) {
						.is-responsive {
						}

						.archive-article.style-card .archive-article-inner { 
							flex-wrap: wrap;
						}
					
					}

					@media screen and ( max-width: 640px ) {

					}

				';

				// PC
				if ( 'pc' === $device ) {

					$content_width = absint( ace()->getFrontendManager()->contentWidth );
					$primary_width = absint( $this->themeMods['main_content_max_width'] );
					$column_left_width = absint( $this->themeMods['column_left_max_width'] );
					$column_right_width = absint( $this->themeMods['column_right_max_width'] );

					$header_layout = ace()->getThemeMod( 'header_layout_pattern' );
					if ( is_string( $header_layout ) && 'fixed-on-left' === $header_layout ) {
						$content_width = $content_width + 300;
					}

					echo '
					.column-left-container,
					.widget-area.column-left,
					.widget-area.column-left-fixed {
						width: ' . $column_left_width . 'px;
					}
				
					.column-right-container,
					.widget-area.column-right,
					.widget-area.column-right-fixed {
						width: ' . $column_right_width . 'px;
					}

					#primary, .post-title {
						max-width: ' . $primary_width . 'px;
					}

					.one-column #primary, .one-column .ace-block.layout-section.block-width-max.inner-width-of-content .section-inner-blocks, .post-title {
						max-width: ' . ( $primary_width + 210 ) . 'px;
					}

					.one-column.one-column-content-area-width-max #primary {
						max-width: 100%;
					}

					@media screen and ( max-width: ' . $content_width . 'px ) {
						.column-left-container,
						.column-right-container {
							display: none;
						}

						.three-columns #primary,
						.two-columns #primary {
							max-width: ' . ( $primary_width + 210 ) . 'px;
						}
						
					}
				
					.widget-area.optional.max-width-auto {
						max-width: ' . ( $content_width ) . 'px;
					}







					';
				
				}
				// Mobile
				else {
					
				}

			$styles = ob_get_clean();
			return $this->trimStyles( $styles );
		}

		/**
		 * Mods
		 */
		public function getModStyles( $device = 'pc' )
		{
			
			ob_start();

				// Basic Font Families
				echo 'body {';
					echo $this->getFontFamilyStyle( $this->themeMods[ 'basic_font_family'] );
				echo '}';
			
				$this->headerStyles( $device );
				
				$this->mainStyles( $device );
				
				$this->footerStyles( $device );

				$this->swaStyles( $device );

			$styles = ob_get_clean();
			return $this->trimStyles( $styles );

		}

		/**
		 * Header
		 */
		public function headerStyles( $device = 'pc' )
		{

			// Background Color
				echo 'header {';
					echo $this->getBackgroundColorStyle( $this->themeMods['header_background_color'] );
				echo '}';

				echo '.header-parts-fixable {';
					echo $this->getBackgroundColorStyle( $this->themeMods['header_fixed_parts_background_color'] );
				echo '}';
				
			// Design Two Tone
			if ( 'two-tone' === $this->themeMods['header_design_edge'] ) {

				echo '.header.designed-section.two-tone .designed-section-inner.two-tone::before {';
					echo $this->getBackgroundColorStyle( $this->themeMods['header_design_edge_color'] );
					echo 'box-shadow: 0 0 0.1em 0.1em ' . $this->themeMods['header_design_edge_color'] . ';';
				echo '}';

				echo '.header.designed-section.two-tone .designed-section-inner.two-tone::after {';
					echo $this->getBackgroundColorStyle( $this->themeMods['header_background_color'] );
				echo '}';

			} elseif ( 'thick-border' === $this->themeMods['header_design_edge'] ) {

				echo '.header.designed-section.thick-border {';
					echo 'border-color: ' . $this->themeMods['header_design_edge_color'] . ';';
				echo '}';
	

			}

			$this->headerSiteNameStyles( $device );
			$this->headerSiteDescriptionStyles( $device );
			$this->headerContactInfoStyles( $device );
			$this->headerBreadcrumbStyles( $device );
			$this->headerNavMenuStyles( $device );

		}

			/**
			 * Header Site Name
			**/
			public function headerSiteNameStyles( $device = 'pc' )
			{
				echo '#header-site-name {';
					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['header_site_name_font_family'] );
					// Color
					echo $this->getColorStyle( $this->themeMods['header_site_name_color'] );
				echo '} ';

			}

			/**
			 * Header Site Description
			**/
			public function headerSiteDescriptionStyles( $device = 'pc' )
			{

				echo '#header-site-description {';
					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['header_site_description_font_family'] );
					// Color
					echo $this->getColorStyle( $this->themeMods[ 'header_site_description_color'] );
				echo '} ';

			}

			/**
			 * Header Site Description
			**/
			public function headerContactInfoStyles( $device = 'pc' )
			{

				$header_contact_info_display = ( boolval( ace()->getThemeMod( 'header_contact_info_display' ) ) ? 'block' : 'none' );

				// Breadcrumb
				echo '.header-contact-info {';
					echo 'display: ' . $header_contact_info_display . ';';
				echo '}';

			}

			/**
			 * Breadcrumb
			**/
			public function headerBreadcrumbStyles( $device = 'pc' )
			{

				// Breadcrumb
				echo '#breadcrumb .breadcrumb-item .breadcrumb-link-text {';
					echo $this->getColorStyle( $this->themeMods['header_breadcrumb_color'] );
				echo '}';

			}

			/**
			 * Header Nav Menu
			**/
			public function headerNavMenuStyles( $device = 'pc' )
			{

				// Header Navi
				echo '.ace.pc #header-navi .menu-item > .sub-menu {';
					echo $this->getBackgroundColorStyle( $this->themeMods['header_fixed_parts_background_color'] );
				echo '}';


				echo '#header-navi .menu-wrapper.standard a,
				#header-navi .menu-wrapper.standard a:visited {';
						// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['header_nav_menu_font_family'] );
					// Color
					if ( 'pc' === $device ) {
						echo $this->getColorStyle( $this->themeMods['header_nav_menu_text_color'] );
					}
					'fill: ' . $this->themeMods['header_nav_menu_text_color'] . ';';

				echo '}';

				echo '#header-navi .menu-wrapper.standard .menu-item a:hover,
				#header-navi .menu-wrapper.standard .current_page_item > .menu-item-inner {';
					echo $this->getColorStyle( $this->themeMods['header_nav_menu_text_color_hover'] );
					echo 'border-color: ' . $this->themeMods['header_nav_menu_text_color_hover'] . ';';
					echo 'fill: ' . $this->themeMods['header_nav_menu_text_color_hover'] . ';';
				echo '}';


				echo '#header-navi .menu-wrapper.standard .menu-item .menu-item-inner,
				#header-navi .menu-wrapper.standard .menu-item .menu-item-inner::after {';
					echo 'border-color: ' . $this->themeMods['header_nav_menu_text_color_hover'] . ';';
				echo '}';
					

			}

		/**
		 * Main
		 */
		public function mainStyles( $device = 'pc' )
		{

			echo 'main {';

			echo '}';

			$this->mainAreaStyles( $device );
			$this->singularStyles( $device );
			$this->archiveStyles( $device );

		}

			/**
			 * Main Area
			 */
			public function mainAreaStyles( $device = 'pc' )
			{

				// Main Area
					echo '.main-area {';
						echo $this->getFontFamilyStyle( $this->themeMods['main_area_basic_font_family'] );
						echo $this->getColorStyle( $this->themeMods['main_text_color'] );
						echo $this->getBackgroundColorStyle( $this->themeMods['main_area_background_color'] );
					echo '}';

					echo '.main-area a {';
						echo $this->getColorStyle( $this->themeMods['main_link_text_color'] );
					echo '}';

				if ( 'two-tone' === $this->themeMods['main_area_design_edge'] ) {
					
					// Two Tone
					echo '.main-area.designed-section.two-tone .designed-section-inner.two-tone::before {';
						echo $this->getBackgroundColorStyle( $this->themeMods['main_area_design_edge_color'] );
						echo 'box-shadow: 0 0 0.1em 0.1em ' . $this->themeMods['main_area_design_edge_color'] . ';';
					echo '}';

					echo '.main-area.designed-section.two-tone .designed-section-inner.two-tone::after {';
						echo $this->getBackgroundColorStyle( $this->themeMods['main_area_background_color'] );
					echo '}';

				} elseif ( 'thick-border' === $this->themeMods['main_area_design_edge'] ) {
					
					echo '.main-area.designed-section.thick-border {';
						echo 'border-color: ' . $this->themeMods['main_area_design_edge_color'] . ';';
					echo '}';
		
				}


				// Primary
				echo 'div#primary, .style-3-cols .frame-thumbnail-inner  {';
					echo $this->getBackgroundColorStyle( $this->themeMods['main_background_color'] );
				echo '}';

			}

			/**
			 * Singular
			 */
			public function singularStyles( $device = 'pc' )
			{

				// Basic 
				echo '.entry-content .singular-content-item {';
					echo $this->getFontFamilyStyle( $this->themeMods['main_singular_basic_font_family'] );
				echo '}';

				// Title
					// Background
					echo '.entry-content .singular-content-item,
					.ace-block.layout-tabs.standard .ace-tab-menu-list-item.is-active {';
						echo $this->getBackgroundColorStyle( $this->themeMods['main_singular_title_background_color'] );
					echo '}';
					

					// Text
					echo '.post-title .entry-title {';
						echo $this->getFontFamilyStyle( $this->themeMods['main_singular_title_font_family'] );
						echo $this->getColorStyle( $this->themeMods['main_singular_title_text_color'] );
					echo '}';

				// Headlines
				$headlines = array( 
					'h1' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['basic'],
					), 
					'h2' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['basic'],
					), 
					'h3' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['basic'],
					), 
					'h4' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['basic'],
					), 
					'h5' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['basic'],
					), 
					'h6' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['basic'],
					),
					'p' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['content'],
					),
					'table' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['content'],
					),
					'list' => array(
						'color'       => 'rgba(0,0,0,0.9)',
						'font_family' => $this->basicFontFamily['content'],
					),
				);

				foreach( $headlines as $element => $data ) {

					$selector = '.main-area .post-content ' . $element;
					if ( 'list' === $element ) {
						$selector = '.main-area .post-content ul, .main-area .post-content ol, .main-area .post-content dl';
					}

					echo $selector . '{';

						$key = sprintf( 'main_singular_%s_font_family', $element );
						echo $this->getFontFamilyStyle( $this->themeMods[ $key ] );


						$key = sprintf( 'main_singular_%s_color', $element );
						echo $this->getColorStyle( $this->themeMods[ $key ] );

					echo '}';

				}

			}

			/**
			 * Archive
			 */
			public function archiveStyles( $device = 'pc' )
			{

				echo '.blog #primary #primary {';

					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['main_archive_basic_font_family'] );

				echo '}';

				echo '.blog #primary .archive-title, .archive #primary .archive-title {';

					// Background
					echo $this->getBackgroundColorStyle( $this->themeMods['main_archive_title_background_color'] );

				echo '}';


				echo '.blog #primary .archive-title .archive-title-text, .archive #primary .archive-title .archive-title-text {';

					// Color
					echo $this->getColorStyle( $this->themeMods['main_archive_title_color'] );
					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['main_archive_title_font_family'] );

				echo '}';

				

				echo '.articles article.archive-article, .articles article.style-3-cols .archive-article-excerpt {';

					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['main_archive_article_text_font_family'] );

					// Color
					echo $this->getColorStyle( $this->themeMods[ 'main_archive_article_text_color'] );

					// Background
					echo $this->getBackgroundColorStyle( $this->themeMods['main_archive_article_background_color'] );
					
				echo '}';

				echo '.archive-article .article-title, .archive-article .article-title a, .archive-article .article-title a:hover, .archive-article .article-title a:link, .archive-article .article-title a:visited {';

					// Color
					echo $this->getColorStyle( $this->themeMods[ 'main_archive_article_title_color'] );
					
					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods['main_archive_article_title_font_family'] );
					
				echo '}';



	
			}

		/**
		 * Footer
		 */
		public function footerStyles( $device = 'pc' )
		{

			// Background Color
			echo 'footer {';
				echo $this->getBackgroundColorStyle( $this->themeMods['footer_background_color'] );

				echo $this->getColorStyle( $this->themeMods['footer_text_color'] );
			echo '}';

			echo 'footer a, footer a:link, footer a:visited, footer a:hover {';
				echo $this->getColorStyle( $this->themeMods['footer_link_text_color'] );
			echo '}';


			echo '.footer-nav-menu .menu-wrapper.standard a, .footer-nav-menu .menu-wrapper.standard a:link, .footer-nav-menu .menu-wrapper.standard a:hover, .footer-nav-menu .menu-wrapper.standard a:visited {';
				echo $this->getColorStyle( $this->themeMods['footer_nav_menu_text_color'] );
				echo 'fill: ' . $this->themeMods['footer_nav_menu_text_color'] . ';';
			echo '}';

			echo '.footer-nav-menu .sub-menu {';
				echo $this->getBackgroundColorStyle( $this->themeMods['footer_background_color'] );
			echo '}';

			if ( 'two-tone' === $this->themeMods['footer_design_edge'] ) {

				echo '.footer.designed-section.two-tone .designed-section-inner.two-tone::before {';
					echo $this->getBackgroundColorStyle( $this->themeMods['footer_design_edge_color'] );
					echo 'box-shadow: 0 0 0.1em 0.1em ' . $this->themeMods['footer_design_edge_color'] . ';';
				echo '}';

				echo '.footer.designed-section.two-tone .designed-section-inner.two-tone::after {';
					echo $this->getBackgroundColorStyle( $this->themeMods['footer_background_color'] );
				echo '}';

			} elseif ( 'thick-border' === $this->themeMods['footer_design_edge'] ) {
				
				echo '.footer.designed-section.thick-border {';
					echo 'border-color: ' . $this->themeMods['footer_design_edge_color'] . ';';
				echo '}';
	
			}

			echo '.footer-item-inner {';
				echo 'text-align: ' . $this->themeMods['footer_text_align'] . ';';
			echo '}';

			echo '.footer-item-inner > div:not( .footer-custom-site-info ) {';
				echo ( $this->themeMods['footer_hide_all'] ? 'display: none' : '' );
			echo '}';

			echo '.footer-site-name-description {';
				echo ( $this->themeMods['footer_hide_site_name_description'] ? 'display: none;' : '' );
			echo '}';

			echo '.footer-display-license {';
				echo ( 'none' === $this->themeMods['footer_display_credit_type'] ? 'display: none;' : '' );
			echo '}';

			echo '.footer-display-theme {';
				echo ( $this->themeMods['footer_hide_theme_name'] ? 'display: none;' : '' );
			echo '}';



		}

		/**
		 * Standard Widget Areas
		 */
		public function swaStyles( $device = 'pc' )
		{

			if ( wp_is_mobile() ) {
				$display = array( 'in_header', 'sidebar_mobile' );
			} else {
				$display = array( 'in_header', 'column_left', 'column_left_fixed', 'column_right', 'column_right_fixed', 'slidebar_left', 'slidebar_right' );
			}

			$swa = ace()->getWidgetAreaManager()->getStandardWidgetAreas();
			foreach ( $swa as $swa_id => $data ) {

				if ( ! in_array( $swa_id, $display ) ) {
					continue;
				}
				$this->swaStyle( $data );

			}

		}

			/**
			 * Should Use $data['id'] for prefixing
			 */
			public function swaStyle( $data )
			{

				$setting_id_prefix = 'swa_' . $data['id'] . '_';

				$selector_swa              = '.widget-area.' . $data['class'];
				$selector_swa_inner        = '.widget-list.' . $data['class'];
				$selector_swa_widget_li    = $selector_swa . ' .widget-li';
				$selector_swa_widget       = $selector_swa . ' .widget';
				$selector_swa_widget_link  = $selector_swa . ' a, ' . $selector_swa . ' a:visited';
				$selector_swa_widget_svg   = $selector_swa . ' a svg';
				$selector_swa_widget_title = $selector_swa . ' .widget-title-text';

				echo $selector_swa . '{';	

					// Background
					echo $this->getBackgroundColorStyle( $this->themeMods[ $setting_id_prefix . 'background_color'] );
					if ( $this->themeMods[ $setting_id_prefix . 'border'] ) {
						echo 'box-shadow: 0 0 0 1px rgba(200,200,200,1);';
					}
					echo 'padding: ' . absint( $this->themeMods[ $setting_id_prefix . 'padding'] ) . 'px;';

					// CSS Animation
					//
				echo '}';

				echo $selector_swa_inner . '{';

				echo '}';

				echo $selector_swa_widget_li . '{';
					echo 'margin-bottom: ' . absint( $this->themeMods[ $setting_id_prefix . 'widget_space'] ) . 'rem;'; 
				echo '}';

				echo $selector_swa_widget_li . ':last-child {';
					echo 'margin-bottom: auto;'; 
				echo '}';

				echo $selector_swa_widget . '{';

					echo $this->getFontFamilyStyle( $this->themeMods[ $setting_id_prefix . 'text_font_family'] );
					echo $this->getColorStyle( $this->themeMods[ $setting_id_prefix . 'text_color'] );

				echo '}';

				echo $selector_swa_widget_link . ' {';

					echo $this->getColorStyle( $this->themeMods[ $setting_id_prefix . 'text_link_color'] );
					echo 'border-color: ' . $this->themeMods[ $setting_id_prefix . 'text_link_color'] . ';';

				echo '}';

				//echo $selector_swa_widget_svg . ' {';
				//	echo 'fill: ' . $this->themeMods[ $setting_id_prefix . 'text_link_color'] . ';';
				//echo '}';

				echo $selector_swa_widget_title . '{';

					echo $this->getFontFamilyStyle( $this->themeMods[ $setting_id_prefix . 'title_font_family'] );
					echo $this->getColorStyle( $this->themeMods[ $setting_id_prefix . 'title_color'] );
					if ( 'center' !== $this->themeMods[ $setting_id_prefix . 'title_text_align'] ) {
						echo 'text-align: ' . $this->themeMods[ $setting_id_prefix . 'title_text_align'] .  ';';
						echo 'width: 100%;';
					}

				echo '}';

				echo $selector_swa_widget_title . 'a, ' . $selector_swa_widget_title . 'a:link, ' . $selector_swa_widget_title . 'a:visited{';

					// Font Family
					echo $this->getFontFamilyStyle( $this->themeMods[ $setting_id_prefix . 'title_font_family'] );
					echo $this->getColorStyle( $this->themeMods[ $setting_id_prefix . 'title_color'] );

				echo '}';

			
			}

	#
	# Style Code
	#
		/**
		 * Get Number Style
		 * 
		 * @param string $property        : Style Property Name
		 * @param string $value           : Property Value
		 * @param string $unit            : Unit
		 * @param string $filter_callable : Callable Name
		 * 
		 * @param string
		**/
		function getNumberStyle( $property, $value, $default = '', $unit = 'px', $filter_callable = 'intval' ) {

			# Check if Property is String
				if( ! is_string( $property ) ) {
					return '';
				}

			# Check the Default
				if( is_int( $default ) )
					unset( $default );

			# Check if Value is set. If no, Use Default value
			# Default is also not set return empty string
				if( ! isset( $value ) || ! is_int( $value ) ) {
					if( isset( $default ) )
						$value = $default;
					else 
						return '';
				}

			# Set the Return String CSS Code
				$return = $property . ': ' . $filter_callable( $value ) . $unit . ';';

			# End
				return $return;

		}

	#
	# Color
	#
		/**
		 * Get Color Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getColorStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'color: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'color: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

	# Font Family
		/**
		 * Get Font Family Style
		 * 
		 * @param string $value
		 * @param string $check_if_none
		 * 
		 * @param string
		**/
		function getFontFamilyStyle( $value, $check_if_none = false ) {

			$return = '';

			$font_families = array_flip( ace()->getThemeModManager()->getFontFamilies() );

			if( $check_if_none ) {
				if( ! empty( $value ) 
					&& is_string( $value ) 
					&& $value !== 'none' 
					&& in_array( $value, $font_families )
				) {
					$return = 'font-family: ' . $value . ';';
				}
			} else {
				if( ! empty( $value ) 
					&& is_string( $value ) 
					&& in_array( $value, $font_families )
				) {
					$return = 'font-family: ' . $value . ';';
				}
			}

			return $return;

		}

	#
	# Background
	#
		/**
		 * Get Background Color Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundColorStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'background-color: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-color: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

		/**
		 * Get Background Image Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundImageStyle( $value, $default = '' ) {

			$return = '';
			$image_url = esc_url_raw( $value );

			if( ! empty( $value ) ) {
				$return = 'background-image: url(' . esc_url( $value ) . ');';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-image: url(' . esc_url( $default ) . ');';
				}
			}

			return $return;

		}

		/**
		 * Get Background Size Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundSizeStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'background-size: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-size: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

		/**
		 * Get Background Position Y Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundPositionYStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'background-position-y: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-position-y: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

		/**
		 * Get Background Position X Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundPositionXStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'background-position-x: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-position-x: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

		/**
		 * Get Background Repeat Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundRepeatStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'background-repeat: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-repeat: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

		/**
		 * Get Background Attachment Style
		 * 
		 * @param string $value
		 * @param string $default
		 * 
		 * @param string
		**/
		function getBackgroundAttachmentStyle( $value, $default = '' ) {

			$return = '';

			if( ! empty( $value ) ) {
				$return = 'background-attachment: ' . esc_html( $value ) . ';';
			} else {
				if( ! empty( $default ) ) {
					$return = 'background-attachment: ' . esc_html( $default ) . ';';
				}
			}

			return $return;

		}

	#
	# Escape Values
	#
		/**
		 * Validate Font Awesome Icon Value
		 * 
		 * @param string $value : FontAwesome Icon Content Value
		 *
		 * @return string $return
		**/
		public function escFontawesomeIconValue( $value ) {

			$return = '';

			if ( preg_match( '/^f[0-9a-zA-Z]{3}/i', $value ) ) {
				$return = $value;
			}

			return $return;

		}

		/**
		 * Escape Color Value
		 * 
		 * @param  string $value : Color Value
		 *
		 * @return string $value
		**/
		public function escColorValue( $value ) {

			# Is RGB
				$is_rgb = strpos( $value, 'rgb' ) !== false;

			# Default Value
				$return = '';

			# If is RGB
				if( $is_rgb ) {

					preg_match( '/rgba?\((\s*?([0-9]){1,3}\,?){3}(0|1)\.?[0-9]*?\)/i', $value, $matched );
					if( isset( $matched[0] ) )
						$return = $matched[0];

				}

			# If is HEX 
				elseif( strpos( $value, '#' ) !== false ) {

					$return = sanitize_hex_color( $value );

				}

			# If is no HEX 
				else {

					$value = sanitize_hex_color_no_hash( $value );
					if ( '' === $value ) {
						$return = sanitize_hex_color( '#' . $value );
					}

				}

			# End
				return $return;

		}

		/**
		 * Escape Credit Type
		 * 
		 * @param string $input
		 *
		 * @return $return
		**/
		public function escCreditType( $input ) {

			$return = '';

			$credit_types = array_flip( ace()->getThemeModManager()->getThemeModsChoicesCreditTypes() );

			if( in_array( $input, $credit_types ) ) {

				$return = $input;

			}

			return $return;

		}

		/**
		 * Escape Credit Type
		 * 
		 * @param string $input
		 *
		 * @return $return
		**/
		public function escFooterAlign( $input ) {

			$return = '';

			$footer_align = array_flip( ace()->getThemeModManager()->getThemeModsChoicesFooterAligns() );

			if( in_array( $input, $footer_align ) ) {

				$return = $input;

			}

			return $return;

		}


		
}







