<?php

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'AceDataHTMLClass' ) ) {
/**
 * Data formats
**/
class AceDataHTMLClass extends AceDataAbstract {

	/**
	 * Properties
	**/
		/**
		 * ID for this object.
		 * @var [int|string]
		 */
		protected $id = 0;

		/**
		 * get ID
		 * @return [string]
		 */
		public function getId()
		{
			return $this->id;
		}

		/**
		 * Attributes for this object.
		 * @var [array]
		 */
		protected $attributes = array(
			'id'          => 0, // can be string
			'object_read' => false, // This is false until the object is read from the DB.
			'data_type'   => 'data', // like 'data' 'option' 'post' 'meta'
			'object_type' => '', // like 'single' 'downloadable'
		);

		/**
		 * Data.
		 * @var array
		 */
		protected $data = array();

		/**
		 * Set Prop.
		 * @param array $values
		 * @return bool
		 */
		public function set_classes( $values )
		{
			if ( ! is_array( $values ) 
				|| 0 >= count( $values )
			) {
				return false;
			}
			foreach ( $values as $value ) {
				$this->set_class( $value );
			}
			return true;
		}

		/**
		 * Set Prop.
		 * @param string $value
		 * @return bool
		 */
		public function set_class( $value )
		{
			if ( ! is_string( $value ) 
				|| '' === $value
				|| false !== array_search( $value, $this->data )
			) {
				return false;
			}

			array_push( $this->data, $value );
			return true;
		}

		/**
		 * Get String from data.
		 * @return string
		 */
		public function __toString()
		{
			return implode( $this->data, ' ' );
		}

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		 * @param int|string $id
		**/
		public static function getInstance( $id, $data = array() )
		{
			try {
				$instance = new Self( $id, $data );
			} catch( Ace_Exception $e ) {
				return $e->getMessage();
			}
			return $instance;
		}

		/**
		 * Public Initializer
		 * @param int|string $id
		 * @throws Ace_Exception
		**/
		protected function init( $id, $data = array() )
		{

			$this->id = $id;
			$this->data = apply_filters( ace()->getPrefixedFilterHook( 'html_class' ), $data, $id );

			if ( ! is_array( $data ) ) {
				throw new Ace_Exception( esc_html__( 'Wrong Params.', 'ace' ) );
			}
			if ( 0 < count( $data ) ) {
			foreach ( $data as $data_key => $data_value ) {
				$data_value = sanitize_text_field( $data_value );
				$this->data[ $data_key ] = $data_value;
			}
			}

		}


}
}



