<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Frontend
 * 
**/
class AceFrontendRenderingPartsMethods extends AceRenderingMethods {

	/**
	 * Static
	 */
		public static $ctaCount = 0;

	/**
	 * Before Page Loaded
	 */

	 /**
	 * Header
	**/
		/**
		 * Header Contact Info 
		 */
		public static function headerContactInfo()
		{
			
			$header_contact_info_phone_number = ace()->getThemeMod( 'header_contact_info_phone_number' );
			$header_contact_info_message_above_number = ace()->getThemeMod( 'header_contact_info_message_above_number' );
			$header_contact_info_message_below_number = ace()->getThemeMod( 'header_contact_info_message_below_number' );

			echo '<div class="header-contact-info">';

				echo '<div class="contact-info-info-data">';
					echo '<span class="message-above-contact-number">';
						echo $header_contact_info_message_above_number;
					echo '</span>';

					echo '<span class="header-contact-number">';
						echo $header_contact_info_phone_number;
					echo '</span>';

					echo '<span class="message-below-contact-number">';
						echo $header_contact_info_message_below_number;
					echo '</span>';
				echo '</div>';

			echo '</div>';
		}

		/** 
		 * Nav
		**/
		public static function headerNavi()
		{
			
		}

	/**
	 * Archive
	**/
		/**
		 * Blog
		 */
		public static function renderBlogArticles( $article_type = '' )
		{
			echo self::getBlogArticles( $article_type );
		}

		public static function getBlogArticles( $article_type = '' )
		{

			ob_start();
			if ( in_array( $article_type, array( 'slider' ) ) ) {

				if ( have_posts() ) { 
					$article_container_class = array( 'article-container', 'swiper-container' );
					echo '<div class="' . esc_attr( implode( ' ', $article_container_class ) ) . '">';
					$articles_class = array( 'articles', 'post-list', 'list-in-slider', 'swiper-wrapper' );
					echo '<div class="' . esc_attr( implode( ' ', $articles_class ) ) . '">';
						while( have_posts() ) { the_post();
							do_action( ace()->getPrefixedActionHook( 'render_archive_article' ), $article_type );
						} 
					echo '</div>';
					echo '</div>';
					do_action( ace()->getPrefixedActionHook( 'render_pagination' ) );
				} else { 
					echo '<h2 class="not-found-message">' . esc_html__( 'No Articles.', 'ace' ) . '</h3>';
					echo '<p>' . esc_html__( 'Please try to search for the page with keywords.', 'ace' ) . '</p>';
					get_search_form();
				}
				
			} else {
				if ( have_posts() ) { 
					$articles_class = array( 'articles', 'post-list', 'list-in-' . $article_type );
					echo '<div class="' . esc_attr( implode( ' ', $articles_class ) ) . '">';
						while( have_posts() ) { the_post();
							do_action( ace()->getPrefixedActionHook( 'render_archive_article' ), $article_type );
						} 
					echo '</div>';
					do_action( ace()->getPrefixedActionHook( 'render_pagination' ) );
				} else { 
					echo '<h2 class="not-found-message">' . esc_html__( 'No Articles.', 'ace' ) . '</h3>';
					echo '<p>' . esc_html__( 'Please try to search for the page with keywords.', 'ace' ) . '</p>';
					get_search_form();
				}
			}

			$blog_articles = ob_get_clean();
			return $blog_articles;
		
		}

		/**
		 * Blog Article
		 */
		public static function renderBlogArticle( $article_type = '' )
		{
			echo self::getBlogArticles( $article_type );
		}

		public static function getBlogArticle( $article_type = '' )
		{
			ob_start();
			self::loadTemplatePart( 'archive/article', $type );
			$article = ob_get_clean();

		}

		/**
		 * Post Item Data
		**/
			/**
			 * Thumbnail
			**/
			public static function renderArchiveArticleThumbnail()
			{
				echo self::getArchiveArticleThumbnail();
			}

