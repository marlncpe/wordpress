function initMobileMenu(){
    
    // Preparing menu for mobile dropdown.
    var $mobileMenu, hasMobileMenu = false;
    if(jQuery('#header').find('#tt-mobile-menu').length) {
        $mobileMenu = jQuery('#header').find('#tt-mobile-menu').clone().removeClass('hidden-xs hidden-sm hidden-md hidden-lg').hide();
        jQuery('#header').find('#tt-mobile-menu').remove();
        hasMobileMenu = true;
    } else if(jQuery('#header').find('.mainmenu').length) {
        $mobileMenu = jQuery('#header').find('.mainmenu').clone().removeClass('hidden-xs hidden-sm visible-md visible-lg').attr('id','tt-mobile-menu').hide();
        $mobileMenu.removeClass('mainmenu metro menu');
        hasMobileMenu = true;
    } else if(jQuery('.wide_menu ').find('.mainmenu').length) {
        $mobileMenu = jQuery('.wide_menu').find('.mainmenu').clone().removeClass('hidden-xs hidden-sm visible-md visible-lg').attr('id','tt-mobile-menu').hide();
        $mobileMenu.removeClass('mainmenu metro menu');
        hasMobileMenu = true;
    }
    
    if(hasMobileMenu) {
        // Adding collapse button of Mobile menu
        jQuery('#header>.container>.row').append('<a id="mobile-menu-expand-collapse" href="#" class="show-mobile-menu visible-xs visible-sm hidden-md hidden-lg"></a>');
    }
    
    $mobileMenu.find('ul').attr('style', '');
    $mobileMenu.find('li').removeClass('fullwidth megamenu light dark').attr('style', '');
    $mobileMenu.children().find('ul').addClass('sub-menu');
    $mobileMenu.find('ul.sub-menu').each(function(){
        jQuery(this).parent('li').addClass('has-children');
        jQuery(this).after('<span class="collapse">&nbsp;</span>');
    });
    $mobileMenu.insertAfter(jQuery('#header'));
    
    // Adding expand & collapse event on Plus symbol
    jQuery('#tt-mobile-menu li.has-children span.collapse').click(function(){
        var $this = jQuery(this).closest('.has-children');
        $this.siblings('li.tt-open').removeClass('tt-open').children('.sub-menu').slideUp('fast');
        $this.toggleClass('tt-open');
        if($this.hasClass('tt-open')) {
            $this.children('.sub-menu').slideDown('fast');
        } else {
            $this.children('.sub-menu').slideUp('fast');
        }
    });
    
    // Adding expand event on links those has subs when click first time
    jQuery('#tt-mobile-menu .has-children>a').click(function(e){
        var $this = jQuery(this).closest('.has-children');
        $this.siblings('li.tt-open').removeClass('tt-open').children('.sub-menu').slideUp('fast');
        $this.toggleClass('tt-open');
        if($this.hasClass('tt-open')){
            e.preventDefault();
            $this.children('.sub-menu').slideDown('fast');
            return false;
        }
    });
    
    // Show and Hide mobile menu
    jQuery('a#mobile-menu-expand-collapse').click(function(e){
        e.preventDefault();
        jQuery('#tt-mobile-menu').slideToggle('fast');
        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
    });

    if( jQuery('#header').hasClass('header_transparent') ){
        jQuery('#tt-mobile-menu').css({
            'padding-top': '100px'
        });

        jQuery('#message_bar, #top_Bar').hide();
    }
}


function initMetroBlog(){
    jQuery('.metro-loop').isotope({
        itemSelector : 'article',
        filter: '*',
        getSortData: {
            number : function($elem){
                return parseInt($elem.attr('post-id'), 10);
            }
        },
        sortBy : 'number',
        masonry: {
            columnWidth: 1
        }
    });
	
    jQuery('.metro-loop').find('article').each(function(){
        var $current_item = jQuery(this);
        jQuery(this).find('a').unbind('click')
        .click(function(){
            metro_item_click_hook($current_item.attr('post-id'));
            return false;
        });
    });
}

