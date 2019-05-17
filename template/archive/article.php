<?php global $post;
/**
 * An Article without style
**/

echo '<article id="post-'; echo $post->ID; echo '" '; post_class( 'archive-article' ); echo '>';
	echo '<div class="archive-article-inner">';
		echo '<a class="archive-article-link" href="'; the_permalink(); echo '">';

			if ( has_action( ace()->getPrefixedActionHook( 'render_archive_article_header' ) ) ) {
				echo '<div class="archive-article-item" data-name="header">';
					echo '<div class="archive-article-item-inner">';
						do_action( ace()->getPrefixedActionHook( 'render_archive_article_header' ) );
					echo '</div>';
				echo '</div>';
			}

			if ( has_action( ace()->getPrefixedActionHook( 'render_archive_article_body' ) ) ) {
				echo '<div class="archive-article-item" data-name="body">';
					echo '<div class="archive-article-item-inner">';
						do_action( ace()->getPrefixedActionHook( 'render_archive_article_body' ) );
					echo '</div>';
				echo '</div>';
			}

			if ( has_action( ace()->getPrefixedActionHook( 'render_archive_article_footer' ) ) ) {
				echo '<div class="archive-article-item" data-name="footer">';
					echo '<div class="archive-article-item-inner">';
						do_action( ace()->getPrefixedActionHook( 'render_archive_article_footer' ) );
					echo '</div>';
				echo '</div>';
			}

			if ( has_action( ace()->getPrefixedActionHook( 'render_archive_article_optional' ) ) ) {
				echo '<div class="archive-article-item" data-name="optional">';
					echo '<div class="archive-article-item-inner">';
						do_action( ace()->getPrefixedActionHook( 'render_archive_article_optional' ) );
					echo '</div>';
				echo '</div>';
			}

		echo '</a>';
	echo '</div>';
echo '</article>';
