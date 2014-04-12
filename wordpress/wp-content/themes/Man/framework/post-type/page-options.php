<?php

add_action('admin_enqueue_scripts', 'admin_page_option_render_scripts');

function admin_page_option_render_scripts($hook) {
    if (themeton_admin_post_type() != 'page') {
        return;
    }
    wp_enqueue_style('tt_admin_page_option_style', get_template_directory_uri() . '/framework/post-type/page-styles.css');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('tt_admin_page_option_script', get_template_directory_uri() . '/framework/post-type/page-scripts.js', false, false, true);
}

global $smof_data, $tt_sidebars, $tt_sliders;

/* SLIDER VALUES */
global $wpdb;
$table_name = $wpdb->prefix . "layerslider";
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    
} else {
    $layer_sliders = $wpdb->get_results("SELECT id, name FROM $table_name
                                    WHERE flag_hidden = '0' AND flag_deleted = '0'
                                    ORDER BY date_c ASC LIMIT 100");
}

$tt_sliders = array("none" => "No slider");
// Layer slider list
if (!empty($layer_sliders)) {
    foreach ($layer_sliders as $key => $item) {
        $name = empty($item->name) ? ('Unnamed(' . $item->id . ')') : $item->name;
        $tt_sliders = array_merge($tt_sliders, array("layerslider_" . $item->id => "LayerSlider - " . $name));
    }
}
// Revolution slider list
$table_name_rev = $wpdb->prefix . "revslider_sliders";
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_rev'") != $table_name_rev) {
    
} else {
    $rev_sliders = $wpdb->get_results("SELECT id, title, alias FROM $table_name_rev");
    if (!empty($rev_sliders)) {
        foreach ($rev_sliders as $key => $item) {
            $name = empty($item->title) ? ('Unnamed(' . $item->id . ')') : $item->title;
            $tt_sliders = array_merge($tt_sliders, array("revslider_" . $item->alias => "Revolution Slider - " . $name));
        }
    }
}

// init One Page menus
$onepages_for_navs = array();
$onepage_with_templates = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-one-page.php'
        ));
foreach ($onepage_with_templates as $page) {
    $onepage_menu = array();
    $onepage_menu['onepage_nav' . $page->ID] = $page->post_title;
    $onepages_for_navs = array_merge($onepages_for_navs, $onepage_menu);
}

add_action('after_setup_theme', 'onepage_menu_setup');

function onepage_menu_setup() {
    global $onepages_for_navs;
    register_nav_menus($onepages_for_navs);
}

