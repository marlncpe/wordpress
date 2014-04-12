<?php

function blox_parse_table_hook($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'button_icon' => '',
        'animation' => '',
        'extra_class' => ''
    ), $atts));

    $animate_class = get_blox_animate_class($animation);

    return '<div class="blox_element blox_elem_price_table '.$animate_class.' ' . $extra_class.' clearfix" button-icon="'.$button_icon.'">' . do_shortcode($content) . '</div>';
}

add_shortcode('blox_table', 'blox_parse_table_hook');

function blox_parse_table_row_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'type' => ''
                    ), $atts));

    return '<div class="blox_table_row" type="' . $type . '">' . do_shortcode($content) . '</div>';
}

add_shortcode('blox_table_row', 'blox_parse_table_row_hook');

function blox_parse_table_cell_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'type' => ''
                    ), $atts));

    return '<div class="blox_table_cell" type="' . $type . '">' . do_shortcode($content) . '</div>';
}

add_shortcode('blox_table_cell', 'blox_parse_table_cell_hook');
?>