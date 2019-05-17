<?php
// Color
$wp_customize->add_section( 'section_main_archive_color_style', array(
    'title' => esc_html__( 'Colors', 'ace' ),
    'panel' => 'panel_main_archive',
));

    // Archive Title 
    $wp_customize->add_setting( 'main_archive_title_color', array( 
        'default' => $this->themeMods['main_archive_title_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_archive_title_color', array(
        'label' => esc_html__( 'Archive Title', 'ace' ),
        'section' => 'section_main_archive_color_style',
        'settings' => 'main_archive_title_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Archive Title Background
    $wp_customize->add_setting( 'main_archive_title_background_color', array( 
        'default' => $this->themeMods['main_archive_title_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_archive_title_background_color', array(
        'label' => esc_html__( 'Archive Title Background', 'ace' ),
        'section' => 'section_main_archive_color_style',
        'settings' => 'main_archive_title_background_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Background
    $wp_customize->add_setting( 'main_archive_article_background_color', array( 
        'default' => $this->themeMods['main_archive_article_background_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_archive_article_background_color', array(
        'label' => esc_html__( 'Background', 'ace' ),
        'section' => 'section_main_archive_color_style',
        'settings' => 'main_archive_article_background_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Article Title 
    $wp_customize->add_setting( 'main_archive_article_title_color', array( 
        'default' => $this->themeMods['main_archive_article_title_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_archive_article_title_color', array(
        'label' => esc_html__( 'Article Title', 'ace' ),
        'section' => 'section_main_archive_color_style',
        'settings' => 'main_archive_article_title_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

    // Text 
    $wp_customize->add_setting( 'main_archive_article_text_color', array( 
        'default' => $this->themeMods['main_archive_article_text_color'],
        'transport' => 'postMessage',
        'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
    ));
    $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'main_archive_article_text_color', array(
        'label' => esc_html__( 'Article Text', 'ace' ),
        'section' => 'section_main_archive_color_style',
        'settings' => 'main_archive_article_text_color',
        'show_opacity' => true,
        'palette' => $this->palletColorSet,
    )));

