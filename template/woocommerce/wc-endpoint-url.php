<?php
echo '<article '; post_class( 'h-entry' ); echo '>';

	if ( have_posts() ) { while( have_posts() ) { the_post();

		do_action( ace()->getPrefixedActionHook( 'render_wc_header' ) );

		echo '<div class="woocommerce-endpoint">';
		
		the_content();

		echo '</div>';

	} } else { esc_html_e( 'No Posts.', 'ace' ); }

echo '</article>';
