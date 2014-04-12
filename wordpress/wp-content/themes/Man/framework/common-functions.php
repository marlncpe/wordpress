<?php
/**
 * You can extend it with new icons. 
 * Please see the icon list from here, http://fortawesome.github.io/Font-Awesome/cheatsheet/
 * And extend following array with name and hex code.
 */
global $tt_social_icons;
$tt_social_icons = array(
    'facebook' => '&#xf09a;',
    'twitter' => '&#xf099;',
    'googleplus' => '&#xf0d5;',
    'email' => '&#xf003;',
    'pinterest' => '&#xf0d2;',
    'linkedin' => '&#xf0e1;',
    'youtube' => '&#xf167;',
    'dribbble' => '&#xf17d;',
    'instagram' => '&#xf16d;',
    'flickr' => '&#xf16e;',
    'skype' => '&#xf17e;'
);


add_action('admin_enqueue_scripts', 'admin_common_render_scripts');

function admin_common_render_scripts() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('themeton-admin-common-style', get_template_directory_uri() . '/framework/css/common.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('themeton-admin-common-js', get_template_directory_uri() . '/framework/js/common.js', false, false, true);
}

/**
 * The function returns brightness value from 0 to 255
 */
function get_brightness($hex) {
    $hex = str_replace('#', '', $hex);

    if (strlen($hex) < 6) {
        $hex = substr($hex, 0, 1) . substr($hex, 0, 1) .
                substr($hex, 1, 2) . substr($hex, 1, 2) .
                substr($hex, 2, 3) . substr($hex, 2, 3);
    }

    $c_r = hexdec(substr($hex, 0, 2));
    $c_g = hexdec(substr($hex, 2, 2));
    $c_b = hexdec(substr($hex, 4, 2));

    return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}

/**
 * The function returns brightness class of the color
 */
function get_text_class($color) {
    if( $color=='' || $color=='transparent' || $color=='#fff' || $color=='#ffffff' ){
        return '';
    }
    $brightness = get_brightness($color);
    return $brightness < 200 ? 'light' : 'dark';
}

function is_bg_dark($bgcolor = '#ffffff') {
    return get_text_class($bgcolor);
}

function text_brightness_indicator($prefix = 'title') {
    global $smof_data;
    $bgcolor = (isset($smof_data[$prefix . '_bg_color']) && $smof_data[$prefix . '_bg_color'] != '') ? $smof_data[$prefix . '_bg_color'] : '';
    $bgcolor = $bgcolor != '' ? $bgcolor : '#b81b6c';

    echo get_text_class($bgcolor);
}

function themeton_admin_post_type() {
    global $pagenow, $typenow;
    global $settings_url, $modules;

    if (empty($typenow) && !empty($_GET['post'])) {
        $post = get_post($_GET['post']);
        $typenow = $post->post_type;
    }
    if (is_admin() && ($pagenow == 'post-new.php' OR $pagenow == 'post.php')) {
        return $typenow;
    }
    return '-1';
}

function tt_getmeta($meta, $post_id = NULL) {
    global $post;
    if ($post_id != NULL && (int) $post_id > 0) {
        return get_post_meta($post_id, '_' . $meta, true);
    } else if (isset($post->ID)) {
        return get_post_meta($post->ID, '_' . $meta, true);
    }
    return '';
}

function tt_site_logo() {
    global $smof_data;
    $hide = '';
    echo '<div id="logo">';
    if ($smof_data['logo'] != '') {
        echo "<a href=" . site_url() . "><img src='" . $smof_data['logo'] . "' alt='" . get_bloginfo('name') . "'/></a>";
        $hide = "style='display:none'";
    }
    echo "<h1 $hide><a href=" . site_url() . ">" . get_bloginfo('name') . "</a></h1>";
    echo '</div>';
}

/*
 * Favicon and Touch Icons
 */

function tt_icons() {
    global $smof_data;

    /*
     * Favicon
     */
    $url = get_template_directory_uri() . "/images/favicon.png";
    if ( isset($smof_data['icon_favicon']) && $smof_data['icon_favicon'])
        $url = $smof_data['icon_favicon'];
    echo "<link rel='shortcut icon' href='$url'/>";

    /*
     * Apple Devices Touch Icons
     */
    if (isset($smof_data['icon_iphone']) && $smof_data['icon_iphone'])
        echo '<link rel="apple-touch-icon" href="' . $smof_data['icon_iphone'] . '">';
    if (isset($smof_data['icon_iphone_retina']) && $smof_data['icon_iphone_retina'])
        echo '<link rel="apple-touch-icon" sizes="114x114" href="' . $smof_data['icon_iphone_retina'] . '">';
    if (isset($smof_data['icon_ipad']) && $smof_data['icon_ipad'])
        echo '<link rel="apple-touch-icon" sizes="72x72" href="' . $smof_data['icon_ipad'] . '">';
    if (isset($smof_data['icon_ipad_retina']) && $smof_data['icon_ipad_retina'])
        echo '<link rel="apple-touch-icon" sizes="144x144" href="' . $smof_data['icon_ipad_retina'] . '">';
}

/*
 * Site Tracking Code
 */

function tt_trackingcode() {
    global $smof_data;
    if ($smof_data['site_analytics']) {
        echo $smof_data['site_analytics'];
    }
}

function add_video_radio($embed) {
    if (strstr($embed, 'http://www.youtube.com/embed/')) {
        return str_replace('?fs=1', '?fs=1&rel=0', $embed);
    } else {
        return $embed;
    }
}

add_filter('oembed_result', 'add_video_radio', 1, true);

if (!function_exists('custom_upload_mimes')) {
    add_filter('upload_mimes', 'custom_upload_mimes');

    function custom_upload_mimes($existing_mimes = array()) {
        $existing_mimes['ico'] = "image/x-icon";
        return $existing_mimes;
    }

}

