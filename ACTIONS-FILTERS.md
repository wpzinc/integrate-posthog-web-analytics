<h1>Filters</h1><table>
				<thead>
					<tr>
						<th>File</th>
						<th>Filter Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><tr>
						<td colspan="3">../includes/admin/class-posthog-admin-section-general.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_admin_section_general_sections"><code>posthog_admin_section_general_sections</code></a></td>
						<td>Define settings sections for the General screen.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_admin_section_general_register_fields"><code>posthog_admin_section_general_register_fields</code></a></td>
						<td>Register settings fields for the general settings screen.</td>
					</tr><tr>
						<td colspan="3">../includes/admin/class-posthog-admin-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_admin_settings_minimum_capability"><code>posthog_admin_settings_minimum_capability</code></a></td>
						<td>Defines the minimum capability required to access the Plugin's Menu and Sub Menus</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_plugin_screen_action_links"><code>posthog_plugin_screen_action_links</code></a></td>
						<td>Define links to display below the Plugin Name on the WP_List_Table at Plugins > Installed Plugins.</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_admin_settings_register_sections"><code>posthog_admin_settings_register_sections</code></a></td>
						<td>Registers settings sections.</td>
					</tr><tr>
						<td colspan="3">../includes/global/class-posthog-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_settings_get_defaults"><code>posthog_settings_get_defaults</code></a></td>
						<td>The default Plugin settings.</td>
					</tr>
					</tbody>
				</table><h3 id="posthog_admin_section_general_sections">
						posthog_admin_section_general_sections
						<code>includes/admin/class-posthog-admin-section-general.php::56</code>
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
add_filter( 'posthog_admin_section_general_sections', function( $settings_sections ) {
	// ... your code here
	// Return value
	return $settings_sections;
}, 10, 1 );
</pre>
<h3 id="posthog_admin_section_general_register_fields">
						posthog_admin_section_general_register_fields
						<code>includes/admin/class-posthog-admin-section-general.php::141</code>
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
							<td>PostHog_Settings</td>
							<td>Settings class.</td>
						</tr>
						</tbody>
					</table><h4>Usage</h4>
<pre>
add_filter( 'posthog_admin_section_general_register_fields', function( $fields, $settings ) {
	// ... your code here
	// Return value
	return $fields;
}, 10, 2 );
</pre>
<h3 id="posthog_admin_settings_minimum_capability">
						posthog_admin_settings_minimum_capability
						<code>includes/admin/class-posthog-admin-settings.php::68</code>
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
add_filter( 'posthog_admin_settings_minimum_capability', function( $minimum_capability ) {
	// ... your code here
	// Return value
	return $minimum_capability;
}, 10, 1 );
</pre>
<h3 id="posthog_plugin_screen_action_links">
						posthog_plugin_screen_action_links
						<code>includes/admin/class-posthog-admin-settings.php::189</code>
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
add_filter( 'posthog_plugin_screen_action_links', function( $links ) {
	// ... your code here
	// Return value
	return $links;
}, 10, 1 );
</pre>
<h3 id="posthog_admin_settings_register_sections">
						posthog_admin_settings_register_sections
						<code>includes/admin/class-posthog-admin-settings.php::251</code>
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
add_filter( 'posthog_admin_settings_register_sections', function( $sections ) {
	// ... your code here
	// Return value
	return $sections;
}, 10, 1 );
</pre>
<h3 id="posthog_settings_get_defaults">
						posthog_settings_get_defaults
						<code>includes/global/class-posthog-settings.php::114</code>
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
add_filter( 'posthog_settings_get_defaults', function( $defaults ) {
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
						<td colspan="3">../includes/traits/trait-posthog-admin-section.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_settings_base_render_before"><code>posthog_settings_base_render_before</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_settings_base_render_after"><code>posthog_settings_base_render_after</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_settings_base_sanitize_settings"><code>posthog_settings_base_sanitize_settings</code></a></td>
						<td></td>
					</tr><tr>
						<td colspan="3">../includes/admin/class-posthog-admin-settings.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_admin_settings_add_settings_page"><code>posthog_admin_settings_add_settings_page</code></a></td>
						<td>Add settings menus and sub menus for the Plugin's settings.</td>
					</tr><tr>
						<td colspan="3">../includes/class-posthog.php</td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_initialize_admin"><code>posthog_initialize_admin</code></a></td>
						<td></td>
					</tr><tr>
						<td>&nbsp;</td>
						<td><a href="#posthog_initialize_global"><code>posthog_initialize_global</code></a></td>
						<td></td>
					</tr>
					</tbody>
				</table><h3 id="posthog_settings_base_render_before">
						posthog_settings_base_render_before
						<code>includes/traits/trait-posthog-admin-section.php::162</code>
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
add_action( 'posthog_settings_base_render_before', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="posthog_settings_base_render_after">
						posthog_settings_base_render_after
						<code>includes/traits/trait-posthog-admin-section.php::177</code>
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
add_action( 'posthog_settings_base_render_after', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="posthog_settings_base_sanitize_settings">
						posthog_settings_base_sanitize_settings
						<code>includes/traits/trait-posthog-admin-section.php::225</code>
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
add_action( 'posthog_settings_base_sanitize_settings', function( $name, $updated_settings ) {
	// ... your code here
}, 10, 2 );
</pre>
<h3 id="posthog_admin_settings_add_settings_page">
						posthog_admin_settings_add_settings_page
						<code>includes/admin/class-posthog-admin-settings.php::77</code>
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
add_action( 'posthog_admin_settings_add_settings_page', function( $minimum_capability ) {
	// ... your code here
}, 10, 1 );
</pre>
<h3 id="posthog_initialize_admin">
						posthog_initialize_admin
						<code>includes/class-posthog.php::143</code>
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
add_action( 'posthog_initialize_admin', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
<h3 id="posthog_initialize_global">
						posthog_initialize_global
						<code>includes/class-posthog.php::162</code>
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
add_action( 'posthog_initialize_global', function(  ) {
	// ... your code here
}, 10, 0 );
</pre>
