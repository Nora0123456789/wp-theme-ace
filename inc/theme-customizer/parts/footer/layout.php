<?php
// Font
$wp_customize->add_section( 'section_footer_layout_style', array(
    'title' => esc_html__( 'Layout', 'ace' ),
    'panel' => 'panel_footer',
));

    // Hide Footer
        $wp_customize->add_setting( 'footer_hide_all', array(
            'default'  => false,
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
        ));
        $wp_customize->add_control( 'footer_hide_all', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_hide_all',
            'label' => esc_html__( 'Hide All Footer Parts.', 'ace' ),
            'description' => esc_html__( 'Maybe you want to render content by using widget areas, child theme or your own methods.', 'ace' ),
            'type' => 'checkbox',
        ));

    // Footer Align
        $wp_customize->add_setting( 'footer_text_align', array(
            'default'  => 'center',
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeFooterAlign' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeFooterAlign' ),
        ));
        $wp_customize->add_control( 'footer_text_align', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_text_align',
            'label' => esc_html__( 'Footer Text Align.', 'ace' ),
            'type' => 'select',
            'choices' => array(
                'left' => __( 'Left', 'ace' ),
                'center' => __( 'Center', 'ace' ),
                'right' => __( 'Right', 'ace' ),
            ),
        ));

    // Hide Name Description
        $wp_customize->add_setting( 'footer_hide_site_name_description', array(
            'default'  => false,
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
        ));
        $wp_customize->add_control( 'footer_hide_site_name_description', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_hide_site_name_description',
            'label' => esc_html__( 'Hide Site Name Description', 'ace' ),
            'type' => 'checkbox',
        ));

    // Copyright Year
        $wp_customize->add_setting( 'footer_copyright_year', array(
            'default' => 2000,
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'absint',
            'sanitize_js_callback' => 'absint',
        ));
        $wp_customize->add_control( 'footer_copyright_year', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_copyright_year',
            'label' => esc_html__( 'Year for Copyright', 'ace' ),
            'description' => __( 'Please enter the year of beginning of the website. This number is used for copyright section displayed at the bottom.', 'ace' ),
            'type' => 'number',
        ));

    // Credit Type
        $wp_customize->add_setting( 'footer_display_credit_type', array(
            'default'  => 'none',
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCreditType' ), 
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCreditType' ),
        ));
        $wp_customize->add_control( 'footer_display_credit_type', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_display_credit_type',
            'label' => esc_html__( 'Displayed License Type', 'ace' ),
            'type' => 'select',
            'choices' => ace()->getThemeModManager()->getThemeModsChoicesCreditTypes(),
        ));

    // Hide Theme Name
        $wp_customize->add_setting( 'footer_hide_theme_name', array(
            'default'  => false,
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
        ));
        $wp_customize->add_control( 'footer_hide_theme_name', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_hide_theme_name',
            'label' => esc_html__( 'Hide Theme Name', 'ace' ),
            'type' => 'checkbox',
        ));

    // Custom Theme Footer 
        $wp_customize->add_setting( 'footer_custom_site_info', array(
            'default'  => '',
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeTextarea' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeTextarea' ),
        ));
        $wp_customize->add_control( 'footer_custom_site_info', array(
            'section' => 'section_footer_layout_style',
            'settings' => 'footer_custom_site_info',
            'label' => esc_html__( 'Custom Site Info', 'ace' ),
            'type' => 'textarea',
        ));



