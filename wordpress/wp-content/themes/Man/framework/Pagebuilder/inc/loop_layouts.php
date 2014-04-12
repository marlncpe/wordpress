<?php

/*
 * Regular blog loop
 *************************************************************/
function blox_loop_regular($overlay = 'both', $content = 'excerpt') {
    global $post, $layout_sidebar;
    $crop_width = 846;
    if($layout_sidebar == 'full')
        $crop_width = 1140;
    ?>
    <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo format_class(get_the_ID()); ?> blog_medium medium_top_image post_filter_item <?php echo get_post_filter_cats(); ?> clearfix">
        <?php
        if(in_array(get_post_format(), array('video', 'audio', 'gallery', 'image') ))
            call_user_func('blox_format_'. get_post_format());
        else
            echo hover_featured_image(get_the_ID(), $overlay, false, $crop_width);
        ?>
        <div class="entry_title">
            <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
        <div class="entry_meta">
            <ul class="top_meta">
                <li class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></li>
                <li itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . get_the_category_list(', '); ?></li>
            </ul>
            <ul class="bottom_meta">
                <li itemprop="dateCreated" class="meta_date"><i class="icon-time"></i><?php echo __("Posted: ", "themeton") . date_i18n("M j, Y", strtotime(get_the_date())); ?></li>
                <li itemprop="comment" class="meta_comment"><i class="icon-comment"></i><?php echo __("Comments: ", "themeton") . comment_count(); ?></li>
                <li class="meta_like"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></li>
            </ul>
            <a href="<?php echo get_post_format_link(get_post_format(get_the_ID()));?>" title="<?php echo ucfirst(get_post_format()) .' '. __('posts', 'themeton'); ?>" class="entry_format"></a>
        </div>
        <?php blox_post_content($content); ?>
    </article>
<?php
}

function blox_post_content($content = 'nocontent') {
    global $post, $readmoretext;
    if ($content == 'both') { ?>
        <div class="entry_content">
            <?php the_excerpt(); ?>
            <p><a href="<?php the_permalink(); ?>" class="entry_more blox_elem_button blox_elem_button_medium blox_elem_color_background blox_elem_button_default"><i class="icon-arrow-right"></i><?php echo isset($readmoretext) ? $readmoretext : __('Read more', 'themeton'); ?></a></p>
        </div>
    <?php } elseif ($content == 'content') { ?>
        <div class="entry_content post_excert">
            <?php
                global $more;
                $more = 0;
                the_content( __('<span class="entry_more blox_elem_button blox_elem_button_medium blox_elem_color_background blox_elem_button_default"><i class="icon-arrow-right"></i> Read more</span>', 'themeton') );
                ?>
        </div>
    <?php } elseif ($content == 'excerpt') { ?>
        <div class="entry_content">
            <?php the_excerpt(); ?>
        </div>
    <?php }
}


/*
 * Post format : Video
 *************************************************************/
function blox_format_video() {
    global $post;
    $video_content = get_post_meta($post->ID, '_format_video_embed', true);
    if ($video_content == '')
        return;
    echo '<div class="entry_media">';
    $embedCheck = array("<embed", "<video", "<ifram", "<objec"); // only checking against the first 6

    $firstSix = substr($video_content, 0, 6); // get the first 6 char 

    if (strpos($firstSix, "http:/") !== false || strpos($firstSix, "https:") !== false) {
        if (wp_oembed_get($video_content) !== false) {
            // Embed convertion
            echo wp_oembed_get($video_content);
        } else {
            
            $fimage = '';
            if (has_post_thumbnail(get_the_ID())) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'blog');
                $fimage = $image[0];
            }
            // Seems self hosted video
            echo get_video_player($video_content, '#3a87ad', '', $fimage);
        }
    } else if (tt_strpos_arr($firstSix, $embedCheck) !== false) {
        // Yeah it is embeded content
        echo $video_content;
    } else if (current_user_can('publish_posts')) {
        $content_oembed = "<p><strong>Whoops! That embed link or code has problems:</strong></p>";
        $content_oembed .= "URL should begin with http:// or https:// <br/>";
        $content_oembed .= "Embed code should be wrapped in either &lt;embed&gt;&lt;/embed&gt; &lt;video&gt;&lt;/video&gt; or &lt;iframe&gt;&lt;/iframe&gt; elements.";
        $content_oembed .= "<p>" . $video_content . "</p>";
        echo $content_oembed;
    }
    echo '</div><!-- .entry-media -->';
}
function tt_strpos_arr($haystack, $needle) { 
    if(!is_array($needle)) $needle = array($needle); 
    foreach($needle as $what) { 
        if(($pos = strpos($haystack, $what))!==false) return $pos; 
    } 
    return false; 
}   
/*
 * Post format : Audio
 *************************************************************/
