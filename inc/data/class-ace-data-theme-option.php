<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class AceDataThemeOption extends AceDataOption {

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
			} catch ( AceException $e ) {
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
			$this->setOptionId( ace()->getPrefixedThemeOptionName( $id ) );
		}

}