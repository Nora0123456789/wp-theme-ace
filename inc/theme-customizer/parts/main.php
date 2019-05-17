<?php // Main Area
$wp_customize->add_panel( 'panel_main_area', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Main Area', 'ace' ),
    'description'	=> '',
) );

    // General
    $wp_customize->add_section( 'section_main_area_general', array(
        'title' => esc_html__( 'General', 'ace' ),
        'panel' => 'panel_main_area',
    ));

    // Font Family
        require_once( 'main/font.php' );

    // Colors
        require_once( 'main/color.php' );

    // Edges
        require_once( 'main/edge.php' );

