<?php

// Bail if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cheatin\', eh?' );
}

/**
 * Node Red WordPress shortcodes
 *
 * @package node-red-wp
 * @since 0.0.1
 */
class Node_Red_WP_Shortcodes {

	/**
	 * Class constructor
	 */
	function __construct() {
		add_shortcode( 'nodered_data', array( $this, 'shortcode__data' ) );
	}

	/**
	 * Data shortcode
	 *
	 * Returns the markup for a live data point on the front end
	 *
	 * @param array $atts Shortcode attributes
	 *
	 * @uses Node_Red_WP::init()
	 * @uses Node_Red_WP->data
	 * @uses Node_Red_WP->data->get()
	 * @uses esc_attr()
	 * @uses esc_html()
	 *
	 * @return string Formatted shortcode markup
	 */
	function shortcode__data( $atts ) {
		// Get the data for the specified key
		$val = Node_Red_WP::init()->data->get( $atts['key'] );

		// Default the data value when it's not set
		$val = null !== $val ? $val : '[undefined]';

		// Create the shortcode markup
		return sprintf( '<span class="nrwp-data nrwp-data-%s" data-key="%s">%s</span>',
			esc_attr( $atts['key'] ),
			esc_attr( $atts['key'] ),
			esc_html( $val )
		);
	}

}