function tt_breadcrumbs() {

    global $smof_data;
    if (isset($smof_data['use_breadcrumb']) && $smof_data['use_breadcrumb'] == 0) {
        return;
    }
    
    /* === OPTIONS === */
    $text['location'] = __('', 'themeton'); // text for the 'Home' link
    $text['home'] = __('Home', 'themeton'); // text for the 'Home' link
    $text['category'] = __('Archive by Category "%s"', 'themeton'); // text for a category page
    $text['search'] = __('Search Results for "%s" query', 'themeton'); // text for a search results page
    $text['tag'] = __('Posts Tagged "%s"', 'themeton'); // text for a tag page
    $text['author'] = __('Articles Posted by %s', 'themeton'); // text for an author page
    $text['404'] = __('Error 404', 'themeton'); // text for the 404 page

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter = ''; // delimiter between crumbs
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;
    $homeLink = site_url() . '/';
    $linkBefore = '<span>';
    $linkAfter = '</span>';
    $linkAttr = '';
    $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;


    echo '<div id="crumbs" class="tt_breadcrumb">' . $text['location'];

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1)
            echo '<span><a href="' . $homeLink . '">' . $text['home'] . '</a></span>';
    } else {

        echo sprintf($link, $homeLink, $text['home']) . $delimiter;

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
        } elseif (is_search()) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;
        } elseif (is_day()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $term = array('name'=>'');
                $term_link = '';
                $term = array('orderby' => 'none');
                if(get_post_type() == 'portfolio') {
                    $term = wp_get_post_terms($post->ID, 'portfolio_entries');
                    $term_link = get_term_link($term[0], 'portfolio_entries');
                }   
                if( isset($term[0]->name) ){
                	printf($link, $term_link, $term[0]->name);
                }
                if ($showCurrent == 1)
                    echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                if (!empty($cat)) {
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0)
                        $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo $cats;
                    if ($showCurrent == 1)
                        echo $before . get_the_title() . $after;
                }
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $term = array('name'=>'');
            $term_link = '';
            $term = array('orderby' => 'none');
            if(get_post_type() == 'portfolio') {
                $term = wp_get_post_terms($post->ID, 'portfolio_entries');
                $term_link = get_term_link($term[0], 'portfolio_entries');
            }
            if( isset($term[0]->name) ){
                printf($link, $term_link, $term[0]->name);
            }
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1)
                echo $delimiter . $before . get_the_title() . $after;
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1)
                echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1)
                    echo $delimiter;
            }
            if ($showCurrent == 1)
                echo $delimiter . $before . get_the_title() . $after;
        } elseif (is_tag()) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;
        } elseif (is_404()) {
            echo $before . $text['404'] . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo __('Page', 'themeton') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }
    }
    echo '</div>';
}

// end breadcrumbs()

/**
 * Comment Count Number
 * @return html 
 */
function comment_count() {
    global $smof_data;
    if (isset($smof_data['facebook_comment']) && $smof_data['facebook_comment'] == 1) {
        return '<fb:comments-count data-href="' . get_permalink() . '"></fb:comments-count>';
    } else {
        $comment_count = get_comments_number('0', '1', '%');
        if ($comment_count == 0) {
            $comment_trans = __('No comment', 'themeton');
        } elseif ($comment_count == 1) {
            $comment_trans = __('One comment', 'themeton');
        } else {
            $comment_trans = $comment_count . ' ' . __('comments', 'themeton');
        }
        return "<a href='" . get_comments_link() . "' title='" . $comment_trans . "' class='comment-count'>" . $comment_trans . "</a>";
    }
}

/**
 * Comment Count Number for Grid Layout
 * @return html
 */
function comment_count_grid() {
    global $smof_data;
    if (isset($smof_data['facebook_comment']) && $smof_data['facebook_comment'] == 1) {
        return '<fb:comments-count data-href="' . get_permalink() . '"></fb:comments-count>';
    } else {
        $comment_count = get_comments_number('0', '1', '%');
        if ($comment_count == 0) {
            $comment_trans = __('No comment', 'themeton');
        } elseif ($comment_count == 1) {
            $comment_trans = __('One comment', 'themeton');
        } else {
            $comment_trans = $comment_count . ' ' . __('comments', 'themeton');
        }
        return "<a href='" . get_comments_link() . "' title='" . $comment_trans . "' class='comment-count'><i class='icon-comments'></i> " . $comment_count . "</a>";
    }
}

/**
 * Returns Author link
 * @return html
 */
function get_author_posts_link() {
    $output = '';
    ob_start();
    the_author_posts_link();
    $output .= ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * Pagination for Blog Layouts
 * Uses paginate_links of WP core
 */
function tt_pagination() {
    global $wp_query;

    $prevclass = $nextclass = "disabled";
    $prevlink = $nextlink = "";
    $pages = $wp_query->max_num_pages;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if (is_front_page()) {
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    }

    if (empty($pages)) {
        $pages = 1;
    }

    if (1 != $pages) {
        if ($paged > 1) {
            $prevlink = get_pagenum_link($paged - 1);
            $prevclass = "active";
        }
        if ($paged < $pages) {
            $nextlink = get_pagenum_link($paged + 1);
            $nextclass = "active";
        }

        $big = 9999; // need an unlikely integer
        echo "<div class='tt-pager-pagination'>";
        echo "<div class='tt-pagination clearfix'>";

        echo paginate_links(
                array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'end_size' => 3,
                    'mid_size' => 6,
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $wp_query->max_num_pages,
                    'type' => 'list',
                    'prev_text' => __('&laquo;', 'themeton'),
                    'next_text' => __('&raquo;', 'themeton'),
        ));
        echo "</div>";
        echo "</div>";
    }
}

if (!function_exists('format_class')) {

    // Returns post format class by string
    function format_class($post_id) {
        $format = get_post_format($post_id);
        if ($format === false)
            $format = 'standard';

        return 'format_' . $format;
    }

}


/**
 * This code filters the Categories archive widget to include the post count inside the link
 */
add_filter('wp_list_categories', 'cat_count_span');

