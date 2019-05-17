<?php



// Color
$wp_customize->add_section( 'section_main_archive_layout_style', array(
    'title' => esc_html__( 'Layout', 'ace' ),
    'panel' => 'panel_main_archive',
));

    // Article Type
    $wp_customize->add_setting( 'main_archive_article_type', array(
        'default'  => $this->themeMods['main_archive_article_type'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => array( $this, 'sanitizeArchiveArticleLayoutPattern' ),
        'sanitize_js_callback' => array( $this, 'sanitizeArchiveArticleLayoutPattern' ),
    ));
    $wp_customize->add_control( 'main_archive_article_type', array(
        'section' => 'section_main_archive_layout_style',
        'settings' => 'main_archive_article_type',
        'label' => esc_html__( 'Article Type', 'ace' ),
        'type' => 'select',
        'choices' => array(
            'card' => __( 'Card', 'ace' ),
            '3-cols' => __( '3 Cols', 'ace' ),
            //'slider' => __( 'Slider', 'ace' )
        ),
    ));








