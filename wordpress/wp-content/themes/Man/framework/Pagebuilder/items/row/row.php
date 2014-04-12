<?php

function get_blox_column_width_parser($size){
	if( $size == '1/1' ){
		return 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	}
	else if( $size == '1/5' ){
		return 'col-xs-12 col-xxs-6 col-sm-6 col-md-3 col-lg-3';
	}
	else if( $size == '1/4' ){
		return 'col-xs-12 col-xxs-6 col-sm-6 col-md-3 col-lg-3';
	}
	else if( $size == '1/3' ){
		return 'col-xs-12 col-xxs-4 col-sm-4 col-md-4 col-lg-4';
	}
	else if( $size == '2/5' ){
		return 'col-xs-12 col-xxs-6 col-sm-6 col-md-6 col-lg-6';
	}
	else if( $size == '1/2' ){
		return 'col-xs-12 col-xxs-6 col-sm-6 col-md-6 col-lg-6';
	}
	else if( $size == '3/4' ){
		return 'col-xs-12 col-sm-12 col-md-8 col-lg-9';
	}
	else if( $size == '2/3' ){
		return 'col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}
	else if( $size == '4/5' ){
		return 'col-xs-12 col-xxs-6 col-sm-6 col-md-2 col-lg-2';
	}
	else if( $size == '1/6' ){
		return 'col-xs-12 col-xxs-6 col-sm-6 col-md-2 col-lg-2';
	}
	else if( $size == '5/6' ){
		return 'col-xs-12 col-sm-12 col-md-8 col-lg-9';
	}
	else{
		return 'col-xs-12 col-xxs-12 col-sm-12 col-md-12 col-lg-12';
	}
}

function blox_parse_row_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'columns' => '',
		'fullwidth' => '',
		'color' => '',
		'image' => '',
		'bg_repeat' => '',
		'bg_position' => '',
		'bg_attach' => '',
		'extra_class' => '',
		'video_active' => '',
		'video_m4v' => '',
		'video_webm' => '',
		'poster' => '',
		'video_opacity' => '0.4',
		'no_padding' => ''
	), $atts ) );

	$attrs = '';
	if( $image!='' ){
		$attrs .= "background-image: url($image); background-position: $bg_position;";
		$attrs .= ( $bg_repeat=='cover' ? "background-size: cover;" : "background-repeat: $bg_repeat;" );
		$attrs .= ( $bg_attach=='parallax' ? "" : "background-attachment: $bg_attach;" );
	}
	if( $color!='' ){ $attrs .= "background-color: $color;"; }

	$dark_light = $color!='' ? blox_light_dark($color) : '';
	$dark_light .= $bg_attach=='parallax' ? ' skrollable skrollable-between' : '';

	$data_attr = $bg_attach=='parallax' ? 'data-bottom-top="background-position:50% 0%" data-top-bottom="background-position:50% 100%;"' : '';

	$no_padding_col = $no_padding=='1' ? 'no_padding_columns' : '';

	// video background
	if( $fullwidth=='true' && $video_active=='1' ){

		wp_enqueue_style('mediaelement-css', BLOX_PATH.'js/mediaelement/mediaelementplayer.min.css');
		wp_enqueue_script('mediaelement-js',        BLOX_PATH.'js/mediaelement/mediaelement-and-player.min.js');
		
		$video_bg = '';
		if( $color!='' ){ $video_bg .= "background-color: ".blox_hex2rgba($color, $video_opacity).";"; }
		if( $image!='' ){ $video_bg .= "background-image: url($image);"; }
		return '<div class="blox_row_fullwidth row_video_wrapper '.$dark_light.' '.$extra_class.'">
					<div class="row_video" style="background-image:url('.$poster.');">
						<video controls="controls" preload="auto" loop="true" autoplay="true">
							<source type="video/mp4" src="'.$video_m4v.'" />
							<source type="video/webm" src="'.$video_webm.'" />
							<object width="1900" height="1060" type="application/x-shockwave-flash" data="'.BLOX_PATH.'js/mediaelement/flashmediaelement.swf">
								<param name="movie" value="'.BLOX_PATH.'js/mediaelement/flashmediaelement.swf" />
								<param name="flashvars" value="controls=true&file='.$video_m4v.'" />
							</object>
						</video>
					</div>
					<div class="row_background" style="'.$video_bg.'"></div>
					<div class="container">
						<div class="wrapper">
							'.'<div class="row '.$no_padding_col.'">'.do_shortcode($content).'</div>'.'
						</div>
					</div>
				</div>';
	}
	else if( $fullwidth=='true' ){
		return '<div class="blox_row_fullwidth '.$dark_light.' '.$extra_class.'" style="'.$attrs.'" '.$data_attr.'>
					<div class="container">
						<div class="wrapper">
							'.'<div class="row '.$no_padding_col.'">'.do_shortcode($content).'</div>'.'
						</div>
					</div>
				</div>';
	}

	return '<div class="wrapper '.$dark_light.' '.$extra_class.'" style="'.$attrs.'" '.$data_attr.'>
				<div class="row '.$no_padding_col.'">'.do_shortcode($content).'</div>
			</div>';
}
add_shortcode( 'blox_row', 'blox_parse_row_hook' );
add_shortcode( 'blox_row_inner', 'blox_parse_row_hook' );


function blox_parse_column_hook( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'width' => '1/1'
	), $atts ) );
	
	return '<div class="'.get_blox_column_width_parser($width).'">'.do_shortcode($content).'</div>';
	//tt_fluid_block
}
add_shortcode( 'blox_column', 'blox_parse_column_hook' );
add_shortcode( 'blox_column_inner', 'blox_parse_column_hook' );








?>