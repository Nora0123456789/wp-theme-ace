<?php

if ( ! defined( 'ABSPATH' ) ) exit;


class AceFrontendRenderingManager {

	/**
	 * Static
	**/
		/**
		 * Instance
		**/
		protected static $instance = null;

		/**
		 * Args Num 
		**/
		protected static $priorityExceptions = array(

		);

		/**
		 * Args Num 
		**/
		protected static $argsNumExceptions = array(
			'footer_button' => 4,
		);

	/**
	 * Properties
	**/
		protected $hookedMethods = array(

			// Header
			'render_in_header_parts_fixable' => array(
				'header_nav' => array( 'AceFrontendRenderingMethods', 'headerNavi' ),
				'search_form_in_header' => array( 'AceFrontendRenderingMethods', 'headerSearchForm' ),
			),

			'render_in_header' => array(
				'breadcrumb' => array( 'AceFrontendRenderingMethods', 'breadcrumb' ),
				'header_tools' => array( 'AceFrontendRenderingMethods', 'headerTools' ),
			),

			'render_widgets_in_header' => array(
				'render_widget_area_in_header' => array( 'AceWidgetAreaManager', 'renderHeaderWidgetArea' ),
			),

			'render_optional_tools_in_header' => array(),


			// Content
			'render_content' => array(),

			'render_content_home' => array(),
			'render_content_front' => array(),
			'render_content_blog' => array(),
				'render_blog_articles' => array(
					'blog_articles' => array( 'AceFrontendRenderingMethods', 'blogArticles' ),
				),
			'render_content_singular' => array(),
				'render_singular_header' => array(),
				'render_singular_body' => array(),
					'render_singular_before_content' => array(
						'singular_thumbnail' => array( 'AceFrontendRenderingMethods', 'singularThumbnail' ),
					),
					'render_singular_content_start' => array(),
					'render_link_pages' => array(),
					'render_content_end' => array(),
					'render_after_content' => array(),
				'render_singular_footer' => array(),
			'render_content_archive' => array(),
				'render_archive_start' => array(),
				'render_before_archive' => array(),
				'render_article' => array(),

				'render_archive_end' => array(
					'pagination' => array( 'AceFrontendRenderingMethods', 'pagination' ),
				),
			'render_wc_page' => array(),
				'render_wc_shop' => array(),
				'render_wc_single_product' => array(),
				'render_wc_product_archive' => array(),
				'render_wc_product_taxonomy' => array(),
				'render_wc_account_page' => array(),
				'render_wc_cart' => array(),
				'render_wc_checkout' => array(),
				'render_wc_endpoint_url' => array(),
			'render_bbpress_page' => array(),

			// Footer
			'render_in_footer' => array(),
			'render_footer_items' => array(
				'footer_name_description' => array( 'AceFrontendRenderingMethods', 'footerNameDescription' ),
				'footer_license' => array( 'AceFrontendRenderingMethods', 'footerLicense' ),
				'footer_theme_uri' => array( 'AceFrontendRenderingMethods', 'footerThemeURI' ),
				'footer_custom_site_info' => array( 'AceFrontendRenderingMethods', 'footerCustomSiteInfo' ),
			),

			// Footer Tools
			'render_in_footer_tools' => array(
				'footer_button_set' => array( 'AceFrontendRenderingMethods', 'footerButtonSet' ),
			),

			// Mobile Tools
			'render_in_mobile_tools' => array(
				'footer_button_set' => array( 'AceFrontendRenderingMethods', 'footerButtonSet' ),
			),

			// in Parts
				'render_footer_button' => array(
					'footer_button' => array( 'AceFrontendRenderingMethods', 'buttonWithIcon' ),
				),

			// Widget Areas
				// Before Primary
				'render_before_primary' => array(
					//'render_before_primary' => array( 'AceFrontendRenderingMethods', 'renderBeforePrimary' ),
				),
					// Before Content
					'render_before_content' => array(
						//'render_before_content' => array( 'AceFrontendRenderingMethods', 'renderBeforeContent' ),
					),
						// Beginning of Content
						'render_beginning_of_content' => array(
							//'render_beginning_of_content' => array( 'AceFrontendRenderingMethods', 'renderBeginingOfContentContent' ),
						),
						// Before 1st H2 of Content
						'render_before_1st_h2_of_content' => array(
							//'render_before_1st_h2_of_content' => array( 'AceFrontendRenderingMethods', 'renderBefore1stH2OfContent' ),
						),
						// End of Content
						'render_end_of_content' => array(
							//'render_end_of_content' => array( 'AceFrontendRenderingMethods', 'renderEndOfContent' ),
						),
					// After Content
					'render_after_content' => array(
						//'render_after_content' => array( 'AceFrontendRenderingMethods', 'renderAfterContent' ),
					),
				// After Primary
				'render_after_primary' => array(
					//'render_after_primary' => array( 'AceFrontendRenderingMethods', 'renderAfterPrimary' ),
				),

		);

