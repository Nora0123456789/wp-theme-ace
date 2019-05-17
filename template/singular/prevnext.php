<?php



echo '<div class="p-navi clearfix single-page-prev-next">';
$prev_post = get_previous_post();
if ( ! empty( $prev_post ) ) {
    echo '<a class="prev-post-title-link" href="' . esc_url( get_the_permalink( absint( $prev_post->ID ) ) ) . '" rel="prev">';
        echo '<div class="prev-post-inner">';
            echo '<span class="prev-post-text">';
                esc_html_e( 'Prev Page', 'ace' );
            echo '</span>';
                echo '<span class="prev-post-title">';
                    echo get_the_title( $prev_post->ID );
                echo '</span>';
        echo '</div>';
    echo '</a>';
} unset( $prev_post );

$next_post = get_next_post();
if ( ! empty( $next_post ) ) {
    echo '<a class="next-post-title-link" href="' . esc_url( get_the_permalink( absint( $next_post->ID ) ) ) . '" rel="next">';
        echo '<div class="next-post-inner">';
            echo '<span class="next-post-text">';
                esc_html_e( 'Next Page', 'ace' );
            echo '</span>';
            echo '<span class="next-post-title">';
                echo get_the_title( $next_post->ID );
            echo '</span>';
        echo '</div>';
    echo '</a>';
} unset( $next_post );
echo '</div>';
