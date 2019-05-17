<?php
$the_title = the_title( '', '', false );
if ( empty( $the_title ) ) {
	$the_title = esc_html__( '( No Title )', 'ace' );
}
echo '<h1 class="post-title">';
	echo '<span class="p-name entry-title">';
		echo $the_title;
	echo '</span>';
echo '</h1>';
