<?php // Layout
$wp_customize->add_panel( 'panel_layout', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Page Layout', 'ace' ),
    'description'	=> '',
) );

    require_once( 'layout/general.php' );
