String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};


/*
 * GET UNIQUE ID
 */
function guid_temp(){
	return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
}
function guid(){
	return (guid_temp()+guid_temp());
}





/*
	Font Icon Dialog Public
	Usage: themeton_get_font( jQuery(this).parent().find('input') );
*/
function themeton_get_font($obj){
	jQuery.fancybox.open([jQuery('<div id="themeton_modal" />')],{
		width: 600,
		height: 500,
		autoSize: false,
		afterLoad: function(){
			$metrize = '';
			for(i=0; i<font_metrize.length; i++){
				$metrize += '<a href="javascript:;" class="'+font_metrize[i]+'"></a>';
			}
			$awesome = '';
			for(i=0; i<font_awesome.length; i++){
				$awesome += '<a href="javascript:;" class="'+font_awesome[i]+'"></a>';
			}
			html = '<div id="themeton_modal_font_selector"><a href="javascript:;">Font Awesome Icons</a><a href="javascript:;">Metrize Icons</a></div>';
			html += '<div id="themeton_modal_font"><div>'+$awesome+'</div><div>'+$metrize+'</div></div>';
			this.content = html;
		},
		afterShow: function(){
			
			jQuery('#themeton_modal_font').find('div').eq(1).hide();
			jQuery('#themeton_modal_font').find('div').eq(0).fadeIn();
					
			jQuery('#themeton_modal_font_selector').find('a').eq(0).unbind('click')
				.click(function(){
					jQuery('#themeton_modal_font').find('div').eq(1).hide();
					jQuery('#themeton_modal_font').find('div').eq(0).fadeIn();
				});
				
			jQuery('#themeton_modal_font_selector').find('a').eq(1).unbind('click')
				.click(function(){
					jQuery('#themeton_modal_font').find('div').eq(0).hide();
					jQuery('#themeton_modal_font').find('div').eq(1).fadeIn();
				});
			
			jQuery('#themeton_modal_font a').unbind('click')
				.click(function(){
					$obj.val( jQuery(this).attr('class') );
					$obj.change();
					jQuery.fancybox.close();
				});
		}
	});
}