
function get_blox_element_twitter($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_twitter" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Twitter</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
				+ '<div class="blox_item_twitter_id">'+($content!=undefined && $content.find('.id').length>0 ? $content.find('.id').html() : '')+'</div>'
                                + '<div class="blox_item_twitter_count">'+($content!=undefined && $content.find('.count').length>0 ? $content.find('.count').html() : '')+'</div>'
                                + '<div class="blox_item_twitter_timeout">'+($content!=undefined && $content.find('.timeout').length>0 ? $content.find('.timeout').html() : '')+'</div>'
				+ '<div class="blox_item_twitter_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
				+'</div> \
			</div>';
}


function parse_shortcode_twitter($content){
	$content = wp.shortcode.replace( 'blox_twitter', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
                                if( key=='id' ){
					attrs += '<div class="id">'+value+'</div>';
				}
				if( key=='count' ){
					attrs += '<div class="count">'+value+'</div>';
				}
				if( key=='timeout' ){
					attrs += '<div class="timeout">'+value+'</div>';
				}
				if( key=='extra_class' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
			}
		});		
		return get_blox_element_twitter(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
	});
	return $content;
}

function revert_shortcode_twitter($content){
	$content.find('.blox_twitter').each(function(){
		attr = '';
		var temp_val = '';

		temp_val = jQuery(this).find('.blox_item_twitter_id').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' id="'+temp_val+'"';
		}
                
		temp_val = jQuery(this).find('.blox_item_twitter_count').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' count="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_twitter_timeout').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' timeout="'+temp_val+'"';
		}
                
		temp_val = jQuery(this).find('.blox_item_twitter_extra_class').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_twitter'+attr+']');
	});
	return $content;
}


function add_event_blox_element_twitter(){
	
	jQuery('.blox_twitter').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
                                        {
                				type: 'input',
                				id: 'blox_element_option_id',
                				label: 'Twitter user',
                				value: $this.find('.blox_item_twitter_id').html()

                			},
                			{
                				type: 'input',
                				id: 'blox_element_option_count',
                				label: 'Tweet count',
                				value: $this.find('.blox_item_twitter_count').html()
                			},                			
                			{
                				type: 'input',
                				id: 'blox_element_option_timeout',
                				label: 'Slide timeout',
                				value: $this.find('.blox_item_twitter_timeout').html()

                			},
                			{
                				type: 'input',
                				id: 'blog_element_extra_class',
                				label: 'Extra Class',
                				value: $this.find('.blox_item_twitter_extra_class').html()
                			}
                			];

                show_blox_form('Edit Twitter', form_element, function($form){
                        $this.find('.blox_item_twitter_id').html(   jQuery('#blox_element_option_id').val() );
                	$this.find('.blox_item_twitter_count').html(  jQuery('#blox_element_option_count').val() );
                	$this.find('.blox_item_twitter_timeout').html(   jQuery('#blox_element_option_timeout').val() );
            		$this.find('.blox_item_twitter_extra_class').html( jQuery('#blog_element_extra_class').val() );
                });

			});
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_twitter();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
