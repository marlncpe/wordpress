
function get_blox_element_team($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_team" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-user"></i> \
                        <span class="blox_item_title">Team Member</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_team_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
                + '<div class="blox_item_team_style">'+($content!=undefined && $content.find('.style').length>0 ? $content.find('.style').html() : '')+'</div>'
                + '<div class="blox_item_team_img">'+($content!=undefined && $content.find('.image').length>0 ? $content.find('.image').html() : '')+'</div>'
                + '<div class="blox_item_team_img_link">'+($content!=undefined && $content.find('.imglink').length>0 ? $content.find('.imglink').html() : '')+'</div>'
                + '<div class="blox_item_team_name">'+($content!=undefined && $content.find('.name').length>0 ? $content.find('.name').html() : '')+'</div>'
                + '<div class="blox_item_team_position">'+($content!=undefined && $content.find('.position').length>0 ? $content.find('.position').html() : '')+'</div>'
                + '<div class="blox_item_team_bio">'+($content!=undefined && $content.find('.bio').length>0 ? $content.find('.bio').html() : '')+'</div>'
                + '<div class="blox_item_team_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                + '<div class="blox_item_team_social">'+($content!=undefined && $content.find('.social').length>0 ? $content.find('.social').html().replace(/\,/g, '\n') : '')+'</div>'
                + '<div class="blox_item_team_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
                + '<div class="blox_item_team_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
			</div>';
}


function parse_shortcode_team($content){
    $content = wp.shortcode.replace( 'blox_team', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='title' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='style' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='image' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='imglink' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='name' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='position' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='color' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='social' ){
                    value = value.replace(/,/g, '\n');
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
        attrs += '<div class="bio">'+data.content+'</div>';
		
        return get_blox_element_team(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_team($content){
    $content.find('.blox_team').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_team_title').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_team_style').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' style="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_team_img').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' image="'+temp_val+'"';
        }
        temp_val = jQuery(this).find('.blox_item_team_img_link').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' imglink="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_team_name').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' name="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_team_position').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' position="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_team_color').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' color="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_team_social').text()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            var_social = temp_val;
            var_social = var_social.replace(/\n/g, ',');
            attr += ' social="'+var_social+'"';
        }

        temp_val = jQuery(this).find('.blox_item_team_animation').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' animation="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_team_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_team'+attr+']'+jQuery(this).find('.blox_item_team_bio').html()+'[/blox_team]');
    });
    return $content;
}


function add_event_blox_element_team(){
	
    jQuery('.blox_team').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'input',
                id: 'team_title',
                label: 'Title',
                value: $this.find('.blox_item_team_title').html()

            },
            {
                type: 'select',
                id: 'blox_element_option_style',
                label: 'Style',
                value: $this.find('.blox_item_team_style').html(),
                options: [
                {
                    value: 'style1',
                    label: 'Rectangle'
                },
                {
                    value: 'style2',
                    label: 'Circle'
                }
                ],
                description: "You should visit <a href='http://themeton.freshdesk.com/solution/articles/152103-team-member-element' target='_blank'>this link</a> and see how these styles look like."
            },
            {
                type: 'image',
                id: 'team_member_img',
                label: 'Image',
                value: $this.find('.blox_item_team_img').html()

            },
            {
                type: 'input',
                id: 'team_member_img_link',
                label: 'Image link (optional)',
                value: $this.find('.blox_item_team_img_link').html()

            },
            {
                type: 'input',
                id: 'team_member_name',
                label: 'Name',
                value: $this.find('.blox_item_team_name').html()

            },
            {
                type: 'input',
                id: 'team_member_position',
                label: 'Position',
                value: $this.find('.blox_item_team_position').html()

            },
            {
                type: 'textarea',
                id: 'team_member_bio',
                label: 'Bio Text',
                value: $this.find('.blox_item_team_bio').html()

            },
            {
                type: 'colorpicker',
                id: 'team_member_block_color',
                label: 'Color',
                value: $this.find('.blox_item_team_color').html()
            },
            {
                type: 'textarea',
                id: 'team_member_social_links',
                label: 'Social links',
                value: $this.find('.blox_item_team_social').html(),
                description: "Format have to same as <strong>socialname</strong> + <strong>:</strong> (colon) + <strong>link</strong> + line break. Ex:<br><br><em>facebook: facebook.com/yourprofile<br>twitter: twitter.com/yourpage</em><br><br>You should visit <a href='http://themeton.freshdesk.com/solution/articles/152103-team-member-element' target='_blank'>this link</a> and see how many socials supports it and how you can extend your custom socials here."
            }
            ];

            $this.attr('animation', $this.find('.blox_item_team_animation').html());
            $this.attr('extra_class', $this.find('.blox_item_team_extra_class').html());

            show_blox_form('Edit Team', form_element, function($form){
                $this.find('.blox_item_team_title').html( jQuery('#team_title').val() );
                $this.find('.blox_item_team_style').html( jQuery('#blox_element_option_style').val() );
                $this.find('.blox_item_team_img').html( jQuery('#team_member_img').val() );
                $this.find('.blox_item_team_img_link').html( jQuery('#team_member_img_link').val() );
                $this.find('.blox_item_team_name').html( jQuery('#team_member_name').val() );
                $this.find('.blox_item_team_position').html( jQuery('#team_member_position').val() );
                $this.find('.blox_item_team_bio').html( jQuery('#team_member_bio').val() );
                $this.find('.blox_item_team_color').html( jQuery('#team_member_block_color').val() );
                $this.find('.blox_item_team_social').html( jQuery('#team_member_social_links').val() );
                
                $this.find('.blox_item_team_animation').html( $this.attr('animation') );
                $this.find('.blox_item_team_extra_class').html( $this.attr('extra_class') );
            },
            {
                target: $this,
                extra_field: true
            });

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_team();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
