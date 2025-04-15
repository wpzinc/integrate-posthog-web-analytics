<?php
/**
 * PostHog API trait.
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
trait Integrate_PHWA_API_Trait {

	/**
	 * Holds the user's API key
	 *
	 * @since   1.1.0
	 *
	 * @var     string
	 */
	public $api_key;

	/**
	 * Holds the cloud country
	 *
	 * @since   1.1.0
	 *
	 * @var     string
	 */
	public $cloud_country;

	/**
	 * Holds the events to send to PostHog using the /batch endpoint.
	 *
	 * @since   1.1.0
	 *
	 * @var     array
	 */
	public $events = array();

	/**
	 * Holds the PostHog user distinct ID.
	 *
	 * @since   1.1.0
	 *
	 * @var     string
	 */
	private $distinct_id = '';

	/**
	 * Add an event to the batch for sending when later calling batch_capture().
	 *
	 * @since   1.1.0
	 *
	 * @param   string $event_name   Event name.
	 * @param   array  $properties   Event properties.
	 */
	public function capture_event( $event_name, $properties = array() ) {

		// Set distinct ID.
		$this->set_distinct_id();

		// Bail if no distinct ID.
		if ( ! $this->distinct_id ) {
			return;
		}

		// Add distinct ID to properties.
		$properties['distinct_id'] = $this->distinct_id;

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

		// Bail if no events to send.
		if ( empty( $this->events ) ) {
			return;
		}

		// Send events to PostHog.
		$this->post(
			'batch',
			array(
				'batch' => $this->events,
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
	 * @return  WP_Error|string|object
	 */
	private function request( $cmd, $method = 'get', $params = array() ) {

		// Define API Key.
		$params['api_key'] = $this->api_key;

		// Define endpoint.
		$endpoint = 'https://' . $this->cloud_country . '.i.posthog.com/';

		// Send request.
		switch ( $method ) {
			/**
			 * POST
			 */
			case 'post':
				$result = wp_remote_post(
					$endpoint . $cmd,
					array(
						'headers'  => $this->get_headers(),
						'body'     => wp_json_encode( $params ),
						'timeout'  => $this->get_timeout(),
						'blocking' => false,
					)
				);
				break;

			/**
			 * PUT
			 */
			case 'put':
				$result = wp_remote_post(
					$endpoint . $cmd,
					array(
						'method'   => 'PUT',
						'headers'  => $this->get_headers(),
						'body'     => wp_json_encode( $params ),
						'timeout'  => $this->get_timeout(),
						'blocking' => false,
					)
				);
				break;

			/**
			 * GET
			 */
			case 'get':
			default:
				$result = wp_remote_get(
					$endpoint . $cmd,
					array(
						'headers' => $this->get_headers(),
						'body'    => ( $params !== false ? $params : '' ),
						'timeout' => $this->get_timeout(),
					)
				);
				break;
		}

		return $result;

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

	/**
	 * Sets the distinct ID from the cookie.
	 *
	 * @since   1.1.0
	 */
	private function set_distinct_id() {

		// If a distinct ID is already set, return it.
		if ( $this->distinct_id ) {
			return $this->distinct_id;
		}

		// If the ph_phc_* cookie exists, use the distinct ID from it.
		// This is set by the PostHog JavaScript snippet.
		foreach ( $_COOKIE as $name => $value ) {
			if ( strpos( $name, 'ph_phc_' ) === 0 ) {
				$data = json_decode( stripslashes( $value ) );
				if ( $data->distinct_id ) {
					$this->distinct_id = $data->distinct_id;
					break;
				}
			}
		}

	}

}