function cat_count_span($links) {
    $links = str_replace('</a> (', ' <span>', $links);
    $links = str_replace('<span class="count">(', '<span>', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}

/**
 * This code filters the Archive widget to include the post count inside the link
 */
add_filter('get_archives_link', 'archive_count_span');

function archive_count_span($links) {
    $links = str_replace('</a>&nbsp;(', ' <span>', $links);
    $links = str_replace(')</li>', '</span></a></li>', $links);
    return $links;
}

/**
 * Prints social links on top bar & sub footer area
 * @global array $tt_social_icons
 * @param type $footer : Sign of footer layout
 */
function social_links_by_icon($footer = false) {
    global $tt_social_icons, $smof_data;
    $sign = false;
    $pref = 'social_';
    if ($footer)
        $pref = 'footer_' . $pref;
    $result = '<ul class="social_icon">';
    foreach ($tt_social_icons as $key => $hex) {
        if (isset($smof_data[$pref . $key]) && $smof_data[$pref . $key] != '') {
            $url = $smof_data[$pref . $key];
            if ($key != 'email') {
                if (strpos($url, 'http:') === false)
                    $url = "http://" . $url;
            } else {
                $url = 'mailto:' . $url . '?subject=' . get_bloginfo('name') . '&amp;body='.__('Your%20message%20here!', 'themeton');
            }
            $result .= '<li><a class="' . $key . '" href="' . $url . '" data-attr="' . $hex . '" target="_blank">' . $hex . '</a></li>';
            $sign = true;
        }
    }
    $result .= '</ul>';
    echo $sign ? $result : __('Please add your social profiles on Theme Options => Social Options tab.', 'themeton');
}

/**
 * Prints Top Bar content
 * @param type $type : Menu type
 * @param type $position : Right or Left
 */
function top_bar_content($type = 'menu', $position = 'left') {
    global $smof_data;

    if( function_exists('is_shop') && is_shop() && $position == 'right' ){
        $type = 'cart';
    }
    
    if ($type == 'social') {
        social_links_by_icon();
    }
    elseif ($type == 'cart') {
        themeton_get_shopping_cart();
    }
    elseif ($type == 'language') {
        global $wp_filter;
        if( isset($wp_filter['icl_language_selector']) ){
            //do_action('icl_language_selector');
            themeton_language_selector();
        }
        else{
            _e('WPML plugin not installed, Please try again', 'themeton');
        }
        
    }
    elseif ($type == 'menu') {
        wp_nav_menu(array('theme_location' => 'topbar-menu', 'fallback_cb' => '', 'depth'=>1));
    }
    elseif ($type == 'text') {
        if (isset($smof_data['top_bar_text_' . $position])) {
            echo do_shortcode($smof_data['top_bar_text_' . $position]);
        }
    }
}



function themeton_get_shopping_cart(){
    global $woocommerce;
    if (isset($woocommerce->cart)) {
        $cart = $woocommerce->cart;
        echo '<div class="woocommerce_cart">';
        echo '<i class="icon-shopping-cart"></i> ' . $cart->get_cart_total() . ' / ' . $cart->cart_contents_count . ' ' . ((int)$cart->get_cart_total()>1 ? __('items', 'themeton') : __('item', 'themeton'));
        echo '<div class="woocommerce_cart_wrapper">';
        echo '<div class="woocommerce_cart_items">';
        echo '<div class="cart_item_title">' . $cart->cart_contents_count . ' '.__('item in the shopping bag', 'themeton').'</div>';
        echo '<ul>';
        foreach ($cart->cart_contents as $item) {
            $product = get_product($item['product_id']);
            $price = $product->get_price_html();
            $product_img = '';

            if( function_exists('ttwc_gallery_first_thumbnail') ){
                $product_img = ttwc_gallery_first_thumbnail($item['product_id'], 'full');
            }
            else{
                $product_gallery = get_post_meta( $item['product_id'], '_product_image_gallery', true );
                if(!empty($product_gallery))
                {
                    $gallery    = explode(',',$product_gallery);
                    $image_id   = $gallery[0];
                    $image      = wp_get_attachment_url($image_id);
                    
                    if(!empty($image)){
                        $product_img = $image;
                    }
                }
            }

            if( $product_img=='' ){
                $attach_src = wp_get_attachment_image_src(get_post_thumbnail_id($item['product_id']), 'thumbnail');
                if (@getimagesize($attach_src[0])) {
                    $product_img = $attach_src[0];
                }
            }

            echo '<li>
                            <span class="img" style="background-image:url(' . $product_img . ');"></span>
                            <h4>' . $item['data']->post->post_title . ' ' . $price . '</h4>
                            <span class="quantity">' . __('Quantity', 'themeton') . ': ' . $item['quantity'] . '</span>
                            <div class="clearfix"></div>
                          </li>';
        }
        echo '</ul>';
        echo '<div class="cart_item_bottom">
                        <span><a href="'.$woocommerce->cart->get_cart_url().'">' . __('Shopping Bag', 'themeton') . '</a></span>
                        <span><a href="'.$woocommerce->cart->get_checkout_url().'">' . __('Checkout', 'themeton') . '</a></span>
                        <div class="clearfix"></div>
                      </div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div id="woo_added_cart_msg">
                <span class="icon_wrapper"><i class="icon-shopping-cart"></i></span>
                <span class="msg"><span class="item_name"></span> '.__('was added to the cart').'</span>
              </div>';
    }
    else{
        _e('Woocommerce plugin not installed', 'themeton');
    }
}
add_action('wp_ajax_tt_get_shopping_cart', 'get_shopping_cart_hook');
add_action('wp_ajax_nopriv_tt_get_shopping_cart', 'get_shopping_cart_hook');
function get_shopping_cart_hook(){
    themeton_get_shopping_cart();
    exit;
}


function themeton_language_selector(){
    echo '<div class="language_selector">';
    _e('Languages: ', 'themeton');
    global $post, $wp_query;
    $tmp_post = $post;
    $tmp_query = $wp_query;
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    $post = $tmp_post;
    $wp_query = $tmp_query;
    if(!empty($languages)){
        foreach($languages as $l){
            if(!$l['active']){ echo '<a href="'.$l['url'].'">'; }
            echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
            if(!$l['active']){ echo '</a>'; }
        }
    }
    echo '</div>';
}

/**
 * Prints Sub Footer Area Content
 * @param type $type : Menu type
 * @param type $position : Right or Left
 */
function sub_footer_content($type = 'menu', $position = 'left') {
    global $smof_data;
    if ($type == 'social') {
        social_links_by_icon(true);
    } elseif ($type == 'cart') {
        echo "Cart";
    } elseif ($type == 'language') {
        global $wp_filter;
        if( isset($wp_filter['icl_language_selector']) ){
            themeton_language_selector();
        }
        else{
            _e('WPML plugin not installed, Please try again', 'themeton');
        }
    } elseif ($type == 'menu') {
        wp_nav_menu(array('theme_location' => 'footer-menu', 'fallback_cb' => '', 'depth'=>1));
    } elseif ($type == 'text') {
        echo do_shortcode($smof_data['footer_text_' . $position]);
    } elseif ($type == 'gotop') {
        if ($position == 'left')
            echo '<span class="gototop"><i class="icon-arrow-up"></i> ' . $smof_data['footer_text_gotop'] . '</span>';
        else
            echo '<span class="gototop">' . $smof_data['footer_text_gotop'] . ' <i class="icon-arrow-up"></i></span>';
    }
}

if (!function_exists('tt_comment_form')) :

    function tt_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();

        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'themeton') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input placeholder="' . __('Name', 'themeton') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
            'email' => '<p class="comment-form-email"><label for="email">' . __('Email', 'themeton') . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
            '<input placeholder="' . __('Email', 'themeton') . '" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
            'url' => '<p class="comment-form-url"><label for="url">' . __('Website', 'themeton') . '</label>' .
            '<input placeholder="' . __('Website', 'themeton') . '" id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
        );
        return $fields;
    }

    add_filter('comment_form_default_fields', 'tt_comment_form');

