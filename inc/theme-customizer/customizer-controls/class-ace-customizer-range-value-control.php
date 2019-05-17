<?php


if ( ! class_exists( 'Customizer_Range_Value_Control' ) ) {
    return;
}


if ( ! class_exists( 'AceCustomizerRangeValueControl' ) ) {
class AceCustomizerRangeValueControl extends Customizer_Range_Value_Control {

    /**
	 * Enqueue scripts/styles.
	 */
	public function enqueue() {
		wp_enqueue_script( 'customizer-range-value-control', get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-range-control/js/customizer-range-value-control.js', array( 'jquery', 'customize-base' ), RANGE_VERSION, true );
		wp_enqueue_style( 'customizer-range-value-control', get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-range-control/css/customizer-range-value-control.css', array(), RANGE_VERSION );
	}


}
}