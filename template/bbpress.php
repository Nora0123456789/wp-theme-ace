<?php
if ( have_posts() ) { while( have_posts() ) { the_post(); global $post;
	$post_type = get_post_type( $post->ID );
	echo '<div class="bbpress-content">';
		the_content();
	echo '</div>';
} } else { esc_html_e( 'No Post', 'ace' ); }