function blox_format_audio() {
    global $post;
    $audio_content = get_post_meta($post->ID, '_format_audio_embed', true);
    if ($audio_content == '')
        return;
    echo '<div class="entry_media blox_elem_audio">';
    $embedCheck = array("<embed", "<video", "<ifram", "<objec"); // only checking against the first 6

    $firstSix = substr($audio_content, 0, 6); // get the first 6 char 

    if (strpos($firstSix, "http:/") !== false || strpos($firstSix, "https:") !== false) {
        if (wp_oembed_get($audio_content) !== false) {
            // Embed convertion
            echo wp_oembed_get($audio_content);
        } else {
            // Seems self hosted audio
            echo get_audio_player($audio_content);
        }
    } else if (tt_strpos_arr($firstSix, $embedCheck) !== false) {
        echo $audio_content;
    } else if (current_user_can('publish_posts')) {
        $content_oembed = "<p><strong>Whoops! That embed link or code has problems:</strong></p>";
        $content_oembed .= "URL should begin with http:// or https:// <br/>";
        $content_oembed .= "Embed code should be wrapped in either &lt;embed&gt;&lt;/embed&gt; &lt;video&gt;&lt;/video&gt; or &lt;iframe&gt;&lt;/iframe&gt; elements.";
        $content_oembed .= "<p>" . $audio_content . "</p>";
        echo $content_oembed;
    }
    echo '</div><!-- .entry-media -->';
}
/*
 * Post format : Image
 *************************************************************/
function blox_format_image() {
    global $post;
    $image_content = get_post_meta($post->ID, '_format_image', true);
    if ($image_content == '')
        return;
    echo '<div class="entry_media blox_elem_image">';

    if (strpos($image_content, "<") !== false) {
        // HTML
        echo $image_content;
    } else if (strpos($image_content, 'http') === 0) {
        // Image url
        echo "<img src='$image_content' alt='Featured Image'/>";
    }
    echo '</div><!-- .entry-media -->';
}

/*
 * Post format : Gallery
 *************************************************************/
function blox_format_gallery() {
    $pattern = get_shortcode_regex();

    if (preg_match("/$pattern/s", get_the_content(), $match) && 'gallery' == $match[2]) {
        add_filter('shortcode_atts_gallery', 'tt_format_gallery_atts');
        echo do_shortcode_tag($match);
    }
}
function tt_format_gallery_atts($atts) {
    $atts['size'] = 'large';
    $atts['media'] = 'large';
    return $atts;
}



/* WORDPRESS GALLERY function OVERRIDE */
/* =================================================== */
remove_shortcode( 'gallery', 'gallery_shortcode' );
add_shortcode('gallery', 'themeton_gallery_shortcode');    
function themeton_gallery_shortcode($attr) {
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $i = 0;
    $html = '';
    foreach ( $attachments as $id => $attachment ) {
        $attach_url = wp_get_attachment_url($id);
        $img = blox_aq_resize($attach_url, 800, 430, true);

        $html .= '<img src="'.$img.'" />';
    }

    return '<div class="blox_element blox_gallery gallery_layout_slider">
                <span class="gallery_preview">'.$html.'</span>
                <span class="gallery_pager"></span>
            </div>';
}






