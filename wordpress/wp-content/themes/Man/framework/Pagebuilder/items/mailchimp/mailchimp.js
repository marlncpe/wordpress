
function get_blox_element_mailchimp($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_mailchimp" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Mailchimp form</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
                                + '<div class="blox_item_mailchimp_style">'+($content!=undefined && $content.find('.style').length>0 ? $content.find('.style').html() : '')+'</div>'
                                + '<div class="blox_item_mailchimp_exclude">'+($content!=undefined && $content.find('.exclude').length>0 ? $content.find('.exclude').html() : '')+'</div>'
                                + '<div class="blox_item_mailchimp_filter">'+($content!=undefined && $content.find('.filter').length>0 ? $content.find('.filter').html() : '')+'</div>'
				+ '<div class="blox_item_mailchimp_category">'+($content!=undefined && $content.find('.category').length>0 ? $content.find('.category').html() : '')+'</div>'
				+ '<div class="blox_item_mailchimp_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
				+'</div> \
			</div>';
}


function parse_shortcode_mailchimp($content){
	$content = wp.shortcode.replace( 'blox_mailchimp', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){                                
				if( key=='style' ){
					attrs += '<div class="style">'+value+'</div>';
				}
				if( key=='exclude' ){
					attrs += '<div class="exclude">'+value+'</div>';
				}
				if( key=='filter' ){
					attrs += '<div class="filter">'+value+'</div>';
				}
				if( key=='category' ){
					attrs += '<div class="category">'+value+'</div>';
				}
				if( key=='extra_class' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
			}
		});		
		return get_blox_element_mailchimp(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
	});
	return $content;
}

function revert_shortcode_mailchimp($content){
	$content.find('.blox_mailchimp').each(function(){
		attr = '';
		var temp_val = '';
                
		temp_val = jQuery(this).find('.blox_item_mailchimp_style').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' style="'+temp_val+'"';
		}

		temp_val = jQuery(this).find('.blox_item_mailchimp_exclude').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' exclude="'+temp_val+'"';
		}
                
		temp_val = jQuery(this).find('.blox_item_mailchimp_filter').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			var_social = temp_val;
			var_social = var_social.replace(/\n/g, ',');
			attr += ' filter="'+var_social+'"';
		}
                
		temp_val = jQuery(this).find('.blox_item_mailchimp_category').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			var_social = temp_val;
			var_social = var_social.replace(/\n/g, ',');
			attr += ' category="'+var_social+'"';
		}

		temp_val = jQuery(this).find('.blox_item_mailchimp_extra_class').html()+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_mailchimp'+attr+']');
	});
	return $content;
}


function add_event_blox_element_mailchimp(){
	
	jQuery('.blox_mailchimp').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
                			{
                				type: 'select',
                				id: 'blox_element_option_style',
                				label: 'Layout Style',
                				value: $this.find('.blox_item_mailchimp_style').html(),
                				options: [
                						{
                							value: 'style1',
                							label: 'Rectangle'
                						},
                						{
                							value: 'style2',
                							label: 'Circle'
                						},
                						{
                							value: 'style3',
                							label: 'Flat'
                						},
                						{
                							value: 'style4',
                							label: '3D'
                						}                                                                
                						]
                			},
                                        {
                				type: 'category',
                				id: 'blox_element_option_category',
                				label: 'Category',
                				value: $this.find('.blox_item_mailchimp_category').html()
                			},
                                        {
                				type: 'input',
                				id: 'blox_element_option_exclude',
                				label: 'Exclude post IDs',
                				value: $this.find('.blox_item_mailchimp_exclude').html()
                			},
                			{
                				type: 'select',
                				id: 'blox_element_option_filter',
                				label: 'Filter',
                				value: $this.find('.blox_item_mailchimp_filter').html(),
                				options: [
                						{
                							value: 'recent',
                							label: 'Recent'
                						},
                						{
                							value: 'popular',
                							label: 'Popular'
                						},
                						{
                							value: 'featured',
                							label: 'Featured'
                						},
                						{
                							value: 'discount',
                							label: 'Discount'
                						}
                						]

                			},
                			{
                				type: 'input',
                				id: 'blox_element_extra_class',
                				label: 'Extra Class',
                				value: $this.find('.blox_item_mailchimp_extra_class').html()
                			}
                			];

                show_blox_form('Edit Mailchimp', form_element, function($form){
                	$this.find('.blox_item_mailchimp_style').html(  jQuery('#blox_element_option_style').val() );
                        $this.find('.blox_item_mailchimp_filter').html(  jQuery('#blox_element_option_filter').val() );
                	$this.find('.blox_item_mailchimp_exclude').html(   jQuery('#blox_element_option_exclude').val() );
                        $this.find('.blox_item_mailchimp_category').html(   jQuery('#blox_element_option_category').val() );
            		$this.find('.blox_item_mailchimp_extra_class').html( jQuery('#blox_element_extra_class').val() );
                });

			});
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_mailchimp();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
