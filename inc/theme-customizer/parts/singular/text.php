<?php
foreach( $headlines as $element => $label ) {

    // Color 
    $key = sprintf( 'main_singular_%s_color', $element );
    $label = sprintf( esc_html__( '%s Color', 'ace' ), $label );
    $wp_customize->add_setting( $key, array( 
        'default' => $this->themeMods[ $key ],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, $key, array(
        'label' => $label,
        'section' => 'section_main_singular_color_style',
        'settings' => $key,
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Font Family 
    $key = sprintf( 'main_singular_%s_font_family', $element );
    $label = sprintf( esc_html__( '%s Font Family', 'ace' ), $label );
    $wp_customize->add_setting( $key, array( 
        'default' => $this->themeMods[ $key ],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( $key, array(
        'section' => 'section_main_singular_font_family_style',
        'settings' => $key,
        'label' => esc_html( $label ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));


}

