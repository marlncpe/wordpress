function split2class(split){
	var col;
	switch(split){
		case '1/2':
			col = 'span6';
			break;
		case '1/3':
			col = 'span4';
			break;
		case '2/3':
			col = 'span8';
			break;
		case '1/6':
			col = 'span2';
			break;
		case '1/4':
			col = 'span3';
			break;
		case '3/4':
			col = 'span9';
			break;
		case '5/6':
			col = 'span10';
			break;
		default:
			col = 'span12';
			break;
	}
	return col;
}
function class2split(split){
	var col;
	switch(split){
		case 'span6':
			col = '1/2';
			break;
		case 'span4':
			col = '1/3';
			break;
		case 'span8':
			col = '2/3';
			break;
		case 'span2':
			col = '1/6';
			break;
		case 'span3':
			col = '1/4';
			break;
		case 'span9':
			col = '3/4';
			break;
		case 'span10':
			col = '5/6';
		default:
			col = '1/1';
			break;
	}
	return col;
}


function get_blox_row_controls(){
	$actions = '<div class="blox_controls_row clearfix"> \
					<a href="javascript:;" class="move_row"><i class="icon-fixed-width"></i></a> \
					<a href="javascript:;" class="split_row one" title="1/1"></a> \
					<a href="javascript:;" class="split_row one_half" title="1/2+1/2"></a> \
					<a href="javascript:;" class="split_row two_third_ref" title="1/3+2/3"></a> \
					<a href="javascript:;" class="split_row two_third" title="2/3+1/3"></a> \
					<a href="javascript:;" class="split_row three_fourth" title="1/4+3/4"></a> \
					<a href="javascript:;" class="split_row three_fourth_ref" title="3/4+1/4"></a> \
					<a href="javascript:;" class="split_row five_sixth_ref" title="1/6+5/6"></a> \
					<a href="javascript:;" class="split_row five_sixth" title="5/6+1/6"></a> \
					<a href="javascript:;" class="split_row one_third" title="1/3+1/3+1/3"></a> \
					<a href="javascript:;" class="split_row one_fourth_two_fourth" title="1/4+1/2+1/4"></a> \
					<a href="javascript:;" class="split_row two_fourth_one_fourth" title="1/2+1/4+1/4"></a> \
					<a href="javascript:;" class="split_row two_fourth_one_fourth_ref" title="1/4+1/4+1/2"></a> \
					<a href="javascript:;" class="split_row one_fourth" title="1/4+1/4+1/4+1/4"></a> \
					<a href="javascript:;" class="split_row one_sixth" title="1/6+1/6+1/6+1/6+1/6+1/6"></a> \
					<a href="javascript:;" class="actions_remove"><i class="icon-fixed-width"></i></a> \
					<a href="javascript:;" class="actions_clone"><i class="icon-fixed-width"></i></a> \
					<a href="javascript:;" class="actions_edit"><i class="icon-fixed-width"></i></a> \
				</div>';
	return $actions;
}


function get_blox_row_html($row_content){
	$actions = get_blox_row_controls();
	return '<div class="blox_row row-fluid">'+$actions+'<div class="blox_row_content clearfix">'+$row_content+'</div></div>';
}

function get_blox_column_html($width, $col_content){
	$col_action_top = '<div class="blox_columns_action blox_action_buttons"> \
							<a href="javascript:;" class="blox_column_action_add" data-rel="top"><i class="icon-fixed-width"></i></a> \
						</div>';
	$col_action_bottom = '<div class="blox_columns_action blox_action_buttons"> \
							<a href="javascript:;" class="blox_column_action_add" data-rel="bottom"><i class="icon-fixed-width"></i></a> \
						</div>';
	return '<div class="blox_column '+$width+'">'+$col_action_top+'<div class="blox_column_content blox_container">'+$col_content+'</div>'+$col_action_bottom+'</div>';
}

function get_blox_row_el_html($content){
	$actions = get_blox_row_controls();
	return '<div class="blox_row row-fluid">'+$actions+'<div class="blox_row_content clearfix">'+get_blox_column_html('span12', $content!=undefined ? $content : '')+'</div></div>';
}






