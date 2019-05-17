<?php

// Header Style
$wp_customize->add_setting( 'main_singular_header_style', array( 
    'default' => $this->themeMods['main_singular_header_style'],
    'transport' => 'postMessage',
    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
));
$wp_customize->add_control( 'main_singular_header_style', array(
    'section' => 'section_main_singular_header_style',
    'settings' => 'main_singular_header_style',
    'label' => esc_html__( 'Header Style', 'ace' ),
    'type' => 'select',
    'choices' => $this->singularHeaderStyle,
));

// Title Style
$wp_customize->add_setting( 'main_singular_title_style', array( 
    'default' => $this->themeMods['main_singular_title_style'],
    'transport' => 'postMessage',
    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
));
$wp_customize->add_control( 'main_singular_title_style', array(
    'section' => 'section_main_singular_header_style',
    'settings' => 'main_singular_title_style',
    'label' => esc_html__( 'Title Style', 'ace' ),
    'type' => 'select',
    'choices' => $this->singularTitleStyle,
));



