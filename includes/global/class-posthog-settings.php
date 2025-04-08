<?php
/**
 * PostHog settings class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PostHog plugin settings class.
 *
 * @package PostHog
 * @author WP Zinc
 */
class PostHog_Settings {

	use PostHog_Settings_Trait;

	/**
	 * Holds the Settings Key that stores Plugin settings
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const SETTINGS_NAME = '_posthog_settings';

	/**
	 * Constructor. Reads settings from options table, falling back to defaults
	 * if no settings exist.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Get Settings.
		$settings = get_option( self::SETTINGS_NAME );

		// If no Settings exist, falback to default settings.
		if ( ! $settings ) {
			$this->settings = $this->get_defaults();
		} else {
			$this->settings = array_merge( $this->get_defaults(), $settings );
		}

	}

	/**
	 * Returns the Project API Key setting.
	 *
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	public function project_api_key() {

		return $this->settings['project_api_key'];

	}

	/**
	 * Returns the Project ID setting.
	 *
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	public function project_id() {

		return $this->settings['project_id'];

	}

	/**
	 * Returns the Project Region setting.
	 *
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	public function project_region() {

		return $this->settings['project_region'];

	}

	/**
	 * Returns the Persistence setting.
	 *
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	public function persistence() {

		return $this->settings['persistence'];

	}

	/**
	 * Returns an object string of configuration options for the PostHog JS SDK.
	 *
	 * @since   1.0.0
	 *
	 * @return  string
	 */
	public function get_js_init_config() {

		return wp_unslash(
			wp_json_encode(
				array(
					'api_host'    => 'https://' . esc_attr( $this->project_region() ) . '.i.posthog.com',
					'persistence' => esc_attr( $this->persistence() ),
				)
			)
		);

	}

	/**
	 * The default settings, used when the Plugin Settings haven't been saved
	 * e.g. on a new installation.
	 *
	 * @since   1.0.0
	 *
	 * @return  array
	 */
	public function get_defaults() {

		$defaults = array(
			'project_api_key' => '',
			'project_id'      => '',
			'project_region'  => 'us',
			'persistence'     => 'localStorage+cookie',
		);

		/**
		 * The default Plugin settings.
		 *
		 * @since   1.0.0
		 *
		 * @param   array   $defaults   Default Settings.
		 */
		$defaults = apply_filters( 'posthog_settings_get_defaults', $defaults );

		return $defaults;

	}

	/**
	 * Saves the given array of settings to the WordPress options table.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $settings   Settings.
	 */
	public function save( $settings ) {

		update_option( self::SETTINGS_NAME, array_merge( $this->get(), $settings ) );

		// Reload settings in class, to reflect changes.
		$this->settings = get_option( self::SETTINGS_NAME );

	}

}
