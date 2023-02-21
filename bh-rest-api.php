<?php
/*
  Plugin Name: Bullhorn Rest Api
  Description: Plugin to fetch jobs from Bullhorn.
  Version: 1.0.0
*/

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'BH_PLUGIN_DIR' ) ) {
	define( 'BH_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
	define( 'BH_INCLUDES_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/' );
//	define( 'CJ_JS_DIR', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) . '/assets/js/' );
}

if ( ! class_exists( 'bhCustom' ) ) {
	include_once BH_INCLUDES_DIR . "class-bh.php";
}

function bh_init(): bhCustom {
	return bhCustom::getInstance();
}

bh_init();