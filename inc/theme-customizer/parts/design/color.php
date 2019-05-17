<?php

// Color
$wp_customize->add_section( 'section_design_color_style', array(
    'title' => esc_html__( 'Colors', 'ace' ),
    'panel' => 'panel_design',
));

    // Text 
    $wp_customize->add_setting( 'basic_background_color', array( 
        'default' => $this->themeMods['basic_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'basic_background_color', array(
        'label' => esc_html__( 'Background', 'ace' ),
        'section' => 'section_design_color_style',
        'settings' => 'basic_background_color',
        'palette' => $this->palletColorSet,
    )));

    // Text 
    $wp_customize->add_setting( 'basic_text_color', array( 
        'default' => $this->themeMods['basic_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'basic_text_color', array(
        'label' => esc_html__( 'Text', 'ace' ),
        'section' => 'section_design_color_style',
        'settings' => 'basic_text_color',
        'palette' => $this->palletColorSet,
    )));

    // Text Link
    $wp_customize->add_setting( 'basic_text_link_color', array( 
        'default' => $this->themeMods['basic_text_link_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'basic_text_link_color', array(
        'label' => esc_html__( 'Text Link', 'ace' ),
        'section' => 'section_design_color_style',
        'settings' => 'basic_text_link_color',
        'palette' => $this->palletColorSet,
    )));




