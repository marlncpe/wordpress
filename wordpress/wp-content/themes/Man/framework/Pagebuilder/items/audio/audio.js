
function get_blox_element_audio($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_audio" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-user"></i> \
                        <span class="blox_item_title">Audio Player</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;">'
                    + '<div class="blox_item_audio_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
                    + '<div class="blox_item_audio_type">'+($content!=undefined && $content.find('.type').length>0 ? $content.find('.type').html() : '')+'</div>'
                    + '<div class="blox_item_audio_url">'+($content!=undefined && $content.find('.url').length>0 ? $content.find('.url').html() : '')+'</div>'
                    + '<div class="blox_item_audio_embed">'+($content!=undefined && $content.find('.embed').length>0 ? $content.find('.embed').html() : '')+'</div>'
                    + '<div class="blox_item_audio_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                    + '<div class="blox_item_audio_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                    + '<div class="blox_item_audio_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
                +'</div> \
    </div>';
}


function parse_shortcode_audio($content){
    $content = wp.shortcode.replace( 'blox_audio', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='title' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='type' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='url' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='embed' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='animation' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
            }
        })
		
        return get_blox_element_audio(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_audio($content){
    $content.find('.blox_audio').each(function(){
        attr = '';
        var temp_val = '';
        temp_val = jQuery(this).find('.blox_item_audio_title').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_audio_type').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' type="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_audio_url').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' url="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_audio_embed').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' embed="'+temp_val+'"';
        }
		
        temp_val = jQuery(this).find('.blox_item_audio_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_audio_animation').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' animation="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_audio_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_audio'+attr+']');
    });
    return $content;
}


function add_event_blox_element_audio(){
	
    jQuery('.blox_audio').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'input',
                id: 'audio_title',
                label: 'Title',
                value: $this.find('.blox_item_audio_title').html()

            },
            {
                type: 'select',
                id: 'audio_type',
                label: 'Target',
                value: $this.find('.blox_item_audio_type').html(),
                options: [
                {
                    value: 'url',
                    label: 'By URL'
                },

                {
                    value: 'embed',
                    label: 'Custom Embed'
                }
                ]
            },
            {
                type: 'file',
                id: 'audio_url',
                label: 'Audio URL',
                value: $this.find('.blox_item_audio_url').html()

            },
            {
                type: 'textarea',
                id: 'audio_embed',
                label: 'Embed code',
                value: decodeURIComponent($this.find('.blox_item_audio_embed').html())

            },
            {
                type: 'colorpicker',
                id: 'audio_elem_option_color',
                label: 'Player Color (optional)',
                value: $this.find('.blox_item_audio_color').html(),
                description: 'Select proper color for your HTML5 player.'
            }
            ];

            $this.attr('animation', $this.find('.blox_item_audio_animation').html());
            $this.attr('extra_class', $this.find('.blox_item_audio_extra_class').html());

            show_blox_form('Edit Audio element', form_element, function($form){
                $this.find('.blox_item_audio_title').html( jQuery('#audio_title').val() );
                $this.find('.blox_item_audio_type').html( jQuery('#audio_type').val() );
                $this.find('.blox_item_audio_url').html( jQuery('#audio_url').val() );
                $this.find('.blox_item_audio_embed').html( encodeURIComponent(jQuery('#audio_embed').val()) );
                $this.find('.blox_item_audio_color').html( jQuery('#audio_elem_option_color').val() );

                $this.find('.blox_item_audio_animation').html( $this.attr('animation') );
                $this.find('.blox_item_audio_extra_class').html( $this.attr('extra_class') );
            },
            {
                target: $this,
                extra_field: true
            });
            
            //Folds
            jQuery('#audio_type').change(function(){
                if( jQuery('#audio_type').val() == 'url' ){
                    jQuery('#audio_embed').parent().hide();
                    jQuery('#audio_url').parent().show();
                    jQuery('.wp-picker-container').parent().show();
                }
                else{
                    jQuery('#audio_url').parent().hide();
                    jQuery('#audio_embed').parent().show();
                    jQuery('.wp-picker-container').parent().hide();
                }
            });
            jQuery('#audio_type').change();

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_audio();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}