<?php
/**
 * Provides common functionality, styling and views for Plugins.
 *
 * Historically named dashboard, as it used to provide a widget
 * on the WordPress Admin Dashboard.
 *
 * @package WPZincDashboardWidget
 * @author WP Zinc
 */

/**
 * Provides common functionality, styling and views for Plugins.
 *
 * Historically named dashboard, as it used to provide a widget
 * on the WordPress Admin Dashboard.
 */
class WPZincDashboardWidget {

	/**
	 * Holds the plugin object
	 *
	 * @since   1.0.0
	 *
	 * @var     object
	 */
	public $plugin;

	/**
	 * Holds the exact path to this file's folder
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	public $dashboard_folder;

	/**
	 * Holds the exact URL to this file's folder
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	public $dashboard_url;

	/**
	 * Constructor
	 *
	 * @since   1.0.0
	 *
	 * @param   object $plugin    WordPress Plugin.
	 */
	public function __construct( $plugin ) {

		// Plugin Details.
		$this->plugin = $plugin;

		// Set class vars.
		$this->dashboard_folder = plugin_dir_path( __FILE__ );
		$this->dashboard_url    = plugin_dir_url( __FILE__ );

		// Admin CSS, JS and Menu.
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts_css' ) );

	}

	/**
	 * Adds the WP Zinc CSS class to the <body> tag when we're in the WordPress Admin interface
	 * and viewing a Plugin Screen
	 *
	 * This allows us to then override some WordPress layout styling on e.g. #wpcontent, without
	 * affecting other screens, Plugins etc.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $classes    CSS Classes.
	 * @return  string               CSS Classes
	 */
	public function admin_body_class( $classes ) {

		// Define a list of strings that determine whether we're viewing a Plugin Screen.
		$screens = array(
			$this->plugin->name,
		);

		/**
		 * Filter the body classes to output on the <body> tag.
		 *
		 * @since   1.0.0
		 *
		 * @param   array   $screens        Screens.
		 * @param   array   $classes        Classes.
		 */
		$screens = apply_filters( 'wpzinc_admin_body_class', $screens, $classes );

		// Determine whether we're on a Plugin Screen.
		$is_plugin_screen = $this->is_plugin_screen( $screens );

		// Bail if we're not a Plugin screen.
		if ( ! $is_plugin_screen ) {
			return $classes;
		}

		// Add the wpzinc class and plugin name.
		$classes .= ' wpzinc ' . $this->plugin->name;

		// Return.
		return trim( $classes );

	}

	/**
	 * Determines whether we're viewing this Plugin's screen in the WordPress Administration
	 * interface.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $screens    Screens.
	 * @return  bool                Is Plugin Screen
	 */
	private function is_plugin_screen( $screens ) {

		// Bail if the current screen can't be obtained.
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		// Bail if no screen names were specified to search for.
		if ( empty( $screens ) || count( $screens ) === 0 ) {
			return false;
		}

		// Get screen.
		$screen = get_current_screen();

		foreach ( $screens as $screen_name ) {
			if ( strpos( $screen->id, $screen_name ) === false ) {
				continue;
			}

			// We're on a Plugin Screen.
			return true;
		}

		// If here, we're not on a Plugin Screen.
		return false;

	}

	/**
	 * Register JS scripts, which Plugins may optionally load via wp_enqueue_script()
	 * Enqueues CSS
	 *
	 * @since   1.0.0
	 */
	public function admin_scripts_css() {

		// JS.
		wp_register_script( 'wpzinc-admin-tabs', $this->dashboard_url . 'js/tabs.js', array( 'jquery' ), $this->plugin->version, true );

		// CSS.
		wp_enqueue_style( 'wpzinc-admin', $this->dashboard_url . 'css/admin.css', false, $this->plugin->version );

	}

}
