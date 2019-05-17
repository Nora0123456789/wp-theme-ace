<?php
if ( ! function_exists( 'ace_boolval' ) ) {
	/**
	 * Check if the Var in Boolean
	 * 
	 * @param mixed $val
	**/
	function ace_boolval( $val ) {
		return ( bool ) intval( $val );
	}
}

if ( ! function_exists( 'ace_wrap_text' ) ) {
	/**
	 * Only for simple element
	 */
	function ace_wrap_text( $before, $after, $el, $html, $parent_el = '' )
	{
		$pattern = '<' . $el . '\s[^>]+>)([^<]+)(<\/' . $el . ')';
		if ( is_string( $parent_el ) && '' !== $parent_el ) $pattern = '(<' . $parent_el . '\s[~>]+>' . $pattern;
		$pattern = '/' . $pattern . '/msi';
		return preg_replace(
			'/(<' . $parent_el . '\s[~>]+>[^<]+<' . $el . '\s[^>]+>)([^<]+)(<\/' . $el . ')/msi',
			'{$1}' . $before . '{$2}' . $after . '{$3}',
			$html
		);
	}
}

if( ! function_exists( 'ace_print_edit_shortcut_for_theme_customizer' ) ) {
	/**
	 * Edit Shortcut for Theme Customizer
	 * 
	 * @param string $setting_id
	 * @param string $label
	 * 
	 * @return string
	**/
	function ace_print_edit_shortcut_for_theme_customizer( $setting_id, $label = '' ) {

		if( is_customize_preview() ) {

			AceRenderingMethods::editorShortcutForThemeCustomizer( $setting_id, $label );

		}

	}
}

/**
 * Return EOF String
**/
if ( ! function_exists( 'ace_get_string_eof' ) ) { function ace_get_string_eof( $string ) {
$return = <<< EOF
{$string}
EOF;
return $return;
} }

#
# String
#
if ( ! function_exists( 'ace_is_json_string' ) ) {
	/**
	 * Check if $var is json
	 * 
	 * @parma string $var
	 * 
	 * @return bool
	**/
	function ace_is_json_string( $var ) {

		json_decode( $var );
		return ace_boolval( json_last_error() == JSON_ERROR_NONE );

	}
}

/**
 * Array
 */
if ( ! function_exists( 'ace_array_insert' ) ) {
	/**
	 * Insert an array into another array before/after a certain key
	 *
	 * @param array $array The initial array
	 * @param array $pairs The array to insert
	 * @param string $key The certain key
	 * @param string $position Wether to insert the array before or after the key
	 * @return array
	 */
	function ace_array_insert( $array, $pairs, $key, $position = 'after' ) {
		$key_pos = array_search( $key, array_keys( $array ) );
		if ( 'after' == $position )
			$key_pos++;
		if ( false !== $key_pos ) {
			$result = array_slice( $array, 0, $key_pos );
			$result = array_merge( $result, $pairs );
			$result = array_merge( $result, array_slice( $array, $key_pos ) );
		}
		else {
			$result = array_merge( $array, $pairs );
		}
		return $result;
	}
}


// Comments
	if ( ! function_exists( 'ace_comments_tempalte' ) ) { 
		/**
		 * Print Comment List
		**/
		function ace_comments_tempalte()
		{
			if ( is_singular() 
				|| is_page() 
			) { 
				if ( comments_open( $post ) || get_comments_number() ) { 
					comments_template(); 
				} 
			}
		}
	}

	if ( ! function_exists( 'ace_comments_list' ) ) { 
		/**
		 * Print Comment List
		 * 
		 * @param object $comment
		 * @param array  $args
		 * @param int    $depth
		**/
		function ace_comments_list( $comment, $args, $depth ) {

			echo '<li id="li-comment-'; comment_ID(); echo '" '; comment_class(); echo '>';
				echo '<div class="comment-inner">';
					echo '<div class="comment-header">';
						echo '<div class="comment-avatar-container rotate3d-up-right-20">';
							echo get_avatar( $comment, 100 );
						echo '</div>';

						//echo '<a href="'; comment_link(); echo'">' . esc_html__( 'Anchor', 'ace' ) . '</a>';

						echo '<div class="comment-meta-container">';
							echo '<cite class="comment-author fn">';
								comment_author_link();
							echo '</cite>';

							if ( $comment->comment_approved == '0' ) {
								echo '<p class="wait">';
									esc_html_e( '* Waiting for being approved *', 'ace' );
								echo '</p>';
							}

							echo '<div class="comment-meta">';
								echo '<a class="comment-date" href="'; comment_link(); echo '">';
									echo get_comment_date();
								echo '</a>';

								echo '<time class="comment-time">';
									echo get_comment_time();
								echo '</time>';

								edit_comment_link( esc_html__( 'Edit', 'ace' ), '  ', '' ); 

							echo '</div>';
						echo '</div>';
					echo '</div>';
							
					echo '<div id="comment-'; comment_ID(); echo '" class="comment-body">';

						comment_text();

						echo '<div class="reply">';
							comment_reply_link( array_merge( 
								$args, 
								array( 
									'depth' => $depth, 
									'max_depth' => $args[ 'max_depth' ] 
								) 
							) );
						echo '</div>';


					echo '</div>';
					
					echo '<div class="comment-footer">';


					echo '</div>';
				echo '</div>';

//			echo '</li>';

		}
	}

	if ( ! function_exists( 'ace_comments_pagination' ) ) {
		/**
		 * Print Comment Pagination
		**/
		function ace_comments_pagination() {
			echo ace_get_comments_pagination();
		}
	}

	if ( ! function_exists( 'ace_get_comments_pagination' ) ) {
		/**
		 * Get Comment Pagination HTML
		 * 
		 * @global object $wp_query
		 * 
		 * @return string HTML
		**/
		function ace_get_comments_pagination() {

            global $wp_query;

            $total = ( $wp_query->max_num_comment_pages ? absint( $wp_query->max_num_comment_pages ) : 0 );

            if ( $total > 1 ) {

                $current = intval( get_query_var( 'cpage' ) ) ? intval( get_query_var( 'cpage' ) ) : 1;

                $args = array(
                    'end_size'        => 3,
                    'mid_size'        => 3,
                    'prev_text'       => esc_html__( '&laquo; Previous', 'ace' ),
                    'next_text'       => esc_html__( 'Next &raquo;', 'ace' ),
                );

	            return sprintf( '<div class="pagination"><span>' . esc_html__( 'Comment Page: %1$d of %2$d', 'ace' ) . '</span>%3$s</div>', $current, $total, get_the_comments_pagination( $args ) );

			}
			
			return '';

		}
	}

// Pings
	if ( ! function_exists( 'ace_pings_list' ) ) {
		/**
		 * Print Ping List
		 * 
		 * @param object $comment
		 * @param array  $args
		 * @param int    $depth
		**/
		function ace_pings_list( $comment, $args, $depth ) {

			echo '<li id="li-comment-'; comment_ID(); echo '" '; comment_class(); echo '>';

				echo get_comment_author_link();

				echo '<div class="comment-meta">';
					get_comment_date();
					edit_comment_link( esc_html__( 'Edit', 'ace' ), '  ', '' );
				echo '</div>';

				echo '<div id="comment-'; comment_ID(); echo '" class="comment-body">';
					comment_text();
				echo '</div>';

//			echo '</li>';

		}
	}

