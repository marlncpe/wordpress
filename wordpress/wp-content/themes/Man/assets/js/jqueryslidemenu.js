

var themetonmgamenu = {
	build: function(menu){
		jQuery(document).ready(function($){
			var $main_ul = $(menu + ">ul");
			var $main_li = $main_ul.find('ul').parent();

			$main_ul.find('>li').each(function(){
				jQuery(this).find('>ul').each(function(){
					jQuery(this).find('>li').eq(0).append('<span class="menu_arrow"></span>');
				});
			});

			$main_li.each(function(i){
				var $this = $(this);

				$this.hover(
					function(){
						var $targetul = $(this).children("ul:eq(0)");
						var target_width = parseInt($targetul.parent().outerWidth()/2);

						$targetul.parent().find('.menu_arrow').css({
							'left': target_width+'px'
						});

						if( $targetul.find('.menu_column').length > 0 ){
							$targetul.find('>li').addClass('row');
							$targetul.find('>li').css({ 'display':'block', 'width':'100%' });
							$targetul.find('.menu_column').addClass('col-lg-'+parseInt(12/$targetul.find('.menu_column').length)+' col-md-4 col-xxs-6 col-xs-12');
							$targetul.width( $targetul.find('.menu_column').length*230 );
							
							// mega menu set left pos, arrow pos
							var t_left = parseInt(($targetul.find('.menu_column').length*230-target_width)/2);
							$targetul.css({ 'left': '-'+t_left+'px' });
							$targetul.parent().find('.menu_arrow').css({
								'left': t_left+target_width+'px'
							});


							if( $targetul.parent().hasClass('fullwidth') ){
								var wpadin = parseInt(($(window).width() - $('#header > .container').width())/2);
								var lileft = $targetul.parent().offset().left;
								
								$targetul.css({
									'left': '-'+(lileft-wpadin)+'px',
									'width': $('#header > .container').width()+'px'
								});

								$targetul.parent().find('.menu_arrow').css({
									'left': parseInt(lileft-wpadin+target_width)+'px'
								});
							}
							else{
								var lileft = parseInt($targetul.parent().offset().left);
								if( $(window).width() < $targetul.width()/2+lileft ){
									var pos_dif = $targetul.width()/2+lileft - $(window).width();
									pos_dif = parseInt( pos_dif );
									$targetul.css({ 'left': '-'+(parseInt($targetul.width()/2) + pos_dif+target_width)+'px' });

									$targetul.parent().find('.menu_arrow').css({
										'left': (parseInt($targetul.width()/2) + pos_dif+target_width+target_width)+'px'
									});
								}
							}

							if( $('.wide_menu').length>0 && !$targetul.parent().hasClass('fullwidth') ){
								$targetul.css({ 'left': '0px' });
								$targetul.parent().find('.menu_arrow').css({
									'left': target_width+'px'
								});
							}
						}
						else{
							var lileft = parseInt($targetul.parent().offset().left);
							if( $(window).width() < $targetul.width()+lileft ){
								var pos_dif = $targetul.width()/2+lileft - $(window).width();
								pos_dif = parseInt( pos_dif );
								$targetul.css({ 'left': '-'+(parseInt($targetul.width()/2) + pos_dif+target_width)+'px' });

								$targetul.parent().find('.menu_arrow').css({
									'left': (parseInt($targetul.width()/2) + pos_dif+target_width+target_width)+'px'
								});

								$targetul.addClass('floar_right_menu');
							}
						}


						// calculate Submenu Padding-Top
						if( $('.wide_menu').length>0 ){ }
						else{
							var sub_top = parseInt(jQuery('#header').css('padding-bottom')) + parseInt((jQuery('#header > .container').outerHeight()-jQuery('.mainmenu').parent().outerHeight())/2+jQuery('.mainmenu').parent().outerHeight());
							jQuery('.mainmenu ul.menu > li > ul').css({
								'padding-top': sub_top+'px'
							});

							//var stuck = jQuery('#header').hasClass('stuck');
							jQuery(window).scroll(function(){
								var sub_top = parseInt(jQuery('#header').css('padding-bottom')) + parseInt((jQuery('#header > .container').outerHeight()-jQuery('.mainmenu').parent().outerHeight())/2+jQuery('.mainmenu').parent().outerHeight());
								jQuery('.mainmenu ul.menu > li > ul').css({
									'padding-top': sub_top+'px'
								});
							});
						}


						$targetul.fadeIn('fast');
					},
					function(){
						var $targetul = $(this).children("ul:eq(0)");
						$targetul.fadeOut('fast');
					}
				);
			});
		});
	}
}


themetonmgamenu.build('.mainmenu');




