<?php
	
function blox_parse_twitter_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'id' => 'envato',
		'count' => '3',
		'timeout' => '5',
                'class' => ''
	), $atts ) );
	return "<a href='$link' target='$target' class='blox_twitter $style $align' style='padding:$size;background-color:$color'>".($icon!='' ? "<span class='button_icon $icon'></span>" : '')."<span class='button_title'>$text</span></a>";
}
add_shortcode( 'blox_twitter', 'blox_parse_twitter_hook' );

?>