$url = ADMIN_IMAGES;
$tmp_arr = array(
    'onepage' => array(
        'label' => 'One Page Options',
        'post_type' => 'page',
        'items' => array(
            array(
                'name' => 'onepages',
                'type' => 'onepage',
                'label' => 'Pages for One Page Template',
                'desc' => 'Build page with Multi pages',
                'default' => '',
            ),
            array(
                'name' => 'onepages_names',
                'type' => 'text',
                'label' => 'Pages Names',
                'default' => '',
            ),
            array(
                'name' => 'onepages_links',
                'type' => 'text',
                'label' => 'Pages Links',
                'default' => '',
            ),
            array(
                'name' => 'onepage_menu',
                'type' => 'checkbox',
                'label' => 'Use One Page Menu',
                'desc' => 'If you check this option, current pages menu would be selected pages titles.'
            )
        )
    ),
    'page' => array(
        'label' => 'Page Options',
        'post_type' => 'page',
        'items' => array(
            array(
                'name' => 'slider',
                'type' => 'select',
                'label' => 'Top slider',
                'option' => $tt_sliders,
                'desc' => 'Select a slider that you\'ve created on LayerSlider and Revolution Slider. This slider shows up between header and page title.'
            ),
            array(
                'name' => 'page_layout',
                'type' => 'thumbs',
                'label' => 'Page Layout',
                'default' => 'full',
                'option' => array(
                    'full' => ADMIN_DIR . 'assets/images/1col.png',
                    'right' => ADMIN_DIR . 'assets/images/2cr.png',
                    'left' => ADMIN_DIR . 'assets/images/2cl.png'
                ),
                'desc' => 'Select Page Layout (Fullwidth | Right Sidebar | Left Sidebar)'
            ),
            array(
                'name' => 'sidebar',
                'type' => 'select',
                'label' => 'Page Sidebar',
                'default' => 'page-sidebar',
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
            /*
             * Page customization options
             */
            array(
                'name' => 'customize_page',
                'type' => 'checkbox',
                'label' => '<span style="font-weight:bold; background-color:#4cd864; display:inline-block; padding: 3px; border-radius:3px; color:#fff;">Need Advanced Customization?</span>',
                'desc' => 'You can customize this page fully with following options. Those options help you to create new looking pages those are absolutely individual than general options. Think different and Enjoy :)'
            ),
            // Start option group division
            array(
                'name' => 'customize_group_container',
                'type' => 'start_group',
                'visible' => false
            ),
            array(
                'name' => 'layout',
                'type' => 'select',
                'label' => 'Container Layout',
                'default' => 'full',
                'option' => array(
                    'full' => 'Full Width',
                    'boxed' => 'Boxed',
                    'attached' => 'Attached'
                ),
                'desc' => 'Page Container Layout'
            ),
            array(
                'name' => 'body_margin_top',
                'type' => 'number',
                'label' => 'Site Top Spacing',
                'default' => isset($smof_data['body_margin_top']) ? $smof_data['body_margin_top'] : 40,
                'desc' => 'Site top spacing for Attached Page Layout.'
            ),
            array(
                'name' => 'body_margin_bottom',
                'type' => 'number',
                'label' => 'Site Bottom Spacing',
                'default' => isset($smof_data['body_margin_bottom']) ? $smof_data['body_margin_bottom'] : 40,
                'desc' => 'Site bottom spacing for Attached Page Layout.'
            ),
            array(
                'name' => 'hidetopbar',
                'type' => 'checkbox',
                'label' => 'Hide page top bar?',
                'desc' => 'Top Bar will not show up If you turn this option ON.'
            ),
            array(
                'name' => 'hideheader',
                'type' => 'checkbox',
                'label' => 'Hide page header?',
                'desc' => 'Page Title will not show up If you turn this option ON.'
            ),
            array(
                'name' => 'header_layout_images',
                'type' => 'start_group',
                'visible' => true
            ),
            array(
                'name' => 'header_layout',
                'type' => 'thumbs',
                'label' => 'Header Layout',
                'default' => '1',
                'option' => array(
                    '1' => ADMIN_IMAGES . '/Header-1.jpg',
                    '2' => ADMIN_IMAGES . '/Header-2.jpg',
                    '3' => ADMIN_IMAGES . '/Header-3.jpg',
                    '4' => ADMIN_IMAGES . '/Header-4.jpg',
                    '5' => ADMIN_IMAGES . '/Header-5.jpg'
                ),
                'desc' => 'Select header layout type for this page.'
            ),
            array(
                'name' => 'header_bg_color',
                'type' => 'colorpicker',
                'label' => 'Header BG Color',
                'default' => isset($smof_data['header_bg_color']) ? $smof_data['header_bg_color'] : '#ffffff',
                'desc' => 'Page Header Background Color'
            ),
            array(
                'name' => 'menu_bg_color',
                'type' => 'colorpicker',
                'label' => 'Menu BG Color for layout 4 and 5 ',
                'default' => isset($smof_data['menu_bg_color']) ? $smof_data['menu_bg_color'] : '#FFFFFF',
                'desc' => 'Page Menu Section Background Color'
            ),
            array(
                'name' => 'header_transparent',
                'type' => 'checkbox',
                'label' => 'Menu transparent?',
                'desc' => 'If you check this option, Menu will has fixed layout'
            ),
            array(
                'name' => 'header_layout_images',
                'type' => 'end_group'
            ),
            // Title options
            array(
                'name' => 'hidetitle',
                'type' => 'checkbox',
                'label' => 'Hide page title?',
                'desc' => 'May be you need to hide title area for a reason specially if you include this page on "One page".'
            ),
            array(
                'name' => 'title_layout_switch',
                'type' => 'start_group',
                'visible' => true
            ),
            array(
                'name' => 'title_space',
                'type' => 'number',
                'label' => 'Title Area Spacing',
                'default' => isset($smof_data['title_space']) ? $smof_data['title_space'] : 40,
                'desc' => 'Page Title Sections padding-top, padding-bottom size'
            ),
            array(
                'name' => 'title_bgcolor',
                'type' => 'colorpicker',
                'label' => 'Title Background Color',
                'default' => isset($smof_data['title_bg_color']) ? $smof_data['title_bg_color'] : '#00b4cc',
                'desc' => 'Page Title Section Background Color'
            ),
            array(
                'name' => 'title_bg_image',
                'type' => 'image',
                'label' => 'Title Background Image',
                'default' => '',
                'desc' => 'If you want to show your title area beautiful, this option exactly you need.'
            ),
            array(
                'name' => 'title_bg_cover',
                'type' => 'checkbox',
                'label' => 'Background image cover?',
                'desc' => 'You don\'t wanna repeat your BG image there. It is efficient and looks good without stretch If your selected image is bigger enough to cover the area.'
            ),
            array(
                'name' => 'title_bg_repeat',
                'type' => 'select',
                'label' => 'Background Repeat',
                'default' => 'repeat',
                'option' => array(
                    'repeat' => 'Repeat',
                    'repeat-x' => 'Repeat-X',
                    'repeat-y' => 'Repeat-Y',
                    'no-repeat' => 'No Repeat'
                )
            ),
            array(
                'name' => 'title_bg_position',
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
                )
            ),
            array(
                'name' => 'title_bg_fixed',
                'type' => 'select',
                'label' => 'Background Attachment Type',
                'desc' => '',
                'default' => 'scroll',
                'option' => array(
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed'
                )
            ),
            array(
                'name' => 'title_layout_switch',
                'type' => 'end_group'
            ),
            // Content area options
            array(
                'name' => 'general_color',
                'type' => 'colorpicker',
                'label' => 'Content BG Color',
                'default' => isset($smof_data['content_bg_color']) ? $smof_data['content_bg_color'] : '#ffffff',
                'option' => array(
                    'val' => 'label'
                )
            ),
            array(
                'name' => 'bg_image',
                'type' => 'image',
                'label' => 'Content Background image',
                'default' => '',
                'desc' => 'Background image for page content'
            ),
            array(
                'name' => 'bg_cover',
                'type' => 'checkbox',
                'label' => 'Background image cover?',
                'desc' => 'You don\'t wanna repeat your BG image there. It is efficient and looks good without stretch If your selected image is bigger enough to cover the area.'
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
                )
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
                )
            ),
            array(
                'name' => 'bg_fixed',
                'type' => 'select',
                'label' => 'Background Attachment Type',
                'default' => 'scroll',
                'desc' => 'Controls how your background image affect when you scroll up & down. If you select here <b>Parallax</b> value, background image moves beautiful motion.',
                'option' => array(
                    'scroll' => 'Scroll',
                    'fixed' => 'Fixed',
                    'parallax' => 'Parallax'
                )
            ),
            array(
                'name' => 'hidefooter',
                'type' => 'checkbox',
                'label' => 'Hide page footer?',
            ),
            array(
                'name' => 'hidesubfooter',
                'type' => 'checkbox',
                'label' => 'Hide page sub footer?',
            ),
            // Close option group division
            array(
                'name' => 'customize_page',
                'type' => 'end_group',
            ),
        )
    )
);

$tt_post_meta = array_merge($tt_post_meta, $tmp_arr);
?>