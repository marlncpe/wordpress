<?php

function blox_testimonial_hook( $atts, $content=null ) {
    extract( shortcode_atts( array(
        'title' => '',
        'type' => 'single_color',
        'color' => 'transparent',
        'animation' => '',
        'extra_class' => ''
    ), $atts ) );

    $animate_class = get_blox_animate_class($animation);

    if( $type == 'full_color' ){
        return '<div class="blox_element blox_testimonial '.$type.' '.$animate_class. ' '.blox_light_dark($color).' '.$extra_class.'" style="background-color:'.blox_hex2rgba($color, 0.8).'; border-color:'.$color.';">
                    <div class="testimonial_wrapper">
                        '.do_shortcode($content).'
                    </div>
                </div>';
    }

    return '<div class="blox_element blox_testimonial '.$type.' '.$animate_class.' '.$extra_class.'" bgcolor="'.$color.'" light_dark="'.blox_light_dark($color).'">
                <div class="testimonial_wrapper">
                    '.do_shortcode($content).'
                </div>
            </div>';
}
add_shortcode( 'blox_testimonial', 'blox_testimonial_hook' );


function blox_testimonial_item_hook( $atts, $content=null ) {
    extract( shortcode_atts( array(
        'author' => '',
        'position' => '',
        'company' => '',
        'image' => ''
    ), $atts ) );

    $img = $image!='' ? "<span class='img'><img src='".blox_aq_resize($image, 38, 38, true)."' alt='Author'/></span>" : '';

    return '<div class="testimonial_item">
                <div class="testy_desc">
                    '.do_shortcode($content).'
                </div>
                <div class="testy_meta">
                    '.$img.'
                    <span class="author">
                        <h3>'.$author.'</h3>
                        <span class="position">'.$position.'</span>
                        <span class="company">'.$company.'</span>
                    </span>
                    <span class="testy_actions">
                        <a href="javascript:;" class="testy_prev"><i class="icon-chevron-left"></i></a>
                        <a href="javascript:;" class="testy_next"><i class="icon-chevron-right"></i></a>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>';
}
add_shortcode( 'blox_testimonial_item', 'blox_testimonial_item_hook' );


?>