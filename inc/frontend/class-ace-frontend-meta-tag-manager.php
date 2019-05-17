<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Frontend
 * 
**/
class AceFrontendMetaTagManager {

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

        }

        protected function initHooks()
        {

            add_action( 'wp_head', array( $this, 'printMetaTags' ) );

        }

        public function printMetaTags()
        {
            // JSON LD
            $this->printJsonLdMarkup();

            // Canonical Link
            $this->printCanonicalLink();

            // Meta Robots
            $this->printSeoMetaRobots();

            // Meta Description
            $this->printMetaDescription();

            // Meta Key
            $this->printMetaKeywords();

            // Twitter
            $this->printTwitterCard();

            // Open Graph
            $this->printOpenGraph();

            // Google
            $this->printGooglePlusUrl();

        }

        protected function printTwitterTags()
        {

        }

		/**
         * SEO
        **/
			/**
			 * JSON LD Markup
			**/
			protected function printJsonLdMarkup() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' JSON LD MARKUP -->' . PHP_EOL;

				$website = json_encode( array(
					"@context" => esc_url( "http://schema.org" ),
					"@type" => "Website",
					"name" => ACE_SITE_NAME,
					"url" => esc_url( trailingslashit( home_url() ) ),
					"potentialAction" => array(
						"@type" => "SearchAction",
						"target" => esc_url( trailingslashit( home_url() ) ) . "?s={search_term_string}",
						"query-input" => "required name=search_term_string"
						),
				) );
				echo '<script type="application/ld+json">' . $website . '</script>' . PHP_EOL; $website = null;

				if( is_singular( 'post' ) ) {
					global $post;
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							$page_title = esc_html( wp_strip_all_tags( get_the_title() ) );
							$author_name = esc_html( wp_strip_all_tags( get_the_author() ) );
							$date_published = esc_attr( get_the_date( 'Y-n-j' ) );
							$date_modified = esc_attr( get_the_modified_time( 'Ymd' ) );
							$image_id = get_post_thumbnail_id();
							$image = ( $image_id 
								? wp_get_attachment_image_src( $image_id, 'full' ) 
								: array( 
									esc_url( get_theme_mod( 'default_thumbnail_image', SSE_ASSETS_URL . 'images/no-img.png' ) ),
									'150',
									'150'
								)
							); $image_id = null;
							$logo_image = wp_get_attachment_image_src( $this->options['seo']->get_prop( 'json_ld_logo' ) );

							$article_body = get_the_content();
							$url = esc_url( get_permalink() );

							$json_post = array(
								'@context' => 'http://schema.org',
								'@type' => 'Article',
								'mainEntityOfPage' => array(
									'@type' => 'WebPage',
									'@id' => $url,
								),
								'name' => $page_title,
								'author' => array(
									'@type' => 'Person',
									'name' => $author_name
								),
								'datePublished' => $date_published,
								'dateModified' => $date_modified,
								'image' => array(
									'@type' => 'ImageObject',
									'url' => $image[ 0 ],
									'width' => ( $image[ 1 ] > 696 ? $image[ 1 ] : 696 ),
									'height' => ( $image[ 1 ] > 696 ? $image[ 2 ] : 696 )
								),
								'articleBody' => $article_body,
								'url' => $url,
								'publisher' => array(
									'@type' => 'Organization',
									'name' => ACE_SITE_NAME,
									'logo' => array(
										'@type' => 'ImageObject',
										'url' => esc_url( $logo_image[ 0 ] ),
										'width' => absint( $logo_image[ 1 ] <= 600 ? $logo_image[ 1 ] : 600 ),
										'height' => absint( $logo_image[ 1 ] <= 60 ? $logo_image[ 2 ] : 60 ),
									)
								),
								'headline' => esc_html( $page_title ),
                            );
                            $page_title = $author_name = $date_published = $date_modified = $image = $logo_image = $article_body = $url = null;
							
							$article_section = array();
							$cats = get_the_terms( $post->ID, 'category' );
							if( ! empty( $cats ) ) {
								if( is_array( $cats ) ) { foreach( $cats as $cat ) {
									$article_section[] = esc_attr( wp_strip_all_tags( $cat->name ) );
								} }
                            } $cats = null;
                            
							$tags = get_the_terms( $post->ID, 'post_tag' );
							if( ! empty( $tags ) ) {
								if( is_array( $tags ) ) { foreach( $tags as $tag ) {
									$article_section[] = esc_attr( wp_strip_all_tags( $tag->name ) );
								} }
							}
							$json_post['articleSection'] = $article_section; $article_section = null;

							$json_post = json_encode( $json_post );
							echo '<script type="application/ld+json">' . $json_post . '</script>' . PHP_EOL; $json_post = null;
						}
					}
					rewind_posts();
				}

			}

			/**
			 * Canonical Link
			**/
			protected function printCanonicalLink() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' Canonical Link -->' . PHP_EOL;
				if( is_home() && is_front_page() ) {
					echo '<link rel="canonical" href="' . esc_url( SITE_URL ) . '" />';
				} elseif( is_front_page() ) {
					echo '<link rel="canonical" href="' . esc_url( SITE_URL ) . '" />';
				} elseif( is_home() && ! is_front_page() ) {
					echo '<link rel="canonical" href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" />';
				} elseif( is_category() ) {
					$term_url = esc_url( get_category_link( get_query_var( 'cat' ) ) );
					echo '<link rel="canonical" href="' . $term_url . '" />';
				} elseif( is_tag() ) {
					$term_url = esc_url( get_tag_link( get_query_var( 'tag_id' ) ) );
					echo '<link rel="canonical" href="' . $term_url . '" />';
				} elseif( is_day() ) {
					$term_url = esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'n' ). get_the_time( 'j' ) ) );
					echo '<link rel="canonical" href="' . $term_url . '" />';
				} elseif( is_month() ) {
					$term_url = esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'n' ) ) );
					echo '<link rel="canonical" href="' . $term_url . '" />';
				} elseif( is_year() ) {
					$term_url = esc_url( get_year_link( get_the_time( 'Y' ) ) );
					echo '<link rel="canonical" href="' . $term_url . '" />';
				} elseif( is_author() ) {
					$term_url = esc_url( get_author_posts_url( get_query_var( 'author' ) ) );
					echo '<link rel="canonical" href="' . $term_url . '" />';
				} elseif( is_singular() ) {
					global $post;
					echo '<link rel="canonical" href="' . esc_url( get_permalink( $post->ID ) ) . '" />';
				} $term_url = null;
				echo PHP_EOL;

			}

			/**
			 * Meta Robots
			**/
			protected function printSeoMetaRobots() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' SEO Meta Robots -->' . PHP_EOL;
				if( is_tag() || is_search() || is_404() ) {
					echo '<meta name="robots" content="noindex,follow">' . PHP_EOL;
					return;
				}

				global $page, $paged;
				if( ( is_home() && is_front_page() ) || is_front_page() ) {
				} elseif( 
					( is_home() 
						|| is_singular() 
					)
					&& ( $this->is_seo_meta_on )
				) {
					// checkboxes
					if( ! isset( $this->post_meta_seo['seo_meta_robots'] ) 
						|| $this->post_meta_seo['seo_meta_robots'] == 'index,follow' 
					) {
						return;
					} else { 
						echo '<meta name="robots" content="' . esc_attr( $this->post_meta_seo['seo_meta_robots'] ) . '">';
					} $this->post_meta_seo['seo_meta_robots'] = null;

				} else if( $this->options['seo']->get_prop( 'meta_robots_on' ) ) {
					if( ( is_home() || is_front_page() || is_singular() || is_category() ) 
					&& ! ( $paged >= 2 || $page >= 2 ) ) {
						return;
					} 
					echo '<meta name="robots" content="noindex,follow">';
				}
				echo PHP_EOL;

			}

			/**
			 * Meta Description
			**/
			protected function printMetaDescription() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' SEO Meta Description -->' . PHP_EOL;
				if( is_404() || is_search() ) { 
					return;
				}
				if( is_home() && is_front_page() ) {
					echo '<meta name="description" content="' . esc_attr( ACE_SITE_DESCRIPTION ) . '">' . PHP_EOL;
					return;
				} elseif( is_front_page() ) {
					echo '<meta name="description" content="' . esc_attr( ACE_SITE_DESCRIPTION ) . '">' . PHP_EOL;
					return;
				} elseif( is_home() || is_singular() ) {

					if( is_home() ) {
						$post = get_post( $this->home_id );
					} else {
						global $post;
					}

					$meta_description = isset( $this->post_meta_seo['seo_meta_description'] ) ? $this->post_meta_seo['seo_meta_description'] : '';
					$post_excerpt = ( $this->options['seo']->get_prop( 'meta_description_on' ) 
						? esc_attr( sse_get_the_excerpt( $post->post_content ) )
						: '' 
					);

					$meta_description = esc_attr( 
						( $this->is_seo_meta_on )
						? ( $meta_description 
							? $meta_description 
							: $post_excerpt 
						) 
						: $post_excerpt
					);
					if( $meta_description != '' ) {
						echo '<meta name="description" content="' . $meta_description . '">' . PHP_EOL;
						return;
					}
				} else {
					return;
				}

			}

			/**
			 * Meta Keywords
			**/
			protected function printMetaKeywords() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' SEO Meta Keywords -->' . PHP_EOL;
				if( ( is_home() && is_front_page() ) || is_search() || is_404() ) {
					return;
				} elseif( is_home() || is_front_page() || is_singular( 'post' ) ) {
					if( is_singular( 'post' ) ) {
						global $post;
					}
					
					$cats_tags = '';
					if( is_singular( 'post' ) ) {
						$cats = get_the_terms( $post->ID, 'category' );
						if( ! empty( $cats ) ) {
							if( is_array( $cats ) ) { foreach( $cats as $cat ) {
								$cats_tags .= esc_html( $cat->name ) . ',';
							} }
						}
						$tags = get_the_terms( $post->ID, 'post_tag' );
						if( ! empty( $tags ) ) {
							if( is_array( $tags ) ) { foreach( $tags as $tag ) {
								$cats_tags .= esc_html( $tag->name ) . ',';
							} }
						}
						$cats_tags = ( $this->options['seo']->get_prop( 'meta_keywords_on' )
							? substr( $cats_tags, 0, strlen( $cats_tags ) - 1 )
							: ''
						);
					}
					$meta_keywords = ( 
						( isset( $this->post_meta_seo['seo_meta_keywords'] ) 
							&& $this->post_meta_seo['seo_meta_keywords'] != '' )
						? $this->post_meta_seo['seo_meta_keywords']
						: $cats_tags
					);
					$meta_keywords = esc_attr( 
						$this->is_seo_meta_on
						? $meta_keywords
						: ''
					);
					if( $meta_keywords != '' )
						echo '<meta name="keywords" content="' . $meta_keywords . '">' . PHP_EOL;
					return;
				} else {
					return;
				}

			}

			/**
			 * Twitter Card
			**/
			protected function printTwitterCard() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' Twitter Card -->' . PHP_EOL;
				if( is_404() || is_search() ) { return; }
				// 「Summary」の出力
				echo '<meta name="twitter:card" content="summary" />' . PHP_EOL;

				$twitter_card_account = ( get_user_meta( get_the_author_meta( 'ID' ), 'twitter', true )
					? get_user_meta( get_the_author_meta( 'ID' ), 'twitter', true )
					: $this->options['seo']->get_prop( 'twitter_card_account' )
				);
				if( ! empty( $twitter_card_account ) ) {
					// 「Site」の出力
					echo '<meta name="twitter:site" content="@' . esc_attr( $twitter_card_account ) . '" />' . PHP_EOL;	
				}
				if( is_home() && is_front_page() ) {
					// 「Title」「Description」「Image」「URL」の出力
					echo '<meta name="twitter:title" content="' . esc_attr( ACE_SITE_NAME . ' - ' . ACE_SITE_DESCRIPTION ) . '" />' . PHP_EOL . 
					'<meta name="twitter:description" content="' . esc_attr( ACE_SITE_DESCRIPTION ) . '" />' . PHP_EOL .
					'<meta name="twitter:image" content="' . esc_url( $this->options['seo']->get_prop( 'tc_og_image' ) ) . '" />' . PHP_EOL .
					'<meta name="twitter:url" content="' . esc_url( SITE_URL ) . '" />';	
				} elseif( is_front_page() ) { 
					// 「Title」「Description」「Image」「URL」の出力
					echo '<meta name="twitter:title" content="' . esc_attr( ACE_SITE_NAME . ' - ' . ACE_SITE_DESCRIPTION ) . '" />' . PHP_EOL . 
					'<meta name="twitter:description" content="' . esc_attr( ACE_SITE_DESCRIPTION ) . '" />' . PHP_EOL .
					'<meta name="twitter:image" content="' . esc_url( $this->options['seo']->get_prop( 'tc_og_image' ) ) . '" />' . PHP_EOL .
					'<meta name="twitter:url" content="' . esc_url( SITE_URL ) . '" />';	
				} elseif( is_home() || is_singular() ) { 
					if( is_home() ) {
						$post = get_post( $this->home_id );
					} else {
						global $post;
					}
					$meta_description = esc_attr( 
						isset( $this->post_meta_seo['seo_meta_description'] )
							&& $this->post_meta_seo['seo_meta_description'] !== ''
						? $this->post_meta_seo['seo_meta_description']
						: ''
					);
					$meta_description = ( 
						( isset( $this->is_seo_meta_on ) && $this->is_seo_meta_on )
						? ( $meta_description 
							? $meta_description 
							: esc_attr( sse_get_the_excerpt( $post->post_content ) ) 
						)
						: esc_attr( sse_get_the_excerpt( $post->post_content ) )
					);
					// 「Title」「Description」「URL」の出力
					echo '<meta name="twitter:title" content="' . esc_attr( get_the_title( $post->ID ) . ' - ' . ACE_SITE_NAME ) . '" />' . PHP_EOL .
					'<meta name="twitter:description" content="'. esc_attr( $meta_description ) .'" />' . PHP_EOL .
					'<meta name="twitter:url" content="' . esc_url( get_the_permalink( $post->ID ) ) . '" />' . PHP_EOL;	
					// 「Image」の出力
					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					$image_src = esc_url( 
						! empty( $image_src )
						? $image_src[ 0 ]
						: ( get_user_meta( get_the_author_meta( 'ID' ), 'tc_og_image', true )
							? get_user_meta( get_the_author_meta( 'ID' ), 'tc_og_image', true )
							: $this->options['seo']->get_prop( 'tc_og_image' )
						)
					);
					echo '<meta name="twitter:image" content="' . esc_url( $image_src ) . '" />';	
				}
				echo PHP_EOL;

			}

			/**
			 * Open Graph
			**/
			protected function printOpenGraph() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' Open Graph -->' . PHP_EOL;
				// 「Locale」「Site Name」「Type」の出力
				echo '<meta property="og:locale" content="ja_JP" />' . PHP_EOL .
				'<meta property="og:site_name" content="' . esc_attr( ACE_SITE_NAME ) . '" />' . PHP_EOL .
				'<meta property="og:type" content="article" />' . PHP_EOL;

				if( is_home() && is_front_page() ) {
					// 「Title」「Description」「URL」「Image」の出力
					echo '<meta property="og:title" content="' . esc_attr( ACE_SITE_NAME ) . '" />' . PHP_EOL .
					'<meta property="og:description" content="' . esc_attr( ACE_SITE_DESCRIPTION ) . '" />' . PHP_EOL .
					'<meta property="og:url" content="' . esc_url( SITE_URL ) . '" />' . PHP_EOL .
					'<meta property="og:image" content="' . esc_attr( $this->options['seo']->get_prop( 'tc_og_image' ) ) . '" />' . PHP_EOL;
				} elseif ( is_front_page() ) { 
					// 「Title」「Description」「URL」「Image」の出力
					echo '<meta property="og:title" content="' . esc_attr( ACE_SITE_NAME ) . '" />' . PHP_EOL .
					'<meta property="og:description" content="' . esc_attr( ACE_SITE_DESCRIPTION ) . '" />' . PHP_EOL .
					'<meta property="og:url" content="' . esc_url( SITE_URL ) . '" />' . PHP_EOL .
					'<meta property="og:image" content="' . esc_url( $this->options['seo']->get_prop( 'tc_og_image' ) ) . '" />' . PHP_EOL;
				} elseif ( is_home() || is_singular() ) { 
					if( is_home() ) {
						$post = get_post( $this->home_id );
					} else {
						global $post;
					}
					$meta_description = esc_attr( get_post_meta( $post->ID, '_ss_seo_meta_description', true ) );
					$meta_description = ( $meta_description 
						? $meta_description 
						: esc_attr( sse_get_the_excerpt( $post->post_content ) )
					);
					if( is_singular( 'post' ) ) {
						$cat = get_the_category( $post->ID );
						// 「Title」「Description」「URL」「Article Section」「Article Published Time」「Article Modified Time」「Updated Time」
						echo '<meta property="og:title" content="' . esc_attr( get_the_title( $post->ID ) ) . ' - ' . ACE_SITE_NAME . '" />' . PHP_EOL .
						'<meta property="og:description" content="' . $meta_description . '" />' . PHP_EOL .
						'<meta property="og:url" content="' . esc_url( get_the_permalink( $post->ID ) ) . '" />' . PHP_EOL .
						'<meta property="article:section" content="' . esc_attr( $cat[ 0 ]->cat_name ) . '" />' . PHP_EOL .
						'<meta property="article:published_time" content="' . esc_attr( get_the_time( 'Ymd' ) ) . '" />' . PHP_EOL .
						'<meta property="article:modified_time" content="' . esc_attr( get_the_modified_time( 'Ymd' ) ) . '" />' . PHP_EOL .
						'<meta property="og:updated_time" content="' . esc_attr( get_the_modified_time( 'Ymd' ) ) . '" />' . PHP_EOL; $meta_description = $cat = null;
					}
					// 「Image」の出力
					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					$image_src = esc_url( $image_src 
						? $image_src[ 0 ]
						: ( get_user_meta( get_the_author_meta( 'ID' ), 'tc_og_image', true )
							? get_user_meta( get_the_author_meta( 'ID' ), 'tc_og_image', true )
							: $this->options['seo']->get_prop( 'tc_og_image' )
						)
					);
					echo '<meta property="og:image" content="' . esc_url( $image_src ) .'" />' . PHP_EOL; $image_src = null;
				}

			}

			/**
			 * Link tag for Google Plus URL
			**/
			protected function printGooglePlusUrl() {

				echo '<!-- ' . ace()->getThemeData( 'Name' ) . ' Google Plus Link -->' . PHP_EOL;
				$google_plus_url = esc_url( get_user_meta( get_the_author_meta( 'ID' ), 'googleplus', true )
					? get_user_meta( get_the_author_meta( 'ID' ), 'googleplus', true )
					: $this->options['seo']->get_prop( 'google_plus_url' )
				);
				if( ! empty( $google_plus_url ) && is_string( $google_plus_url ) )
					echo '<link rel="publisher" href="' . esc_url( $google_plus_url ) . '"/>' . PHP_EOL; 
				$google_plus_url = null;

			}




}