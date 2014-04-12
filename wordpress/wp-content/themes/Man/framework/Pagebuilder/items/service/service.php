<?php

function blox_parse_service_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'icon' => '',
                'icon_size' => '48',
                'color' => '',
                'bgcolor' => '',
                'layout' => 'style1',
                'animation' => 'none',
                'extra_class' => ''
                    ), $atts));
    
    $icon_img = '';
    $color = "color:$color;";
    
    // If the style allows icon size
    if(in_array($layout, array('style3','style4','style5','style6','style7','style8','style9') ))
        $icon_size = 'font-size:'.$icon_size.'px;';
    else
        $icon_size = '';
    
    
    if (filter_var($icon, FILTER_VALIDATE_URL)) {
        $icon_img = "<span class='service_image'><img src='$icon' /></span>";
    } else if (in_array($layout, array('style1', 'style2', 'style3', 'style4', 'style5', 'style6', 'style7', 'style8', 'style11'))) {
        $icon_img = "<span class='service_icon $icon' style='$color$icon_size'></span>";
    } else {
        $icon_img = "<span class='service_icon $icon'></span>";
    }

    $animate_class = get_blox_animate_class($animation);

    if ($layout == 'style2') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class'>
                        $icon_img
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style3') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class'>
                        $icon_img
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style4') {
        return "<div class='blox_element blox_elem_service $layout " . blox_light_dark($bgcolor) . " $animate_class $extra_class' style='box-shadow: inset 0 0 0 3px $bgcolor; background-color:" . blox_hex2rgba($bgcolor, 0.8) . ";'>
                        $icon_img
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style5') {
        return "<div class='blox_element blox_elem_service $layout " . blox_light_dark($bgcolor) . " $animate_class $extra_class' style='box-shadow: inset 0 0 0 3px $bgcolor; background-color:" . blox_hex2rgba($bgcolor, 0.8) . ";'>
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                        $icon_img
                </div>";
    } else if ($layout == 'style6') {
        return "<div class='blox_element blox_elem_service $layout " . blox_light_dark($bgcolor) . " $animate_class $extra_class' style='box-shadow: inset 0 0 0 3px $bgcolor; background-color:" . blox_hex2rgba($bgcolor, 0.8) . ";'>
                        <h3>$title</h3>
                        $icon_img
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style7') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class' style='border-color:" . blox_hex2rgba($bgcolor) . ";'>
                        <h3>$title</h3>
                        $icon_img
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style8') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class' style='border-color:" . blox_hex2rgba($bgcolor) . ";'>
                        $icon_img
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style9') {
        return "<div class='blox_element blox_elem_service $layout " . blox_light_dark($bgcolor) . " $animate_class $extra_class' style='background-color:" . blox_hex2rgba($bgcolor, 0.8) . "; border:1px solid $bgcolor;'>
                        <span class='service_rectangle " . blox_light_dark($bgcolor) . "' style='background-color: $bgcolor; border: 1px solid rgba(0,0,0,.03);'>$icon_img</span>
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style10') {
        return "<div class='blox_element blox_elem_service $layout " . blox_light_dark($bgcolor) . " $animate_class $extra_class' style='background-color:" . blox_hex2rgba($bgcolor, 0.8) . "; border:1px solid $bgcolor;'>
                        <span class='service_rectangle " . blox_light_dark($bgcolor) . "' style='background-color: $bgcolor; border: 1px solid rgba(0,0,0,.03);'>$icon_img</span>
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style11') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class' style='box-shadow: inset 0 0 0 1px $bgcolor;'>
                        <span class='service_rectangle' style='box-shadow: inset 0 0 0 1px $bgcolor; color:$color;'>$icon_img</span>
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style12') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class' style='box-shadow: inset 0 0 0 1px $bgcolor;'>
                        <span class='service_rectangle " . blox_light_dark($bgcolor) . "' style='background-color:$bgcolor;'>$icon_img</span>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style13') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class' style='box-shadow: inset 0 0 0 1px $bgcolor;'>
                        <span class='service_rectangle " . blox_light_dark($bgcolor) . "' style='background-color:$bgcolor;'>$icon_img</span>
                        <div class='service_text'>".do_shortcode($content)."</div>
                </div>";
    } else if ($layout == 'style14') {
        return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class' style='border-color:" . blox_hex2rgba($bgcolor) . ";'>
                        <h3>$title</h3>
                        <div class='service_text'>".do_shortcode($content)."</div>
                        $icon_img
                </div>";
    }
    return "<div class='blox_element blox_elem_service $layout $animate_class $extra_class'>
                    $icon_img
                    <h3>$title</h3>
                    <div class='service_text'>".do_shortcode($content)."</div>
            </div>";
}

add_shortcode('blox_service', 'blox_parse_service_hook');
?>