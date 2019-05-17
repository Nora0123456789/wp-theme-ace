<?php

echo '<div class="search-form-wrapper">';
    echo '<div class="search-form-inner">';

        echo '<form class="search-form" action="' . esc_url( get_site_url() ) . '" method="get">'; 

            echo '<div class="search-inner hoverable running-underline">';

                echo '<input name="s" type="text" class="search-box search-box-text-field" placeholder="' . __( 'Search', 'ace' ) . '" aria-label="' . __( 'Search Keywords', 'ace' ) . '">';

                echo '<button class="search-button" aria-label="' . __( 'Search', 'ace' ) . '">';
                    echo '<span class="nora-glyph circle arrow right"></span>';
               echo '</button>';

            echo '</div>';


        echo '</form>';

    echo '</div>';
echo '</div>';


