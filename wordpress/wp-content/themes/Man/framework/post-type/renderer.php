<?php

add_action('admin_enqueue_scripts', 'admin_option_render_scripts');

function admin_option_render_scripts($hook) {
    global $post_type;
    if ($post_type == '' || $post_type == NULL) {
        return;
    }
    wp_enqueue_style('tt_admin_option_style', get_template_directory_uri() . '/framework/post-type/renderer.css');
    wp_enqueue_script('tt_admin_option_script', get_template_directory_uri() . '/framework/post-type/renderer.js', false, false, true);
}

add_action('admin_init', 'themeton_admin_option_add_custom_box', 1);

function themeton_admin_option_add_custom_box() {
    global $tt_post_meta;
    foreach ($tt_post_meta as $key => $value) {
        $position = 'advanced';
        $priority = 'core';
        if ($value['post_type'] == 'post') {
            $position = 'advanced';
            $priority = 'high';
        }
        add_meta_box(
                'pmeta_' . $key, __($value['label'], 'themeton'), 'themeton_ao_render_section', $value['post_type'], $position, 'core', $value['items']
        );
    }
}

function themeton_ao_render_section($post, $metabox) {
    global $post;
    foreach ($metabox['args'] as $value) {
        
        if ($value['type'] == 'start_group') {
            $style = '';
            if(isset($value['visible']) && $value['visible'] == false){
                $style = 'style="display:none;"';
            }
            echo '<div id="'.$value['name'].'" class="'.$value['name'].'" '.$style.'>';
        }
        elseif ($value['type'] == 'end_group') {
            echo '</div><!-- #'.$value['name'].' -->';
        }
        else {
            echo "<div id='option_wrapper_" . $value['name'] . "' class='page_option_fieldset'>";
            if( isset($value['label']) && $value['label'] != '' && !in_array($value['type'], array('checkbox', 'colorpicker', 'number')) ){
                echo "<div><label for='" . $value['name'] . "'>" . $value['label'] . "</label></div>";
            }
            echo "<div>";
                if( isset($value['fullwidth']) ){
                    echo "<div class='page_option_field_full'>".themeton_ao_get_field($value)."</div>";
                }
                else{
                    echo "<div class='page_option_field'>".themeton_ao_get_field($value)."</div>";
                    if(isset($value['desc'])) {
                        echo '<div class="field_description">'.$value['desc'].'</div>';
                    }
                }
            echo "</div>";
            echo "<div style='clear:both;'></div></div>";
        }
    }
}

