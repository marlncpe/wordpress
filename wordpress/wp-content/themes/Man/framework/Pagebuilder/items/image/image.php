<?php
	
function blox_parse_image_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'style' => 'blox_elem_image_frame_border',
		'image' => '',
		'caption' => '',
		'color' => '',
		'link' => '',
        'target' => '0',
        'animation' => '',
        'extra_class' => ''
	), $atts ) );

        $rel = ($link == '') ? 'rel="prettyPhoto"' : '';
        $link = ($link != '') ? $link : $image;
        
	$animate_class = get_blox_animate_class($animation);
	$target = $target == '1' ? '_blank' : '_self';


	if( $style=='blox_elem_image_frame_border' ){
		return '<div class="blox_element blox_elem_image_frame blox_elem_image_frame_colored blox_elem_image_frame_caption_image '.$animate_class.' '. $extra_class .'" style="background-color: '.$color.';">
					<div class="blox_elem_image_frame_border">
						<a class="algin-left clearfix" href="'.$link.'" '.$rel.' target="'.$target.'">
							<div class="blox_elem_image_frame_hover">
								<i class="icon-picture"></i>
							</div>
							<img src="'.$image.'" alt="" class="frame"/>
								<p class="blox_elem_caption_text">'.$caption.'</p>
						</a>
					</div>
				</div>';
	}

	return '<div class="blox_element blox_elem_image_frame '.$animate_class.' '. $extra_class .'">
				<div class="blox_elem_image_frame_border blox_elem_image_frame_radius blox_elem_image_frame_bordered blox_elem_image_frame_no_border">
					<a class="algin-left clearfix" href="'.$link.'" title="" '.$rel.' target="'.$target.'">
						<div class="blox_elem_image_frame_hover">
							<i class="icon-picture"></i>
						</div>
						<img src="'.$image.'" alt="" class="frame"/>
					</a>
				</div>
				<p class="blox_elem_caption_text">'.$caption.'</p>
			</div>';
}
add_shortcode( 'blox_image', 'blox_parse_image_hook' );

?>