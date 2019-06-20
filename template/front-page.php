<?php
if ( have_posts() ) { while( have_posts() ) { the_post(); global $post;
	echo '<article '; post_class( array( 'entry-content hentry' ) ); echo '>';
		if ( has_action( ace()->getPrefixedActionHook( 'render_singular_header' ) ) ) {
			echo '<div class="singular-content-item header">';
				echo '<div class="singular-content-item-inner">';
					do_action( ace()->getPrefixedActionHook( 'render_singular_header' ) );
				echo '</div>';
			echo '</div>';
		}

		do_action( ace()->getPrefixedActionHook( 'render_singular_body' ) );

		if ( has_action( ace()->getPrefixedActionHook( 'render_singular_footer' ) ) ) {
			echo '<div class="singular-content-item footer">';
				echo '<div class="singular-content-item-inner">';
					do_action( ace()->getPrefixedActionHook( 'render_singular_footer' ) );
				echo '</div>';
			echo '</div>';
		}
	echo '</article>';

} }
