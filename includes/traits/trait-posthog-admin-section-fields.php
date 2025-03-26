<?php
/**
 * PostHog settings section fields trait.
 *
 * @package PostHog
 * @author WP Zinc
 */

/**
 * PostHog settings section fields trait.
 *
 * @package PostHog
 * @author WP Zinc
 */
trait PostHog_Admin_Section_Fields_Trait {

	/**
	 * Outputs a text field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function text_field_callback( $args ) {

		$html = sprintf(
			'<input type="text" class="regular-text" id="%s" name="%s[%s]" value="%s" />',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] ),
			esc_attr( $args['value'] )
		);

		$this->output_field( $html, $args );

	}

	/**
	 * Outputs a number field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function number_field_callback( $args ) {

		$html = sprintf(
			'<input type="number" class="small-text" id="%s" name="%s[%s]" value="%s" min="%s" max="%s" step="%s" />',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] ),
			esc_attr( $args['value'] ),
			$args['min'],
			$args['max'],
			$args['step']
		);

		$this->output_field( $html, $args );

	}

	/**
	 * Outputs a textarea field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function textarea_field_callback( $args ) {

		$html = sprintf(
			'<textarea class="regular-text" id="%s" name="%s[%s]">%s</textarea>',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] ),
			esc_attr( $args['value'] )
		);

		$this->output_field( $html, $args );

	}

	/**
	 * Outputs a date field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function date_field_callback( $args ) {

		$html = sprintf(
			'<input type="date" class="regular-text" id="%s" name="%s[%s]" value="%s" />',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] ),
			esc_attr( $args['value'] )
		);

		$this->output_field( $html, $args );

	}

	/**
	 * Outputs a select field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function select_field_callback( $args ) {

		// Build opening <select> tag.
		$html = sprintf(
			'<select id="%s" name="%s[%s]" size="1">',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] )
		);

		// Build <option> tags.
		foreach ( $args['options'] as $option => $label ) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				esc_attr( $option ),
				selected( $args['value'], $option, false ),
				esc_attr( $label )
			);
		}

		// Close <select>.
		$html .= '</select>';

		$this->output_field( $html, $args );

	}

	/**
	 * Outputs a multiple select field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function select_multiple_field_callback( $args ) {

		// Build opening <select> tag.
		$html = sprintf(
			'<select id="%s" name="%s[%s][]" size="%s" multiple>',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] ),
			esc_attr( (string) count( $args['options'] ) )
		);

		// Build <option> tags.
		foreach ( $args['options'] as $option => $label ) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				esc_attr( $option ),
				( in_array( $option, $args['value'], true ) ? ' selected' : '' ),
				esc_attr( $label )
			);
		}

		// Close <select>.
		$html .= '</select>';

		$this->output_field( $html, $args );

	}

	/**
	 * Outputs a checkbox field.
	 *
	 * @since   1.0.0
	 *
	 * @param   array $args   Field arguments.
	 */
	public function checkbox_field_callback( $args ) {

		$html = sprintf(
			'<input type="checkbox" id="%s" name="%s[%s]" value="1"%s />',
			esc_attr( $args['name'] ),
			esc_attr( $this->settings_key ),
			esc_attr( $args['name'] ),
			esc_attr( $args['value'] ? ' checked' : '' )
		);

		$this->output_field( $html, $args );

	}

	/**
	 * Returns the given text wrapped in a paragraph with the description class.
	 *
	 * @since   1.0.0
	 *
	 * @param   bool|string|array $description    Description.
	 * @return  string                            HTML Description
	 */
	public function get_description( $description ) {

		// Return blank string if no description specified.
		if ( ! $description ) {
			return '';
		}

		// Return description in paragraph.
		return '<p class="description">' . esc_html( $description ) . '</p>';

	}

	/**
	 * Outputs the given field HTML with the description,
	 * running the output through wp_kses() with the allowed tags.
	 *
	 * @since   1.0.0
	 *
	 * @param   string $html   HTML to output.
	 * @param   array  $args   Field arguments.
	 */
	private function output_field( $html, $args ) {

		echo wp_kses(
			$html . $this->get_description( $args['description'] ),
			array(
				'input'    => array(
					'type'    => array(),
					'class'   => array(),
					'id'      => array(),
					'name'    => array(),
					'value'   => array(),
					'min'     => array(),
					'max'     => array(),
					'step'    => array(),
					'checked' => array(),
				),
				'select'   => array(
					'id'       => array(),
					'name'     => array(),
					'size'     => array(),
					'multiple' => array(),
				),
				'option'   => array(
					'value'    => array(),
					'selected' => array(),
				),
				'textarea' => array(
					'class' => array(),
					'id'    => array(),
					'name'  => array(),
					'rows'  => array(),
					'cols'  => array(),
				),
				'p'        => array(),
			)
		);

	}

}
