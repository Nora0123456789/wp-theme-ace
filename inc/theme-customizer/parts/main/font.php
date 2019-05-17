<?php
// Font
$wp_customize->add_section( 'section_main_area_font_style', array(
    'title' => esc_html__( 'Fonts', 'ace' ),
    'panel' => 'panel_main_area',
));


    // Basic Font Family
    $wp_customize->add_setting( 'main_area_basic_font_family', array(
        'default'  => $this->themeMods['main_area_basic_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'main_area_basic_font_family', array(
        'section' => 'section_main_area_font_style',
        'settings' => 'main_area_basic_font_family',
        'label' => esc_html__( 'Basic Font Family', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

    