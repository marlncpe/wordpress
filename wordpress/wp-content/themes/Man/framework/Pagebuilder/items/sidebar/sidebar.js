

function get_blox_element_sidebar($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_sidebar" '+($attrs!=undefined ? $attrs : '')+'> \
                    <div class="blox_item_title"> \
                            <i class="icon-columns"></i> Sidebar'+$tools+' \
                    </div> \
                    <div class="blox_item_content">'+($content!=undefined ? $content : '')+'</div> \
            </div>';
}


function parse_shortcode_sidebar($content){
    $content = wp.shortcode.replace( 'blox_sidebar', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
            if( value!=undefined && value!='undefined' && value!='' ){
                attrs += key+'="'+value+'" ';
            }
        })
        return get_blox_element_sidebar(data.content, attrs);
    });
    return $content;
}



function revert_shortcode_sidebar($content){
    $content.find('.blox_sidebar').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).attr('title')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('sidebar')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' sidebar="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_sidebar'+attr+'/]');
    });
    return $content;
}


function add_event_blox_element_sidebar(){
	
    jQuery('.blox_sidebar').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){
            var $item = $this;

            var ajax_params = {
                'action':'get_blox_element_sidebars', 
                'sidebar':$item.attr('sidebar')
            };
            show_blox_form_ajax("Edit Sidebar Element", ajax_params, function(){
                $item.find('.blox_item_content').html( jQuery(':selected', '#blox_elem_option_sidebar').text() );
                $item.attr('sidebar', jQuery('#blox_elem_option_sidebar').val());
            });

        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_sidebar();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}
