<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Frontend
 * 
**/
class AceFrontendRenderingMethods extends AceFrontendRenderingPartsMethods
{

	/**
	 * Render
	**/

	/**
	 * Render
	**/
		/** 
		 * Archive
		 */
			/**
			 * Render archive start
			**/
			public static function archiveStart()
			{
				
			}

	/**
	 * Template Loader
	**/

		/**
		 * Before Page Loaded
		 */
		public static function beforePageLoaded()
		{
			// Option
			self::loadTemplatePart( 'before-page-loaded/loading-page' );
			self::loadTemplatePart( 'before-page-loaded/define-svg' );
		}
			
		/**
		 * Header
		**/
			/**
			 * Print template/header/navi.php
			**/
			public static function headerNavi()
			{
				self::loadTemplatePart( 'header/navi' );
			}

			/**
			 * Print template/header/breadcrumb.php
			**/
			public static function breadcrumb()
			{
				self::loadTemplatePart( 'header/breadcrumb' );
			}

			/**
			 * Print template/header/tools.php
			**/
			public static function headerTools()
			{
				self::loadTemplatePart( 'header/tools' );
			}

			/**
			 * Print template/header/search-form.php
			**/
			public static function headerSearchForm()
			{
				$custom_search_classes = array( 'custom-search-trigger' );
				if ( ! ace()->getThemeMod( 'is_search_on_top' ) ) array_push( $custom_search_classes, 'hidden' );
				echo '<div class="' . esc_attr( implode( ' ', $custom_search_classes ) ) . '"><a class="custom-search-button" href="javascript:void(0);"><svg class="custom-search-icon"><use xlink:href="#iconSearch"></use></svg></a></div>';
			}

			/**
			 * Print template/header/optional-tools.php
			**/
			public static function headerOptioalTools()
			{
				self::loadTemplatePart( 'header/optional-tools' );
			}

		/**
		 * Main
		**/
			/**
			 * Print template/content.php
			**/
			public static function content()
			{
				self::loadTemplatePart( 'content' );
			}

			/**
			 * Home
			**/
				/**
				 * Print template/home.php
				**/
				public static function homePage()
				{
					self::loadTemplatePart( 'home' );
				}

			/**
			 * Front Page
			**/
				/**
				 * Print template/front-page.php
				**/
				public static function frontPage()
				{
					self::loadTemplatePart( 'front-page' );
				}

			/**
			 * Blog
			**/
				/**
				 * Print template/blog.php
				**/
				public static function blogPage()
				{
					$type = get_theme_mod( 'main_archive_article_type', 'card' );
					self::loadTemplatePart( 'blog', $type );
				}

					/**
					 * Print template/blog.php
					**/
					public static function blogArticles()
					{
						$type = get_theme_mod( 'main_archive_article_type', 'card' );
						self::loadTemplatePart( 'archive/blog-articles', $type );
					}

			/**
			 * Singular
			**/
				/**
				 * Print template/singular.php
				**/
				public static function singularPage()
				{
					self::loadTemplatePart( 'singular' );
				}

					/**
					 * Render in content header
					**/
					public static function singularHeader()
					{
						if ( is_front_page() ) return;
						self::loadTemplatePart( 'singular/title' );
					}

					/**
					 * Render in content body
					**/
					public static function singularBody()
					{
						self::loadTemplatePart( 'singular/content' );
					}

					public static function singularLinkPages()
					{
						self::loadTemplatePart( 'singular/link-pages' );
					}

					/**
					 * Render in content footer
					**/
					public static function singularFooter()
					{
						self::singularFooterPrevNext();
					}

			/**
			 * Archive
			**/
				/**
				 * Print template/archive.php
				**/
				public static function archive()
				{
					$type = get_theme_mod( 'main_archive_article_type', 'card' );
					self::loadTemplatePart( 'archive', $type );
				}

					/**
					 * Render before archive
					**/
					public static function beforeArchive()
					{
						$type = get_theme_mod( 'main_archive_article_type', 'card' );
						self::loadTemplatePart( 'archive/before-articles', $type );
					}



					/**
					 * Print template/archive/article.php
					**/
					public static function archiveArticle( $type = '' )
					{
						if ( '' === $type ) {
							$type = get_theme_mod( 'main_archive_article_type', 'card' );
						}
						self::loadTemplatePart( 'archive/article', $type );
					}

					/**
					 * Print template/archive/article.php
					**/
					public static function pagination()
					{
						parent::pagination();
					}



			/**
			 * BBPress
			**/
				/**
				 * Print template/bbpress.php
				**/
				public static function bbpressPage()
				{
					self::loadTemplatePart( 'bbpress' );
				}

			/**
			 * WooCommerce
			**/
				/**
				 * Print template/woocommerce.php
				**/
				public static function wcPage()
				{
					self::loadTemplatePart( 'woocommerce' );
				}

					/**
					 * Print template/woocommerce/wc-header.php
					**/
					public static function wcHeader()
					{
						self::loadTemplatePart( 'woocommerce/wc-header' );
					}

					/**
					 * Print template/woocommerce/wc-shop.php
					**/
					public static function wcShop()
					{
						self::loadTemplatePart( 'woocommerce/wc-shop' );
					}

					/**
					 * Print template/woocommerce/wc-product-page.php
					**/
					public static function wcProductPage()
					{
						self::loadTemplatePart( 'woocommerce/wc-product-page' );
					}

					/**
					 * Print template/woocommerce/wc-product-archive.php
					**/
					public static function wcProductArchive()
					{
						self::loadTemplatePart( 'woocommerce/wc-product-archive' );
					}

					/**
					 * Print template/woocommerce/wc-product-taxonomy.php
					**/
					public static function wcProductTaxonomy()
					{
						self::loadTemplatePart( 'woocommerce/wc-product-taxonomy' );
					}

					/**
					 * Print template/woocommerce/wc-account-page.php
					**/
					public static function wcAccountPage()
					{
						self::loadTemplatePart( 'woocommerce/wc-account-page' );
					}

					/**
					 * Print template/woocommerce/wc-cart.php
					**/
					public static function wcCart()
					{
						self::loadTemplatePart( 'woocommerce/wc-cart' );
					}

					/**
					 * Print template/woocommerce/wc-checkout.php
					**/
					public static function wcCheckout()
					{
						self::loadTemplatePart( 'woocommerce/wc-checkout' );
					}

					/**
					 * Print template/woocommerce/wc-endpoint-url.php
					**/
					public static function wcEndpointUrl()
					{
						self::loadTemplatePart( 'woocommerce/wc-endpoint-url' );
					}

		/**
		 * Footer
		**/
			/**
			 * Print template/footer.php
			**/
			public static function footer()
			{
				self::loadTemplatePart( 'footer' );
			}







}

