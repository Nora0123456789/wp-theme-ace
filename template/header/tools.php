<?php
if ( ! wp_is_mobile() ) {

    echo '<div class="header-tools">';

        if ( has_action( ace()->getPrefixedActionHook( 'render_widgets_in_header' ) ) ) {
            echo '<div class="header-tool widget-area-wrapper">';
                do_action( ace()->getPrefixedActionHook( 'render_widgets_in_header' ) );
            echo '</div>';
        }

        if ( has_action( ace()->getPrefixedActionHook( 'render_optional_tools_in_header' ) ) ) {
            do_action( ace()->getPrefixedActionHook( 'render_optional_tools_in_header' ) );
        }

    echo '</div>';

} else {

    echo '<div class="header-tools">';
    
    if ( has_action( ace()->getPrefixedActionHook( 'render_widgets_in_header' ) ) ) {
        echo '<div class="header-tool widget-area-wrapper">';
            do_action( ace()->getPrefixedActionHook( 'render_widgets_in_header' ) );
        echo '</div>';
    }

    echo '</div>';

}