/* WP 3.6 functions */
if ( ! function_exists( 'get_post_galleries' ) ){
    function get_post_galleries( $post, $html = true ) {
        if ( ! $post = get_post( $post ) )
            return array();

        if( strpos($post->post_content, '[gallery') !== false ){  }else{ return array(); }

        $galleries = array();
        if ( preg_match_all( '/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER ) ) {
            foreach ( $matches as $shortcode ) {
                if ( 'gallery' === $shortcode[2] ) {
                    $srcs = array();
                    $count = 1;

                    $gallery = do_shortcode_tag( $shortcode );
                    if ( $html ) {
                        $galleries[] = $gallery;
                    } else {
                        preg_match_all( '#src=([\'"])(.+?)\1#is', $gallery, $src, PREG_SET_ORDER );
                        if ( ! empty( $src ) ) {
                            foreach ( $src as $s )
                                $srcs[] = $s[2];
                        }

                        $data = shortcode_parse_atts( $shortcode[3] );
                        $data['src'] = array_values( array_unique( $srcs ) );
                        $galleries[] = $data;
                    }
                }
            }
        }

        return apply_filters( 'get_post_galleries', $galleries, $post );
    }
}
if ( ! function_exists( 'get_post_gallery' ) ){
    function get_post_gallery( $post = 0, $html = true ) {
        $galleries = get_post_galleries( $post, $html );
        $gallery = reset( $galleries );

        return apply_filters( 'get_post_gallery', $gallery, $post, $galleries );
    }
}

if ( ! function_exists( 'get_post_gallery_images' ) ){
    function get_post_gallery_images( $post = 0 ) {
        $gallery = get_post_gallery( $post, false );
        return empty( $gallery['src'] ) ? array() : $gallery['src'];
    }
}



/*
 * Featured Image with Overlay and proper options
 *************************************************************/
function hover_featured_image($post_id, $overlay = 'both', $placeholder = false, $w = 868, $h = 0) {
    $result = '';
    if($placeholder) {
        $height = $h > 0 ? $h . 'px' : '180px';
        $result = "<div class='entry_media'><div class='blox_elem_placeholder' style='height:$height;background-color:rgba(192, 192, 192, .3)'><span class='icon-picture'></span></div></div>";
    }
    $image_source = '';
    $tmp_post = get_post($post_id); 

    if (has_post_thumbnail($post_id)){
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'blog');
        $image_source = $image[0];
    }
    else if( strpos($tmp_post->post_content, '[gallery') !== false ){
        $gallery = get_post_gallery_images($tmp_post);
        $image_source = isset($gallery[0]) ? $gallery[0] : '';
    }

    if ($image_source!='') {
        $image = aq_resize($image_source, $w, $h, true);
        if($image == '') return $result;
        $result = '<div class="entry_media">';
        if($overlay != '') {
            $result .= '    <div class="entry_hover animate_icon">';
            if ($overlay == 'permalink' || $overlay == 'both') {
                $result .='<div class="entry_article_link"><a href="' . get_permalink($post_id) . '" title=""><i class="icon-link"></i></a></div>';
            }
            if ($overlay == 'lightbox' || $overlay == 'both') {
                $result .='<div class="entry_image_link"><a href="'.$image_source.'" rel="prettyPhoto" title=""><i class="icon-picture"></i></a></div>';
            }
            $result .= '    </div>';
        } // end of overlay
        $result .= '    <img itemprop="image" src="' . $image . '" alt="Post Image"/>
                </div><!-- end .entry_media -->';
    }
    return $result;
}


/*
 * Metro blog loop
 *************************************************************/
function blox_loop_metro() {
    get_metro_content();
}


function is_folio(){
    global $prefix;
    return isset($prefix) && $prefix=='portfolio' ? true : false;
}

/*
 * Centered blog loop
 *************************************************************/
