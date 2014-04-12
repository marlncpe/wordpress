jQuery(function(){
    jQuery('#bg_image').change(function(){
        if( this.value!='' ){
            jQuery('#option_wrapper_bg_repeat').show();
            jQuery('#option_wrapper_bg_position').show();
            jQuery('#option_wrapper_bg_type').show();
            jQuery('#option_wrapper_bg_fixed').show();
        }
        else{
            jQuery('#option_wrapper_bg_repeat').hide();
            jQuery('#option_wrapper_bg_position').hide();
            jQuery('#option_wrapper_bg_type').hide();
            jQuery('#option_wrapper_bg_fixed').hide();
        }
    });
    jQuery('#bg_image').change();
    
    
    
});