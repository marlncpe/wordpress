<?php


add_action('wp_ajax_get_blox_element_portfolio', 'blox_element_portfolio_hook');
add_action('wp_ajax_nopriv_blox_element_portfolio', 'blox_element_portfolio_hook');
function blox_element_portfolio_hook() {
    try {
        $value = isset($_POST['value']) ? $_POST['value'] : '';
        $value_array = explode(',', $value);
        $html = '';

        $taxonomies = get_object_taxonomies('portfolio');
        if (count($taxonomies) > 0) {
            $terms = get_terms($taxonomies[0]);
            foreach ($terms as $term) {
                $selected = '';
                if( in_array($term->term_id, $value_array) ){
                    $selected = 'selected';
                }
                $html .= '<option value="'.$term->term_id.'" '.$selected.'>'.$term->name.'</option>';
            }
        }
        $html = "<select id='blox_new_cats' multiple>$html</select>";

        echo "<div>$html</div>";
    }
    catch (Exception $e) {
        echo "-1";
    }
    exit;
}



function blox_portfolio_parse_hook($atts) {
    extract(shortcode_atts(array(
                'title' => '',
                'style' => 'default',
                'categories' => '',
                'count' => '5',
                'pager' => '0',
                'height' => '',
                'readmore' => __('Read more', 'themeton'),
                'ignoresticky' => 'yes',
                'filter' => '1',
                'overlay' => '',
                'exclude' => '',
                'order' => '',
                'extra_class' => '',
                'skin' => 'default'
                    ), $atts));

    global $query, $post, $paged;
    $temp_qry = $query;
    $temp_post = $post;

    wp_reset_query();
    wp_reset_postdata();

	if(is_front_page()){
        $paged = get_query_var('page')?get_query_var('page'):1;   
    }
    $args = array(
        'post_type' => 'portfolio',
        'post__not_in' => array($exclude),
        'posts_per_page' => (int) $count,
        'paged' => $paged,
        'ignore_sticky_posts' => $ignoresticky == 'yes' ? 1 : 0
    );

    if( $categories!='' ){
        $format_array = explode(',', $categories);
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_entries',
                'field' => 'id',
                'terms' => $format_array
            )
        );
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

    $result = '';
    $title = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        // Grid container
        $masonry_class = '';
        if(strpos($style, 'masonry') !== false){
            $masonry_class = 'masonry';
        }
        $result .='<div class="grid_entry '.$masonry_class.' row" style="'.($masonry_class!='' ? 'width:100%;' : '').'"><div class="">';

        $cats_filter = array();
        $item_number = 0;

        while ($query->have_posts()) {
            $query->the_post();

            // If it is grid style, there don't need image scaled cropping
            $image_height = 0;
            if(strpos($style, 'grid') !== false) {
                $image_height = $height != '' ? (int) $height : 0;
            }
            
            $item_number++;
            $class = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
            $image_width = 539;
            if ($style == 'masonry3' || $style == 'grid3') {
                $class = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
                $image_width = 344;
            } else if ($style == 'masonry4' || $style == 'grid4') {
                $class = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
                $image_width = 247;
            } else if ($style == 'centered') {
                $class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 centered_portfolio';
                $image_width = 0;
            }
            
            
            // If it is centered style, there don't need image overlay
            if($style == 'centered') {
                $overlay = 'nothing';
            }

            $current_filter_classes = '';
            $terms = wp_get_post_terms( get_the_ID(), 'portfolio_entries' );
            foreach($terms as $term){
                $current_filter_classes .= 'filter-'.$term->slug.' ';

                $temp_cat = array(
                    'id' => $term->term_id,
                    'title' => $term->name,
                    'slug' => $term->slug
                );
                if (!in_array($temp_cat, $cats_filter)) {
                    $cats_filter[] = $temp_cat;
                }
            }

            $result .= '<div class="' . $class . ' post_filter_item '.$current_filter_classes.'">
                            <article itemscope itemtype="http://schema.org/BlogPosting" class="entry portfolio">
                            '.hover_featured_image(get_the_ID(), $overlay, true, $image_width, $image_height).'
                                <div class="entry_title">
                                    <h2 itemprop="headline"><a itemprop="url" href="' . get_permalink() . '">' . get_the_title() . '</a></h2>
                                </div>
                                <footer class="clearfix">
                                    <span itemprop="keywords" class="entry_category pull-left">' . get_the_term_list(get_the_ID(), 'portfolio_entries', '', ', ') . '</span>
                                    <span class="meta_like pull-right"><a href="javascript:;" pid="'.get_the_ID().'" class="'.blox_post_liked(get_the_ID()).'"><i class="icon-heart"></i> <span>'.(int)blox_getmeta(get_the_ID(), 'post_like').'</span></a></span>
                                </footer>
                            </article>
                        </div>';
            
            
            // Clearfix for Grid layouts, for each row
            if (strpos($style, 'grid') !== false) {
                $column = (int)str_replace('grid', '', $style);
                if($item_number % $column == 0) {
                    $result .= '<div class="clearfix"></div>';
                }
            }
        }

        if ($filter == '1') {
            $cat_filter_html = '';
            foreach ($cats_filter as $cat) {
                $cat_filter_html .= '<li><a href="javascript:;" title="' . $cat['title'] . '" data-filter="filter-' . $cat['slug'] . '">' . $cat['title'] . '</a></li>';
            }

            if ($cat_filter_html != '') {
                $result = $title.'<div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="post-filter">
                                        <ul>
                                            <li><a href="javascript:;" title="All" data-filter="all" class="active">All</a></li>
                                            ' . $cat_filter_html . '
                                        </ul>
                                    </div>
                                </div></div>'.$result;
            }
        }

        // Grid container closing div
        $result .='</div><!-- end grid container --></div><!-- end row -->';

    }


    if ($pager == '1') {
        ob_start();
        $result .= '<div class="grid_pager" style="overflow:hidden; width:100%;">';
        tt_paginate_links($query);
        $result .= ob_get_contents();
        $result .= '</div><!-- .grid_pager -->';
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

add_shortcode('blox_portfolio', 'blox_portfolio_parse_hook');

?>