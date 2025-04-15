<?php

namespace Tests\EndToEnd;

use Tests\Support\EndToEndTester;

/**
 * Tests the Plugin's General Settings screen.
 *
 * @since   1.1.0
 */
class PluginGeneralSettingsCest
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