endif;

if (!function_exists('about_author')) {

    function about_author() {
        ?>
        <div class="item-author clearfix">
            <?php
            $author_email = get_the_author_meta('email');
            echo get_avatar($author_email, $size = '60');
            ?>
            <h3><?php _e("Written by ", "themeton"); ?><?php if (is_author()) the_author(); else the_author_posts_link(); ?></h3>
            <div class="author-title-line"></div>
            <p>
                <?php
                $description = get_the_author_meta('description');
                if ($description != '')
                    echo $description;
                else
                    _e('The author didnt add any Information to his profile yet', 'themeton');
                ?>
            </p>
        </div>
        <?php
    }

}

if (!function_exists('social_share')) {

    /**
     * Prints Social Share Options
     * @global array $tt_social_icons
     * @global type $post : Current post
     */
    function social_share() {
        global $smof_data, $tt_social_icons;
        $share = false;

        if (isset($smof_data['share_buttons']))
            $share = true;

        if ($share) {
            global $post;
            echo '<span class="sf_text">' . __('Share', 'themeton') . ': </span>';
            echo '<ul class="post_share">';
            if (isset($smof_data['share_buttons']['facebook']) && $smof_data['share_buttons']['facebook'] == 1) {
                echo '<li><a href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" title="Facebook" target="_blank">' . $tt_social_icons['facebook'] . '</a></li>';
            }
            if (isset($smof_data['share_buttons']['twitter']) && $smof_data['share_buttons']['twitter'] == 1) {
                echo '<li><a href="https://twitter.com/share?url=' . get_permalink() . '" title="Twitter" target="_blank">' . $tt_social_icons['twitter'] . '</a></li>';
            }
            if (isset($smof_data['share_buttons']['googleplus']) && $smof_data['share_buttons']['googleplus'] == 1) {
                echo '<li><a href="https://plus.google.com/share?url='.get_permalink().'" title="GooglePlus" target="_blank">' . $tt_social_icons['googleplus'] . '</a></li>';
            }
            if (isset($smof_data['share_buttons']['pinterest']) && $smof_data['share_buttons']['pinterest'] == 1) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
                echo '<li><a href="//pinterest.com/pin/create/button/?url=' . get_permalink() . '&media=' . $image[0] . '&description=' . get_the_title() . '" title="Pinterest" target="_blank">' . $tt_social_icons['pinterest'] . '</a></li>';
            }
            if (isset($smof_data['share_buttons']['email']) && $smof_data['share_buttons']['email'] == 1) {
                echo '<li><a href="mailto:?subject=' . get_the_title() . '&body=' . strip_tags(get_the_excerpt()) . get_permalink() . '" title="Email" target="_blank">' . $tt_social_icons['email'] . '</a></li>';
            }
            echo '</ul>';
        }
    }

}

/**
 * Prints Related Posts
 * @global type $post : Current post
 */
function tt_related_posts() {

    global $post;
    $categories = get_the_category($post->ID);
    if ($categories) {
        $category_ids = array();
        foreach ($categories as $individual_category) {
            $category_ids[] = $individual_category->term_id;
        }
        $args = array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => 4
        );
        $my_query = new wp_query($args);
        if ($my_query->have_posts()) {
            echo '<div class="related_posts grid_entry">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3>' . __('Related Posts', 'themeton') . '</h3>
                        </div>';
            while ($my_query->have_posts()) {
                $my_query->the_post();
                ?>
                <div class="col-xs-12 col-xxs-6 col-sm-6 col-md-3 col-lg-3">
                    <article itemscope="" itemtype="http://schema.org/BlogPosting" class="entry">
                        <?php echo hover_featured_image($post->ID, 'permalink', 174, 130); ?>
                        <div class="entry_title">
                            <h2 itemprop="headline"><a itemprop="url" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                    </article>
                </div>
                <?php
            }
            echo '  </div><!-- end row -->
                  </div><!-- end related_posts -->';
        }
    }
    wp_reset_query();
}

// ADDING ADMIN BAR MENU
if (!function_exists('tt_admin_bar_menu')) {
    add_action('admin_bar_menu', 'tt_admin_bar_menu', 90);

    function tt_admin_bar_menu() {

        if (!current_user_can('manage_options'))
            return;

        global $wp_admin_bar;

        $admin_url = admin_url('admin.php');

        $item = array(
            'id' => 'theme-options',
            'title' => __('Theme Options', 'themeton'),
            'href' => $admin_url . "?page=theme-options",
        );

        $wp_admin_bar->add_menu($item);
    }

}


/*
 * Returns element style if page sets custom bg color.
 * Or returns empty if page don't have a specific color title area.
 */

