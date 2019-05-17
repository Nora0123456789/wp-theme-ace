<?php

if ( ! class_exists( 'Customizer_Alpha_Color_Control' ) ) {
    return;
}

if ( ! class_exists( 'AceCustomizerAlphaColorControl' ) ) {
class AceCustomizerAlphaColorControl extends Customizer_Alpha_Color_Control {

    public function enqueue()
    {
		wp_enqueue_script(
			'ace-customizer-alpha-color-picker',
			get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-alpha-color-picker/js/alpha-color-picker.js',
			array( 'jquery', 'wp-color-picker' ),
			ALPHA_VERSION,
			true
		);
		wp_enqueue_style(
			'ace-customizer-alpha-color-picker',
			get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-alpha-color-picker/css/alpha-color-picker.css',
			array( 'wp-color-picker' ),
			ALPHA_VERSION
		);
    }

	/**
	 * Render the control.
	 */
	public function render_content() {
		// Process the palette
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}
		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
		// Begin the output. 
		
		if ( isset( $this->label ) && '' !== $this->label ) {
			echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
		}

		// Output the label and description if they were passed in.
		if ( isset( $this->description ) && '' !== $this->description ) {
			echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
		}

		?>
		<label>
			<?php
			// Output the label and description if they were passed in.
			if ( isset( $this->label ) && '' !== $this->label ) {
				//echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
			}
			if ( isset( $this->description ) && '' !== $this->description ) {
				//echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
			}
			?>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_attr( $show_opacity ); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php esc_attr( $this->link() ); ?>  />
		</label>
		<?php
	}

}
}