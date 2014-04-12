
function get_blox_element_duplicator($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_duplicator" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-user"></i> \
                        <span class="blox_item_title">Duplicator</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_duplicator_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_total">'+($content!=undefined && $content.find('.total').length>0 ? $content.find('.total').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_size">'+($content!=undefined && $content.find('.size').length>0 ? $content.find('.size').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_color2">'+($content!=undefined && $content.find('.color2').length>0 ? $content.find('.color2').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_icon">'+($content!=undefined && $content.find('.icon').length>0 ? $content.find('.icon').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_number">'+($content!=undefined && $content.find('.number').length>0 ? $content.find('.number').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_number2">'+($content!=undefined && $content.find('.number2').length>0 ? $content.find('.number2').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_align">'+($content!=undefined && $content.find('.align').length>0 ? $content.find('.align').html() : '')+'</div>'
                + '<div class="blox_item_duplicator_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_duplicator($content){
    $content = wp.shortcode.replace( 'blox_duplicator', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){                             
                if( key=='title' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='total' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='number' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='number2' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='icon' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color2' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='size' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='align' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
            }
        });		
        return get_blox_element_duplicator(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_duplicator($content){
    $content.find('.blox_duplicator').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_duplicator_title').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_total').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' total="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_number').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' number="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_number2').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' number2="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_color2').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color2="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_icon').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            var_social = temp_val;
            var_social = var_social.replace(/\n/g, ',');
            attr += ' icon="'+var_social+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_size').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            var_social = temp_val;
            var_social = var_social.replace(/\n/g, ',');
            attr += ' size="'+var_social+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_align').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            var_social = temp_val;
            var_social = var_social.replace(/\n/g, ',');
            attr += ' align="'+var_social+'"';
        }
        temp_val = jQuery(this).find('.blox_item_duplicator_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_duplicator'+attr+'/]');
    });
    return $content;
}


function add_event_blox_element_duplicator(){
	
    jQuery('.blox_duplicator').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'input',
                id: 'blox_element_option_title',
                label: 'Title',
                value: $this.find('.blox_item_duplicator_title').html()

            }, 
            {
                type: 'number',
                id: 'blox_element_option_total',
                label: 'Total amount',
                std: 12,
                value: $this.find('.blox_item_duplicator_total').html()

            },                			
            {
                type: 'number',
                id: 'blox_element_option_number',
                std: 5,
                label: 'Fill Number',
                value: $this.find('.blox_item_duplicator_number').html()

            },
            {
                type: 'colorpicker',
                id: 'blox_element_option_color',
                label: 'Color',
                value: $this.find('.blox_item_duplicator_color').html(),
                description: 'Icon color.'
            },
            {
                type: 'icon',
                id: 'blox_element_option_icon',
                label: 'Icon',
                value: $this.find('.blox_item_duplicator_icon').html()

            },
            {
                type: 'number',
                id: 'blox_element_option_size',
                std: 32,
                label: 'Icon Size',
                value: $this.find('.blox_item_duplicator_size').html()
            },
            {
                type: 'number',
                id: 'blox_element_option_number2',
                std: 0,
                label: 'Fill Number 2 (optional)',
                value: $this.find('.blox_item_duplicator_number2').html(),
                description: 'You should set number value here If you need second filled icons.'
            },
            {
                type: 'colorpicker',
                id: 'blox_element_option_color2',
                label: 'Color 2',
                value: $this.find('.blox_item_duplicator_color2').html(),
                description: 'Icon color for Fill Number 2.'
            },
            {
                type: 'select',
                id: 'blox_element_option_align',
                label: 'Align',
                value: $this.find('.blox_item_duplicator_align').html(),
                options: [
                {
                    value: 'left',
                    label: 'Left'
                },
                {
                    value: 'right',
                    label: 'Right'
                },
                {
                    value: 'center',
                    label: 'Center'
                }
                ]
            },
            {
                type: 'input',
                id: 'blog_element_extra_class',
                label: 'Extra Class',
                value: $this.find('.blox_item_duplicator_extra_class').html()
            }
            ];

            show_blox_form('Edit Duplicator', form_element, function($form){
                $this.find('.blox_item_duplicator_title').html(   jQuery('#blox_element_option_title').val() );
                $this.find('.blox_item_duplicator_total').html(   jQuery('#blox_element_option_total').val() );
                $this.find('.blox_item_duplicator_number').html(   jQuery('#blox_element_option_number').val() );
                $this.find('.blox_item_duplicator_number2').html(   jQuery('#blox_element_option_number2').val() );
                $this.find('.blox_item_duplicator_icon').html(   jQuery('#blox_element_option_icon').val() );
                $this.find('.blox_item_duplicator_color').html( jQuery('#blox_element_option_color').val() );
                $this.find('.blox_item_duplicator_color2').html( jQuery('#blox_element_option_color2').val() );
                $this.find('.blox_item_duplicator_size').html(   jQuery('#blox_element_option_size').val() );
                $this.find('.blox_item_duplicator_align').html(   jQuery('#blox_element_option_align').val() );
                $this.find('.blox_item_duplicator_extra_class').html( jQuery('#blog_element_extra_class').val() );
            });

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_duplicator();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
