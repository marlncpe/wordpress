<?php

function blox_parse_heading_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'size' => 'h3',
		'icon' => '',
		'style' => '',
		'color' => '#000000',
		'animation' => '',
		'extra_class' => ''
	), $atts ) );

	$animate_class = get_blox_animate_class($animation);

	
	switch($style){
		case 'style1':
			return '<div class="blox_element blox_elem_heading '.$style . ' '. $animate_class.' '. $extra_class .'">
						<table style="width:100%;">
							<tr>
								<td style="width:25%;"><span style="background-color:'.$color.'">&nbsp;</span></td>
								<td style="width:50%;"><'.$size.' style="border-color:'.$color.'">'.$title.'</'.$size.'></td>
								<td style="width:25%;"><span style="background-color:'.$color.'">&nbsp;</span></td>
							</tr>
						</table>
					</div>';
			break;
		case 'style2':
			return '<div class="blox_element blox_elem_heading '.blox_light_dark($color).' '.$style . ' '. $animate_class.' '. $extra_class .'" style="background-color:'.$color.';">
						<span class="heading-icon"><i class="'.$icon.'"></i></span>
						<div class="heading-content">
							<'.$size.'>'.$title.'</'.$size.'>
							<p>'.do_shortcode($content).'</p>
						</div>
					</div>';
			break;
		case 'style3':
			return '<div class="blox_element blox_elem_heading '.$style . ' '. $animate_class.' '. $extra_class .'">
						<span class="heading-icon"><i class="'.$icon.'"></i></span>
						<div class="heading-content">
							<'.$size.'>'.$title.'</'.$size.'>
							<p>'.do_shortcode($content).'</p>
						</div>
					</div>';
			break;
		case 'style4':
			return '<div class="blox_element blox_elem_heading '.$style . ' '. $animate_class.' '. $extra_class .'">
						<'.$size.'><i class="'.$icon.'"></i> '.$title.'</'.$size.'>
						<p>'.do_shortcode($content).'</p>
					</div>';
			break;
		case 'style5':
			return '<div class="blox_element blox_elem_heading '.$style . ' '. $animate_class.' '. $extra_class .'">
						<'.$size.'>'.$title.'</'.$size.'>
						<p>'.do_shortcode($content).'</p>
					</div>';
			break;
		default:
			return '<div class="blox_element blox_elem_heading '.$style . ' '. $animate_class.' '. $extra_class .'">
						<table style="width:100%;">
							<tr>
								<td style="width:25%;"><span style="background-color:'.$color.'">&nbsp;</span></td>
								<td style="width:50%;"><'.$size.'>'.$title.'</'.$size.'></td>
								<td style="width:25%;"><span style="background-color:'.$color.'">&nbsp;</span></td>
							</tr>
						</table>
						<p>'.do_shortcode($content).'</p>
					</div>';
			break;
	}

	return '';
}
add_shortcode( 'blox_heading', 'blox_parse_heading_hook' );

?>