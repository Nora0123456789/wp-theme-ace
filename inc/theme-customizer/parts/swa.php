<?php 
/*
Standard Widget Areas
Should be loaded by AceThemeCustomizer

$this->themeMods           
$this->fontFamilies        
$this->animateCSS          
$this->backgroundImageSizes

*/
$wp_customize->add_panel( 'swa', array(
    'capability'	 => 'edit_theme_options',
    'theme_supports' => '',
    'title'		  => esc_html__( 'Standard Widget Areas', 'ace' ),
    'description'	=> '',
) );

    // Area
    require_once( 'swa/area.php');

