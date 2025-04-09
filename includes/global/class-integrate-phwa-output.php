<?php
/**
 * PostHog output class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PostHog output class.
 *
 * @package PostHog
 * @author WP Zinc
 */
class Integrate_PHWA_Output {

	/**
	 * Constructor.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Enqueue JS on the frontend site.
	 *
	 * @since   1.0.0
	 */
	public function enqueue_scripts() {

		// Get settings class.
		$settings = new Integrate_PHWA_Settings();

		// Bail if no Project API Key is set.
		if ( empty( $settings->project_api_key() ) ) {
			return;
		}

		// Enqueue the PostHog JS SDK.
		wp_enqueue_script(
			'integrate-phwa',
			INTEGRATE_PHWA_PLUGIN_URL . 'assets/js/posthog-min.js',
			array(),
			INTEGRATE_PHWA_PLUGIN_VERSION,
			false
		);
		wp_add_inline_script( 'integrate-phwa', 'posthog.init("' . esc_js( $settings->project_api_key() ) . '", ' . $settings->get_js_init_config() . ')', 'after' );

	}

}
