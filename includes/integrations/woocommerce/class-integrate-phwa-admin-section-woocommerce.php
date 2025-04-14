<?php
/**
 * PostHog WooCommerce integration class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PostHog WooCommerce integration class.
 *
 * @package PostHog
 * @author WP Zinc
 */
class Integrate_PHWA_Admin_Section_WooCommerce {

	use Integrate_PHWA_Admin_Section_Trait;
	use Integrate_PHWA_Admin_Section_Fields_Trait;

	/**
	 * Constructor. Defines the actions to track events on.
	 *
	 * @since   1.1.0
	 */
	public function __construct() {

		// Define the class that reads/writes settings.
		$this->settings = new Integrate_PHWA_Settings_WooCommerce();

		// Define the programmatic name, title, tab and settings key.
		$this->name              = 'woocommerce';
		$this->title             = __( 'WooCommerce Settings', 'integrate-posthog-web-analytics' );
		$this->description       = __( 'Define the WooCommerce events to track.', 'integrate-posthog-web-analytics' );
		$this->tab_text          = __( 'WooCommerce', 'integrate-posthog-web-analytics' );
		$this->documentation_url = 'https://www.wpzinc.com/documentation/posthog/woocommerce';
		$this->settings_key      = $this->settings::SETTINGS_NAME;

		// Define fields.
		$this->fields = array(
			'event_view_product'         => array(
				'title'   => __( 'Event: View Product', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_view_product(),
					'description' => esc_html__( 'If enabled, tracks viewing a product.', 'integrate-posthog-web-analytics' ),
				),
			),
			'event_add_to_cart'          => array(
				'title'   => __( 'Event: Add to Cart', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_add_to_cart(),
					'description' => esc_html__( 'If enabled, tracks adding a product to the cart.', 'integrate-posthog-web-analytics' ),
				),
			),
			'event_update_cart'          => array(
				'title'   => __( 'Event: Update Cart', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_update_cart(),
					'description' => esc_html__( 'If enabled, tracks updating the cart.', 'integrate-posthog-web-analytics' ),
				),
			),
			'event_view_cart'            => array(
				'title'   => __( 'Event: View Cart', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_view_cart(),
					'description' => esc_html__( 'If enabled, tracks viewing the cart.', 'integrate-posthog-web-analytics' ),
				),
			),
			'event_checkout_started'     => array(
				'title'   => __( 'Event: Checkout Started', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_checkout_started(),
					'description' => esc_html__( 'If enabled, tracks the checkout started event.', 'integrate-posthog-web-analytics' ),
				),
			),
			'event_checkout_in_progress' => array(
				'title'   => __( 'Event: Checkout In Progress', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_checkout_in_progress(),
					'description' => esc_html__( 'If enabled, tracks the checkout in progress event.', 'integrate-posthog-web-analytics' ),
				),
			),
			'event_checkout_completed'   => array(
				'title'   => __( 'Event: Checkout Completed', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'checkbox',
					'value'       => $this->settings->event_checkout_completed(),
					'description' => esc_html__( 'If enabled, tracks the checkout completed event.', 'integrate-posthog-web-analytics' ),
				),
			),
		);

		// Define settings sections.
		$this->settings_sections = array(
			'woocommerce' => array(
				'title'    => $this->title,
				'callback' => array( $this, 'print_section_info' ),
				'wrap'     => true,
			),
		);

		// Register the settings section.
		$this->register_section();

	}

}

// Bootstrap.
add_filter(
	'integrate_phwa_admin_settings_register_sections',
	function ( $sections ) {

		$sections['woocommerce'] = new Integrate_PHWA_Admin_Section_WooCommerce();
		return $sections;

	}
);
