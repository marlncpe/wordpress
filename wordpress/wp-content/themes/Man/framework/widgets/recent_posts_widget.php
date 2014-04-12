<?php

class tt_RecentPostsWidget extends WP_Widget {

    function tt_RecentPostsWidget() {
        $widget_ops = array('classname' => 'ttrecentpostswidget', 'description' => 'Advanced recent posts.');
        parent::WP_Widget(false, ': Recent Posts', $widget_ops);
    }

    function widget($args, $instance) {
        global $post;
        extract(array_merge(array(
                    'title' => '',
                    'number_posts' => 4,
                    'thumb' => 'thumb',
                        ), $instance));

        $q['posts_per_page'] = $number_posts;
        $q['ignore_sticky_posts'] = 1;

        query_posts($q);

        if (isset($before_widget))
            echo $before_widget;

        echo '<div id="widget_tt_recent_posts" class="widget tt_post_widget tt_most_commented">';

        if ($title != '')
            echo $args['before_title'] . $title . $args['after_title'];

        echo '<ul>';
        while (have_posts()) : the_post();
            echo '<li class="clearfix '.format_class(get_the_ID()).'">';
            $comments = wp_count_comments($post->ID);
            if($thumb == 'date') {
                echo '<span class="tt_widget_thumb">
                    <span class="day">'.get_the_date('d').'</span>
                    <span class="month">'.date_i18n( 'M',  strtotime( get_the_date( "Y-m-d" ) ) ).'</span>
                </span>';
            } else {
                echo '<span class="tt_widget_thumb">';
                if(has_post_thumbnail()) {
                    the_post_thumbnail('thumb');
                } else {
                    echo '<span class="entry_format"></span>';
                }
                echo '</span>';
            }
            echo '<a href="'.get_permalink().'" class="widget_post_title">'.get_the_title().'</a>';
            echo '<ul>
                    <li class="tt_widget_comments_number"><a href="#" title=""><i class="icon-comments"></i> '.$comments->total_comments.'</a></li>
                    <li class="tt_widget_likes_number meta_like"><a href="javascript:;" pid="'.get_the_ID().'" class="'.blox_post_liked(get_the_ID()).'"><i class="icon-heart"></i> <span>'.(int)blox_getmeta(get_the_ID(), 'post_like').'</span></a></li>
                  </ul>';
            echo '</li>';
        endwhile;
        echo '</ul>';
        echo '</div>';
        
        if (isset($after_widget))
            echo $after_widget;

        wp_reset_query();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['thumb'] = strip_tags($new_instance['thumb']);

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
        <p>
            <label for="<?php echo $this->get_field_id('thumb'); ?>">Post thumbnail or date:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('thumb'); ?>" name="<?php echo $this->get_field_name('thumb'); ?>">
                <option value="thumb" <?php
        if ($thumb == 'thumbnail')
            print 'selected="selected"';
        ?>>Post thumbnail image</option>
                <option value="date" <?php
        if ($thumb == 'date')
            print 'selected="selected"';
        ?>>Post date</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number_posts'); ?>">Number of posts to show:</label>
            <input type="text" id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" value="<?php echo $number_posts; ?>" size="3" />
        </p>
        <?php
    }

}

add_action('widgets_init', create_function('', 'return register_widget("tt_RecentPostsWidget");'));
