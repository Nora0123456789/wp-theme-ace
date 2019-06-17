<?php
/**
 * An Article with theme customizer style Slider
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

?>
<article id="post-<?php echo $post->ID; ?>" <?php post_class( array( 'archive-article', 'style-slider', 'swiper-slide' ) ); ?>>
	<div class="archive-article-inner">

        <div class="archive-article-item article-thumbnail">
            <div class="archive-article-item-inner article-thumbnail">
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

                <div class="archive-article-date-publish">
                    <div class="archive-article-date-publish-inner">
                        <time class="dt-published published updated hoverable hover-text-shadow" datetime="<?php the_date(); ?>">
                            <?php the_date(); ?>
                        </time>
                    </div>
                </div>
            </div>
        </div>

        <div class="archive-article-item article-meta">
            <div class="archive-article-item-inner article-meta-wrapper">

                <div class="archive-article-item-meta article-title">
                    <h2 class="article-title">
                        <a class="archive-article-link" href="<?php the_permalink(); ?>">
                            <span class="article-title-text"><?php echo $title; ?></span>
                        </a>
                    </h2>
                </div>
                <div class="archive-article-item-meta article-excerpt">
                    <div class="hoverable hover-text-shadow">
                        <p class="archive-article-excerpt"><?php echo $excerpt; ?></p>
                    </div>
                </div>

                <div class="archive-article-item-meta archive-article-read-more-button">
                    <a class="read-more-button" href="<?php echo esc_url( $article_link ); ?>">
                        <?php esc_html_e( 'Read More', 'ace' ); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

</article>
