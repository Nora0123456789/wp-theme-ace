<?php 
/**
 * An Article with theme customizer style 3-cols
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
            'class'    => 'archive-article-3-cols ',
            'src'      => $thumbnail_url,
            'data-src' => $thumbnail_url,
            'alt'      => $title
        );
        
?>
<article id="post-<?php echo $post->ID; ?>" <?php post_class( array( 'archive-article', 'style-3-cols' ) ); ?>>
	<div class="archive-article-inner">

        <div class="archive-article-item">
            <div class="archive-article-item-inner">
                <a class="archive-article-link" href="<?php the_permalink(); ?>">
                    <div class="frame-thumbnail">
                        <div class="background-board"></div>
                        <div class="frame-thumbnail-inner clip-rhombus">
                            <?php
                                echo AceFrontendRenderingMethods::getImageTagWithNoScript( $thumbnail_url, 'img', array(
                                    'class' => 'thumbnail',
                                    'alt' => $title,
                                    'width' => absint( $thumbnail_size[0] ),
                                    'height' => absint( $thumbnail_size[1] ),
                                    'desc' => $excerpt,
                                ) );
                            ?>

                            <div class="hover-falling read-more clip-rhombus">
                                <span>Read ?</span>
                            </div>

                        </div>
                    </div>

                    <div class="archive-article-meta">
                        <div class="archive-article-meta-inner article-title">
                            <h2 class="article-title hoverable hover-text-shadow running-underline">
                                <span class="article-title-text"><?php echo $title; ?></span>
                            </h2>
                        </div>

                        <div class="archive-article-meta-inner article-excerpt">
                            <div class="hoverable hover-text-shadow">
                                <p class="archive-article-excerpt"><?php echo $excerpt; ?></p>
                            </div>
                        </div>

                        <div class="archive-article-meta-inner article-date">
                            <time class="dt-published published updated hoverable hover-text-shadow" datetime="<?php the_time(); ?>">
                                <?php the_time(); ?>
                            </time>
                        </div>

                    </div>

                </a>

            </div>
        </div>

    </div>

</article>
