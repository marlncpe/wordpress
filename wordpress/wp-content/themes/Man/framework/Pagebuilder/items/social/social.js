
function get_blox_element_social($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_social" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-share"></i> \
					<span class="blox_item_title">Share Buttons</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
				+ '<div class="blox_item_social_fbshare">'+($content!=undefined && $content.find('.fbshare').length>0 ? $content.find('.fbshare').html() : '')+'</div>'
                + '<div class="blox_item_social_tweet">'+($content!=undefined && $content.find('.tweet').length>0 ? $content.find('.tweet').html() : '')+'</div>'
                + '<div class="blox_item_social_gplus">'+($content!=undefined && $content.find('.gplus').length>0 ? $content.find('.gplus').html() : '')+'</div>'
                + '<div class="blox_item_social_pinterest">'+($content!=undefined && $content.find('.pinterest').length>0 ? $content.find('.pinterest').html() : '')+'</div>'
                + '<div class="blox_item_social_align">'+($content!=undefined && $content.find('.align').length>0 ? $content.find('.align').html() : '')+'</div>'
				+ '<div class="blox_item_social_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
				+ '<div class="blox_item_social_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
				+'</div> \
			</div>';
}


function parse_shortcode_social($content){
	$content = wp.shortcode.replace( 'blox_social', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
            	if( key=='fbshare' ){
					attrs += '<div class="fbshare">'+value+'</div>';
				}
                if( key=='tweet' ){
					attrs += '<div class="tweet">'+value+'</div>';
				}                                
				if( key=='gplus' ){
					attrs += '<div class="gplus">'+value+'</div>';
				}
				if( key=='pinterest' ){
					attrs += '<div class="pinterest">'+value+'</div>';
				}
				if( key=='align' ){
					attrs += '<div class="align">'+value+'</div>';
				}
				if( key=='animation' ){
					attrs += '<div class="animation">'+value+'</div>';
				}
				if( key=='extra_class' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
			}
		});		
		return get_blox_element_social(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
	});
	return $content;
}

function revert_shortcode_social($content){
	$content.find('.blox_social').each(function(){
		attr = '';
		var temp_val = '';
                
		temp_val = jQuery(this).find('.blox_item_social_fbshare').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' fbshare="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_social_tweet').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' tweet="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_social_gplus').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' gplus="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_social_pinterest').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' pinterest="'+temp_val+'"';
		}
                
		temp_val = jQuery(this).find('.blox_item_social_align').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			var_social = temp_val;
			var_social = var_social.replace(/\n/g, ',');
			attr += ' align="'+var_social+'"';
		}

		temp_val = jQuery(this).find('.blox_item_social_animation').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' animation="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_social_extra_class').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_social'+attr+']');
	});
	return $content;
}


function add_event_blox_element_social(){
	
	jQuery('.blox_social').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
                			{
                				type: 'checkbox_flat',
                				id: 'blox_element_option_fbshare',
                				label: 'Facebook Share',
                				value: $this.find('.blox_item_social_fbshare').html()

                			},
                            {
                				type: 'checkbox_flat',
                				id: 'blox_element_option_tweet',
                				label: 'Tweet me button',
                				value: $this.find('.blox_item_social_tweet').html()

                			},
                            {
                				type: 'checkbox_flat',
                				id: 'blox_element_option_gplus',
                				label: 'Google+',
                				value: $this.find('.blox_item_social_gplus').html()

                			},
                            {
                				type: 'checkbox_flat',
                				id: 'blox_element_option_pinterest',
                				label: 'Pinterest',
                				value: $this.find('.blox_item_social_pinterest').html()

                			},
                			{
                				type: 'select',
                				id: 'blox_element_option_align',
                				label: 'Align',
                				value: $this.find('.blox_item_social_align').html(),
                				options: [
                						{ value: 'left', label: 'Left' },
                						{ value: 'right', label: 'Right' },
                						{ value: 'center', label: 'Center' }
        						]

                			}
            			];

    			$this.attr('animation', $this.find('.blox_item_social_animation').html());
        		$this.attr('extra_class', $this.find('.blox_item_social_extra_class').html());

                show_blox_form('Edit Social Buttons', form_element, function($form){
                    $this.find('.blox_item_social_fbshare').html(   jQuery('#blox_element_option_fbshare').val() );
                    $this.find('.blox_item_social_tweet').html( jQuery('#blox_element_option_tweet').val() );
                	$this.find('.blox_item_social_gplus').html(  jQuery('#blox_element_option_gplus').val() );
                    $this.find('.blox_item_social_pinterest').html(  jQuery('#blox_element_option_pinterest').val() );
                    $this.find('.blox_item_social_align').html(  jQuery('#blox_element_option_align').val() );
            		
            		$this.find('.blox_item_social_animation').html( $this.attr('animation') );
            		$this.find('.blox_item_social_extra_class').html( $this.attr('extra_class') );
                },
                {
                	target: $this,
                	extra_field: true
                });

			});
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_social();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
