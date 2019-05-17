<?php
/**
 * Widget Area
 * 
 * 
**/
class AceWidgetArea {

	/**
	 * Consts
	**/

	/**
	 * Properties
	**/
		/**
		 * ID
		 * @var string
		**/
		private $id = '';

		/**
		 * Data
		 * @var array
		**/
		private $data = array();

	/**
	 * Initializer
	**/
		/**
		 * Public initializer
		 * @param string $id
		 * @param array  $data
		 * @return bool|AceWidget_Area
		**/
		public static function getInstance( $id, $data = array() )
		{
			try {
				$instance = new Self( $id, $data );
			} catch ( AceException $e ) {
				return false;
			}
			return $instance;
		}

		/**
		 * Constructor
		 * @param array $data
		 * @throws AceException
		**/
		protected function __construct( $id, $data = array() )
		{
			if ( ! is_string( $id ) 
				|| '' === $id
				|| ! is_array( $data )
				|| 0 >= count( $data )
				//|| did_action( 'widgets_init' )
			) {
				throw new AceException( esc_html__( 'Failed to initialize the widget area.', 'ace' ) );
			}
			$this->initVars( $id, $data );
			$this->initHooks();
		}

		/**
		 * Init vars
		 * @param array $data
		**/
		protected function initVars( $id, $data )
		{
			$this->id   = $id;
			$this->data = $data;
		}

		/**
		 * Init hooks
		**/
		protected function initHooks()
		{

		}

		/**
		 * Register sidebar
		 * @param array $data
		**/
		public function registerSidebar()
		{
			if ( ! in_array( current_filter(), array( 'widgets_init' ) ) ) {
				return;
			}
			register_sidebar( $this->data );
		}

	/**
	 * Getters
	**/
		/**
		 * Get ID
		**/
		public function getId()
		{
			return $this->id;
		}

		/**
		 * Get Data
		**/
		public function getData()
		{
			return $this->data;
		}

}

