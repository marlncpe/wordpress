<?php
	
function blox_parse_mailchimp_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'category' => '',
                'filter' => 'recent',
		'style' => 'style1',
                'exclude' => '',
                'class' => ''
	), $atts ) );
	return "<a href='$link' target='$target' class='blox_mailchimp $style $align' style='padding:$size;background-color:$color'>".($icon!='' ? "<span class='button_icon $icon'></span>" : '')."<span class='button_title'>$text</span></a>";
}
add_shortcode( 'blox_mailchimp', 'blox_parse_mailchimp_hook' );

?>