// parse shortcode to row
function parse_shortcode_row_hook($content){
	$content = wp.shortcode.replace( 'blox_row', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
				attrs += ' '+key+'="'+value+'"';
			}
		});
		$actions = get_blox_row_controls();
		$new_content = '<div class="blox_row row-fluid"'+attrs+'>'+$actions+'<div class="blox_row_content clearfix">'+data.content+'</div></div>';
		return $new_content;
	});
	
	$content = wp.shortcode.replace( 'blox_row_inner', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
				attrs += ' '+key+'="'+value+'"';
			}
		});
		$actions = get_blox_row_controls();
		$new_content = '<div class="blox_row row-fluid"'+attrs+'>'+$actions+'<div class="blox_row_content clearfix">'+data.content+'</div></div>';
		return $new_content;
	});
	
	return $content;
}
function parse_shortcode_row($content){
	$content = parse_shortcode_row_hook($content);
	return parse_shortcode_column($content);
}




// parse shortcode to column
function parse_shortcode_column_hook($content){
	$content = wp.shortcode.replace( 'blox_column', $content, function(data){
		var col = 'span12';
		jQuery.each(data.attrs.named, function(key, value){
			if( key=='width' ){
				col = split2class(value);
			}
		})
		return get_blox_column_html(col, data.content);
	});
	
	$content = wp.shortcode.replace( 'blox_column_inner', $content, function(data){
		var col = 'span12';
		jQuery.each(data.attrs.named, function(key, value){
			if( key=='width' ){
				col = split2class(value);
			}
		})
		return get_blox_column_html(col, data.content);
	});
	
	return $content;
}
function parse_shortcode_column($content){
	$content = parse_shortcode_column_hook($content);
	return $content;
}





// revert to shortcode rows
function revert_shortcode_row_hook($content, $hook){
	$content.find('.blox_row').each(function(){
		var attr = '';
		var temp_val = '';
		
		temp_val = jQuery(this).attr('columns')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' columns="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('fullwidth')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' fullwidth="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('color')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' color="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('image')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' image="'+temp_val+'"';
		}
		
		temp_val = jQuery(this).attr('bg_repeat')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' bg_repeat="'+temp_val+'"';
		}
		temp_val = jQuery(this).attr('bg_position')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' bg_position="'+temp_val+'"';
		}
		temp_val = jQuery(this).attr('bg_attach')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' bg_attach="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('video_active')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' video_active="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('video_m4v')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' video_m4v="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('video_webm')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' video_webm="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('video_opacity')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' video_opacity="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('poster')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' poster="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('no_padding')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' no_padding="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('extra_class')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}

		if( typeof $hook!=='undefined' && $hook ){
			jQuery(this).replaceWith('[blox_row_inner'+attr+']'+jQuery(this).find('> .blox_row_content').html()+'[/blox_row_inner]');
		}
		else{
			jQuery(this).replaceWith('[blox_row'+attr+']'+jQuery(this).find('> .blox_row_content').html()+'[/blox_row]');
		}

	});
}
function revert_shortcode_row($content){
	revert_shortcode_row_hook($content);
	revert_shortcode_row_hook($content, true);
	return revert_shortcode_column($content);
}