			public static function getArchiveArticleThumbnail()
			{
				global $post;
				ob_start();
				echo '<div class="post-list-bloginfo-div">';
					echo '<div class="bloginfo bloginfo-thumbnail">';
						//echo '<a class="post-list-thumbnail-a" href="'; the_permalink(); echo '">';

							$thumbnailURL = esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) );
							$alt = $post_title = wp_strip_all_tags( get_the_title( $post->ID ) );
							if ( $thumbnailURL ) {
								$classes = array( 'post-list-thumbnail' );
								$atts = array(
									'class' => implode( ' ', $classes ),
									'alt' => ( $alt ? $alt : sprintf( esc_html__( 'No Titles - %s', 'ace' ), ACE_SITE_NAME ) ),
									'title' => ( 
										$post_title !== ''
										? $post_title 
										: sprintf( 
											esc_html__( 'No Titles - %s', 'ace' ), 
											esc_html( ACE_SITE_NAME )
										) 
									),
								);
								$width = absint( ace()->getThemeMod( 'archive_page_post_thumbnail_width' ) );
								$height = absint( ace()->getThemeMod( 'archive_page_post_thumbnail_height' ) );
								$size = $width . 'px ' . $height . 'px';
								echo get_the_post_thumbnail( $post->ID, $size, $atts );
								unset( $atts );

							}

							else {
								$classes = array( 'post-list-thumbnail', 'default' );
								$default_cat_thumbnail = AceFrontendRenderingMethods::getTheDefaultThumbnailUrl( $post );

								AceFrontendRenderingMethods::imgTagDefaultThumbnail( 
									implode( ' ', $classes ), 
									array( 
										'width' => absint( ace()->getThemeMod( 'archive_page_post_thumbnail_width' ) ) . 'px', 
										'height' => absint( ace()->getThemeMod( 'archive_page_post_thumbnail_height' ) ) . 'px' 
									),
									$alt,
									esc_url( $default_cat_thumbnail )
								);
								unset( $default_cat_thumbnail );

							} unset( $thumbnailURL, $alt, $id, $class );

						//echo '</a>';
					echo '</div>';
				echo '</div>';
				$html = ob_get_clean();
				return apply_filters( ace()->getPrefixedFilterHook( 'render_post_list_item_thumbnail' ), $html, $post );

			}

			/**
			 * Author
			**/
			public static function renderArchiveArticleAuthor()
			{
				echo self::getArchiveArticleAuthor();
			}

			public static function getArchiveArticleAuthor()
			{
				global $post;
				ob_start();
				echo '<p class="bloginfo-p bloginfo-p-user vcard">';
					echo '<a class="fn url" href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . esc_html( get_the_author() ) . '</a>';
				echo '</p>';
				$html = ob_get_clean();
				return apply_filters( ace()->getPrefixedFilterHook( 'archive_article_author' ), $html );

			}

			/**
			 * Date Publish
			**/
			public static function renderArchiveArticleDatePublished()
			{
				echo self::getArchiveArticleDatePublished();
			}

			public static function getArchiveArticleDatePublished()
			{
				global $post;
				ob_start();

				echo '<div class="bloginfo-p bloginfo-p-time">';
					echo '<time class="dt-published published updated" datetime="'; the_time( 'c' ); echo '">';
						the_time( esc_html_x( 'Y/m/d', 'Date Format', 'ace' ) );
					echo '</time>';
				echo '</div
				>';

				$html = ob_get_clean();
				return apply_filters( ace()->getPrefixedFilterHook( 'archive_article_date_published' ), $html );
			}

		/**
		 * Author Card
		**/
		public static function renderAuthorCard( $user_id, $query_posts = false, $title_element = 'div', $show_post_count = false, $card_style = 'standard' )
		{

			$author_desc = get_the_author_meta( 'user_description', $user_id );
	
			$user_url = get_author_posts_url( $user_id );
			if ( function_exists( 'bp_core_get_user_domain' ) ) {
				$user_url = bp_core_get_user_domain( $user_id );
			}
			$display_name = get_the_author_meta( 'display_name', $user_id );

			$post_author_atts = get_user_meta( absint( $user_id ), '_ace_post_author_atts', true );
			$post_author_atts = json_decode( $post_author_atts, true );
			if ( null === $post_author_atts ) $post_author_atts = array();
			$post_author_atts = wp_parse_args( $post_author_atts, array(
				'position' => __( 'Post Author', 'ace' ),
			) );
			if ( ! isset( $post_author_atts['position'] ) || '' === $post_author_atts['position'] ) {
				$post_author_atts['position'] = __( 'Post Author', 'ace' );
			}
			$position = $post_author_atts['position'];

			$posts_total = count( get_posts( array(
				'post_author' => $user_id,
				'post_type' => 'post',
				'posts_per_page' => -1
			) ) );

			// Related Posts
			$has_related_posts = false;
			if ( false !== $query_posts ) {
				$posts = get_posts( $query_posts );
				if ( 0 < count( $posts ) ) {
					$has_related_posts = true;
				}
			}

			// Belongs Data
			$has_belongs_data = false;
	
			// Avatar 
			$avatar_url = get_avatar_url( $user_id, array(
				'size' => 100,
				'default' => 'mystery',
			) );
			$avatar_img = AceFrontendRenderingMethods::getImageTagWithNoScript( $avatar_url, $type = 'img', $atts = array(
				'class' => 'author-card-avatar-image',
				'alt' => sprintf( 'The Post Author: %1$s', $display_name ),
				'width' => 100,
				'height' => 100,
			) );

			$card_classes = array( 'author-card', 'style-' . $card_style );
			$card_inner_classes = array( 'autor-card-inner', 'swiper-wrapper' );
			if ( $has_related_posts ) {
				array_push( $card_classes, 'swiper-container' );
				array_push( $card_classes, 'swiper-container-flip-y' );

				//array_push( $card_inner_classes, 'swiper-wrapper' );
			} 
	
			printf( '<div class="%1$s">', implode( ' ', $card_classes ) );

				printf( '<div class="%1$s">', implode( ' ', $card_inner_classes ) );

					echo '<div class="author-card-profile-side swiper-slide">';

						echo '<div class="author-card-header">';
							echo '<' . $title_element . ' class="author-card-title">';
								echo '<span class="author-card-title-text">';
									echo esc_html( $display_name );
								echo '</span>';

								echo '<span class="author-card-position">';
									echo '<span class="author-card-position-text">';
										echo esc_html( $position );
									echo '</span>';

									if ( $show_post_count ) {
										echo '<span class="author-card-post-count-text">';
											printf( esc_html__( '%1$d Posts', 'ace' ), $posts_total );
										echo '</span>';
									}
								echo '</span>';

							echo '</' . $title_element . '>';
						echo '</div>';

						echo '<div class="author-card-body">';
							echo '<div class="author-card-avatar">';
								echo $avatar_img;
							echo '</div>';
							echo '<div class="author-card-meta">';

								echo '<div class="author-card-profile">';
									echo '<div class="author-card-profile-description"><p class="author-card-profile-description-text">' . $author_desc . '</p></div>';

									do_action( ace()->getPrefixedActionHook( 'render_sns_account_of_author_card_in_archive' ), $user_id );

								echo '</div>';

							echo '</div>';
						echo '</div>';

					echo '</div>';

					if ( $has_related_posts ) {
						echo '<aside class="author-card-related-posts swiper-slide">';

							echo '<div class="author-card-related-posts-inner swiper-container">';
								echo '<div class="author-related-post-list swiper-wrapper">';
								foreach ( $posts as $related_post ) {

									// Post 
									$post_id = absint( $related_post->ID );
									$permalink = get_permalink( $post_id );

									// Category
									$cat = get_the_category( $post_id );
									//var_dump( $cat );
									$cat_name = esc_html( 'No Title', 'ace' );
									//var_dump( $cat );
									if ( isset( $cat[0] ) && 'WP_Term' === get_class( $cat[0] ) ) {
										$cat_name = $cat[0]->name;
									}

									// Title
									$title = ( ! empty( $related_post->post_title ) ? wp_strip_all_tags( $related_post->post_title ) : esc_html__( '( No Title )', 'ace' ) );
									$excerpt = AceDataMethods::getTheExcerpt( $related_post->post_content );

									// Date
									$time = strtotime( $related_post->post_date );
									$date = date_i18n( 'Y/m/d', $time );

									// Thumbnail
										$thumbnail_url = get_the_post_thumbnail_url( $related_post, 'archive-article-card' );
										if ( false === $thumbnail_url ) {
											$thumbnail_url = get_theme_mod( 'default_thumbnail', ACE_PLUS_DIR_URL . 'assets/img/no-img-dark.png' );
										}
										$thumbnail_size = apply_filters( ace_plus()->getPrefixedFilterHook( 'thumbnail_size' ), array( 160, 120 ), $related_post );
										$view_box = sprintf( '0,0,%1$d,%2$d', absint( $thumbnail_size[0] ), absint( $thumbnail_size[1] ) );
										
									echo '<div class="author-related-post swiper-slide">';

										echo '<div class="author-related-post-header lazy-background" style="background-color: rgba(0,0,0,1)" data-src="' . esc_url( $thumbnail_url ) . '">';

											echo '<a href="'; the_permalink( $post_id ); echo '" class="author-related-post-cat-link">';
												echo '<div class="author-related-post-cat">';
													echo '<span class="author-related-post-cat-label">' . $cat_name . '</span>';
												echo '</div>';
											echo '</a>';

										echo '</div>';

										echo '<div class="author-related-post-body">';
											echo '<time class="author-related-post-date dt-published published updated" datetime="'; the_time( 'c' ); echo '">' . $date . '</time>';
											echo '<div class="author-related-post-title">';
												echo '<a class="author-related-post-link" href="'; the_permalink( $post_id ); echo '">' . $title . '</a>';
											echo '</div>';
										echo '</div>';

									echo '</div>';

								}
								echo '</div>';

								//echo '<div class="swiper-button-prev"></div>';
								//echo '<div class="swiper-button-next"></div>';
									
								//echo '<div class="swiper-pagination-nested"><div class="swiper-pagination"></div></div>';
							echo '</div>';
						echo '</aside>';
					}

					if ( $has_belongs_data ) {
						echo '<div class="author-card-belongs swiper-slide">';

						echo '</div>';
					}

				echo '</div>';

				if ( $has_related_posts ) {
					echo '<div class="swiper-button-next">';
						echo '<a class="button button-flip-author-card" href="javascript:void(0);">';
							esc_html_e( 'Flip', 'ace' );
						echo '</a>';
					echo '</div>';
				}

			echo '</div>';


		}

		/**
		 * Print Pagination Template for Archive Page
		 * 
		 * @see self::getPagination()
		**/
		public static function pagination() {
			echo self::getPagination();
		}

		/**
		 * Get Pagination Template for Archive Page
		 * 
		 * @return string
		**/
		public static function getPagination( $args = array() ) {

			if ( ! wp_is_mobile() ) {

				global $wp_query;
				$total = ( 
					isset( $wp_query->max_num_pages ) 
						&& $wp_query->max_num_pages > 1 
					? $wp_query->max_num_pages
					: 1 
				);

				$current = ( 
					get_query_var( 'paged' ) 
					? get_query_var( 'paged' ) 
					: 1
				);

				$default_args = array(
					'end_size'		   => 3,
					'mid_size'		   => 3,
					'prev_text'		  => esc_html__( '&laquo; Previous', 'ace' ),
					'next_text'		  => esc_html__( 'Next &raquo;', 'ace' ),
				);
				$args = wp_parse_args( $args, $default_args );

				return apply_filters( ace()->getPrefixedFilterHook( 'render_pagination' ), sprintf( '<div class="pagination"><span>' . esc_html__( 'Page: %1$d of %2$d', 'ace' ) . '</span>%3$s</div>', absint( $current ), absint( $total ), paginate_links( $args ) ), 'pc' );

			} else {

				$prev = get_previous_posts_link( esc_html__( 'To Prev', 'ace' ) );
				$next = get_next_posts_link( esc_html__( 'To Next', 'ace' ) );
				if ( ! $prev && ! $next ) {
					return apply_filters( 
						ace()->getPrefixedFilterHook( 'render_pagination' ),
						'',
						'mobile'
					);
				} else {
					if ( $prev ) {
						$prev = '<div class="prev-posts-link-mobile">' . $prev . '</div>';
					}
					if ( $next ) {
						$next = '<div class="next-posts-link-mobile">' . $next . '</div>' ;
					}
				}
				return apply_filters( 
					ace()->getPrefixedFilterHook( 'render_pagination' ),
					'<div class="pagination">' . $prev . $next . '</div>',
					'mobile'
				);

			}

		}

	/**
	 * Singular
	**/
		/**
		 * Render Thumbnail HTML
		**/
		public static function singularThumbnail()
		{
			echo self::getSingularThumbnail();
		}

		/**
		 * Get Thumbnail HTML
		**/
		public static function getSingularThumbnail()
		{

			global $post;
			$thumbnailURL = esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) );
			if ( false === $thumbnailURL ) {
				return '';
			}
			$classes = array( 'singular-thumbnail' );
			$post_title = wp_strip_all_tags( get_the_title( $post->ID ) );
			$alt = $post_title = (
				'' !== $post_title 
				? $post_title 
				: sprintf( esc_html__( 'No Titles - %s', 'ace' ), esc_html( ACE_SITE_NAME ) )
			);
			$atts = array(
				'class' => implode( ' ', $classes ),
				'alt' => $alt,
				'title' => $post_title,
			);
			$width = 100;//absint( ace()->getThemeMod( 'archive_page_post_thumbnail_width' ) );
			$height = 100;//absint( ace()->getThemeMod( 'archive_page_post_thumbnail_height' ) );
			$size = $width . 'px ' . $height . 'px';

			ob_start();
			echo '<div class="post-list-bloginfo-div">';
				echo '<div class="bloginfo bloginfo-thumbnail">';
					echo '<a class="post-list-thumbnail-a" href="'; the_permalink(); echo '">';
						echo get_the_post_thumbnail( $post->ID, $size, $atts );
						unset( $atts );
					echo '</a>';
				echo '</div>';
			echo '</div>';
			$html = ob_get_clean();

			return apply_filters( ace()->getPrefixedFilterHook( 'render_singular_thumbnail' ), $html, $post );

		}

		/**
		 * Excerpt
		 * 
		 * @param string $post_content
		 * @param int $excerpt_length
		 * 
		 * @see self::get_the_excerpt( $post_content, $excerpt_length )
		**/
		public static function theExcerpt( $post = null ) { 
			echo self::getTheExcerpt( $post );
		}

		/**
		 * Excerpt
		 * 
		 * @param string $post_content
		 * @param int $excerpt_length
		 * 
		 * @return string
		**/
		public static function getTheExcerpt( $post = null ) {

			if ( empty( $post ) ) {
				global $post;
			}
			$post = get_post( $post );

			if ( ! $post instanceof WP_Post ) return '';

			$post_content = $post->post_content;

			$the_excerpt = preg_replace( '/\[[^\]]+]/i', '', $post_content );
			$the_excerpt = wp_strip_all_tags( $the_excerpt );
			$the_excerpt = str_replace( array( "\n", "\r", '&ensp;', '&emsp;', '&thinsp;', '"', "&nbsp;" ), '', $the_excerpt );
			$the_excerpt = mb_ereg_replace( "/[^a-zA-Z0-9]\s[^a-zA-Z0-9]/i", '', $the_excerpt );

			return mb_substr( $the_excerpt, 0, 200 );

		}

		/**
		 * Excerpt
		 * 
		 * @param string $post_content
		 * @param int $excerpt_length
		 * 
		 * @see self::get_the_excerpt( $post_content, $excerpt_length )
		**/
		public static function singularPostTax( $post = null ) { 
			echo self::getSingularPostTax( $post );
		}

		/**
		 * Excerpt
		 * 
		 * @param string $post_content
		 * @param int $excerpt_length
		 * 
		 * @return string
		**/
		public static function getSingularPostTax( $post = null ) {

			if ( empty( $post ) ) {
				global $post;
			}
			$post = get_post( $post );

			if ( ! $post instanceof WP_Post ) return '';

			ob_start();
				echo '<div class="singular-after-title ' . $post->post_type . '">';
					self::loadTemplatePart( 'singular/tax-' . $post->post_type );
				echo '</div>';
			$html = ob_get_clean();

			return apply_filters( ace()->getPrefixedFilterHook( 'render_singular_post_tax' ), $html, 'singular' );

		}

		/** 
		 * Footer
		**/
		public static function singularFooterPrevNext()
		{
			echo self::getSingularFooterPrevNext();
		}
		public static function getSingularFooterPrevNext()
		{
			global $post;
			$post_type = get_post_type( $post );
			if ( 'post' !== $post_type || is_home() || is_front_page() ) {
				return '';
			}

			ob_start();
			self::loadTemplatePart( 'singular/prevnext' );
			$html = ob_get_clean();

			return apply_filters( ace()->getPrefixedFilterHook( 'render_singular_footer_prev_next' ), $html, 'singular' );
		}

	/**
	 * Footer
	**/
		/**
		 * Footer Description
		**/
		public static function footerNameDescription()
		{
			echo self::getFooterNameDescription();
		}
		/**
		 * Get Footer Description
		**/
		public static function getFooterNameDescription()
		{
			ob_start();
			echo '<div class="footer-site-name-description">';

				// Theme Customizer
				ace_print_edit_shortcut_for_theme_customizer( 'footer_display_description' );

				echo '<span class="footer-site-name-text">';
					echo esc_html( ACE_SITE_NAME );
				echo '</span>';
			
				echo '<span class="footer-site-description-text">';
					echo esc_html( ACE_SITE_DESCRIPTION );
				echo '</span>';

			echo '</div>';
			$html = ob_get_clean();
			return apply_filters( ace()->getPrefixedFilterHook( 'render_footer_description' ), $html );
		}

		/**
		 * Footer License
		**/
		public static function footerLicense()
		{
			echo self::getFooterLicense();
		}
		
		/**
		 * Get Footer Description
		**/
		public static function getFooterLicense()
		{
			$license_type = AceDataMethods::getFooterLicenseType();
			if ( '' === $license_type
				&& ! is_customize_preview()
			) {
				return '';
			}
			ob_start();
			echo '<div id="footer-display-license" class="footer-display-license">';
				// For License Display
				ace_print_edit_shortcut_for_theme_customizer( 'footer_display_credit_type' );

				echo '<span id="footer-license-text" class="footer-license-text">';
					echo $license_type;
				echo '</span>';

			echo '</div>';

			$html = ob_get_clean();

			return apply_filters( ace()->getPrefixedFilterHook( 'render_footer_license' ), $html );

		}

		/**
		 * Footer Theme
		**/
		public static function footerThemeURI()
		{
			echo self::getFooterThemeURI();
		}
		/**
		 * Get Footer Description
		**/
		public static function getFooterThemeURI()
		{
			ob_start();
			echo '<div class="footer-display-theme" itemscope itemtype="https://schema.org/CreativeWork">';
				ace_print_edit_shortcut_for_theme_customizer( 'footer_display_theme' );

				$wp_url = 'https://wordpress.org';
				echo '<span class="powered-by-wp">';
					printf(
						'Proudly powered by %s.',
						'<a href="https://wordpress.org">WordPress</a>'
					);
				echo'</span>';

				echo '<span>';
					echo esc_html_x( 'Theme', 'in Footer', 'ace' );
					$theme_url = apply_filters( ace()->getPrefixedFilterHook( 'theme_author_uri' ), 'https://wp-works.com', ACE_THEME_NAME );
					echo ' <a class="footer-a" target="_blank" href="' . esc_url( $theme_url ) . '" itemprop="url">';
						echo '<span itemprop="name">';
							echo esc_html( ace()->getThemeData( 'Name' ) );
						echo '</span>';
					echo '</a>';
				echo '</span>';
			echo '</div>';
			$html = ob_get_clean();
			return apply_filters( ace()->getPrefixedFilterHook( 'render_footer_theme_uri' ), $html );
		}

		/**
		 * Footer Theme
		**/
		public static function footerCustomSiteInfo()
		{
			echo self::getFooterCustomSiteInfo();
		}
		/**
		 * Get Footer Description
		**/
		public static function getFooterCustomSiteInfo()
		{
			$custom_site_info = html_entity_decode( ace()->getThemeMod( 'footer_custom_site_info' ) );
			if ( ( ! is_string( $custom_site_info ) || '' === $custom_site_info ) && ! is_customize_preview() ) return '';
			ob_start();
			echo '<div class="footer-custom-site-info" itemscope itemtype="https://schema.org/CreativeWork">';
				ace_print_edit_shortcut_for_theme_customizer( 'footer_custom_site_info' );
				echo $custom_site_info;
			echo '</div>';
			$html = ob_get_clean();
			return apply_filters( ace()->getPrefixedFilterHook( 'render_footer_custom_site_info' ), $html );
		}

	// Buttons
		/**
		 * Footer Button Set
		**/
		public static function footerButtonSet()
		{
			echo self::getFooterButtonSet();
		}
		public static function getFooterButtonSet()
		{

			$icon_set = apply_filters( ace()->getPrefixedFilterHook( 'footer_menu_icons' ), array(
				'search' => array(
					'xlink' => esc_attr( '#iconSearch' ),
					'text' => esc_html__( 'Search', 'ace' ),
				), 
				'go-to-home' => array(
					'xlink' => esc_attr( '#iconHome' ),
					'text' => esc_html__( 'Home', 'ace' ),
				), 
				'scroll-to-top' => array(
					'xlink' => esc_attr( '#iconChevronTop' ),
					'text' => esc_html__( 'Top', 'ace' ),
				), 
				'right-menu' => array(
					'xlink' => esc_attr( '#iconMenuDots' ),
					'text' => esc_html__( 'Widgets', 'ace' ),
				),
			) );

			if ( ! is_array( $icon_set ) || 0 >= count( $icon_set ) ) {
				return;
			}
			ob_start();
			echo '<div class="footer-action-buttons">';
				echo '<div class="footer-action-buttons-inner">';
					foreach ( $icon_set as $action => $data ) {
						$xlink = $data['xlink'];
						$text = $data['text'];
						do_action( ace()->getPrefixedActionHook( 'render_footer_button' ), $action, $xlink, $text );
					}
				echo '</div>';
				echo '<div class="footer-action-tool search">';
					get_template_part('searchform');
				echo '</div>';
			echo '</div>';
			$html = ob_get_clean();
			return apply_filters( ace()->getPrefixedFilterHook( 'render_footer_buttons' ), $html );
		}

		/**
		 * 
		**/
		public static function buttonWithIcon( $action, $xlink, $text, $atts = array() )
		{
			echo self::getButtonWithIcon( $action, $xlink, $text, $atts );
		}

		public static function getButtonWithIcon( $action, $xlink, $text, $atts = array() )
		{
			ob_start();
			printf( '<div class="footer-button-container" data-action="%1$s"><div class="footer-button-inner"><a class="footer-button action-trigger" href="javascript:void(0);" data-action="%1$s" aria-label="' . esc_attr( $text ) . '">', $action );
				printf( '<div class="button-icon-box"><svg class="footer-icon-svg" viewBox="0 0 24 24"><use xlink:href="%s"></use></svg></div>', $xlink );
				print( '<div class="button-text-box"><span class="menu-text">' . esc_html( $text ) . '</span></div>' );
			print( '</a></div></div>' );
			$html = ob_get_clean();
			return apply_filters( ace()->getPrefixedFilterHook( 'render_button_with_icon' ), $html, $action, $xlink, $text );
		}

	/**
	 * Mods
	**/
		// Content
			/**
			 * Hooked in Filter "the_content"
			 * @param string $the_content
			 * @return string $the_content
			**/
			public static function contentFilter( $content ) {

				// IMG Tags
					$content = preg_replace_callback(
						'/<img[^>]+\/>/ims',
						array( 'AceFrontendRenderingMethods', 'filterImagesWithNoscript' ),
						$content
					);
					$content = preg_replace(
						'/(\<noscript><img[^>]+\/>\<\/noscript\>)(\<\/noscript\>)/ims',
						'${2}',
						$content
					);
					$content = preg_replace(
						'/(\<\/noscript>)(\<noscript><img[^>]+\/>\<\/noscript\>)/ims',
						'${1}',
						$content
					);

				return $content;

			}

				// Images
					/**
					 * Return Matched Part
					 * 
					 * @return string
					 */
					public static function filterImagesWithNoscript( $matched_img ) {

						//var_dump( $matched_img );

						$with_noscript = $matched_img[0];
						preg_match_all( '/([^\s\=]+)=[\'"]([^\'"]*)[\'"]/', $with_noscript, $matched );

						$attr_num = count( $matched[0] );
						$lazy_atts_str = '';
						$atts_holder = array();
						$has_data_src = false;
						if ( false !== array_search( 'data-src', $matched[1] ) ) {
							$has_data_src = true;
						}
						foreach ( $matched[1] as $index => $attr_name ) {
							array_push( $atts_holder, $attr_name );
							$attr_val = $matched[2][ $index ];
							if ( 'src' === $attr_name ) {
								if ( $has_data_src ) {
									$attr_val = self::getNoImageSrc();
								} else {
									$lazy_atts_str .= ' src="' . esc_attr( self::getNoImageSrc() ) . '"';
									$attr_name = 'data-src';
								}
							}
							if ( 'class' === $attr_name ) $attr_val .= ' lazy'; 
							$lazy_atts_str .= ' ' . $attr_name . '="' . esc_attr( $attr_val ) . '"';
						}
						//echo '<pre>' . $with_noscript . '</pre>';

						return '<img ' . $lazy_atts_str . ' /><noscript>' . $with_noscript . '</noscript>';

					}
			
		// Categories
			/**
			 * Widget Categories
			 * 
			 * @param string $tags
			 * @param array $args
			 * 
			 * @return string $tag
			**/
			public static function filterDropdownCategories( $tags, $args ) {
				$tags = preg_replace(
					'/(<li[^>]*>[^<]*)(<a[^>]+>[^<]+<\/a>)([^<]*<\/li>)/i',
					'<li class="category-list-item">${2}${3}',
					$tags
				);
				return $tags;
			}

			/**
			 * Widget Categories
			 * 
			 * @param string $tags
			 * @param array $args
			 * 
			 * @return string $tag
			**/
			public static function filterListCategories( $tags, $args ) {
				return $tags;
				$tags = preg_replace(
					'/(<li[^>]*>[^<]*)(<a[^>]+>[^<]+<\/a>)([^<]*<\/li>)/i',
					'<li class="category-list-item">${2}${3}',
					$tags
				);
				return $tags;
			}

		// Archives
			/**
			 * Widget Archive
			 * 
			 * @param string $tags
			 * 
			 * @return string $tag
			**/
			public static function filterArchivesLink( $link_html, $url, $text, $format, $before, $after ) {
				$link_html = preg_replace(
					'/(<li[^>]*>[^<]*)(<a[^>]+>[^<]+<\/a>)([^<]*<\/li>)/i',
					'<li class="archive-list-item">${2}${3}',
					$link_html
				);
				return $link_html;
			}

		// Read More for Excerpt
			public static function filterExcerptMore( $more ) {
				return '...';
			}
	
	

			
	/**
	 * Widget Areas
	 */
		// Slidebars
			public static function renderSlidebarLeft()
			{
				echo self::getSlidebarLeft();
			}

			public static function getSlidebarLeft()
			{
				if ( wp_is_mobile() ) return '';

				// Get Widget Areas
				$slidebar_left = AceWidgetAreaManager::getSlidebarLeft();

				// Check
				if( '' === $slidebar_left ) {
					return '';
				}

				$html = '<div class="slidebar-left-container slide-box standard">' . $slidebar_left . '</div>';

				return apply_filters( ace()->getPrefixedFilterHook( 'render_slidebar_left' ), $html );
				
			}

			public static function renderSlidebarRight()
			{
				echo self::getSlidebarRight();
			}

			public static function getSlidebarRight()
			{
				if ( wp_is_mobile() ) return '';

				// Get Widget Areas
				$slidebar_right = AceWidgetAreaManager::getSlidebarRight();

				// Check
				if( '' === $slidebar_right ) {
					return '';
				}

				$html = '<div class="slidebar-right-container slide-box standard">' . $slidebar_right . '</div>';

				return apply_filters( ace()->getPrefixedFilterHook( 'render_slidebar_right' ), $html );
				
			}

		// Column Left
			public static function renderColumnLeftContainer()
			{
				echo self::getColumnLeftContainer();
			}

			public static function getColumnLeftContainer()
			{

				if ( wp_is_mobile() ) return '';

				// Get Widget Areas
				$widget_areas = '';
				$widget_areas .= AceWidgetAreaManager::getWidgetAreaColumnLeft();
				$widget_areas .= AceWidgetAreaManager::getWidgetAreaColumnLeftFixed();

				// Check
				if( '' === $widget_areas ) {
					return '';
				}

				$html = '<div class="column-left-container standard">' . $widget_areas . '</div>';

				return apply_filters( ace()->getPrefixedFilterHook( 'render_column_left' ), $html );
				
			}

		// Column Right
			public static function renderColumnRightContainer()
			{
				echo self::getColumnRightContainer();
			}

			public static function getColumnRightContainer()
			{

				if ( wp_is_mobile() ) return '';

				// Get Widget Areas
				$widget_areas = '';
				$widget_areas .= AceWidgetAreaManager::getWidgetAreaColumnRight();
				$widget_areas .= AceWidgetAreaManager::getWidgetAreaColumnRightFixed();

				// Check
				if( '' === $widget_areas ) {
					return '';
				}

				$html = '<div class="column-right-container standard">' . $widget_areas . '</div>';

				return apply_filters( ace()->getPrefixedFilterHook( 'render_column_right' ), $html );
				
			}

		// On Mobile Menu
			public static function renderOnMobileMenu()
			{
				self::loadTemplatePart('mobile/side-menu');
			}

}


