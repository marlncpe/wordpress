
function get_blox_element_video($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
	
    return '<div class="blox_item blox_video" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-facetime-video"></i> \
                        <span class="blox_item_title">Video</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;">'
                    + '<div class="blox_item_widget_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
                    + '<div class="blox_item_video_type">'+($content!=undefined && $content.find('.type').length>0 ? $content.find('.type').html() : '')+'</div>'
                    + '<div class="blox_item_video_url">'+($content!=undefined && $content.find('.video').length>0 ? $content.find('.video').html() : '')+'</div>'
                    + '<div class="blox_item_video_img">'+($content!=undefined && $content.find('.poster').length>0 ? $content.find('.poster').html() : '')+'</div>'
                    + '<div class="blox_item_video_embed">'+($content!=undefined && $content.find('.embed').length>0 ? $content.find('.embed').html() : '')+'</div>'
                    + '<div class="blox_item_video_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                    + '<div class="blox_item_widget_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
    </div>';
}


function parse_shortcode_video($content){
    $content = wp.shortcode.replace( 'blox_video', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='title' ){
                    attrs += '<div class="title">'+value+'</div>';
                }
                if( key=='type' ){
                    attrs += '<div class="type">'+value+'</div>';
                }
                if( key=='url' ){
                    attrs += '<div class="video">'+value+'</div>';
                }
                if( key=='poster' ){
                    attrs += '<div class="poster">'+value+'</div>';
                }
                if( key=='embed' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="extra_class">'+value+'</div>';
                }
            }
        })
		
        return get_blox_element_video(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_video($content){
    $content.find('.blox_video').each(function(){
        attr = '';
        var temp_val = '';
        if( jQuery(this).find('.blox_item_widget_title').html()!='undefined' && jQuery(this).find('.blox_item_widget_title').html()!='' ){
            attr += ' title="'+jQuery(this).find('.blox_item_widget_title').html()+'"';
        }

        temp_val = jQuery(this).find('.blox_item_video_type').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' type="'+temp_val+'"';
        }

        if( jQuery(this).find('.blox_item_video_url').html()!='undefined' && jQuery(this).find('.blox_item_video_url').html()!='' ){
            attr += ' url="'+jQuery(this).find('.blox_item_video_url').html()+'"';
        }

        temp_val = jQuery(this).find('.blox_item_video_img').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' poster="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_video_embed').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' embed="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_video_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }

        if( jQuery(this).find('.blox_item_widget_extra_class').html()!='undefined' && jQuery(this).find('.blox_item_widget_extra_class').html()!='' ){
            attr += ' extra_class="'+jQuery(this).find('.blox_item_widget_extra_class').html()+'"';
        }
		
        jQuery(this).replaceWith('[blox_video'+attr+']');
    });
    return $content;
}


function add_event_blox_element_video(){
	
    jQuery('.blox_video').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'input',
                id: 'edit_form_widget_title',
                label: 'Item Title',
                value: $this.find('.blox_item_widget_title').html()

            },
            {
                type: 'select',
                id: 'video_type',
                label: 'Target',
                value: $this.find('.blox_item_video_type').html(),
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
                type: 'video',
                id: 'edit_form_video_url',
                label: 'Video URL',
                value: $this.find('.blox_item_video_url').html()

            },
            {
                type: 'image',
                id: 'edit_form_video_img',
                label: 'Video poster image for self hosted video',
                value: $this.find('.blox_item_video_img').html()

            },
            {
                type: 'textarea',
                id: 'video_embed',
                label: 'Embed code',
                value: decodeURIComponent($this.find('.blox_item_video_embed').html())

            },
            {
                type: 'colorpicker',
                id: 'video_elem_option_color',
                label: 'Player Color',
                value: $this.find('.blox_item_video_color').html(),
                description: 'Self hosted video plays with HTML player and it is possible to change color of that. If you selected local video on above, you should set color of player.'
            },
            {
                type: 'input',
                id: 'edit_form_widget_class',
                label: 'Extra Class',
                value: $this.find('.blox_item_widget_extra_class').html()
            }
            ];

            show_blox_form('Edit Video element', form_element, function($form){
                $this.find('.blox_item_widget_title').html( jQuery('#edit_form_widget_title').val() );
                $this.find('.blox_item_video_type').html( jQuery('#video_type').val() );
                $this.find('.blox_item_video_url').html( jQuery('#edit_form_video_url').val() );
                $this.find('.blox_item_video_img').html( jQuery('#edit_form_video_img').val() );
                $this.find('.blox_item_video_embed').html( encodeURIComponent(jQuery('#video_embed').val()) );
                $this.find('.blox_item_video_color').html( jQuery('#video_elem_option_color').val() );
                $this.find('.blox_item_widget_extra_class').html( jQuery('#edit_form_widget_class').val() ); 
            });
        	
            jQuery('#video_type').change(function(){
                if( jQuery('#video_type').val() == 'url' ){
                    jQuery('#video_embed').parent().hide();
                    jQuery('#edit_form_video_url').parent().show();
                    jQuery('#edit_form_video_img').parent().show();
                }
                else{
                    jQuery('#edit_form_video_url').parent().hide();
                    jQuery('#edit_form_video_img').parent().hide();
                    jQuery('#video_embed').parent().show();
                }
            });
            jQuery('#video_type').change();
        });
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_video();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
