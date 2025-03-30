<?php
/**
 * Outputs a setting field.
 *
 * @package PostHog
 * @author WP Zinc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

switch ( $field['type'] ) {
	/**
	 * Text
	 */
	case 'text':
		?>
		<input type="text" 
				id="<?php echo esc_attr( $field_name ); ?>"
				name="<?php echo esc_attr( $settings::SETTINGS_NAME ); ?>[<?php echo esc_attr( $field_name ); ?>]"
				value="<?php echo esc_attr( isset( $field['value'] ) ? $field['value'] : '' ); ?>" 
				placeholder="<?php echo esc_attr( ( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ) ); ?>"
				class="widefat <?php echo esc_attr( ( isset( $field['class'] ) ? $field['class'] : '' ) ); ?>" />
		<?php
		break;

	/**
	 * Textarea
	 */
	case 'textarea':
		?>
		<textarea 
				id="<?php echo esc_attr( $field_name ); ?>"
				name="<?php echo esc_attr( $settings::SETTINGS_NAME ); ?>[<?php echo esc_attr( $field_name ); ?>]"
				placeholder="<?php echo esc_attr( ( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ) ); ?>"
				class="widefat <?php echo esc_attr( ( isset( $field['class'] ) ? $field['class'] : '' ) ); ?>"><?php echo esc_attr( isset( $field['value'] ) ? $field['value'] : '' ); ?></textarea>
		<?php
		break;

	/**
	 * Number
	 */
	case 'number':
		?>
		<input type="number" 
				id="<?php echo esc_attr( $field_name ); ?>"
				name="<?php echo esc_attr( $settings::SETTINGS_NAME ); ?>[<?php echo esc_attr( $field_name ); ?>]" 
				value="<?php echo esc_attr( isset( $field['value'] ) ? $field['value'] : '' ); ?>" 
				min="<?php echo esc_attr( $field['min'] ); ?>" 
				max="<?php echo esc_attr( $field['max'] ); ?>" 
				step="<?php echo esc_attr( $field['step'] ); ?>"
				class="widefat <?php echo esc_attr( ( isset( $field['class'] ) ? $field['class'] : '' ) ); ?>" />
		<?php
		break;

	/**
	 * Select
	 */
	case 'select':
		?>
		<select name="<?php echo esc_attr( $settings::SETTINGS_NAME ); ?>[<?php echo esc_attr( $field_name ); ?>]"
				id="<?php echo esc_attr( $field_name ); ?>"
				size="1"
				class="widefat <?php echo esc_attr( ( isset( $field['class'] ) ? $field['class'] : '' ) ); ?>">
			<?php
			$field['value'] = ( isset( $field['value'] ) ? $field['value'] : '' );
			foreach ( $field['options'] as $value => $label ) {
				?>
				<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $field['value'], $value ); ?>>
					<?php echo esc_attr( $label ); ?>
				</option>
				<?php
			}
			?>
		</select>
		<?php
		break;

	/**
	 * Multiple Select
	 */
	case 'select_multiple':
		?>
		<select name="<?php echo esc_attr( $settings::SETTINGS_NAME ); ?>[<?php echo esc_attr( $field_name ); ?>][]"
				id="<?php echo esc_attr( $field_name ); ?>"
				size="10"
				multiple="multiple"
				class="widefat <?php echo esc_attr( ( isset( $field['class'] ) ? $field['class'] : '' ) ); ?>">
			<?php
			$field['value'] = ( isset( $field['value'] ) ? $field['value'] : '' );
			if ( isset( $field['options'] ) && is_array( $field['options'] ) && count( $field['options'] ) > 0 ) {
				foreach ( $field['options'] as $value => $label ) {
					?>
					<option value="<?php echo esc_attr( $value ); ?>"<?php echo esc_attr( in_array( $value, (array) $field['value'], true ) ? ' selected' : '' ); ?>>
						<?php echo esc_attr( $label ); ?>
					</option>
					<?php
				}
			}
			?>
		</select>
		<?php
		break;

	/**
	 * Toggle
	 */
	case 'toggle':
		?>
		<select name="<?php echo esc_attr( $settings::SETTINGS_NAME ); ?>[<?php echo esc_attr( $field_name ); ?>]"
				id="<?php echo esc_attr( $field_name ); ?>"
				size="1"
				class="widefat <?php echo esc_attr( ( isset( $field['class'] ) ? $field['class'] : '' ) ); ?>">
			<?php
			$field['value'] = ( isset( $field['value'] ) ? $field['value'] : '' );
			?>
			<option value="0"<?php selected( $field['value'], 0 ); ?>><?php esc_html_e( 'No', 'posthog' ); ?></option>
			<option value="1"<?php selected( $field['value'], 1 ); ?>><?php esc_html_e( 'Yes', 'posthog' ); ?></option>
		</select>
		<?php
		break;
}

if ( isset( $field['description'] ) ) {
	?>
	<p class="description">
		<?php echo wp_kses_post( $field['description'] ); ?>
	</p>
	<?php
}
