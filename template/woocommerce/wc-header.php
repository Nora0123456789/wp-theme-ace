<?php
# Action Hook "ace_wc_header"
# Filter Hook "ace_filters_wc_header"
global $post;
$title_el = 'h1';
if ( is_front_page() ) {
	$title_el = 'h2';
}
echo '<div class="woocommerce-header">';
	echo '<' . $title_el . ' class="singular-title">';
		echo '<span class="p-name entry-title singular-title-text">';
			esc_html( $post->post_title );
		echo '</span>';
	echo '</' . $title_el . '>';
echo '</div>';

