<h1>Filters</h1><table>
				<thead>
					<tr>
						<th>File</th>
						<th>Filter Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><tr>
						<td colspan="3">../includes/admin/class-fomo-notifications-admin-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_settings_minimum_capability"><code>fomo_notifications_admin_settings_minimum_capability</code></a></td>
						<td>Defines the minimum capability required to access the Plugin's Menu and Sub Menus</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_plugin_screen_action_links"><code>fomo_notifications_plugin_screen_action_links</code></a></td>
						<td>Define links to display below the Plugin Name on the WP_List_Table at Plugins > Installed Plugins.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_settings_register_sections"><code>fomo_notifications_admin_settings_register_sections</code></a></td>
						<td>Registers settings sections.</td>
					</tr><tr>
						<td colspan="3">../includes/admin/class-fomo-notifications-admin-section-general.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_section_general_sections"><code>fomo_notifications_admin_section_general_sections</code></a></td>
						<td>Define settings sections for the General screen.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_section_general_register_fields"><code>fomo_notifications_admin_section_general_register_fields</code></a></td>
						<td>Register settings fields for the general settings screen.</td>
					</tr><tr>
						<td colspan="3">../includes/admin/class-fomo-notifications-admin-notification-ui.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_notification_ui_get_sources"><code>fomo_notifications_admin_notification_ui_get_sources</code></a></td>
						<td>Define the available notification sources.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_notification_ui_get_display_fields"><code>fomo_notifications_admin_notification_ui_get_display_fields</code></a></td>
						<td>Define the available settings fields for the display section</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_notification_ui_get_conditions_fields"><code>fomo_notifications_admin_notification_ui_get_conditions_fields</code></a></td>
						<td>Define the available settings fields for the conditions section</td>
					</tr><tr>
						<td colspan="3">../includes/global/class-fomo-notifications-notifications.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_notifications_get_all"><code>fomo_notifications_notifications_get_all</code></a></td>
						<td>Filters the Notifications to return.</td>
					</tr><tr>
						<td colspan="3">../includes/global/class-fomo-notifications-output.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_output_get_notifications_conditions_met"><code>fomo_notifications_output_get_notifications_conditions_met</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_output_get_notifications_conditions_met_  source"><code>fomo_notifications_output_get_notifications_conditions_met_  source</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_output_get_notifications_items_  source"><code>fomo_notifications_output_get_notifications_items_  source</code></a></td>
						<td>Define the items to output for this notification.</td>
					</tr><tr>
						<td colspan="3">../includes/global/class-fomo-notifications-notification-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_notification_settings_get_defaults"><code>fomo_notifications_notification_settings_get_defaults</code></a></td>
						<td>The default Plugin settings.</td>
					</tr><tr>
						<td colspan="3">../includes/global/class-fomo-notifications-plugin-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_plugin_settings_get_defaults"><code>fomo_notifications_plugin_settings_get_defaults</code></a></td>
						<td>The default Plugin settings.</td>
					</tr>
					</tbody>
				</table><h3 id="fomo_notifications_admin_settings_minimum_capability">
						fomo_notifications_admin_settings_minimum_capability
						<code>includes/admin/class-fomo-notifications-admin-settings.php::129</code>
					</h3><h4>Overview</h4>
						<p>Defines the minimum capability required to access the Plugin's Menu and Sub Menus</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$capability</td>
							<td>string</td>
							<td>Minimum Required Capability.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_settings_minimum_capability', function( $minimum_capability ) {
	// ... your code here
	// Return value
	return $minimum_capability;
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_plugin_screen_action_links">
						fomo_notifications_plugin_screen_action_links
						<code>includes/admin/class-fomo-notifications-admin-settings.php::250</code>
					</h3><h4>Overview</h4>
						<p>Define links to display below the Plugin Name on the WP_List_Table at Plugins > Installed Plugins.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$links</td>
							<td>array</td>
							<td>HTML Links.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_plugin_screen_action_links', function( $links ) {
	// ... your code here
	// Return value
	return $links;
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_admin_settings_register_sections">
						fomo_notifications_admin_settings_register_sections
						<code>includes/admin/class-fomo-notifications-admin-settings.php::312</code>
					</h3><h4>Overview</h4>
						<p>Registers settings sections.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$sections</td>
							<td>array</td>
							<td>Array of settings classes that handle individual tabs e.g. General, Tools etc.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_settings_register_sections', function( $sections ) {
	// ... your code here
	// Return value
	return $sections;
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_admin_section_general_sections">
						fomo_notifications_admin_section_general_sections
						<code>includes/admin/class-fomo-notifications-admin-section-general.php::56</code>
					</h3><h4>Overview</h4>
						<p>Define settings sections for the General screen.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$settings_sections</td>
							<td>array</td>
							<td>Settings sections.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_section_general_sections', function( $settings_sections ) {
	// ... your code here
	// Return value
	return $settings_sections;
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_admin_section_general_register_fields">
						fomo_notifications_admin_section_general_register_fields
						<code>includes/admin/class-fomo-notifications-admin-section-general.php::119</code>
					</h3><h4>Overview</h4>
						<p>Register settings fields for the general settings screen.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$fields</td>
							<td>array</td>
							<td>Fields.</td>
						</tr><tr>
							<td>$settings</td>
							<td>Fomo_Notifications_Settings</td>
							<td>Settings class.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_section_general_register_fields', function( $fields, $settings ) {
	// ... your code here
	// Return value
	return $fields;
}, 10, 2 );
</pre>
<h3 id="fomo_notifications_admin_notification_ui_get_sources">
						fomo_notifications_admin_notification_ui_get_sources
						<code>includes/admin/class-fomo-notifications-admin-notification-ui.php::126</code>
					</h3><h4>Overview</h4>
						<p>Define the available notification sources.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$sources</td>
							<td>array</td>
							<td>Sources.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_notification_ui_get_sources', function( array( ) {
	// ... your code here
	// Return value
	return array(;
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_admin_notification_ui_get_display_fields">
						fomo_notifications_admin_notification_ui_get_display_fields
						<code>includes/admin/class-fomo-notifications-admin-notification-ui.php::151</code>
					</h3><h4>Overview</h4>
						<p>Define the available settings fields for the display section</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$display_fields</td>
							<td>array</td>
							<td>Fields.</td>
						</tr><tr>
							<td>$settings</td>
							<td>Fomo_Notifications_Notification_Settings</td>
							<td>Settings instance for this notification.</td>
						</tr><tr>
							<td>$post_id</td>
							<td>int</td>
							<td>Notification ID.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_notification_ui_get_display_fields', function( $display_fields, $settings, $post->ID ) {
	// ... your code here
	// Return value
	return $display_fields;
}, 10, 3 );
</pre>
<h3 id="fomo_notifications_admin_notification_ui_get_conditions_fields">
						fomo_notifications_admin_notification_ui_get_conditions_fields
						<code>includes/admin/class-fomo-notifications-admin-notification-ui.php::165</code>
					</h3><h4>Overview</h4>
						<p>Define the available settings fields for the conditions section</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$conditions_fields</td>
							<td>array</td>
							<td>Fields.</td>
						</tr><tr>
							<td>$settings</td>
							<td>Fomo_Notifications_Notification_Settings</td>
							<td>Settings instance for this notification.</td>
						</tr><tr>
							<td>$post_id</td>
							<td>int</td>
							<td>Notification ID.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_admin_notification_ui_get_conditions_fields', function( $conditions_fields, $settings, $post->ID ) {
	// ... your code here
	// Return value
	return $conditions_fields;
}, 10, 3 );
</pre>
<h3 id="fomo_notifications_notifications_get_all">
						fomo_notifications_notifications_get_all
						<code>includes/global/class-fomo-notifications-notifications.php::73</code>
					</h3><h4>Overview</h4>
						<p>Filters the Notifications to return.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$notifications_arr</td>
							<td>array</td>
							<td>Notifications.</td>
						</tr><tr>
							<td>$notifications</td>
							<td>WP_Query</td>
							<td>Notifications Query.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_notifications_get_all', function( $notifications_arr, $notifications ) {
	// ... your code here
	// Return value
	return $notifications_arr;
}, 10, 2 );
</pre>
<h3 id="fomo_notifications_output_get_notifications_conditions_met">
						fomo_notifications_output_get_notifications_conditions_met
						<code>includes/global/class-fomo-notifications-output.php::111</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$conditions_met</td>
							<td>Unknown</td>
							<td>N/A</td>
						</tr><tr>
							<td>$settings</td>
							<td>Unknown</td>
							<td>N/A</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_output_get_notifications_conditions_met', function( $conditions_met, $settings ) {
	// ... your code here
	// Return value
	return $conditions_met;
}, 10, 2 );
</pre>
<h3 id="fomo_notifications_output_get_notifications_conditions_met_  source">
						fomo_notifications_output_get_notifications_conditions_met_  source
						<code>includes/global/class-fomo-notifications-output.php::119</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$conditions_met</td>
							<td>Unknown</td>
							<td>N/A</td>
						</tr><tr>
							<td>$settings</td>
							<td>Unknown</td>
							<td>N/A</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_output_get_notifications_conditions_met_  source', function( $conditions_met, $settings ) {
	// ... your code here
	// Return value
	return $conditions_met;
}, 10, 2 );
</pre>
<h3 id="fomo_notifications_output_get_notifications_items_  source">
						fomo_notifications_output_get_notifications_items_  source
						<code>includes/global/class-fomo-notifications-output.php::133</code>
					</h3><h4>Overview</h4>
						<p>Define the items to output for this notification.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$items</td>
							<td>array</td>
							<td>Items to display in this notification.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_output_get_notifications_items_  source', function( $items, $settings ) {
	// ... your code here
	// Return value
	return $items;
}, 10, 2 );
</pre>
<h3 id="fomo_notifications_notification_settings_get_defaults">
						fomo_notifications_notification_settings_get_defaults
						<code>includes/global/class-fomo-notifications-notification-settings.php::119</code>
					</h3><h4>Overview</h4>
						<p>The default Plugin settings.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$defaults</td>
							<td>array</td>
							<td>Default Settings.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_notification_settings_get_defaults', function( $defaults ) {
	// ... your code here
	// Return value
	return $defaults;
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_plugin_settings_get_defaults">
						fomo_notifications_plugin_settings_get_defaults
						<code>includes/global/class-fomo-notifications-plugin-settings.php::114</code>
					</h3><h4>Overview</h4>
						<p>The default Plugin settings.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$defaults</td>
							<td>array</td>
							<td>Default Settings.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'fomo_notifications_plugin_settings_get_defaults', function( $defaults ) {
	// ... your code here
	// Return value
	return $defaults;
}, 10, 1 );
</pre>
<h1>Actions</h1><table>
				<thead>
					<tr>
						<th>File</th>
						<th>Filter Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><tr>
						<td colspan="3">../includes/traits/trait-fomo-notifications-admin-section.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_settings_base_render_before"><code>fomo_notifications_settings_base_render_before</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_settings_base_render_after"><code>fomo_notifications_settings_base_render_after</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_settings_base_sanitize_settings"><code>fomo_notifications_settings_base_sanitize_settings</code></a></td>
						<td></td>
					</tr><tr>
						<td colspan="3">../includes/admin/class-fomo-notifications-admin-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_settings_enqueue_scripts"><code>fomo_notifications_admin_settings_enqueue_scripts</code></a></td>
						<td>Enqueue JavaScript for the Settings Screen.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_settings_enqueue_styles"><code>fomo_notifications_admin_settings_enqueue_styles</code></a></td>
						<td>Enqueue CSS for the Settings Screen.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_admin_settings_add_settings_page"><code>fomo_notifications_admin_settings_add_settings_page</code></a></td>
						<td>Add settings menus and sub menus for the Plugin's settings.</td>
					</tr><tr>
						<td colspan="3">../includes/class-fomo-notifications.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_initialize_admin"><code>fomo_notifications_initialize_admin</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#fomo_notifications_initialize_global"><code>fomo_notifications_initialize_global</code></a></td>
						<td></td>
					</tr>
					</tbody>
				</table><h3 id="fomo_notifications_settings_base_render_before">
						fomo_notifications_settings_base_render_before
						<code>includes/traits/trait-fomo-notifications-admin-section.php::162</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_settings_base_render_before', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="fomo_notifications_settings_base_render_after">
						fomo_notifications_settings_base_render_after
						<code>includes/traits/trait-fomo-notifications-admin-section.php::177</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_settings_base_render_after', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="fomo_notifications_settings_base_sanitize_settings">
						fomo_notifications_settings_base_sanitize_settings
						<code>includes/traits/trait-fomo-notifications-admin-section.php::225</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$name</td>
							<td>Unknown</td>
							<td>N/A</td>
						</tr><tr>
							<td>$updated_settings</td>
							<td>Unknown</td>
							<td>N/A</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_settings_base_sanitize_settings', function( $name, $updated_settings ) {
	// ... your code here
}, 10, 2 );
</pre>
<h3 id="fomo_notifications_admin_settings_enqueue_scripts">
						fomo_notifications_admin_settings_enqueue_scripts
						<code>includes/admin/class-fomo-notifications-admin-settings.php::75</code>
					</h3><h4>Overview</h4>
						<p>Enqueue JavaScript for the Settings Screen.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$section</td>
							<td>string</td>
							<td>Settings section / tab.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_admin_settings_enqueue_scripts', function( $section ) {
	// ... your code here
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_admin_settings_enqueue_styles">
						fomo_notifications_admin_settings_enqueue_styles
						<code>includes/admin/class-fomo-notifications-admin-settings.php::106</code>
					</h3><h4>Overview</h4>
						<p>Enqueue CSS for the Settings Screen.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$section</td>
							<td>string</td>
							<td>Settings section / tab.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_admin_settings_enqueue_styles', function( $section ) {
	// ... your code here
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_admin_settings_add_settings_page">
						fomo_notifications_admin_settings_add_settings_page
						<code>includes/admin/class-fomo-notifications-admin-settings.php::138</code>
					</h3><h4>Overview</h4>
						<p>Add settings menus and sub menus for the Plugin's settings.</p><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody><tr>
							<td>$minimum_capability</td>
							<td>string</td>
							<td>Minimum capability required.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_admin_settings_add_settings_page', function( $minimum_capability ) {
	// ... your code here
}, 10, 1 );
</pre>
<h3 id="fomo_notifications_initialize_admin">
						fomo_notifications_initialize_admin
						<code>includes/class-fomo-notifications.php::162</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_initialize_admin', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="fomo_notifications_initialize_global">
						fomo_notifications_initialize_global
						<code>includes/class-fomo-notifications.php::184</code>
					</h3><h4>Parameters</h4>
					<table>
						<thead>
							<tr>
								<th>Parameter</th>
								<th>Type</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_action( 'fomo_notifications_initialize_global', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
