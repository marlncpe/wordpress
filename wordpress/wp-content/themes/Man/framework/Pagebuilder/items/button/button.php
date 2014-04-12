<?php

function blox_parse_button_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'text' => 'Button',
                'link' => '#',
                'target' => '0',
                'icon' => '',
                'style' => 'default',
                'border' => '',
                'size' => 'medium',
                'color' => '#004bcc',
                'align' => 'left',
                'extra_class' => '',
                'animation' => ''
                    ), $atts));
    $style = 'blox_elem_button_' . $style;
    $border = 'blox_elem_border_' . $border;
    $size = 'blox_elem_button_'.$size;
    $icon = $icon != '' ? "<i class='$icon'></i>" : '';
    $target = $target == '1' ? '_blank' : '_self';
    
    $text_color = blox_light_dark($color);
    $el_style = "style='background-color:$color;'";
    if($style == 'blox_elem_button_flat')
        $el_style = "style='background-color:transparent;border-color:$color;color:$color;'";
    
    $animate_class = get_blox_animate_class($animation);

    $before = $after = '';
    if($align == 'center') {
        $before = '<div class="blox_element_center">';
        $after = '</div>';
    } else {
        $align = $align == 'right' ? 'pull-right' : '';
    }
    
    return $before . "<a class='blox_elem_button " . $animate_class . ' ' . ($style == 'blox_elem_button_flat' ? $style . ' blox_elem_color_border' : $style . ' blox_elem_color_background') . " $border $size $text_color $align $extra_class' $el_style href='$link' target='$target'>$icon" . ($style == 'blox_elem_button_metro' ? "<span>$text</span>" : $text) . "</a>" . $after;

}

add_shortcode('blox_button', 'blox_parse_button_hook');
?>