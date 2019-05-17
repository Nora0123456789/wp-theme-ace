<?php
// Check if This is read by WordPress.
if ( ! defined( 'ABSPATH' ) ) exit;

// Degine Plugin Dir Path
if( ! defined( 'ACE_MAIN_FILE' ) ) define( 'ACE_MAIN_FILE', __FILE__ );
if( ! defined( 'ACE_DIR_PATH' ) ) define( 'ACE_DIR_PATH', trailingslashit( get_template_directory() ) );
if( ! defined( 'ACE_DIR_URL' ) ) define( 'ACE_DIR_URL', trailingslashit( get_template_directory_uri() ) );

// Define Class
require_once( ACE_DIR_PATH . '/inc/class-ace.php' );

/**
 * Init Ace
**/
function ace()
{
	global $ace;
	if ( ! $ace instanceof Ace ) {
		try {
			$ace = Ace::getInstance();
			if ( ! $ace instanceof Ace ) {
				throw new Exception( esc_html__( 'Something Wrong.', 'ace' ) );
			}
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
	return $ace;
}
global $ace;
$ace = ace();

// Version Check
/**
 * Check that we can use PHP 5.4 and fail if not
 * 
 * @param string $old_name
 * @param object $old_theme
 */
function ace_version_check( $old_name, $old_theme ) {
	
	if ( version_compare( phpversion(), '5.4.0', '<' ) ) {
		
		function shapeshifer_version_check_notices() {
			echo '<div class="update-nag">';
			printf( __( 'This theme requires PHP version 5.4.0. You are currently using %s.', 'ace' ), PHP_VERSION );
			echo '</div>';
		}
		add_action( 'admin_notices', 'shapeshifer_version_check_notices' );
		
		switch_theme( $old_theme->stylesheet );

	}

}
add_action( 'after_switch_theme', 'ace_version_check', 10, 2 );

