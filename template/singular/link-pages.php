<?php

// for "<!--nextpage-->"
$args = array(
    'before'           => '<div class="page-links-div"><span>' . esc_html__( 'Pages:', 'ace' ) . '</span>',
    'after'	           => '</div>',
    'link_before'      => '<span class="page-links-num">',
    'link_after'       => '</span>',
    'next_or_number'   => esc_attr( get_option( ace()->getPrefixedOptionName( 'link_pages_type' ), 'number' ) ), // number or next
    'separator'        => ' ',
    'nextpagelink'     => esc_html__( 'Next Page', 'ace' ),
    'previouspagelink' => esc_html__( 'Prev Page', 'ace' ),
    'pagelink'         => '%',
    'echo'             => 1
);
wp_link_pages( $args );
unset( $args );

