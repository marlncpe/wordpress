<?php
/*
 * Globals
 */

define('THEMEDOC', 'http://docs.themeton.com/mana');
define('SUPPORFORUM', 'http://themeton.freshdesk.com');

/**
 * Enable Menu and Locations
 */
add_action('after_setup_theme', 'theme_setup');
if (!function_exists('theme_setup')):

    function theme_setup() {
        add_editor_style();
        register_nav_menus(array(
            'primary' => __('Primary Navigation', 'themeton'),
            'topbar-menu' => __('Top Bar Navigation', 'themeton'),
            'mobile-menu' => __('Mobile Navigation (optional)', 'themeton'),
            'footer-menu' => __('Footer Navigation', 'themeton')
        ));
        load_theme_textdomain('themeton', get_template_directory() . '/languages/');
    }

endif;

/*
 * Theme setup
 */
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
// For thumbnail image for post list
add_image_size('small', 45, 45, true);
// For thumbnail for TT recent posts widget
add_image_size('thumb', 65, 65, true);
// Metro blog images
add_image_size('metro-small', 165, 165, true);
add_image_size('metro-horizontal', 360, 165, true);
add_image_size('metro-large', 360, 360, true);

// For related posts in single page
add_image_size('relatedposts', 168, 130, true);


if (!isset($content_width))
    $content_width = 960;


/* * ***********************       */
/* Admin Panel - Options Framework */
/* * ***********************       */
require_once ('framework/admin-panel/index.php');


/* * ***********************     */
/* Theme part file including 	 */
/* * ***********************     */
require_once( get_template_directory() . '/framework/minify.php' );
require_once( get_template_directory() . '/framework/Pagebuilder/index.php' );
require_once( get_template_directory() . '/framework/common-functions.php' );
require_once( get_template_directory() . '/framework/mega-menu/mega-menu.php' );
require_once( get_template_directory() . '/framework/widgets/init_widget.php' );

require_once( get_template_directory() . '/framework/comment-template.php' );

require_once( get_template_directory() . '/framework/config-bbp/config.php' );
require_once( get_template_directory() . '/framework/config-woocommerce/config.php' );


/* TGM Plugin Activation */
require_once( get_template_directory() . '/framework/tgmplugin/plugin-install.php' );



/* Welcome page */
include_once( 'framework/welcome.php' );

function activation_admin_init() {
    global $pagenow;
    if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
        #redirect to options page
        wp_safe_redirect(admin_url('admin.php?page=mana-about'));
    }
}

add_action('admin_init', 'activation_admin_init');




/**
 * Registers all widget areas.
 */

// Global scope that saves sidebar list
global $smof_data;
$tt_sidebars = $tt_sliders = array();
if (isset($smof_data['custom_sidebar']) && is_array($smof_data['custom_sidebar'])) {
    foreach ($smof_data['custom_sidebar'] as $sidebar) {
        if ($sidebar['title'] != '') {
            $tt_sidebars[$sidebar['title']] = $sidebar['title'];
        }
    }
}
$tt_sidebars = array_merge(array(
    'post-sidebar'=> 'Post Sidebar Area',
    'page-sidebar'=> 'Page Sidebar Area',
    'blog-sidebar'=> 'Blog Sidebar Area',
    'portfolio-sidebar'=> 'Portfolio Sidebar Area',
    'woocommerce-sidebar'=> 'Woocommerce Sidebar Area'
        ), $tt_sidebars);

function theme_widgets_init() {
    /**
     * Registering custom sidebars 
     */
    global $tt_sidebars;
    if(isset($tt_sidebars)) {
        foreach ($tt_sidebars as $id => $sidebar) {
            if ($id != '') {
                register_sidebar(array(
                    'name' => $sidebar,
                    'id' => $id,
                    'description' => $sidebar,
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="widget_title">',
                    'after_title' => '</h3>'
                ));                
            }
        }
    }

    /**
     * Registering Footer sidebars 
     */
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name' => 'Footer Sidebar Area ' . $i,
            'id' => 'sidebar_metro_footer' . $i,
            'description' => 'Footer Sidebar Area ' . $i,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget_title">',
            'after_title' => '</h3>'
        ));
    }
}

add_action('widgets_init', 'theme_widgets_init');



/* * ***********************       */
/* Metaboxes of page and post      */
/* * ***********************       */
$tt_post_meta = array();
require_once('framework/post-type/post-options.php');
require_once('framework/post-type/page-options.php');
require_once('framework/post-type/portfolio-options.php');
require_once('framework/post-type/renderer.php');


/* * ***********************     */
/* Script and CSS file including */
/* * ***********************     */

add_action('wp_enqueue_scripts', 'themeton_enqueue_scripts');