function blox_loop_centered($overlay = 'both', $content = 'excerpt') {
    global $post, $layout_sidebar;
    $crop_width = 846;
    if($layout_sidebar == 'full')
        $crop_width = 1138;
    ?>
    <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> <?php echo format_class(get_the_ID()); ?> blog_big post_filter_item <?php echo get_post_filter_cats(); ?>">
        <div class="entry_title">
            <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>                                        
        <div class="entry_meta">
            <ul>
                <li itemprop="dateCreated" class="meta_date"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></li>
                <?php if(!is_folio()): ?>
                <li itemprop="comment" class="meta_comment"><?php echo __("Comments: ", "themeton") . comment_count(); ?></li>
                <li class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></li>
                <?php endif; ?>
                <li itemprop="keywords" class="entry_category">
                    <?php
                    if(!is_folio()){
                        echo __("IN ", "themeton") . get_the_category_list(', ');
                    }
                    else{
                        echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ');
                    }
                    ?>
                </li>
                <li class="meta_like"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></li>
            </ul>
        </div>
        <?php 
        if(in_array(get_post_format(), array('video', 'audio', 'gallery', 'image') ))
            call_user_func('blox_format_'. get_post_format());
        else
            echo hover_featured_image(get_the_ID(), $overlay, false, $crop_width);
        ?>
        <div class="entry_content_big_container clearfix">
            <div class="entry_meta_big">

                <?php echo get_avatar($post->post_author, 80); ?>

                <a href="<?php echo get_post_format_link(get_post_format(get_the_ID()));?>" title="<?php echo ucfirst(get_post_format()) .' '. __('posts', 'themeton'); ?>" class="entry_format"></a>
            </div>
            <?php blox_post_content($content); ?>
        </div>
    </article>
    <?php
}

/*
 * Right image loop
 *************************************************************/
function blox_loop_rightimage($overlay = 'both', $content = 'excerpt') {
    global $post;
    ?>
    <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo format_class(get_the_ID()); ?> blog_medium medium_right_image post_filter_item <?php echo get_post_filter_cats(); ?> clearfix">
        <?php echo hover_featured_image(get_the_ID(), $overlay, true, 219, 150); ?>
        <div class="entry_title">
            <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
        <div class="entry_meta">
            <ul>
                <li itemprop="dateCreated" class="meta_date"><?php echo __("Posted: ", "themeton") . date_i18n("M j, Y", strtotime(get_the_date())); ?></li>
                <li itemprop="comment" class="meta_comment"><?php echo __("Comments: ", "themeton") . comment_count(); ?></li>
                <li class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></li>
                <li itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . get_the_category_list(', '); ?></li>
                <li class="meta_like"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></li>
            </ul>
        </div>
        <?php blox_post_content($content); ?>
    </article>
    <?php
}

/*
 * Left image loop
 *************************************************************/
function blox_loop_leftimage($overlay = 'both', $content = 'excerpt') {
    global $post;
    ?>
    <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo format_class(get_the_ID()); ?> blog_medium medium_left_image post_filter_item <?php echo get_post_filter_cats(); ?> clearfix">
        <?php echo hover_featured_image(get_the_ID(), $overlay, true, 219, 150); ?>
        <div class="entry_title">
            <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
        <div class="entry_meta">
            <ul>
                <li itemprop="dateCreated" class="meta_date"><?php echo __("Posted: ", "themeton") . date_i18n("M j, Y", strtotime(get_the_date())); ?></li>
                <li itemprop="comment" class="meta_comment"><?php echo __("Comments: ", "themeton") . comment_count(); ?></li>
                <li class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></li>
                <li itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . get_the_category_list(', '); ?></li>
                <li class="meta_like"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></li>
            </ul>
        </div>
        <?php blox_post_content($content); ?>
    </article>
    <?php
}

/*
 * Grid 2 columns
 *************************************************************/
function blox_loop_grid2($overlay = 'both', $content = 'nocontent') {
    global $post, $layout_sidebar;
    $crop_width = 393;
    if($layout_sidebar == 'full')
        $crop_width = 539;
    
    $class = 'col-xs-12 col-xxs-6 col-sm-6 col-md-6 col-lg-6 post_filter_item '.get_post_filter_cats();
    $class .= ($content != 'nocontent') ? ' with_excerpt' : '';
    ?>
    <div class="<?php echo $class; ?>">
        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> clearfix">
            <?php echo hover_featured_image(get_the_ID(), $overlay, true, $crop_width, 300); ?>
            <div class="entry_title">
                <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        <?php blox_post_content($content); ?>
            <?php if(!is_folio()): ?>
            <div class="entry_meta">
                <span class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></span>
                <span itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . (is_tax() ? get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ') :get_the_category_list(', ')); ?></span>
            </div>
            <?php endif; ?>
            <footer class="clearfix">
                <?php if(!is_folio()): ?><span itemprop="dateCreated" class="meta_date pull-left"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></span><?php endif; ?>
                <?php if(is_folio()): ?><span itemprop="keywords" class="entry_category"><?php echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', '); ?></span><?php endif; ?>
                <span class="meta_like pull-right"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></span>
                <?php if(!is_folio()): ?>
                <span itemprop="comment" class="meta_comment pull-right"> <?php echo comment_count_grid(); ?></span>
                <?php endif; ?>
            </footer>
        </article>
    </div>
    <?php
}
/*
 * Grid 3 columns
 *************************************************************/
