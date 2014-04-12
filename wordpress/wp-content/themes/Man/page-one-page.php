<?php
/*
 * Template Name: One Page Template
 */

get_header();

the_post();

if (tt_getmeta('slider')!='' && tt_getmeta('slider')!='none') { ?>
    <!-- Start Slider -->
    <div id="tt-slider" class="tt-slider">
        <?php 
        $slider_name = tt_getmeta("slider");
        $slider = split("_", $slider_name);
        $shortcode = '';
        if (strpos($slider_name, "layerslider") !== false)
            $shortcode = "[" . $slider[0] . " id='" . $slider[1] . "']";
        elseif (strpos($slider_name, "revslider") !== false)
            $shortcode = "[rev_slider " . $slider[1] . "]";
        echo do_shortcode($shortcode);
        
        ?>
    </div>
    <!-- End Slider -->
<?php } ?>
<!-- Start Main -->
<div id="main">
    <?php
	global $smof_data;
	
    $page_links = array();
	$temp_post = $post;
	$meta_pages = tt_getmeta('onepages');
	$onepages = explode(',', $meta_pages);
	wp_reset_postdata();
	wp_reset_query();
    $forloop_index = 0;
	foreach ($onepages as $page_id):
	if( $page_id!='' && (int)$page_id > 0 ):
		
		$args = array(
	        'post_type' => 'page',
	        'p' => (int)$page_id
	    );
		$page_query = new WP_Query( $args );
		while ( $page_query->have_posts() ):
		$page_query->the_post();
		
        $page_links[] = array( 'title'=>get_the_title(), 'link'=>get_permalink() );

        
            if( isset($post) && tt_getmeta('wp_page_template')=='page-blog-metro.php'):
                include 'template-metro-blog.php';
            else:
                include 'template-page.php';
            endif;
		
	endwhile;
	wp_reset_postdata();
	wp_reset_query();
    elseif( $page_id=='0' ):
        $names = tt_getmeta('onepages_names', $temp_post->ID);
        $links = tt_getmeta('onepages_links', $temp_post->ID);
        $arr_name = explode('^', $names);
        $arr_link = explode('^', $links);
        $page_links[] = array( 'title'=>(isset($arr_name[$forloop_index]) ? $arr_name[$forloop_index] : ''), 'link'=>(isset($arr_link[$forloop_index]) ? $arr_link[$forloop_index] : '') );
	endif;
    $forloop_index++;
	endforeach;
	$post = $temp_post;
?>

    <div id="one_page_menu" style="display:none;"><?php
    	if( tt_getmeta('onepage_menu') == '1' ){
    		foreach ($page_links as $item) {
	            echo '<li>
	                    <a href="'.$item['link'].'">
	                        <span class=""></span><span class="menu_text">'.$item['title'].'</span>
	                    </a>
	                </li>';
	        }
    	}
    ?></div>

</div>
<!-- End Main -->

<?php
	if( tt_getmeta('onepage_menu') == '1' ){
		echo '<style> #header .menu{ display:none; } </style>';
	}
?>



<?php
get_footer();
?>
<script type="text/javascript">
	jQuery(function(){
		
        if( jQuery('#one_page_menu').html()!='' ){
        	if( jQuery('.mainmenu').parent().hasClass('icon_menu') || jQuery('.mainmenu').parent().hasClass('metro_menu') ){
	            jQuery('.mainmenu').parent().removeClass('icon_menu metro_menu').addClass('default_menu');
	        }
	        
        	jQuery('#header').find('.menu').html( jQuery('#one_page_menu').html() ).fadeIn('fast');
	        jQuery('#header').find('.menu a').click(function(event){
				$this = jQuery(this);
				$link = $this.attr('href');
				$obj = jQuery('div[permalink="'+$link+'"],section[permalink="'+$link+'"]');
				if( $obj.length > 0 ){
					jQuery('html, body').animate({
				         scrollTop: $obj.offset().top - jQuery('.sticky-wrapper').height()
					}, 800);
					return false;
				}
				else{
					return true;
				}
			});

			jQuery('div[permalink],section[permalink]').each(function(){
				var $this = jQuery(this);
				$this.waypoint(function(){
					var permalink = $this.attr('permalink')+'';
					var $active_menu = jQuery('.mainmenu').find('a[href="'+permalink+'"]');
					if( $active_menu.length>0 ){
						jQuery('.mainmenu').find('li').removeClass('active_menu');
						$active_menu.parent().addClass('active_menu');
					}
				},{
					offset: function(){
						return -jQuery(this).height()+300;
		                //return jQuery.waypoints('viewportHeight')-200;
		            }
				});
			});

        }
        
	});
</script>