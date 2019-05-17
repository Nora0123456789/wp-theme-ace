<?php
// Layout
    $wp_customize->add_section( 'section_layout_general', array(
        'title' => esc_html__( 'Page Layout General', 'ace' ),
        'panel' => 'panel_layout',
    ));

    // Columns
        $columns = array( 
            'column_left' => array(
                'name' => esc_html__( 'Column Left Container', 'ace' ),
            ),
            'main_content' => array(
                'name' => esc_html__( 'Main Content', 'ace' ),
            ),
            'column_right' => array(
                'name' => esc_html__( 'Column Right Container', 'ace' ),
            ),
        );

        foreach( $columns as $id => $data ) {

            $max_width_min = in_array( $id, array( 'main_content' ) ) ? 768 : 200;
            $max_width_default = in_array( $id, array( 'main_content' ) ) ? 768 : 300;
            $max_width_max = in_array( $id, array( 'main_content' ) ) ? 1000 : 500;

            // Width
                $wp_customize->add_setting( $id . '_max_width', array(
                    'default' => $max_width_default,
                    'capability' => 'edit_theme_options',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'absint',
                    'sanitize_js_callback' => 'absint',
                ));
                $wp_customize->add_control( $id . '_max_width', array(
                    'section' => 'section_layout_general',
                    'settings' => $id . '_max_width',
                    'label' => sprintf( __( 'Width of %s', 'ace' ), $data[ 'name' ] ),
                    'type' => 'range',
                    'description' => '',
                    'input_attrs' => array(
                        'min' => $max_width_min,
                        'max' => $max_width_max,
                        'step' => 1,
                        'value' => absint( $this->themeMods[ $id . '_max_width' ] ),
                        'id' => $id . '_max_width_id',
                        'style' => 'width:100%;',
                    ),
                ));

        }

