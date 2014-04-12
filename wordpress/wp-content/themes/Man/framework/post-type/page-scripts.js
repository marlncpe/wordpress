function orderby_onepages(){
    var $onepage = jQuery('#onepages');
    var $onepage_names = jQuery('#onepages_names');
    var $onepage_links = jQuery('#onepages_links');
    $onepage.val('');
    $onepage_names.val('');
    $onepage_links.val('');
    var $page_ids = '';
    var $page_names = '';
    var $page_links = '';
    jQuery('#onepage_container').find('.onepage_item').each(function(index){
        $page_ids += index>0 ? ','+jQuery(this).attr('data') : jQuery(this).attr('data');
        $page_names += index>0 ? '^'+jQuery(this).find('span').text() : jQuery(this).find('span').text();
        $page_links += index>0 ? '^'+jQuery(this).attr('data-link') : jQuery(this).attr('data-link');
    });
    $onepage.val($page_ids);
    $onepage_names.val($page_names);
    $onepage_links.val($page_links);
}

jQuery(function(){
    jQuery('#title_bg_image').change(function(){
        if( this.value!='' ){
            jQuery('#option_wrapper_title_bg_repeat').show();
            jQuery('#option_wrapper_title_bg_position').show();
            jQuery('#option_wrapper_title_bg_type').show();
            jQuery('#option_wrapper_title_bg_fixed').show();
            jQuery('#option_wrapper_title_bg_cover').show();
        }
        else{
            jQuery('#option_wrapper_title_bg_repeat').hide();
            jQuery('#option_wrapper_title_bg_position').hide();
            jQuery('#option_wrapper_title_bg_type').hide();
            jQuery('#option_wrapper_title_bg_fixed').hide();
            jQuery('#option_wrapper_title_bg_cover').hide();
        }
    });
    jQuery('#title_bg_image').change();

    jQuery('#bg_image').change(function(){
        if( this.value!='' ){
            jQuery('#option_wrapper_bg_repeat').show();
            jQuery('#option_wrapper_bg_position').show();
            jQuery('#option_wrapper_bg_type').show();
            jQuery('#option_wrapper_bg_fixed').show();
            jQuery('#option_wrapper_bg_cover').show();
        }
        else{
            jQuery('#option_wrapper_bg_repeat').hide();
            jQuery('#option_wrapper_bg_position').hide();
            jQuery('#option_wrapper_bg_type').hide();
            jQuery('#option_wrapper_bg_fixed').hide();
            jQuery('#option_wrapper_bg_cover').hide();
        }
    });
    jQuery('#bg_image').change();
	

    // Group name
    jQuery('#customize_page').change(function(){
        if( jQuery(this).val() == '1' ){
            jQuery('#customize_group_container').slideDown();
        }
        else{
            jQuery('#customize_group_container').slideUp();
        }
    });
    jQuery('#customize_page').trigger('change');
    
    // Group name
    jQuery('#hideheader').change(function(){
        if( jQuery(this).val() == '0' ){
            jQuery('#header_layout_images').slideDown();
        }
        else{
            jQuery('#header_layout_images').slideUp();
        }
    });
    jQuery('#hideheader').trigger('change');
    
    // Group name
    jQuery('#hidetitle').change(function(){
        if( jQuery(this).val() == '0' ){
            jQuery('#title_layout_switch').slideDown();
        }
        else{
            jQuery('#title_layout_switch').slideUp();
        }
    });
    jQuery('#hidetitle').trigger('change');


    
    
	
    if( jQuery('#page_template').val() == 'page-one-page.php' ){
        jQuery('#pmeta_onepage').slideDown();
        jQuery('#postdivrich').hide();
        jQuery('#blox_contentbuilder').hide();
    }
    jQuery('#page_template').change(function(){
        if( this.value == 'page-one-page.php' ){
            jQuery('#pmeta_onepage').slideDown();
            jQuery('#postdivrich').hide();
            jQuery('#blox_contentbuilder').hide();
        }
        else{
            jQuery('#pmeta_onepage').slideUp();
            
            if( get_cookie_editor_mode() ){
                jQuery('#blox_contentbuilder').slideDown();
            }
            else{
                jQuery('#postdivrich').slideDown();
            }
        }
    });
	
    var $onepage = jQuery('#onepages');
    var $onepage_names = jQuery('#onepages_names');
    var $onepage_links = jQuery('#onepages_links');
    var $splited_pages = $onepage.val().split(',');
    var $splited_names = $onepage_names.val().split('^');
    var $splited_links = $onepage_links.val().split('^');
    for(var i=0; i<$splited_pages.length; i++){
        if( $splited_pages!='' ){
            html = get_onepage_item_html( $splited_pages[i], $splited_names[i], (typeof $splited_links[i]!=='undefined' ? $splited_links[i] : '') );
            jQuery('#onepage_container').append(html);
        }
    }

    var $op_container = jQuery('#onepage_container');
    var opform = '<div id="one_page_custom_link"> \
                        <p> \
                                <label>Custom Title</label> \
                                <input type="text" id="op_custom_title" /> \
                        </p> \
                        <p> \
                                <label>Custom Link</label> \
                                <input type="text" id="op_custom_link" /> \
                        </p> \
                        <p><a href="javascript:;" class="button" id="op_custom_link_add">Add</a></p> \
                </div>';
    $op_container.before(opform);

    jQuery('#button_op_custom_link').click(function(){
        jQuery('#one_page_custom_link').toggle('fast');
    });

    jQuery('#op_custom_link_add').click(function(){
        if( jQuery('#op_custom_title').val()!='' && jQuery('#op_custom_link').val()!='' ){
            html = get_onepage_item_html( 0, jQuery('#op_custom_title').val(), jQuery('#op_custom_link').val() );
            jQuery('#onepage_container').append(html);
            jQuery('#op_custom_title').val('');
            jQuery('#op_custom_link').val('');
            orderby_onepages();
        }
    });

    jQuery('#onpage_allpages').change(function(){
        if( jQuery(this).val()!='0' ){
            jQuery('#button_onepage_add').trigger('click');
            jQuery(this).val('0').change();
        }
    });
	
    jQuery('#onepage_container').sortable({
        update: function( event, ui ){
            orderby_onepages();
        }
    });
    jQuery('#button_onepage_add').unbind('click')
    .click(function(){
        $opage = jQuery('#onpage_allpages');
        html = get_onepage_item_html( $opage.val(), $opage.find("option[value='"+$opage.val()+"']").text(), $opage.find("option[value='"+$opage.val()+"']").attr('data-link') );
        jQuery('#onepage_container').append(html);
        orderby_onepages();
    });
	
});


function get_onepage_item_html($page_id, $page_title, $page_link){
    return '<div class="onepage_item" data="'+$page_id+'" data-link="'+$page_link+'"> \
                <span>'+$page_title+'</span> \
                <a href="javascript:;" onclick="jQuery(this).parent().remove(); orderby_onepages();" class="icon-remove"></a> \
                <a href="'+ajaxurl.replace('admin-ajax.php','post.php?post='+$page_id+'&action=edit')+'" target="_blank" class="op_edit icon-pencil"></a> \
            </div>';
}
