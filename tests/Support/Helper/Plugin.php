<?php
namespace Tests\Support\Helper;

/**
 * Helper methods and actions related to the Plugin that
 * would be used across multiple tests.
 * These are then available using $I->{yourFunctionName}.
 *
 * @since   3.8.4
 */
class Plugin extends \Codeception\Module
{
	/**
	 * Helper method to activate the Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function activatePostHogPlugin($I)
	{
		$I->activateThirdPartyPlugin($I, 'integrate-posthog-web-analytics');
	}

	/**
	 * Helper method to deactivate the Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function deactivatePostHogPlugin($I)
	{
		$I->deactivateThirdPartyPlugin($I, 'integrate-posthog-web-analytics');
	}

	/**
	 * Helper method to activate a third party Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   EndToEndTester $I                       EndToEndTester.
	 * @param   string         $name                    Plugin Slug.
	 * @param   bool           $wizardExpectsToDisplay  Whether the Plugin Setup Wizard is expected to display.
	 */
	public function activateThirdPartyPlugin($I, $name, $wizardExpectsToDisplay = true)
	{
		// Login as the Administrator, if we're not already logged in.
		if ( ! $this->amLoggedInAsAdmin($I) ) {
			$this->doLoginAsAdmin($I);
		}

		// Go to the Plugins screen in the WordPress Administration interface.
		$I->amOnPluginsPage();

		// Wait for the Plugins page to load.
		$I->waitForElementVisible('body.plugins-php');

		// Depending on the Plugin name, perform activation.
		switch ($name) {
			case 'woocommerce':
				// The bulk action to activate won't be available in WordPress 6.5+ due to dependent
				// plugins being installed.
				// See https://core.trac.wordpress.org/ticket/60863.
				$I->click('a#activate-' . $name);
				break;

			default:
				// Activate the Plugin.
				$I->activatePlugin($name);
				break;
		}

		// Go to the Plugins screen again.
		$I->amOnPluginsPage();

		// Wait for the Plugins page to load with the Plugin activated, to confirm it activated.
		$I->waitForElementVisible('table.plugins tr[data-slug=' . $name . '].active');

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);
	}

	/**
	 * Helper method to activate a third party Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   EndToEndTester $I      EndToEnd Tester.
	 * @param   string         $name   Plugin Slug.
	 */
	public function deactivateThirdPartyPlugin($I, $name)
	{
		// Login as the Administrator, if we're not already logged in.
		if ( ! $this->amLoggedInAsAdmin($I) ) {
			$this->doLoginAsAdmin($I);
		}

		// Go to the Plugins screen in the WordPress Administration interface.
		$I->amOnPluginsPage();

		// Wait for the Plugins page to load.
		$I->waitForElementVisible('body.plugins-php');

		// Depending on the Plugin name, perform deactivation.
		switch ($name) {
			case 'woocommerce':
				// The bulk action to deactivate won't be available in WordPress 6.5+ due to dependent
				// plugins being installed.
				// See https://core.trac.wordpress.org/ticket/60863.
				$I->click('a#deactivate-' . $name);
				break;

			default:
				// Deactivate the Plugin.
				$I->deactivatePlugin($name);
				break;
		}
	}

	/**
	 * Helper method to check if the Administrator is logged in.
	 *
	 * @since   5.0.5
	 *
	 * @param   EndToEndTester $I      EndToEnd Tester.
	 *
	 * @return  bool
	 */
	public function amLoggedInAsAdmin($I)
	{
		$cookies = $I->grabCookiesWithPattern('/^wordpress_logged_in_[a-z0-9]{32}$/');
		return ! is_null( $cookies );
	}

	/**
	 * Helper method to reliably login as the Administrator.
	 *
	 * @since   5.0.5
	 *
	 * @param   EndToEndTester $I      EndToEnd Tester.
	 */
	public function doLoginAsAdmin($I)
	{
		// Add admin_email_lifespan option to prevent Administration email verification screen from
		// displaying on login, which causes tests to fail.
		// This is included in the dump.sql file, but seems to be deleted after a test.
		$I->haveOptionInDatabase('admin_email_lifespan', '1805512805');

		// Load login screen.
		$I->amOnPage('wp-login.php');

		// Wait for the login form to load.
		$I->waitForElementVisible('#user_login');
		$I->waitForElementVisible('#user_pass');
		$I->waitForElementVisible('#wp-submit');

		// Fill in the login form.
		$I->click('#user_login');
		$I->fillField('#user_login', $_ENV['WORDPRESS_ADMIN_USER']);
		$I->click('#user_pass');
		$I->fillField('#user_pass', $_ENV['WORDPRESS_ADMIN_PASSWORD']);

		// Submit.
		$I->click('#wp-submit');

		// Wait for the Dashboard page to load, to confirm login succeeded.
		$I->waitForElementVisible('body.index-php');
	}

	/**
	 * Helper method to load the Plugin's Settings screen.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I     EndToEndTester.
	 */
	public function amOnPluginSettingsScreen($I)
	{
		$I->amOnAdminPage('options-general.php?page=integrate-posthog-web-analytics');

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);

		$I->see('General Settings');
	}

	/**
	 * Helper method to load the Plugin's WooCommerceSettings screen.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I     EndToEndTester.
	 */
	public function amOnPluginWooCommerceSettingsScreen($I)
	{
		$I->amOnAdminPage('options-general.php?page=integrate-posthog-web-analytics&tab=woocommerce');

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);

		$I->see('WooCommerce Settings');
	}

	/**
	 * Helper method to configure the Plugin's general settings.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I           EndToEndTester.
	 * @param   string         $apiKey      Project API Key.
	 * @param   string         $projectID   Project ID.
	 * @param   string         $region      Project Region.
	 * @param   string         $persistence Persistence.
	 */
	public function configurePluginGeneralSettings($I, $apiKey = false, $projectID = false, $region = 'us', $persistence = 'localStorage+cookie')
	{
		$I->haveOptionInDatabase(
			'_integrate_phwa_settings',
			array(
				'project_api_key' => $apiKey ? $apiKey : $_ENV['POSTHOG_PROJECT_API_KEY'],
				'project_id'      => $projectID ? $projectID : $_ENV['POSTHOG_PROJECT_ID'],
				'project_region'  => $region,
				'persistence'     => $persistence,
			)
		);
	}

	/**
	 * Helper method to reset the Plugin's settings.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  EndToEndTester.
	 */
	public function resetPostHogPlugin($I)
	{
		$I->dontHaveOptionInDatabase('_integrate_phwa_settings');
		$I->dontHaveOptionInDatabase('_integrate_phwa_settings_woocommerce');
	}
}
