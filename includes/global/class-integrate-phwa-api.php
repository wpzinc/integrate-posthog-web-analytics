<?php
/**
 * PostHog API class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PostHog API class.
 *
 * @package PostHog
 * @author WP Zinc
 */
class Integrate_PHWA_API {

	/**
	 * Holds the API endpoint
	 *
	 * @since   1.1.0
	 *
	 * @var     string
	 */
	public $api_endpoint;

	/**
	 * Holds the user's API key
	 *
	 * @since   1.1.0
	 *
	 * @var     string
	 */
	public $api_key;

	/**
	 * Holds the events to send to PostHog using the /batch endpoint.
	 *
	 * @since   1.1.0
	 *
	 * @var     array
	 */
	public $events = array();

	/**
	 * Constructor
	 *
	 * @since   1.1.0
	 *
	 * @param   string $api_key         API Key.
	 * @param   string $cloud_country   Cloud Country.
	 */
	public function __construct( $api_key, $cloud_country = 'us' ) {

		// Define API Key and endpoint.
		$this->api_key      = $api_key;
		$this->api_endpoint = 'https://' . $cloud_country . '.i.posthog.com/';

	}

	/**
	 * Add an event to the batch for sending when later calling batch_capture().
	 *
	 * @since   1.1.0
	 *
	 * @param   string $event_name   Event name.
	 * @param   array  $properties   Event properties.
	 */
	public function capture_event( $event_name, $properties = array() ) {

		// If the user is logged in, add the user ID to the properties.
		if ( is_user_logged_in() ) {
			$properties['user_id'] = get_current_user_id();
		}

		// Store event.
		$this->events[] = array(
			'event'      => $event_name,
			'properties' => $properties,
			'timestamp'  => gmdate( 'c', time() ),
		);

	}

	/**
	 * Send the batch of events to PostHog.
	 *
	 * @since   1.1.0
	 */
	public function send_events() {

		var_dump( $this->events );
		die();

		// Bail if no events to send.
		if ( empty( $this->events ) ) {
			return;
		}

		// Send events to PostHog.
		$this->post(
			'batch',
			array(
				'historical_migration' => false,
				'events'               => $this->events,
			)
		);

		// Clear events.
		$this->events = array();

	}

	/**
	 * Performs a GET request
	 *
	 * @since   1.1.0
	 *
	 * @param   string            $cmd            Command.
	 * @param   array|bool|string $params         Params.
	 * @return  WP_Error|string|object
	 */
	public function get( $cmd, $params = false ) {

		return $this->request( $cmd, 'get', $params );

	}

	/**
	 * Performs a POST request
	 *
	 * @since  1.1.0
	 *
	 * @param   string            $cmd            Command.
	 * @param   array|bool|string $params         Params.
	 * @return  WP_Error|string|object
	 */
	public function post( $cmd, $params = false ) {

		return $this->request( $cmd, 'post', $params );

	}

	/**
	 * Performs a PUT request
	 *
	 * @since   1.1.0
	 *
	 * @param   string            $cmd            Command.
	 * @param   array|bool|string $params         Params.
	 * @return  WP_Error|string|object
	 */
	public function put( $cmd, $params = false ) {

		return $this->request( $cmd, 'put', $params );

	}

	/**
	 * Returns the maximum amount of time to wait for
	 * a response to the request before exiting
	 *
	 * @since   1.1.0
	 *
	 * @return  int     Timeout, in seconds
	 */
	public function get_timeout() {

		$timeout = 30;

		/**
		 * Defines the maximum time to allow the API request to run.
		 *
		 * @since   1.1.0
		 *
		 * @param   int     $timeout    Timeout, in seconds
		 */
		$timeout = apply_filters( 'integrate_phwa_api_get_timeout', $timeout );

		return $timeout;

	}

	/**
	 * Main function which handles sending async requests to an API using WordPress functions.
	 *
	 * @since   1.1.0
	 *
	 * @param   string            $cmd                      Command (required).
	 * @param   string            $method                   HTTP Method (optional).
	 * @param   array|bool|string $params                   Params.
	 */
	private function request( $cmd, $method = 'get', $params = array() ) {

		// Add API Key to params.
		$params['api_key'] = $this->api_key;

		// Send request.
		switch ( $method ) {
			/**
			 * POST
			 */
			case 'post':
				$result = wp_remote_post(
					$this->api_endpoint . $cmd,
					array(
						'headers' => $this->get_headers(),
						'body'    => wp_json_encode( $params ),
						'timeout' => $this->get_timeout(),
					)
				);
				break;

			/**
			 * PUT
			 */
			case 'put':
				$result = wp_remote_post(
					$this->api_endpoint . $cmd,
					array(
						'method'  => 'PUT',
						'headers' => $this->get_headers(),
						'body'    => wp_json_encode( $params ),
						'timeout' => $this->get_timeout(),
					)
				);
				break;

			/**
			 * GET
			 */
			case 'get':
			default:
				$result = wp_remote_get(
					$this->api_endpoint . $cmd,
					array(
						'headers' => $this->get_headers(),
						'body'    => ( $params !== false ? $params : '' ),
						'timeout' => $this->get_timeout(),
					)
				);
				break;
		}

	}

	/**
	 * Returns the headers for the request.
	 *
	 * @since   1.1.0
	 *
	 * @return  array
	 */
	private function get_headers() {

		return array(
			'Accept'       => 'application/json',
			'Content-Type' => 'application/json',
		);

	}

}
