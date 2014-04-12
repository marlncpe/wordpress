
function get_blox_element_list($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_list" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-list-ul"></i> \
                        <span class="blox_item_title">Iconic List</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;">'
                + '<div class="blox_item_icon_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
                + '<div class="blox_item_icon_icon">'+($content!=undefined && $content.find('.icon').length>0 ? $content.find('.icon').html() : '')+'</div>'
                + '<div class="blox_item_icon_color">'+($content!=undefined && $content.find('.color').length>0 ? $content.find('.color').html() : '')+'</div>'
                + '<div class="blox_item_icon_list">'+($content!=undefined && $content.find('.list').length>0 ? $content.find('.list').html() : '')+'</div>'
                + '<div class="blox_item_icon_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
                + '<div class="blox_item_icon_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
                +'</div> \
            </div>';
}


function parse_shortcode_list($content){
    $content = wp.shortcode.replace( 'blox_list', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                if( key=='title' ){
                    attrs += '<div class="'+key+'">'+value+'</div>';
                }
                if( key=='icon' ){
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
        });
        
        attrs += '<div class="list">'+data.content+'</div>';

        return get_blox_element_list(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
    });
    return $content;
}

function revert_shortcode_list_hook($this){
    attr = '';
    var temp_val = '';

    temp_val = $this.find('.blox_item_icon_title').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' title="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_icon_icon').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' icon="'+temp_val+'"';
    }

    temp_val = $this.find('.blox_item_icon_color').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' color="'+temp_val+'"';
    }
    temp_val = $this.find('.blox_item_icon_animation').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' animation="'+temp_val+'"';
    }
    temp_val = $this.find('.blox_element_option_extraclass').html()+'';
    if( temp_val!='undefined' && temp_val!='' ){
        attr += ' extra_class="'+temp_val+'"';
    }
    
    
    $this.replaceWith('[blox_list'+attr+']'+$this.find('.blox_item_icon_list').html()+'[/blox_list]');
}

function revert_shortcode_list($content){
    $content.find('.blox_list').each(function(){
        revert_shortcode_list_hook( jQuery(this) );
    });
    return $content;
}


function add_event_blox_element_list(){
	
    jQuery('.blox_list').each(function(){
        var $this = jQuery(this);

        if( !$this.parent().hasClass('blox_container') ){
            revert_shortcode_list_hook( $this );
        }
        else{
            $this.find('.blox_item_actions .action_edit').unbind('click').click(function(){
                
                var form_element = [
                    {
                        type: 'input',
                        id: 'blox_element_option_title',
                        label: 'Title',
                        value: $this.find('.blox_item_icon_title').html()
                    },
                    {
                        type: 'icon',
                        id: 'blox_element_option_icon',
                        label: 'List Icon',
                        value: $this.find('.blox_item_icon_icon').html()
                    },
                    {
                        type: 'colorpicker',
                        id: 'blox_element_option_color',
                        label: 'Icon Color',
                        value: $this.find('.blox_item_icon_color').html()
                    },
                    {
                        type: 'textarea',
                        id: 'blox_element_option_list',
                        label: 'List Content (Please add list items as separated by line breaks. No need html tags)',
                        value: ''
                    }
                ];

                $this.attr('animation', $this.find('.blox_item_icon_animation').html());
                $this.attr('extra_class', $this.find('.blox_item_icon_extra_class').html());

                show_blox_form('Edit Icon', form_element, function($form){
                    $this.find('.blox_item_icon_title').html(   jQuery('#blox_element_option_title').val() );
                    $this.find('.blox_item_icon_icon').html( jQuery('#blox_element_option_icon').val() );
                    $this.find('.blox_item_icon_color').html(  jQuery('#blox_element_option_color').val() );
                    
                    $this.find('.blox_item_icon_animation').html(  $this.attr('animation') );
                    $this.find('.blox_item_icon_extra_class').html( $this.attr('extra_class') );
                    

                    $this.find('.blox_item_icon_list').html('');
                    var splited = jQuery('#blox_element_option_list').val().split('\n');
                    for(var i=0; i<splited.length; i++){
                        $this.find('.blox_item_icon_list').html( $this.find('.blox_item_icon_list').html() + '<li>'+splited[i]+'</li>' );
                    }
                },
                {
                    target: $this,
                    extra_field: true
                });

                $this.find('.blox_item_icon_list').find('li').each(function(index){
                    jQuery('#blox_element_option_list').val( jQuery('#blox_element_option_list').val()+(index==0 ? '' : '\n')+jQuery(this).text());
                });

            });
                
            
            $this.find('.blox_item_actions .action_clone').unbind('click')
            .click(function(){
                $this.after($this.clone());
                add_event_blox_element_list();
            });
                
            $this.find('.blox_item_actions .action_remove').unbind('click')
            .click(function(){
                $this.remove();
            });

        }

    });
	
}


