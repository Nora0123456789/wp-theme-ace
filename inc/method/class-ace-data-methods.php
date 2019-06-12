<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class AceDataMethods {

	/**
	 * Getters
	**/
		/**
		 * Options
		**/
		public static function getOptions()
		{
			return ace()->getOptions();
		}
		public static function getOption( $key )
		{
			return ace()->getOption( $key );
		}

		/**
		 * Theme Mods
		**/
		public static function getThemeMods()
		{
			return ace()->getThemeModManager()->getThemeMods();
		}
		public static function getThemeMod( $key )
		{
			return ace()->getThemeModManager()->getThemeMod( $key );
		}

		/**
		 * HTML Classes
		**/
		public static function getHTMLClasses()
		{
			return ace()->getHTMLClasses();
		}
		public static function getHTMLClass( $key )
		{
			return ace()->getHTMLClass( $key );
		}


	#
	# Strings
	#
		/**
		 * Get Modified Time
		 * 
		 * @static
		 * 
		 * @param string $format
		 * 
		 * @return string
		**/
		public static function getModifiedTime( $format ) {

			// Modified Time
			$mtime = get_the_modified_time( 'Ymd' ); 

			// Publish Time
			$ptime = get_the_time( 'Ymd' );

			// Not Modified ( Publish > Modified )
			if ( $ptime > $mtime ) { 
				return date_i18n( $format );
			}
			// Not Modified ( Publish = Modified )
			elseif ( $ptime === $mtime ) { 
				return date_i18n( $format );
			}
			// Modified ( Publish < Modified )
			else { 
				return get_the_modified_time( $format );
			}
		}

		/**
		 * Get Post Format Name
		 * 
		 * @static
		 * 
		 * @param WP_Post $post
		 * 
		 * @return string
		**/
		public static function getPostFormatName( $post ) {
			$current_post_id = intval( get_post()->ID );
			$format = get_post_format( $current_post_id );
			return $format;
		}

		/**
		 * Get Post Excerpt
		 * 
		 * @static
		 * 
		 * @param string $post_content
		 * @param int    $excerpt_length
		 * 
		 * @return string
		**/
		public static function getTheExcerpt( $post_content, $excerpt_length = 200 ) {

			$the_excerpt = strip_shortcodes( $post_content );
			$the_excerpt = wp_strip_all_tags( $the_excerpt );
			$the_excerpt = str_replace( array( "\n", "\r", '　', '"' ), ' ', $the_excerpt );
			$the_excerpt = mb_ereg_replace( "/[^a-zA-Z0-9]\s[^a-zA-Z0-9]/i", '', $the_excerpt );
			return mb_substr( $the_excerpt, 0, $excerpt_length );

		}


	/**
	 * 
	**/
		/**
		 * Print Template for License Display in Footer
		 * 
		 * @see $this->get_footer_license_type()
		**/
		public static function footerLicenseType() {
			echo self::get_footer_license_type();
		}

		/**
		 * Get Template for License Display in Footer
		 * 
		 * @return string
		**/
		public static function getFooterLicenseType() {

			$type = ace()->getThemeMod( 'footer_display_credit_type' );
			$year = absint( ace()->getThemeMod( 'footer_copyright_year' ) );

			if ( $type == 'none' ) {
				$type = null;
				$return = '';
			} elseif ( $type == 'all' ) {
				$type = null;
				$return = wp_kses( sprintf( __( 'Copyright &copy; <span id="copyright-year">%1$d</span> %2$s All Rights Reserved.', 'ace' ), $year, esc_html( ACE_SITE_NAME ) ), array( 'span' => array( 'id' => array() ) ) );
			} elseif ( $type == 'cc-by' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC-BY %s Some Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'cc-by-sa' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC-BY-SA %s Some Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'cc-by-nd' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC-BY-ND %s Some Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'cc-by-nc' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC-BY-NC %s Some Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'cc-by-nc-sa' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC-BY-NC-SA %s Some Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'cc-by-nc-nd' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC-BY-NC-ND %s Some Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'cc0' ) {
				$type = null;
				$return = sprintf( esc_html__( 'CC0 %s No Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} elseif ( $type == 'public' ) {
				$type = null;
				$return = sprintf( esc_html__( 'Public Domain %s No Rights Reserved.', 'ace' ), esc_html( ACE_SITE_NAME ) );
			} else {
				$return = '';
			}

			return apply_filters( ace()->getPrefixedFilterHook( 'footer_license_type' ), $return, $type, $year );

		}

	/**
	 * URL
	 */
		/**
		 * Get Excerpt From Post Content
		 * 
		 * @param string $post_content
		 * @param int    $excerpt_length
		 * 
		 * @return string
	    **/
	  	public static function getCurrentUrlForSNS() {

		   global $post;
		   global $wp_query;

		   // Get URL
		   if( is_search() || is_paged() || is_404() || is_attachment() ) {
			   return false;
		   } elseif( is_home() || is_front_page() ) {
			   $permalink_url = esc_url( ACE_SITE_URL );
		   } elseif( function_exists( 'is_woocommerce' ) && is_woocommerce() ) { // WooCommerce
			   if( is_shop() ) { // The main shop
				   $permalink_url = esc_url( get_post_type_archive_link( 'product' ) );
			   } elseif( is_product_taxonomy() ) { // タクソノミーページ
				   if( is_product_category() ) { // A product category
					   $permalink_url = esc_url( get_term_link( $wp_query->queried_object->term_id, $wp_query->queried_object->taxonomy ) );
				   } elseif( is_product_tag() ) { // A product tag
					   $permalink_url = esc_url( get_term_link( $wp_query->queried_object->term_id, $wp_query->queried_object->taxonomy ) );
				   }
			   } elseif( is_product() ) { // A single product
				   $permalink_url = esc_url( get_permalink( $post->ID ) ) ;
			   }
		   } elseif( function_exists( 'is_woocommerce' ) && is_cart() ) { // The cart
			   return false;
		   } elseif( function_exists( 'is_woocommerce' ) && is_checkout() ) { // The checkout
			   return false;
		   } elseif( function_exists( 'is_woocommerce' ) && is_account_page() ) { // Customer account
			   return false;
		   } elseif( function_exists( 'is_bbpress' ) && is_bbpress() ) { // bbPress
			   $permalink_url = esc_url( get_permalink( $post->ID ) );
		   } elseif( is_singular() ) {
			   $permalink_url = esc_url( get_permalink( $post->ID ) );
		   } elseif( is_archive() ) {
			   if( is_category() || is_tag() || is_tax() ) {
				   $permalink_url = esc_url( get_term_link( $wp_query->queried_object->term_id, $wp_query->queried_object->taxonomy ) );
			   } elseif( is_author() ) {
				   $permalink_url = esc_url( get_author_posts_url( $wp_query->queried_object->data->ID ) );
			   } elseif( is_date() ) {
				   if( is_year() ) {
					   $permalink_url = esc_url( get_year_link( $wp_query->query['year'] ) );
				   } elseif( is_month() ) {
					   $permalink_url = esc_url( get_month_link( $wp_query->query['year'], $wp_query->query['monthnum'] ) );
				   } elseif( is_day() ) {
					   $permalink_url = esc_url( get_day_link( $wp_query->query['year'], $wp_query->query['monthnum'], $wp_query->query['day'] ) );
				   } else {
					   return false;
				   }
			   } else {
				   return false;
			   }
		   } else {
			   return false;
		   }
		   return $permalink_url;

	   }


}