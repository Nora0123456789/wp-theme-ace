<?php
// Check if WP is Loaded
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'AceUniqueAbstract' ) ) {
/**
 * Class which should be initialized only once
**/
abstract class AceUniqueAbstract {

	/**
	 * Statics
	**/
		/**
		 * Instance of the Class
		 * @var object AceUniqueAbstract
		**/
		protected static $instance = null;

	/**
	 * Settings
	**/
		/**
		 * Cloning is forbidden.
		 * @since 1.0.0
		 */
		public function __clone()
		{
			_doing_it_wrong( __FUNCTION__, esc_html__( 'DO NOT Clone.', 'ace' ), '1.0.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 * @since 1.0.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'DO NOT Unserialize', 'ace' ), '1.0.0' );
		}

}
}