// revert to shortcode columns
function revert_shortcode_column_hook($content, $hook){
	if( typeof $hook!=='undefined' && $hook ){
		$content.find('.blox_column').each(function(){
			var size = '1/1';
			$this = jQuery(this);
			
			if( $this.hasClass('span6') ){
				size = '1/2';
			}else if( $this.hasClass('span4') ){
				size = '1/3';
			}else if( $this.hasClass('span8') ){
				size = '2/3';
			}else if( $this.hasClass('span2') ){
				size = '1/6';
			}else if( $this.hasClass('span3') ){
				size = '1/4';
			}else if( $this.hasClass('span9') ){
				size = '3/4';
			}
			jQuery(this).replaceWith('[blox_column_inner width="'+size+'"]'+jQuery(this).find('> .blox_column_content').html()+'[/blox_column_inner]');
		});
	}
	else{
		$content.find('.blox_column').each(function(){
			var size = '1/1';
			$this = jQuery(this);
			
			if( $this.hasClass('span6') ){
				size = '1/2';
			}else if( $this.hasClass('span4') ){
				size = '1/3';
			}else if( $this.hasClass('span8') ){
				size = '2/3';
			}else if( $this.hasClass('span2') ){
				size = '1/6';
			}else if( $this.hasClass('span3') ){
				size = '1/4';
			}else if( $this.hasClass('span9') ){
				size = '3/4';
			}
			jQuery(this).replaceWith('[blox_column width="'+size+'"]'+jQuery(this).find('> .blox_column_content').html()+'[/blox_column]');
		});
	}
}
function revert_shortcode_column($content){
	revert_shortcode_column_hook($content);
	revert_shortcode_column_hook($content, true);
	return $content;
}





function get_blox_element_row($content){
	return get_blox_row_el_html($content);
}


