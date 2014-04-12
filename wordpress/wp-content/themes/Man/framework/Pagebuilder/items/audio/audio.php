<?php

function blox_parse_audio_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'type' => 'url',
                'url' => '',
                'embed' => '',
                'color' => '#3a87ad',
                'animation' => '',
                'extra_class' => ''
                    ), $atts));


    $animate_class = get_blox_animate_class($animation);

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';
    if ($type == 'url') {
        $result .= get_audio_player($url, $color, $extra_class);
        return $result;
    }
    else{
        return $result."<div class='blox_element blox_elem_audio audio_embed $animate_class $extra_class'>".urldecode($embed)."</div>";
    }

    return $result;
}

add_shortcode('blox_audio', 'blox_parse_audio_hook');
?>