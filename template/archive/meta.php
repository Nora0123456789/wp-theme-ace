<?php
/**
 * Article Meta for card style
**/

// Author
echo '<p class="bloginfo-p bloginfo-p-user vcard">';
    echo '<a class="fn url" href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . esc_html( get_the_author() ) . '</a>';
echo '</p>';

// Date Published
echo '<p class="bloginfo-p bloginfo-p-time">';
    echo '<time class="dt-published published updated" datetime="'; the_time( 'c' ); echo '">';
        the_time( esc_html_x( 'Y/m/d', 'Date Format', 'ace' ) );
    echo '</time>';
echo '</p>';

// Tax
if ( get_post_type( $post ) === 'post' ) {
    // Category for Post
    echo '<p class="bloginfo-p bloginfo-p-categories">';
        echo '<span class="category">';
            the_category( ',' );
        echo '</span>';
    echo '</p>';

    if ( get_the_terms( absint( $post->ID ), 'post_tag' ) ) {
        echo '<p class="bloginfo-p bloginfo-p-tags">';
            echo '<span>';
                the_tags( '', ',' . SHAPESHIFTER_NBSP );
            echo '</span>';
        echo '</p>';
    }

}

// Excerpt
echo '<div class="bloginfo-excerpt entry-summary">';

    $excerpt = get_the_excerpt();
    $excerpt_length = absint( apply_filters( ace()->getPrefixedFilterHook( 'excerpt_length' ), 200 ) );
    if ( $excerpt !== '' ) {
    } else {
        $excerpt = $post->post_content;
    }
    do_action( ace()->getPrefixedActionHook( 'the_excerpt' ), $excerpt, $excerpt_length );
    unset( $excerpt, $excerpt_length );

    echo '<a class="button read-article" href="'; the_permalink(); echo '">';
        esc_html_e( 'Read More', 'ace' );
    echo '</a>';

echo '</div>';
