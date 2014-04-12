
function get_blox_element_carousel($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
	
    return '<div class="blox_item blox_carousel" '+($attrs!=undefined ? $attrs : '')+'> \
            <div class="blox_item_title"> \
                    <i class="icon-fixed-width"></i> \
                    <span class="blox_item_title">Carousel</span> \
                    '+$tools+' \
            </div> \
            <div class="blox_item_content" style="display: none;">'
            + '<div class="blox_item_widget_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
            + '<div class="blox_item_post_type">'+($content!=undefined && $content.find('.post_type').length>0 ? $content.find('.post_type').html() : '')+'</div>'
            + '<div class="blox_item_post_category">'+($content!=undefined && $content.find('.category').length>0 ? $content.find('.category').html() : '')+'</div>'
            + '<div class="blox_item_post_count">'+($content!=undefined && $content.find('.count').length>0 ? $content.find('.count').html() : '')+'</div>'
            + '<div class="blox_item_overlay">'+($content!=undefined && $content.find('.overlay').length>0 ? $content.find('.overlay').html() : '')+'</div>'
            + '<div class="blox_item_widget_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
            + '<div class="blox_item_widget_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
            +'</div> \
    </div>';
}


function parse_shortcode_carousel($content){
    $content = wp.shortcode.replace( 'blox_carousel', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                attrs += '<div class="'+key+'">'+value+'</div>';
            }
        });
		
        return get_blox_element_carousel(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_carousel($content){
    $content.find('.blox_carousel').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_widget_title').html();
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_post_type').html();
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' post_type="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_post_category').html();
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' category="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_post_count').html();
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' count="'+temp_val+'"';
        }
        
        temp_val = jQuery(this).find('.blox_item_overlay').html();
        if( temp_val!='undefined' && temp_val!='' ){
            //attr += ' style="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_widget_extra_class').html();
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_widget_animation').html();
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' animation="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_carousel'+attr+']');
    });
    return $content;
}


function add_event_blox_element_carousel(){
	
    jQuery('.blox_carousel').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            $this.attr('animation', $this.find('.blox_item_widget_animation').html());
            $this.attr('extra_class', $this.find('.blox_item_widget_extra_class').html());

            var ajax_params = {
                'action': 'get_blox_element_carousel', 
                'title': $this.find('.blox_item_widget_title').html(),
                'post_type': $this.find('.blox_item_post_type').html(),
                'category': $this.find('.blox_item_post_category').html(), 
                'count': $this.find('.blox_item_post_count').html(), 
                'overlay': $this.find('.blox_item_overlay').html()
            };
            show_blox_form_ajax("Edit Carousel Element", ajax_params, function(){
                $this.find('.blox_item_widget_title').html( jQuery('#blox_el_option_title').val() );
                $this.find('.blox_item_post_type').html( jQuery('#blox_option_post_type').val() );
                $this.find('.blox_item_post_category').html( jQuery('#blox_option_taxonomy_'+jQuery('#blox_option_post_type').val()).val() );
                $this.find('.blox_item_post_count').html( jQuery('#blox_option_posts_count').val() );
                $this.find('.blox_item_overlay').html( jQuery('#blox_option_carousel_overlay').val() );

                $this.find('.blox_item_widget_animation').html($this.attr('animation'));
                $this.find('.blox_item_widget_extra_class').html($this.attr('extra_class'));
            },
            {
                target: $this,
                extra_field: true,
                ajax_handler: function(){
                    jQuery('#blox_option_post_type').change(function(){
                        jQuery('.blox_option_taxonomies').hide();
                        jQuery('#blox_option_taxonomy_'+jQuery(this).val()).show();
                    });

                    jQuery('#blox_popup_window').find('.select_data_val').each(function(){
                        var $val = jQuery(this).attr('data_val');
                        jQuery(this).val($val).change();
                    });

                    jQuery('#blox_option_taxonomy_'+jQuery('#blox_option_post_type').val()).val(jQuery('#blox_option_post_type').attr('data_cat')).change();
                }
            });
        		
        });
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_carousel();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
