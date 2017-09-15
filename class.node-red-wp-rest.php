<?php

// Bail if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cheatin\', eh?' );
}

/**
 * Node Red WordPress REST API endpoints
 *
 * @package node-red-wp
 * @since 0.0.1
 */
class Node_Red_WP_REST {

	/**
	 * Class constructor
	 *
	 * Hook in our class to rest_api_init
	 *
	 * @uses add_action()
	 */
	function __construct() {
		add_action( 'rest_api_init', array( $this, 'action__rest_api_init' ) );
	}

	/**
	 * Register our endpoints
	 *
	 * @uses register_rest_route()
	 */
	function action__rest_api_init() {
		// Set a specific key to a specific value
		register_rest_route( 'nrwp/v1', '/set/(?P<key>[a-zA-Z0-9-]+)/(?P<val>[a-zA-Z0-9-.]+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'endpoint__set' ),
		) );

		// Get the value for a specific key
		register_rest_route( 'nrwp/v1', '/get/(?P<key>[a-zA-Z0-9-]+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'endpoint__get' ),
		) );

		// Get an array of all the data keys
		register_rest_route( 'nrwp/v1', '/get_keys', array(
			'methods' => 'GET',
			'callback' => array( $this, 'endpoint__get_keys' ),
		) );

		// Get the keys and values for all data points
		register_rest_route( 'nrwp/v1', '/get_all', array(
			'methods' => 'GET',
			'callback' => array( $this, 'endpoint__get_all' ),
		) );

		register_rest_route( 'nrwp/v1', '/get_stats', array(
			'methods' => 'GET',
			'callback' => array( $this, 'endpoint__get_stats' ),
		) );
	}

	/**
	 * Get the value for a specific data key
	 *
	 * @param WP_Rest_Request $request The REST API request object
	 *
	 * @uses Node_Red_WP::init()
	 * @uses Node_Red_WP::data->get()
	 * @uses $this->format_response()
	 *
	 * @return array Formatted API response
	 */
	function endpoint__get( $request ) {
		$nrwp = Node_Red_WP::init();

		$data = $nrwp->data->get( $request['key'] );

		if ( null === $data ) {
			return $this->format_response( false, false, true, 'No data was found for this key.' );
		}

		return $this->format_response( true, $data );
	}

	/**
	 * Set the value at a specific data key
	 *
	 * @param WP_Rest_Request $request The REST API request object
	 *
	 * @uses Node_Red_WP::init()
	 * @uses Node_Red_WP::data->set()
	 * @uses $this->format_response()
	 *
	 * @return array Formatted API response
	 */
	function endpoint__set( $request ) {
		$nrwp = Node_Red_WP::init();

		$stat = $nrwp->data->set( $request['key'], $request['val'] );

		if ( $stat ) {
			return $this->format_response( true, false, false, 'Value updated.' );
		} else {
			return $this->format_response( false, false, true, 'Not updated. Value did not change.' );
		}
	}

	/**
	 * Get an array of data keys
	 *
	 * @param WP_Rest_Request $request The REST API request object
	 *
	 * @uses Node_Red_WP::init()
	 * @uses Node_Red_WP::data->get_all()
	 * @uses $this->format_response()
	 *
	 * @return array Formatted API response
	 */
	function endpoint__get_keys( $request ) {
		$data = Node_Red_WP::init()->data->get_all();

		return $this->format_response( true, array_keys( $data ) );
	}

	/**
	 * Get an array of data keys and their associated values
	 *
	 * @param WP_Rest_Request $request The REST API request object
	 *
	 * @uses Node_Red_WP::init()
	 * @uses Node_Red_WP::data->get_all()
	 * @uses $this->format_response()
	 *
	 * @return array Formatted API response
	 */
	function endpoint__get_all( $request ) {
		$nrwp = Node_Red_WP::init();

		$data = $nrwp->data->get_all();

		return $this->format_response( true, $data );
	}

	/**
	 * Get an array of stats data from Jetpack
	 *
	 * @param WP_Rest_Requeset $request The REST API request object
	 *
	 * @uses stats_get_from_restapi()
	 * @uses $this->format_response()
	 *
	 * @return array Formatted API response
	 */
	function endpoint__get_stats( $request ) {
		if ( ! function_exists( 'stats_get_from_restapi' ) ) {
			return $this->format_response( false, false, true, 'This feature is not available. Please install the Jetpack plugin.' );
		}

		$stats = stats_get_from_restapi();

		return $this->format_response( true, $stats->stats );
	}

	/**
	 * Standardize an API response payload
	 *
	 * @param bool $status True if the request succeeded, false on failure
	 * @param mixed $data False on failure, array|string on success
	 * @param bool $error True if an error is present, false on success
	 * @param mixed $message False if no message, string when there is an error or notice
	 *
	 * @return array Formatted response payload
	 */
	function format_response( $status, $data = false, $error = false, $message = false ) {
		return array(
			'status'        => $status,
			'data'          => $data,
			'error'         => (bool) $error,
			'error_message' => $message,
		);
	}

}