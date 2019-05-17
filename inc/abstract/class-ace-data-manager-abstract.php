<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class AceDataManagerAbstract extends AceUniqueAbstract {

	/**
	 * Static
	**/

	/**
	 * Properties
	**/
		/**
		 * Data
		 * @var array
		**/
		protected $data = array();

		/**
		 * Data
		 * @return AceDataAbstract
		**/
		public function get_data( $key )
		{
			if ( ! is_string( $key )
				|| '' === $key
				|| ! isset( $this->data[ $key ] ) 
			) {
				return false;
			}
			return $this->data[ $key ];
		}

}
