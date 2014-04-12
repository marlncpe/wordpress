var ThemifyBuilderModuleJs;
;(function($, window, document, undefined) {
	ThemifyBuilderModuleJs = {
		init: function() {
			this.bindEvents();

			if(tbLocalScript.isTouch) {
				$('body').addClass('builder-is-touch');
			}
		},

		bindEvents: function() {
			var self = ThemifyBuilderModuleJs;

			$(document).ready(function(){
				self.accordion();
				self.tabs();
				self.tabsDeepLink();

				if(tbLocalScript.isTouch) return;
				self.animationOnScroll();
			});

			$(window).load(function(){
				self.carousel();

				if(tbLocalScript.isTouch) return;
				self.backgroundScrolling();
			});
		},

		loadOnAjax: function() {
			ThemifyBuilderModuleJs.accordion();
			ThemifyBuilderModuleJs.tabs();
			ThemifyBuilderModuleJs.carousel();
		},

		accordion: function() {
			$('.module.module-accordion').themify_accordion();
		},

		tabs: function() {
			$(".module.module-tab").each(function(){
				$height = $(".tab-nav", this).outerHeight();
				if($height > 200) {
					$(".tab-content", this).css('min-height', $height);
				}
			});
			$(".module.module-tab").tabify();
		},

		tabsDeepLink: function() {
			if($(window.location.hash).length > 0){
				$('a[href=' + window.location.hash + ']').click();
				$('html, body').animate({ scrollTop: $(window.location.hash).offset().top}, 1000);
			}
		},

		carousel: function() {
			$('.themify_builder_slider').each(function(){
				var $this = $(this),
					$args = {
					responsive: true,
					circular: true,
					infinite: true,
					height: 'auto',
					items: {
						visible: { min: 1, max: $this.data('visible') },
						width: 150
					},
					onCreate: function( items ) {
						var heights = [];
						$('.themify_builder_slider_wrap').css({'visibility':'visible', 'height':'auto'});

						$.each( items, function() {
							heights.push( $(this).outerHeight() );
						});
						$( '.caroufredsel_wrapper, .themify_builder_slider, .themify_builder_slider li', $this ).outerHeight( Math.max.apply( Math, heights ) );

						$('.themify_builder_slider_loader').remove();
					}
				};

				if($this.closest('.themify_builder_slider_wrap').find('.caroufredsel_wrapper').length > 0) {
					return;
				}

				// fix the one slide problem
				if($this.children().length < 2) {
					$('.themify_builder_slider_wrap').css({'visibility':'visible', 'height':'auto'});
					$('.themify_builder_slider_loader').remove();
					$(window).resize();
					return;
				}

				// Auto
				if(parseInt($this.data('auto-scroll')) > 0) {
					$args.auto = {
						play: true,
						pauseDuration: parseInt($this.data('auto-scroll') * 1000)
					};
				}
				else if($this.data('effect') !== 'continuously' && ( typeof $this.data('auto-scroll') !== 'undefined' || parseInt($this.data('auto-scroll')) == 0 )  ){
					$args.auto = false;
				}

				// Scroll
				if($this.data('effect') == 'continuously'){
					if(typeof $args.auto !== 'undefined'){
						delete $args.auto;
					}
					var speed = $this.data('speed'), duration;
					if ( speed == .5 ) {
						duration = 0.10;
					} else if ( speed == 4 ) {
						duration = 0.04;
					} else {
						duration = 0.07;
					}
					$args.auto = { pauseDuration: 0 };
					$args.align = false;
					$args.scroll = {
						delay: 1000,
						easing: 'linear',
						items: $this.data('scroll'),
						duration: duration,
						timeoutDuration: 0,
						pauseOnHover: $this.data('pause-on-hover')
					};
				} else {
					$args.scroll = {
						items: $this.data('scroll'),
						wipe: true,
						pauseOnHover: $this.data('pause-on-hover'),
						duration: parseInt($this.data('speed') * 1000),
						fx: $this.data('effect')
					}
				}

				if($this.data('arrow') == 'yes') {
					$args.prev = '#' + $this.data('id') + ' .carousel-prev';
					$args.next = '#' + $this.data('id') + ' .carousel-next';
				}

				if($this.data('pagination') == 'yes') {
					$args.pagination = { container: '#' + $this.data('id') + ' .carousel-pager' };
				}

				if($this.data('wrapper') == 'no') {
					$args.wrapper = {
						element: false
					}
				}

				$this.carouFredSel($args);
			});
		},

		request: 0,

		initialize: function(address, num, zoom, type, scroll, drag) {
			var delay = this.request++ * 500;
			setTimeout( function(){
				var geo = new google.maps.Geocoder(),
					latlng = new google.maps.LatLng(-34.397, 150.644),
					mapOptions = {
						'zoom': zoom,
						center: latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						scrollwheel: scroll,
						draggable: drag
					};
				switch( type.toUpperCase() ) {
					case 'ROADMAP':
						mapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
						break;
					case 'SATELLITE':
						mapOptions.mapTypeId = google.maps.MapTypeId.SATELLITE;
						break;
					case 'HYBRID':
						mapOptions.mapTypeId = google.maps.MapTypeId.HYBRID;
						break;
					case 'TERRAIN':
						mapOptions.mapTypeId = google.maps.MapTypeId.TERRAIN;
						break;
				}
				var	map = new google.maps.Map( document.getElementById( 'themify_map_canvas_' + num ), mapOptions );
				geo.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location
						});
					}
				});
			}, delay );
		},

		backgroundScrolling: function() {
			$('.builder-parallax-scrolling').builderParallax('50%', 0.1);
		},

		animationOnScroll: function() {
			var self = ThemifyBuilderModuleJs;
			$('body').addClass('animation-on')
			.on('builder_toggle_frontend', function(event, is_edit){
				if(!is_edit){
					self.doAnimation();
				}
			});
			self.doAnimation();
		},

		doAnimation: function(){
			// On scrolling animation
			var selectors = '.module.fly-in .post, .shortcode.fly-in .post, .themify_builder_row.fly-in .tb-column, .module.fade-in .post, .shortcode.fade-in .post, .themify_builder_row.fade-in .tb-column, .module.slide-up .post, .shortcode.slide-up .post, .themify_builder_row.slide-up .tb-column',
				iterate = 0;

			$(selectors).on('inview', function(event, isInView, visiblePartX, visiblePartY) {
				if (isInView) {
					if($(this).hasClass('animated')) return;

					// FadeIn & SlideUp
					if($(this).closest('.slide-up').length > 0 || $(this).closest('.fade-in').length > 0 ){
						var duration = $(this).closest('.slide-up').length ? 100 : 500;
						var $this = $(this);
						iterate = iterate + 1;
						setTimeout(function(){
							$this.addClass('animated');
							iterate = 0;
						}, iterate * duration);
					} else {
						$(this).addClass('animated');
					}
				} else {
					// element has gone out of viewport
					$(this).removeClass('animated');
					$(this).removeClass('animated');
				}
			});
		}
	};

	// Initialize
	ThemifyBuilderModuleJs.init();

}(jQuery, window, document));