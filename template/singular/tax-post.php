<?php global $post;

// Post Data
    // Category
    $category = get_the_category();

    // Tags
    $cats = get_the_category( absint( $post->ID ) );
    $tags = get_the_category( absint( $post->ID ) );

    // Permalink
        $article_link = get_the_permalink();

    // Post
        $title = the_title( '', '', false );
        $title = ( ! empty( $title ) ? $title : esc_html__( '( No Title )', 'ace' ) );
        $excerpt = get_the_excerpt();
    
    // Thumbnail
        $thumbnail_url = get_the_post_thumbnail_url( $post, 'archive-article-card' );
        if ( false === $thumbnail_url ) {
            $thumbnail_url = get_theme_mod( 'default_thumbnail', ACE_DIR_URL . 'assets/img/no-img-dark.png' );
        }
        $thumbnail_size = apply_filters( ace()->getPrefixedFilterHook( 'thumbnail_size' ), array( 100, 100 ), $post );
        $thumbnail_atts = array(
            'class'    => 'archive-article-card ',
            'src'      => $thumbnail_url,
            'data-src' => $thumbnail_url,
            'alt'      => $title
        );
        
?>
<div class="singular-after-title-inner article-author">
    <span class="label"><?php esc_html_e( 'Author', 'ace' ); ?></span>
    <span class="vcard author hoverable hover-text-shadow">
        <a class="fn url" href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>">
            <?php echo esc_html( get_the_author() ); ?>
        </a>
    </span>
</div>

<div class="singular-after-title-inner article-date">
    <span class="label"><?php esc_html_e( 'Date', 'ace' ); ?></span>
    <time class="dt-published published updated hoverable hover-text-shadow" datetime="<?php the_time(); ?>">
        <?php the_time(); ?>
    </time>
</div>

<?php if ( isset( $category[0] ) ) { $top_category_name = $category[0]->cat_name; ?>
    <div class="singular-after-title-inner article-category">
        <span class="label"><?php esc_html_e( 'Categories', 'ace' ); ?></span>
        <span class="categories hoverable hover-text-shadow">
            <?php the_category( ',' ); ?>
        </span>
    </div>
<?php } ?>

<?php if ( get_the_terms( absint( $post->ID ), 'post_tag' ) ) { ?>
    <div class="singular-after-title-inner article-tags">
        <span class="label"><?php esc_html_e( 'Tags', 'ace' ); ?></span>
        <span class="tags hoverable hover-text-shadow">
            <?php the_tags( '', ',' ); ?>
        </span>
    </div>
<?php } ?>

