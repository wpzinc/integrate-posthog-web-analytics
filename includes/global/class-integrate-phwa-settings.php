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
class Integrate_PHWA_Settings {

	use Integrate_PHWA_Settings_Trait;

	/**
	 * Holds the Settings Key that stores Plugin settings
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const SETTINGS_NAME = '_integrate_phwa_settings';

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
	 * Returns true if the Project API Key is set.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function has_project_api_key() {

		return ! empty( $this->settings['project_api_key'] );

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
	 * Returns true if the Project ID is set.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function has_project_id() {

		return ! empty( $this->settings['project_id'] );

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
	 * Returns true if the Project Region is set.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function has_project_region() {

		return ! empty( $this->settings['project_region'] );

	}

	/**
	 * Returns the Reverse Proxy Domain setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  string
	 */
	public function reverse_proxy_domain() {

		if ( ! $this->has_reverse_proxy_domain() ) {
			return '';
		}

		$domain = $this->settings['reverse_proxy_domain'];
		if ( strpos( $domain, 'http://' ) !== 0 && strpos( $domain, 'https://' ) !== 0 ) {
			$domain = 'https://' . ltrim( $domain, '/' );
		}

		return $domain;

	}

	/**
	 * Returns true if the Reverse Proxy Domain is set.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function has_reverse_proxy_domain() {

		return ! empty( $this->settings['reverse_proxy_domain'] );

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
	 * Returns true if the Plugin has its API Key and Region set.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function enabled() {

		return $this->has_project_api_key() && $this->has_project_region();

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
					'api_host'    => $this->get_api_host(),
					'ui_host'     => $this->get_ui_host(),
					'persistence' => esc_attr( $this->persistence() ),
				)
			)
		);

	}

	/**
	 * Returns the API host, depending on whether a Reverse Proxy Domain is set.
	 *
	 * @since   1.1.4
	 *
	 * @return  string
	 */
	public function get_api_host() {

		// If a Reverse Proxy Domain is set, use it.
		if ( $this->has_reverse_proxy_domain() ) {
			return $this->reverse_proxy_domain();
		}

		// Otherwise, use the default API host.
		return 'https://' . esc_attr( $this->project_region() ) . '.i.posthog.com';

	}

	/**
	 * Returns the UI host, depending on whether a Reverse Proxy Domain is set.
	 *
	 * @since   1.1.4
	 *
	 * @return  string
	 */
	public function get_ui_host() {

		return 'https://' . esc_attr( $this->project_region() ) . '.posthog.com';

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
			'project_api_key'      => '',
			'project_id'           => '',
			'project_region'       => 'us',
			'reverse_proxy_domain' => '',
			'persistence'          => 'localStorage+cookie',
		);

		/**
		 * The default Plugin settings.
		 *
		 * @since   1.0.0
		 *
		 * @param   array   $defaults   Default Settings.
		 */
		$defaults = apply_filters( 'integrate_phwa_settings_get_defaults', $defaults );

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
