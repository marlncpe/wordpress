<?php
	
function blox_parse_duplicator_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
                'title' => '',
		'total' => '20',
		'number' => '10',
                'number2' => '',
		'icon' => 'icon-smile',
		'color' => '#004cab',
                'color2' => '#ddd',
                'align' => 'left',
                'size' => '20',
                'extra_class' => ''
	), $atts ) );
        
    $html = $title != '' ? '<h3 class="element_title">'.$title.'</h3>' : '';
        
	$html .= "<div class='blox_element blox_element_duplicator $extra_class' style='text-align:$align;font-size:$size"."px'>";
    for($i = 1; $i <= (int)$number; $i++) {
        $html .= "<span class='$icon duplicator_item' style='color:#ddd;' data-color='$color'></span>";
    }
    $total = (int)$total - (int)$number;
    if($number2 != '') {
        for($i = 1; $i <= (int)$number2; $i++)
        $html .= "<span class='$icon duplicator_item' style='color:#ddd;' data-color='$color2'></span>";
        $total = $total - (int)$number2;
    }
    for($i = 1; $i <= $total; $i++) {
        $html .= "<span class='$icon' style='color:#ddd;'></span>";
    }
    $html .= "</div>";
    
    return $html;
}
add_shortcode( 'blox_duplicator', 'blox_parse_duplicator_hook' );

?>