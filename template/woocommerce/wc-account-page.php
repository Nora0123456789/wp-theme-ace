<?php
if ( ! defined( 'ABSPATH' ) ) exit();

global $wp;
$menu_key = 'dashboard';
foreach ( $wp->query_vars as $key => $value ) {
	if ( 'pagename' === $key ) {
		continue;
	}
	$menu_key = $key;
} unset( $key );

if ( have_posts() ) { while( have_posts() ) { the_post();

	echo '<h1 class="woocommerce-my-account-title ' . $menu_key . '">' . _x( 'Your Account', 'WooCommerce Endpoint', 'ace' ) . '</h1>';

	$titles = wp_parse_args( wc_get_account_menu_items(), array(
		'view-order' => _x( 'Order Details', 'WC Account Page', 'ace' ),
		'add-payment-method' => _x( 'Add Payment Method', 'WC Account Page', 'ace' ),
	) );
	$menu_title = isset( $titles[ $menu_key ] ) ? $titles[ $menu_key ] : $titles['dashboard'];

	unset( $titles );

	do_action( ace()->getPrefixedActionHook( 'render_in_wc_endpoint_content_header' ), $menu_key, $menu_title );

	add_action( 'woocommerce_account_content', function() use ( $menu_title, $menu_key ) {
		echo '<h2 class="woocommerce-my-account-menu-title ' . $menu_key . '">' . $menu_title . '</h2>';
	}, 0 );

	do_action( ace()->getPrefixedActionHook( 'render_wc_header' ) );

	echo '<div class="woocommerce-my-account">';
	
	the_content();

	echo '</div>';

} } else { esc_html_e( 'No Posts.', 'ace' ); }