function blox_loop_grid3($overlay = 'both', $content = 'nocontent') {
    global $post, $layout_sidebar;
    $crop_width = 246;
    if($layout_sidebar == 'full'){
        $crop_width = 344;
    }

    $class = 'col-xs-12 col-xxs-6 col-sm-6 col-md-4 col-lg-4 post_filter_item '.get_post_filter_cats();
    $class .= ($content != 'nocontent') ? ' with_excerpt' : '';
    ?>
    <div class="<?php echo $class; ?>">
        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> clearfix">
            <?php echo hover_featured_image(get_the_ID(), $overlay, true, $crop_width, 210); ?>
            <div class="entry_title">
                <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        <?php blox_post_content($content); ?>
            <?php if(!is_folio()): ?>
            <div class="entry_meta">
                <span class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></span>
                <span itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . (is_tax() ? get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ') :get_the_category_list(', ')); ?></span>
            </div>
            <?php endif; ?>
            <footer class="clearfix">
                <?php if(!is_folio()): ?><span itemprop="dateCreated" class="meta_date pull-left"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></span><?php endif; ?>
                <?php if(is_folio()): ?><span itemprop="keywords" class="entry_category"><?php echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', '); ?></span><?php endif; ?>
                <span class="meta_like pull-right"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></span>
                <?php if(!is_folio()): ?><span itemprop="comment" class="meta_comment pull-right"> <?php echo comment_count_grid(); ?></span><?php endif; ?>
            </footer>
        </article>
    </div>
    <?php
}
/*
 * Grid 4 columns
 *************************************************************/
function blox_loop_grid4($overlay = 'both', $content = 'nocontent') {
    global $post, $layout_sidebar;
    $crop_width = 173;
    if($layout_sidebar == 'full'){
        $crop_width = 247;
    }
    
    $class = 'col-xs-12 col-xxs-6 col-sm-6 col-md-3 col-lg-3 post_filter_item '.get_post_filter_cats();
    $class .= ($content != 'nocontent') ? ' with_excerpt' : '';
    ?>
    <div class="<?php echo $class; ?>">
        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> clearfix">
            <?php echo hover_featured_image(get_the_ID(), $overlay, true, $crop_width, 180); ?>
            <div class="entry_title">
                <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        <?php blox_post_content($content); ?>
            <?php if(!is_folio()): ?>
            <div class="entry_meta">
                <span class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></span>
                <span itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . (is_tax() ? get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ') :get_the_category_list(', ')); ?></span>
            </div>
            <?php endif; ?>
            <footer class="clearfix">
                <?php if(!is_folio()): ?><span itemprop="dateCreated" class="meta_date pull-left"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></span><?php endif; ?>
                <?php if(is_folio()): ?><span itemprop="keywords" class="entry_category"><?php echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', '); ?></span><?php endif; ?>
                <span class="meta_like pull-right"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>" title=""><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></span>
                <?php if(!is_folio()): ?><span itemprop="comment" class="meta_comment pull-right"> <?php echo comment_count_grid(); ?></span><?php endif; ?>
            </footer>
        </article>
    </div>
    <?php
}

/*
 * Maronry 2 columns
 *************************************************************/
