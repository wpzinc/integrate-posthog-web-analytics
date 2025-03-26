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
class PostHog_Admin_Section_General {

	use PostHog_Admin_Section_Trait;
	use PostHog_Admin_Section_Fields_Trait;

	/**
	 * Constructor.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Define the class that reads/writes settings.
		$this->settings = new PostHog_Settings();

		// Define the programmatic name, title, tab and settings key.
		$this->name         = 'general';
		$this->title        = __( 'General Settings', 'posthog' );
		$this->tab_text     = __( 'General', 'posthog' );
		$this->settings_key = $this->settings::SETTINGS_NAME;

		// Define settings sections.
		$settings_sections = array(
			'general' => array(
				'title'    => $this->title,
				'callback' => array( $this, 'print_section_info' ),
				'wrap'     => true,
			),
		);

		/**
		 * Define settings sections for the General screen.
		 *
		 * @since   1.0.0
		 *
		 * @param   array   $settings_sections  Settings sections.
		 */
		$settings_sections = apply_filters( 'posthog_admin_section_general_sections', $settings_sections );

		// Assign to class.
		$this->settings_sections = $settings_sections;
		unset( $settings_sections );

		// Enqueue CSS.
		add_action( 'posthog_admin_settings_enqueue_styles', array( $this, 'enqueue_styles' ) );

		// If tab text is not defined, use the title for the tab's text.
		if ( empty( $this->tab_text ) ) {
			$this->tab_text = $this->title;
		}

		// Register the settings section.
		$this->register_section();

	}

	/**
	 * Enqueues styles for the Settings > General screen.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $section    Settings section / tab.
	 */
	public function enqueue_styles( $section ) {

		// Bail if we're not on the general section.
		if ( $section !== $this->name ) {
			return;
		}

	}

	/**
	 * Registers settings fields for this section.
	 *
	 * @since   1.0.0
	 */
	public function register_fields() {

		// Define fields.
		$fields = array(
			'project_api_key' => array(
				'title'   => __( 'Project API Key', 'posthog' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'text',
					'value'       => $this->settings->project_api_key(),
					'description' => esc_html__( 'Copy the Project API Key from the PostHog > Settings > Project, entering it here.', 'posthog' ),
				),
			),
			'project_id'      => array(
				'title'   => __( 'Project ID', 'posthog' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'text',
					'value'       => $this->settings->project_id(),
					'description' => esc_html__( 'Copy the Project ID from the PostHog > Settings > Project, entering it here.', 'posthog' ),
				),
			),
			'project_region'  => array(
				'title'   => __( 'Project region', 'posthog' ),
				'section' => $this->name,
				'props'   => array(
					'type'        => 'select',
					'value'       => $this->settings->project_region(),
					'description' => esc_html__( 'Define the region where your PostHog data is hosted.', 'posthog' ),
					'options'     => array(
						'us' => 'US',
						'eu' => 'EU',
					),
				),
			),
		);

		/**
		 * Register settings fields for the general settings screen.
		 *
		 * @since   1.0.0
		 *
		 * @param   array                $fields     Fields.
		 * @param   PostHog_Settings     $settings   Settings class.
		 */
		$fields = apply_filters( 'posthog_admin_section_general_register_fields', $fields, $this->settings ); // @phpstan-ignore-line

		// Add settings fields.
		foreach ( $fields as $id => $field ) {
			add_settings_field(
				$id,
				$field['title'],
				( array_key_exists( 'callback', $field ) ? $field['callback'] : array( $this, $field['props']['type'] . '_field_callback' ) ),
				$this->settings_key,
				$field['section'],
				array_merge(
					$field['props'],
					array(
						'name' => $id,
					)
				)
			);
		}

	}

	/**
	 * Prints help info for the general section of the settings screen.
	 *
	 * @since   1.0.0
	 */
	public function print_section_info() {

		?>
		<p class="description"><?php esc_html_e( 'Enter your Project API Key and Project ID to enable web analytics tracking.', 'posthog' ); ?></p>
		<?php

	}

	/**
	 * Returns the URL for the Plugin documentation for this setting section.
	 *
	 * @since   1.0.0
	 *
	 * @return  string  Documentation URL.
	 */
	public function documentation_url() {

		return 'https://www.wpzinc.com/documentation/posthog';

	}

}
