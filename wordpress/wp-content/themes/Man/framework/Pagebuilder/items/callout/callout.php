<?php

function blox_parse_callout_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'box_style' => 'blox_elem_callout_clean',
                'margin' => '0',
                'bgcolor' => '#FFFFFF',
                'animation' => '',
                'extra_class' => ''
                    ), $atts));


    $animate_class = get_blox_animate_class($animation);


    $dark_light = '';
    if( $box_style!='blox_elem_callout_clean' && $box_style!='blox_elem_callout_flat' && $box_style!='blox_elem_callout_centered' ){
        $dark_light = get_text_class($bgcolor);
    }

    $callout_content = do_shortcode($content);
    $array = array (
            '<p>' => '', 
            '</p>' => ''
          );
    $callout_content = strtr($callout_content, $array);

    $result = '';
    $result .= "<div class='blox_element blox_elem_callout $box_style $animate_class $dark_light $extra_class clearfix' style='".($box_style == 'blox_elem_callout_metro' ? "background-color:$bgcolor;" : '')."'>
                    <h2>$title</h2>
                    <div class='blox_callout_content' style='margin-right: ".$margin."px;'>$callout_content</div>
                </div>";
    return $result;
}

add_shortcode('blox_callout', 'blox_parse_callout_hook');
?>