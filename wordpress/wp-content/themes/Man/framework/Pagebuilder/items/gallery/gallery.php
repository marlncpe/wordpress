<?php

add_action('wp_ajax_get_blox_element_galleryimg', 'get_blox_element_galleryimg_hook');
add_action('wp_ajax_nopriv_get_blox_element_galleryimg', 'get_blox_element_galleryimg_hook');
function get_blox_element_galleryimg_hook() {
    try {
		if( isset($_POST['images']) && $_POST['images']!='' ){
			$arr = explode(',', trim($_POST['images']));
			$counter = 0;
			$images = '';
			foreach ($arr as $value) {
				if( $value!='' ){
					$images .= ($counter==0 ? '' : '^').wp_get_attachment_url($value);
					$counter++;
				}
			}
			echo $images;
		}
		else{
			echo "-1";
		}
    }
    catch (Exception $e) {
    	echo "-1";
    }
    exit;
}



function blox_parse_gallery_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'images' => '',
		'layout' => '1',
		'animation' => '',
		'extra_class' => ''
	), $atts ) );
	
	$title = isset($title) && $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

	$animate_class = get_blox_animate_class($animation);

	$uid = uniqid();
	
	if( $images!='' ){
		$img_array = explode(',', $images);
		$html = '';

		if( $layout=='2' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = blox_aq_resize($attach_url, 150, 150, true);
				$prev = blox_aq_resize($attach_url, 600, 320, true);
				
				$html .= '<a href="'.$attach_url.'" data-preview="'.$prev.'" rel="blox_gallery['.$uid.']">
							<span class="thumb">
								<img src="'.$img.'" />
								<span class="hover"><i class="icon-zoom-in"></i></span>
							</span>
						</a>';			
			}
			return $title.'<div class="blox_element blox_gallery gallery_layout'.$layout.' '.$extra_class.' '.$animate_class.'">
						<span class="gallery_preview"><span class="preview_panel"></span></span>
						<span class="gallery_thumbs">'.$html.'</span>
					</div>';
		}
		else if( $layout=='3' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = blox_aq_resize($attach_url, 800, 430, true);
				
				$html .= '<img src="'.$img.'" />';
			}
			return $title.'<div class="blox_element blox_gallery gallery_layout_slider '.$extra_class.' '.$animate_class.'">
						<span class="gallery_preview">'.$html.'</span>
						<span class="gallery_pager"></span>
					</div>';
		}
		else if( $layout=='4' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = blox_aq_resize($attach_url, 800, 450, true);
				
				$html .= '<div style="background-image:url('.$img.');"></div>';
			}
			return $title.'<div class="blox_element blox_gallery gallery_imac '.$animate_class.'">
						<div class="device-mockup imac">
			                <div class="device">
			                    <div class="screen">
			                        <div class="gallery_viewport">'.$html.'</div>
			                    </div>
			                </div>
			            </div>
			            <a href="javascript:;" class="gallery_prev"><i class="icon-chevron-left"></i></a>
			            <a href="javascript:;" class="gallery_next"><i class="icon-chevron-right"></i></a>
		            </div>';
		}
		else if( $layout=='5' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = blox_aq_resize($attach_url, 800, 500, true);
				
				$html .= '<div style="background-image:url('.$img.');"></div>';
			}
			return $title.'<div class="blox_element blox_gallery gallery_laptop '.$animate_class.'">
						<div class="device-mockup macbook">
			                <div class="device">
			                    <div class="screen">
			                        <div class="gallery_viewport">'.$html.'</div>
			                    </div>
			                </div>
			            </div>
			            <a href="javascript:;" class="gallery_prev"><i class="icon-chevron-left"></i></a>
			            <a href="javascript:;" class="gallery_next"><i class="icon-chevron-right"></i></a>
		            </div>';
		}
		else if( $layout=='6' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = blox_aq_resize($attach_url, 640, 1130, true);
				
				$html .= '<div style="background-image:url('.$img.');"></div>';
			}
			return $title.'<div class="blox_element blox_gallery gallery_iphone '.$animate_class.'">
						<div class="device-mockup iphone5 portrait white">
			                <div class="device">
			                    <div class="screen">
			                        <div class="gallery_viewport">'.$html.'</div>
			                    </div>
			                    <div class="button"></div>
			                </div>
			            </div>
			            <a href="javascript:;" class="gallery_prev"><i class="icon-chevron-left"></i></a>
			            <a href="javascript:;" class="gallery_next"><i class="icon-chevron-right"></i></a>
		            </div>';
		}
		else{
            // Layout 1
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = blox_aq_resize($attach_url, 150, 150, true);
				$prev = '';
				
				$html .= '<a href="'.$attach_url.'" data-preview="'.$prev.'" rel="blox_gallery['.$uid.']">
							<span class="thumb">
								<img src="'.$img.'" />
								<span class="hover"><i class="icon-zoom-in"></i></span>
							</span>
						</a>';			
			}
			return $title.'<div class="blox_element blox_gallery gallery_layout'.$layout.' '.$extra_class.' '.$animate_class.'">
						<span class="gallery_preview"><span class="preview_panel"></span></span>
						<span class="gallery_thumbs">'.$html.'</span>
					</div>';
		}
	}
	
	return '';
}
add_shortcode( 'blox_gallery', 'blox_parse_gallery_hook' );


?>