function tt_page_title_bg_color() {
    global $smof_data;
    $title_bgcolor = tt_getmeta('title_bgcolor');
    $titlebg = ($title_bgcolor != '' && $title_bgcolor != $smof_data['title_bg_color']) ? "background-color: $title_bgcolor;" : '';
    return $titlebg;
}

/*
 * Returns element style if page sets custom bg color.
 * Or returns empty if page don't have a specific color on content area.
 */

function tt_page_content_bg_color() {
    global $smof_data;
    $pcolor = tt_getmeta('general_color');
    $contentbg = ($pcolor != '' && $pcolor != $smof_data['content_bg_color']) ? "background-color: $pcolor;" : '';
    return $contentbg;
}

/*
 * Returns element style if page sets custom bg image.
 * Or returns empty if page don't have a specific image.
 */

function tt_page_title_bg_image($titlebg = '') {
    $page_bg_style = '';
    $bg_image = tt_getmeta('title_bg_image');
    
    $padding = 'padding: '.tt_getmeta('title_space').'px 0;';
    
    if ($bg_image != '') {
        $page_bg_style = 'background-image:url(' . $bg_image . ');';
        
        $page_bg_style .= $padding;

        $bg_image_cover = tt_getmeta('title_bg_cover');
        $page_bg_style .= $bg_image_cover == '1' ? 'background-size:cover;' : '';

        $bg_image_repeat = tt_getmeta('title_bg_repeat');
        $page_bg_style .= $bg_image_repeat != '' ? 'background-repeat:' . $bg_image_repeat . ';' : '';

        $bg_image_position = tt_getmeta('title_bg_position');
        $page_bg_style .= $bg_image_position != '' ? 'background-position:' . $bg_image_position . ';' : '';

        $bg_scroll = tt_getmeta('title_bg_fixed');
        $page_bg_style .= $bg_scroll != '' ? 'background-attachment:' . $bg_scroll . ';' : '';

        $page_bg_style = ($titlebg . $page_bg_style) != '' ? 'style="' . $titlebg . $page_bg_style . ';"' : '';

        $page_bg_style .= ($bg_scroll == 'parallax' && $page_bg_style != '') ? ' data-bottom-top="background-position:50% 100%" data-top-bottom="background-position:50% 0%;"' : '';
    } else {
        $page_bg_style = 'style="' . $titlebg .$padding. ';"';
    }
    return $page_bg_style;
}

/*
 * Returns element style if page sets custom bg image.
 * Or returns empty if page don't have a specific image.
 */

function tt_page_content_bg_image($contentbg = '') {
    $page_bg_style = '';
    $bg_image = tt_getmeta('bg_image');
    if ($bg_image != '') {
        $page_bg_style = 'background-image:url(' . $bg_image . ');';

        $bg_image_cover = tt_getmeta('bg_cover');
        $page_bg_style .= $bg_image_cover == '1' ? 'background-size:cover;' : '';

        $bg_image_repeat = tt_getmeta('bg_repeat');
        $page_bg_style .= $bg_image_repeat != '' ? 'background-repeat:' . $bg_image_repeat . ';' : '';

        $bg_image_position = tt_getmeta('bg_position');
        $page_bg_style .= $bg_image_position != '' ? 'background-position:' . $bg_image_position . ';' : '';

        $bg_scroll = tt_getmeta('bg_fixed');
        $page_bg_style .= $bg_scroll != '' ? 'background-attachment:' . $bg_scroll . ';' : '';

        $page_bg_style = ($contentbg . $page_bg_style) != '' ? 'style="' . $contentbg . $page_bg_style . ';"' : '';

        $page_bg_style .= ($bg_scroll == 'parallax' && $page_bg_style != '') ? ' data-bottom-top="background-position:50% 0%" data-top-bottom="background-position:50% 100%;"' : '';
    } else {
        $page_bg_style = $contentbg != '' ? 'style="' . $contentbg . '"' : '';
    }
    return $page_bg_style;
}





/**
 * Prints Custom Logo Image for Login Page
 */
function custom_login_logo() {
    global $smof_data;
    if ($smof_data['logo_admin'] != '') {
        echo '<style type="text/css">h1 a { background: url(' . $smof_data['logo_admin'] . ') center center no-repeat !important;}</style>';
    }
}

add_action('login_head', 'custom_login_logo');


/**
 * Aqua Resizer function
 * Version : 1.1.7
 */
function aq_resize($url, $width = null, $height = null, $crop = null, $single = true, $upscale = false) {

    // Validate inputs.
    if (!$url || (!$width && !$height ))
        return $url;

    // Caipt'n, ready to hook.
    if (true === $upscale)
        add_filter('image_resize_dimensions', 'aq_upscale', 10, 6);

    // Define upload path & dir.
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];

    $http_prefix = "http://";
    $https_prefix = "https://";

    /* if the $url scheme differs from $upload_url scheme, make them match 
      if the schemes differe, images don't show up. */
    if (!strncmp($url, $https_prefix, strlen($https_prefix))) { //if url begins with https:// make $upload_url begin with https:// as well
        $upload_url = str_replace($http_prefix, $https_prefix, $upload_url);
    } elseif (!strncmp($url, $http_prefix, strlen($http_prefix))) { //if url begins with http:// make $upload_url begin with http:// as well
        $upload_url = str_replace($https_prefix, $http_prefix, $upload_url);
    }


    // Check if $img_url is local.
    if (false === strpos($url, $upload_url))
        return $url;

    // Define path of image.
    $rel_path = str_replace($upload_url, '', $url);
    $img_path = $upload_dir . $rel_path;

    // Check if img path exists, and is an image indeed.
    if (!file_exists($img_path) or !getimagesize($img_path))
        return $url;

    // Get image info.
    $info = pathinfo($img_path);
    $ext = $info['extension'];
    list( $orig_w, $orig_h ) = getimagesize($img_path);

    // Get image size after cropping.
    $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
    $dst_w = $dims[4];
    $dst_h = $dims[5];

    // Return the original image only if it exactly fits the needed measures.
    if (!$dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) )) {
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
    } else {
        // Use this to check if cropped image already exists, so we can return that instead.
        $suffix = "{$dst_w}x{$dst_h}";
        $dst_rel_path = str_replace('.' . $ext, '', $rel_path);
        $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

        if (!$dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) )) {
            // Can't resize, so return false saying that the action to do could not be processed as planned.
            return $url;
        }
        // Else check if cache exists.
        elseif (file_exists($destfilename) && getimagesize($destfilename)) {
            $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        }
        // Else, we resize the image and return the new resized image url.
        else {

            // Note: This pre-3.5 fallback check will edited out in subsequent version.
            if (function_exists('wp_get_image_editor')) {

                $editor = wp_get_image_editor($img_path);

                if (is_wp_error($editor) || is_wp_error($editor->resize($width, $height, $crop)))
                    return $url;

                $resized_file = $editor->save();

                if (!is_wp_error($resized_file)) {
                    $resized_rel_path = str_replace($upload_dir, '', $resized_file['path']);
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return $url;
                }
            } else {

                $resized_img_path = image_resize($img_path, $width, $height, $crop); // Fallback foo.
                if (!is_wp_error($resized_img_path)) {
                    $resized_rel_path = str_replace($upload_dir, '', $resized_img_path);
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return $url;
                }
            }
        }
    }

    // Okay, leave the ship.
    if (true === $upscale)
        remove_filter('image_resize_dimensions', 'aq_upscale');

    // Return the output.
    if ($single) {
        // str return.
        $image = $img_url;
    } else {
        // array return.
        $image = array(
            0 => $img_url,
            1 => $dst_w,
            2 => $dst_h
        );
    }

    return $image;
}

