<?php


function blox_parse_accordion_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'extra_class' => '',
		'animation' => '',
		'border' => '',
                'extra_class' => ''
	), $atts ) );

	$title = isset($title) && $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

	$animate_class = get_blox_animate_class($animation);

	return $title."<div class='blox_element tt_accordion $animate_class $extra_class ".($border=='1' ? 'bordered' : '')."'>".do_shortcode($content)."</div>";
}
add_shortcode( 'blox_accordion', 'blox_parse_accordion_hook' );


function blox_parse_accordion_item_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => 'Accordion Section',
		'icon' => '',
		'collapse' => ''
	), $atts ) );
	return '<div class="accordion_title '.($collapse=='1' ? 'current' : '').'">
				<a href="#" title="">'.($icon!='' ? "<i class='$icon'></i>" : '').do_shortcode($title).'</a>
				<span class="accordion_arrows"><i class="icon-chevron-down"></i><i class="icon-chevron-up"></i></span>
			</div>
			<div class="accordion_content">'.do_shortcode($content).'</div>';
}
add_shortcode( 'blox_accordion_item', 'blox_parse_accordion_item_hook' );



?>