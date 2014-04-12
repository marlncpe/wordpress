
function get_blox_element_progress($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
    return '<div class="blox_item blox_progress" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Progress Bar</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_progress_text">'+($content!=undefined && $content.find('.text').length>0 ? $content.find('.text').html() : '')+'</div>'
                + '<div class="blox_item_progress_percent">'+($content!=undefined && $content.find('.percent').length>0 ? $content.find('.percent').html() : '')+'</div>'
                + '<div class="blox_item_progress_style">'+($content!=undefined && $content.find('.style').length>0 ? $content.find('.style').html() : '')+'</div>'
                + '<div class="blox_item_progress_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                + '<div class="blox_item_progress_icon">'+($content!=undefined && $content.find('.icon').length>0 ? $content.find('.icon').html() : '')+'</div>'
                + '<div class="blox_item_progress_align">'+($content!=undefined && $content.find('.align').length>0 ? $content.find('.align').html() : '')+'</div>'
                + '<div class="blox_item_progress_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_progress($content){
    $content = wp.shortcode.replace( 'blox_progress', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='text' ){
                    attrs += '<div class="text">'+value+'</div>';
                }
                if( key=='percent' ){
                    attrs += '<div class="percent">'+value+'</div>';
                }
                if( key=='style' ){
                    attrs += '<div class="style">'+value+'</div>';
                }
                if( key=='icon' ){
                    attrs += '<div class="icon">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="color">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="extra_class">'+value+'</div>';
                }
            }
        });		
        return get_blox_element_progress(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_progress($content){
    $content.find('.blox_progress').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_progress_text').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' text="'+temp_val+'"';
        }
                
        temp_val = jQuery(this).find('.blox_item_progress_percent').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' percent="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_progress_style').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' style="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_progress_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }
                
        temp_val = jQuery(this).find('.blox_item_progress_icon').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            var_social = temp_val;
            var_social = var_social.replace(/\n/g, ',');
            attr += ' icon="'+var_social+'"';
        }

        temp_val = jQuery(this).find('.blox_item_progress_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_progress'+attr+']');
    });
    return $content;
}


function add_event_blox_element_progress(){
	
    jQuery('.blox_progress').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'select',
                id: 'blox_element_option_style',
                label: 'Style',
                value: $this.find('.blox_item_progress_style').html(),
                options: [
                {
                    value: 'style1',
                    label: '1. Icon with Boxed Line | No Title'
                },
                {
                    value: 'style2',
                    label: '2. Icon with Line + Title'
                },
                {
                    value: 'style3',
                    label: '3. Icon with Boxed'
                },
                {
                    value: 'style4',
                    label: '4. Icon with Boxed + Color Filled'
                },
                {
                    value: 'style5',
                    label: '5. Icon with Boxed + Title'
                },
                {
                    value: 'style6',
                    label: '6. Vertical Boxed Line + Percent + Title'
                },
                {
                    value: 'style7',
                    label: '7. Vertical Full Colored Box Line + Percent + Title'
                },
                {
                    value: 'style8',
                    label: '8. Vertical Boxed Line|Bottom + Percent + Title'
                },
                {
                    value: 'style9',
                    label: '9. Vertical Full Colored Box Line|Bottom + Percent + Title'
                }
                ],
                description: "You should visit <a href='http://themeton.freshdesk.com/support/solutions/articles/152092-progress-bar-element' target='_blank'>this link</a> and see how these styles look like."
            },
            {
                type: 'input',
                id: 'blox_element_option_text',
                label: 'Title text',
                value: $this.find('.blox_item_progress_text').html()

            },
            {
                type: 'number',
                id: 'blox_element_option_percent',
                std: 40,
                label: 'Fill Percent (%)',
                value: $this.find('.blox_item_progress_percent').html()

            },                			
            {
                type: 'icon',
                id: 'blox_element_option_icon',
                label: 'Icon',
                value: $this.find('.blox_item_progress_icon').html()

            },
            {
                type: 'colorpicker',
                id: 'blox_element_option_color',
                label: 'Color',
                value: $this.find('.blox_item_progress_color').html()
            },
            {
                type: 'input',
                id: 'blox_element_extra_class',
                label: 'Extra Class',
                value: $this.find('.blox_item_progress_extra_class').html()
            }
            ];

            show_blox_form('Edit Progress Bar', form_element, function($form){
                $this.find('.blox_item_progress_text').html(   jQuery('#blox_element_option_text').val() );
                $this.find('.blox_item_progress_style').html(  jQuery('#blox_element_option_style').val() );
                $this.find('.blox_item_progress_color').html(  jQuery('#blox_element_option_color').val() );
                $this.find('.blox_item_progress_icon').html(   jQuery('#blox_element_option_icon').val() );
                $this.find('.blox_item_progress_percent').html(   jQuery('#blox_element_option_percent').val() );                        
                $this.find('.blox_item_progress_extra_class').html( jQuery('#blox_element_extra_class').val() );
            });
            
                            
            // Folds
            $element = jQuery('#blox_element_option_style');
            $element.change(function(){
                if($element.val() != 'style1' && $element.val() != 'style3') {
                	jQuery('#blox_element_option_text').parent().show();
                } else {
	                jQuery('#blox_element_option_text').parent().hide();
                }
            });
            $element.change();

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_progress();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