function themeton_ao_get_field($params) {
    global $post;
    $name = $params['name'];
    $type = $params['type'];
    $meta_val = tt_getmeta($params['name'], $post->ID);

    $default = isset($params['default']) ? $params['default'] : '';
    $value = $meta_val != '' ? $meta_val : $default;
    if (isset($params['option']))
        $option = $params['option'];

    $gatts = 'id="' . $name . '" name="' . $name . '"';



    switch ($type) {
        case 'title':
            return '<span style="font-weight: bold;font-size:14px;background-color: #4cd864;display: inline-block;padding:7px;border-radius: 3px;color: #fff;">' . $params['title'] . '</span>';
            break;
        case 'colorpicker':
            return '<input type="text" ' . $gatts . ' value="' . $value . '" class="tt_wpcolorpicker" data-default-color="' . $default . '" />
                    <label for="' . $params['name'] . '">' . $params['label'] . '</label>';
            break;
        case 'text':
            return '<input type="text" ' . $gatts . ' value="' . $value . '" />';
            break;
        case 'number':
            return '<input type="number" ' . $gatts . ' step="1" min="0" value="' . (int)$value . '" class="small-text" />
                    &nbsp;&nbsp;<label for="' . $params['name'] . '">' . $params['label'] . '</label>';
            break;
        case 'textarea':
            return '<textarea ' . $gatts . '>' . $value . '</textarea>';
            break;
        case 'select':
            $html = '<select ' . $gatts . ' default-value="' . $value . '" class="tt_wpselectbox">';
            foreach ($option as $key => $val) {
                $html .= '<option value="' . $key . '">' . $val . '</option>';
            }
            $html .= '</select>';
            return $html;
            break;
        case 'radio':
            $html = '';
            foreach ($option as $key => $val) {
                $html .= '<input type="radio" group="tt_group_' . $name . '" ' . $gatts . ' class="tt_wpradiobox" ' . ($value == $key ? 'checked' : '') . '>';
                $html .= $val . '<br>';
            }
            return $html;
            break;
        case 'icon':
            $html = '';
            foreach ($option as $key => $val) {
                $html .= '<input type="radio" group="tt_group_' . $name . '" ' . $gatts . ' class="tt_wpradiobox" ' . ($val == $key ? 'checked' : '') . '>';
                $html .= $val;
                if ($key == 'custom')
                    $html .= '<input type="text" value""/>';
                $html .= '<br>';
            }
            return $html;
            break;
        case 'thumbs':
            $html = '';
            $ndx = 0;
            foreach ($option as $key => $val) {
                $ndx++;
                $html .= '<input type="radio" group="tt_group_' . $name . '" name="' . $name . '" id="' . $name . $ndx . '" value="' . $key . '" class="tt_wpradiobox" ' . ($key == $value ? 'checked' : '') . '>';
                $html .= '<label for="' . $name . $ndx . '"><img src="' . $val . '" class="'.($key == $value ? 'active' : '').'" /></label>';
            }
            return "<div class='page_option_field_thumbs'>$html</div>";
            break;
        case 'image':
            $html = '';
            $html .= '<div class="pmeta_item_browse">
                            <input type="text" ' . $gatts . ' value="' . $value . '" />
                            <a href="javascript:;" class="button pmeta_button_browse">Browse...</a>
                            <div class="browse_preview">' . ($value != '' ? '<img src="' . $value . '" /><a href="javascript:;">Remove</a>' : '') . '</div>
                    </div>';
            return $html;
            break;
        case 'metro':
            $html = '<div id="metro_style_container">
                            <a href="javascript:;" class="small1"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/small-icon-title.png" /></a>
                            <a href="javascript:;" class="small2"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/small-title.png" /></a>
                            <a href="javascript:;" class="small3"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/small-image.png" /></a>
                            <a href="javascript:;" class="small4"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/small-icon.png" /></a>
                            <a href="javascript:;" class="hor1"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/big-icon-title.png" /></a>
                            <a href="javascript:;" class="hor2"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/big-icon.png" /></a>
                            <a href="javascript:;" class="hor3"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/big-image.png" /></a>
                            <a href="javascript:;" class="hor4"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/big-title.png" /></a>
                            <a href="javascript:;" class="large1"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-icon-title.png" /></a>
                            <a href="javascript:;" class="large2"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-icon.png" /></a>
                            <a href="javascript:;" class="large3"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-image-stitle.png" /></a>
                            <a href="javascript:;" class="large4"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-image-title.png" /></a>
                            <a href="javascript:;" class="large5"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-image.png" /></a>
                            <a href="javascript:;" class="large6"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-title.png" /></a>
                            <a href="javascript:;" class="ver1"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-ver-title.png" /></a>
                            <a href="javascript:;" class="ver2"><img src="' . get_template_directory_uri() . '/framework/post-type/images/post-format/large-ver-icon.png" /></a>
                    </div>';

            $html .= '<input type="hidden" ' . $gatts . ' value="' . $value . '" />';
            return $html;
            break;
        case 'font_icon':
            $html = '';
            $html .= '<div class="pmeta_item_font">
                                <input type="text" ' . $gatts . ' value="' . $value . '" />
                                <a href="javascript:;" class="button pmeta_button_font">Font Icon...</a>
                        </div>';
            return $html;
            break;
        case 'onepage':
            $html = '';

            $html .= '<select id="onpage_allpages">';
            $html .= '<option value="0">' . __('Choose page...', 'themeton') . '</option>';
            $pages = get_pages();
            foreach ($pages as $page) {
                $html .= '<option value="' . $page->ID . '" data-link="' . get_permalink($page->ID) . '">' . $page->post_title . '</option>';
            }
            $html .= '</select>';
            $html .= '&nbsp;&nbsp;<a href="javascript:;" class="button" id="button_onepage_add">Add Page</a>';
            $html .= '&nbsp;&nbsp;<a href="javascript:;" class="button" id="button_op_custom_link">Custom Link</a>';

            $html .= '<div id="onepage_container"></div>';

            $html .= '<input type="hidden" ' . $gatts . ' value="' . $value . '" />';
            return $html;
            break;
        case 'checkbox':
            return '<span class="blox_switcher '.($value == '1' ? 'on' : '').'">
                        <span class="handle"></span>
                        <input type="hidden" ' . $gatts . ' value="' . ($value == '1' ? '1' : '0') . '" />
                    </span>
                    <label for="' . $params['name'] . '">' . $params['label'] . '</label>';
            break;
            /*
            return '<span>
                        <input type="hidden" ' . $gatts . ' value="' . ($value == '1' ? '1' : '0') . '" class="pohcheck" />
                        <input type="checkbox" id="' . $name . '_chbox"  value="1" ' . ($value == '1' ? 'checked="checked"' : '') . ' onclick="if(this.checked){ jQuery(this).parent().find(\'.pohcheck\').val(1); }else{ jQuery(this).parent().find(\'.pohcheck\').val(0); }" />
                    </span>
                    <label for="' . $params['name'] . '_chbox">' . $params['label'] . '</label>';
            break;
            */
        case 'customlink':
            return '<input type="text" ' . $gatts . ' value="' . $value . '" /><input type="checkbox" value="1"/> Open in a new tab?';
            break;     
        default:
            return "Option doesn't prepared!";
            break;
    }
}

// Save fields data
add_action('save_post', 'tt_admin_option_save_postdata');

function tt_admin_option_save_postdata($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    if (isset($_GET['post_type']) && 'page' == $_GET['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    }
    else {
        if (!current_user_can('edit_post', $post_id))
            return $post_id;
    }

    $field_name = array();
    global $tt_post_meta;
    foreach ($tt_post_meta as $key => $value) {
        foreach ($value['items'] as $item) {
            $field_name[] = $item['name'];
        }
    }


    foreach ($field_name as $field) {
        if (isset($_POST[$field])) {
            $data_field = '_' . $field;
            $data_value = $_POST[$field];

            if (count(get_post_meta($post_id, $data_field)) == 0) {
                add_post_meta($post_id, $data_field, trim($data_value), true);
            } elseif ($data_value != get_post_meta($post_id, $data_field, true)) {
                update_post_meta($post_id, $data_field, trim($data_value));
            } elseif ($data_value == "") {
                delete_post_meta($post_id, $data_field, trim(get_post_meta($post_id, $data_field, true)));
            }
        }
    }
}

?>