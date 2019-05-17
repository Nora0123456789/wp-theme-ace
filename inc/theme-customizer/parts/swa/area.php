<?php

$swa = ace()->getWidgetAreaManager()->getStandardWidgetAreas();
foreach ( $swa as $swa_id => $data ) {

    $hook        = $data['id'];
    $class       = $data['class'];
    $name        = $data['name'];
    $description = $data['description'];

    // Section
    $section_id = sprintf( 'swa_%s', $hook );
    $wp_customize->add_section( $section_id, array(
        'title' => $name,
        'panel' => 'swa',
        'description' => $description
    ));

    $setting_id_prefix = $section_id . '_';

    // Enter CSS Animation
        // Widget Area
        /*
            $wp_customize->add_setting( $setting_id_prefix . 'area_animation_enter', array(
                'default'  => 'none',
                'transport' => 'postMessage',
                'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCSSAnimationEnter' ),
                'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCSSAnimationEnter' ),
            ));
            $wp_customize->add_control( $setting_id_prefix . 'area_animation_enter', array(
                'section' => $section_id,
                'settings' => $setting_id_prefix . 'area_animation_enter',
                'label' => esc_html__( 'Area Animation Enter', 'ace' ),
                'type' => 'select',
                'choices' => $this->animateCSS['enter']
            ));
        */

    // Design
        // Widget Border
            $wp_customize->add_setting( $setting_id_prefix . 'border', array(
                'default'  => false,
                'transport' => 'postMessage',
                'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
                'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeCheckbox' ),
            ));
            $wp_customize->add_control( $setting_id_prefix . 'border', array(
                'section' => $section_id,
                'settings' => $setting_id_prefix . 'border',
                'label' => esc_html__( 'Border for Each Item', 'ace' ),
                'type' => 'checkbox',
            ));

        // Padding
            $wp_customize->add_setting( $setting_id_prefix . 'padding', array(
                'default' => 0,
                'capability' => 'edit_theme_options',
                'transport' => 'postMessage',
                'sanitize_callback' => 'absint',
                'sanitize_js_callback' => 'absint',
            ));
            $wp_customize->add_control( $setting_id_prefix . 'padding', array(
                'section' => $section_id,
                'settings' => $setting_id_prefix . 'padding',
                'label' => esc_html__( 'Padding', 'ace' ),
                'type' => 'range',
                'description' => '',
                'input_attrs' => array(
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'value' => absint( $this->themeMods[ $setting_id_prefix . 'padding'] ),
                    'id' => $setting_id_prefix . 'padding_id',
                    'style' => 'width:100%;',
                ),
            ));

    // Colors
        // Background
            $wp_customize->add_setting( $setting_id_prefix . 'background_color', array( 
                'default' => 'rgba(255,255,255,0)',
                'transport' => 'postMessage',
                'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
            ));
            $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, $setting_id_prefix . 'background_color', array(
                'label' => esc_html__( 'Background Color of Widget Item', 'ace' ),
                'section' => $section_id,
                'settings' => $setting_id_prefix . 'background_color',
                'palette' => $this->palletColorSet,
            )));

    // Widget
        // Animation
            // Widget Area Enter
                $wp_customize->add_setting( $setting_id_prefix . 'widget_animation_enter', array(
                    'default'  => 'none',
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeEnterAnimation' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeEnterAnimation' ),
                ));
                $wp_customize->add_control( $setting_id_prefix . 'widget_animation_enter', array(
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'widget_animation_enter',
                    'label' => esc_html__( 'Enter Animation for Widget', 'ace' ),
                    'type' => 'select',
                    'choices' => $this->animationClasses['enter']

                ));

            // Enter
                $wp_customize->add_setting( $setting_id_prefix . 'widget_animation_hide', array(
                    'default'  => 'none',
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeHideAnimation' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeHideAnimation' ),
                ));
                $wp_customize->add_control( $setting_id_prefix . 'widget_animation_hide', array(
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'widget_animation_hide',
                    'label' => esc_html__( 'Hide Animation for Widget', 'ace' ),
                    'type' => 'select',
                    'choices' => $this->animationClasses['hide']
                ));

        // Style
            // Widget Space
                $widget_space_key = $setting_id_prefix . 'widget_space';
                $wp_customize->add_setting( $setting_id_prefix . 'widget_space', array(
                    'default'  => $this->themeMods[ $widget_space_key ],
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'absint',
                    'sanitize_js_callback' => 'absint',
                ));
                $wp_customize->add_control( $setting_id_prefix . 'widget_space', array(
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'widget_space',
                    'label' => esc_html__( 'Space between widgets', 'ace' ),
                    'type' => 'range',
                    'input_attrs' => array(
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'value' => absint( $this->themeMods[ $setting_id_prefix . 'widget_space'] ),
                        'id' => $setting_id_prefix . 'widget_space_id',
                        'style' => 'width:100%;',
                    ),
                ));

        // Title
            // Font Family
                $font_family_key = $setting_id_prefix . 'title_font_family';
                $wp_customize->add_setting( $setting_id_prefix . 'title_font_family', array(
                    'default'  => $this->themeMods[ $font_family_key ],
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeFontFamilies' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeFontFamilies' ),
                ));
                $wp_customize->add_control( $setting_id_prefix . 'title_font_family', array(
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'title_font_family',
                    'label' => esc_html__( 'Title Font Family', 'ace' ),
                    'type' => 'select',
                    'choices' => $this->fontFamilies,
                ));

            // Color
                $wp_customize->add_setting( $setting_id_prefix . 'title_color', array( 
                    'default' => '#000000',
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                ));
                $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, $setting_id_prefix . 'title_color', array(
                    'label' => esc_html__( 'Title Color', 'ace' ),
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'title_color',
                    'palette' => $this->palletColorSet,
                )));

            // Text Align
                $font_family_key = $setting_id_prefix . 'title_text_align';
                $wp_customize->add_setting( $setting_id_prefix . 'title_text_align', array(
                    'default'  => 'center',
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeTextAlign' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeTextAlign' ),
                ));
                $wp_customize->add_control( $setting_id_prefix . 'title_text_align', array(
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'title_text_align',
                    'label' => esc_html__( 'Title Text Align', 'ace' ),
                    'type' => 'select',
                    'choices' => $this->textAlign,
                ));

            // Text
            // Font Family
                $font_family_key = $setting_id_prefix . 'text_font_family';
                $wp_customize->add_setting( $setting_id_prefix . 'text_font_family', array(
                    'default'  => $this->themeMods[ $font_family_key ],
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeFontFamilies' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeFontFamilies' ),
                ));
                $wp_customize->add_control( $setting_id_prefix . 'text_font_family', array(
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'text_font_family',
                    'label' => esc_html__( 'Text Font Family', 'ace' ),
                    'type' => 'select',
                    'choices' => $this->fontFamilies,
                ));

            // Text Color
                $wp_customize->add_setting( $setting_id_prefix . 'text_color', array( 
                    'default' => '#666666',
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                ));
                $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, $setting_id_prefix . 'text_color', array(
                    'label' => esc_html__( 'Text Color', 'ace' ),
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'text_color',
                    'palette' => $this->palletColorSet,
                )));
                
            // Link Text Color
                $wp_customize->add_setting( $setting_id_prefix . 'text_link_color', array( 
                    'default' => '#337ab7',
                    'transport' => 'postMessage',
                    'sanitize_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                    'sanitize_js_callback' => array( 'AceSanitizeMethods', 'sanitizeColorValue' ),
                ));
                $wp_customize->add_control( new AceCustomizerAlphaColorControl( $wp_customize, $setting_id_prefix . 'text_link_color', array(
                    'label' => esc_html__( 'Text Link Color', 'ace' ),
                    'section' => $section_id,
                    'settings' => $setting_id_prefix . 'text_link_color',
                    'palette' => $this->palletColorSet,
                )));	

    //

    $wp_customize->add_setting( $setting_id_prefix . 'setting_tabs', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( new AceCustomizerTabsControl( $wp_customize, $setting_id_prefix . 'setting_tabs', array(
        'section' => $section_id,
        'tabs'    => array(
            'area' => array(
                'nicename' => esc_html__( 'Widget Area', 'ace' ),
                'icon'     => 'font',
                'controls' => array(
                    $setting_id_prefix . 'widget_animation_enter',
                    $setting_id_prefix . 'widget_animation_hide',

                    $setting_id_prefix . 'background_color',
                    $setting_id_prefix . 'background_image',
                    /*
                    $setting_id_prefix . 'background_image_size',
                    $setting_id_prefix . 'background_image_position_row',
                    $setting_id_prefix . 'background_image_position_column',
                    $setting_id_prefix . 'background_image_repeat',
                    $setting_id_prefix . 'background_image_attachment',
                    */
                    $setting_id_prefix . 'padding',
                    $setting_id_prefix . 'border',
                ),
            ),
            'widget'   => array(
                'nicename' => esc_html__( 'Widget', 'ace' ),
                'icon'     => 'text-height',
                'controls' => array(
                    $setting_id_prefix . 'widget_space',
                    $setting_id_prefix . 'title_font_family',
                    $setting_id_prefix . 'title_color',
                    $setting_id_prefix . 'title_text_align',
                    $setting_id_prefix . 'text_font_family',
                    $setting_id_prefix . 'text_link_color',
                    $setting_id_prefix . 'text_color',
                ),
            ),
        ),
    ) ) );    

}

