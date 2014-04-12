<?php

/*
  Plugin Name: Blox Page Builder inside Mana
  Plugin URI: http://www.themeton.com/blox-pagebuilder
  Description: Play Web Elements
  Version: 1.0
  Author: Themeton
  Author URI: http://themeton.com
 */

define('BLOX_PATH', trailingslashit(get_template_directory_uri()).'framework/Pagebuilder/');

require_once 'inc/common_functions.php';
require_once 'inc/metro_content.php';
require_once 'inc/loop_layouts.php';
require_once 'inc/blox_aq_resizer.php';
require_once 'render.php';



add_action('wp_enqueue_scripts', 'blox_frontend_scripts');

function blox_frontend_scripts() {
    
    // Import all Frontend CSS
    /*
    $cssFiles = array(
        BLOX_PATH.'css/font-awesome.min.css',
        BLOX_PATH.'css/bootstrap-grid.css',
        BLOX_PATH.'css/prettyPhoto.css',
        BLOX_PATH.'css/device-mockups/device-mockups.css',
        BLOX_PATH.'css/device-mockups/device-mockups2.css',
        BLOX_PATH.'css/blox-frontend.css',
        BLOX_PATH.'css/blox-buttons.css',
        BLOX_PATH.'css/blox-icons.css',
        BLOX_PATH.'css/blox-callouts.css',
        BLOX_PATH.'css/blox-content-box.css',
        BLOX_PATH.'css/blox-notification-box.css',
        BLOX_PATH.'css/blox-placeholder.css',
        BLOX_PATH.'css/blox-image-frame.css',
        BLOX_PATH.'css/blox-audio.css',
        BLOX_PATH.'css/blox-price-table.css',
        BLOX_PATH.'css/blox-colors.css',
        BLOX_PATH.'css/blox-blog.css',
        BLOX_PATH.'css/blox-animations.css'
    );
    $minify = new TTMinify();
    $minify->minify_style($cssFiles);
    */
    wp_enqueue_style('blox-style', BLOX_PATH.'css/');

    
    wp_enqueue_script('jquery');

    /*
    $jsFiles = array(
        BLOX_PATH.'js/jquery.cycle2.min.js',
        BLOX_PATH.'js/jplayer/jquery.jplayer.min.js',
        BLOX_PATH.'js/jquery.prettyPhoto.js',
        BLOX_PATH.'js/waypoints.min.js',
        BLOX_PATH.'js/knob.js',
        BLOX_PATH.'js/jquery.easypiechart.min.js',
        BLOX_PATH.'js/blox-frontend.js'
    );
    $minify->minify_script($jsFiles);
    */
    wp_enqueue_script('blox-script', BLOX_PATH.'js/', false, false, true);

}

function blox_wp_head() {
    echo '<script>
                var blox_plugin_path = "' . BLOX_PATH . '";
            </script>';
}

add_action('wp_head', 'blox_wp_head');


//Admin menu
add_action('admin_menu', 'blox_admin_menu');
function blox_admin_menu() {
    //add_menu_page('Blox Settings', 'Blox Settings', 'manage_options', 'blox_settings', 'render_blox_settings');
}

function render_blox_settings() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'themeton'));
    }

    echo '<div class="wrap">';
    echo '<div id="icon-options-general" class="icon32"><br></div>';
    echo '<h2>Blox Settings</h2>';

    echo '<br>';

    echo '<form id="blox_settings_form" method="post" action="' . site_url() . '/wp-admin/admin-ajax.php?action=save_blox_settings">';
    echo '<input type="checkbox" value="post" id="checkbox_post" name="checkbox_post" ' . (get_blox_option('checkbox_post') != '' ? 'checked="checked"' : '') . ' /><label for="checkbox_post">' . __('Post', 'themeton') . '</label><br>';
    echo '<input type="checkbox" value="page" id="checkbox_page" name="checkbox_page" ' . (get_blox_option('checkbox_page') != '' ? 'checked="checked"' : '') . ' /><label for="checkbox_page">' . __('Page', 'themeton') . '</label><br>';
    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects', 'and');
    foreach ($post_types as $type) {
        echo '<input type="checkbox" value="' . $type->name . '" id="checkbox_' . $type->name . '" name="checkbox_' . $type->name . '" ' . (get_blox_option('checkbox_' . $type->name) != '' ? 'checked="checked"' : '') . ' /><label for="checkbox_' . $type->name . '">' . __($type->labels->name) . '</label><br>';
    }
    echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
    echo '</form>';

    echo '</div>';
}

