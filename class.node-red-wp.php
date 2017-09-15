<?php

// Bail if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cheatin\', eh?' );
}

/**
 * Node Red WordPress main class
 *
 * @package node-red-wp
 * @since 0.0.1
 */
class Node_Red_WP {

	// Instance holder
	static $instance = null;
	
	// Holders for other classes
	var $api = null;
	var $data = null;
	var $shortcodes = null;

	// Key for the data option name
	const DATA_OPTION_KEY = 'nrwp_data';

	// Get an instance of the core class
	static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Class constructor
	 *
	 * Bootstraps all the sub-classes that the plugin uses
	 *
	 * @uses Node_Red_WP_Rest
	 * @uses Node_Red_WP_Data
	 * @uses Node_Red_WP_Shortcodes
	 * @uses add_action()
	 */
	function __construct() {
		$this->api = new Node_Red_WP_REST();
		$this->data = new Node_Red_WP_Data();
		$this->shortcodes = new Node_Red_WP_Shortcodes();

		add_action( 'wp_enqueue_scripts', array( $this, 'action__enqueue_scripts' ) );
	}

	/**
	 * Register, localize, and include the front end Javascript
	 *
	 * @uses wp_register_script()
	 * @uses wp_localize_script()
	 * @uses wp_enqueue_script()
	 * @uses plugin_dir_url()
	 * @uses plugin_dir_path()
	 * @uses esc_url()
	 * @uses get_rest_url()
	 */
	function action__enqueue_scripts() {
		wp_register_script( 'nrwp', plugin_dir_url( __FILE__ ) . 'js/nrwp.js', array( 'jquery' ), filemtime( plugin_dir_path( __FILE__ ) . 'js/nrwp.js' ) );

		wp_localize_script( 'nrwp', 'nrwp', array(
			'resturl' => esc_url( get_rest_url() ),
		) );

		wp_enqueue_script( 'nrwp' );
	}

}
