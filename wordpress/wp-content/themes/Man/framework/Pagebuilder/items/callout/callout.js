

function get_blox_element_callout($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_callout" '+($attrs!=undefined ? $attrs : '')+'><div class="blox_item_title"><i class="icon-mail-forward"></i> Callout: <span class="blox_callout_title"></span>'+$tools+'</div><div class="blox_item_content">'+($content!=undefined ? $content : '')+'</div></div>';
}


function parse_shortcode_callout($content){
    $content = wp.shortcode.replace( 'blox_callout', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){

                if( key=='title' ){
                    attrs += 'title="'+value+'" ';
                }
                if( key=='box_style' ){
                    attrs += 'box_style="'+value+'" ';
                }
                if( key=='bgcolor' ){
                    attrs += 'bgcolor="'+value+'" ';
                }
                if( key=='margin' ){
                    attrs += 'margin="'+value+'" ';
                }
                if( key=='animation' ){
                    attrs += 'animation="'+value+'" ';
                }
                if( key=='extra_class' ){
                    attrs += 'extra_class="'+value+'" ';
                }
            }
        })
        return get_blox_element_callout(data.content, attrs);
    });
    return $content;
}


function revert_shortcode_callout($content){
    $content.find('.blox_callout').each(function(){
        attr = '';
        var temp_val = '';
        
        temp_val = jQuery(this).attr('title')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }

        temp_val = jQuery(this).attr('bgcolor')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' bgcolor="'+temp_val+'"';
        }
		
        temp_val = jQuery(this).attr('box_style')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' box_style="'+temp_val+'"';
        }

        temp_val = jQuery(this).attr('margin')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' margin="'+temp_val+'"';
        }

        temp_val = jQuery(this).attr('animation')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' animation="'+temp_val+'"';
        }

        temp_val = jQuery(this).attr('extra_class')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_callout'+attr+']'+jQuery(this).find('> .blox_item_content').html()+'[/blox_callout]');
    });
	
    return $content;
}


function add_event_blox_element_callout(){
	
    jQuery('.blox_callout').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            
            var form_element = [
                        {
                            type: 'input',
                            id: 'blox_title',
                            label: 'Title',
                            value: $this.attr('title')
                        },
                        {
                            type: 'editor',
                            id: 'blox_option_editor',
                            label: 'Content',
                            value: $this.find('.blox_item_content').html()
                        },
                        {
                            type: 'select',
                            id: 'blox_boxstyle',
                            label: 'Callout Box Style',
                            value: $this.attr('box_style'),
                            options: [
                                        {
                                            value: 'blox_elem_callout_clean',
                                            label: 'Clean Style'
                                        },
                                        {
                                            value: 'blox_elem_callout_flat',
                                            label: 'Flat style'
                                        },
                                        {
                                            value: 'blox_elem_callout_centered',
                                            label: 'Centered style'
                                        },
                                        {
                                            value: 'blox_elem_callout_metro',
                                            label: 'Metro style'
                                        }
                                    ],
                              description: "You should visit <a href='http://themeton.freshdesk.com/support/solutions/articles/152077-callout-element' target='_blank'>this link</a> and see how these styles look like."
                        },
                        {
                            type: 'colorpicker',
                            id: 'blox_bgcolor',
                            label: 'Background Color',
                            value: $this.attr('bgcolor'),
                            description: 'Pick a color for Metro Callout Style.'
                        },
                        {
                            type: 'number',
                            id: 'blox_margin',
                            label: 'Content Margin Right Size',
                            value: $this.attr('margin'),
                            description: 'If you need to align text space and add button on right side, you should set here value.'
                        }
                    ];

            show_blox_form('Edit Callout', form_element, function($form){
                $this.find('.blox_item_content').html(get_content_tinymce());
                $this.attr('title', jQuery('#blox_title').val());
                $this.attr('box_style', jQuery('#blox_boxstyle').val());
                $this.attr('bgcolor', jQuery('#blox_bgcolor').val());
                $this.attr('margin', jQuery('#blox_margin').val());
            },
            {
                target: $this,
                extra_field: true
            });
            
            // Folds
            jQuery('#blox_boxstyle').change(function(){
                if( jQuery('#blox_boxstyle').val() == 'blox_elem_callout_metro' ){
                    jQuery('.wp-picker-container').parent().show();
                }
                else{
                    jQuery('.wp-picker-container').parent().hide();
                }
            });
            jQuery('#blox_boxstyle').change();
            
            
        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_callout();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
