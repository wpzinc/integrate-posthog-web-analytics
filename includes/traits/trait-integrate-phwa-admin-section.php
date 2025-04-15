<?php
/**
 * PostHog settings section trait.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PostHog settings section trait class.
 *
 * @package PostHog
 * @author WP Zinc
 */
trait Integrate_PHWA_Admin_Section_Trait {

	/**
	 * Section name
	 *
	 * @since   1.0.0
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Section title
	 *
	 * @since   1.0.0
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * Section description
	 *
	 * @since   1.1.0
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Section documentation URL
	 *
	 * @since   1.1.0
	 *
	 * @var string
	 */
	public $documentation_url = '';

	/**
	 * Section tab text
	 *
	 * @since   1.0.0
	 *
	 * @var string
	 */
	public $tab_text = '';

	/**
	 * Options table key
	 *
	 * @since   1.0.0
	 *
	 * @var string
	 */
	public $settings_key = '';

	/**
	 * Holds the settings class for the section.
	 *
	 * @since   1.0.0
	 *
	 * @var     false|Integrate_PHWA_Settings|Integrate_PHWA_Settings_WooCommerce
	 */
	public $settings;

	/**
	 * Holds the settings fields for a settings screen.
	 *
	 * @since   1.1.0
	 *
	 * @var     array
	 */
	public $fields = array();

	/**
	 * Holds the settings sections for a settings screen.
	 *
	 * @since   1.0.0
	 *
	 * @var     array
	 */
	public $settings_sections = array();

	/**
	 * Holds whether the save button should be disabled e.g. there are no
	 * settings on screen to save.
	 *
	 * @since   1.0.0
	 *
	 * @var     bool
	 */
	public $save_disabled = false;

	/**
	 * Registers settings fields for this section.
	 *
	 * @since   1.1.0
	 */
	public function register_fields() {

		// Add settings fields.
		foreach ( $this->fields as $id => $field ) {
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
	 * Helper method to determine if we're viewing the current settings screen.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $tab    Current settings tab (general|tools|restrict-content|broadcasts).
	 * @return  bool
	 */
	public function on_settings_screen( $tab ) {

		// phpcs:disable WordPress.Security.NonceVerification

		// Bail if we're not on the settings screen.
		if ( ! array_key_exists( 'page', $_REQUEST ) ) {
			return false;
		}
		if ( sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) !== '_Integrate_PHWA_settings' ) {
			return false;
		}

		// Define current settings tab.
		// General screen won't always be loaded with a `tab` parameter.
		$current_tab = ( array_key_exists( 'tab', $_REQUEST ) ? sanitize_text_field( wp_unslash( $_REQUEST['tab'] ) ) : 'general' );

		// Return whether the request is for the current settings tab.
		return ( $current_tab === $tab );

		// phpcs:enable

	}

	/**
	 * Register settings section.
	 *
	 * @since   1.0.0
	 */
	public function register_section() {

		// Register settings sections.
		foreach ( $this->settings_sections as $name => $settings_section ) {
			// Determine if this settings section needs to be wrapped in its own container.
			$wrap = array();
			if ( $settings_section['wrap'] ) {
				$wrap = array(
					'before_section' => $this->get_render_container_start( $name ),
					'after_section'  => $this->get_render_container_end(),
				);
			}

			add_settings_section( // @phpstan-ignore-line
				$name,
				$settings_section['title'],
				$settings_section['callback'],
				$this->settings_key,
				$wrap
			);
		}

		// Register settings fields.
		$this->register_fields();

		// Register setting to store data in options table.
		register_setting(
			$this->settings_key,
			$this->settings_key,
			array( $this, 'sanitize_settings' )
		);

	}

	/**
	 * Renders the section
	 *
	 * @since   1.0.0
	 */
	public function render() {

		/**
		 * Performs actions prior to rendering the settings form.
		 *
		 * @since   1.0.0
		 */
		do_action( 'integrate_phwa_settings_base_render_before' );

		do_settings_sections( $this->settings_key );

		settings_fields( $this->settings_key );

		if ( ! $this->save_disabled ) {
			submit_button();
		}

		/**
		 * Performs actions after rendering of the settings form.
		 *
		 * @since   1.0.0
		 */
		do_action( 'integrate_phwa_settings_base_render_after' );

	}

	/**
	 * Returns opening .metabox-holder and .postbox container div elements,
	 * used before beginning a section of a settings screen output.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $css_class  Additional CSS Class for metabox-holder.
	 */
	public function get_render_container_start( $css_class = '' ) {

		return '<div class="metabox-holder ' . sanitize_html_class( $css_class ) . '"><div class="postbox">';

	}

	/**
	 * Returns closing .metabox-holder and .postbox container div elements,
	 * used after finishing a section of a settings screen output.
	 *
	 * @since   1.0.0
	 */
	public function get_render_container_end() {

		return '</div><!-- close postbox --></div><!-- close metabox-holder -->';

	}

	/**
	 * Sanitizes the settings prior to being saved.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $settings   Submitted Settings Fields.
	 * @return  array               Sanitized Settings with Defaults
	 */
	public function sanitize_settings( $settings ) {

		// Merge settings with defaults.
		$updated_settings = wp_parse_args( $settings, $this->settings->get_defaults() );

		/**
		 * Performs actions prior to settings being saved.
		 *
		 * @since   1.0.0
		 */
		do_action( 'integrate_phwa_settings_base_sanitize_settings', $this->name, $updated_settings );

		// Return settings to be saved.
		return $updated_settings;

	}

	/**
	 * Prints help info for the general section of the settings screen.
	 *
	 * @since   1.0.0
	 */
	public function print_section_info() {

		// Bail if no description is set.
		if ( empty( $this->description ) ) {
			return;
		}

		?>
		<p class="description"><?php esc_html( $this->description ); ?></p>
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

		// Bail if no documentation URL is set.
		if ( empty( $this->documentation_url ) ) {
			return 'https://www.wpzinc.com/documentation/posthog';
		}

		return $this->documentation_url;

	}

}
