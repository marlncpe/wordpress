
function get_blox_element_button($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
    return '<div class="blox_item blox_button" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Button</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_button_text">'+($content!=undefined && $content.find('.text').length>0 ? $content.find('.text').html() : '')+'</div>'
                + '<div class="blox_item_button_link">'+($content!=undefined && $content.find('.link').length>0 ? $content.find('.link').html() : '')+'</div>'
                + '<div class="blox_item_button_target">'+($content!=undefined && $content.find('.target').length>0 ? $content.find('.target').html() : '')+'</div>'
                + '<div class="blox_item_button_style">'+($content!=undefined && $content.find('.style').length>0 ? $content.find('.style').html() : '')+'</div>'
                + '<div class="blox_item_border_style">'+($content!=undefined && $content.find('.border').length>0 ? $content.find('.border').html() : '')+'</div>'
                + '<div class="blox_item_button_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                + '<div class="blox_item_button_icon">'+($content!=undefined && $content.find('.icon').length>0 ? $content.find('.icon').html() : '')+'</div>'
                + '<div class="blox_item_button_size">'+($content!=undefined && $content.find('.size').length>0 ? $content.find('.size').html() : '')+'</div>'
                + '<div class="blox_item_button_align">'+($content!=undefined && $content.find('.align').length>0 ? $content.find('.align').html() : '')+'</div>'
                + '<div class="blox_item_button_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
                + '<div class="blox_item_button_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_button($content){
    $content = wp.shortcode.replace( 'blox_button', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='text' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='target' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='link' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }                                
                if( key=='style' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='border' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='icon' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color' ){
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
                if( key=='animation' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
            }
        });		
        return get_blox_element_button(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}


function revert_button_shortcode_hook($this){
    attr = '';
    var temp_val = '';

    temp_val = $this.find('.blox_item_button_text').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' text="'+temp_val+'"';
    }
            
    temp_val = $this.find('.blox_item_button_link').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' link="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_button_target').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' target="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_button_style').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' style="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_border_style').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' border="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_button_color').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' color="'+temp_val+'"';
    }
            
    temp_val = $this.find('.blox_item_button_icon').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' icon="'+temp_val+'"';
    }
            
    temp_val = $this.find('.blox_item_button_size').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' size="'+temp_val+'"';
    }
            
    temp_val = $this.find('.blox_item_button_align').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' align="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_button_animation').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' animation="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_button_extra_class').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' extra_class="'+temp_val+'"';
    }
    
    $this.replaceWith('[blox_button'+attr+'/]');
}

function revert_shortcode_button($content){
    $content.find('.blox_button').each(function(){
        revert_button_shortcode_hook( jQuery(this) );
    });
    return $content;
}


function add_event_blox_element_button(){
	
    jQuery('.blox_button').each(function(){
        var $this = jQuery(this);

        if( !$this.parent().hasClass('blox_container') ){
            revert_button_shortcode_hook( $this );
        }
        else{

            $this.find('.blox_item_actions .action_edit').unbind('click')
                .click(function(){

                    var form_element = [
                    {
                        type: 'input',
                        id: 'blox_element_option_text',
                        label: 'Button text',
                        value: $this.find('.blox_item_button_text').html()

                    },
                    {
                        type: 'input',
                        id: 'blox_element_option_link',
                        label: 'Link',
                        value: $this.find('.blox_item_button_link').html()

                    },
                    {
                        type: 'checkbox_flat',
                        id: 'blox_element_option_target',
                        label: 'Open link in a new tab?',
                        value: $this.find('.blox_item_button_target').html(),
                        options: [
                            { value: '_self', label: 'Same window' },
                            { value: '_blank', label: 'In a new tab' }
                        ]
                    },
                    {
                        type: 'select',
                        id: 'blox_element_option_style',
                        label: 'Style',
                        value: $this.find('.blox_item_button_style').html(),
                        options: [
                            { value: 'default', label: 'Default Button' },
                            { value: 'flat', label: 'Flat Button' },
                            { value: 'metro', label: 'Metro Button' },
                            { value: '3d', label: '3D Button' }
                        ]
                    },
                    {
                        type: 'select',
                        id: 'blox_elem_option_border_style',
                        label: 'Border Style',
                        value: $this.find('.blox_item_border_style').html(),
                        options: [
                            { value: '', label: 'Default' },
                            { value: 'bordered', label: 'Bordered Button' },
                            { value: 'circle', label: 'Circle Button' },
                            { value: 'rectangle', label: 'Rectangle Button' }     
                        ]
                    },
                    {
                        type: 'select',
                        id: 'blox_element_option_size',
                        label: 'Button Size',
                        value: $this.find('.blox_item_button_size').html(),
                        options: [
                            { value: 'small', label: 'Small' },
                            { value: 'medium', label: 'Medium' },
                            { value: 'large', label: 'Large' },
                            { value: 'xlarge', label: 'Extra Large' } 
                        ]
                    },
                    {
                        type: 'colorpicker',
                        id: 'blox_elem_option_color',
                        label: 'Button Color',
                        value: $this.find('.blox_item_button_color').html()
                    },
                    {
                        type: 'icon',
                        id: 'blox_element_option_icon',
                        label: 'Icon',
                        value: $this.find('.blox_item_button_icon').html()
                    },
                    {
                        type: 'select',
                        id: 'blox_element_option_align',
                        label: 'Align',
                        value: $this.find('.blox_item_button_align').html(),
                        options: [
                            { value: 'left', label: 'Left' },
                            { value: 'right', label: 'Right' },
                            { value: 'center', label: 'Center' }
                        ]

                    }
                    ];

                    $this.attr('animation', $this.find('.blox_item_button_animation').html());
                    $this.attr('extra_class', $this.find('.blox_item_button_extra_class').html());

                    show_blox_form('Edit Button', form_element, function($form){
                        $this.find('.blox_item_button_text').html(   jQuery('#blox_element_option_text').val() );
                        $this.find('.blox_item_button_link').html(   jQuery('#blox_element_option_link').val() );
                        $this.find('.blox_item_button_target').html( jQuery('#blox_element_option_target').val() );
                        $this.find('.blox_item_button_style').html(  jQuery('#blox_element_option_style').val() );
                        $this.find('.blox_item_border_style').html( jQuery('#blox_elem_option_border_style').val() );
                        $this.find('.blox_item_button_color').html(  jQuery('#blox_elem_option_color').val() );
                        $this.find('.blox_item_button_icon').html(   jQuery('#blox_element_option_icon').val() );
                        $this.find('.blox_item_button_size').html( jQuery('#blox_element_option_size').val() );
                        $this.find('.blox_item_button_align').html(  jQuery('#blox_element_option_align').val() );
                        
                        $this.find('.blox_item_button_animation').html( $this.attr('animation') );
                        $this.find('.blox_item_button_extra_class').html( $this.attr('extra_class') );
                    },
                    {
                        target: $this,
                        extra_field: true
                    });

                });
                    
                
            $this.find('.blox_item_actions .action_clone').unbind('click')
            .click(function(){
                $this.after($this.clone());
                add_event_blox_element_button();
            });
                
            $this.find('.blox_item_actions .action_remove').unbind('click')
            .click(function(){
                $this.remove();
            });

        }
    });
	
}
