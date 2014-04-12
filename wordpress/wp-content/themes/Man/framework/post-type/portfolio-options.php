<?php

function register_portfolio_type() {
    $labels = array(
        'name' => __('Portfolio', 'themeton'),
        'singular_name' => __('Portfolio', 'themeton'),
        'edit_item' => __('Edit Portfolio', 'themeton'),
        'new_item' => __('New Portfolio', 'themeton'),
        'all_items' => __('All Portfolio', 'themeton'),
        'view_item' => __('View Portfolio', 'themeton'),
        'menu_name' => __('Portfolio Items', 'themeton')
    );
    global $smof_data;
    $slug = isset($smof_data['portfolio_slug']) ? $smof_data['portfolio_slug'] : 'portfolio-item';
    $args = array(
        'labels' => $labels,
        'public' => true,
        '_builtin' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => $slug),
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('portfolio', $args);

    $tax = array(
        "hierarchical" => true,
        "label" => __("Categories", "themeton"),
        "singular_label" => __("Portfolio Category", "themeton"),
        "rewrite" => true);

    register_taxonomy('portfolio_entries', 'portfolio', $tax);

    flush_rewrite_rules();
}

add_action('init', 'register_portfolio_type');

function portfolio_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "thumbnail column-comments" => "Image",
        "title" => __("Portfolio Title", "themeton"),
        "catalogs" => __("Categories", "themeton"),
        "date" => __("Date", "themeton"),
    );
    return $columns;
}

add_filter('manage_edit-portfolio_columns', 'portfolio_edit_columns');

function portfolio_custom_columns($column) {
    global $post;
    switch ($column) {
        case "thumbnail column-comments":
            if (has_post_thumbnail($post->ID)) {
                echo get_the_post_thumbnail($post->ID, 'small');
            }
            break;
        case "catalogs":
            echo get_the_term_list($post->ID, 'catalogs', '', ', ', '');
            break;
        case "price":
            echo get_the_term_list($post->ID, 'prices', '', ', ', '');
            break;
        case "team":
            echo get_the_term_list($post->ID, 'position', '', ', ', '');
            break;
        case "testimonial":
            echo get_the_term_list($post->ID, 'testimonials', '', ', ', '');
            break;
    }
}

//add_action("manage_posts_custom_column", "portfolio_custom_columns");

add_action('admin_enqueue_scripts', 'admin_portfolio_option_render_scripts');

function admin_portfolio_option_render_scripts($hook) {
    if (themeton_admin_post_type() != 'portfolio') {
        return;
    }
    wp_enqueue_style('tt_admin_portfolio_option_style', get_template_directory_uri() . '/framework/post-type/portfolio-styles.css');
    wp_enqueue_script('tt_admin_portfolio_option_script', get_template_directory_uri() . '/framework/post-type/portfolio-scripts.js', false, false, true);
}

/* SLIDER VALUES */
global $tt_sidebars;

$tmp_arr = array(
    'portfolio' => array(
        'label' => 'Page Options',
        'post_type' => 'portfolio',
        'items' => array(
            array(
                'name' => 'hidetitle',
                'type' => 'checkbox',
                'label' => 'Hide page title?',
            ),
            array(
                'name' => 'title_bgcolor',
                'type' => 'colorpicker',
                'label' => 'Title Background Color',
                'default' => isset($smof_data['title_bg_color']) ? $smof_data['title_bg_color'] : '#00b4cc'
            ),
            array(
                'name' => 'general_color',
                'type' => 'colorpicker',
                'label' => 'Content Background Color',
                'default' => isset($smof_data['content_bg_color']) ? $smof_data['content_bg_color'] : '#ffffff',
                'option' => array(
                    'val' => 'label'
                )
            ),
            array(
                'name' => 'page_layout',
                'type' => 'thumbs',
                'label' => 'Page Layout',
                'default' => 'right',
                'option' => array(
                    'full' => ADMIN_IMAGES . '1col.png',
                    'left' => ADMIN_IMAGES . '2cl.png',
                    'right' => ADMIN_IMAGES . '2cr.png',
                ),
                'desc' => 'Select Page Layout (Fullwidth | Right Sidebar | Left Sidebar)'
            ),
            array(
                'name' => 'sidebar',
                'type' => 'select',
                'label' => 'Portfolio Sidebar',
                'default' => 'portfolio-sidebar',
                'option' => $tt_sidebars,
                'desc' => 'You should select a sidebar If you\'ve chosen page layout with sidebar. And if you need an unique sidebar for this page, you have to create new one on Theme Options => <b>Custom Sidebar</b> and then add your Appearence => <b>Widgets</b>. Later on select it here.'
            ),
            array(
                'name' => 'teaser',
                'type' => 'textarea',
                'label' => 'Page Teaser',
                'default' => '',
                'desc' => 'Add description text which shows up at bottom of Page Title.'
            ),
            array(
                'name' => 'bg_image',
                'type' => 'image',
                'label' => 'Background image',
                'default' => '',
                'desc' => 'Background image for content.'
            ),
            array(
                'name' => 'bg_repeat',
                'type' => 'select',
                'label' => 'Background Repeat',
                'default' => 'repeat',
                'option' => array(
                    'repeat' => 'Repeat',
                    'repeat-x' => 'Repeat-X',
                    'repeat-y' => 'Repeat-Y',
                    'no-repeat' => 'No Repeat'
                ),
                'fullwidth' => 1
            ),
            array(
                'name' => 'bg_position',
                'type' => 'select',
                'label' => 'Background Position',
                'default' => 'top left',
                'option' => array(
                    'top left' => 'Top & Left',
                    'top center' => 'Top & Center',
                    'top right' => 'Top & Right',
                    'center left' => 'Center & Left',
                    'center center' => 'Center & Center',
                    'center right' => 'Center & Right',
                    'bottom left' => 'Bottom & Left',
                    'bottom center' => 'Bottom & Center',
                    'bottom right' => 'Bottom & Right',
                ),
                'fullwidth' => 1
            ),
            array(
                'name' => 'bg_fixed',
                'type' => 'select',
                'label' => 'Background Scroll or Fixed',
                'default' => 'top left',
                'option' => array(
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                ),
                'fullwidth' => 1
            ),
        )
    )
);

$tt_post_meta = array_merge($tt_post_meta, $tmp_arr);
?>