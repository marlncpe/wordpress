<?php



add_action('wp_ajax_get_blox_element_blog', 'get_blox_element_blog_hook');
add_action('wp_ajax_nopriv_get_blox_element_blog', 'get_blox_element_blog_hook');
function get_blox_element_blog_hook() {
    try {
        $filter = $_POST['filter'];
        $value = $_POST['value'];
        $value_array = explode(',', $value);
        $html = '';

        // get categories
        $categories = get_categories();
        foreach ($categories as $cat) {
            $selected = '';
            if( $filter=='categories' && in_array($cat->cat_ID, $value_array) ){
                $selected = 'selected';
            }
            $html .= '<option value="'.$cat->cat_ID.'" '.$selected.'>'.$cat->name.'</option>';
        }
        $html = "<select id='blox_new_cats' multiple>$html</select>";



        // get tags
        $html .= "<select id='blox_new_tags' multiple>";
        $tags = get_tags();
        foreach ($tags as $tag) {
            $selected = '';
            if( $filter=='tags' && in_array($tag->slug, $value_array) ){
                $selected = 'selected';
            }
            $html .= '<option value="'.$tag->slug.'" '.$selected.'>'.$tag->name.'</option>';
        }
        $html .= "</select>";



        // get post formats
        $html .= "<select id='blox_new_formats' multiple>";
        $post_formats = get_theme_support( 'post-formats' );
        foreach ($post_formats[0] as $format) {
            $selected = '';
            if( $filter=='format' && in_array($format, $value_array) ){
                $selected = 'selected';
            }
            $html .= '<option value="'.$format.'" '.$selected.'>'.$format.'</option>';
        }
        $html .= "</select>";



        echo "<div>$html</div>";
    }
    catch (Exception $e) {
        echo "-1";
    }
    exit;
}



function blox_parse_blog_hook($atts) {
    extract(shortcode_atts(array(
                'title' => '',
                'style' => 'default',
                'categories' => 'all',
                'blog_filter' => '',
                'count' => '5',
                'pager' => '1',
                'content' => 'both',
                'readmore' => __('Read more', 'themeton'),
                'ignoresticky' => 'yes',
                'filter' => '0',
                'overlay' => '',
                'exclude' => '',
                'order' => '',
                'skip' => '0',
                'extra_class' => '',
                'skin' => 'default'
                    ), $atts));

    global $query, $post, $paged, $readmoretext;
    $temp_qry = $query;
    $temp_post = $post;
	
	$readmoretext = $readmore;

    wp_reset_query();
    wp_reset_postdata();
	
    if(is_front_page()){
        $paged = get_query_var('page')?get_query_var('page'):1;   
    }
    $args = array(
        'paged' => $paged,
        'posts_per_page' => (int) $count + (int)$skip,
        'ignore_sticky_posts' => $ignoresticky == 'yes' ? 1 : 0
    );

    if( $categories=='categories' ){
        $args['cat'] = $blog_filter;
    }
    else if( $categories=='tags' ){
        $args['tag'] = $blog_filter;
    }
    else if( $categories=='format' ){
        $format_array = explode(',', $blog_filter);
        $array = array();
        foreach ($format_array as $value) {
            $array[] = 'post-format-'.$value;
        }
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => $array
            )
        );
    }

    // Exclude posts 
    if ($exclude != '') {
        $args['post__not_in'] = array($exclude);
    }
    if ($order == 'dateasc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($order == 'titleasc') {
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
    } elseif ($order == 'titledes') {
        $args['orderby'] = 'title';
        $args['order'] = 'DESC';
    } elseif ($order == 'comment') {
        $args['orderby'] = 'comment_count';
    } elseif ($order == 'postid') {
        $args['orderby'] = 'ID';
    }

    $title = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

    $result = '';
    $open_grid_pager = $close_grid_pager = '';

    $query = new WP_Query($args);
    if ($query->have_posts()) {

        // Grid container
        if (strpos($style, 'grid') !== false) {
            $result .='<div class="grid_entry row">';
        } else if (strpos($style, 'masonry') !== false) {
            $result .='<div class="grid_entry row masonry" style="width:100%">';
        } else if ($style == 'metro') {
            $result .='<div class="metro_container masonry">';
        }

        $cats_filter = array();
        $item_number = 0;

        while ($query->have_posts()) {
            $query->the_post();

            $filter_classes = '';
            $item_number++;
            if($item_number <= $skip) continue;
            $post_categories = wp_get_post_categories(get_the_ID());
            foreach ($post_categories as $c) {
                $cat = get_category($c);
                $temp_cat = array(
                    'id' => $cat->cat_ID,
                    'title' => $cat->cat_name,
                    'slug' => $cat->slug
                );
                $filter_classes .= 'filter-' . $cat->slug;
                if (!in_array($temp_cat, $cats_filter)) {
                    $cats_filter[] = $temp_cat;
                }
            }
            ob_start();
            if (function_exists('blox_loop_' . $style))
                call_user_func('blox_loop_' . $style, $overlay, $content);
            else
                call_user_func('blox_loop_regular', $overlay, $content);
            $result .= ob_get_contents();
            
            // Clearfix for Grid layouts
            if (strpos($style, 'grid') !== false) {
                $column = (int)str_replace('grid', '', $style);
                if($item_number % $column == 0)
                    $result .= '<div class="clearfix"></div>';
            }
            ob_end_clean();
        }

        if ($filter == '1') {
            $cat_filter_html = '';
            foreach ($cats_filter as $cat) {
                $cat_filter_html .= '<li><a href="javascript:;" title="' . $cat['title'] . '" data-filter="filter-' . $cat['slug'] . '">' . $cat['title'] . '</a></li>';
            }
            if ($cat_filter_html != '') {
                $result = $title . '<div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="post-filter">
                                    <ul>
                                        <li><a href="javascript:;" title="All" data-filter="all" class="active">All</a></li>
                                        ' . $cat_filter_html . '
                                    </ul>
                                </div>
                            </div>
                        </div><!-- end row -->' . $result;
            }
        }

        // Grid container closing div
        if (strpos($style, 'grid') !== false || strpos($style, 'masonry') !== false || $style == 'metro') {
            $result .='</div><!-- end grid container -->';
            $open_grid_pager = '<div class="grid_pager" style="overflow:hidden; width:100%;">';
            $close_grid_pager = '</div><!-- .grid_pager -->';
        }
    }


    if ($pager == '1') {
        ob_start();
        $result .= $open_grid_pager;
        
        // Main pagination function
        tt_paginate_links($query);
        $result .= ob_get_contents();
        
        $result .= $close_grid_pager;
        ob_end_clean();
    }
    wp_reset_query();
    wp_reset_postdata();

    $query = $temp_qry;
    $post = $temp_post;

    if( $skin!='' && $skin!='default' ){
        $result = "<div class='blox_skin_container $skin'>$result</div>";
    }
    return $result;
}

add_shortcode('blox_blog', 'blox_parse_blog_hook');
?>