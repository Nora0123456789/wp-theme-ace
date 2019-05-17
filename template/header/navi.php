<?php
echo '<div id="header-mobile-navi-trigger" class="header-mobile-navi-trigger">';
	echo '<a class="header-mobile-navi-trigger-icons" href="javascript: void(0);" aria-label="' . esc_attr__( 'Navi Menu', 'ace' ) . '">';
		echo '<span class="header-mobile-navi-trigger-icon top-line"></span>';
		echo '<span class="header-mobile-navi-trigger-icon middle-line"></span>';
		echo '<span class="header-mobile-navi-trigger-icon bottom-line"></span>';
	echo '</a>';
echo '</div>';
echo '<nav id="header-navi" class="navi header">';

	echo '<div class="header-navi-button-close">';
		echo '<div class="header-navi-button-close-inner">';
			echo '<a class="header-navi-button close" href="javascript:void(0);" aria-label="' . esc_attr__( 'Close Navi Menu', 'ace' ) . '">';
				echo '<svg class="header-navi-button-icon"><use xlink:href="#iconPlus"></use></svg>';
			echo '</a>';
		echo '</div>';
	echo '</div>';

	do_action( ace()->getPrefixedActionHook( 'render_header_navi_share_tools' ) );

	/**
	* Displays a navigation menu.
	*
	* @since 3.0.0
	*/
	AceFrontendNavMenuMethods::renderHeaderNavMenu();

echo '</nav>';


