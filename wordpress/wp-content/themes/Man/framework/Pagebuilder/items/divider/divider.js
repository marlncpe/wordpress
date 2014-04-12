
function get_blox_element_divider($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_divider" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-user"></i> \
                        <span class="blox_item_title">Divider / Space</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;">'
    + '<div class="blox_item_divider_text">'+($content!=undefined && $content.find('.text').length>0 ? $content.find('.text').html() : '')+'</div>'
    + '<div class="blox_item_divider_style">'+($content!=undefined && $content.find('.style').length>0 ? $content.find('.style').html() : '')+'</div>'
    + '<div class="blox_item_divider_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
    + '<div class="blox_item_divider_height">'+($content!=undefined && $content.find('.height').length>0 ? $content.find('.height').html() : '')+'</div>'
    + '<div class="blox_item_divider_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
    +'</div> \
        </div>';
}


function parse_shortcode_divider($content){
    $content = wp.shortcode.replace( 'blox_divider', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='text' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='style' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='height' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
            }
        });		
        return get_blox_element_divider(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_divider($content){
    $content.find('.blox_divider').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_divider_text').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' text="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_divider_style').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' style="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_divider_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_divider_height').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' height="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_divider_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_divider'+attr+'/]');
    });
    return $content;
}


function add_event_blox_element_divider(){
	
    jQuery('.blox_divider').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'select',
                id: 'blox_element_option_style',
                label: 'Style',
                value: $this.find('.blox_item_divider_style').html(),
                options: [
                {
                    value: 'style1',
                    label: 'Solid Line'
                },
                {
                    value: 'style2',
                    label: 'Dotted Line'
                },
                {
                    value: 'style3',
                    label: 'Dashed Line'
                },
                {
                    value: 'style4',
                    label: 'Line + Shadow'
                },
                {
                    value: 'style5',
                    label: 'Shadow'
                },
                {
                    value: 'style6',
                    label: 'Line + Top Text'
                },
                {
                    value: 'style7',
                    label: '5px Line + Color'
                },
                {
                    value: 'style8',
                    label: 'Centered 5px Line + Color'
                },
                {
                    value: 'style9',
                    label: 'Centered Solid Line'
                },
                {
                    value: 'style10',
                    label: 'Centered Dashed Line'
                },
                {
                    value: 'style11',
                    label: 'Space'
                }
                ]
            },
            {
                type: 'input',
                id: 'blox_element_option_text',
                label: 'Go to top text',
                value: $this.find('.blox_item_divider_text').html()

            },
            {
                type: 'colorpicker',
                id: 'blox_element_option_color',
                label: 'Color',
                value: $this.find('.blox_item_divider_color').html()
            },
            {
                type: 'number',
                id: 'blox_element_option_height',
                label: 'Space',
                std: 5,
                value: $this.find('.blox_item_divider_height').html()
            },
            {
                type: 'input',
                id: 'blog_element_extra_class',
                label: 'Extra Class',
                value: $this.find('.blox_item_divider_extra_class').html()
            }
            ];

            show_blox_form('Edit Divider', form_element, function($form){
                $this.find('.blox_item_divider_text').html(   jQuery('#blox_element_option_text').val() );
                $this.find('.blox_item_divider_style').html(  jQuery('#blox_element_option_style').val() );
                $this.find('.blox_item_divider_color').html(  jQuery('#blox_element_option_color').val() );
                $this.find('.blox_item_divider_height').html(  jQuery('#blox_element_option_height').val() );
                $this.find('.blox_item_divider_extra_class').html( jQuery('#blog_element_extra_class').val() );
            });
            
            // Folds
            jQuery('#blox_element_option_style').change(function(){
                if( jQuery('#blox_element_option_style').val() == 'style6' ){
                    jQuery('#blox_element_option_text').parent().show();
                }else{
                    jQuery('#blox_element_option_text').parent().hide();
                }
            });
            jQuery('#blox_element_option_style').change();

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_divider();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
