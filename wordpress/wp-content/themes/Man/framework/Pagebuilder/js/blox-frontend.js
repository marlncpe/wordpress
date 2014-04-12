

/*
    Blox Carousel Render function
    =============================
*/
function to_render_blox_carousel($this, col){
    var c_length = $this.find('.blox_carousel_wrapper .carousel_item').length;
    var c_pager = parseInt( c_length/col );
    c_pager = c_length % col > 0 ? c_pager+1 : c_pager;

    var $rows = jQuery('<div />');
    var $tmp = jQuery('<div class="row" />');
    $this.find('.blox_carousel_wrapper .carousel_item').each(function(index){
        if( index % col == 0 ){
            if( index != 0 ){
                $rows.append( jQuery('<div class="carousel_row" />').append($tmp) );
            }
            $tmp = jQuery('<div class="row" />');
        }
        
        if( c_length-1 == index ){
            $tmp.append( jQuery(this) );
            $rows.append( jQuery('<div class="carousel_row" />').append($tmp) );
        }
        $tmp.append( jQuery(this) );
    });

    $this.find('.blox_carousel_wrapper').html( $rows.html() );
	
	var detect_ie = false;
	if (navigator.userAgent.match(/msie/i) ){
		detect_ie = true;
	}
    $this.find('.blox_carousel_wrapper').cycle({
        fx: detect_ie ? 'fade' : 'carousel',
        prev: $this.find('.action_prev'),
        next: $this.find('.action_next'),
        swipe: true
    });
}
function render_blox_carousel($this){
    $this.find('.blox_carousel_wrapper').cycle('destroy');
    $this.find('.blox_carousel_wrapper .carousel_item').removeClass('col-lg-6 col-lg-4 col-lg-3 col-md-6 col-md-4 col-md-3 col-sm-6 col-sm-4 col-sm-3 col-xs-6 col-xs-4 col-xs-3');
    var owidth = $this.outerWidth();
    if( owidth > 850 ){
        $this.find('.blox_carousel_wrapper .carousel_item').addClass('col-lg-3 col-md-3 col-sm-3 col-xs-3');
        to_render_blox_carousel($this, 4);
    }
    else if( owidth > 698 ){
        $this.find('.blox_carousel_wrapper .carousel_item').addClass('col-lg-4 col-md-4 col-sm-4 col-xs-4');
        to_render_blox_carousel($this, 3);
    }
    else if( owidth < 699 ){
        $this.find('.blox_carousel_wrapper .carousel_item').addClass('col-lg-6 col-md-6 col-sm-6 col-xs-6');
        to_render_blox_carousel($this, 2);
    }
}