		protected $archiveArticleTypes = array(
			'card' => array(
				'render_archive_article_header' => array(),
				'render_archive_article_body' => array(
					'post_list_item_thumbnail' => array( 'AceFrontendRenderingMethods', 'renderArchiveArticleThumbnail' ),
					'the_excerpt' => array( 'AceFrontendRenderingMethods', 'theExcerpt' ),
				),
				'render_archive_article_footer' => array(),
				'render_archive_article_optional' => array(),
			),
			'col-3' => array(
				'render_archive_article_header' => array(),
				'render_archive_article_body' => array(
					'post_list_item_thumbnail' => array( 'AceFrontendRenderingMethods', 'renderArchiveArticleThumbnail' ),
					'the_excerpt' => array( 'AceFrontendRenderingMethods', 'theExcerpt' ),
				),
				'render_archive_article_footer' => array(),
				'render_archive_article_optional' => array(),
			),
		);

	/**
	 * Init
	**/
		public static function getInstance()
		{
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		protected function __construct()
		{
			$this->initVars();
			$this->initHooks();
		}

		protected function initVars()
		{

			$archive_article_type = get_theme_mod( 'archive_article_type', 'card' );
			if ( is_array( $this->archiveArticleTypes[ $archive_article_type ] ) 
				&& 0 < count( $this->archiveArticleTypes[ $archive_article_type ] ) 
			) {
			foreach ( $this->archiveArticleTypes[ $archive_article_type ] as $hook => $hooked_methods ) {
				if ( is_array( $hooked_methods ) && 0 < count( $hooked_methods ) ) {
					$this->hookedMethods[ $hook ] = $hooked_methods;
				}
			}
			}

			// Header Tools
			$this->hookedMethods['render_optional_tools_in_header'] = array(
				'optional_tools_in_header' => array( 'AceFrontendRenderingMethods', 'headerOptioalTools' ),
			);

			// Singular Post Tax in Post Header
			$this->hookedMethods['render_beginning_of_content'] = wp_parse_args( 
				$this->hookedMethods['render_beginning_of_content'],
				array(
					'singular_post_tax' => array( 'AceFrontendRenderingMethods', 'singularPostTax' ),
				)
			);

			// Singular Post Tax in Post Header
			$link_pages_method = apply_filters( ace()->getPrefixedFilterHook( 'render_link_pages_method' ), array( 'AceFrontendRenderingMethods', 'singularLinkPages' ) );
			$this->hookedMethods['render_link_pages'] = wp_parse_args( 
				$this->hookedMethods['render_link_pages'],
				array(
					'render_link_pages' => $link_pages_method,
				)
			);

			// Column Left
			$this->hookedMethods['render_in_column_left'] = array(
				'column_left' => array( 'AceFrontendRenderingMethods', 'renderColumnLeftContainer' ),
			);

			// Column Right
			$this->hookedMethods['render_in_column_right'] = array(
				'column_left' => array( 'AceFrontendRenderingMethods', 'renderColumnRightContainer' ),
			);

			$this->hookedMethods['render_in_footer'] = array(
				//'widget_areas_in_footer'      => array( 'AceFrontendRenderingMethods', 'renderInFooter' ),
				'widget_areas_slidebar_left'  => array( 'AceFrontendRenderingMethods', 'renderSlidebarLeft' ),
				'widget_areas_slidebar_right' => array( 'AceFrontendRenderingMethods', 'renderSlidebarRight' ),
			);

			if ( wp_is_mobile() ) {
					$this->hookedMethods['render_in_footer']['widget_areas_in_mobile'] = array( 'AceFrontendRenderingMethods', 'renderOnMobileMenu' );
			}

			$this->hookedMethods = apply_filters( ace()->getPrefixedFilterHook( 'hooked_methods' ), $this->hookedMethods );

		}

		protected function initHooks()
		{
			
			// Template
			add_action( ace()->getPrefixedActionHook( 'render_before_page_loaded' ), array( 'AceFrontendRenderingMethods', 'beforePageLoaded' ) );

			add_action( ace()->getPrefixedActionHook( 'render_content' ), array( 'AceFrontendRenderingMethods', 'content' ) );

				add_action( ace()->getPrefixedActionHook( 'render_content_home' ), array( 'AceFrontendRenderingMethods', 'homePage' ) );

				add_action( ace()->getPrefixedActionHook( 'render_content_front' ), array( 'AceFrontendRenderingMethods', 'frontPage' ) );

				add_action( ace()->getPrefixedActionHook( 'render_content_blog' ), array( 'AceFrontendRenderingMethods', 'blogPage' ) );

				add_action( ace()->getPrefixedActionHook( 'render_content_singular' ), array( 'AceFrontendRenderingMethods', 'singularPage' ) );

					add_action( ace()->getPrefixedActionHook( 'render_singular_header' ), array( 'AceFrontendRenderingMethods', 'singularHeader' ) );
					//add_action( ace()->getPrefixedActionHook( 'render_singular_body' ), array( 'AceFrontendRenderingMethods', 'singularPostTax' ) );
					add_action( ace()->getPrefixedActionHook( 'render_singular_body' ), array( 'AceFrontendRenderingMethods', 'singularBody' ) );
					add_action( ace()->getPrefixedActionHook( 'render_singular_footer' ), array( 'AceFrontendRenderingMethods', 'singularFooter' ) );

				add_action( ace()->getPrefixedActionHook( 'render_content_archive' ), array( 'AceFrontendRenderingMethods', 'archive' ) );
					add_action( ace()->getPrefixedActionHook( 'render_archive_start' ), array( 'AceFrontendRenderingMethods', 'archiveStart' ) );
					add_action( ace()->getPrefixedActionHook( 'render_before_archive' ), array( 'AceFrontendRenderingMethods', 'beforeArchive' ) );
					add_action( ace()->getPrefixedActionHook( 'render_archive_article' ), array( 'AceFrontendRenderingMethods', 'archiveArticle' ) );

				add_action( ace()->getPrefixedActionHook( 'render_wc_page' ), array( 'AceFrontendRenderingMethods', 'wcPage' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_shop' ), array( 'AceFrontendRenderingMethods', 'wcShop' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_single_product' ), array( 'AceFrontendRenderingMethods', 'wcProductPage' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_product_archive' ), array( 'AceFrontendRenderingMethods', 'wcProductArchive' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_product_taxonomy' ), array( 'AceFrontendRenderingMethods', 'wcProductTaxonomy' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_account_page' ), array( 'AceFrontendRenderingMethods', 'wcAccountPage' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_cart' ), array( 'AceFrontendRenderingMethods', 'wcCart' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_checkout' ), array( 'AceFrontendRenderingMethods', 'wcCheckout' ) );
					add_action( ace()->getPrefixedActionHook( 'render_wc_endpoint_url' ), array( 'AceFrontendRenderingMethods', 'wcEndpointUrl' ) );

				add_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ), array( 'AceFrontendRenderingMethods', 'bbpressPage' ) );

			/**
			 * $hook        : name with prefix like "render_" 
			 * $method_list : 
			 * 		$method_id :
			 *   		$method   array 
			 *     		$priority int
			 *   		$args_num int
			**/
			foreach ( $this->hookedMethods as $hook => $method_list ) {
				if ( is_array( $method_list ) && 0 < count( $method_list ) ) {
					foreach ( $method_list as $method_id => $method_data ) {
						try {

							if ( ! isset( $method_data ) || ! is_array( $method_data ) || 0 >= count( $method_data ) ) {
								throw new Exception( esc_html__( 'Callable methods are not set.', 'ace' ) );
							}

							if ( ! is_callable( $method_data ) ) {
								var_dump( $method_data );
								throw new Exception( sprintf( 
									esc_html__( '%1$s::%2$s is NOT callable!', 'ace' ),
									$method_data[0],
									$method_data[1]
								) );
							}

							$this->hookedMethods[ $hook ][ $method_id ] = apply_filters(
								ace()->getPrefixedFilterHook( 'hooked_rendering_methods' ),
								$method_data,
								$method_id,
								$hook
							);

							$args_add_action= array(
								ace()->getPrefixedActionHook( $hook ),
								$method_data
							);

							// Priority
							if ( in_array( $method_id, array_keys( self::$priorityExceptions ) ) ) {
								$args_add_action[2] = absint( self::$priorityExceptions[ $method_id ] );
							}

							// Args Num
							if ( in_array( $method_id, array_keys( self::$argsNumExceptions ) ) ) {
								if ( ! isset( $args_add_action[2] ) ) {
									$args_add_action[2] = 10;
								}
								$args_add_action[3] = absint( self::$argsNumExceptions[ $method_id ] );
							}

							call_user_func_array( 'add_action', $args_add_action );

						} catch ( Exception $e ) {

							if ( current_user_can( 'manage_options' ) ) {
								echo $e->getMessage() . '<br>';
							}
						} finally {

						}
					}
				}
			}

			// Main
				// 
				// 

			// Footer

				// 

			// Others
				// Content
				add_filter( 'the_content', array( 'AceFrontendRenderingMethods', 'contentFilter' ), 15 );

				// Read More for Excerpt
				add_filter( 'excerpt_more', array( 'AceFrontendRenderingMethods', 'filterExcerptMore' ), 10, 1 );

			
			// Widgets
				// Categories
				add_filter( 'wp_dropdown_categories', array( 'AceFrontendRenderingMethods', 'filterDropdownCategories' ), 10, 2 );
				add_filter( 'wp_list_categories', array( 'AceFrontendRenderingMethods', 'filterListCategories' ), 10, 2 );
				// Archives
				add_filter( 'get_archives_link', array( 'AceFrontendRenderingMethods', 'filterArchivesLink' ), 10, 6 );

		}

		public function arrangeHookedMethods( $hooked_methods )
		{
			foreach ( $this->hookedOrder as $hook => $method_list ) {
				if ( is_array( $method_list ) && 0 < count( $method_list ) ) {
					foreach ( $method_list as $method_id => $method_data ) {
						$this->hookedOrder[ $hook ][ $method_id ] = apply_filters(
							ace()->getPrefixedFilterHook( 'hooked_rendering_methods' ),
							$method_data,
							$method_id,
							$hook
						);
					}
				}
			}

			return $hooked_methods;
		}




}