<?php
/**
 * PostHog WordPress Plugin
 *
 * @package PostHog
 * @author WP Zinc
 *
 * @wordpress-plugin
 * Plugin Name: PostHog
 * Plugin URI: http://www.wpzinc.com/documentation/posthog
 * Version: 1.0.0
 * Author: WP Zinc
 * Author URI: http://www.wpzinc.com
 * Description: Web analytics using PostHog
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: posthog
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Plugin is already loaded.
if ( class_exists( 'PostHog' ) ) {
	return;
}
if ( defined( 'POSTHOG_PLUGIN_VERSION' ) ) {
	return;
}

// Define Plugin version and build date.
define( 'POSTHOG_PLUGIN_VERSION', '1.0.0' );
define( 'POSTHOG_PLUGIN_BUILD_DATE', '2025-03-26 18:00:00' );

// Define Plugin paths.
define( 'POSTHOG_PLUGIN_FILE', plugin_basename( __FILE__ ) );
define( 'POSTHOG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'POSTHOG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Traits.
require_once POSTHOG_PLUGIN_PATH . 'includes/traits/trait-posthog-admin-section.php';
require_once POSTHOG_PLUGIN_PATH . 'includes/traits/trait-posthog-admin-section-fields.php';
require_once POSTHOG_PLUGIN_PATH . 'includes/traits/trait-posthog-settings.php';

// Admin.
require_once POSTHOG_PLUGIN_PATH . 'includes/admin/class-posthog-admin-section-general.php';
require_once POSTHOG_PLUGIN_PATH . 'includes/admin/class-posthog-admin-settings.php';

// Global.
require_once POSTHOG_PLUGIN_PATH . 'includes/global/class-posthog-output.php';
require_once POSTHOG_PLUGIN_PATH . 'includes/global/class-posthog-settings.php';

// Bootstrap.
require_once POSTHOG_PLUGIN_PATH . 'includes/class-posthog.php';

/**
 * Main function to return Plugin instance.
 *
 * @since   1.0.0
 */
function posthog() {

	return PostHog::get_instance();

}

// Finally, initialize the Plugin.
posthog();
