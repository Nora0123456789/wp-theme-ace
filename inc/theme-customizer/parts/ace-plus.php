<?php


$wp_customize->register_section_type( 'AceCustomizerLinkSection' );

// Register sections.
$wp_customize->add_section(
    new AceCustomizerLinkSection(
        $wp_customize,
        'ace_plus',
        array(
            'title'    => esc_html__( 'Plugin Ace+', 'ace' ),
            'pro_text' => esc_html__( 'Features?', 'ace' ),
            'pro_url'  => 'https://wp-works.com/features-of-plugin-ace-plus/',
            'priority' => 120
        )
    )
);


