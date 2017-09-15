<?php

// Bail if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cheatin\', eh?' );
}

/**
 * Node Red WordPress data access interface
 *
 * @package node-red-wp
 * @since 0.0.1
 */
class Node_Red_WP_Data {

	/**
	 * Load existing data object, default to empty array
	 *
	 * @uses get_option()
	 * @uses Node_Red_WP::DATA_OPTION_KEY
	 *
	 * @return array Data object
	 */
	function load() {
		$data = get_option( Node_Red_WP::DATA_OPTION_KEY );

		if ( ! $data ) {
			$data = array();
		}

		return $data;
	}

	/**
	 * Pluck a specific value from the data array, default to null
	 *
	 * @param string $key The key to get data for
	 *
	 * @uses $this->load()
	 *
	 * @return string Value at key location
	 */
	function get( $key ) {
		$data = $this->load();

		return isset( $data[ $key ] ) ? $data[ $key ] : null;
	}

	/**
	 * Get all data keys and values
	 *
	 * @uses $this->load()
	 *
	 * @return array Array of data keys and values
	 */
	function get_all() {
		return $this->load();
	}

	/**
	 * Set a specific value to a data key, store in wp_options
	 *
	 * @param string $key The key location
	 * @param string $val The value to store at key
	 *
	 * @uses $this->load()
	 * @uses update_option()
	 * @uses Node_Red_WP::DATA_OPTION_KEY
	 *
	 * @return bool True if option updated, false if no change
	 */
	function set( $key, $val ) {
		$data = $this->load();

		$data[ $key ] = $val;

		return update_option( Node_Red_WP::DATA_OPTION_KEY, $data );
	}

}
