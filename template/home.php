<?php

do_action( ace()->getPrefixedActionHook( 'render_archive_start' ) );



do_action( ace()->getPrefixedActionHook( 'render_before_archive' ) );

if ( have_posts() ) { 
	echo '<div class="articles post-list">';
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

