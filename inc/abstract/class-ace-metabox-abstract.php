<?php


class AceMetaboxAbstract extends AceUniqueAbstract {

	/**
	 * Static
	**/
		/**
		 * Instance of this Class
		 * 
		 * @var $instance
		**/
		protected static $instance = null;

	/**
	 * Properties
	**/
		/**
		 * Slug
		 * @var string
		**/
		protected $id;

		/**
		 * Title
		 * @var string
		**/
		protected $title;

		/**
		 * Title
		 * @var string[]
		**/
		protected $postTypes = array();

		/**
		 * Context : 'normal', 'side' and 'advanced'
		**/
		protected $context = 'advanced';

		/**
		 * Priority
		 * 'high', 'low' : Default 'default'
		**/
		protected $priority = 'default';

		/**
		 * Args
		**/
		protected $args = array();

	/**
	 * Init
	**/
		/**
		 * Public Initializer
		 * @return Self
		**/
		public static function getInstance() {
			if ( null === self::$instance ) self::$instance = new Self();
			return self::$instance;
		}

		/**
		 * Constructor
		**/
		protected function __construct()
		{
			$this->postTypes = apply_filters( ace()->getPrefixedFilterHook( 'post_types' ),
				$this->postTypes,
				'metabox',
				$this->id
			);
			$this->init();
			$this->initHooks();
		}

		/**
		 * Please Define '$this->title' and $this->args
		**/
		protected function init() {

		}

		/**
		 * Required to add_action
		**/
		protected function initHooks()
		{
			add_action( 'save_post', array( $this, 'saveMetaboxSettings' ) );
			add_action( 'add_meta_boxes', array( $this, 'addMetaBoxes' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
		}

		public function adminEnqueueScripts( $hook )
		{
			if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
				return;
			}

			global $post;
			if ( ! in_array( $post->post_type, $this->postTypes ) ) {
				return;
			}

			$this->enqueueScripts();
		}

		protected function enqueueScripts() {}

	/**
	 * Actions
	**/
		/**
		 * Save Action
		 * @param int $post_id
		**/
		public function saveMetaboxSettings( $post_id ) { do_action( ace()->getPrefixedActionHook( 'save_metabox' ), $post_id ); }

		/**
		 * Add Metaboxes
		 * @param string $post_type
		 * @param object $post
		**/
		public function addMetaBoxes( $post_type = '', $post = '' ) {

			if ( ! in_array( $post_type, $this->postTypes ) 
				|| 'add_meta_boxes' !== current_filter()
			) {
				return;
			}

			add_meta_box(
				ace()->getPrefixedName( $this->id ),
				$this->title,
				array( $this, 'render' ),
				$post_type,
				$this->context,
				$this->priority,
				$this->args
			);

		}

		/**
		 * Add Metaboxes
		 * @param WP_Post $post
		 * @param array $args Default array()
		**/
		public function render( $post, $args = array() ) {}

	/**
	 * Help
	**/
		/**
		 * Get Post Meta Prefix
		**/
		public function getPrefixedPostMetaName( $name, $context = 'meta' )
		{
			if ( 'meta' === $context ) {
				return ace()->getPrefixedPostMetaName( $name );
			}
			elseif ( 'theme' === $context ) {
				return ace()->getPrefixedThemePostMetaName( $name );
			}
			else {
				return ace()->getPrefixedPostMetaName( $name );
			}

			return ace()->getPrefixedPostMetaName( $name );

		}

}


