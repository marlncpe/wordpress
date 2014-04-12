
function get_blox_element_googlemaps($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
    return '<div class="blox_item blox_gmap" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-user"></i> \
					<span class="blox_item_title">Google Maps</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_gmap_select">'+($content!=undefined && $content.find('.select').length>0 ? $content.find('.select').html() : '')+'</div>'
                + '<div class="blox_item_gmap_lat">'+($content!=undefined && $content.find('.lat').length>0 ? $content.find('.lat').html() : '')+'</div>'
                + '<div class="blox_item_gmap_long">'+($content!=undefined && $content.find('.long').length>0 ? $content.find('.long').html() : '')+'</div>'
                + '<div class="blox_item_gmap_embed">'+($content!=undefined && $content.find('.embed').length>0 ? $content.find('.embed').html() : '')+'</div>'
                + '<div class="blox_item_gmap_zoom">'+($content!=undefined && $content.find('.zoom').length>0 ? $content.find('.zoom').html() : '')+'</div>'
                + '<div class="blox_item_gmap_type">'+($content!=undefined && $content.find('.type').length>0 ? $content.find('.type').html() : '')+'</div>'
                + '<div class="blox_item_gmap_height">'+($content!=undefined && $content.find('.height').length>0 ? $content.find('.height').html() : '')+'</div>'
                + '<div class="blox_item_gmap_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_googlemaps($content){
    $content = wp.shortcode.replace( 'blox_gmap', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='select' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='zoom' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }                                               
                if( key=='type' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='height' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='lat' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='long' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
            }
                        
        });
        attrs += '<div class="embed">'+data.content+'</div>';				
        return get_blox_element_googlemaps(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_googlemaps($content){
    $content.find('.blox_gmap').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_gmap_select').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' select="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_gmap_lat').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' lat="'+temp_val+'"';
        }        
        temp_val = jQuery(this).find('.blox_item_gmap_long').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' long="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gmap_type').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' type="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gmap_zoom').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' zoom="'+temp_val+'"';
        }
                
        temp_val = jQuery(this).find('.blox_item_gmap_height').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            var_social = temp_val;
            var_social = var_social.replace(/\n/g, ',');
            attr += ' height="'+var_social+'"';
        }
               
        temp_val = jQuery(this).find('.blox_item_gmap_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_gmap'+attr+']'+jQuery(this).find('.blox_item_gmap_embed').html()+'[/blox_gmap]');
    });
    return $content;
}


function add_event_blox_element_googlemaps(){
	
    jQuery('.blox_gmap').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'select',
                id: 'blox_element_option_select',
                label: 'Custom map?',
                value: $this.find('.blox_item_gmap_select').html(),
                options: [
                    {value: 'embed',label: 'Embed code'},
                    {value: 'custom',label: 'Custom map settings'}
                ]
            },
            {
                type: 'textarea',
                id: 'blox_element_option_embed',
                label: 'Map Embed',
                value: $this.find('.blox_item_gmap_embed').html()
            },
            {
                type: 'input',
                id: 'blox_element_option_lat',
                label: 'Latitude',
                value: $this.find('.blox_item_gmap_lat').html(),
                std: '48.856614',
                description: 'Latitude: 48.856614'
            },
            {
                type: 'input',
                id: 'blox_element_option_long',
                label: 'Longitute',
                value: $this.find('.blox_item_gmap_long').html(),
                std: '2.352222',
                description: 'Longitute: 2.352222'
            },
            {
                type: 'select',
                id: 'blox_element_option_type',
                label: 'View Type',
                value: $this.find('.blox_item_gmap_type').html(),
                options: [
                    {value: 'ROADMAP',label: 'Map'},
                    {value: 'SATELLITE',label: 'Satellite'},
                    {value: 'TERRAIN',label: 'Terrain'}
                ]
            },
            {
                type: 'number',
                id: 'blox_element_option_zoom',
                label: 'Zoom',
                std: 14,
                value: $this.find('.blox_item_gmap_zoom').html(),
                description: 'Zoom value have to 1 to 20. Default: 14.'
            },
            {
                type: 'number',
                id: 'blox_element_option_height',
                label: 'Map Height',
                std: 400,
                value: $this.find('.blox_item_gmap_height').html()
            },
            {
                type: 'input',
                id: 'blox_element_extra_class',
                label: 'Extra Class',
                value: $this.find('.blox_item_gmap_extra_class').html()
            }
            ];

            show_blox_form('Edit Google Map', form_element, function($form){
                $this.find('.blox_item_gmap_select').html(   jQuery('#blox_element_option_select').val() );
                $this.find('.blox_item_gmap_embed').html( jQuery('#blox_element_option_embed').val() );
                $this.find('.blox_item_gmap_lat').html(   jQuery('#blox_element_option_lat').val() );                        
                $this.find('.blox_item_gmap_long').html(   jQuery('#blox_element_option_long').val() );                        
                $this.find('.blox_item_gmap_height').html(  jQuery('#blox_element_option_height').val() );
                $this.find('.blox_item_gmap_zoom').html(   jQuery('#blox_element_option_zoom').val() );
                $this.find('.blox_item_gmap_type').html(   jQuery('#blox_element_option_type').val() );
                $this.find('.blox_item_gmap_extra_class').html( jQuery('#blox_element_extra_class').val() );
            });

            jQuery('#blox_element_option_select').change(function(){
                if( this.value=='embed' ){
                    jQuery('#blox_element_option_embed').parent().show();
                    jQuery('#blox_element_option_lat,#blox_element_option_long,#blox_element_option_type, #blox_element_option_zoom').parent().hide();
                }
                else{
                    jQuery('#blox_element_option_embed').parent().hide();
                    jQuery('#blox_element_option_lat,#blox_element_option_long,#blox_element_option_type, #blox_element_option_zoom').parent().show();
                }
            });
            jQuery('#blox_element_option_select').change();

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_gmap();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
