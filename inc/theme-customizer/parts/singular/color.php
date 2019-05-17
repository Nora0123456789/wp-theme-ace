<?php
// Background
$wp_customize->add_setting( 'main_singular_title_background_color', array( 
    'default' => $this->themeMods['main_singular_title_background_color'],
    'transport' => 'postMessage',
    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
));
$wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_singular_title_background_color', array(
    'label' => esc_html__( 'Title Background', 'ace' ),
    'section' => 'section_main_singular_color_style',
    'settings' => 'main_singular_title_background_color',
    'show_opacity' => true,
    'palette' => $this->palletColorSet,
)));

// Text 
$wp_customize->add_setting( 'main_singular_title_text_color', array( 
    'default' => $this->themeMods['main_singular_title_text_color'],
    'transport' => 'postMessage',
    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
));
$wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_singular_title_text_color', array(
    'label' => esc_html__( 'Title Text', 'ace' ),
    'section' => 'section_main_singular_color_style',
    'settings' => 'main_singular_title_text_color',
    'show_opacity' => true,
    'palette' => $this->palletColorSet,
)));

