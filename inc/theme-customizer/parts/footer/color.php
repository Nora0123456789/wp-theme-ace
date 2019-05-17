<?php
// Color
$wp_customize->add_section( 'section_footer_color_style', array(
    'title' => esc_html__( 'Colors', 'ace' ),
    'panel' => 'panel_footer',
));

    // Background
    $wp_customize->add_setting( 'footer_background_color', array( 
        'default' => $this->themeMods['footer_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color', array(
        'label' => esc_html__( 'Background', 'ace' ),
        'section' => 'section_footer_color_style',
        'settings' => 'footer_background_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Text 
    $wp_customize->add_setting( 'footer_text_color', array( 
        'default' => $this->themeMods['footer_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'footer_text_color', array(
        'label' => esc_html__( 'Text', 'ace' ),
        'section' => 'section_footer_color_style',
        'settings' => 'footer_text_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Text Link
    $wp_customize->add_setting( 'footer_link_text_color', array( 
        'default' => $this->themeMods['footer_link_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'footer_link_text_color', array(
        'label' => esc_html__( 'Link Text', 'ace' ),
        'section' => 'section_footer_color_style',
        'settings' => 'footer_link_text_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Nav Menu
    $wp_customize->add_setting( 'footer_nav_menu_text_color', array( 
        'default'  => $this->themeMods['footer_nav_menu_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'footer_nav_menu_text_color', array(
        'label' => esc_html__( 'Nav Menu Text', 'ace' ),
        'section' => 'section_footer_color_style',
        'settings' => 'footer_nav_menu_text_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

