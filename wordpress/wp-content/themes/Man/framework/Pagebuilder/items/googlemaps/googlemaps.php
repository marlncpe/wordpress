<?php
	
function blox_parse_gmap_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'select' => 'embed',
		'lat' => '0',
        'long' => '0',
        'address' => '',
		'type' => 'ROADMAP',
		'zoom' => '14',
        'height' => '400',
        'extra_class' => ''
	), $atts ) );

    $result = '';
    if($select == 'embed') {
        $result .= $content;
    } else {
        wp_register_script('googlemap_api',      'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
        
        $id = 'gmaps'.uniqid();
        wp_enqueue_script('googlemap_api');
	   
       $result .= '<div class="google_map" id="'.$id.'" lat="'.$lat.'" long="'.$long.'" zoom="'.$zoom.'" style="height: '.$height.'px;"></div>';
    }

    return '<div class="blox_element blox_gmap '.$extra_class.'">'.do_shortcode($result).'</div>';
}
add_shortcode( 'blox_gmap', 'blox_parse_gmap_hook' );

?>