<?php

// Color
$wp_customize->add_section( 'section_header_color_style', array(
    'title' => esc_html__( 'Colors', 'ace' ),
    'panel' => 'panel_header',
));

    // Background Color
    $wp_customize->add_setting( 'header_background_color', array( 
        'default'  => $this->themeMods['header_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background_color', array(
        'label' => esc_html__( 'Background', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_background_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Background Color
    $wp_customize->add_setting( 'header_fixed_parts_background_color', array( 
        'default'  => $this->themeMods['header_fixed_parts_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'header_fixed_parts_background_color', array(
        'label' => esc_html__( 'Background of Fixed Part', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_fixed_parts_background_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Site Name
    $wp_customize->add_setting( 'header_site_name_color', array( 
        'default'  => $this->themeMods['header_site_name_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'header_site_name_color', array(
        'label' => esc_html__( 'Site Name', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_site_name_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Site Description
    $wp_customize->add_setting( 'header_site_description_color', array( 
        'default'  => $this->themeMods['header_site_description_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'header_site_description_color', array(
        'label' => esc_html__( 'Site Description', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_site_description_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Breadcrumb
    $wp_customize->add_setting( 'header_breadcrumb_color', array( 
        'default'  => $this->themeMods['header_breadcrumb_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'header_breadcrumb_color', array(
        'label' => esc_html__( 'Breadcrumb Text', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_breadcrumb_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Nav Menu
    $wp_customize->add_setting( 'header_nav_menu_text_color', array( 
        'default'  => $this->themeMods['header_nav_menu_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'header_nav_menu_text_color', array(
        'label' => esc_html__( 'Nav Menu', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_nav_menu_text_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Nav Menu Hover
    $wp_customize->add_setting( 'header_nav_menu_text_color_hover', array( 
        'default'  => $this->themeMods['header_nav_menu_text_color_hover'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'header_nav_menu_text_color_hover', array(
        'label' => esc_html__( 'Nav Menu Hover', 'ace' ),
        'section' => 'section_header_color_style',
        'settings' => 'header_nav_menu_text_color_hover',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

