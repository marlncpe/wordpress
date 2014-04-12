<?php
	
function blox_parse_list_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
        'icon' => 'icon-user',
		'color' => '',
        'animation' => '',
        'extra_class' => ''
	), $atts ) );

	$result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';
	$animate_class = get_blox_animate_class($animation);

	$lis = str_replace('<p>', '', $content);
	$lis = str_replace('</p>', '', $lis);
	$lis = str_replace('<li>', '', $lis);
	$lis = str_replace('<ul>', '', $lis);
	$lis = str_replace('</ul>', '', $lis);

	$result .= "<div class='blox_element blox_element_list $animate_class $extra_class'><ul>";

	$list = explode('</li>', $lis);
	if( count($list)-1 > 0 ){
		for($i=0; $i<count($list)-1; $i++){
			$result .= "<li><span class='$icon' style='color:$color;'></span> $list[$i]</li>";
		}
	}
	$result .= '</ul></div>';

	return $result;
}
add_shortcode( 'blox_list', 'blox_parse_list_hook' );

?>