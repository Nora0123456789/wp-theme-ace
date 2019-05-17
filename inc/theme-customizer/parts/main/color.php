<?php

// Color
$wp_customize->add_section( 'section_main_area_color_style', array(
    'title' => esc_html__( 'Colors', 'ace' ),
    'panel' => 'panel_main_area',
));

    // Area Background ( No Use Alpha )
    $wp_customize->add_setting( 'main_area_background_color', array( 
        'default' => $this->themeMods['main_area_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_area_background_color', array(
        'label' => esc_html__( 'Area Background', 'ace' ),
        'section' => 'section_main_area_color_style',
        'settings' => 'main_area_background_color',
        'palette' => $this->palletColorSet,
    )));

    // Background
    $wp_customize->add_setting( 'main_background_color', array( 
        'default' => $this->themeMods['main_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_background_color', array(
        'label' => esc_html__( 'Background', 'ace' ),
        'section' => 'section_main_area_color_style',
        'settings' => 'main_background_color',
        'palette' => $this->palletColorSet,
    )));

    // Text
    $wp_customize->add_setting( 'main_text_color', array( 
        'default' => $this->themeMods['main_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_text_color', array(
        'label' => esc_html__( 'Text', 'ace' ),
        'section' => 'section_main_area_color_style',
        'settings' => 'main_text_color',
        'palette' => $this->palletColorSet,
    )));

    // Link Text
    $wp_customize->add_setting( 'main_link_text_color', array( 
        'default' => $this->themeMods['main_link_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_link_text_color', array(
        'label' => esc_html__( 'Link Text', 'ace' ),
        'section' => 'section_main_area_color_style',
        'settings' => 'main_link_text_color',
        'palette' => $this->palletColorSet,
    )));

