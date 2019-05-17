<?php
# Action Hook "ace_mobile_side_menu"
# Filter Hook "ace_filters_mobile_side_menu"

echo '<div id="mobile-side-menu" class="mobile-side-menu">' . PHP_EOL;
	echo '<div class="mobile-side-menu-inner">';
		AceWidgetAreaManager::renderWidgetAreaMobileMenu();
		do_action( ace()->getPrefixedActionHook( 'render_widget_areas' ), 'is_on_mobile_menu' );
		
		echo '<div class="clearfix"></div>' . PHP_EOL;
	echo '</div>';
echo '</div>';
