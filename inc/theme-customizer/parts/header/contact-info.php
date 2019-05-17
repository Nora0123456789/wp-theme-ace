<?php

// Edge
$wp_customize->add_section( 'section_header_contact_info_style', array(
    'title' => esc_html__( 'Contact Info', 'ace' ),
    'panel' => 'panel_header',
));

    // Display
        $wp_customize->add_setting( 'header_contact_info_display', array(
            'default'  => false,
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
        ));
        $wp_customize->add_control( 'header_contact_info_display', array(
            'section' => 'section_header_contact_info_style',
            'settings' => 'header_contact_info_display',
            'label' => esc_html__( 'Header Contact Info Display', 'ace' ),
            'description' => esc_html__( 'Contact Info will be placed in the same line as the site name on header. So navi menu will be placed below that with this even though the header layout type is flex.', 'ace' ),
            'type' => 'checkbox',
        ));

    // Phone Number
        $wp_customize->add_setting( 'header_contact_info_phone_number', array(
            'default'  => '0000-000-000',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
            'sanitize_js_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( 'header_contact_info_phone_number', array(
            'section' => 'section_header_contact_info_style',
            'settings' => 'header_contact_info_phone_number',
            'label' => esc_html__( 'Contact Phone Number', 'ace' ),
            'type' => 'text',
        ));

    // Messages above number
        $wp_customize->add_setting( 'header_contact_info_message_above_number', array( 
            'default'  => '',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
            'sanitize_js_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( 'header_contact_info_message_above_number', array(
            'section' => 'section_header_contact_info_style',
            'settings' => 'header_contact_info_message_above_number',
            'label' => esc_html__( 'Message above Number', 'ace' ),
            'type' => 'text',
        ));

    // Messages below number
        $wp_customize->add_setting( 'header_contact_info_message_below_number', array( 
            'default'  => '',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
            'sanitize_js_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( 'header_contact_info_message_below_number', array(
            'section' => 'section_header_contact_info_style',
            'settings' => 'header_contact_info_message_below_number',
            'label' => esc_html__( 'Message below Number', 'ace' ),
            'type' => 'text',
        ));



