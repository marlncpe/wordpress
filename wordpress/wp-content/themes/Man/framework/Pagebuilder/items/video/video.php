<?php

function blox_parse_video_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'type' => 'url',
                'url' => '',
                'poster' => '',
                'embed' => '',
                'color' => '#3a87ad',
                'extra_class' => ''
                    ), $atts));

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';
    
    if( $type == 'url' ){
        if ($url != '' && wp_oembed_get($url) !== false) {
            // Embed convertion
            $result .= wp_oembed_get($url);
        } else {
            $result .= get_video_player($url, $color, $extra_class, $poster);
        }

        return $result;
    }
    else{
        return $result."<div class='blox_element blox_elem_video video_embed $extra_class'>".urldecode($embed)."</div>";
    }
    
    return $result;
}

add_shortcode('blox_video', 'blox_parse_video_hook');
?>