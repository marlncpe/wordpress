
function get_blox_element_notification($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_notification" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Message Box</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
                    + '<div class="blox_item_msg_text">'+($content!=undefined && $content.find('.text').length>0 ? $content.find('.text').html() : '')+'</div>'
                    + '<div class="blox_item_msg_icon">'+($content!=undefined && $content.find('.icon').length>0 ? $content.find('.icon').html() : '')+'</div>'
                    + '<div class="blox_item_msg_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                    + '<div class="blox_item_msg_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
                    + '<div class="blox_item_msg_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_notification($content){
	$content = wp.shortcode.replace( 'blox_notification', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
				if( key=='text' ){
					attrs += '<div class="text">'+value+'</div>';
				}
                if( key=='icon' ){
					attrs += '<div class="icon">'+value+'</div>';
				}
				if( key=='color' ){
					attrs += '<div class="color">'+value+'</div>';
				}
				if( key=='animation' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
				if( key=='extra_class' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
			}
		})
		
		return get_blox_element_notification(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
	});
	return $content;
}

function revert_shortcode_notification($content){
	$content.find('.blox_notification').each(function(){
		attr = '';
		var temp_val = '';
        temp_val = jQuery(this).find('.blox_item_msg_text').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' text="'+temp_val+'"';
		}
		temp_val = jQuery(this).find('.blox_item_msg_icon').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' icon="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_msg_color').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' color="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_msg_animation').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' animation="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_msg_class').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_notification'+attr+']');
	});
	return $content;
}


function add_event_blox_element_notification(){
	
	jQuery('.blox_notification').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
                			{
                				type: 'input',
                				id: 'blox_el_text',
                				label: 'Message Text',
                				value: $this.find('.blox_item_msg_text').html()

                			},
                			{
                				type: 'icon',
                				id: 'blox_el_icon',
                				label: 'Icon',
                				value: $this.find('.blox_item_msg_icon').html()

                			},
                			{
                				type: 'colorpicker',
                				id: 'blox_el_color',
                				label: 'Background Color',
                				value: $this.find('.blox_item_msg_color').html()
                			}
                			];

               	$this.attr('animation', $this.find('.blox_item_msg_animation').html());
                $this.attr('extra_class', $this.find('.blox_item_msg_class').html());

                show_blox_form('Edit Message Box', form_element, function($form){
                    $this.find('.blox_item_msg_text').html( jQuery('#blox_el_text').val() );
                   	$this.find('.blox_item_msg_icon').html( jQuery('#blox_el_icon').val() );
            		$this.find('.blox_item_msg_color').html( jQuery('#blox_el_color').val() );

            		$this.find('.blox_item_msg_animation').html( $this.attr('animation') );
                    $this.find('.blox_item_msg_class').html( $this.attr('extra_class') );
                },
                {
                	target: $this,
                    extra_field: true
                });

			});
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_notification();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}