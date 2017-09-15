<?php
/*
Plugin Name: Node Red WordPress
Description: Magical things happen when you combine <strong>Node Red</strong> and <strong>WordPress</strong>.
Plugin URI: https://github.com/Automattic/node-red-wordpress
Author: Automattic
Author URI: https://automattic.com
Version: 0.0.1
*/

// Class requirements
require_once( plugin_dir_path( __FILE__ ) . 'class.node-red-wp.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class.node-red-wp-data.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class.node-red-wp-rest.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class.node-red-wp-shortcodes.php' );
require_once( plugin_dir_path( __FILE__ ) . 'class.node-red-wp-data-widget.php' );

// Bootstrap the plugin flow
function nrwp_init() {
	Node_Red_WP::init();
}
add_action( 'init', 'nrwp_init' );

// Bootstrap widgets
add_action( 'widgets_init', array( 'Node_Red_WP', 'action__widgets_init' ) );