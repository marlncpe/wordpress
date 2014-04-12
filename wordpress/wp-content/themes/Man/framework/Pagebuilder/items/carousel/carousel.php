<?php

add_action('wp_ajax_get_blox_element_carousel', 'get_blox_element_carousel_hook');
add_action('wp_ajax_nopriv_get_blox_element_carousel', 'get_blox_element_carousel_hook');

function get_blox_element_carousel_hook() {
    try {

        echo '<p>
                <label>Item Title</label><br>
                <input type="text" id="blox_el_option_title" value="' . (isset($_POST['title']) ? $_POST['title'] : '') . '" />
              </p>';

        echo '<label>Post type:</label>';
        echo '<select id="blox_option_post_type" class="select_data_val" data_val="' . (isset($_POST['post_type']) && $_POST['post_type'] != '' ? $_POST['post_type'] : 'post') . '" data_cat="' . (isset($_POST['category']) && $_POST['category'] != '' ? $_POST['category'] : '0') . '">';
        $post_arr = array();
        $post_arr['post'] = get_post_type_object('post');
        $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects', 'and');
        $post_types = array_merge($post_arr, $post_types);
        foreach ($post_types as $type) {
            echo '<option value="' . $type->name . '">' . __($type->labels->name, 'themeton') . '</option>';
        }
        echo '</select>';


        echo '<label>Category:</label>';
        foreach ($post_types as $type) {
            $ptype = $type->name;
            echo '<select id="blox_option_taxonomy_' . $ptype . '" class="blox_option_taxonomies">';
            echo '<option value="0">All</option>';
            $taxonomies = get_object_taxonomies($ptype);
            if (count($taxonomies) > 0) {
                $terms = get_terms($taxonomies[0]);
                foreach ($terms as $term) {
                    echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                }
            }
            echo '</select>';
        }

        echo '<p>';
        echo '<label>Posts count:</label>';
        echo '<input type="number" step="1" min="1" id="blox_option_posts_count" value="' . (isset($_POST['count']) && $_POST['count'] != '' ? $_POST['count'] : '6') . '" class="small-text">';
        echo '</p>';

        echo '<p style="display:none;">';
        echo '<label>Carousel Item Overlay:</label>';
        echo '<select id="blox_option_carousel_overlay" class="select_data_val" data_val="' . (isset($_POST['overlay']) && $_POST['overlay'] != '' ? $_POST['overlay'] : 'permalink') . '">
                    <option value="permalink">Permalink</option>
                    <option value="lightbox">Lightbox</option>
                    <option value="both">Permalink & Lightbox</option>
                </select>';
        echo '</p>';


    } catch (Exception $e) {
        echo "-1";
    }
    exit;
}

function blox_parse_carousel_hook($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'post_type' => 'post',
                'category' => '0',
                'count' => '6',
                'style' => '',
                'overlay' => 'permalink',
                'animation' => '',
                'extra_class' => ''
                    ), $atts));

    global $post, $product, $woocommerce, $woocommerce_loop;
    global $the_query;
    $temp_post = $post;
    $temp_query = $the_query;

    $animate_class = get_blox_animate_class($animation);

    $args = array(
        'post_type' => $post_type,
        'numberposts' => (int) $count,
        'ignore_sticky_posts' => 1
    );

    if ($category != '' && $category != '0') {
        $taxonomies = get_object_taxonomies($post_type);
        $args['tax_query'] = array(array('taxonomy' => $taxonomies[0], 'terms' => $category));
    }
    $i = 0;
    $html = '';



    $the_query = new WP_Query($args);
    while ($the_query->have_posts()):
        $the_query->the_post();
        
        if( $post_type == 'product' ){
            $product = get_product(get_the_Id()); 

            $extra_class .= ' woocommerce woocommerce-page';

            // get product price
            ob_start();
            woocommerce_template_loop_add_to_cart();
            $output = ob_get_clean();
            if(!empty($output))
            {
                $pos = strpos($output, ">");
                
                if ($pos !== false) {
                    $output = substr_replace($output,"><span class='icon-plus'></span> ", $pos , strlen(1));
                }
            }
            
            ob_start();
            do_action( 'woocommerce_before_shop_loop_item_title' );
            $title_before = ob_get_clean();

            ob_start();
            do_action( 'woocommerce_after_shop_loop_item_title' );
            $title_after = ob_get_clean();

            $html .= '<div class="carousel_item">
                        <div itemscope="" itemtype="http://data-vocabulary.org/Product" class="entry_product">
                            '.$title_before.'
                            <h3>
                                <a itemprop="name" href="'.get_permalink().'">'.get_the_title().'</a>
                            </h3>
                            '.$title_after.'
                            <footer class="cart_buttons ">
                                '.$product->get_price_html().'
                                '.$output.'
                                <span class="button-mini-delimiter"></span>
                            </footer>
                        </div>
                      </div>';
        }
        else{
            $thumb = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            $image = $thumb != '' ? blox_aq_resize($thumb, 230, 230, true) : '';
            $i++;

            $html .= '<div class="carousel_item">
                        <article itemscope itemtype="http://schema.org/BlogPosting" class="entry clearfix">
                                ' . hover_featured_image(get_the_ID(), 'both', true, 235, 160) . '
                                <div class="entry_title">
                                <h2 itemprop="headline"><a itemprop="url" href="' . get_permalink() . '">' . get_the_title() . '</a></h2>
                            </div>
                            <div class="entry_meta">
                                <span class="meta_author">' . __("BY ", "themeton") . get_author_posts_link() . '</span>
                                <span itemprop="keywords" class="entry_category">' . __("IN ", "themeton") . get_the_category_list(', ') . '</span>
                            </div>
                            <footer class="clearfix">
                                <span itemprop="dateCreated" class="meta_date pull-left">' . date_i18n("M j, Y", strtotime(get_the_date())) . '</span>
                                <span class="meta_like pull-right"><a href="javascript:;" pid="' . get_the_ID() . '" class="' . blox_post_liked(get_the_ID()) . '"><i class="icon-heart"></i> <span>' . (int) blox_getmeta(get_the_ID(), 'post_like') . '</span></a></span>
                                <span itemprop="comment" class="meta_comment pull-right">' . comment_count_grid() . '</span>
                            </footer>
                        </article>
                    </div>';
        }
    endwhile;

    $the_query = $temp_query;
    $post = $temp_post;
    

    return "<div class='blox_element blox_elem_carousel $animate_class $extra_class'>
                <div class='blox_carousel_wrapper grid_entry' data-cycle-fx='carousel' data-cycle-timeout='0' data-cycle-slides='> div'>
                        " . $html . "
                </div>
                <a href='#' class='blox_carousel_action action_prev'><span class='icon-chevron-left'></span></a>
                <a href='#' class='blox_carousel_action action_next'><span class='icon-chevron-right'></span></a>
            </div>";
}

add_shortcode('blox_carousel', 'blox_parse_carousel_hook');
?>