function metro_item_click_hook($post_id){
    jQuery('#metro_item_content').slideUp();
    jQuery.post( metro_frontend_ajax,
    {
        action: 'get_metro_item_content', 
        post_id: $post_id
    },
    function(data){
        if( data != "-1" ){
            jQuery('#metro_item_content').html(data);
            jQuery('#metro_item_content').slideDown();
            	
            jQuery('#metro_item_content').find('.close_post_link').unbind('click')
            .click(function(){
                jQuery('#metro_item_content').slideUp();
            });
            jQuery('#metro_item_content').find('a.prev_post_link').unbind('click')
            .click(function(){
                metro_item_click_hook( jQuery(this).attr('post-id') );
                return false;
            });
            jQuery('#metro_item_content').find('a.next_post_link').unbind('click')
            .click(function(){
                metro_item_click_hook( jQuery(this).attr('post-id') );
                return false;
            });
            	
            jQuery('html, body').animate({
                scrollTop: jQuery("#metro_item_content").offset().top-286+190
            }, 800);
        }
        else{
            console.log(data);
        }
    });
}



function fix_woo_products(){
    jQuery('.products .entry_product .product_image_hover').each(function(){
        var $this = jQuery(this);
        if( $this.find('img').length>0 ){
            var wid = parseInt($this.width()*$this.find('img').eq(0).height()/$this.find('img').eq(0).width());
            $this.height( wid );
        }
    });
}



