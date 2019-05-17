<?php

if ( has_action( ace()->getPrefixedActionHook( 'render_beginning_of_content' ) ) ) {
    //echo '<div class="singular-beginning-of-content">';
        do_action( ace()->getPrefixedActionHook( 'render_beginning_of_content' ) );
    //echo '</div>';
}

echo '<div class="post-content">';

    the_content();

    echo '<div class="clearfix"></div>';

    do_action( ace()->getPrefixedActionHook( 'render_link_pages' ) );

echo '</div>';

do_action( ace()->getPrefixedActionHook( 'render_maybe_cta_after_content' ) );

if ( has_action( ace()->getPrefixedActionHook( 'render_end_of_content' ) ) ) {
    echo '<div class="singular-end-of-content">';
        do_action( ace()->getPrefixedActionHook( 'render_end_of_content' ) );
    echo '</div>';
}