if (isset($_GET['page']) && $_GET['page'] == 'blox_settings') {
    add_action('admin_enqueue_scripts', 'blox_settings_scripts');

    function blox_settings_scripts() {

        wp_enqueue_style('blox_settings_style', BLOX_PATH.'css/settings.css');

        wp_enqueue_script('jquery');
        wp_enqueue_script('blox_settings_script', BLOX_PATH.'js/settings.js', false, false, true);
    }

}



add_action('wp_ajax_save_blox_settings', 'save_blox_settings');
add_action('wp_ajax_nopriv_save_blox_settings', 'save_blox_settings');

// save settings form date
function save_blox_settings() {
    try {
        $form_data = $_POST;
        update_blox_settings(json_encode($form_data));
        echo "1";
    } catch (Exception $e) {
        echo "-1";
    }
    exit;
}

// update settings values
function update_blox_settings($param) {
    $settings = array();
    $settings['blox_settings_data'] = $param;
    update_option('blox_settings_data_group', $settings);
}

function get_blox_option($param) {
    $value = "";
    try {
        $option = get_option('blox_settings_data_group');
        $json = json_decode($option['blox_settings_data'], true);
        if (isset($json[$param])) {
            $value = $json[$param];
        }
    } catch (Exception $e) {
        
    }
    return $value;
}

/*
 * BLOX TEMPLATE SAVE
 */

function blox_get_template() {
    $templates = array();
    $option = get_option('blox_settings_data_group');
    if ($option && isset($option['blox_templates']) && json_decode($option['blox_templates'], true)) {
        $templates = json_decode($option['blox_templates'], true);
    }
    return $templates;
}

add_action('wp_ajax_blox_template_save', 'blox_template_save_hook');
add_action('wp_ajax_nopriv_blox_template_save', 'blox_template_save_hook');

function blox_template_save_hook() {
    try {
        $uid = uniqid();
        $template = array(
            array(
                'id' => $uid,
                'title' => $_POST['title'],
                'content' => $_POST['content']
            )
        );
        $option = get_option('blox_settings_data_group');

        $templates = blox_get_template();
        $templates = array_merge($templates, $template);

        $json_template = json_encode($templates);
        $option['blox_templates'] = $json_template;
        update_option('blox_settings_data_group', $option);

        $arr = array();
        foreach ($templates as $tmp) {
            $new_temp = $tmp;
            $new_temp['content'] = '';
            $arr[] = $new_temp;
        }

        echo json_encode($arr);
    } catch (Exception $e) {
        echo "-1";
    }
    exit;
}

add_action('wp_ajax_blox_template_remove', 'blox_template_remove_hook');
add_action('wp_ajax_nopriv_blox_template_remove', 'blox_template_remove_hook');

function blox_template_remove_hook() {
    try {
        $templates = blox_get_template();
        $new_template = array();
        foreach ($templates as $template) {
            if ($template['id'] != $_POST['id']) {
                $new_template[] = $template;
            }
        }
        $option = get_option('blox_settings_data_group');
        $json_template = json_encode($new_template);
        $option['blox_templates'] = $json_template;
        update_option('blox_settings_data_group', $option);

        $arr = array();
        foreach ($new_template as $tmp) {
            $new_temp = $tmp;
            $new_temp['content'] = '';
            $arr[] = $new_temp;
        }

        echo json_encode($arr);
    } catch (Exception $e) {
        echo "-1";
    }
    exit;
}

add_action('wp_ajax_blox_template_load', 'blox_template_load_hook');
add_action('wp_ajax_nopriv_blox_template_load', 'blox_template_load_hook');

function blox_template_load_hook() {
    try {
        $content = '';
        $templates = blox_get_template();
        foreach ($templates as $template) {
            if ($template['id'] == $_POST['id']) {
                $content = stripslashes($template['content']);
            }
        }
        echo $content;
    } catch (Exception $e) {
        echo "-1";
    }
    exit;
}

?>