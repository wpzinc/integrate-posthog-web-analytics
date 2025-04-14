<?php
/**
 * Integrate PostHog Web Analytics Web Analytics WordPress Plugin
 *
 * @package PostHog
 * @author WP Zinc
 *
 * @wordpress-plugin
 * Plugin Name: Integrate PostHog Web Analytics
 * Plugin URI: http://www.wpzinc.com/documentation/posthog
 * Version: 1.0.0
 * Author: WP Zinc
 * Author URI: http://www.wpzinc.com
 * Description: Unofficial Plugin to integrate PostHog's web analytics tracking script to your WordPress web site.
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: integrate-posthog-web-analytics
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
define( 'INTEGRATE_PHWA_PLUGIN_VERSION', '1.0.0' );
define( 'INTEGRATE_PHWA_PLUGIN_BUILD_DATE', '2025-03-26 18:00:00' );

// Define Plugin paths.
define( 'INTEGRATE_PHWA_PLUGIN_FILE', plugin_basename( __FILE__ ) );
define( 'INTEGRATE_PHWA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'INTEGRATE_PHWA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Traits.
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/traits/trait-integrate-phwa-admin-section.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/traits/trait-integrate-phwa-admin-section-fields.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/traits/trait-integrate-phwa-api.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/traits/trait-integrate-phwa-settings.php';

// Admin.
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/admin/class-integrate-phwa-admin-section-general.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/admin/class-integrate-phwa-admin-settings.php';

// Global.
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/global/class-integrate-phwa-output.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/global/class-integrate-phwa-settings.php';

// Integrations: WooCommerce.
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/integrations/woocommerce/class-integrate-phwa-admin-section-woocommerce.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/integrations/woocommerce/class-integrate-phwa-settings-woocommerce.php';
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/integrations/woocommerce/class-integrate-phwa-woocommerce.php';

// Bootstrap.
require_once INTEGRATE_PHWA_PLUGIN_PATH . 'includes/class-integrate-phwa.php';

/**
 * Main function to return Plugin instance.
 *
 * @since   1.0.0
 */
function integrate_phwa() {

	return Integrate_PHWA::get_instance();

}

// Finally, initialize the Plugin.
integrate_phwa();