jQuery(function(){
	
    initMobileMenu();
    //initMetroBlog();

    jQuery('.metro_container').isotope({
        itemSelector : 'article',
        filter: '*',
        getSortData: {
            number : function($elem){
                return parseInt($elem.attr('post-id'), 10);
            }
        },
        sortBy : 'number',
        masonry: {
            columnWidth: 1
        }
    });
	
    // menu fixed position
    if( jQuery('.wide_menu').length > 0 ){
        jQuery('.wide_menu').waypoint('sticky', {
            wrapper: '<div class="sticky-wrapper" />'
        });
    }
    else{
        if( jQuery('.icon_menu').length > 0 ){
            jQuery('.mainmenu > ul > li > a').css({
                'height' : jQuery('#header').outerHeight()+'px',
                'line-height': jQuery('#header').outerHeight()+'px'
            });
        }

        // check offset
        var x_offset = 0;
        if( jQuery('.header_transparent').length>0 ){
            x_offset = -30;
        }
        else if( jQuery('#top_bar').length < 1 || jQuery('#message_bar').length < 1 ){
            x_offset = -30;
        }

        jQuery('#header').waypoint('sticky', {
            offset: x_offset,
            wrapper: '<div class="sticky-wrapper" />',
            handler: function(direction){
                if( jQuery('.header_transparent').length>0 ){
                    jQuery('.sticky-wrapper').css('height', '0px');
                }
                        
                if( jQuery('.icon_menu').length > 0 ){
                    if( direction=='down' ){
                        jQuery('.mainmenu > ul > li > a').attr('style', '');
                    }
                    else{
                        jQuery('.mainmenu > ul > li > a').css({
                            'height' : jQuery('#header').outerHeight()+'px',
                            'line-height': jQuery('#header').outerHeight()+'px'
                        });
                    }
                    jQuery('.sticky-wrapper').css('height', '77px');
                    setTimeout(function(){
                        jQuery('.sticky-wrapper').css('height', jQuery('#header').outerHeight()+'px');
                    }, 200);
                }
            }
        });
    }

    jQuery('.mainmenu .menu').find('li').each(function(){
        var $this = jQuery(this);
        if( $this.find('ul').length > 0 ){
            $this.addClass('page_item_has_children');
        }
    });


	
    jQuery(window).resize(function(){
        $sw = 136;
        $mw = 158;
        $lw = 188;
        $metro = jQuery('.metro-loop');
        $w = jQuery(window).width();
        if( $metro.hasClass('small') ){
            $metro.width( parseInt($w/$sw)*$sw );
        }
        else if( $metro.hasClass('medium') ){
            $metro.width( parseInt($w/$mw)*$mw );
        }
        else if( $metro.hasClass('large') ){
            $metro.width( parseInt($w/$lw)*$lw );
        }
		
        jQuery('.metro_container').isotope('reLayout');


        if( jQuery('.products .entry_product .product_image_hover').length>0 ){
            fix_woo_products();
        }
    });

    if( jQuery('.products .entry_product .product_image_hover').length>0 ){
        jQuery('.products img').load(function(){
            fix_woo_products();
        });
    }
	
    
    
    
    /*
     * Footer layout color filling
     * 1 => 100%
     * 2 => 50% + 50%
     * 3 => 50% + 25% + 25%
     * 4 => 25% + 25% + 50%
     * 5 => 33% + 33% + 33%
     * 6 => 25% + 25% + 25% + 25%
     */
    if(footer == true && footer_layout != 1 && colorful_footer == true) {
        $footer_block = jQuery('#footer').find('.footer_widget_container');
        var actual_height = new Array();
        $footer_block.each(function(index){
            actual_height.push(jQuery(this).height());
            jQuery(this).height(jQuery('#footer').height()-160).css("zIndex", index+10);
            var colorful = '<span class="footer_metro_bg footer_metrobg_'+index+'" style="background-color:'+jQuery(this).css('background-color')+'"></span>';
            var $colorful = jQuery(colorful).css({
                'position': 'absolute',
                'width': '50%',
                'height': '100%',
                'top': '0',
                'z-index': index + 3
            });
            if(index < 1)
                jQuery($colorful).css({
                    'left': 0
                });
            else jQuery($colorful).css({
                'right': 0
            });
            jQuery('#footer > .container').before($colorful);
        });
        
        
        /*
         * Events when Window resize
         */
        jQuery(window).resize(function(){

            $color_bg = jQuery('#footer').find('.footer_metro_bg');
            // When two columns
            if(footer_layout == 2) {
                if (jQuery(window).width() < 768) {
                    $footer_block.each(function(){
                        jQuery(this).css('height', 'auto');
                    });
                } else {
                    $footer_block.each(function(){
                        jQuery(this).height(jQuery('#footer').height()-160);
                    });
                }
            } else if(footer_layout == 3) {
                if (jQuery(window).width() < 768) {
                    $footer_block.each(function(){
                        jQuery(this).css('height', 'auto');
                    });
                } else if (jQuery(window).width() < 992) {
                    $footer_block.eq(0).css('height', 'auto');
                    max_height = actual_height[1] > actual_height[2] ? actual_height[1] : actual_height[2];
                    max_height += 160;
                    $footer_block.eq(1).css('height', max_height);
                    $footer_block.eq(2).css('height', max_height);
                    $color_bg.eq(1).css({
                        'height': max_height,
                        'left': 0,
                        'bottom':0,
                        'top' : ''
                    });
                    $color_bg.eq(2).css({
                        'height': max_height,
                        'right': 0,
                        'bottom':0,
                        'top' : ''
                    });
                } else {
                    $footer_block.each(function(){
                        jQuery(this).height(jQuery('#footer').height()-160);
                    });
                    $color_bg.eq(1).css({'left':'','right':0});
                }
            } else if(footer_layout == 4) {
                if (jQuery(window).width() < 768) {
                    $footer_block.each(function(){
                        jQuery(this).css('height', 'auto');
                    });
                } else if (jQuery(window).width() < 992) {
                    $footer_block.eq(2).css('height', 'auto');
                    max_height = actual_height[0] > actual_height[1] ? actual_height[0] : actual_height[1];
                    max_height += 160;
                    $footer_block.eq(1).css('height', max_height);
                    $footer_block.eq(0).css('height', max_height);
                    $color_bg.eq(2).css({
                        'width': '100%',
                        'zIndex': 1
                    });
                    $color_bg.eq(1).css({
                        'height': max_height
                    });
                    $color_bg.eq(0).css({
                        'height': max_height
                    });
                } else {
                    $footer_block.each(function(){
                        jQuery(this).height(jQuery('#footer').height()-160);
                    });
                    $color_bg.eq(2).css({
                        'width': '50%',
                        'zIndex': 5
                    });
                }
            } else if(footer_layout == 5) {
                if (jQuery(window).width() < 992) {
                    $footer_block.each(function(i){
                        jQuery(this).css('height', 'auto');
                        var offset = jQuery(this).position();
                        $color_bg.eq(i).css({
                            'height': jQuery(this).height()+160,
                            'width': '100%',
                            'top': offset.top
                        });
                    });
                } else {
                    $footer_block.each(function(i){
                        jQuery(this).height(jQuery('#footer').height()-160);
                        $color_bg.eq(i).css({
                            'height': '100%',
                            'width': '50%',
                            'top': ''
                        });
                    });
                }
            } else if(footer_layout == 6) {
                if (jQuery(window).width() < 768) {
                    $footer_block.each(function(){
                        jQuery(this).css('height', 'auto');
                    });
                } else if (jQuery(window).width() < 992) {                        
                    max_height = actual_height[0] > actual_height[1] ? actual_height[0] : actual_height[1];
                    max_height += 160;
                    $footer_block.eq(0).css('height', max_height);
                    $footer_block.eq(1).css('height', max_height);
                    $color_bg.eq(0).css('height', max_height);
                    $color_bg.eq(1).css('height', max_height);

                    max_height = actual_height[2] > actual_height[3] ? actual_height[2] : actual_height[3];
                    max_height += 160;
                    $footer_block.eq(2).css('height', max_height);
                    $footer_block.eq(3).css('height', max_height);
                    $color_bg.eq(2).css({
                        'height': max_height,
                        'bottom': 0,
                        'top': '',
                        'right': '',
                        'left': 0
                    });
                    $color_bg.eq(3).css({
                        'height': max_height,
                        'bottom': 0,
                        'top': ''
                    });

                } else {
                    $footer_block.each(function(){
                        jQuery(this).height(jQuery('#footer').height()-160);
                    });
                    $color_bg.eq(2).css({
                        'right': 0,
                        'left': '',
                        'height': '100%'
                    });
                }
            }
        });
        jQuery(window).trigger('resize');
    }
    
    

    // Video responsive alignment		
    jQuery("#content,#footer").fitVids();



    // init widget child ul li
    jQuery('.sidebar_area .widget_pages > ul, .sidebar_area .widget_nav_menu > div > ul').each(function(){
        var $this = jQuery(this);
        $this.find('ul').hide();
        $this.find('li').hover(
            function(){
                jQuery(this).find('> ul').slideDown('fast');
            },
            function(){
                jQuery(this).find('> ul').slideUp('fast');
            }
        );
    });
    
    

    // Site message button
    jQuery('#message_bar .icon-remove').click(function(){
        jQuery('#message_bar').slideUp();
        set_cookie('message_bar', 'hide');
    });
    

    jQuery('a[rel^="prettyPhoto"]').prettyPhoto({deeplinking:false, social_tools:false});
   
    // Go to top arrow
    jQuery('span.gototop').click(function() {
        jQuery('body,html').animate({scrollTop: 0}, 600);
    });


    var s = skrollr.init({
        forceHeight: false
    });


    jQuery(window).scroll(function(){
        if( jQuery(window).scrollTop() > 500 ){
            jQuery('.gototop_footer').addClass('show');
        }
        else{
            jQuery('.gototop_footer').removeClass('show');
        }
    });

    new jQuery.ajax_search({scope:'.wide_menu'});


    jQuery('.add_to_cart_button').click(function(){
        var $cart = jQuery('.woocommerce_cart');
        var $item = jQuery(this);
        if($cart.length>0){
            setTimeout(function(){
                var values = 'action=tt_get_shopping_cart';
                jQuery.ajax({
                    url: metro_frontend_ajax,
                    type: "POST",
                    data:values,
                    success: function(response){
                        var $response = jQuery('<div></div>').append(response);
                        $response.find('#woo_added_cart_msg').remove();
                        $cart.replaceWith($response.html());

                        var item_title = $item.parent().parent().find('h3').text();
                        jQuery('#woo_added_cart_msg').find('.item_name').html(item_title);
                        jQuery('#woo_added_cart_msg').css({ right: '-500px' });
                        jQuery('#woo_added_cart_msg').show().animate({
                            right: '0px',
                            opacity: 1
                        }, 400, function(){
                            setTimeout(function(){
                                jQuery('#woo_added_cart_msg').animate({ right:'-500px', opacity: 0 }, 400, function(){ jQuery('#woo_added_cart_msg').hide(); });
                            }, 2000);
                        });
                    }
                });
            }, 500);
        }
    });


    jQuery('.entry_content').each(function(){
        var $this = jQuery(this);
        if( $this.find('>div').length>0 && $this.find('>div').eq(0).hasClass('blox_row_fullwidth') ){
            $this.parent().parent().css('padding-top', '0px');
        }

        if( $this.find('>div').length>0 && $this.find('>div').eq($this.find('>div').length-1).hasClass('blox_row_fullwidth') ){
            $this.parent().parent().css('padding-bottom', '0px');
        }
    });
    

});



