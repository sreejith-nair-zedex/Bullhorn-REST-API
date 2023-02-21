<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( "bhCustom" ) ) {
	class bhCustom {
		protected static $instance;
		public $BhRestApi;

		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'initialize' ), 20 );
		}

		public static function getInstance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			$this->includes();
			$this->init();
		}

		public function includes() {
			include_once BH_INCLUDES_DIR . 'class-bh-api.php';
		}

		public function init() {
			$this->BhRestApi = bhRestApi::getInstance();
		}
	}
}