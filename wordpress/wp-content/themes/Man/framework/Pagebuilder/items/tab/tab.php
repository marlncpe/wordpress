<?php

function blox_parse_tab_hook($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'vertical_tab' => '0',
        'border' => '0',
        'animation' => '',
        'extra_class' => ''
    ), $atts));

    $animate_class = get_blox_animate_class($animation);

    return '<div class="blox_element tt_tabs ' . ($vertical_tab == '1' ? 'horizontal_tab' : '') . ' ' . $animate_class . ' '.$extra_class.' ' . ($border == '1' ? 'bordered' : '') . '"><ul class="tab_header"></ul><div class="tab_content">' . do_shortcode($content) . '</div></div>';
}

add_shortcode('blox_tab', 'blox_parse_tab_hook');

function blox_parse_tab_item_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => 'Tab item',
                'icon' => ''
                    ), $atts));
    return '<div class="tab_content_item" title="' . ($icon != '' ? "<i class='$icon'></i>" : '') . $title . '">' . do_shortcode($content) . '</div>';
}

add_shortcode('blox_tab_item', 'blox_parse_tab_item_hook');
?>