<?php

class AceShortcodeManager extends AceUniqueAbstract {

	/**
	 * Static
	**/
		/**
		 * Instance of this Class
		**/
        protected static $instance = null;
        
        /**
         * Used Shortcodes
         * @var string[]
        **/
        protected static $usedSC = array();

        public function getUsedSC()
        {
            return self::$usedSC;
        }

        public function addUsedShortcode( $shortcode = '' )
        {
            if ( ! in_array( $shortcode, self::$usedSC ) ) array_push( self::$usedSC, $shortcode );
        }

        /**
         * Check if shortcode is used
         * @param string[] $shortcodes
         * @return bool
         */
        public function didShortcodes( $shortcodes = array() )
        {

            if ( is_array( self::$usedSC ) && 0 >= count( self::$usedSC ) ) {
                return false;
            }

            foreach ( $shortcodes as $shortcode ) {
                if ( array_search( $shortcode, self::$usdeSC ) ) {
                    return true;
                }
            }

            return false;

        }

        /**
         * Check if shortcode is used
         * @param string[] $shortcodes
         * @return bool
         */
        public function didShortcode( string $shortcode )
        {
            if ( is_array( self::$usedSC ) && 0 >= count( self::$usedSC ) ) return false;
            if ( array_search( $shortcode, self::$usdeSC ) ) return true;
            return false;
        }

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		**/
		public static function getInstance()
		{
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct() {
            $this->initVars();
            $this->initHooks();
        }

        protected function initVars()
        {
            add_action( ace()->getPrefixedActionHook( 'init_shortcodes' ) );
        }

        protected function initHooks()
        {
            add_filter( 'do_shortcode_tag', array( $this, 'registerUsedSC' ), 1, 3 );
        }

        public function registerUsedSC( $output, $tag, $attr = array() )
        {
            $this->addUsedShortcode( $tag );
            return $output;
        }




}
