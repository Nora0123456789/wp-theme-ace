<?php


if ( ! class_exists( 'Customizer_Select_Multiple' ) ) {
    return;
}


if ( ! class_exists( 'AceCustomizerSelectMultiple' ) ) {
class AceCustomizerSelectMultiple extends Customizer_Select_Multiple {

	/**
	 * Loads the framework scripts/styles.
	 *
	 * @since  1.1.40
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'customizer-select-multiple', get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-select-multiple/js/script-customizer-select-multiple.js', array( 'jquery', 'customize-base' ), MULTISELECT_VERSION, true );

	}

}
}

