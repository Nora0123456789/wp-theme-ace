<?php
/**
 * Archive Page Content Part in 3-cols style
**/

do_action( ace()->getPrefixedActionHook( 'render_archive_start' ) );

get_template_part( 'template/archive/header' );

do_action( ace()->getPrefixedActionHook( 'render_before_archive' ) );

if ( have_posts() ) { 
	$articles_class = array( 'articles', 'post-list', 'list-in-' . get_theme_mod( 'main_archive_article_type', 'card' ) );
	echo '<div class="' . esc_attr( implode( ' ', $articles_class ) ) . '">';
		while( have_posts() ) { the_post();
			do_action( ace()->getPrefixedActionHook( 'render_archive_article' ) );
		} 
	echo '</div>';
} else { 
	echo '<h2 class="not-found-message">' . esc_html__( 'No Articles.', 'ace' ) . '</h3>';
	echo '<p>' . esc_html__( 'Please try to search for the page with keywords.', 'ace' ) . '</p>';
	get_search_form();
}

do_action( ace()->getPrefixedActionHook( 'render_archive_end' ) );