jQuery(window).load(function(){

    // fix primary and sidebar heights
    jQuery('.content').each(function(){
        var $this = jQuery(this);
        if( jQuery(this).parent().parent().find('.sidebar_area').length>0 ){
            var $sidebar = jQuery(this).parent().parent().find('.sidebar_area');
            if( $sidebar.length > 0 && $sidebar.outerHeight() < $this.outerHeight() ){
                if( jQuery(window).width() > 768 ){
                    $sidebar.height( $this.outerHeight()-120 );
                }
            }

            jQuery(window).resize(function(){
                if( jQuery(window).width() < 768 ){
                    $sidebar.css('height', 'auto');
                }
                else{
                    $sidebar.height( $this.outerHeight()-120 );
                }
            });
        }
    });

});



function set_cookie(c_name, value, exdays){
    exdays = typeof exdays !== 'undefined' ? exdays : 1;
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}




jQuery.ajax_search  =  function(options){
   var defaults = {
        delay: 300,
        minChars: 3,
        scope: 'body'
    }

    this.options = jQuery.extend({}, defaults, options);
    this.scope   = jQuery(this.options.scope);
    this.timer   = false;
    this.lastVal = "";

    this.bind_events();
}


jQuery.ajax_search.prototype ={

    bind_events: function(){
        this.scope.on('keyup', '#s' , jQuery.proxy( this.try_search, this));
    },

    try_search: function(e){
        clearTimeout(this.timer);

        if(e.currentTarget.value.length >= this.options.minChars && this.lastVal != jQuery.trim(e.currentTarget.value)){
            this.timer = setTimeout(jQuery.proxy( this.do_search, this, e), this.options.delay);
        }
    },

    do_search: function(e){
        var obj          = this,
            currentField = jQuery(e.currentTarget).attr( "autocomplete", "off" ),
            form         = currentField.parents('form:eq(0)'),
            results      = form.find('.ajax_search_response'),
            loading      = jQuery('<div class="ajax_load"><span class="ajax_load_inner"></span></div>'),
            action       = form.attr('action'),
            values       = form.serialize();
            values      += '&action=themeton_fajax_search';

        if(action.indexOf('?') != -1){
            action  = action.split('?');
            values += "&" + action[1];
        }

        if(!results.length) results = jQuery('<div class="ajax_search_response"></div>').appendTo(form);

        if(results.find('.ajax_not_found').length && e.currentTarget.value.indexOf(this.lastVal) != -1) return;

        this.lastVal = e.currentTarget.value;

        jQuery.ajax({
            url: metro_frontend_ajax,
            type: "POST",
            data:values,
            beforeSend: function()
            {
                results.html('').append(loading);
            },
            success: function(response)
            {
                if(response == 0) response = "";
                results.html(response);
            },
            complete: function()
            {
                loading.remove();
            }
        });
    }
}