jQuery(function(){
	
	//Tab
    jQuery(".tt_tabs").each(function(){
            var $this = jQuery(this);
            
            $this.find(".tab_content_item").each(function(index){
            	$this.find('> .tab_header').append('<li><a href="javascript:;">'+jQuery(this).attr('title')+'</a></li>');
                if( index === 0 ){
                    jQuery(this).fadeIn('fast');
                }
                else{
                    jQuery(this).fadeOut('fast');
                }
            });
            
            $this.find(".tab_header li a").each(function(index){
                if( index===0 ){
                    jQuery(this).addClass("active").closest('li').addClass("active");
                }
            });
            
            $this.find(".tab_header li a").click(function(){
                $this.find(".tab_header li a").removeClass("active").closest('li').removeClass("active");
                jQuery(this).addClass("active").closest('li').addClass("active");
                var indexEl = $this.find(".tab_header li a").index(this);
                $this.find('.tab_content_item').stop().hide();
                $this.find('.tab_content_item').each(function(index){
                    if(indexEl===index){
                        jQuery(this).show();
                    }
                });
            });
        });

    
    //Toggle
    jQuery(".tt_toggle").not(".tt_toggle_open").find(".tt_toggle_inner").hide();
    jQuery(".tt_toggle").each( function () {
        var $this=jQuery(this);
        $this.find('.tt_toggle_title').click(function(e){
            e.preventDefault();
            $this.toggleClass('tt_toggle_open');
            if($this.hasClass('tt_toggle_open')){
                $this.find('.tt_icon').addClass('icon-minus').removeClass('icon-plus');
                $this.find('.tt_toggle_inner').stop().slideDown('fast');
            }else{
                $this.find('.tt_icon').addClass('icon-plus').removeClass('icon-minus');
                $this.find('.tt_toggle_inner').stop().slideUp('fast');
            }
        });
    });
     
     
    //Accordion
    jQuery(".tt_accordion").each(function(){
        jQuery(this).find(".accordion_title").not(".current").next(".accordion_content").hide(); var $self = jQuery(this);
        jQuery(this).find('.accordion_title').click(function(e){
            e.preventDefault();
            $self.find('.accordion_title').not(this).removeClass('current');
            jQuery(this).toggleClass('current');
            $self.find('.accordion_title').each(function(){
                if(jQuery(this).hasClass('current')){
                    jQuery(this).find('.tt_icon').addClass('icon-minus').removeClass('icon-plus');
                    jQuery(this).next('.accordion_content').slideDown('fast');
                }else{
                    jQuery(this).find('.tt_icon').removeClass('icon-plus').addClass('icon-minus'); jQuery(this).next('.accordion_content').slideUp('fast'); }
            });
        });
    });
	
	jQuery('.blox_gallery').each(function(){
		var $this = jQuery(this);
		
		if( $this.hasClass('gallery_layout2') ){
			
			var $cloned =  $this.find('.gallery_thumbs a').eq(0).clone();
			$cloned.attr('rel', '');
			$cloned.find('img').attr('src', $cloned.attr('data-preview'));
			$this.find('.gallery_preview .preview_panel').html( $cloned );
			
			$this.find('.gallery_preview').find('a').unbind('click').click(function(){
				$this.find('.gallery_thumbs a').eq(0).trigger('click');
				return false;
			});
			
			$this.find('.gallery_thumbs a').hover(
				function(){
					var $cloned_item =  jQuery(this).clone();
					$cloned_item.attr('rel', '');
					$cloned_item.find('img').attr('src', $cloned_item.attr('data-preview'))
					$this.find('.gallery_preview .preview_panel').html( $cloned_item );
					
					var selected_index = $this.find('.gallery_thumbs a').index( jQuery(this) );
					$this.find('.gallery_preview').find('a').unbind('click')
						.click(function(){
							$this.find('.gallery_thumbs a').eq(selected_index).trigger('click');
							return false;
						});
				},
				function(){
					
				}
			);
		}
        else if( $this.hasClass('gallery_imac') || $this.hasClass('gallery_laptop') || $this.hasClass('gallery_iphone') ){
            if( $this.find('.gallery_viewport > div').length<2 ){
                $this.find('.gallery_prev,.gallery_next').hide();
            }
            $this.find('.gallery_viewport').cycle({
                slides: '>div',
                prev: $this.find('.gallery_prev'),
                next: $this.find('.gallery_next'),
                swipe: true
            });
        }
        else if( $this.hasClass('gallery_layout_slider') ){
            $this.find('.gallery_preview').cycle({
                pager: $this.find('.gallery_pager'),
                swipe: true
            });
        }
		else{
			
		}
		$this.find("a[rel^='blox_gallery']").prettyPhoto();
	});


    // JPlayer Audio
    jQuery('.blox_elem_audio .blox-jplayer-audio').each(function(){
        jQuery(this).jPlayer({
            ready: function () {
                jQuery(this).jPlayer("setMedia", {
                    mp3: jQuery(this).attr('src')
                });
            },
            play: function(){
                jQuery('.blox_elem_audio .blox-jplayer-audio').not(this).jPlayer("pause");
            },
            wmode:"window",
            swfPath: "",
            cssSelectorAncestor: "#jp_interface_"+jQuery(this).attr('pid'),
            supplied: "mp3"
        });
    });

    // JPlayer Video
    jQuery('.blox_elem_video .blox-jplayer-video').each(function(){
        var $this = jQuery(this);
        $this.jPlayer({
            ready: function () {
                if( jQuery(this).attr('ext') == 'flv' ){
                    jQuery(this).jPlayer("setMedia", {
                        flv: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }
                else if( jQuery(this).attr('ext') == 'mp4' ){
                    jQuery(this).jPlayer("setMedia", {
                        mp4: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }
                else if( jQuery(this).attr('ext') == 'm4v' ){
                    jQuery(this).jPlayer("setMedia", {
                        m4v: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }
                else if( jQuery(this).attr('ext') == 'ogv' ){
                    jQuery(this).jPlayer("setMedia", {
                        ogv: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }
                else if( jQuery(this).attr('ext') == 'webmv' ){
                    jQuery(this).jPlayer("setMedia", {
                        webmv: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }
                else if( jQuery(this).attr('ext') == 'webm' ){
                    jQuery(this).jPlayer("setMedia", {
                        webmv: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }
                else if( jQuery(this).attr('ext') == 'ogg' ){
                    jQuery(this).jPlayer("setMedia", {
                        ogg: jQuery(this).attr('src'),
                        poster: jQuery(this).attr('poster')
                    });
                }

                jQuery(this).find('.fluid-width-video-wrapper').attr('style', '');
            },
            play: function(){
                jQuery('.blox_elem_video .blox-jplayer-video').not(this).jPlayer("pause");
            },
            wmode:"window",
            swfPath: blox_plugin_path+"/js/jplayer/",
            solution: "html, flash",
            cssSelectorAncestor: "#jp_interface_"+jQuery(this).attr('pid'),
            supplied: ( jQuery(this).attr('ext')=='webm' ? 'webmv' : jQuery(this).attr('ext') ),
            preload: "metadata",
            size: {
                width: $this.width(),
                height: parseInt( $this.width()*360/640 )
            }
        });
    });

    jQuery('.blox_elem_progress').waypoint(
        function(direction){
            var $active = jQuery(this);
            if( direction==='down' ){
                $active.find('.blox_progress_line').show();
                $active.find('.blox_progress_vline').show();
            }
            else{
                $active.find('.blox_progress_line').hide();
                $active.find('.blox_progress_vline').hide();
            }
        },
        {
            offset: function(){
                return jQuery.waypoints('viewportHeight')+100;
            }
        }
    );

    jQuery('.blox_element_duplicator').each(function(i){
        var $this = jQuery(this);
        $this.waypoint(function(direction){
            if( direction==='down' ){
                $this.find('.duplicator_item').each(function(dindex){
                    var $ditem = jQuery(this);
                    setTimeout(function(){
                        $ditem.css('color', $ditem.attr('data-color'));
                    }, dindex*200);
                });
            }
        },
        {
            offset: function(){
                return jQuery.waypoints('viewportHeight')+100;
            }
        });
    });

    // Blox Element Animation
    var ua = navigator.userAgent;
    var agent_detector = {
        ios: ua.match(/(iPhone|iPod|iPad)/),
        blackberry: ua.match(/BlackBerry/),
        android: ua.match(/Android/)
    };

    if( agent_detector.ios || agent_detector.blackberry || agent_detector.android ){
        jQuery('.blox_animation_animate_before').css({
            'visibility': 'visible',
            'opacity': '1'
        });

        jQuery('.row_video').each(function(){
            jQuery(this).empty();
        });

        jQuery('html').removeClass('skrollr skrollr-desktop skrollr-mobile');
        jQuery('.skrollable').each(function(){
            jQuery(this)
                .css('background-attachment', 'fixed')
                .removeClass('skrollable skrollable-between');
        });
    }
    else{
        
        /*
        jQuery('.blox_animation_animate_before').each(function(i){
        var $this = jQuery(this);
        $this.waypoint(
            function(direction){
                if( direction==='down' ){
                    setTimeout(function () {
                        $this.delay(100).addClass('blox_animation_start');
                    }, 100 * (i > 15 ? parseInt(i/10) : i));
                }
                else{

                }
            },
            {
                offset: function(){
                    return jQuery.waypoints('viewportHeight')+30;
                }
            }
        );
        });
        */
        jQuery('.wrapper .row').each(function(){
            var $this = jQuery(this);
            $this.find('.blox_animation_animate_before').each(function(i){
                var $item = jQuery(this);
                $item.waypoint(function(direction){
                    if( direction==='down' ){
                        setTimeout(function () {
                            $item.delay(100).addClass('blox_animation_start');
                        }, i*150);
                    }
                },
                {
                    offset: function(){
                        return jQuery.waypoints('viewportHeight')+100;
                    }
                });
            });
        });
    }


    // Blox Carousel Item
    jQuery('.blox_elem_carousel').each(function(){
        var $this = jQuery(this);
        render_blox_carousel($this); 
        $this.css('visibility', 'visible');
    });

    jQuery(window).resize(function(){
        jQuery('.blox_elem_carousel').each(function(){
            var $this = jQuery(this);
            render_blox_carousel($this); 
        });
    });


    jQuery('.blox_elem_price_table').each(function(){
        var $this = jQuery(this);
        var column_length = $this.find('.blox_table_row').length>0 ? $this.find('.blox_table_row').eq(0).find('.blox_table_cell').length : 0;
        var html = '';
        for(var i=0; i<column_length; i++){
            var html_col = '';
            var col_class = '';

            $this.find('.blox_table_row').each(function(){
                var $row = jQuery(this);
                var $cell = $row.find('.blox_table_cell').eq(i);
                var row_type = $row.attr('type')+'' != 'undefined' ? $row.attr('type')+'' : '';

                if( row_type=='header' ){
                    var header_html = $cell.html();
                    var parts = header_html.split(',');
                    html_col += '<div class="blox_elem_price_plan_name"><span><h3>'+parts[0]+'</h3>'+(typeof parts[1]!=='undefined' ? '<span class="header_desc">'+parts[1]+'</span>' : '')+'</span></div>';
                }
                else if( row_type=='price' ){
                    var price = $cell.html();
                    var parr = price.split(',');
                    html_col += '<div class="blox_elem_price_plan_price"> \
                                <span class="price_number"> \
                                    <span class="number">'+parr[0]+'</span> \
                                    '+(parr[1] ? '<span class="currency">'+parr[1]+'</span>' : '')+' \
                                </span> \
                                '+(parr[2] ? '<span class="per">'+parr[2]+'</span>' : '')+' \
                            </div>';
                }
                else if( row_type=='button' ){
                    var btn_txt = $cell.html();
                    var btn_link = '#';
                    var btn_txt_split = btn_txt.split(',');
                    if( btn_txt_split.length > 1 ){
                        btn_txt = btn_txt_split[0];
                        btn_link = btn_txt_split[1];
                    }
                    var button_icon = typeof $this.attr('button-icon')!=='undefined' && $this.attr('button-icon')!='' ? '<i class="'+$this.attr('button-icon')+'"></i>' : '';
                    html_col += '<div class="blox_elem_price_plan_footer"> \
                                    <a class="blox_elem_button blox_elem_button_small blox_elem_button_flat blox_elem_button_bordered" href="'+btn_link+'"> \
                                        '+button_icon+' '+btn_txt+' \
                                    </a> \
                                </div>';
                }
                else{
                    html_col += '<div class="blox_elem_price_plan_text"><span>'+$cell.html()+'</span></div>';
                }
                
                if( $cell.attr('type')=='highlight' ){
                    col_class = 'blox_elem_featured_plan';
                }
                if( $cell.attr('type')=='description' ){
                    col_class = 'blox_elem_description_col';
                }
            });
            
            if(column_length==2){ col_class += ' blox_elem_price_col_two'; }
            else if(column_length==3){ col_class += ' blox_elem_price_col_three'; }
            else if(column_length==4){ col_class += ' blox_elem_price_col_four'; }
            else if(column_length==5){ col_class += ' blox_elem_price_col_five'; }
            else{ col_class += ' blox_elem_price_col_one'; }

            html_col = '<div class="blox_elem_price_col '+col_class+'">'+html_col+'</div>';
            html += html_col;
        }
        if( column_length>0 ){ $this.html(html); }
        $this.css('visibility', 'visible');
    });

    
    // post like event
    jQuery('.meta_like a').click(function(){
        var $this = jQuery(this);
        var $id = typeof $this.attr('pid') !=='undefined' ? parseInt($this.attr('pid')) : 0;
        if( !$this.hasClass('post_liked') && $id > 0 ){
            var ids = blox_get_cookie('post_like');
            ids = ids!=null ? ids : '';
            var array_ids = ids.split(',');
            var exists = false;
            for( var i=0; i<array_ids.length; i++ ){
                if( array_ids[i]+'' == $id+'' ){
                    exists = true;
                }
            }
            if( !exists ){
                blox_set_cookie('post_like', ids+','+$id);
                jQuery.post( metro_frontend_ajax, {'action': 'blox_post_like', 'post_id': parseInt($id) }, function(data){
                    if( data=='1' ){
                        $this.find('span').html( parseInt($this.find('span').html())+1 );
                        $this.addClass('post_liked');
                    }
                });
            }
        }
    });



    /*
    jQuery(".blox_countdown input").knob({
        readOnly: true,
        thickness: '0.2'
    });

    */

    /*
    jQuery('.blox_countdown').each(function(){
        var $this = jQuery(this);
        var cdate = $this.attr('data-date');
        var end_date = new Date(cdate.replace(' ', 'T'));

        var $countdown = $this.find('.countdown_item');
        var options = {
            scaleColor: false,
            lineWidth: 15,
            lineCap: 'square',
            size: 170
        }
        if( $this.attr('data-bgcolor') != '' ){
            jQuery.extend( options, { trackColor: $this.attr('data-bgcolor') } );
        }
        if( $this.attr('data-fgcolor') != '' ){
            jQuery.extend( options, { barColor: $this.attr('data-fgcolor') } );
        }
        if( $this.attr('data-inputColor') != '' ){
            $this.find('.percent').css('color', $this.attr('data-inputColor'));
        }
        $countdown.easyPieChart(options);

        var $cd_day = jQuery('.countdown_item.countdown_day').data('easyPieChart');
        var $cd_hour = jQuery('.countdown_item.countdown_hour').data('easyPieChart');
        var $cd_minute = jQuery('.countdown_item.countdown_minute').data('easyPieChart');
        var $cd_second = jQuery('.countdown_item.countdown_second').data('easyPieChart');

        var countdownInterval = setInterval(function(){
            var now  = new Date();

            var $daysLeft    = parseInt((end_date-now)/86400000);
            var $hoursLeft   = parseInt((end_date-now)/3600000); 
            var $minutsLeft  = parseInt((end_date-now)/60000);
            var $secondsLeft = parseInt((end_date-now)/1000);

            var $prSeconds = $minutsLeft*60;
            $prSeconds = $secondsLeft-$prSeconds;

            var $prMinutes = $hoursLeft*60;
            var $prMinutes = $minutsLeft-$prMinutes;

            var $prHours = $daysLeft*24;
            $prHours = ($hoursLeft-$prHours) < 0 ? 0 : $hoursLeft-$prHours;

            var $prDays = $daysLeft;
            jQuery('.countdown_day .percent'   ,$this).text($prDays);
            jQuery('.countdown_hour .percent'  ,$this).text($prHours);
            jQuery('.countdown_minute .percent',$this).text($prMinutes);
            jQuery('.countdown_second .percent',$this).text($prSeconds);

            $cd_day.update( $prDays>30 ? 100 : parseInt($prDays*100/30) );
            $cd_hour.update( parseInt($prHours*100/60) );
            $cd_minute.update( parseInt($prMinutes*100/60) );
            $cd_second.update( parseInt($prSeconds*100/60) );

            if(now>=end_date){clearInterval(countdownInterval);}
        }, 1000);

    });
    */
    
    jQuery('.blox_countdown').each(function(){
        var $this = jQuery(this);
        var cdate = $this.attr('data-date');
        var end_date = new Date(cdate.replace(' ', 'T'));

        var $knob = $this.find('input');
        $knob.knob({
            readOnly: true,
            thickness: '0.2',
            width: parseInt($this.outerWidth()/4)-40,
            height: parseInt($this.outerWidth()/4)-10
        });

        
        jQuery(window).resize(function() {
            $knob.attr('data-width', parseInt($this.outerWidth()/4)-40)
                .attr('data-height', parseInt($this.outerWidth()/4)-10);
            $knob.parent().redrawKnob();
        });
        

        var countdownInterval = setInterval(function(){
            var now  = new Date();

            var $daysLeft    = parseInt((end_date-now)/86400000);
            var $hoursLeft   = parseInt((end_date-now)/3600000); 
            var $minutsLeft  = parseInt((end_date-now)/60000);
            var $secondsLeft = parseInt((end_date-now)/1000);

            var $prSeconds = $minutsLeft*60;
            $prSeconds = $secondsLeft-$prSeconds;

            var $prMinutes = $hoursLeft*60;
            var $prMinutes = $minutsLeft-$prMinutes;

            var $prHours = $daysLeft*24;
            $prHours = ($hoursLeft-$prHours) < 0 ? 0 : $hoursLeft-$prHours;

            var $prDays = $daysLeft;

            jQuery('.countdown_day'   ,$this).val($prDays).trigger('change');
            jQuery('.countdown_hour'  ,$this).val($prHours).trigger('change');
            jQuery('.countdown_minute',$this).val($prMinutes).trigger('change');
            jQuery('.countdown_second',$this).val($prSeconds).trigger('change');

            if(now>=end_date){clearInterval(countdownInterval);}
        }, 1000);
    });
    
    


    // init testimonials
    jQuery('.blox_testimonial').each(function(){
        var $this = jQuery(this);

        if( $this.hasClass('single_color') ){
            $this.find('.testy_desc').css({
                'background-color': $this.attr('bgcolor')
            })
            .addClass($this.attr('light_dark'));
        }

        if( $this.find('.testimonial_wrapper >div').length<2 ){
            $this.find('.testy_actions').hide();
        }

        $this.find('.testimonial_wrapper').cycle({
            slides: '> div',
            timeout: 0,
            fx: 'fade',
            prev: $this.find('.testy_prev'),
            next: $this.find('.testy_next'),
            swipe: true
        });
    });
    

    // init Fullwidth row
    jQuery('.blox_row_fullwidth').each(function(){
        var $this = jQuery(this);
        var $wrapper = jQuery('body > .wrapper');

        $this.css({
            'width' : $wrapper.width(),
            'max-width': $wrapper.width(),
            'left': ($this.width()-$wrapper.width())/2+'px',
            'visibility': 'visible'
        });
        
        jQuery(window).resize(function(){
            var $resize_wrapper = jQuery('body > .wrapper');
            $this.css({
                'width' : $resize_wrapper.width(),
                'max-width': $resize_wrapper.width(),
                'left': ($this.find('>.container').width()-$resize_wrapper.width())/2+'px',
                'visibility': 'visible'
            });
        });

        
        if( $this.hasClass('row_video_wrapper') ){
            $this.find('.row_video video').width( jQuery(window).width() );
            $this.find('.row_video video').height( parseInt( jQuery(window).width()/1.777 ) );
            $this.find('.row_video video').mediaelementplayer();
        }

    });

    jQuery(window).on("debouncedresize", function () {
        if( jQuery('.row_video_wrapper').length > 0 ){
            var $width;
            if(jQuery.exists('.mk-boxed-enabled')) {
                $width = jQuery('#mk-boxed-layout').width();
            } else {
                $width = jQuery('body').width();
            }

            jQuery('.mk-section-video video, .mk-section-video .mejs-overlay, .mk-section-video .mejs-container').css({width : $width, height : parseInt($width/1.777)});
            jQuery('.mk-section-video').css('width', $width);
            jQuery('.mk-section-video video, .mk-section-video object').attr({'width' : $width, 'height' : parseInt($width/1.777)});
        }
    });
	
});

function initializeGoogleMap() {

    jQuery('.google_map').each(function(){
        var $this = jQuery(this);

        var cLatlng = new google.maps.LatLng(parseFloat($this.attr('lat')), parseFloat($this.attr('long')));

        var mapOptions = {
            zoom: parseInt($this.attr('zoom')),
            center: cLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var googlemap = new google.maps.Map(document.getElementById($this.attr('id')+''), mapOptions);

        var marker = new google.maps.Marker({
            position: cLatlng,
            map: googlemap
        });

        jQuery('.tt_tabs').each(function(){
            if( jQuery(this).find('.google_map').length>0 ){
                jQuery(this).find('.tab_header a').click(function(){
                    google.maps.event.trigger(googlemap, 'resize');
                });
            }
        });

        setTimeout(function() {
            google.maps.event.trigger(googlemap, 'resize');
        }, 1000);

        jQuery(window).resize(function(){
            google.maps.event.trigger(googlemap, 'resize');
        });

    });
}


/* Window Load/All Media Loaded */
jQuery(window).load(function(){

    initializeGoogleMap();

    var $masonry_container = jQuery('.grid_entry.masonry');
    var masonry_entry = '.post_filter_item';
    if( $masonry_container.length > 0 ){
        //$masonry_container.parent().attr('class', '');
    }
    else{
        $masonry_container = jQuery('.metro_container.masonry');
        $masonry_container.parent().attr('class', '');
    }

    if( $masonry_container.length > 0 ){
        $masonry_container.isotope({
            itemSelector : masonry_entry,
            masonry: {
                columnWidth: 1
            }
        });

        setTimeout(function(){
            $masonry_container.isotope('reLayout');
        }, 200);

        jQuery(window).resize(function(){
            $masonry_container.isotope('reLayout');
        });
    }
     
    // Post Filter
    jQuery('.post-filter > ul a').click(function(){
        var $this = jQuery(this);
        var filter = $this.attr('data-filter');

        jQuery('.post-filter > ul a').removeClass('active');
        $this.addClass('active');

        if( $masonry_container.length>0 ){
            filter = filter=='all' ? '*' : '.'+filter;
            $masonry_container.isotope({ filter: filter });
            $masonry_container.isotope('reLayout');
        }
        else{
            if( filter!='all' ){
                jQuery('.post_filter_item').each(function(){
                    if( jQuery(this).hasClass(filter) ){
                        jQuery(this).css('opacity', '1');
                    }
                    else{
                        jQuery(this).css('opacity', '0.2');
                    }
                });
            }
            else{
                jQuery('.post_filter_item').each(function(){
                    jQuery(this).css('opacity', '1');
                });
            }
        }
    });
    
    // event blog view mode
    jQuery('.post-filter').each(function(){
        var $this = jQuery(this);
        $this.find('> span a').unbind('click')
        .click(function(){
            var mode = jQuery(this).parent().attr('class')+'';
            if( mode == 'list' ){
                jQuery('.post_filter_item').addClass('blog_list_view');
            }
            else{
                jQuery('.post_filter_item').removeClass('blog_list_view');
            }
            return false;
        });
    });

});



function blox_date_diff(date1, date2) {
    date1.setHours(0);
    date1.setMinutes(0, 0, 0);
    date2.setHours(0);
    date2.setMinutes(0, 0, 0);
    var datediff = Math.abs(date1.getTime() - date2.getTime()); // difference 
    return parseInt(datediff / (24 * 60 * 60 * 1000), 10); //Convert values days and return value      
}


function blox_set_cookie(c_name,value,exdays){
    exdays = typeof exdays!=='undefined' ? exdays : 1;
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function blox_get_cookie(c_name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1){
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1){
        c_value = null;
    }
    else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1){
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}