function aq_upscale($default, $orig_w, $orig_h, $dest_w, $dest_h, $crop) {
    if (!$crop)
        return null; // Let the wordpress default function handle this.
        
    // Here is the point we allow to use larger image size than the original one.
    $aspect_ratio = $orig_w / $orig_h;
    $new_w = $dest_w;
    $new_h = $dest_h;

    if (!$new_w) {
        $new_w = intval($new_h * $aspect_ratio);
    }

    if (!$new_h) {
        $new_h = intval($new_w / $aspect_ratio);
    }

    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor(( $orig_w - $crop_w ) / 2);
    $s_y = floor(( $orig_h - $crop_h ) / 2);

    return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
}



function themeton_content_truncate($string, $limit, $break=".", $pad="…", $stripClean = false) {
    if($stripClean){
        $string = strip_shortcodes(strip_tags($string, '<strong><em><span>'));
    }

    if(strlen($string) <= $limit) return $string;
    
    if(false !== ($breakpoint = strpos($string, $break, $limit))) { 
        if($breakpoint < strlen($string) - 1) { 
            $string = substr($string, 0, $breakpoint) . $pad; 
        } 
    } 
    
    if(!$breakpoint){
        $string = substr($string, 0, $limit) . $pad; 
    }
    
    return $string; 
}


/**
 *  Theme frontend ajax search
 */
add_action('wp_ajax_themeton_fajax_search', 'themeton_fajax_search_hook');
add_action('wp_ajax_nopriv_themeton_fajax_search', 'themeton_fajax_search_hook');
function themeton_fajax_search_hook(){
    unset($_REQUEST['action']);
    if(empty($_REQUEST['s'])) die();

    $defaults = array('numberposts' => 5, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false);
    $_REQUEST['s'] = apply_filters( 'get_search_query', $_REQUEST['s']);

    $query = array_merge($defaults, $_REQUEST);
    $query = http_build_query($query);
    $posts = get_posts( $query );

    if(empty($posts)){
        $output  = "<span class='ajax_search_entry ajax_not_found'>";
        $output .= "<span class='ajax_search_image'><i class='icon-file-text-alt'></i></span>";
        $output .= "<span class='ajax_search_content'>";
        $output .= "    <span class='ajax_search_title'>";
        $output .=       __("Sorry, no posts matched your criteria", 'themeton');
        $output .= "    </span>";
        $output .= "    <span class='ajax_search_excerpt'>";
        $output .=      __("Please try another search term", 'themeton');
        $output .= "    </span>";
        $output .= "</span>";
        $output .= "</span>";
        echo $output;
        die();
    }

    $output = '';
    foreach($posts as $post){
        $image = get_the_post_thumbnail( $post->ID, 'thumbnail' );

        $extra_class = $image ? "with_image" : "";
        $post_type   = $image ? "" : get_post_format($post->ID) != "" ? get_post_format($post->ID) : "standard";
        $iconfont    = $image ? "" : '<i class="icon-file-text-alt"></i>';
        $excerpt     = "";

        $excerpt = get_the_time(get_option('date_format'), $post->ID);
        $link = get_permalink($post->ID);

        $output .= "<a class ='ajax_search_entry {$extra_class}' href='".$link."'>";
        $output .= "<span class='ajax_search_image'>";
        $output .= $image.$iconfont;
        $output .= "</span>";
        $output .= "<span class='ajax_search_content'>";
        $output .= "    <span class='ajax_search_title'>";
        $output .=      get_the_title($post->ID);
        $output .= "    </span>";
        $output .= "    <span class='ajax_search_excerpt'>";
        $output .=      $excerpt;
        $output .= "    </span>";
        $output .= "</span>";
        $output .= "</a>";
    }

    $query = http_build_query($_REQUEST);
    $output .= "<a class='ajax_search_entry ajax_search_entry_view_all' href='".site_url('?' . $query )."'>".__('View all results','themeton')."</a>";

    echo $output;
    exit;
}


/**
 * Custom styles from Theme Options
 */
add_action('wp_ajax_themeton_customcss', 'themeton_customcss_hook');
add_action('wp_ajax_nopriv_themeton_customcss', 'themeton_customcss_hook');

