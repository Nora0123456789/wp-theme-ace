<?php // Page Design
$wp_customize->add_panel( 'panel_design', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Page Design', 'ace' ),
    'description'	=> '',
) );

    // General
    $wp_customize->add_section( 'section_design_general', array(
        'title' => esc_html__( 'General', 'ace' ),
        'panel' => 'panel_design',
    ));

    // Color
        require_once( 'design/color.php' );

    // Font
        require_once( 'design/font.php' );

    // Skin
        require_once( 'design/skin.php' );






        