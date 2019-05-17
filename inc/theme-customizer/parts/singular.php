<?php // Singular
$wp_customize->add_panel( 'panel_main_singular', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		     => esc_html__( 'Singular', 'ace' ),
    'description'	 => __( 'Theme Mods for Singular Page.', 'ace' ),
) );

// Header
$wp_customize->add_section( 'section_main_singular_header_style', array(
    'title' => esc_html__( 'Header', 'ace' ),
    'panel' => 'panel_main_singular',
));

// Color
$wp_customize->add_section( 'section_main_singular_color_style', array(
    'title' => esc_html__( 'Colors', 'ace' ),
    'panel' => 'panel_main_singular',
));

// Font Family
$wp_customize->add_section( 'section_main_singular_font_family_style', array(
    'title' => esc_html__( 'Fonts', 'ace' ),
    'panel' => 'panel_main_singular',
));



// Headlines
$headlines = array( 
    'h1'    => __( 'H1', 'ace' ),
    'h2'    => __( 'H2', 'ace' ),
    'h3'    => __( 'H3', 'ace' ),
    'h4'    => __( 'H4', 'ace' ),
    'h5'    => __( 'H5', 'ace' ),
    'h6'    => __( 'H6', 'ace' ),
    'p'     => __( 'P', 'ace' ),
    'table' => __( 'Table', 'ace' ),
    'list'  => __( 'List', 'ace' )
);

    // Font
    require_once( 'singular/header.php' );

    // Font
    require_once( 'singular/font.php' );

    // Color
    require_once( 'singular/color.php' );

    // Text
    require_once( 'singular/text.php' );

    // 



