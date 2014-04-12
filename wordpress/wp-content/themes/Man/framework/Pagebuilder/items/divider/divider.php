<?php

function blox_parse_divider_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'text' => 'Top',
                'style' => 'style1',
                'color' => '#00b4cc',
                'height' => '5',
                'extra_class' => ''
                    ), $atts));
    $height_style = "style='height:$height" . "px'";
    $custom_style = "style='height:$height" . "px;background-color:$color'";
    
    if ($style == 'style1')
        return "<div class='blox_element blox_elem_divider style1 $extra_class'></div>";
    elseif ($style == 'style2')
        return "<div class='blox_element blox_elem_divider style2 $extra_class'></div>";
    elseif ($style == 'style3')
        return "<div class='blox_element blox_elem_divider style3 $extra_class'></div>";
    elseif ($style == 'style4')
        return "<div class='blox_element blox_elem_divider style4 $extra_class'></div>";
    elseif ($style == 'style5')
        return "<div class='blox_element blox_elem_divider style5 $extra_class'></div>";
    elseif ($style == 'style6')
        return "<div class='blox_element blox_elem_divider style6 $extra_class'><span class='gototop'>$text <i class='icon-arrow-up'></i></div>";
    elseif ($style == 'style7')
        return "<div class='blox_element blox_elem_divider style7 $extra_class' $custom_style></div>";
    elseif ($style == 'style8')
        return "<div class='blox_element blox_elem_divider style8 $extra_class' $custom_style></div>";
    elseif ($style == 'style9')
        return "<div class='blox_element blox_elem_divider style9 $extra_class'></div>";
    elseif ($style == 'style11')
        return "<div $height_style></div>";
    else
        return "<div class='blox_element blox_elem_divider style10 $extra_class'></div>";
}

add_shortcode('blox_divider', 'blox_parse_divider_hook');
?>