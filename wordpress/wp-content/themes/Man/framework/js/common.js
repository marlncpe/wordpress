
var wp_ajax_delay = true;

jQuery(function(){
	
	if( jQuery('.widgets-holder-wrap').length > 0 ){
		jQuery('.tt_wpcolorpicker').wpColorPicker();
		jQuery('body').ajaxSuccess(function(evt, request, settings) {

			if( wp_ajax_delay ){
				wp_ajax_delay = false;
				jQuery('.wp-picker-container').each(function(){
					var $this = jQuery(this);
					var $input = $this.find('.tt_wpcolorpicker').clone();
					$input.attr('style', '');
					$input.removeClass('wp-color-picker');
					$this.replaceWith( $input );
				});
				jQuery('.tt_wpcolorpicker').wpColorPicker();

				setInterval(function(){ wp_ajax_delay = true; },3000);
			}
			
		});
	}
	
});
