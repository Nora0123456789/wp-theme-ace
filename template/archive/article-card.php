<?php
/**
 * An Article with theme customizer style card
**/
global $post;

// Post Data
    // Category
        $category = get_the_category();

    // Tags

    // Permalink
        $article_link = get_the_permalink();

    // Post
        $title = the_title( '', '', false );
        $title = ( ! empty( $title ) ? $title : esc_html__( '( No Title )', 'ace' ) );
        $excerpt = get_the_excerpt();

    // Thumbnail
        $thumbnail_url = get_the_post_thumbnail_url( $post, 'archive-article-200' );
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
<article id="post-<?php echo $post->ID; ?>" <?php post_class( array( 'archive-article', 'style-card', 'rotate3d-up-right-20' ) ); ?>>
	<div class="archive-article-inner">

        <div class="archive-article-item article-thumbnail">
            <div class="archive-article-item-inner">
                <div class="frame-thumbnail hoverable zoomable">
                    <a class="archive-article-link" href="<?php the_permalink(); ?>">

                        <?php
                            echo AceFrontendRenderingMethods::getImageTagWithNoScript( $thumbnail_url, 'img', array(
                                'class' => 'thumbnail',
                                'alt' => $title,
                                'width' => absint( $thumbnail_size[0] ),
                                'height' => absint( $thumbnail_size[1] ),
                                'desc' => $excerpt,
                            ) );
                        ?>
                    </a>
                    <?php if ( isset( $category[0] ) ) { $top_category_name = $category[0]->cat_name; ?>
                        <div class="archive-article-thumbnail-label article-category">
                            <a href="<?php echo esc_url( get_category_link( $category[0] ) ); ?>">
                                <span class="category">
                                    <?php echo $top_category_name; ?>
                                </span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="archive-article-item article-meta">
            <div class="archive-article-item-inner article-title">
                <h2 class="article-title hoverable hover-text-shadow running-underline">
                    <a class="archive-article-link" href="<?php the_permalink(); ?>">
                        <span class="article-title-text"><?php echo $title; ?></span>
                    </a>
                </h2>
            </div>
            <div class="archive-article-item-inner article-excerpt">
                <div class="hoverable hover-text-shadow">
                    <p class="archive-article-excerpt"><?php echo $excerpt; ?></p>
                </div>
            </div>
            <?php if ( isset( $category[0] ) ) { $top_category_name = $category[0]->cat_name; ?>
                <div class="archive-article-item-inner article-category">
                    <span class="category hoverable hover-text-shadow">
                        <?php the_category( ',' ); ?>
                    </span>
                </div>
            <?php } ?>
            <?php if ( get_the_terms( absint( $post->ID ), 'post_tag' ) ) { ?>
                <div class="archive-article-item-inner article-tags">
                    <span class="tags hoverable hover-text-shadow">
                        <?php the_tags( '', ',' ); ?>
                    </span>
                </div>
            <?php } ?>

            <div class="archive-article-item-inner article-date">
                <time class="dt-published published updated hoverable hover-text-shadow" datetime="<?php the_date(); ?>">
                    <?php the_date(); ?>
                </time>
            </div>
            <div class="archive-article-item-inner article-author">
                <span class="vcard author hoverable hover-text-shadow">
                    <a class="fn url" href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>">
                        <?php echo esc_html( get_the_author() ); ?>
                    </a>
                </span>
            </div>
        </div>
    </div>

</article>