function add_event_blox_element_row(){
	
	jQuery('.blox_controls_row').each(function(){
  		var $context = jQuery(this).parent();
  		if( $context.attr('columns') ){
  			jQuery(this).find('.split_row').each(function(){
  				if( jQuery(this).attr('title') && jQuery(this).attr('title')==$context.attr('columns') ){
  					jQuery(this).addClass('active');
  				}
  			});
  		}
  		jQuery(this).find('.split_row').unbind('click')
  			.click(function(){
  				
  				jQuery(this).parent().find('.split_row').removeClass('active');
  				jQuery(this).addClass('active');
  				
  				var size_title = jQuery(this).attr('title');
  				var size_arr = size_title.split('+');
  				var $row = jQuery(this).parent().parent();
  				var $tmp_array = new Array();

  				$context.attr('columns', size_title);
  				
  				$row.find('> .blox_row_content > .blox_column').each(function(index){
  					$col = jQuery(this);
  					$tmp_array[index] = jQuery(this);
  				});
  				
  				$row.find('> .blox_row_content').html('');
  				for(i=0; i<size_arr.length; i++){
  					html = '';
  					if( i<$tmp_array.length ){
  						html = get_blox_column_html(split2class(size_arr[i]), $tmp_array[i].find('.blox_column_content').html());
  					}
  					else{
  						html = get_blox_column_html(split2class(size_arr[i]), '');
  					}
  					$row.find('> .blox_row_content').append(html);
  				}
  				if( $tmp_array.length > size_arr.length  ){
  					for(i=size_arr.length; i<$tmp_array.length; i++){
  						$row.find('> .blox_row_content > .blox_column').eq(size_arr.length-1).find('.blox_column_content').append($tmp_array[i].find('.blox_column_content').html());
  					}
  				}
  				addEventsBloxLayout();
  			});
  			
		jQuery(this).find('.actions_remove').unbind('click')
			.click(function(){
				$context.remove();
			});
		
		jQuery(this).find('.actions_clone').unbind('click')
			.click(function(){
				$context.after( $context.clone() );
				addEventsBloxLayout();
			});
			
		jQuery(this).find('.actions_edit').unbind('click')
			.click(function(){
				
				var form_element = [
							{
                				type: 'checkbox_flat',
                				id: 'blox_row_attr_fullwidth',
                				label: 'Enable Fullwidth',
                				value: ( typeof $context.attr('fullwidth')!=='undefined' && $context.attr('fullwidth')=='true' ? '1' : '0' )
                			},
                			{
                				type: 'colorpicker',
                				id: 'blox_row_attr_color',
                				label: 'Background Color',
                				value: $context.attr('color')
                			},
                			{
                				type: 'image',
                				id: 'blox_row_attr_image',
                				label: 'Background Image',
                				value: $context.attr('image')

                			},
                			{
                				type: 'select',
                				id: 'blox_row_attr_bgrepeat',
                				label: 'Background Repeat',
                				value: $context.attr('bg_repeat'),
                				options: [
                					{ value: 'no-repeat', label: 'No Repeat' },
                					{ value: 'repeat', label: 'Repeat' },
                					{ value: 'repeat-x', label: 'Repeat-X' },
                					{ value: 'repeat-y', label: 'Repeat-Y' },
                					{ value: 'cover', label: 'No Repeat/Image Cover' }
                				]
                			},
                			{
                				type: 'select',
                				id: 'blox_row_attr_bgposition',
                				label: 'Background Position',
                				value: $context.attr('bg_position'),
                				options: [
                					{ value: 'top left', label: 'Top Left' },
                					{ value: 'top center', label: 'Top Center' },
                					{ value: 'top right', label: 'Top right' },
                					{ value: 'center left', label: 'Center Left' },
                					{ value: 'center center', label: 'Center Center' },
                					{ value: 'center right', label: 'Center Right' },
                					{ value: 'bottom left', label: 'Bottom Left' },
                					{ value: 'bottom center', label: 'Bottom Center' },
                					{ value: 'bottom right', label: 'Bottom Right' }
                				]
                			},
                			{
                				type: 'select',
                				id: 'blox_row_attr_attachment',
                				label: 'Background Attachment Type',
                				value: $context.attr('bg_attach'),
                				options: [
                					{ value: 'scroll', label: 'Scroll' },
                					{ value: 'fixed', label: 'Fixed' },
                					{ value: 'parallax', label: 'Parallax' }
                				],
                                description: 'Controls how your background image affect when you scroll up & down. If you select here <b>Parallax</b> value, background image moves beautiful motion.'
                			},
                			{
                				type: 'checkbox_flat',
                				id: 'row_video_active',
                				label: 'Background Video Active',
                				value: $context.attr('video_active')
                			},
                			{
				                type: 'video',
				                id: 'row_video_m4v',
				                label: 'Video M4V',
				                value: $context.attr('video_m4v'),
				                description: 'Webkit browsers support this format for HTML5 video'
				            },
				            {
				                type: 'video',
				                id: 'row_video_webm',
				                label: 'Video WEBM',
				                value: $context.attr('video_webm'),
				                description: 'Firefox browser support webm format for HTML5 video'
				            },
				            {
                				type: 'image',
                				id: 'blox_row_attr_poster',
                				label: 'Video Poster',
                				value: $context.attr('poster'),
                				description: 'It is poster of background video. It is appear when you visit from mobile device. Background Video not play on mobile device.'

                			},
				            {
				                type: 'text',
				                id: 'row_video_opacity',
				                label: 'Overlay color opacity',
				                value: (typeof $context.attr('video_opacity')!=='undefined' && $context.attr('video_opacity')!='' ? $context.attr('video_opacity') : '0.4'),
				                description: 'Video overlay color opacity. value from row background color (value is float number: 0-1)'
				            },
				            {
                				type: 'checkbox_flat',
                				id: 'row_nopadding',
                				label: 'No padding Columns',
                				value: $context.attr('no_padding')
                			},
                			{
                				type: 'input',
                				id: 'blox_row_extra_class',
                				label: 'Extra Class',
                				value: $context.attr('extra_class')
                			}
            			];

                show_blox_form('Edit Row Option', form_element, function($form){
                	$context.attr('fullwidth', (jQuery('#blox_row_attr_fullwidth').val() == 1 ? 'true' : '') );
                	$context.attr('color', jQuery('#blox_row_attr_color').val());
                	$context.attr('image', jQuery('#blox_row_attr_image').val());
                	
                	$context.removeAttr('bg_repeat');
                	$context.removeAttr('bg_position');
                	$context.removeAttr('bg_attach');
                	$context.removeAttr('extra_class');

                	$context.removeAttr('video_active');
                	$context.removeAttr('video_m4v');
                	$context.removeAttr('video_webm');
                	$context.removeAttr('video_opacity');
                	$context.removeAttr('poster');

                	$context.removeAttr('row_nopadding');

                	if( jQuery('#blox_row_attr_image').val()!='' ){
                		$context.attr('bg_repeat', jQuery('#blox_row_attr_bgrepeat').val());
                		$context.attr('bg_position', jQuery('#blox_row_attr_bgposition').val());
                		$context.attr('bg_attach', jQuery('#blox_row_attr_attachment').val());
                	}

                	if( jQuery('#blox_row_extra_class').val()!='' ){
                		$context.attr('extra_class', jQuery('#blox_row_extra_class').val());
                	}

                	if( jQuery('#row_video_active').val() == '1' ){
                		$context.attr('video_active', jQuery('#row_video_active').val());
                		$context.attr('video_m4v', jQuery('#row_video_m4v').val());
                		$context.attr('video_webm', jQuery('#row_video_webm').val());
                		$context.attr('poster', jQuery('#blox_row_attr_poster').val());
                		$context.attr('video_opacity', jQuery('#row_video_opacity').val());
                	}

                	if( jQuery('#row_nopadding').val() == '1' ){
                		$context.attr('no_padding', jQuery('#row_nopadding').val());
                	}
                },
                {
                	target: $context
                }
                );
				
				
				//Image field event
                jQuery('#blox_row_attr_image').change(function(){
                	if( this.value!='' ){
                		jQuery('#blox_row_attr_bgrepeat').parent().show();
		                jQuery('#blox_row_attr_bgposition').parent().show();
		                jQuery('#blox_row_attr_attachment').parent().show();
                	}
                	else{
                		jQuery('#blox_row_attr_bgrepeat').parent().hide();
		                jQuery('#blox_row_attr_bgposition').parent().hide();
		                jQuery('#blox_row_attr_attachment').parent().hide();
                	}
                });
                jQuery('#blox_row_attr_image').change();


                //Video active event
                jQuery('#row_video_active').change(function(){
                	var $this = jQuery(this);
                	if( this.value == '1' ){
						jQuery('#row_video_m4v').parent().show();
		                jQuery('#row_video_webm').parent().show();
		                jQuery('#row_video_opacity').parent().show();
		                jQuery('#blox_row_attr_poster').parent().show();
                	}
                	else{
						jQuery('#row_video_m4v').parent().hide();
		                jQuery('#row_video_webm').parent().hide();
		                jQuery('#row_video_opacity').parent().hide();
		                jQuery('#blox_row_attr_poster').parent().hide();
                	}
                });

                //Row fullwidth event
                jQuery('#blox_row_attr_fullwidth').change(function(){
                	var $this = jQuery(this);
                	if( this.value == '1' ){
                		jQuery('#blox_row_attr_color').parent().parent().parent().show();
                		jQuery('#blox_row_attr_image').parent().show();
                		jQuery('#blox_row_attr_image').change();
                		jQuery('#row_video_active').parent().parent().show();
                		jQuery('#row_video_active').change();
                	}
                	else{
                		jQuery('#blox_row_attr_color').parent().parent().parent().hide();
                		jQuery('#blox_row_attr_image').parent().hide();
                		jQuery('#blox_row_attr_bgrepeat').parent().hide();
		                jQuery('#blox_row_attr_bgposition').parent().hide();
		                jQuery('#blox_row_attr_attachment').parent().hide();
		                
		                jQuery('#row_video_active').parent().parent().hide();
		                jQuery('#row_video_m4v').parent().hide();
		                jQuery('#row_video_webm').parent().hide();
		                jQuery('#row_video_opacity').parent().hide();
		                jQuery('#blox_row_attr_poster').parent().hide();
                	}
                });

				jQuery('#blox_row_attr_fullwidth').change();

                
			});
  	});
  	
  	
  	jQuery('.blox_columns_action .blox_column_action_add').unbind('click')
  		.click(function(){
  			$context = jQuery(this).parent().parent().find('> .blox_column_content');
  			add_blox_element($context, jQuery(this).attr('data-rel'));
  		});
	
}

