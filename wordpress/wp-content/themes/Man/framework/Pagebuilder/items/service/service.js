
function get_blox_element_service($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	
    return '<div class="blox_item blox_service" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-asterisk"></i> \
					<span class="blox_item_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : 'Service Block')+'</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_service_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
                + '<div class="blox_item_service_icon">'+($content!=undefined && $content.find('.icon').length>0 ? $content.find('.icon').html() : '')+'</div>'
                + '<div class="blox_item_service_icon_size">'+($content!=undefined && $content.find('.icon_size').length>0 ? $content.find('.icon_size').html() : '')+'</div>'
                + '<div class="blox_item_service_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                + '<div class="blox_item_service_bgcolor">'+($content!=undefined && $content.find('.bgcolor').length>0 ? $content.find('.bgcolor').html() : '')+'</div>'
                + '<div class="blox_item_service_content">'+($content!=undefined && $content.find('.content').length>0 ? $content.find('.content').html() : '')+'</div>'
                + '<div class="blox_item_service_layout">'+($content!=undefined && $content.find('.layout').length>0 ? $content.find('.layout').html() : '')+'</div>'
                + '<div class="blox_item_service_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
                + '<div class="blox_item_service_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_service($content){
    $content = wp.shortcode.replace( 'blox_service', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='title' ){
                    attrs += '<div class="title">'+value+'</div>';
                }
                if( key=='icon' ){
                    attrs += '<div class="icon">'+value+'</div>';
                }
                if( key=='icon_size' ){
                    attrs += '<div class="icon_size">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="color">'+value+'</div>';
                }
                if( key=='bgcolor' ){
                    attrs += '<div class="bgcolor">'+value+'</div>';
                }
                if( key=='layout' ){
                    attrs += '<div class="layout">'+value+'</div>';
                }
                if( key=='extra_class' ){
                    attrs += '<div class="extra_class">'+value+'</div>';
                }
                if( key=='animation' ){
                    attrs += '<div class="animation">'+value+'</div>';
                }
            }
        })
        attrs += '<div class="content">'+data.content+'</div>';
		
        return get_blox_element_service(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_service($content){
    $content.find('.blox_service').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_service_title').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_icon').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' icon="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_icon_size').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' icon_size="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_bgcolor').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' bgcolor="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_layout').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' layout="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_service_animation').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' animation="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_service'+attr+']'+jQuery(this).find('.blox_item_service_content').html()+'[/blox_service]');
    });
    return $content;
}


function validate_url(s) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(s);
}

function add_event_blox_element_service(){
	
    jQuery('.blox_service').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){
            
            var form_element = [
                        {
                            type: 'input',
                            id: 'service_title',
                            label: 'Title',
                            value: $this.find('.blox_item_service_title').html()
                        },
                        {
                            type: 'textarea',
                            id: 'service_content',
                            label: 'Service Block Text',
                            value: $this.find('.blox_item_service_content').html()
                        },
                        {
                            type: 'select',
                            id: 'service_layout',
                            label: 'Service Block Layout',
                            value: $this.find('.blox_item_service_layout').html(),
                            options: [
                                { value: 'style1', label: '1. Left Icon + Title + Content' },
                                { value: 'style2', label: '2. Left Icon with Title + Content' },
                                { value: 'style3', label: '3. Icon Top + Title + Content' },
                                { value: 'style4', label: '4. Background + Icon Top + Title + Content' },
                                { value: 'style5', label: '5. Background + Title + Content + Icon Bottom' },
                                { value: 'style6', label: '6. Border + Title + Content + Bottom Icon' },
                                { value: 'style14', label: '7. Background + Title + Icon Middle + Content' },
                                { value: 'style7', label: '8. Border + Title + Middle Icon + Content' },
                                { value: 'style8', label: '9. Border + Top Icon + Title + Content' },
                                { value: 'style9', label: '10. Background + Rombus Icon Top + Title + Content' },
                                { value: 'style10', label: '11. Background + Cirlce Icon Top + Title + Content' },
                                { value: 'style11', label: '12. Border + Cirlce Icon Top + Title + Content' },
                                { value: 'style12', label: '13. Border + Cirlce Icon Left + Title + Content' },
                                { value: 'style13', label: '14. Border + Square Icon Left + Title + Content' }
                            ],
                            description: "You should visit <a href='http://themeton.freshdesk.com/support/solutions/articles/152093-service-element' target='_blank'>this link</a> and see how these styles look like."
                        },
                        {
                            type: 'select',
                            id: 'service_icon_or_image',
                            label: 'Select icon type',
                            value: validate_url($this.find('.blox_item_service_icon').html()) ? 'image' : 'icon',
                            options: [
                                { value: 'icon', label: 'Icon' },
                                { value: 'image', label: 'Image' }
                            ],
                            description: "You should turn this option to Image and upload your custom image If you have specific images for your services excepts suggesting icons."
                        },
                        {
                            type: 'icon',
                            id: 'service_icon',
                            label: 'Icon',
                            value: $this.find('.blox_item_service_icon').html()
                        },
                        {
                            type: 'image',
                            id: 'service_icon_image',
                            label: 'Image',
                            value: $this.find('.blox_item_service_icon').html()
                        },
                        {
                            type: 'number',
                            id: 'service_icon_size',
                            label: 'Icon Size',
                            std: 48,
                            value: $this.find('.blox_item_service_icon_size').html(),
                            description: 'It won\'t aspect If you upload custom image. Your image show own size and container restricts overflow if the image is too big.'
                        },
                        {
                            type: 'colorpicker',
                            id: 'service_color',
                            label: 'Color',
                            value: $this.find('.blox_item_service_color').html(),
                            description: 'General color. It styles icon color on most of service styles.'
                        },
                        {
                            type: 'colorpicker',
                            id: 'service_bgcolor',
                            label: 'Background Color',
                            value: $this.find('.blox_item_service_bgcolor').html(),
                            description: ''
                        }
                    ];

            $this.attr('animation', $this.find('.blox_item_service_animation').html());
            $this.attr('extra_class', $this.find('.blox_item_service_extra_class').html());

            show_blox_form('Edit Service Element', form_element, function($form){
                $this.find('.blox_item_serviceblock_title').html( jQuery('#service_title').val() );
                $this.find('.blox_item_service_title').html( jQuery('#service_title').val() );
                
                $this.find('.blox_item_service_icon').html( jQuery('#service_icon_or_image').val()=='icon' ? jQuery('#service_icon').val() : jQuery('#service_icon_image').val() );
                
                $this.find('.blox_item_service_icon_size').html( jQuery('#service_icon_size').val() );
                $this.find('.blox_item_service_color').html( jQuery('#service_color').val() );
                $this.find('.blox_item_service_bgcolor').html( jQuery('#service_bgcolor').val() );
                $this.find('.blox_item_service_content').html( jQuery('#service_content').val() );
                $this.find('.blox_item_service_layout').html( jQuery('#service_layout').val() );

                $this.find('.blox_item_service_animation').html( $this.attr('animation') );
                $this.find('.blox_item_service_extra_class').html( $this.attr('extra_class') );
            },
            {
                target: $this,
                extra_field: true
            });
                            
            // Folds
            jQuery('#service_icon_or_image').change(function(){
                if( this.value == 'icon' ){
                    jQuery('#service_icon_image').parent().hide();
                    jQuery('#service_icon').parent().show();
                }
                else{
                    jQuery('#service_icon').parent().hide();
                    jQuery('#service_icon_image').parent().show();
                }
            });
            jQuery('#service_icon_or_image').change();

        });
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_service();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
