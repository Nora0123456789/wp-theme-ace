<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class AceNavMenuManager extends AceUniqueAbstract {

    /**
	 * Static
	**/
		/**
		 * Instance
		 * @var AceAdminPageManager
		**/
		protected static $instance;

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		 * @return AceAdminPageManager
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct()
		{
			$this->init();
			$this->initHooks();
		}
		
		protected function init()
		{

		}

		protected function initHooks()
		{

			// Walker Instance
				//add_filter( ace()->getPrefixedFilterHook( 'walker_nav_menu_instance' ), array( $this, 'filterWalkerNavMenu' ), 10, 2 );

			// Frontend
				add_filter( 'walker_nav_menu_start_el', array( $this, 'appendNavDescription' ), 10, 4 );

		}

	/**
	 * Frontend
	**/
		/**
		 * 
		 */
		public function appendNavDescription( $item_output, $item, $depth, $args ) {

			$appended_classes = array();

			// Append Description
			if ( ! empty( $item->description ) ) {

				array_push( $appended_classes, 'menu-link-has-description' );

				$item_output = str_replace(
					$args->link_after,
					'</span><span class="menu-link-description">' . $item->description . '</span></div><span class="menu-link-icon"></span>',
					$item_output
				);

				$item_output = preg_replace(
					'/<span\sclass=[\'"]menu-link-text[\'"]/i',
					'<span class="menu-link-text menu-link-has-description"',
					$item_output
				);

			}

			return $item_output;

		}

		/**
		 * 
		 */
		public function filterWalkerNavMenu( $walker, $theme_location ) 
		{
			if ( 'primary' === $theme_location && ! wp_is_mobile() ) {
				return new AceWalkerNavMenu();
			}
			return $walker;

		}


}

