<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'AcePostMetaManager' ) ) {
/**
 * Data formats
**/
class AcePostMetaManager extends AceUniqueAbstract {

	/**
	 * Consts
	**/

	/**
	 * Vars
	**/
		/**
		 * Admin
		 * 
		 * @var $admin
		**/
		protected static $instance;

	/**
	 * Properties
	**/
		/**
		 * Options
		 * @var AceDataOption[]
		**/
		private $postmeta = array();

		/**
		 * Set Post Meta
		 * @param int   $post_id
		 * @param array $postmeta
		 * @param void
		**/
		public function setProp( $post_id, $postmeta )
		{
			if ( ! is_numeric( $post_id ) 
				|| 0 >= intval( $post_id ) 
				|| ! is_array( $postmeta )
				|| 0 >= count( $postmeta )
			) {
				return false;
			}

			$post_id = intval( $post_id );
			foreach ( $postmeta as $key => $value ) {
				$result = $this->setPostMeta( $post_id, $key, $value );
			}
		}
	
		/**
		 * @param int    $post_id
		 * @param string $key
		 * @param mixed  $value
		 * @param void
		**/
		public function setPostMeta( $post_id, $key, $value )
		{
			if ( ! is_numeric( $post_id ) 
				|| 0 >= intval( $post_id ) 
				|| ! is_string( $key ) 
				|| '' === $key
			) {
				return false;
			}

			$post_id = intval( $post_id );
			if ( ! isset( $this->postmeta[ $post_id ] ) ) {
				$this->postmeta[ $post_id ] = array();
			}

			$this->postmeta[ $post_id ][ $key ] = $value;
			return true;
		}

	/**
	 * Initializer
	**/
		/**
		 * Public initializer
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) {
				self::$instance = new Self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct()
		{
			$this->initVars();
			$this->load();
			$this->initHooks();
		}

		/**
		 * Init Vars
		**/
		protected function initVars()
		{
			$this->option_ids = apply_filters(
				ace()->getPrefixedFilterHook( 'option_ids' ),
				array()
			);
		}

		/**
		 * Constructor
		**/
		protected function load()
		{

			if ( ! is_array( $this->option_ids ) || 0 >= count( $this->option_ids ) ) {
				return;
			}
			foreach ( $this->option_ids as $option_id ) {
				$this->options[ $option_id ] = AceDataPostMeta( $option_id );
			}

		}

		/**
		 * Init hooks
		**/
		protected function initHooks()
		{

		}

	/**
	 * 
	**/

}
}

