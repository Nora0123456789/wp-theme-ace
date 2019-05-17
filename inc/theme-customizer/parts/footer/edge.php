<?php

// Edge
$wp_customize->add_section( 'section_footer_edge_style', array(
    'title' => esc_html__( 'Edge', 'ace' ),
    'panel' => 'panel_footer',
));

    // Edge Design
    $wp_customize->add_setting( 'footer_design_edge', array(
        'default'  => $this->themeMods['footer_design_edge'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
        'sanitize_js_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'footer_design_edge', array(
        'section' => 'section_footer_edge_style',
        'settings' => 'footer_design_edge',
        'label' => esc_html__( 'Footer Edge Type', 'ace' ),
        'type' => 'select',
        'choices' => $this->designedEdgeTypes,
    ));

        // Edge Design Color
        $wp_customize->add_setting( 'footer_design_edge_color', array( 
            'default'  => $this->themeMods['footer_design_edge_color'],
            'transport' => 'postMessage',
            'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
            'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
        ));
        $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, 'footer_design_edge_color', array(
            'label' => esc_html__( 'Layered Color', 'ace' ),
            'section' => 'section_footer_edge_style',
            'settings' => 'footer_design_edge_color',
            'palette' => $this->palletColorSet,
        )));



