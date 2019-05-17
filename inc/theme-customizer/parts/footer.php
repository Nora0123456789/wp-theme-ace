<?php // Main Area
$wp_customize->add_panel( 'panel_footer', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Footer', 'ace' ),
    'description'	=> '',
) );

    // General
    $wp_customize->add_section( 'section_footer_general', array(
        'title' => esc_html__( 'General', 'ace' ),
        'panel' => 'panel_footer',
    ));

    // Layout
        require_once( 'footer/layout.php' );

    // Font Family
        require_once( 'footer/font.php' );

    // Colors
        require_once( 'footer/color.php' );

    // Edges
        require_once( 'footer/edge.php' );