function themeton_customcss_hook() {
    global $smof_data;

    //if( isset($_GET['get_custom_css']) ):
    
    //ob_start("ob_gzhandler");
    //header('Cache-Control: public');
    //header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
    //header("Content-type: text/css");

    echo "<!-- CSS from Theme Options Panel -->\n";
    echo "<style type='text/css'>\n";


    /* Body margin on Attached layout */
    if ($smof_data['layout'] == 'attached' && $smof_data['body_margin_top'] != '') {
        echo ".wrapper{margin:" . $smof_data['body_margin_top'] . "px 0 " . $smof_data['body_margin_bottom'] . "px 0}\n";
    }
    if ($smof_data['logo_top'] > 50 && $smof_data['logo_bottom'] > 50) {
        echo "#logo{margin-top:" . ((int) $smof_data['logo_top'] - 50) . "px;margin-bottom:" . ((int) $smof_data['logo_bottom'] - 50) . "px}\n";
    } elseif ($smof_data['logo_top'] > 50) {
        echo "#logo{margin-top:" . ((int) $smof_data['logo_top'] - 50) . "px;";
    } elseif ($smof_data['logo_bottom'] > 50) {
        echo "#logo{margin-bottom:" . ((int) $smof_data['logo_bottom'] - 50) . "px;";
    }

    /* STYLES OPTIONS */
    if ($smof_data['body_bg_color'] != '')
        echo "body{background-color:" . $smof_data['body_bg_color'] . ";}\n";
    if ($smof_data['message_bar_bg_color'] != '')
        echo "#message_bar{background-color:" . $smof_data['message_bar_bg_color'] . ";}\n";
    if ($smof_data['content_bg_color'] != '' && $smof_data['content_bg_color'] != '#ffffff')
        echo "#content{background-color:" . $smof_data['content_bg_color'] . ";}\n";
    if (isset($smof_data['content_text_color']) && $smof_data['content_text_color'] != '' && $smof_data['content_text_color'] != '#666666')
        echo "#content{color:" . $smof_data['content_text_color'] . ";}\n";
    if ($smof_data['header_bg_color'] != '')
        echo "#header{background-color:" . $smof_data['header_bg_color'] . ";}\n";
    if ($smof_data['menu_bg_color'] != '')
        echo ".wide_menu{background-color:" . $smof_data['menu_bg_color'] . "}.wide_menu #searchform div#s_input:after{border-left-color:" . $smof_data['menu_bg_color'] . "}.wide_menu #searchform div#s_input:before{border-left-color:rgba(0,0,0,.2)}\n";
    
    if ($smof_data['top_bar_bg_color'] != '')
        echo "#top_bar,#top_bar ul.social_icon li a::after{background-color:" . $smof_data['top_bar_bg_color'] . ";}\n";
    if ($smof_data['sub_footer_bg_color'] != '')
        echo "#sub_footer,#sub_footer ul.social_icon li a::after{background-color:" . $smof_data['sub_footer_bg_color'] . ";}\n";

    $title_space = $title_bg_color = $title_bg_image = '';
    if ($smof_data['title_space'] != 40)
        $title_space = "padding:" . $smof_data['title_space'] . "px 0;";
    if ($smof_data['title_bg_color'] != '')
        $title_bg_color = "background-color:" . $smof_data['title_bg_color'] . ";";
    if ($smof_data['title_bg_image'] != "") {
        $title_bg_image = "background-image:url('" . $smof_data['title_bg_image'] . "');";
        $title_bg_image .= "background-repeat:" . $smof_data['title_bg_repeat'] . ";";
        $title_bg_image .= "background-position:" . $smof_data['title_bg_position'] . ";";
        $title_bg_image .= "background-attachment:" . $smof_data['title_bg_fixed'] . ";";
    }
    echo "#feature{ $title_space$title_bg_color$title_bg_image }";

    if ($smof_data['bg_image'] != "") {
        echo "body{background-image:url('" . $smof_data['bg_image'] . "');\n";
        echo "background-repeat:" . $smof_data['bg_repeat'] . ";\n";
        echo "background-position:" . $smof_data['bg_position'] . ";\n";
        echo "background-attachment:" . $smof_data['bg_fixed'] . ";}\n";
    }
    
    /* Footer */
    if ($smof_data['use_footer_column_color'] != 1) {
        if ($smof_data['footer_bg_color'] != '')
            echo "#footer{background-color:" . $smof_data['footer_bg_color'] . ";}\n";
        if ($smof_data['footer_bg_image'] != "") {
            echo "#footer{background-image:url('" . $smof_data['footer_bg_image'] . "');\n";
            echo "background-repeat:" . $smof_data['footer_bg_repeat'] . ";\n";
            echo "background-position:" . $smof_data['footer_bg_position'] . ";\n";
            echo "background-attachment:" . $smof_data['footer_bg_fixed'] . ";}\n";
        }    
    }
    

    /* FONT STYLES */
    if ($smof_data['body_font']['size'] != 12)
        echo "body{font-size:" . $smof_data['body_font']['size'] . "}\n";
    echo "body{font-family:" . $smof_data['body_font']['face'] . "}\n";
    echo "body{font-style:" . $smof_data['body_font']['style'] . "}\n";
    if ($smof_data['body_font']['color'] != '#000000')
        echo "body{color:" . $smof_data['body_font']['color'] . "}\n";

    if ($smof_data['menu_font'] != 13)
        echo ".metro_menu ul li a > .menu_text,.icon_menu ul.menu li a,.default_menu ul.menu li a,.wide_menu ul.menu li a {font-size:" . $smof_data['menu_font'] . "px}\n";

    if ($smof_data['heading1'] != 36)
        echo "h1{font-size:" . $smof_data['heading1'] . "px}\n";
    if ($smof_data['heading2'] != 30)
        echo "h2{font-size:" . $smof_data['heading2'] . "px}\n";
    if ($smof_data['heading3'] != 24)
        echo "h3{font-size:" . $smof_data['heading3'] . "px}\n";
    if ($smof_data['heading4'] != 18)
        echo "h4{font-size:" . $smof_data['heading4'] . "px}\n";
    if ($smof_data['heading5'] != 14)
        echo "h5{font-size:" . $smof_data['heading5'] . "px}\n";
    if ($smof_data['heading6'] != 12)
        echo "h6{font-size:" . $smof_data['heading6'] . "px}\n";

     if ($smof_data['widget_font'] != 12)
        echo "h3.widget_title{font-size:" . $smof_data['widget_font'] . "px}\n";
     
    /* GOOGLE FONTS */
    if ($smof_data['google_font'] == 1) {
        if ($smof_data['google_menu'] != 'default') {
            echo ".menu{font-family:'" . $smof_data['google_menu'] . "'}\n";
        }
        if ($smof_data['google_heading'] != 'default') {
            echo "h1,h2,h3,h4,h5,h6{font-family:'" . $smof_data['google_heading'] . "'}\n";
        }
        if ($smof_data['google_body'] != 'default') {
            echo "body{font-family:'" . $smof_data['google_body'] . "'}\n";
        }
    }


    /* General Colors */
    if ($smof_data['general_color'] != '' && $smof_data['general_color'] != '#00b4cc'){
    ?>
    /*woocommerce*/
    footer.cart_buttons a.button,
    /*elements*/
    .post-filter > span a,
    .post-filter > span:hover a::before {
        color: <?php echo $smof_data['general_color']; ?>;
    }
    /*style*/
    ul.menu ul .menu_item .new:after,
    #feature, #error-404 input[type="submit"], 
    input[type="button"], input[type="reset"], input[type="submit"],
    .tt_widget_thumb,
    .tagcloud a,
    .widget_social ul li a, ul.social_icon li a,
    .widget_pages ul li.current_page_item, .widget ul.menu li.menu.current_menu_item,
    .widget_archive ul li span, .widget_categories ul li span, .widget_product_categories ul li span,
    /*woocommere custom*/
    .woocommerce span.onsale,
    .woocommerce-page span.onsale,

    .woocommerce ul.products li.product .entry_product:hover,
    .woocommerce-page ul.products li.product .entry_product:hover,
    .woocommerce-page .entry_product:hover,

    footer.cart_buttons a.button,

    .woocommerce a.button,
    .woocommerce-page a.button,
    .woocommerce button.button,
    .woocommerce-page button.button,
    .woocommerce input.button,
    .woocommerce-page input.button,
    .woocommerce #respond input#submit,
    .woocommerce-page #respond input#submit,
    .woocommerce #content input.button,
    .woocommerce-page #content input.button,

    .woocommerce a.button.alt,
    .woocommerce-page a.button.alt,
    .woocommerce button.button.alt,
    .woocommerce-page button.button.alt,
    .woocommerce input.button.alt,
    .woocommerce-page input.button.alt,
    .woocommerce #respond input#submit.alt,
    .woocommerce-page #respond input#submit.alt,
    .woocommerce #content input.button.alt,
    .woocommerce-page #content input.button.alt,

    .woocommerce .addresses .title .edit,
    .woocommerce-page .addresses .title .edit,

    .price_slider_wrapper .ui-slider-handle,

    .woocommerce span.onsale,
    .woocommerce-page span.onsale,

    /*elements*/
    .jp-play-bar,
    .blox_elem_button_default,
    .blox_elem_divider.style7,
    .blox_elem_divider.style8{
        background-color: <?php echo $smof_data['general_color']; ?>;
    }
    /*style*/
    #error-404 input[type="text"], article.portfolio,
    /*woocommerce*/
    .woocommerce nav.woocommerce-pagination ul,
    .woocommerce-page nav.woocommerce-pagination ul,
    .woocommerce #content nav.woocommerce-pagination ul,
    .woocommerce-page #content nav.woocommerce-pagination ul,

    .woocommerce ul.products li.product .entry_product:hover,
    .woocommerce-page ul.products li.product .entry_product:hover,
    .woocommerce-page .entry_product:hover,
    /*elements*/
    .blog_big .entry_content_big_container,
    .blog_big.blog_list_view,
    .blog_medium,
    .grid_entry article.entry:hover,
    .grid_entry .centered_portfolio article.entry,
    .format_quote blockquote,
    .grid_pager .tt-pager-pagination,
    .metro .tt-pager-pagination,
    .post-filter,
    .blox_gallery.gallery_layout_slider .gallery_pager span.cycle-pager-active{
        border-color: <?php echo $smof_data['general_color']; ?>;
    }
    .entry_media:hover .entry_hover{background-color:<?php echo blox_hex2rgba($smof_data['general_color'],0.9); ?>}
    <?php
    }

    
    /* Menu color */
    if (isset($smof_data['menu_text_color']) && $smof_data['menu_text_color'] != '') {
        echo ".wide_menu ul.menu li a,nav.mainmenu a{color:".$smof_data['menu_text_color'] . "}\n";
    }
    if (isset($smof_data['menu_text_hover_color']) && $smof_data['menu_text_hover_color'] != '') {
        echo ".wide_menu ul.menu li a:hover,nav.mainmenu ul.menu li a:hover,ul.menu li a:hover,.icon_menu ul.menu li a:hover, ul.menu li a.active{color:".$smof_data['menu_text_hover_color'] . "}\n";
    }
    
    /* Link color */
    if (isset($smof_data['link_color']) && $smof_data['link_color'] != '#00b4cc')
        echo "a{color:" . $smof_data['link_color'] . "}\n";
    if (isset($smof_data['link_hover_color']) && $smof_data['link_hover_color'] != '')
        echo "a:hover{color:" . $smof_data['link_hover_color'] . "}\n";

    /* Heading color */
    if(isset($smof_data['heading_text_color']) && $smof_data['heading_text_color'] != '')
        echo "h1,h2,h3,h4,h5,h6{color:" . $smof_data['heading_text_color'] . "} ";
    
    /* Widget title color */
    if(isset($smof_data['widget_title_color']) && $smof_data['widget_title_color'] != '')
        echo "h3.widget_title{color:" . $smof_data['widget_title_color'] . "} ";
    
    
    /* CUSTOM STYLES */
    if ($smof_data['custom_css'] != '')
        echo $smof_data['custom_css'] . "\n";
    if ($smof_data['tablet_css'] != '') {
        echo "@media (min-width: 768px) and (max-width: 985px) {";
        echo $smof_data['tablet_css'];
        echo "}\n";
    }
    if ($smof_data['wide_phone_css'] != '') {
        echo "@media (min-width: 480px) and (max-width: 767px) {";
        echo $smof_data['wide_phone_css'];
        echo "}\n";
    }
    if ($smof_data['phone_css'] != '') {
        echo "@media (max-width: 479px) {";
        echo $smof_data['phone_css'];
        echo "}\n";
    }

    echo "</style>\n";
    //exit;
    //endif;
}


