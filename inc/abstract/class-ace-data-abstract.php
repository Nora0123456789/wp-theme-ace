<?php

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! class_exists( 'AceDataAbstract' ) ) {
/**
 * Data formats
**/
class AceDataAbstract {

	/**
	 * Statics
	**/
		/**
		 * Instance of the Class
		 * 
		 * @var object Ace_Data_Option
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
			'data_type'   => 'data', // like 'data' 'option' 'post' 'meta'
			'object_type' => '', // like 'single' 'downloadable'
		);

		/**
		 * Data
		 * @var array
		 */
		protected $data = array();

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
		public static function getInstance( $id, $defaults = null )
		{
			try {
				$instance = new Self( $id, $defaults );
			} catch( Exception $e ) {
				return $e->getMessage();
			}
			return $instance;
		}

		/**
		 * Public Initializer
		 * @param int|string $id
		 * @throws Exception
		**/
		protected function __construct( $id, $defaults = null )
		{
			if ( ! is_int( $id ) && ! is_string( $id ) 
				|| empty( $id )
			) {
				throw new Exception( esc_html__( 'Wrong ID.', 'ace' ) );
			}
			$this->init( $id, $defaults );
		}

		/**
		 * Public Initializer
		 * @param int|string $id
		 * @throws Exception
		**/
		protected function init( $id, $defaults = null )
		{

			$this->id   = $id;
			$this->data = $this->defaults = $defaults;

			if ( in_array( $this->getAttr( 'data_type' ), array( 'option', 'post_meta', 'theme_mod' ) ) ) {
				$func = 'get_' . $this->getAttr( 'data_type' );
				if ( function_exists( $func ) ) {
					$data = $func( $id, $defaults );
					if ( is_string( $data ) ) {
						$maybe_json_decoded = json_decode( $data, true );
						if ( null !== $maybe_json_decoded ) {
							$data = $maybe_json_decoded;
						}
						unset( $maybe_json_decoded );
					} elseif ( is_array( $data ) ) {
					} else { 
					}
					$this->data = $data;
				}
			}

			if ( is_array( $this->data ) && is_array( $this->defaults ) ) {
				$this->data = wp_parse_args( $this->data, $this->defaults );
			}

			do_action( ace()->getPrefixedActionHook( 'init_data' ), $this, $id, $this->data );

		}

	/**
	 * Getters
	**/
		/**
		 * Get ID
		 * @return int|string
		**/
		public function getId()
		{
			return $this->id;
		}

		/**
		 * Get Defaults
		 * @return array
		**/
		public function getDefaults()
		{
			return $this->defaults;
		}

		/**
		 * Get Attributes
		 * @param string $key : Default ''
		 * @uses array $this->attributes
		 * @return bool|mixed : Returns false for errors.
		**/
		public function getAttr( $key = '' )
		{

			if ( ! is_string( $key ) ) {
				return false;
			} elseif ( '' === $key ) {
				return $this->attributes;
			} elseif ( '' !== $key && isset( $this->attributes[ $key ] ) ) {
				return $this->attributes[ $key ];
			}

			return false;

		}

		/**
		 * Get Data
		 * @uses array $this->data
		 * @return array
		**/
		public function getData()
		{
			return $this->data;
		}

		/**
		 * Get Prop
		 * @param string $key : Default ''
		 * @uses array $this->data
		 * @return bool|mixed : Returns false for errors.
		**/
		public function getProp( $key = '' )
		{
			if ( is_string( $key ) 
				&& '' !== $key 
				&& isset( $this->data[ $key ] )
			) {
				return $this->data[ $key ];
			}
			return false;
		}

	/**
	 * Setters
	**/
		/**
		 * Set ID
		 * @param int|string $id
		 * @return bool
		**/
		public function setId( $id )
		{

			if ( ! is_int( $id ) || ! is_string( $id ) || empty( $id ) ) {
				return false;
			}

			$this->id               = $id;
			$this->attributes['id'] = $id;

			return true;

		}

		/**
		 * Set Defaults
		 * @param array $defaults : Default array()
		 * @return bool
		**/
		public function setDefaults( $defaults = array() )
		{

			if ( ! is_array( $defaults ) || 0 >= count( $defaults ) ) {
				return false;
			}

			$this->defaults = $defaults;
			return true;

		}

		/**
		 * Set Attributes
		 * @param array $attributes : Default array()
		 * @return bool
		**/
		public function setAtts( $attributes = array() )
		{

			if ( ! is_array( $attributes ) || 0 >= count( $attributes ) ) {
				return false;
			}

			foreach ( $attributes as $attribute_key => $attribute_value ) {

				try {
					$result = $this->setAttr( $attribute_key, $attribute_value );
				} catch ( Ace_Exception $e ) {
					continue;
				}

			}

			return true;

		}

		/**
		 * Set Attribute Value
		 * @param string $key
		 * @param mixed  $value
		 * @throws Ace_Exception
		 * @return bool
		**/
		public function setAttr( $key, $value = null )
		{

			if ( ! is_string( $key ) || '' === $key ) {
				throw new Ace_Exception( esc_html__( 'Wrong key is set.', 'ace' ) );
			}

			if ( null === $value ) {
				throw new Ace_Exception( esc_html__( 'Value is not set.', 'ace' ) );
			}

			$this->attributes[ $key ] = $value;

			return true;

		}

		/**
		 * Set Prop.
		 * @param string $key
		 * @param string $value
		 * @return bool
		 */
		public function setProps( $data )
		{

			if ( ! is_array( $data ) 
				|| 0 >= count( $data )
			) {
				return false;
			}

			foreach ( $data as $data_key => $data_value ) {
				$this->setProp( $data_value, $data_key );
			}

			return true;

		}

		/**
		 * Set Prop.
		 * @param string $key
		 * @param string $value
		 * @return bool
		 */
		public function setProp( $value, $key = '' )
		{
			if ( ! is_string( $value ) 
				|| '' === $value
			) {
				return false;
			}

			if ( '' === $key ) {
				array_push( $this->data, $value );
			} else {
				$this->data[ $key ] = $value;
			}

			return true;
		}

	/**
	 * Delete
	**/
		/**
		 * Delete Prop.
		 * @param string $key
		 * @param string $value
		 * @return bool
		 */
		public function deleteProp( $key = '', $value = '' )
		{
			$class = $this->getProp( $key );
			if ( false === $class ) {
				if ( is_string( $value ) 
					&& '' !== $value
				) {
					foreach ( $this->data as $data_key => $data_value ) {
						if ( $data_value === $value ) {
							unset( $this->data[ $data_key ] );
						}
					}
					return true;
				}
				return false;
			}
			unset( $this->data[ $key ] );
			return true;

		}


}

}



