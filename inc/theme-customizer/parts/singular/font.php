<?php
// Font Family
    // Basic
    $wp_customize->add_setting( 'main_singular_basic_font_family', array(
        'default'  => $this->themeMods['main_singular_basic_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'main_singular_basic_font_family', array(
        'section' => 'section_main_singular_font_family_style',
        'settings' => 'main_singular_basic_font_family',
        'label' => esc_html__( 'Basic', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

    // Title
    $wp_customize->add_setting( 'main_singular_title_font_family', array(
        'default'  => $this->themeMods['main_singular_title_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'main_singular_title_font_family', array(
        'section' => 'section_main_singular_font_family_style',
        'settings' => 'main_singular_title_font_family',
        'label' => esc_html__( 'Title', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

