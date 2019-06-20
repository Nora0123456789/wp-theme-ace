<?php
# Action Hook "ace_nav_menu"
# Filter Hook "ace_filters_header_nav"

$theme_mods = ace()->getThemeMods();
$navbar = ace()->getFrontendManager()->get_walker_nav_menu_instance( 'navbar' );
$nav_menu_args = array( 
	'theme_location' => 'navbar',
	//'depth' => 2,
	'echo' => false, 
	'fallback_cb' => false,
	'walker' => $navbar
);

$nav_is_mobile = ace_boolval( wp_nav_menu( $nav_menu_args ) === false );

if ( ! wp_is_mobile() ) {

	if ( ! $nav_is_mobile ) {

		$nav_menu_args = array( 
			'container_class' => 'ace-main-nav-div',
			'menu_class' => 'ace-main-nav-menu',
			'theme_location' => 'navbar',
			'depth' => 3,
			'echo' => false, 
			'fallback_cb' => false,
			'walker' => $navbar
		);
		unset( $navbar );

		$nav_menu_output = substr_replace( 
			wp_nav_menu( $nav_menu_args ),
			'<li id="nav-menu-search-box" class="menu-item">' . get_search_form( false ) . '</li>',
			-11,
			0
		);

	} else {

		$mobile_nav_menu = ace()->getFrontendManager()->get_walker_nav_menu_instance( 'mobile_nav_menu' );
		$nav_menu_args = array( 
			'container_class' => 'ace-mobile-nav-div',
			'menu_class' => 'ace-mobile-nav-menu',
			'theme_location' => 'top_nav',
			//'depth' => 2,
			'echo' => false, 
			'fallback_cb' => false,
			'walker' => $mobile_nav_menu
		);
		unset( $mobile_nav_menu );

		$nav_menu_output = substr_replace( 
			wp_nav_menu( $nav_menu_args ),
			'<li id="nav-menu-search-box" class="menu-item">' . get_search_form( false ) . '</li>',
			-11,
			0
		);

	}

} else {

	$nav_is_mobile = true;

	$mobile_nav_menu = ace()->getFrontendManager()->get_walker_nav_menu_instance( 'mobile_nav_menu' );
	$nav_menu_args = array( 
		'container_class' => 'ace-mobile-nav-div',
		'menu_class' => 'ace-mobile-nav-menu',
		'theme_location' => 'top_nav',
		//'depth' => 2,
		'echo' => false, 
		'fallback_cb' => false,
		'walker' => $mobile_nav_menu
	);
	unset( $mobile_nav_menu );

	$nav_menu_output = substr_replace( 
		wp_nav_menu( $nav_menu_args ),
		'<li id="nav-menu-search-box" class="menu-item">' . get_search_form( false ) . '</li>',
		-11,
		0
	);

}
unset( $nav_menu_args );

$top_nav_menu = ace()->getFrontendManager()->top_nav_menu;
$either_primary_or_second = ( 
	$nav_is_mobile 
	? esc_html__( 'Primary Navigation', 'ace' ) 
	: esc_html( 
		'' !== $top_nav_menu 
		? __( 'Secondary Navigation', 'ace' ) 
		: __( 'Primary Navigation', 'ace' ) 
	)
);
$either_main_or_mobile = ( 
	$nav_is_mobile 
	? 'mobile' 
	: 'main' 
);

$nav_classes = array( 'ace-' . esc_attr( $either_main_or_mobile ) . '-nav', 'ace-' . esc_attr( $either_main_or_mobile ) . '-regular-nav' );
if ( $theme_mods['is_nav_menu_fixed'] ) {
	array_push( $nav_classes, 'ace-nav-menu-fixed' );
}
echo '<nav
	aria-label="' . esc_attr( $either_primary_or_second ) . '"
	class="' . esc_attr( implode( ' ', $nav_classes ) ) . '"
>';
	echo '<div
		id="ace-' . esc_attr( $either_main_or_mobile ) . '-nav-wrapper-div"
		class="ace-' . esc_attr( $either_main_or_mobile ) . '-nav-wrapper-div"
	>';
		$theme_mods['is_nav_menu_fixed'] = null;

		echo '<p class="ace-mobile-nav-top-title">' . esc_html__( 'Nav Menu', 'ace' ) . '</p>';

		echo $nav_menu_output;
		unset( $nav_menu_output );

	echo '</div>';
echo '</nav>';

if ( ! $nav_is_mobile ) {
	echo '<div id="div-after-main-nav"></div>';
}
unset( $nav_is_mobile );
