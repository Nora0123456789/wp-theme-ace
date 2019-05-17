<?php
# Action Hook "ace_footer_menu_for_mobile"
# Filter Hook "ace_filters_footer_menu_for_mobile"

echo '<div class="action-buttons">';
	do_action( ace()->getPrefixedActionHook( 'render_button_with_icon' ), 'action-buttons' );

	echo '<div class="button-container"><a id="slide-menu" class="menu-button-for-mobile-a" href="javascript:void(0);">';
		echo '<div class="mobile-menu-button-icon-box"><span class="fa fa-list menu-icon"></span></div>';
		echo '<div class="mobile-menu-button-text-box"><span class="menu-text">' . esc_html_x( 'Menu', 'Mobile Button', 'ace' ) . '</span></div>';
	echo '</a><div>';
	echo '<div class="button-container"><a id="widget-area-only-for-mobile" class="menu-button-for-mobile-a" href="' . esc_url( ACE_SITE_URL ) . '">';
		echo '<div class="mobile-menu-button-icon-box"><span class="fa fa-home menu-icon"></span></div>';
		echo '<div class="mobile-menu-button-text-box"><span class="menu-text">' . esc_html_x( 'Home', 'Mobile Button', 'ace' ) . '</span></div>';
	echo '</a></div>';
	echo '<div class="button-container"><a id="bottom-menu-scroll-to-top" class="menu-button-for-mobile-a scroll-to-top" href="javascript:void(0);">';
		echo '<div class="mobile-menu-button-icon-box"><span class="fa fa-arrow-up menu-icon"></span></div>';
		echo '<div class="mobile-menu-button-text-box"><span class="menu-text">' . esc_html_x( 'Top', 'Mobile Button', 'ace' ) . '</span></div>';
	echo '</a></div>';
	if( wp_is_mobile() ) {
		echo '<div class="button-container"><a id="mobile-side-menu" class="menu-button-for-mobile-a" href="javascript:void(0);">';
			echo '<div class="mobile-menu-button-icon-box"><span class="fa fa-object-group menu-icon"></span></div>';
			echo '<div class="mobile-menu-button-text-box"><span class="menu-text">' . esc_html_x( 'Widgets', 'Mobile Button', 'ace' ) . '</span></div>';
		echo '</a></div>';
	}
echo '</div>';