function themeton_enqueue_scripts() {
    global $smof_data;

    if ($smof_data['google_font'] == 1) {
        $protocol = is_ssl() ? 'https' : 'http';
        $font_options = array('menu', 'heading', 'body');
        $fonts_included = array();
        foreach ($font_options as $option)
            if ($smof_data["google_$option"] != 'default') {
                $font = str_replace(' ', '+', $smof_data["google_$option"]);
                $subset = ($smof_data["google_subset"] != '') ? '&subset=' . $smof_data["google_subset"] : '';
                $subset = str_replace(' ', '', $subset);
                if (!in_array($font, $fonts_included)) {
                    wp_enqueue_style("themeton-google-font-$option", "$protocol://fonts.googleapis.com/css?family=" . $font . ":300,400,700,800" . $subset);
                    $fonts_included[] = $font;
                }
            }
    }

    wp_enqueue_style('themeton-css-grid', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_style( 'mana-style', get_stylesheet_uri() );
    wp_enqueue_style('themeton-css-responsive', get_template_directory_uri() . '/assets/css/responsive.css');
    add_action('wp_head', 'themeton_customcss_hook', 100);

    wp_enqueue_script('jquery');

    /*
    $tmpl_path = trailingslashit(get_template_directory_uri());
    $jsFiles = array(
        $tmpl_path.'assets/js/respond.min.js',
        $tmpl_path.'assets/js/skrollr.min.js',
        $tmpl_path.'assets/js/jquery.isotope.min.js',
        $tmpl_path.'assets/js/jqueryslidemenu.js',
        $tmpl_path.'assets/js/jquery.fitvids.js',
        $tmpl_path.'assets/js/scripts.js'
    );
    $minify_script = new TTMinify();
    $minify_script->minify_script($jsFiles);
    */

    wp_enqueue_script('themeton-script', get_template_directory_uri() . '/assets/js/', false, false, true);

}

if (!function_exists('my_search_form')) {

    function my_search_form() {

        $form = '<form role="search" method="get" id="searchform" action="' . site_url('/') . '" >
    <div>
    <input type="submit" id="searchsubmit" value=""/>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search', 'themeton') . '" />    
    </div>
    </form>';

        return $form;
    }

    add_filter('get_search_form', 'my_search_form');
}

if (!function_exists('tt_paginate_links')) :

    function tt_paginate_links($query = null) {
        global $wp_query;
        $current_query = $query!=null ? $query : $wp_query;
        $pages = $current_query->max_num_pages;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if (is_front_page())
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;

        if (empty($pages)) {
            $pages = 1;
        }
        if (1 != $pages) {
            if ($paged > 1) {
                $prevlink = get_pagenum_link($paged - 1);
            }
            if ($paged < $pages) {
                $nextlink = get_pagenum_link($paged + 1);
            }


            $big = 9999; // need an unlikely integer
            echo "<div class='row'><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><div class='tt-pager-pagination blog_pager clearfix'>";

            $args = array(
                'current' => 0,
                'show_all' => false,
                'prev_next' => true,
                'add_args' => false, // array of query args to add
                'add_fragment' => '',
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'end_size' => 3,
                'mid_size' => 1,
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $current_query->max_num_pages,
                'type' => 'list',
                'prev_text' => __('<i class="icon-arrow-left"></i>', 'themeton'),
                'next_text' => __('<i class="icon-arrow-right"></i>', 'themeton'),
            );

            extract($args, EXTR_SKIP);

            // Who knows what else people pass in $args
            $total = (int) $total;
            if ($total < 2)
                return;
            $current = (int) $current;
            $end_size = 0 < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
            $mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
            $add_args = is_array($add_args) ? $add_args : false;
            $r = '';
            $page_links = array();
            $next_link = $prev_link = '';
            $n = 0;
            $dots = false;

            if ($prev_next && $current && 1 < $current) :
                $link = str_replace('%_%', 2 == $current ? '' : $format, $base);
                $link = str_replace('%#%', $current - 1, $link);
                if ($add_args)
                    $link = add_query_arg($add_args, $link);
                $link .= $add_fragment;
                $next_link = '<a class="prev_page" rel="prev" href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $prev_text . '</a>';
            endif;
            for ($n = 1; $n <= $total; $n++) :
                $n_display = number_format_i18n($n);
                if ($n == $current) :
                    $page_links[] = "<span class='page-numbers current'>$n_display</span>";
                    $dots = true;
                else :
                    if ($show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size )) :
                        $link = str_replace('%_%', 1 == $n ? '' : $format, $base);
                        $link = str_replace('%#%', $n, $link);
                        if ($add_args)
                            $link = add_query_arg($add_args, $link);
                        $link .= $add_fragment;
                        $page_links[] = "<a class='page-numbers' data-hover='$n_display' href='" . esc_url(apply_filters('paginate_links', $link)) . "'>$n_display</a>";
                        $dots = true;
                    elseif ($dots && !$show_all) :
                        $page_links[] = '<span class="page-numbers dots">' . __('&hellip;', 'themeton') . '</span>';
                        $dots = false;
                    endif;
                endif;
            endfor;
            if ($prev_next && $current && ( $current < $total || -1 == $total )) :
                $link = str_replace('%_%', $format, $base);
                $link = str_replace('%#%', $current + 1, $link);
                if ($add_args)
                    $link = add_query_arg($add_args, $link);
                $link .= $add_fragment;
                $prev_link = '<a class="next_page" rel="next" href="' . esc_url(apply_filters('paginate_links', $link)) . '">' . $next_text . '</a>';
            endif;
            $r .= $next_link;
            $r .= "<ul>\n\t<li>";
            $r .= join("</li>\n\t<li>", $page_links);
            $r .= "</li>\n</ul>\n";
            $r .= $prev_link;
            echo $r;
            echo "</div></div><!-- end pagination --></div>";
        }
    }

