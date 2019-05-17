<?php

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'AceDataPostMeta' ) ) {
/**
 * Data formats
**/
class AceDataPostMeta extends AceDataAbstract {

	/**
	 * Statics
	**/
		/**
		 * Instance of the Class
		 * 
		 * @var object AceDataPostMeta
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * ID for this object.
		 * @var [int|string]
		 */
		protected $id = 0;

		/**
		 * Attributes for this object.
		 * @var [array]
		 */
		protected $attributes = array(
			'id'          => 0, // can be string
			'object_read' => false, // This is false until the object is read from the DB.
			'data_type'   => 'option', // like 'data' 'option' 'post' 'meta'
			'object_type' => '', // like 'single' 'downloadable'
		);

		/**
		 * Default Data.
		 * @var array
		 */
		protected $defaults = array();

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		 * @param int|string $id
		**/
		public static function getInstance( $id, $defaults = array() )
		{

			try {
				$instance = new Self( $id, $defaults );
			} catch( Ace_Exception $e ) {
				return $e->getMessage();
			}

		}

		/**
		 * Public Initializer
		 * @param int|string $id
		 * @throws Ace_Exception
		**/
		protected function init( $id, $defaults = array() )
		{

			$this->data = get_option( ace()->getPrefixedOptionName(), $defaults );
			parent::init( $id, $defaults );

		}


}
}



