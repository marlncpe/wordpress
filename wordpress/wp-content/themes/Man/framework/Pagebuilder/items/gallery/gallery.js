
function get_blox_element_gallery($content, $attrs){
	$tools = '<div class="blox_item_actions"> \
					<a href="javascript:;" class="icon-pencil action_edit"></a> \
					<a href="javascript:;" class="icon-copy action_clone"></a> \
					<a href="javascript:;" class="icon-remove action_remove"></a> \
				</div>';
	
	return '<div class="blox_item blox_gallery" '+($attrs!=undefined ? $attrs : '')+'> \
				<div class="blox_item_title"> \
					<i class="icon-picture"></i> \
					<span class="blox_item_title">Gallery</span> \
					'+$tools+' \
				</div> \
				<div class="blox_item_content" style="display: none;">'
				+ '<div class="blox_item_gallery_title">'+($content!=undefined && $content.find('.title').length>0 ? $content.find('.title').html() : '')+'</div>'
				+ '<div class="blox_item_gallery_images">'+($content!=undefined && $content.find('.images').length>0 ? $content.find('.images').html() : '')+'</div>'
				+ '<div class="blox_item_gallery_layout">'+($content!=undefined && $content.find('.layout').length>0 ? $content.find('.layout').html() : '')+'</div>'
				+ '<div class="blox_item_gallery_animation">'+($content!=undefined && $content.find('.animation').length>0 ? $content.find('.animation').html() : '')+'</div>'
				+ '<div class="blox_item_gallery_extra_class">'+($content!=undefined && $content.find('.extra_class').length>0 ? $content.find('.extra_class').html() : '')+'</div>'
				+'</div> \
			</div>';
}


function parse_shortcode_gallery($content){
	$content = wp.shortcode.replace( 'blox_gallery', $content, function(data){
		var attrs = '';
		jQuery.each(data.attrs.named, function(key, value){
			if( value!=undefined && value!='undefined' && value!='' ){
				if( key=='title' ){
					attrs += '<div class="title">'+value+'</div>';
				}
                if( key=='lightbox' ){
					attrs += '<div class="lightbox">'+value+'</div>';
				}
				if( key=='images' ){
					attrs += '<div class="images">'+value+'</div>';
				}
				if( key=='layout' ){
					attrs += '<div class="layout">'+value+'</div>';
				}
				if( key=='animation' ){
					attrs += '<div class="animation">'+value+'</div>';
				}
				if( key=='extra_class' ){
					attrs += '<div class="extra_class">'+value+'</div>';
				}
			}
		})
		
		return get_blox_element_gallery(jQuery('<div class="tmp_pass">'+attrs+'</div>'));
	});
	return $content;
}

function revert_shortcode_gallery($content){
	$content.find('.blox_gallery').each(function(){
		attr = '';
		var temp_val = '';

        temp_val = jQuery(this).find('.blox_item_gallery_title').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gallery_lightbox').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' lightbox="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gallery_images').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' images="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gallery_layout').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' layout="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gallery_animation').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' animation="'+temp_val+'"';
        }

        temp_val = jQuery(this).find('.blox_item_gallery_extra_class').html()+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
		
		jQuery(this).replaceWith('[blox_gallery'+attr+']');
	});
	return $content;
}


function add_event_blox_element_gallery(){
	
	jQuery('.blox_gallery').each(function(){
		var $this = jQuery(this);
		
		$this.find('.blox_item_actions .action_edit').unbind('click')
			.click(function(){

				var form_element = [
                			{
                				type: 'input',
                				id: 'gallery_title',
                				label: 'Title',
                				value: $this.find('.blox_item_gallery_title').html()
                			},
                			{
                				type: 'gallery',
                				id: 'gallery_images',
                				label: 'Insert Gallery Images',
                				value: $this.find('.blox_item_gallery_images').html()
                			},
                			{
                				type: 'select',
                				id: 'gallery_layout',
                				label: 'Gallery Layout',
                				value: $this.find('.blox_item_gallery_layout').html(),
                				options: [
                					{ value: '1', label: 'Thumbnails with Lightbox' },
                					{ value: '2', label: 'Preview Area with Thumbnails' },
                					{ value: '3', label: 'Image Slider with Pager' },
                					{ value: '4', label: 'iMac Slider' },
                					{ value: '5', label: 'Laptop Slider' },
                					{ value: '6', label: 'iPhone Slider' }
                				]
                			}
            			];

            	$this.attr('animation', $this.find('.blox_item_gallery_animation').html());
        		$this.attr('extra_class', $this.find('.blox_item_gallery_extra_class').html());

                show_blox_form('Edit Gallery', form_element, function($form){
                    $this.find('.blox_item_gallery_title').html( jQuery('#gallery_title').val() );
	                $this.find('.blox_item_gallery_images').html( jQuery('#gallery_images').val() );
	        		$this.find('.blox_item_gallery_layout').html( jQuery('#gallery_layout').val() );
	        		$this.find('.blox_item_gallery_animation').html( $this.attr('animation') );
	        		$this.find('.blox_item_gallery_extra_class').html( $this.attr('extra_class') );

                },
	            {
	                target: $this,
                	extra_field: true
	            });
                
			});
		
		$this.find('.blox_item_actions .action_clone').unbind('click')
			.click(function(){
				$this.after($this.clone());
				add_event_blox_element_gallery();
			});
			
		$this.find('.blox_item_actions .action_remove').unbind('click')
			.click(function(){
				$this.remove();
			});
	});
	
}