endif;



if (!function_exists('themeton_entry_meta')) :

    function themeton_entry_meta() {
        if (is_sticky() && is_home() && !is_paged())
            echo '<span class="featured-post">' . __('Sticky', 'themeton') . '</span>';

        if (!has_post_format('aside') && !has_post_format('link') && 'post' == get_post_type())
            themeton_entry_date();

        // Translators: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list(__(', ', 'themeton'));
        if ($categories_list) {
            echo '<span class="categories-links">' . $categories_list . '</span>';
        }

        // Translators: used between list items, there is a space after the comma.
        $tag_list = get_the_tag_list('', __(', ', 'themeton'));
        if ($tag_list) {
            echo '<span class="tags-links">' . $tag_list . '</span>';
        }

        // Post author
        if ('post' == get_post_type()) {
            printf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_attr(sprintf(__('View all posts by %s', 'themeton'), get_the_author())), get_the_author()
            );
        }
    }

endif;

if (!function_exists('themeton_entry_date')) :

      function themeton_entry_date($echo = true) {
        $format_prefix = ( has_post_format('chat') || has_post_format('status') ) ? _x('%1$s on %2$s', '1: post format name. 2: date', 'themeton') : '%2$s';

        $date = sprintf('<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>', esc_url(get_permalink()), esc_attr(sprintf(__('Permalink to %s', 'themeton'), the_title_attribute('echo=0'))), esc_attr(get_the_date('c')), esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date()))
        );

        if ($echo)
            echo $date;

        return $date;
    }

endif;






/* Theme Customizer */
/* ================================================================== */

add_action('customize_register', 'themeton_customize_register');
function themeton_customize_register($wp_customize){
    
    $wp_customize->add_section( 'mana_color_settings', array(
        'title'          => 'Main color',
        'priority'       => 35,
    ) );


    $wp_customize->add_setting( 'mana_main_color', array(
        'default'        => '#00b4cc',
        'transport' =>'postMessage' 
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mana_main_color', array(
        'label'   => 'Site General Color',
        'section' => 'colors',
        'settings'   => 'mana_main_color',
    )));

    $wp_customize->add_setting( 'mana_body_bgcolor', array(
        'default'        => '#ffffff',
        'transport' =>'postMessage' 
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mana_body_bgcolor', array(
        'label'   => 'Body Background Color',
        'section' => 'colors',
        'settings'   => 'mana_body_bgcolor',
    )));

    $wp_customize->add_setting( 'mana_content_bgcolor', array(
        'default'        => '#ffffff',
        'transport' =>'postMessage' 
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mana_content_bgcolor', array(
        'label'   => 'Content Background Color',
        'section' => 'colors',
        'settings'   => 'mana_content_bgcolor',
    )));

    $wp_customize->add_setting( 'mana_link_color', array(
        'default'        => '#00b4cc',
        'transport' =>'postMessage' 
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mana_link_color', array(
        'label'   => 'Link Color',
        'section' => 'colors',
        'settings'   => 'mana_link_color',
    )));

    if ( $wp_customize->is_preview() && !is_admin() ){
        add_action( 'wp_footer', 'themeton_customize_preview', 21);
    }
}

function themeton_customize_preview(){
?>
    <script type="text/javascript">
    jQuery(function($){
        
        wp.customize('mana_main_color',function( value ) {
            value.bind(function(to) {
                 $('a').css('color', to);
             });
        });

        wp.customize('mana_body_bgcolor',function( value ) {
            value.bind(function(to) {
                 $('body').css('background-color', to);
             });
        });

        wp.customize('mana_content_bgcolor',function( value ) {
            value.bind(function(to) {
                 $('#content').css('background-color', to);
             });
        });

        wp.customize('mana_link_color',function( value ) {
            value.bind(function(to) {
                 $('a').css('color', to);
             });
        });

    });
    </script>
<?php
}


?>