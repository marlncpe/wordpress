<?php
	

function blox_notification_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'text' => 'Notification Box',
		'icon' => 'icon-smile',
		'color' => '#ededed',
        'animation' => '',
        'extra_class' => ''
	), $atts ) );

	$animate_class = get_blox_animate_class($animation);

	return "<div class='blox_element blox_elem_notification_box blox_elem_notification_box_colored $animate_class ".blox_light_dark($color)." $extra_class' style='background-color:$color;'>
				<div class='blox_elem_notification_box_icon'><i class='$icon'></i></div>
				<div class='blox_elem_notification_box_content'>$text</div>
			</div>";
}
add_shortcode( 'blox_notification', 'blox_notification_hook' );


?>