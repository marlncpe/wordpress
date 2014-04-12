<?php

function blox_parse_progress_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'text' => 'Progress Bar',
                'percent' => '60',
                'icon' => 'icon-smile',
                'style' => 'style1',
                'color' => '#000',
                'extra_class' => ''
                    ), $atts));

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

    if ($style == 'style1') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='blox_progress_bar'>
                                    <div class='blox_progress_line_container' style='width: $percent%;'>
                                            <div class='blox_progress_line' style='background-color:$color; box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);'></div>
                                    </div>
                            </div>
                            <span class='blox_progress_icon'><i class='$icon'></i></span>
                            <span class='blox_progress_label'>$percent%</span>
                    </div>";
    } else if ($style == 'style2') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <span class='blox_progress_title'><i class='$icon'></i> $text</span>
                            <span class='blox_progress_label'>$percent%</span>
                            <div class='blox_progress_bar' style='border-color:$color;'>
                                    <div class='blox_progress_line_container' style='width: $percent%;'>
                                            <div class='blox_progress_line' style='background-color:$color;'></div>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style3') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='blox_progress_line_container' style='width: $percent%;'>
                                    <div class='blox_progress_line' style='background-color:$color;'>
                                            <span class='blox_progress_icon'><i class='$icon'></i></span>
                                            <span class='blox_progress_label'>$percent%</span>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style4') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;background-color:$color;'>
                            <div class='blox_progress_line_container' style='width: $percent%;'>
                                    <div class='blox_progress_line'>
                                            <span class='blox_progress_icon'><i class='$icon'></i></span>
                                            <span class='blox_progress_label'>$percent%</span>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style5') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='blox_progress_title'>$text</div>
                            <div class='blox_progress_line_container' style='width: $percent%;'>
                                    <div class='blox_progress_line' style='background-color:$color;'>
                                            <span class='blox_progress_icon'><i class='$icon'></i></span>
                                            <span class='blox_progress_label'>$percent%</span>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style6') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class'>
                            <div class='blox_progress_bar'>
                                    <div class='blox_progress_vline_container' style='height: $percent%;'>
                                            <div class='blox_progress_vline'><span style='background-color: $color;'></span></div>
                                    </div>
                            </div>
                            <span class='blox_progress_percent'>$percent%</span>
                            <span class='blox_progress_title'>$text</span>
                    </div>";
    } else if ($style == 'style7') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='blox_progress_bar'>
                                    <div class='blox_progress_vline_container' style='height: $percent%;'>
                                            <div class='blox_progress_vline' style='background-color:$color;'><span></span></div>
                                    </div>
                            </div>
                            <span class='blox_progress_percent'>$percent%</span>
                            <span class='blox_progress_title'>$text</span>
                    </div>";
    } else if ($style == 'style8') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class'>
                            <span class='blox_progress_percent'>$percent%</span>
                            <span class='blox_progress_title'>$text</span>
                            <div class='blox_progress_bar'>
                                    <div class='blox_progress_vline_container' style='height: $percent%; top: 0px;'>
                                            <div class='blox_progress_vline'><span style='background-color: $color;'></span></div>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style9') {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <span class='blox_progress_percent'>$percent%</span>
                            <span class='blox_progress_title'>$text</span>
                            <div class='blox_progress_bar'>
                                    <div class='blox_progress_vline_container' style='height: $percent%; top: 0px;'>
                                            <div class='blox_progress_vline' style='background-color:$color;'><span></span></div>
                                    </div>
                            </div>
                    </div>";
    } else {
        $result .= "<div class='blox_element blox_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='blox_progress_bar'>
                                    <div class='blox_progress_line' style='width: $percent%; background-color:$color;'>&nbsp;</div>
                            </div>
                            <span class='blox_progress_icon'><i class='$icon'></i></span>
                            <span class='blox_progress_label'>$percent%</span>
                    </div>";
    }

    return $result;
}

add_shortcode('blox_progress', 'blox_parse_progress_hook');
?>