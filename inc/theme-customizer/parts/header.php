<?php
$wp_customize->add_panel( 'panel_header', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Header', 'ace' ),
    'description'	=> esc_html__( 'Header Section ', 'ace' ),
) );

    // Layout
    $wp_customize->add_section( 'section_header_general_style', array(
        'title' => esc_html__( 'General Style', 'ace' ),
        'panel' => 'panel_header',
    ));

    // Layout
        require_once( 'header/layout.php' );

    // Font Family
        require_once( 'header/font.php' );

    // Colors
        require_once( 'header/color.php' );

    // Edges
        require_once( 'header/edge.php' );

    // Contact Info
        require_once( 'header/contact-info.php' );

