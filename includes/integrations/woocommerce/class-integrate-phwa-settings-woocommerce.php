<?php
/**
 * PostHog WooCommerce settings class.
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
class Integrate_PHWA_Settings_WooCommerce {

	use Integrate_PHWA_Settings_Trait;

	/**
	 * Holds the Settings Key that stores Plugin settings
	 *
	 * @since   1.1.0
	 *
	 * @var     string
	 */
	const SETTINGS_NAME = '_integrate_phwa_settings_woocommerce';

	/**
	 * Constructor. Reads settings from options table, falling back to defaults
	 * if no settings exist.
	 *
	 * @since   1.1.0
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
	 * Returns the event view product setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_view_product() {

		return $this->event( 'view_product' );

	}

	/**
	 * Returns the event add to cart setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_add_to_cart() {

		return $this->event( 'add_to_cart' );

	}

	/**
	 * Returns the event update cart setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_update_cart() {

		return $this->event( 'update_cart' );

	}

	/**
	 * Returns the event view cart setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_view_cart() {

		return $this->event( 'view_cart' );

	}

	/**
	 * Returns the event checkout started setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_checkout_started() {

		return $this->event( 'checkout_started' );

	}

	/**
	 * Returns the event checkout in progress setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_checkout_in_progress() {

		return $this->event( 'checkout_in_progress' );

	}

	/**
	 * Returns the event checkout completed setting.
	 *
	 * @since   1.1.0
	 *
	 * @return  bool
	 */
	public function event_checkout_completed() {

		return $this->event( 'checkout_completed' );

	}

	/**
	 * Returns the event setting.
	 *
	 * @since   1.1.0
	 *
	 * @param   string $name   Event name.
	 * @return  bool
	 */
	private function event( $name ) {

		return (bool) $this->settings[ 'event_' . $name ];

	}

	/**
	 * The default settings, used when the Plugin Settings haven't been saved
	 * e.g. on a new installation.
	 *
	 * @since   1.1.0
	 *
	 * @return  array
	 */
	public function get_defaults() {

		$defaults = array(
			'event_view_product'         => false,
			'event_add_to_cart'          => false,
			'event_update_cart'          => false,
			'event_view_cart'            => false,
			'event_checkout_started'     => false,
			'event_checkout_in_progress' => false,
			'event_checkout_completed'   => false,
		);

		/**
		 * The default Plugin settings.
		 *
		 * @since   1.1.0
		 *
		 * @param   array   $defaults   Default Settings.
		 */
		$defaults = apply_filters( 'integrate_phwa_settings_woocommerce_get_defaults', $defaults );

		return $defaults;

	}

	/**
	 * Saves the given array of settings to the WordPress options table.
	 *
	 * @since   1.1.0
	 *
	 * @param   array $settings   Settings.
	 */
	public function save( $settings ) {

		update_option( self::SETTINGS_NAME, array_merge( $this->get(), $settings ) );

		// Reload settings in class, to reflect changes.
		$this->settings = get_option( self::SETTINGS_NAME );

	}

}
