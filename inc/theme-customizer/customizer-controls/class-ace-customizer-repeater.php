<?php


if ( ! class_exists( 'Customizer_Repeater' ) ) {
    return;
}


if ( ! class_exists( 'AceCustomizerRepeater' ) ) {
class AceCustomizerRepeater extends Customizer_Repeater {

    public function __construct( $manager, $id, $args = array() )
    {
        parent::__construct( $manager, $id, $args );

		if ( file_exists( get_template_directory() . '/inc/theme-customizer/customizer-controls/customizer-repeater/inc/icons.php' ) ) {
			$this->customizer_icon_container = 'customizer-repeater/inc/icons';
		}

    }
}
}

/**
 * Sanitization function.
 *
 * @param string $input Control input.
 *
 * @return string
 */
function customizer_repeater_sanitize( $input ) {
	$input_decoded = json_decode( $input, true );
	if ( ! empty( $input_decoded ) ) {
		foreach ( $input_decoded as $boxk => $box ) {
			foreach ( $box as $key => $value ) {

					$input_decoded[ $boxk ][ $key ] = wp_kses_post( force_balance_tags( $value ) );

			}
		}
		return json_encode( $input_decoded );
	}
	return $input;
}
