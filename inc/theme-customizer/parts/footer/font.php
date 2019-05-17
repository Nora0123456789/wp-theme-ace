<?php
// Font
$wp_customize->add_section( 'section_footer_font_style', array(
    'title' => esc_html__( 'Fonts', 'ace' ),
    'panel' => 'panel_footer',
));

    // Text
    $wp_customize->add_setting( 'footer_text_font_family', array(
        'default'  => $this->themeMods['footer_text_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'footer_text_font_family', array(
        'section' => 'section_footer_font_style',
        'settings' => 'footer_text_font_family',
        'label' => esc_html__( 'Text', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

    // Nav Menu
    $wp_customize->add_setting( 'footer_nav_menu_font_family', array(
        'default'  => $this->themeMods['footer_nav_menu_font_family'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
        'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
    ));
    $wp_customize->add_control( 'footer_nav_menu_font_family', array(
        'section' => 'section_footer_font_style',
        'settings' => 'footer_nav_menu_font_family',
        'label' => esc_html__( 'Nav Menu', 'ace' ),
        'type' => 'select',
        'choices' => $this->fontFamilies,
    ));

