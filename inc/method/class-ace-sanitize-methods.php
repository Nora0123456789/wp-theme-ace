<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'AceSanitizeMethods' ) ) {
class AceSanitizeMethods {

	/**
	 * Check if is set. Return value if true. Otherwise, return false.
	 * 
	 * @param string  $string
	 *
	 * @return string $string
	**/
	public static function validateDescriptionString( $string ) {

		$string = wp_kses( $string, array(
			'a'      => array(
				'href'  => array(),
				'class' => array()
			),
			'strong' => array(),
			'em'     => array(),
			'b'      => array()
		) );

		return $string;

	}

	/**
	 * Check if is set. return value if true. Otherwise, return false.
	 * 
	 * @param  mixed   $value
	 * 
	 * @return bool $return
	**/
	public static function validateCheckedValue( $value ) {

		if( isset( $value ) ) {
			return false;
		} else {
			return $value;
		}

	}

	/**
	 * Sanitize Color Value
	 * 
	 * @param  string $value : Color Value
	 *
	 * @return string $value
	**/
	public static function sanitizeColorValue( $value ) {

		# Is RGB
			$is_rgb = strpos( $value, 'rgb' ) !== false;

		# Default Value
			$return = '';

		# If is RGB
			if( $is_rgb ) {

				preg_match( '/rgba?\((\s*?([0-9]){1,3}\,?){3}(0|1)\.?[0-9]*?\)/i', $value, $matched );
				if( isset( $matched[0] ) )
					$return = sanitize_text_field( $matched[0] );

			}

		# If is HEX 
			elseif( strpos( $value, '#' ) !== false ) {

				$return = sanitize_hex_color( $value );

			}

		# If is no HEX 
			else {

				$return = sanitize_hex_color_no_hash( $value );

			}

		# End
			return $return;

	}

	/**
	 * Sanitize Checkbox Value
	 * 
	 * @param  bool|int|? $input
	 *
	 * @return bool $value
	**/
	public static function sanitizeCheckbox( $input ) {
		if ( $input == true ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sanitize Int Value
	 * 
	 * @param mixed $input
	 *
	 * @return int $value
	**/
	public static function sanitizeInt( $input ) {
		return intval( $input );
	}

	/**
	 * Sanitize String Value
	 * 
	 * @param mixed $input
	 *
	 * @return string $value
	**/
	public static function sanitizeTextarea( $input ) {
		return esc_textarea( $input );
	}

	/**
	 * Sanitize Text Align
	 * 
	 * @param string $input : Text Align
	 *
	 * @return string $return
	**/
	public static function sanitizeTextAlign( $input ) {

		$return = '';

		$text_aligns = array_flip( ace()->getThemeModManager()->getThemeModsChoicesTextAligns() );

		if( in_array( $input, $text_aligns ) ) {

			$return = $input;

		}

		return $return;

	}

	/**
	 * Sanitize Font Family
	 * 
	 * @param string $input : Font Family
	 *
	 * @return string $return
	**/
	public static function sanitizeFontFamilies( $input ) {

		$return = '';

		$font_families = array_flip( ace()->getThemeModManager()->getFontFamilies() );

		if( in_array( $input, $font_families ) ) {

			$return = $input;

		}

		return $return;

	}

	/**
	 * Sanitize Background Image Size
	 * 
	 * @param string $input
	 *
	 * @return string $return
	**/
	public static function sanitizeBackgroundImageSize( $input ) {

		$return = '';

		$background_image_sizes = array_flip( ace()->getThemeModManager()->getThemeModsChoicesBackgroundSize() );

		if( in_array( $input, $background_image_sizes ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Background Position Row
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeBackgroundPositionRow( $input ) {

		$return = '';

		$background_position_row = array_flip( ace()->getThemeModManager()->getThemeModsChoicesBackgroundPositionRow() );

		if( in_array( $input, $background_position_row ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Background Position Column
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeBackgroundPositionColumn( $input ) {

		$return = '';

		$background_position_column = array_flip( ace()->getThemeModManager()->getThemeModsChoicesBackgroundPositionColumn() );

		if( in_array( $input, $background_position_column ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Background Repeat
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeBackgroundRepeat( $input ) {

		$return = '';

		$background_repeats = array_flip( ace()->getThemeModManager()->getThemeModsChoicesBackgroundRepeats() );

		if( in_array( $input, $background_repeats ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Background Attachment
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeBackgroundAttachment( $input ) {

		$return = '';

		$background_attachment = array_flip( ace()->getThemeModManager()->getThemeModsChoicesBackgroundAttachments() );

		if( in_array( $input, $background_attachment ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize CSS Animations Hover
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeCSSAnimationHover( $input ) {

		$return = '';

		$css_class_array = ace()->getThemeModManager()->geAnimateCSSClassArray();
		$css_animations = array_flip( $css_class_array['hover'] );

		if( in_array( $input, $css_animations ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize CSS Animations Enter
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeCSSAnimationEnter( $input ) {

		$return = '';

		$css_class_array = ace()->getThemeModManager()->geAnimateCSSClassArray();
		$css_animations = array_flip( $css_class_array['enter'] );

		if( in_array( $input, $css_animations ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize CSS Animations Enter
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeEnterAnimation( $input ) {

		$return = '';

		$css_class_array = ace()->getThemeModManager()->getAnimationClasses();
		$css_animations = array_flip( $css_class_array['enter'] );

		if( in_array( $input, $css_animations ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize CSS Animations Enter
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeHideAnimation( $input ) {

		$return = '';

		$css_class_array = ace()->getThemeModManager()->getAnimationClasses();
		$css_animations = array_flip( $css_class_array['hide'] );

		if( in_array( $input, $css_animations ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Header Style Pattern
	 * 
	 * @param string $input
	 * 
	 * @return string
	**/
	public static function sanitizeHeaderStylePattern( $input )
	{

		$return = '';
		$style_patterns = array( 'plain', 'formal', 'material' );
		if ( in_array( $input, $style_patterns ) ) {
			$return = sanitize_text_field( $input );
		}
		return $return;

	}

	/**
	 * Sanitize Header Layout Pattern
	 * 
	 * @param string $input
	 * 
	 * @return string
	**/
	public static function sanitizeHeaderLayoutPattern( $input )
	{

		$return = '';
		$style_patterns = array( 'vertical', 'flex', 'fixed-on-left' );
		if ( in_array( $input, $style_patterns ) ) {
			$return = sanitize_text_field( $input );
		}
		return $return;

	}

	/**
	 * Sanitize Archive Article Layout Pattern
	 * 
	 * @param string $input
	 * 
	 * @return string
	**/
	public static function sanitizeArchiveArticleLayoutPattern( $input )
	{

		$return = '';
		$style_patterns = array( 'card', '3-cols', 'slider' );
		if ( in_array( $input, $style_patterns ) ) {
			$return = sanitize_text_field( $input );
		}
		return $return;

	}

	/**
	 * Sanitize Credit Type
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeCreditType( $input ) {

		$return = '';

		$credit_types = array_flip( ace()->getThemeModManager()->getThemeModsChoicesCreditTypes() );

		if( in_array( $input, $credit_types ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Credit Type
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeFooterAlign( $input ) {

		$return = '';

		$footer_align = array_flip( ace()->getThemeModManager()->getThemeModsChoicesFooterAligns() );

		if( in_array( $input, $footer_align ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

	/**
	 * Sanitize Credit Type
	 * 
	 * @param string $input
	 *
	 * @return $return
	**/
	public static function sanitizeDesignedEdgeTypes( $input ) {

		$return = '';

		$designed_edge_types = array_flip( ace()->getThemeModManager()->getThemeModsDesignedEdgeTypes() );

		if( in_array( $input, $$designed_edge_types ) ) {

			$return = sanitize_text_field( $input );

		}

		return $return;

	}

}
}
