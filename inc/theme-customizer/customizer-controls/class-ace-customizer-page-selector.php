<?php


if ( ! class_exists( 'Customizer_Page_Editor' ) ) {
    return;
}


if ( ! class_exists( 'AceCustomizerPageEditor' ) ) {
class AceCustomizerPageEditor extends Customizer_Page_Editor {

    /**
	 * Enqueue scripts
	 */
	public function enqueue() {
        wp_enqueue_style(
            'ace-customizer-text-editor',
            get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-page-editor/css/customizer-page-editor.css',
            array(),
            CUSTOMIZER_PAGE_EDITOR_VERSION
        );

		wp_enqueue_script(
            'ace-customizer-text-editor',
            get_template_directory_uri() . '/inc/theme-customizer/customizer-controls/customizer-page-editor/js/customizer-text-editor.js', array(
				'jquery',
				'customize-preview',
			), CUSTOMIZER_PAGE_EDITOR_VERSION, true
		);
	}

}
}