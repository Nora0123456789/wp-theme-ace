<?php
/**
 * Frontend Methods
**/
class AceRenderingMethods {

	/**
	 *
	**/
		public static function getNoImageSrc() {
			return ACE_DIR_URL . 'assets/img/no-img-dark.png';
		}

	/**
	 * Template
	**/
		/**
		 * Print Template
		**/
		public static function loadTemplatePart( $template, $name = '' )
		{
			$name = apply_filters( ace()->getPrefixedFilterHook( 'template_name' ), $name, $template );
			$template = apply_filters( ace()->getPrefixedFilterHook( 'template' ), array( 'template', $template ) );
			get_template_part( implode( '/', $template ), $name );
		}

	#
	# General Tags
	#
		/**
		 * Render defined SVG
		 * @param string $svg_class
		 * @param string $xlink_id
		**/
		public static function renderDefinedSVG( $svg_class, $xlink_id, $size = array( 24, 24 ), $view_box = '0 0 24 24'  )
		{
			echo self::getDefinedSVG( $svg_class, $xlink_id );
		}
		public static function getDefinedSVG( $svg_class, $xlink_id )
		{
			return '<svg class="' . esc_attr( $svg_class ) . '" viewBox="0 0 24 24"><use xlink:href="#' . $xlink_id . '"></use></svg>';
		}

		/**
		 * Print General Element Tag
		 *
		 * @static
		 *
		 * @param string $element
		 * @param string $atts
		 * @param string $text
		 * @param string $wrap
		 *
		 * @see self::getGeneratedTag( $element, $atts, $text, $wrap )
		**/
		public static function generatedTag( $element, $atts = array(), $text = '', $wrap = false ) {
			echo self::getGeneratedTag( $element, $atts, $text, $wrap );
		}

