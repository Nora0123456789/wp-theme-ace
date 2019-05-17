<?php 
if ( is_home() && is_front_page() ) {
	do_action( ace()->getPrefixedActionHook( 'render_content_home' ) );
} elseif ( is_front_page() ) {
	do_action( ace()->getPrefixedActionHook( 'render_content_front' ) );
} elseif ( is_home() ) { 
	do_action( ace()->getPrefixedActionHook( 'render_content_blog' ) );
} elseif ( function_exists( 'bp_is_blog_page' ) && ! bp_is_blog_page() ) {
	do_action( ace()->getPrefixedActionHook( 'render_content_singular' ) );
} elseif ( function_exists( 'is_woocommerce' )
	&& ( is_woocommerce()
		|| is_cart()
		|| is_checkout()
		|| is_account_page()
		|| is_wc_endpoint_url()
	)
) { // WooCommerce
	if ( is_woocommerce() ) {
		do_action( ace()->getPrefixedActionHook( 'render_wc_page' ) );
	} elseif ( is_cart() ) {
		do_action( ace()->getPrefixedActionHook( 'render_wc_page' ) );
	} elseif ( is_checkout() ) {
		do_action( ace()->getPrefixedActionHook( 'render_wc_page' ) );
	} elseif ( is_account_page() ) {
		do_action( ace()->getPrefixedActionHook( 'render_wc_page' ) );
	} elseif ( is_wc_endpoint_url()	) {
		do_action( ace()->getPrefixedActionHook( 'render_wc_page' ) );
	} else {
		do_action( ace()->getPrefixedActionHook( 'render_wc_page' ) );
	}
} elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) { // bbPress
	if ( bbp_is_forum_archive() 
	|| bbp_is_topic_archive() ) { // Archive
		do_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ) );
	} elseif ( bbp_is_topic_tag() 
	|| bbp_is_topic_tag_edit() ) { // Topic Tags
		do_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ) );
	} elseif ( bbp_is_single_forum() 
	|| bbp_is_single_topic() 
	|| bbp_is_single_reply()
	|| bbp_is_topic_edit()
	|| bbp_is_topic_merge() 
	|| bbp_is_topic_split()
	|| bbp_is_reply_edit() 
	|| bbp_is_reply_move() 
	|| bbp_is_single_view() ) { // Components
		do_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ) );
	} elseif ( bbp_is_single_user_edit()
	|| bbp_is_single_user()
	|| bbp_is_user_home()
	|| bbp_is_user_home_edit()
	|| bbp_is_topics_created()
	|| bbp_is_replies_created()
	|| bbp_is_favorites()
	|| bbp_is_subscriptions() ) { // User
		do_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ) );
	} elseif ( bbp_is_search()
	|| bbp_is_search_results() ) { // Search
		do_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ) );
	} else {
		do_action( ace()->getPrefixedActionHook( 'render_bbpress_page' ) );
	}
} elseif ( is_archive() || is_author() || is_search() ) {
	do_action( ace()->getPrefixedActionHook( 'render_content_archive' ) );
} elseif ( is_singular() ) {
	do_action( ace()->getPrefixedActionHook( 'render_content_singular' ) );
} else {
	echo '<h2 class="not-found-message">' . esc_html__( 'The Required Page doesn\'t exist.', 'ace' ) . '</2><p>' . esc_html__( 'Please try to search for the page with keywords.', 'ace' ) . '</p>';

	get_search_form();
}
