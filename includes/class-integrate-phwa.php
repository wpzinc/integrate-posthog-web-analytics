<?php
/**
 * PostHog class.
 *
 * @package PostHog
 * @author WP Zinc
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PostHog class.
 *
 * @package PostHog
 * @author WP Zinc
 */
class Integrate_PHWA {

	/**
	 * Holds the class object.
	 *
	 * @since   1.0.0
	 *
	 * @var     object
	 */
	private static $instance;

	/**
	 * Holds the plugin information object.
	 *
	 * @since   1.0.0
	 *
	 * @var     object
	 */
	public $plugin;

	/**
	 * Holds the dashboard class object.
	 *
	 * @since   1.0.0
	 *
	 * @var     object
	 */
	public $dashboard;

	/**
	 * Holds singleton initialized classes that include
	 * action and filter hooks.
	 *
	 * @since   1.0.0
	 *
	 * @var     array
	 */
	private $classes = array();

	/**
	 * Constructor. Acts as a bootstrap to load the rest of the plugin
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Plugin Details.
		$this->plugin                    = new stdClass();
		$this->plugin->name              = 'integrate-posthog-web-analytics';
		$this->plugin->displayName       = 'Integrate PostHog Web Analytics';
		$this->plugin->author_name       = 'WP Zinc';
		$this->plugin->version           = INTEGRATE_PHWA_PLUGIN_VERSION;
		$this->plugin->buildDate         = INTEGRATE_PHWA_PLUGIN_BUILD_DATE;
		$this->plugin->folder            = INTEGRATE_PHWA_PLUGIN_PATH;
		$this->plugin->url               = INTEGRATE_PHWA_PLUGIN_URL;
		$this->plugin->documentation_url = 'https://www.wpzinc.com/documentation/posthog';
		$this->plugin->support_url       = 'https://www.wpzinc.com/support';
		$this->plugin->logo              = INTEGRATE_PHWA_PLUGIN_URL . 'assets/images/icons/logo.svg';
		$this->plugin->review_name       = 'integrate-posthog-web-analytics';
		$this->plugin->review_notice     = 'Thanks for using Integrate PostHog Web Analytics to track your web analytics!';

		// Dashboard Submodule.
		if ( ! class_exists( 'WPZincDashboardWidget' ) ) {
			require_once $this->plugin->folder . '_modules/dashboard/class-wpzincdashboardwidget.php';
		}
		$this->dashboard = new WPZincDashboardWidget( $this->plugin );

		// Defer loading of Plugin Classes.
		add_action( 'init', array( $this, 'initialize' ), 1 );

		// Admin Menus.
		add_action( 'integrate_phwa_admin_settings_add_settings_page', array( $this, 'admin_menu' ) );

	}

	/**
	 * Register menus and submenus.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $minimum_capability  Minimum capability required for access.
	 */
	public function admin_menu( $minimum_capability ) {

		add_options_page(
			__( 'Integrate PostHog Web Analytics', 'integrate-posthog-web-analytics' ),
			__( 'Integrate PostHog Web Analytics', 'integrate-posthog-web-analytics' ),
			$minimum_capability,
			$this->plugin->name,
			array( $this->classes['admin_settings'], 'display_settings_page' )
		);

	}

	/**
	 * Initializes required classes
	 *
	 * @since   1.0.0
	 */
	public function initialize() {

		$this->initialize_admin();
		$this->initialize_global();

	}

	/**
	 * Initialize classes for the WordPress Administration interface
	 *
	 * @since   1.0.0
	 */
	private function initialize_admin() {

		// Bail if this request isn't for the WordPress Administration interface.
		if ( ! is_admin() ) {
			return;
		}

		$this->classes['admin_settings'] = new Integrate_PHWA_Admin_Settings();

		/**
		 * Initialize integration classes for the WordPress Administration interface.
		 *
		 * @since   1.0.0
		 */
		do_action( 'integrate_phwa_initialize_admin' );

	}

	/**
	 * Initialize classes required globally, across the WordPress Administration, CLI, Cron and Frontend
	 * web site.
	 *
	 * @since   1.0.0
	 */
	private function initialize_global() {

		$this->classes['output'] = new Integrate_PHWA_Output();

		/**
		 * Initialize integration classes for the frontend web site.
		 *
		 * @since   1.0.0
		 */
		do_action( 'integrate_phwa_initialize_global' );

	}

	/**
	 * Returns the given class
	 *
	 * @since   1.0.0
	 *
	 * @param   string $name   Class Name.
	 * @return  object          Class Object
	 */
	public function get_class( $name ) {

		// If the class hasn't been loaded, throw a WordPress die screen
		// to avoid a PHP fatal error.
		if ( ! isset( $this->classes[ $name ] ) ) {
			// Define the error.
			$error = new WP_Error(
				'Integrate_PHWA_get_class',
				sprintf(
					/* translators: %1$s: PHP class name */
					__( 'Integrate PostHog Web Analytics Error: Could not load Plugin class <strong>%1$s</strong>', 'integrate-posthog-web-analytics' ),
					$name
				)
			);

			// Depending on the request, return or display an error.
			// Admin UI.
			if ( is_admin() ) {
				wp_die(
					esc_attr( $error->get_error_message() ),
					esc_html__( 'Integrate PostHog Web Analytics Error', 'integrate-posthog-web-analytics' ),
					array(
						'back_link' => true,
					)
				);
			}

			// Cron / CLI.
			return $error;
		}

		// Return the class object.
		return $this->classes[ $name ];

	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @since   1.0.0
	 *
	 * @return  object Class.
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

}
