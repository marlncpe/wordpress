jQuery(function(){
	if( jQuery('.wp-post-format-ui').length < 1 ){
		post_format = ['standard', 'image', 'gallery', 'link', 'video', 'audio', 'chat', 'status', 'quote', 'aside'];
		
		html = '<div id="tt_post_format_container">';
		for(i=0; i<post_format.length; i++){
			html += '<a href="javascript:;" class="post_format_item"> \
						<div class="post-'+post_format[i]+'"></div> \
						<span>'+post_format[i]+'</span> \
					</a>';
		}
		html += '</div>';
	
		jQuery('#poststuff').before(html);
	
		jQuery('#tt_post_format_container a.post_format_item').click(function(){
			var pformat = jQuery(this).find('> span').text();
			pformat = pformat=='standard' ? '' : pformat;
			jQuery('#tt_post_format_container a.post_format_item').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('#post_format').val( pformat );
			
			jQuery('.post_format_wrapper').hide();
			if( pformat != 'quote' ){
				jQuery('.format_content_'+pformat).slideDown();
			}
		});
		
		post_format_html = '<div id="post_format_content_div">';
			post_format_html += '<div class="post_format_wrapper format_content_image"> \
									<div class="pf_image_preview"></div> \
									<label>Image URL or HTML</label> \
									<textarea id="format_image_data" name="format_image_data"></textarea> \
									<div class="pf_link"><a href="javascript:;">Select Image From Media</a></div> \
									<div class="clearfix"></div> \
								</div>';
								
			post_format_html += '<div class="post_format_wrapper format_content_link"> \
									<label>Link URL</label> \
									<input type="text" id="format_link_url_data" name="format_link_url_data" /> \
								</div>';
			
			post_format_html += '<div class="post_format_wrapper format_content_video"> \
									<label>Video embed code or URL</label> \
									<textarea id="format_video_embed_data" name="format_video_embed_data"></textarea> \
									<div class="pf_link"><a href="javascript:;">Select Video From Media</a></div> \
									<div class="clearfix"></div> \
								</div>';
								
			post_format_html += '<div class="post_format_wrapper format_content_audio"> \
									<label>Audio embed code or URL</label> \
									<textarea id="format_audio_embed_data" name="format_audio_embed_data"></textarea> \
									<div class="pf_link"><a href="javascript:;">Select Audio From Media</a></div> \
									<div class="clearfix"></div> \
								</div>';
			
			post_format_html += '<div class="post_format_wrapper format_content_quote"> \
									<label>Quote source</label> \
									<input type="text" id="format_quote_source_name_data" name="format_quote_source_name_data" /> \
									<label>Quote source link</label> \
									<input type="text" id="format_quote_source_url_data" name="format_quote_source_url_data" /> \
								</div>';
		post_format_html += '</div>';
		
		jQuery('#postdivrich').before(post_format_html);
		
		jQuery('#format_image_data').val( jQuery('#format_image').val() );
		jQuery('#format_video_embed_data').val( jQuery('#format_video_embed').val() );
		jQuery('#format_audio_embed_data').val( jQuery('#format_audio_embed').val() );
		
		jQuery('#format_link_url_data').val( jQuery('#format_link_url').val() );
		jQuery('#format_quote_source_name_data').val( jQuery('#format_quote_source_name').val() );
		jQuery('#format_quote_source_url_data').val( jQuery('#format_quote_source_url').val() );
		
		
		// insert image
		jQuery('.format_content_image .pf_link a').click(function(){
			$this = jQuery(this);
			var send_attachment_bkp = wp.media.editor.send.attachment;
			wp.media.editor.send.attachment = function(props, attachment){
				wp.media.editor.send.attachment = send_attachment_bkp;
				$this.parent().parent().find('textarea').val('<img src="'+attachment.url+'" />');
			}
			wp.media.editor.open();
	        return false;
		});
		
		// insert video
		jQuery('.format_content_video .pf_link a').click(function(){
			$this = jQuery(this);
			var send_attachment_bkp = wp.media.editor.send.attachment;
			wp.media.editor.send.attachment = function(props, attachment){
				wp.media.editor.send.attachment = send_attachment_bkp;
				$this.parent().parent().find('textarea').val(attachment.url);
			}
			wp.media.editor.open();
	        return false;
		});
		
		// insert audio
		jQuery('.format_content_audio .pf_link a').click(function(){
			$this = jQuery(this);
			var send_attachment_bkp = wp.media.editor.send.attachment;
			wp.media.editor.send.attachment = function(props, attachment){
				wp.media.editor.send.attachment = send_attachment_bkp;
				$this.parent().parent().find('textarea').val(attachment.url);
			}
			wp.media.editor.open();
	        return false;
		});
		
		$post_format = jQuery('#post_format').val();
		jQuery('div.post-'+$post_format).parent().trigger('click');
		
		jQuery('#post').submit(function(e){
			//e.preventDefault();
			jQuery('#format_image').val( jQuery('#format_image_data').val() );
			jQuery('#format_video_embed').val( jQuery('#format_video_embed_data').val() );
			jQuery('#format_audio_embed').val( jQuery('#format_audio_embed_data').val() );
			
			jQuery('#format_link_url').val( jQuery('#format_link_url_data').val() );
			jQuery('#format_quote_source_name').val( jQuery('#format_quote_source_name_data').val() );
			jQuery('#format_quote_source_url').val( jQuery('#format_quote_source_url_data').val() );
			return true;
		});
	}
	else{
		jQuery('.wp-post-format-ui').show();
	}
	
	// init Metro style
	metrocls = jQuery('#metro_style').val();
	metrocls = metrocls!='' ? metrocls : 'small1';
	jQuery('#metro_style_container').find('.'+metrocls).addClass('active');
	jQuery('#metro_style_container a').click(function(){
		jQuery('#metro_style_container a').removeClass('active');
		jQuery(this).addClass('active');
		cls = jQuery(this).attr('class');
		cls = cls.replace('active', '').replace(' ', '');
		jQuery('#metro_style').val(cls);
	});
	
});
