<?php

add_action('admin_enqueue_scripts', 'admin_post_option_render_scripts');

function admin_post_option_render_scripts($hook) {
    if (themeton_admin_post_type() != 'post') {
        return;
    }
    wp_enqueue_style('tt_admin_post_format_style', get_template_directory_uri() . '/framework/post-type/post-styles.css');
    wp_enqueue_script('tt_admin_post_format_script', get_template_directory_uri() . '/framework/post-type/post-scripts.js', false, false, true);
}

add_theme_support('post-formats', array('image', 'gallery', 'link', 'video', 'audio', 'chat', 'status', 'quote', 'aside'));

if (!function_exists('the_post_format_audio')) {
    $tmp_arr_format = array(
        'post_format' => array(
            'label' => 'Post Format',
            'post_type' => 'post',
            'items' => array(
                array(
                    'name' => 'post_format',
                    'realname' => '1',
                    'type' => 'text',
                    'label' => 'Post Format',
                    'default' => ''
                ),
                array(
                    'name' => 'format_image',
                    'realname' => '1',
                    'type' => 'textarea',
                    'label' => 'Post Format Image',
                    'default' => ''
                ),
                array(
                    'name' => 'format_video_embed',
                    'realname' => '1',
                    'type' => 'textarea',
                    'label' => 'Post Format Video',
                    'default' => ''
                ),
                array(
                    'name' => 'format_audio_embed',
                    'realname' => '1',
                    'type' => 'textarea',
                    'label' => 'Post Format Audio',
                    'default' => ''
                ),
                array(
                    'name' => 'format_link_url',
                    'realname' => '1',
                    'type' => 'text',
                    'label' => 'Post Format Link',
                    'default' => ''
                ),
                array(
                    'name' => 'format_quote_source_name',
                    'realname' => '1',
                    'type' => 'text',
                    'label' => 'Post Format Quote Source',
                    'default' => ''
                ),
                array(
                    'name' => 'format_quote_source_url',
                    'realname' => '1',
                    'type' => 'text',
                    'label' => 'Post Format Quote url',
                    'default' => ''
                )
            )
        )
    );
    $tt_post_meta = array_merge($tt_post_meta, $tmp_arr_format);
}

global $smof_data;
$tmp_arr = array(
    'post' => array(
        'label' => 'Post Options',
        'post_type' => 'post',
        'items' => array(
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
                'desc' => 'Choose Page Layout (Fullwidth | Right Sidebar | Left Sidebar)'
            ),
            array(
                'name' => 'sidebar',
                'type' => 'select',
                'label' => 'Post Sidebar',
                'default' => 'post-sidebar',
                'option' => $tt_sidebars,
                'desc' => 'You should select a sidebar If you\'ve chosen page layout with sidebar. And if you need an unique sidebar for this page, you have to create new one on Theme Options => <b>Custom Sidebar</b> and then add your Appearence => <b>Widgets</b>. Later on select it here.'
            ),
            array(
                'name' => 'hidefeaturedimg',
                'type' => 'checkbox',
                'label' => 'Hide Featured Image on Single?',
                'desc' => 'You should turn this option ON if you dont want to show Featured image on single post page.'
            ),
            array(
                'name' => 'metro',
                'type' => 'title',
                'title' => 'Post Style on Metro Blog',
                'label' => ''
            ),
            array(
                'name' => 'color',
                'type' => 'colorpicker',
                'label' => 'Post Color on Metro Blog',
                'default' => isset($smof_data['post_color']) ? $smof_data['post_color'] : '#00b4cc',
                'desc' => 'Pick a color here to introduce your post. You can change default color value on Theme Options => <b>Color Options</b> for your newer and old posts those didn\'t set this option yet.'
            ),
            array(
                'name' => 'post_icon',
                'type' => 'font_icon',
                'label' => 'Post Icon & Layout',
                'default' => 'icon-smile'
            ),
            array(
                'name' => 'metro_style',
                'type' => 'metro',
                'label' => '',
                'default' => '',
                'fullwidth' => '1'
            ),
        )
    )
);

$tt_post_meta = array_merge($tt_post_meta, $tmp_arr);
?>