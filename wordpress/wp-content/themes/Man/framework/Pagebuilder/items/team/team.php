<?php

function blox_parse_team_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'style' => 'style1',
                'image' => '',
                'imglink' => '',
                'name' => 'Member name',
                'position' => 'CEO / Founder',
                'color' => 'transparent',
                'social' => '',
                'animation' => '',
                'extra_class' => ''
                    ), $atts));

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

    $animate_class = get_blox_animate_class($animation);
    
    $prelink = ($imglink != '') ? '<a href="'.$imglink.'" target="_blank">' : '';
    $afterlink = ($imglink != '') ? '</a>' : '';
    
    $links = '';
    if ($social != '') {
        $arr = explode(',', $social);
        $links .= "<div class='socials'>";
        foreach ($arr as $value) {
            $link = trim($value);
            if (strpos($link, 'facebook:') > -1) {
                $links .= '<a href="' . trim(str_replace('facebook:', '', $link)) . '" class="facebook" target="_blank"><i class="icon-facebook"></i></a>';
            }
            if (strpos($link, 'twitter:') > -1) {
                $links .= '<a href="' . trim(str_replace('twitter:', '', $link)) . '" class="twitter" target="_blank"><i class="icon-twitter"></i></a>';
            }
            if (strpos($link, 'googleplus:') > -1) {
                $links .= '<a href="' . trim(str_replace('googleplus:', '', $link)) . '" class="googleplus" target="_blank"><i class="icon-gplus"></i></a>';
            }
            if (strpos($link, 'email:') > -1) {
                $links .= '<a href="' . trim(str_replace('email:', '', $link)) . '" class="email" target="_blank"><i class="icon-envelope"></i></a>';
            }
            if (strpos($link, 'pinterest:') > -1) {
                $links .= '<a href="' . trim(str_replace('pinterest:', '', $link)) . '" class="pinterest" target="_blank"><i class="icon-pinterest"></i></a>';
            }
            if (strpos($link, 'linkedin:') > -1) {
                $links .= '<a href="' . trim(str_replace('linkedin:', '', $link)) . '" class="linkedin" target="_blank"><i class="icon-linkedin"></i></a>';
            }
            if (strpos($link, 'link:') > -1) {
                $links .= '<a href="' . trim(str_replace('link:', '', $link)) . '" class="link" target="_blank"><i class="icon-link"></i></a>';
            }
            if (strpos($link, 'youtube:') > -1) {
                $links .= '<a href="' . trim(str_replace('youtube:', '', $link)) . '" class="youtube" target="_blank"><i class="icon-youtube"></i></a>';
            }
            if (strpos($link, 'dribbble:') > -1) {
                $links .= '<a href="' . trim(str_replace('dribbble:', '', $link)) . '" class="dribbble" target="_blank"><i class="icon-dribbble"></i></a>';
            }
            if (strpos($link, 'instagram:') > -1) {
                $links .= '<a href="' . trim(str_replace('instagram:', '', $link)) . '" class="instagram" target="_blank"><i class="icon-instagram"></i></a>';
            }
            if (strpos($link, 'flickr:') > -1) {
                $links .= '<a href="' . trim(str_replace('flickr:', '', $link)) . '" class="flickr" target="_blank"><i class="icon-flickr"></i></a>';
            }
            if (strpos($link, 'skype:') > -1) {
                $links .= '<a href="' . trim(str_replace('skype:', '', $link)) . '" class="skype" target="_blank"><i class="icon-skype"></i></a>';
            }
        }
        $links .= "</div>";
    }
    

    if ($style == 'style1') {
        $result .= "<div class='blox_element blox_elem_team $style $animate_class $extra_class ".get_text_class($color)."' style='background-color: $color;'>
					<div class='image'>
                $prelink
						<img src='" . blox_aq_resize($image, 300, 300, true) . "' />
                $afterlink
					</div>
					$links
					<div class='description'>
						<h3>$name</h3>
						<p>$position</p>
						<p>$content</p>
					</div>
				</div>";
    } else {
        $result .= "<div class='blox_element blox_elem_team $style $animate_class $extra_class'>
					<div class='image'>
        $prelink
						<img src='" . blox_aq_resize($image, 300, 300, true) . "' style='border-color:$color;' />
                $afterlink
					</div>
					<div class='description'>
						<h3>$name</h3>
						<div class='position'>$position</div>
						<p>$content</p>
					</div>
					<div class='socials'>$links</div>
				</div>";
    }
    
    return $result;
}

add_shortcode('blox_team', 'blox_parse_team_hook');
?>