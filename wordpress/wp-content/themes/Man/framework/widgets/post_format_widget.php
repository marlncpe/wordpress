<?php

class tt_PostFormatsWidget extends WP_Widget {

    function tt_PostFormatsWidget() {
        $widget_ops = array('classname' => 'ttpostformatswidget', 'description' => 'Post formats list with post count.');
        parent::WP_Widget(false, ': Post Formats', $widget_ops);
    }

    function widget($args, $instance) {
        global $post;
        extract(array_merge(array(
                    'title' => '',
                        ), $instance));

        if (isset($before_widget))
            echo $before_widget;

        echo '<div id="widget_tt_recent_posts" class="widget tt_post_widget tt_most_commented">';

        if ($title != '')
            echo $args['before_title'] . $title . $args['after_title'];

        $post_formats = get_theme_support('post-formats');
        if (is_array($post_formats[0])) {
            echo '<ul>';
            foreach ($post_formats[0] as $format) {
                echo '<li class="clearfix format_' . $format . '">';
                echo '<span class="tt_widget_thumb"><span class="entry_format"></span></span>';
                echo '<a href="' . get_post_format_link($format) . '" class="widget_post_title">' . $format . '</a>';
                $args = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => 'post-format-' . $format,
                        )
                    )
                );
                $result = new WP_Query($args);
                echo '<ul>
                    <li class="tt_widget_comments_number"><a href="#" title=""><i class="icon-pencil"></i> ' . $result->post_count . ' '. __('posts','themeton'). '</a></li>
                  </ul>';
                echo '</li>';
                wp_reset_query();
            }
            echo '</ul>';
        }
        echo '</div>';
        if (isset($after_widget))
            echo $after_widget;

        wp_reset_query();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form($instance) {

        //Output admin widget options form
        extract(shortcode_atts(array(
                    'title' => '',
                    'thumb' => 'thumb',
                    'number_posts' => 5,
                        ), $instance));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title:", "themeton"); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
        <?php
    }

}

add_action('widgets_init', create_function('', 'return register_widget("tt_PostFormatsWidget");'));
