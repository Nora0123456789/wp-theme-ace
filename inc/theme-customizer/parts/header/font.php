<?php
// Font
$wp_customize->add_section( 'section_header_font_style', array(
    'title' => esc_html__( 'Fonts', 'ace' ),
    'panel' => 'panel_header',
));


    // Site Name
    $wp_customize->add_setting( 'header_site_name_font_family', array(
        'default'  => $this->themeMods['header_site_name_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'header_site_name_font_family', array(
        'section' => 'section_header_font_style',
        'settings' => 'header_site_name_font_family',
        'label' => esc_html__( 'Site Name', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

    // Description
    $wp_customize->add_setting( 'header_site_description_font_family', array(
        'default'  => $this->themeMods['header_site_description_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'header_site_description_font_family', array(
        'section' => 'section_header_font_style',
        'settings' => 'header_site_description_font_family',
        'label' => esc_html__( 'Site Description', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

    // Breadcrumb
    $wp_customize->add_setting( 'header_breadcrumb_color', array(
        'default'  => $this->themeMods['header_breadcrumb_color'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'header_breadcrumb_color', array(
        'section' => 'section_header_font_style',
        'settings' => 'header_breadcrumb_color',
        'label' => esc_html__( 'Breadcrumb', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

    // Nav Menu
    $wp_customize->add_setting( 'header_nav_menu_font_family', array(
        'default'  => $this->themeMods['header_nav_menu_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'header_nav_menu_font_family', array(
        'section' => 'section_header_font_style',
        'settings' => 'header_nav_menu_font_family',
        'label' => esc_html__( 'Nav Menu', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

