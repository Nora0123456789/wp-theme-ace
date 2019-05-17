<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class AceDataOption extends AceDataCURDAbstract {

	/**
	 * Properties
	**/
		/**
		 * Attributes for this object.
		 * @var string
		 */
		protected $option_id = '';

		/**
		 * Get Option ID.
		 * @var string
		 */
		public function setOptionId( $option_id )
		{
			if ( '' !== $option_id ) {
				$this->option_id = $option_id;
				return true;
			}
			return false;
		}

		/**
		 * Get Option ID.
		 * @var string
		 */
		public function getOptionId()
		{
			return $this->option_id;
		}

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
	 * Init
	**/
		/**
		 * Public Initializer
		 * @param string $id
		 * @param array  $defaults
		 * @return AceDataOption
		**/
		public static function getInstance( $id, $defaults = null )
		{
			try {
				$instance = new Self( $id, $defaults );
			} catch ( Ace_Exception $e ) {
				if ( is_admin() ) ace()->addNoticeMessage( $e->getMessage() );
				return false;
			}
			return $instance;
		}

		/**
		 * Constructor
		 * @param string $id
		 * @param array  $defaults
		**/
		protected function __construct( $id, $defaults = null )
		{
			parent::__construct( $id, $defaults );
			$this->read();
		}

		/**
		 * Init
		 * @param string $id
		 * @param array  $defaults
		**/
		protected function init( $id, $defaults = null )
		{
			parent::init( $id, $defaults );
			$this->setOptionId( ace()->getPrefixedOptionName( $id ) );
		}

	/**
	 * Create
	**/
		/**
		 * Create Option from $this->data
		**/
		public function create()
		{
			$this->data = wp_parse_args( $this->data, AceOptionManager::$defaults[ $this->getId() ] );
			$value = $this->maybeJsonEncode( $this->data );
			if ( ! is_int( $value ) || is_string( $value ) || is_bool( $value ) ) {
				$this->delete();
				add_option( $this->getOptionId(), apply_filters( ace()->getPrefixedFilterHook( 'sanitize_option_value' ), $value, $this->getId() ) );
			}
		}

	/**
	 * Read
	**/
		/**
		 * Read Saved Data and set to $this->data
		**/
		public function read()
		{
			$this->data = $this->maybeJsonDecode( get_option( $this->getOptionId(), $this->defaults ) );
			$this->data = wp_parse_args( $this->data, AceOptionManager::$defaults[ $this->getId() ] );
		}

	/**
	 * Update
	**/
		/**
		 * Update Option from $this->data
		**/
		public function update()
		{
			$result = false;
			$this->data = wp_parse_args( $this->data, AceOptionManager::$defaults[ $this->getId() ] );
			$value = $this->maybeJsonEncode( $this->data );
			if ( ! is_int( $value ) || is_string( $value ) || is_bool( $value ) ) {
				$result = update_option( $this->getOptionId(), apply_filters( ace()->getPrefixedFilterHook( 'sanitize_option_value' ), $value, $this->getId() ) );
			}
			return $result;
		}

	/**
	 * Delete
	**/
		/**
		 * Delete Option
		**/
		public function delete()
		{
			delete_option( $this->getOptionId() );
			$this->data = AceOptionManager::$defaults[ $this->getId() ];
		}

}



