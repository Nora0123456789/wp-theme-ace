<?php

if ( is_shop() ) { // The main shop
	do_action( ace()->getPrefixedActionHook( 'render_wc_shop' ) );
} elseif ( is_product_category() ) { // A product category
	do_action( ace()->getPrefixedActionHook( 'render_wc_product_taxonomy' ) );
} elseif ( is_product_tag() ) { // A product tag
	do_action( ace()->getPrefixedActionHook( 'render_wc_product_taxonomy' ) );
} elseif ( is_product() ) { // A single product
	do_action( ace()->getPrefixedActionHook( 'render_wc_single_product' ) );
} elseif ( is_cart() ) { // The cart
	do_action( ace()->getPrefixedActionHook( 'render_wc_cart' ) );
} elseif ( is_checkout() ) { // The checkout
	do_action( ace()->getPrefixedActionHook( 'render_wc_checkout' ) );
} elseif ( is_account_page() ) { // Customer account
	do_action( ace()->getPrefixedActionHook( 'render_wc_account_page' ) );
} elseif ( is_wc_endpoint_url() ) { // An endpoint
	do_action( ace()->getPrefixedActionHook( 'render_wc_wc_endpoint_url' ) );
} else {
	do_action( ace()->getPrefixedActionHook( 'render_wc_single_product' ) );
}
