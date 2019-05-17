<?php // Archive
$wp_customize->add_panel( 'panel_main_archive', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Archive', 'ace' ),
    'description'	=> '',
) );

    // General
    $wp_customize->add_section( 'section_main_archive_general', array(
        'title' => esc_html__( 'General', 'ace' ),
        'panel' => 'panel_main_archive',
    ));

    // Font Family
    require_once( 'archive/layout.php' );

    // Font Family
        require_once( 'archive/font.php' );

    // Colors
        require_once( 'archive/color.php' );






        