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
		$this->settings = new Integrate_PHWA_Settings();

		// Define the programmatic name, title, tab and settings key.
		$this->name         = 'woocommerce';
		$this->title        = __( 'WooCommerce Settings', 'integrate-posthog-web-analytics' );
		$this->description  = __( 'Define the WooCommerce events to track.', 'integrate-posthog-web-analytics' );
		$this->tab_text     = __( 'WooCommerce', 'integrate-posthog-web-analytics' );
		$this->documentation_url = 'https://www.wpzinc.com/documentation/posthog/woocommerce';
		$this->settings_key = $this->settings::SETTINGS_NAME;

		// Define fields.
		$fields = array(
			'test' => array(
				'title'   => __( 'test', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'text',
					'value'       => 'test',
					'description' => esc_html__( 'Copy the Project API Key from the PostHog > Settings > Project, entering it here.', 'integrate-posthog-web-analytics' ),
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

add_action( 'integrate_phwa_initialize_admin', function() {

	//$integrate_phwa_admin_section_woocommerce = new Integrate_PHWA_Admin_Section_WooCommerce();

});