function blox_loop_masonry2($overlay = 'both', $content = 'nocontent') {
    global $post, $layout_sidebar;
    $crop_width = 393;
    if($layout_sidebar == 'full')
        $crop_width = 539;
    
    $class = 'col-xs-12 col-xxs-6 col-sm-6 col-md-6 col-lg-6 post_filter_item '.get_post_filter_cats();
    ?>
    <div class="<?php echo $class; ?>">
        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> clearfix">
            <?php echo hover_featured_image(get_the_ID(), $overlay, false, $crop_width); ?>
            <div class="entry_title">
                <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        <?php blox_post_content($content); ?>
            <?php if(!is_folio()): ?>
            <div class="entry_meta">
                <span class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></span>
                <span itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . (is_tax() ? get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ') :get_the_category_list(', ')); ?></span>
            </div>
            <?php endif; ?>
            <footer class="clearfix">
                <?php if(!is_folio()): ?><span itemprop="dateCreated" class="meta_date pull-left"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></span><?php endif; ?>
                <?php if(is_folio()): ?><span itemprop="keywords" class="entry_category"><?php echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', '); ?></span><?php endif; ?>
                <span class="meta_like pull-right"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></span>
                <?php if(!is_folio()): ?><span itemprop="comment" class="meta_comment pull-right"> <?php echo comment_count_grid(); ?></span><?php endif; ?>
            </footer>
        </article>
    </div>
    <?php
}
/*
 * Maronry 3 columns
 *************************************************************/
function blox_loop_masonry3($overlay = 'both', $content = 'nocontent') {
    global $post, $layout_sidebar;
    $crop_width = 246;
    if($layout_sidebar == 'full'){
        $crop_width = 344;
    }

    $class = 'col-xs-12 col-xxs-6 col-sm-6 col-md-4 col-lg-4 post_filter_item '.get_post_filter_cats();
    ?>
    <div class="<?php echo $class; ?>">
        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> clearfix">
            <?php echo hover_featured_image(get_the_ID(), $overlay, false, $crop_width); ?>
            <div class="entry_title">
                <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        <?php blox_post_content($content); ?>
            <?php if(!is_folio()): ?>
            <div class="entry_meta">
                <span class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></span>
                <span itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . (is_tax() ? get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ') :get_the_category_list(', ')); ?></span>
            </div>
            <?php endif; ?>
            <footer class="clearfix">
                <?php if(!is_folio()): ?><span itemprop="dateCreated" class="meta_date pull-left"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></span><?php endif; ?>
                <?php if(is_folio()): ?><span itemprop="keywords" class="entry_category"><?php echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', '); ?></span><?php endif; ?>
                <span class="meta_like pull-right"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></span>
                <?php if(!is_folio()): ?><span itemprop="comment" class="meta_comment pull-right"> <?php echo comment_count_grid(); ?></span><?php endif; ?>
            </footer>
        </article>
    </div>
    <?php
}
/*
 * Maronry 4 columns
 *************************************************************/
function blox_loop_masonry4($overlay = 'both', $content = 'nocontent') {
    global $post, $layout_sidebar;
    $crop_width = 173;
    if($layout_sidebar == 'full')
        $crop_width = 247;
    
    $class = 'col-xs-12 col-xxs-6 col-sm-6 col-md-3 col-lg-3 post_filter_item '.get_post_filter_cats();
    ?>
    <div class="<?php echo $class; ?>">
        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry <?php echo is_folio() ? 'portfolio' : ''; ?> clearfix">
            <?php echo hover_featured_image(get_the_ID(), $overlay, false, $crop_width); ?>
            <div class="entry_title">
                <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
        <?php blox_post_content($content); ?>
            <?php if(!is_folio()): ?>
            <div class="entry_meta">
                <span class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></span>
                <span itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . (is_tax() ? get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', ') :get_the_category_list(', ')); ?></span>
            </div>
            <?php endif; ?>
            <footer class="clearfix">
                <?php if(!is_folio()): ?><span itemprop="dateCreated" class="meta_date pull-left"><?php echo date_i18n("M j, Y", strtotime(get_the_date())); ?></span><?php endif; ?>
                <?php if(is_folio()): ?><span itemprop="keywords" class="entry_category"><?php echo get_the_term_list( get_the_ID(), 'portfolio_entries', '', ', '); ?></span><?php endif; ?>
                <span class="meta_like pull-right"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></span>
                <?php if(!is_folio()): ?><span itemprop="comment" class="meta_comment pull-right"> <?php echo comment_count_grid(); ?></span><?php endif; ?>
            </footer>
        </article>
    </div>
    <?php
}
?>
