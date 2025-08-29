=== Integrate PostHog Web Analytics ===
Contributors: wpzinc
Donate link: https://www.wpzinc.com/documentation/posthog
Tags: posthog, analytics
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.1.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Unofficial Plugin to integrate PostHog's web analytics tracking script to your WordPress web site.

== Description ==

Unofficial Plugin to integrate PostHog's web analytics and event tracking on your WordPress web site.  With PostHog, you can:
* Track visitor behavior and engagement across your WordPress site
* Analyze user journeys and conversion funnels
* Monitor key metrics like pageviews, session duration, and bounce rates
* Create custom events to track specific user actions
* View detailed analytics reports and dashboards
* Make data-driven decisions to optimize your site

For those needing to meet GDPR, HIPAA or other privacy requirements, the plugin can be set in a cookieless mode.

[youtube https://www.youtube.com/watch?v=TZnSXIQeSc0]

=== WooCommerce ===

Integrate PostHog Web Analytics can also track WooCommerce product, cart and checkout events:

[youtube https://www.youtube.com/watch?v=IAdhiIM_fmE]

=== External services ===

This plugin stores your PostHog API and Project ID, using them to insert the required JavaScript <script> tag that permits PostHog to collect your web site's analytics in your PostHog account.

Refer to PostHog's [privacy policy](https://posthog.com/privacy) for more information.

= Documentation =

Full Plugin documentation can be found [here](https://www.wpzinc.com/documentation/posthog).

== Installation ==

1. Navigate to `Plugins > Add New Plugin` in WordPress
2. Type `Integrate PostHog Web Analytics` in the Search Plugins search field, and press the Enter key
3. Click `Install Now` beside `Integrate PostHog Web Analytics`
4. Once installed, click `Activate`

== Configuration ==

To configure the Plugin, follow the documentation [here](https://www.wpzinc.com/documentation/posthog).

== Frequently asked questions ==

= Is this GDPR, HIPAA and Privacy Compliant? =

Yes - you'll need to set the `Peristence` setting to `Memory` at `Settings > PostHog Web Analytics`. This will use a cookieless method for data collection,
ensuring GDPR, HIPAA and other privacy compliance.

= Do I need a paid PostHog account? =

No - PostHog's generous free tier will track 1M free events, 5K free session recordings, and more. Every month. Forever.

= Where can I find the Plugin's Documentation? =

Full Plugin documentation can be found [here](https://www.wpzinc.com/documentation/posthog).

= Will this slow down my site? =

No, the plugin is optimized for performance with minimal impact on page load times.

== Screenshots ==

1. General settings

== Changelog ==

### 1.1.2
* Fix: PHP Notice: Function `_load_textdomain_just_in_time` was called incorrectly

### 1.1.1
* Added: Event Tracking: WooCommerce. See Docs: https://www.wpzinc.com/documentation/posthog/woocommerce-integration/

### 1.0.0
* First release

== Upgrade notice ==

