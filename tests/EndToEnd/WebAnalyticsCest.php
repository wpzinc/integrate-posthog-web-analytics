<?php

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

/**
 * Tests the Web Analytics JS tracking.
 *
 * @since   1.1.0
 */
class WebAnalyticsCest
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
	 * Test that no tracking script is present when no API key is set.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function testNoTrackingScriptWhenNoAPIKey(EndToEndTester $I)
	{
		$I->amOnPage('/');
		$I->dontSeeInSource('assets/js/posthog-min.js');
		$I->dontSeeInSource('id="integrate-phwa-js"');
		$I->dontSeeInSource('<script id="integrate-phwa-js-after">');
		$I->dontSeeInSource('posthog.init');
	}

	/**
	 * Test that the tracking script is present when an API key is set.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function testTrackingScriptWhenAPIKey(EndToEndTester $I)
	{
		// Configure the Plugin's general settings.
		$I->configurePluginGeneralSettings($I);

		// Load the page.
		$I->amOnPage('/');

		// Check that the tracking script is present.
		$I->seeInSource('assets/js/posthog-min.js');
		$I->seeInSource('id="integrate-phwa-js"');
		$I->seeInSource('<script id="integrate-phwa-js-after">');
		$I->seeInSource('posthog.init');
		$I->seeInSource($_ENV['POSTHOG_PROJECT_API_KEY']);
	}

	/**
	 * Check that the General Settings screen loads correctly and settings save.
	 *
	 * @since   1.1.0
	 *
	 * @param   EndToEndTester $I  Tester.
	 */
	public function testSettingsScreen(EndToEndTester $I)
	{
		// Load settings screen.
		$I->amOnPluginSettingsScreen($I);

		// Fill settings.
		$I->fillField('_integrate_phwa_settings[project_api_key]', $_ENV['POSTHOG_PROJECT_API_KEY']);
		$I->fillField('_integrate_phwa_settings[project_id]', $_ENV['POSTHOG_PROJECT_ID']);
		$I->selectOption('_integrate_phwa_settings[persistence]', 'Memory');

		// Save settings.
		$I->click('#submit');

		// Check that the settings were saved.
		$I->waitForElementVisible('div.notice-success');
		$I->seeInField('_integrate_phwa_settings[project_api_key]', $_ENV['POSTHOG_PROJECT_API_KEY']);
		$I->seeInField('_integrate_phwa_settings[project_id]', $_ENV['POSTHOG_PROJECT_ID']);
		$I->seeOptionIsSelected('_integrate_phwa_settings[persistence]', 'Memory');
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