		/**
		 * Get General Element Tag
		 *
		 * @static
		 *
		 * @param string $element
		 * @param string $atts
		 * @param string $text
		 * @param string $wrap
		 *
		 * @return string
		**/
		public static function getGeneratedTag( $element, $atts = array(), $text = '', $wrap = false ) {
			$return = '<' . $element;
			foreach( $atts as $key => $val ) { $return .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"'; }
			if ( $wrap ) {
				$return .= '>' . esc_html( $text ) . '</' . $element . '>';
			} else {
				if ( $text != '' ) { $return .= ' data-' . ACE_THEME_PREFIX . 'text="' . esc_attr( $text ) . '"'; }
				$return .= '/>';
			}
			return $return;
		}

	#
	# Images
	#
		/**
		 * Get Image Tag with Alternative Noscript Tag
		 *
		 * @static
		 *
		 * @param string $src
		 * @param string $type
		 * @param []     $atts
		 *
		 * @return string
		**/
		public static function getImageTagWithNoScript( $src, $type = 'img', $atts = array() ) {

			$no_img = self::getNoImageSrc();

			if ( 'img' === $type ) {
				$img_format = '<img class="%1$s lazy" alt="%2$s" src="%6$s" data-src="%3$s" data-width="%4$s" data-height="%5$s" /><noscript><img class="%1$s" alt="%2$s" src="%3$s" srcset="%3$s" width="%4$s" height="%5$s" /></noscript>';
			}
			elseif ( 'svg' === $type ) {
				$img_format = '<svg class="%1$s lazy" viewBox="0,0,%4$d,%5$d"><title>%2$s</title><desc>%6$s</desc><image href="%6$s" data-src="%3$s" width="%4$dpx" height="%5$dpx" /></svg><noscript><svg class="%1$s" viewBox="0,0,%4$d,%5$d"><title>%2$s</title><desc>%7$s</desc><image href="%3$s" width="%4$dpx" height="%5$dpx" /></svg></noscript>';
			}

			$atts = wp_parse_args( $atts, array(
				'src'  => esc_url( $src ),
				'class' => '',
				'alt' => '',
				'width' => 80,
				'height' => 80,
				'desc' => '',
			));

			$html = sprintf( $img_format, esc_attr( $atts['class'] ), esc_attr( $atts['alt'] ), esc_url( $atts['src'] ), absint( $atts['width'] ), absint( $atts['height'] ), esc_url( $no_img ), $atts['desc'] );

			return $html;

		}

		/**
		 * Print Default Post Thumbnail URL
		 *
		 * @static
		 *
		 * @param WP_Post $post
		 *
		 * @see self::getGeneratedTag( $element, $atts, $text, $wrap )
		**/
		public static function theDefaultThumbnailUrl( $post ) {
			echo esc_url( self::getTheDefaultThumbnailUrl( $post ) );
		}

		/**
		 * Get Default Post Thumbnail URL
		 *
		 * @static
		 *
		 * @param WP_Post $post
		 *
		 * @return string $url
		**/
		public static function getTheDefaultThumbnailUrl( $post ) {

			$cat = get_the_category( $post->ID );

			if ( isset( $cat[ 0 ] ) ) {
				$default_cat_thumbnail = get_term_meta( $cat[ 0 ]->term_id, 'ace_term_default_thumbnail', true );
			} else {
				$default_cat_thumbnail = '';
			}

			$default_cat_thumbnail = esc_url( apply_filters( ace()->getPrefixedFilterHook( 'defualt_thumbnail_url_before_set_theme_mod_value' ), $default_cat_thumbnail, $post ) );

			return esc_url(
				$default_cat_thumbnail != ''
				? $default_cat_thumbnail
				: get_theme_mod( 'default_thumbnail_image', ACE_DIR_URL . 'img/no-img.png' )
			);

		}

		/**
		 * Print Default Post Thumbnail in Div Tag
		 *
		 * @static
		 *
		 * @param string $class
		 * @param array $size
		 * 		'width' => "{$int}px",
		 * 		'height' => "{$int}px",
		 *
		 * @see self::getDivTagDefaultThumbnail( $class, $size )
		**/
		public static function divTagDefaultThumbnail( $class = 'default-post-thumbnail', $size = array( 'width' => '80px', 'height' => '80px' ) ) {
			echo self::getDivTagDefaultThumbnail( $class, $size );
		}

		/**
		 * Get Default Post Thumbnail in Div Tag
		 *
		 * @static
		 *
		 * @param string $class                  : Default "default-post-thumbnail"
		 * @param array  $size                   : Default
		 * 		'width' => "{$int}px",
		 * 		'height' => "{$int}px",
		 * @param string $optional_def_image_url : Default ""
		 *
		 * @see self::getGeneratedTag( $element, $atts = array(), $text = '', $wrap = false )
		 *
		 * @return string
		**/
		public static function getDivTagDefaultThumbnail( $class = 'default-post-thumbnail', $size = array( 'width' => '80px', 'height' => '80px' ), $optional_def_image_url = '' ) {

			// カスタマイザーでデフォルトを設定している場合
			$default_thumbnail_url = esc_url(
				$optional_def_image_url
				? $optional_def_image_url
				: getThemeMod( 'default_thumbnail_image', '' )
			);

			$atts = array(
				'class' => esc_attr( $class ? $class . ' default-thumbnail' : 'default-thumbnail' ),
				'style' => esc_attr( 'width: ' . $size[ 'width' ] . '; height: ' . $size[ 'height' ] . '; background-image: url(' . $default_thumbnail_url . '); background-size: ' . $size[ 'width' ] . ' ' . $size[ 'height' ] . '; background-position: center center; background-repeat: no-repeat;' )
			);
			$return = self::getGeneratedTag( 'div', $atts, '', true );

			return apply_filters( ace()->getPrefixedFilterHook( 'default_thumbnail_div_tag' ), $return, $class, $size, $optional_def_image_url );

		}

		/**
		 * Print Default Thumbnail IMG Tag
		 *
		 * @static
		 *
		 * @param string $class
		 * @param array $size
		 * 		'width' => "{$int}px",
		 * 		'height' => "{$int}px",
		 *
		 * @see self::getImgTagDefaultThumbnail( $class, $size, $alt )
		**/
		public static function imgTagDefaultThumbnail( $class = 'default-post-thumbnail', $size = array( 'width' => 80, 'height' => 80 ), $alt = '' ) {
			echo self::getImgTagDefaultThumbnail( $class, $size, $alt );
		}

		/**
		 * Get Default Thumbnail IMG Tag
		 *
		 * @static
		 *
		 * @param string $class
		 * @param array $size
		 * 		'width' => "{$int}px",
		 * 		'height' => "{$int}px",
		 *
		 * @see self::getGeneratedTag( $element, $atts = array(), $text = '', $wrap = false )
		 *
		 * @return string
		**/
		public static function getImgTagDefaultThumbnail( $class = 'default-post-thumbnail', $size = array( 'width' => 80, 'height' => 80 ), $alt = '', $optional_def_image_url = '' ) {

			$default_thumbnail_url = esc_url(
				$optional_def_image_url
				? $optional_def_image_url
				: get_theme_mod( 'default_thumbnail_image', ACE_DIR_URL . 'img/no-img.png' )
			);

			$atts = array(
				'class' => esc_attr( $class ? $class . ' default-thumbnail' : 'default-thumbnail' ),
				'src' => esc_url( $default_thumbnail_url ),
				'width' => absint( $size[ 'width' ] ),
				'height' => absint( $size[ 'height' ] ),
				'alt' => esc_attr( $alt )
			);
			$return = self::getGeneratedTag( 'img', $atts, '', true );

			return apply_filters( ace()->getPrefixedFilterHook( 'default_thumbnail_img_tag' ), $return, $class, $size, $alt, $optional_def_image_url );

		}

		/**
		 * Print Image in Div
		 *
		 * @static
		 *
		 * @param int $post_id
		 * @param string $class
		 * @param array $size
		 * 		'width' => "{$int}px",
		 * 		'height' => "{$int}px",
		 *
		 * @see self::getDivTagPostThumbnail( $post_id, $class, $size )
		**/
		public static function divTagPostThumbnail( $post_id, $div_class = 'post-thumbnail', $size = array( 'width' => '80px', 'height' => '80px' ) ) {
			echo self::getDivTagPostThumbnail( $post_id, $div_class, $size );
		}

		/**
		 * Get Default Thumbnail IMG Tag
		 *
		 * @static
		 *
		 * @param int $post_id
		 * @param string $class
		 * @param array $size
		 * 		'width' => "{$int}px",
		 * 		'height' => "{$int}px",
		 *
		 * @see self::getGeneratedTag( $element, $atts = array(), $text = '', $wrap = false )
		 *
		 * @return string
		**/
		public static function getDivTagPostThumbnail( $post_id, $div_class = 'post-thumbnail', $size = array( 'width' => '80px', 'height' => '80px' ) ) {

			$post_thumbnail_url = esc_url( get_the_post_thumbnail( $post_id ) );

			if ( ! $post_thumbnail_url )
				return;

			$atts = array(
				'class' => esc_attr( $div_class ),
				'style' => 'background-image: url(' . $post_thumbnail_url . '); background-size: ' . esc_attr( $size[ 'width' ] ) . ' ' . esc_attr( $size[ 'height' ] ) . '; background-position: center center; background-repeat: no-repeat;'
			);
			$return = self::getGeneratedTag( 'div', $atts );

			return apply_filters( ace()->getPrefixedFilterHook( 'post_thumbnail_div_tag' ), $return, $post_id, $div_class, $size );

		}

	/**
	 * Breadcrumb
	**/
		/**
		 * Item
		 * @param string $label
		 * @param string $type
		 * @param string $url
		**/
		public static function renderBreadcrumbItem( $label, $type, $url = '' )
		{

			echo '<li class="breadcrumb-item ' . $type . '" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';

				if ( is_string( $url ) && '' !== $url ) echo '<a class="breadcrumb-link" href="' . esc_url( $url ) . '" itemprop="url">';

					echo '<span class="breadcrumb-link-text" itemprop="title">';
						echo esc_html( $label );
					echo '</span>';

				if ( is_string( $url ) && '' !== $url ) echo '</a>';

			echo '</li>';


		}

	/**
	 * Theme Customizer
	**/
		/**
		 * Edit Shortcut for Theme Customizer
		 *
		 * @param string $setting_id
		 * @param string $label
		 *
		 * @return string
		**/
		public static function editorShortcutForThemeCustomizer( $setting_id, $label = '' ) {

			echo self::getEditorShortcutForThemeCustomizer( $setting_id, $label );

		}

		/**
		 * Edit Shortcut for Theme Customizer
		 *
		 * @param string $setting_id
		 * @param string $label
		 *
		 * @return string
		**/
		public static function getEditorShortcutForThemeCustomizer( $setting_id, $label = '' ) {

			if( empty( $label ) )
				$label = esc_html__( 'Click to edit this.', 'ace' );

			$return = '';

			$return .= '<span class="customize-partial-edit-shortcut customize-partial-edit-shortcut-blogname ace-shortcut-to-related-setting">';
					$return .= '<button aria-label="' . esc_attr( $label ) . '" title="' . esc_attr( $label ) . '" class="customize-partial-edit-shortcut-button" data-setting-id="' . esc_attr( $setting_id ) . '">';
						$return .= '<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">';
							$return .= '<path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path>';
						$return .= '</svg>';
					$return .= '</button>';
			$return .= '</span>';

			return apply_filters( ace()->getPrefixedFilterHook( 'edit_shortcut_icon_for_theme_customizer' ), $return, $setting_id, $label );
		}

}
