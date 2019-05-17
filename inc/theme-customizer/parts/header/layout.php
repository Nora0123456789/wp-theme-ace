<?php
// Layout
$wp_customize->add_section( 'section_header_layout_style', array(
    'title' => esc_html__( 'Layout', 'ace' ),
    'panel' => 'panel_header',
));

    // Style Pattern
    // Used as class name of Header Wrapper
    $wp_customize->add_setting( 'header_style_pattern', array(
        'default'  => 'plain',
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeHeaderStylePattern' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeHeaderStylePattern' ),
    ));
    $wp_customize->add_control( 'header_style_pattern', array(
        'section' => 'section_header_layout_style',
        'settings' => 'header_style_pattern',
        'label' => esc_html__( 'Header Style', 'ace' ),
        'description' => __( 'Header Style', 'ace' ),
        'type' => 'select',
        'choices' => array(
            'plain' => __( 'Plain', 'ace' ),
            //'formal' => __( 'Formal', 'ace' ),
            //'material' => __( 'Material', 'ace' ),
        )
    ));

    // Layout Pattern
    // Used as class name of Header Wrapper
    $wp_customize->add_setting( 'header_layout_pattern', array(
        'default'  => 'vertical',
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeHeaderLayoutPattern' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeHeaderLayoutPattern' ),
    ));
    $wp_customize->add_control( 'header_layout_pattern', array(
        'section' => 'section_header_layout_style',
        'settings' => 'header_layout_pattern',
        'label' => esc_html__( 'Header Layout', 'ace' ),
        'description' => __( 'Header Layout for Fixed Part', 'ace' ),
        'type' => 'select',
        'choices' => array(
            'vertical' => __( 'Vertical', 'ace' ),
            'flex' => __( 'Flex', 'ace' ),
            'fixed-on-left' => __( 'Fixed on Left', 'ace' ),
            //'material' => __( 'Material', 'ace' ),
        )
    ));

    // Is Header Fixed
    $wp_customize->add_setting( 'is_header_fixed', array(
        'default'  => false,
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
    ));
    $wp_customize->add_control( 'is_header_fixed', array(
        'section' => 'section_header_layout_style',
        'settings' => 'is_header_fixed',
        'label' => esc_html__( 'Fix to top when scrolling', 'ace' ),
        'description' => __( 'Fix to top when scrolling?', 'ace' ),
        'type' => 'checkbox',
    ));

    // Search
    /*
    $wp_customize->add_setting( 'is_search_on_top', array(
        'default'  => false,
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
    ));
    $wp_customize->add_control( 'is_search_on_top', array(
        'section' => 'section_header_layout_style',
        'settings' => 'is_search_on_top',
        'label' => esc_html__( 'Is Search Box on Top Right', 'ace' ),
        'description' => __( 'Is Search Box on Top Right?', 'ace' ),
        'type' => 'checkbox',
    ));
    */


    