
function get_blox_element_image($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_image" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Image</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
				+ '<div class="blox_item_image_style">'+($content!=undefined && $content.find('.style').length>0 ? $content.find('.style').html() : '')+'</div>'
				+ '<div class="blox_item_image_image">'+($content!=undefined && $content.find('.image').length>0 ? $content.find('.image').html() : '')+'</div>'
				+ '<div class="blox_item_image_caption">'+($content!=undefined && $content.find('.caption').length>0 ? $content.find('.caption').html() : '')+'</div>'
				+ '<div class="blox_item_image_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
				+ '<div class="blox_item_image_link">'+($content!=undefined && $content.find('.link').length>0 ? $content.find('.link').html() : '')+'</div>'
                + '<div class="blox_item_image_target">'+($content!=undefined && $content.find('.target').length>0 ? $content.find('.target').html() : '')+'</div>'
				+ '<div class="blox_item_image_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
				+ '<div class="blox_item_image_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
				+'</div> \
			</div>';
}


function parse_shortcode_image($content){
	$content = wp.shortcode.replace( 'blox_image', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='style' ){
					attrs += '<div class="style">'+value+'</div>';
				}
                if( key=='image' ){
					attrs += '<div class="image">'+value+'</div>';
				}
				if( key=='caption' ){
					attrs += '<div class="caption">'+value+'</div>';
				}
				if( key=='color' ){
					attrs += '<div class="color">'+value+'</div>';
				}
                if( key=='link' ){
					attrs += '<div class="link">'+value+'</div>';
				}
				if( key=='target' ){
					attrs += '<div class="target">'+value+'</div>';
				}                                
				if( key=='animation' ){
					attrs += '<div class="animation">'+value+'</div>';
				}
				if( key=='extra_class' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
			}
		});		
		return get_blox_element_image(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
	});
	return $content;
}

function revert_shortcode_image($content){
	$content.find('.blox_image').each(function(){
		attr = '';
		var temp_val = '';

		temp_val = jQuery(this).find('.blox_item_image_style').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' style="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_image_image').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' image="'+temp_val+'"';
		}
        
        temp_val = jQuery(this).find('.blox_item_image_caption').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' caption="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_image_color').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' color="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_image_link').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' link="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_image_target').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' target="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_image_animation').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' animation="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_image_extra_class').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_image'+attr+' /]');
	});
	return $content;
}


function add_event_blox_element_image(){
	
	jQuery('.blox_image').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
                			{
                				type: 'select',
                				id: 'blox_element_option_style',
                				label: 'Style',
                				value: $this.find('.blox_item_image_style').html(),
                				options: [
                						{
                							value: 'blox_elem_image_frame_border',
                							label: 'Bordered Style'
                						},
                						{
                							value: 'blox_elem_image_frame_colored',
                							label: 'Regular Style'
                						}
                						]
                			},
                			{
                				type: 'image',
                				id: 'blox_element_option_image',
                				label: 'Image',
                				value: $this.find('.blox_item_image_image').html()

                			},
                			{
                				type: 'input',
                				id: 'blox_element_option_caption',
                				label: 'Caption',
                				value: $this.find('.blox_item_image_caption').html()

                			},
                			{
                				type: 'colorpicker',
                				id: 'blox_element_option_color',
                				label: 'Color',
                				value: $this.find('.blox_item_image_color').html()

                			},
                			{
                				type: 'input',
                				id: 'blox_element_option_link',
                				label: 'Link',
                				value: $this.find('.blox_item_image_link').html()

                			},
                			{
                				type: 'checkbox_flat',
                				id: 'blox_element_option_target',
                				label: 'Link open in a new tab?',
                				value: $this.find('.blox_item_image_target').html(),
                                options: [
                						{value: '_self',label: 'Same window'},
                						{value: '_blank',label: 'In a new tab'}
                                        ]

                			},
                			{
                				type: 'input',
                				id: 'blox_element_extra_class',
                				label: 'Extra Class',
                				value: $this.find('.blox_item_image_extra_class').html()
                			}
                			];

                $this.attr('animation', $this.find('.blox_item_image_animation').html());
        		$this.attr('extra_class', $this.find('.blox_item_image_extra_class').html());

                show_blox_form('Edit Image', form_element, function($form){
                    $this.find('.blox_item_image_style').html(  jQuery('#blox_element_option_style').val() );
                    $this.find('.blox_item_image_image').html(   jQuery('#blox_element_option_image').val() );
                    $this.find('.blox_item_image_caption').html(   jQuery('#blox_element_option_caption').val() );
                    $this.find('.blox_item_image_color').html(   jQuery('#blox_element_option_color').val() );
                    $this.find('.blox_item_image_link').html(   jQuery('#blox_element_option_link').val() );
                    $this.find('.blox_item_image_target').html( jQuery('#blox_element_option_target').val() );
            		
            		$this.find('.blox_item_image_animation').html( $this.attr('animation') );
            		$this.find('.blox_item_image_extra_class').html( $this.attr('extra_class') );
                });

			});
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_image();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
