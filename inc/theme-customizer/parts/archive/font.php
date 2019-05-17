<?php
// Font
$wp_customize->add_section( 'section_main_archive_font_style', array(
    'title' => esc_html__( 'Fonts', 'ace' ),
    'panel' => 'panel_main_archive',
));

    // Fonts
        // Basic Title
        $wp_customize->add_setting( 'main_archive_basic_font_family', array(
            'default'  => $this->themeMods['main_archive_basic_font_family'],
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
            'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
        ));
        $wp_customize->add_control( 'main_archive_basic_font_family', array(
            'section' => 'section_main_archive_font_style',
            'settings' => 'main_archive_basic_font_family',
            'label' => esc_html__( 'Basic', 'ace' ),
            'type' => 'select',
            'choices' => $this->fontFamilies,
        ));

        // Archive Title
        $wp_customize->add_setting( 'main_archive_title_font_family', array(
            'default'  => $this->themeMods['main_archive_title_font_family'],
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
            'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
        ));
        $wp_customize->add_control( 'main_archive_title_font_family', array(
            'section' => 'section_main_archive_font_style',
            'settings' => 'main_archive_title_font_family',
            'label' => esc_html__( 'Title', 'ace' ),
            'type' => 'select',
            'choices' => $this->fontFamilies,
        ));

        // Article Title
        $wp_customize->add_setting( 'main_archive_article_title_font_family', array(
            'default'  => $this->themeMods['main_archive_article_title_font_family'],
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
            'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
        ));
        $wp_customize->add_control( 'main_archive_article_title_font_family', array(
            'section' => 'section_main_archive_font_style',
            'settings' => 'main_archive_article_title_font_family',
            'label' => esc_html__( 'Article Title', 'ace' ),
            'type' => 'select',
            'choices' => $this->fontFamilies,
        ));

        // Article Text
        $wp_customize->add_setting( 'main_archive_article_text_font_family', array(
            'default'  => $this->themeMods['main_archive_article_text_font_family'],
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => array( $this, 'sanitizeFontFamilies' ),
            'sanitize_js_callback' => array( $this, 'sanitizeFontFamilies' ),
        ));
        $wp_customize->add_control( 'main_archive_article_text_font_family', array(
            'section' => 'section_main_archive_font_style',
            'settings' => 'main_archive_article_text_font_family',
            'label' => esc_html__( 'Text', 'ace' ),
            'type' => 'select',
            'choices' => $this->fontFamilies,
        ));




