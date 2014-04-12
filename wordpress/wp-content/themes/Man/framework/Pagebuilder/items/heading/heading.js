
function get_blox_element_heading($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	return '<div class="blox_item blox_heading" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"><i class="icon-font"></i> Header'+$tools+'</div> \
				<div class="blox_item_content">'+($content!=undefined ? $content : '')+'</div> \
			</div>';
}


function parse_shortcode_heading($content){
	$content = wp.shortcode.replace( 'blox_heading', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( key=='title' && value!='undefined' ){
				attrs += key+'="'+value+'" ';
			}
			if( key=='size' && value!='undefined' ){
				attrs += key+'="'+value+'" ';
			}
			if( key=='icon' && value!='undefined' ){
				attrs += key+'="'+value+'" ';
			}
			if( key=='color' && value!='undefined' ){
				attrs += key+'="'+value+'" ';
			}
			if( key=='style' && value!='undefined' ){
				attrs += 'heading_style="'+value+'" ';
			}
			if( key=='animation' && value!='undefined' ){
				attrs += key+'="'+value+'" ';
			}
			if( key=='extra_class' && value!='undefined' ){
				attrs += key+'="'+value+'" ';
			}
		})
		return get_blox_element_heading(data.content, attrs);
	});
	return $content;
}


function revert_shortcode_heading($content){
	$content.find('.blox_heading').each(function(){
		attr = '';
		var temp_val = '';

		temp_val = jQuery(this).attr('title')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' title="'+temp_val+'"';
		}
		temp_val = jQuery(this).attr('size')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' size="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('color')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' color="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('icon')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' icon="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('heading_style')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' style="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('animation')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' animation="'+temp_val+'"';
		}

		temp_val = jQuery(this).attr('extra_class')+'';
		if( temp_val!='undefined' && temp_val!='' ){
			attr += ' extra_class="'+temp_val+'"';
		}
		
		jQuery(this).replaceWith('[blox_heading'+attr+']'+jQuery(this).find('> .blox_item_content').html()+'[/blox_heading]');
	});
	return $content;
}


function add_event_blox_element_heading(){
	
	jQuery('.blox_heading').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

                var form_element = [
                			{
                				type: 'select',
                				id: 'blox_element_option_style',
                				label: 'Style',
                				value: $this.attr('heading_style'),
                				options: [
                						{
                							value: 'default',
                							label: '1. Centered with line'
                						},
                						{
                							value: 'style1',
                							label: '2. 3D, centered without description'
                						},
                						{
                							value: 'style2',
                							label: '3. Boxed with icon'
                						},
                						{
                							value: 'style3',
                							label: '4. Boxed 2 with icon'
                						},
                						{
                							value: 'style4',
                							label: '5. Regular with icon'
                						},
                						{
                							value: 'style5',
                							label: '6. Regular with dash'
                						}
            						],
            					description: "You should visit <a href='http://themeton.freshdesk.com/support/solutions/articles/152080-heading-element' target='_blank'>this link</a> and see how these styles look like."
                			},
                			{
                				type: 'input',
                				id: 'blox_element_option_title',
                				label: 'Title',
                				value: $this.attr('title')

                			},
                			{
                				type: 'select',
                				id: 'blox_element_option_size',
                				label: 'Title tag',
                				value: $this.attr('heading_style'),
                				options: [
                						{
                							value: 'h3',
                							label: 'H3'
                						},
                						{
                							value: 'h1',
                							label: 'H1'
                						},
                						{
                							value: 'h2',
                							label: 'H2'
                						},
                						{
                							value: 'h4',
                							label: 'H4'
                						}
            						],
            					description: "Please select here heading tag. Also it is important for your content indexing for search engines."
                			},
                			{
                				type: 'textarea',
                				id: 'blox_element_option_desc',
                				label: 'Description',
                				value: $this.find('.blox_item_content').html()

                			},
                			{
                				type: 'colorpicker',
                				id: 'blox_element_option_color',
                				label: 'Color',
                				value: $this.attr('color')

                			},
                			{
                				type: 'icon',
                				id: 'blox_tab_section_icon',
                				label: 'Icon',
                				value: $this.attr('icon')
                			}
                			];

                show_blox_form('Edit Heading', form_element, function($form){
                	$this.attr('title', jQuery('#blox_element_option_title').val());
                	$this.attr('size', jQuery('#blox_element_option_size').val());
        			$this.attr('color', jQuery('#blox_element_option_color').val());
        			$this.attr('icon', jQuery('#blox_tab_section_icon').val());
        			$this.attr('heading_style', jQuery('#blox_element_option_style').val());
        			$this.find('.blox_item_content').html( jQuery('#blox_element_option_desc').val() );
                },
                {
                	target: $this,
                	extra_field: true
                });
                
                // Folds
                $element = jQuery('#blox_element_option_style');
                $element.change(function(){
	                if($element.val() != 'style1') {
	                	jQuery('#blox_element_option_desc').show();
	                } else {
		                jQuery('#blox_element_option_desc').hide();
	                }
	                if($element.val() == 'style2' || $element.val() == 'style3' || $element.val() == 'style4') {
		                jQuery('.blox_elem_field_icon').show();
	                } else {
		                jQuery('.blox_elem_field_icon ').hide();
	                }
                });
                $element.change();

			});
			
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_heading();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
