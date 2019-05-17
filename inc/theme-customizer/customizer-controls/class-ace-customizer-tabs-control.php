<?php


if ( ! class_exists( 'Customizer_Tabs_Control' ) ) {
    return;
}


if ( ! class_exists( 'AceCustomizerTabsControl' ) ) {
class AceCustomizerTabsControl extends Customizer_Tabs_Control {

    /**
	 * Loads the scripts and hooks our custom styles in.
	 *
	 * @since  1.1.45
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		if ( empty( $this->tabs ) || ! $this->more_than_one_valid_tab() ) {
			return;
		}

		wp_enqueue_script( 'ace-tabs-control-script', get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-tabs/js/script.js', array( 'jquery' ), TABS_VERSION, true );
		wp_enqueue_style( 'ace-tabs-control-style', get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-tabs/css/style.css', null, TABS_VERSION );

	}

	/**
	 * Enqueue the partials handler script that works synchronously with the hestia-tabs-control-script
	 */
	public function partials_helper_script_enqueue() {
		wp_enqueue_script( 'ace-tabs-addon-script', get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-tabs/js/customizer-addon-script.js', array( 'jquery' ), TABS_VERSION, true );
	}


}
}


