<?php

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

/**
 * Tests the Plugin's WooCommerce Settings screen.
 *
 * @since   1.1.0
 */
class PluginWooCommerceSettingsCest
{
	/**
	 * Run common actions before running the test functions in this class.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function _before(EndToEndTester $I)
	{
		$I->activatePostHogPlugin($I);
	}

	/**
	 * Check that no WooCommerce settings are displayed when WooCommerce is not active.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function testNoSettingsWhenWooCommerceDisabled(EndToEndTester $I)
	{
		// Load settings screen.
		$I->amOnPluginSettingsScreen($I);

		// Confirm no tab to load WooCommerce settings, as the WooCommerce Plugin is not active.
		$I->dontSeeInSource('options-general.php?page=integrate-posthog-web-analytics&tab=woocommerce');
	}

	/**
	 * Check that the WooCommerce Settings screen loads correctly and settings save.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function testSettingsScreen(EndToEndTester $I)
	{
		// Activate WooCommerce.
		$I->activateThirdPartyPlugin($I, 'woocommerce');

		// Load WooCommerce settings screen.
		$I->amOnPluginWooCommerceSettingsScreen($I);

		// Fill settings.
		$I->checkOption('_integrate_phwa_settings_woocommerce[event_view_product]');
		$I->checkOption('_integrate_phwa_settings_woocommerce[event_add_to_cart]');
		$I->checkOption('_integrate_phwa_settings_woocommerce[event_update_cart]');
		$I->checkOption('_integrate_phwa_settings_woocommerce[event_view_cart]');
		$I->checkOption('_integrate_phwa_settings_woocommerce[event_view_checkout]');
		$I->checkOption('_integrate_phwa_settings_woocommerce[event_completed_checkout]');

		// Save settings.
		$I->click('#submit');

		// Check that the settings were saved.
		$I->waitForElementVisible('div.notice-success');
		$I->seeCheckboxIsChecked('_integrate_phwa_settings_woocommerce[event_view_product]', '1');
		$I->seeOptionIsSelected('_integrate_phwa_settings_woocommerce[event_add_to_cart]', '1');
		$I->seeOptionIsSelected('_integrate_phwa_settings_woocommerce[event_update_cart]', '1');
		$I->seeOptionIsSelected('_integrate_phwa_settings_woocommerce[event_view_cart]', '1');
		$I->seeOptionIsSelected('_integrate_phwa_settings_woocommerce[event_view_checkout]', '1');

		// Deactivate WooCommerce.
		$I->deactivateThirdPartyPlugin($I, 'woocommerce');
	}

	/**
	 * Deactivate and reset Plugin(s) after each test, if the test passes.
	 * We don't use _after, as this would provide a screenshot of the Plugin
	 * deactivation and not the true test error.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function _passed(EndToEndTester $I)
	{
		$I->deactivatePostHogPlugin($I);
	}
}
