<?php
/**
 * PostHog settings section general class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers General Settings that can be edited at Settings > PostHog > General.
 *
 * @package PostHog
 * @author WP Zinc
 */
class Integrate_PHWA_Admin_Section_General {

	use Integrate_PHWA_Admin_Section_Trait;
	use Integrate_PHWA_Admin_Section_Fields_Trait;

	/**
	 * Constructor.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Define the class that reads/writes settings.
		$this->settings = new Integrate_PHWA_Settings();

		// Define the programmatic name, title, tab and settings key.
		$this->name              = 'general';
		$this->title             = __( 'General Settings', 'integrate-posthog-web-analytics' );
		$this->description       = __( 'Enter your Project API Key and Project ID to enable web analytics tracking.', 'integrate-posthog-web-analytics' );
		$this->tab_text          = __( 'General', 'integrate-posthog-web-analytics' );
		$this->documentation_url = 'https://www.wpzinc.com/documentation/posthog';
		$this->settings_key      = $this->settings::SETTINGS_NAME;

		// Define fields.
		$this->fields = array(
			'project_api_key' => array(
				'title'   => __( 'Project API Key', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'text',
					'value'       => $this->settings->project_api_key(),
					'description' => esc_html__( 'Copy the Project API Key from the PostHog > Settings > Project, entering it here.', 'integrate-posthog-web-analytics' ),
				),
			),
			'project_id'      => array(
				'title'   => __( 'Project ID', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'text',
					'value'       => $this->settings->project_id(),
					'description' => esc_html__( 'Copy the Project ID from the PostHog > Settings > Project, entering it here.', 'integrate-posthog-web-analytics' ),
				),
			),
			'project_region'  => array(
				'title'   => __( 'Project region', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'select',
					'value'       => $this->settings->project_region(),
					'description' => esc_html__( 'Define the region where your PostHog data is hosted.', 'integrate-posthog-web-analytics' ),
					'options'     => array(
						'us' => 'US',
						'eu' => 'EU',
					),
				),
			),
			'persistence'     => array(
				'title'   => __( 'Persistence', 'integrate-posthog-web-analytics' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'select',
					'value'       => $this->settings->persistence(),
					'description' => esc_html__( 'Where to store user data. Use `memory` to meet GDPR, HIPAA or other privacy requirements.', 'integrate-posthog-web-analytics' ),
					'options'     => array(
						'localStorage+cookie' => __( 'Local Storage + Cookie', 'integrate-posthog-web-analytics' ),
						'cookie'              => __( 'Cookie', 'integrate-posthog-web-analytics' ),
						'localStorage'        => __( 'Local Storage', 'integrate-posthog-web-analytics' ),
						'sessionStorage'      => __( 'Session Storage', 'integrate-posthog-web-analytics' ),
						'memory'              => __( 'Memory', 'integrate-posthog-web-analytics' ),
					),
				),
			),
		);

		// Define settings panels.
		$this->settings_sections = array(
			'general' => array(
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

		$sections['general'] = new Integrate_PHWA_Admin_Section_General();
		return $sections;

	}
);