var arrowimages={down:['downarrowclass', 'down.gif', 23], right:['rightarrowclass', 'right.gif']}

var jqueryslidemenu={

animateduration: {over: 200, out: 100}, //duration of slide in/ out animation, in milliseconds

buildmenu:function(menuid, arrowsvar){
	jQuery(document).ready(function($){
		var $mainmenu=$(menuid+">ul")
		var $headers=$mainmenu.find("ul").parent()
		$headers.each(function(i){
			var $curobj=$(this)
			var $subul=$(this).find('ul:eq(0)')
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
			this.istopheader=$curobj.parents("ul").length==1? true : false
			$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})
			
			$curobj.hover(
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					this._offsets={left:$(this).offset().left, top:$(this).offset().top}
					var menuleft=this.istopheader? 0 : this._dimensions.w
					menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft
					if ($targetul.queue().length<=1) //if 1 or less queued animations
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over)
				},
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					$targetul.slideUp(jqueryslidemenu.animateduration.out)
				}
			) //end hover
		}) //end $headers.each()
		$mainmenu.find("ul").css({display:'none', visibility:'visible'})
	}) //end document.ready
}
}

//build menu with ID="myslidemenu" on page:
//jqueryslidemenu.buildmenu("nav", arrowimages);
//jqueryslidemenu.buildmenu(".mainmenu", arrowimages);




/*
var jqueryslidemenu={

	animateduration: {over: 200, out: 100}, //duration of slide in/ out animation, in milliseconds

	buildmenu:function(menuid){
		jQuery(document).ready(function($){
			var $mainmenu=$(menuid+">ul")
			var $headers=$mainmenu.find("ul").parent()
			$headers.each(function(i){
				var $curobj=$(this)

				if( !$curobj.hasClass('widget') && !$curobj.hasClass('page_item') ){

					var $subul=$(this).find('ul:eq(0)')
					this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
					this.istopheader=$curobj.parents("ul").length==1? true : false
					$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})
					
					$curobj.hover(
						function(e){
							var $targetul=$(this).children("ul:eq(0)")

							if( $(this).parent().hasClass('menu') && jQuery('.default_menu').length>0 ){
								$(this).css('padding-bottom', '0px');
								var $pb = parseInt( (jQuery('#header').outerHeight()-jQuery('.default_menu').outerHeight())/2 );
								$(this).css('padding-bottom', $pb+'px');
								$targetul.css({ top: $(this).outerHeight()+'px'});
							}

							this._offsets={left:$(this).offset().left, top:$(this).offset().top}
							var menuleft=this.istopheader? 0 : this._dimensions.w
							menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft;

							if ($targetul.queue().length<=1){
								var swidth = this._dimensions.subulw;
								if( $targetul.parent().hasClass('megamenu') ){
									var col_count = $targetul.find('.menu_column').length;
									swidth = swidth*col_count
									$targetul.find('.menu_column').css('width', 100/col_count+'%');
								}
								var c_left = jQuery(this).offset().left;
								var menu_tr_left = 30;
								if( c_left+swidth > jQuery('.container').outerWidth() ){
									menuleft = jQuery('.container').outerWidth()-c_left-swidth+(jQuery(window).width()-jQuery('.container').outerWidth())/2;
									menu_tr_left = menuleft < 0 ? menuleft*(-1)+30 : menu_tr_left;
								}
								jQuery("#dynamic_menu_style").text(".mainmenu ul.menu li ul::after{ left: "+menu_tr_left+"px;}");
								$targetul.css({left:menuleft+"px", width:swidth+'px'}).slideDown(jqueryslidemenu.animateduration.over);

								if( $(this).hasClass('fullwidth') ){
									$targetul.css({ left: '0px' });
									var wpad = parseInt( ($(window).width()-$('#content > .container').width())/2 );
									var cleft = (0 - $targetul.offset().left + wpad);
									$targetul.css({ width:$('#content > .container').width(), left: cleft+'px' });
								}
							} //if 1 or less queued animations
						},
						function(e){
							var $targetul=$(this).children("ul:eq(0)")
							$targetul.slideUp(jqueryslidemenu.animateduration.out)
						}
					) //end hover
				}
			}) //end $headers.each()
			$mainmenu.find("ul").each(function(){
				if( !jQuery(this).parent().hasClass('widget') && !jQuery(this).parent().hasClass('page_item') ){
					jQuery(this).css({display:'none', visibility:'visible'})
				}
			});
		}) //end document.ready
	}
}

//build menu with ID="myslidemenu" on page:
jqueryslidemenu.buildmenu(".mainmenu");
*/
jQuery("<style type='text/css' id='dynamic_menu_style' />").appendTo("head");
