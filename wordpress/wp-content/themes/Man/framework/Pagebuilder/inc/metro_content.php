<?php

function get_metro_content() {
    global $post;

    $default_data = array();
    $default_data['post-icon'] = 'metrize-text-normal';
    $default_data['post-image-icon'] = 'metrize-landscape';
    $default_data['post-gallery-icon'] = 'metrize-copy-paste-document';
    $default_data['post-link-icon'] = 'metrize-arrow-curve-left';
    $default_data['post-video-icon'] = 'metrize-play';
    $default_data['post-audio-icon'] = 'metrize-music';
    $default_data['post-chat-icon'] = 'metrize-comments';
    $default_data['post-status-icon'] = 'metrize-comment';
    $default_data['post-quote-icon'] = 'metrize-quote';
    $default_data['post-aside-icon'] = 'metrize-three-points';

    $default_data['color'] = '#ffcc00';
    $default_data['metro'] = 'small1';

    $post_format = tt_getmeta('post_format');
    $post_format = get_post_format() ? get_post_format() : tt_getmeta('post_format');

    $color = tt_getmeta('color');
    $color = $color != '' ? $color : $default_data['color'];

    $icon = tt_getmeta('post_icon');
    $icon = $icon != '' ? $icon : $default_data['post' . ($post_format != '' ? '-' . $post_format : '') . '-icon'];

    $metro = tt_getmeta('metro_style');
    $metro = $metro != '' ? $metro : $default_data['metro'];


    $text_class = get_text_class($color);
    $thumb = '';
    if (has_post_thumbnail()) {

        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'metro-small');
        $thumb = "background-image: url('$thumb[0]');";
        
        $thumb_h = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'metro-horizontal');
        $thumb_h = "background-image: url('$thumb_h[0]');";
        
        $thumb_l = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'metro-large');
        $thumb_l = "background-image: url('$thumb_l[0]');";

    }

    switch ($metro) {
        case 'small1':
            ?>
            <article class="metro_entry metro_entry_small style_one <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span aria-hidden="true" class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
        case 'small2':
            ?>
            <article class="metro_entry metro_entry_small style_two <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
        case 'small3':
            ?>
            <article class="metro_entry metro_entry_small style_two <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <span class="metro_image" style="<?php echo $thumb; ?>"></span>
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                </a>
            </article>
            <?php
            break;
        case 'small4':
            ?>
            <article class="metro_entry metro_entry_small style_three <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                </a>
            </article>
            <?php
            break;

        case 'hor1':
            ?>
            <article class="metro_entry metro_entry_horizontal style_three <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
        case 'hor2':
            ?>
            <article class="metro_entry metro_entry_horizontal style_one <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
        case 'hor3':
            ?>
            <article class="metro_entry metro_entry_horizontal style_two <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <span class="metro_image" style="<?php echo $thumb_h; ?>"></span>
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                </a>
            </article>
            <?php
            break;
        case 'hor4':
            ?>
            <article class="metro_entry metro_entry_horizontal style_two <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;

        case 'large1':
            ?>
            <article class="metro_entry metro_entry_big style_one <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
        case 'large2':
            ?>
            <article class="metro_entry metro_entry_big style_three <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                </a>
            </article>
            <?php
            break;
        case 'large3':
            ?>
            <article class="metro_entry metro_entry_big style_five <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <span class="metro_image" style="<?php echo $thumb_l; ?>"></span>
                <div class="entry_item_container clearfix" style="background-color: <?php echo $color; ?>;">
                    <a href="<?php the_permalink(); ?>">
                        <div class="entry_icon">
                            <span class="<?php echo $icon; ?>"></span>
                        </div>
                        <h2 class="entry_title"><?php the_title(); ?></h2>
                    </a>
                </div>
            </article>
            <?php
            break;
        case 'large4':
            ?>
            <article class="metro_entry metro_entry_big style_four <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <div class="metro_image_container">
                    <span class="metro_image" style="<?php echo $thumb_l; ?>"></span>
                </div>
                <div class="metro_entry metro_entry_horizontal style_two <?php echo $text_class; ?>" style="background-color: <?php echo $color; ?>;">
                    <a href="<?php the_permalink(); ?>">
                        <div class="entry_icon">
                            <span class="<?php echo $icon; ?>"></span>
                        </div>
                        <h2 class="entry_title"><?php the_title(); ?></h2>
                    </a>
                </div>
            </article>
            <?php
            break;
        case 'large5':
            ?>
            <article class="metro_entry metro_entry_big style_two <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <span class="metro_image" style="<?php echo $thumb_l; ?>"></span>
                </a>
            </article>
            <?php
            break;
        case 'large6':
            ?>
            <article class="metro_entry metro_entry_big style_two <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
        case 'large7':
            break;

        case 'ver1':
            ?>
            <article class="metro_entry metro_entry_vertical style_one <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <div class="metro_image_container">
                    <span class="metro_image" style="<?php echo $thumb; ?>"></span>
                </div>
                <div class="metro_entry_small style_two <?php echo $text_class; ?>" style="background-color: <?php echo $color; ?>;">
                    <a href="<?php the_permalink(); ?>">
                        <div class="entry_icon">
                            <span class="<?php echo $icon; ?>"></span>
                        </div>
                        <h2 class="entry_title"><?php the_title(); ?></h2>
                    </a>
                </div>
            </article>
            <?php
            break;
        case 'ver2':
            ?>
            <article class="metro_entry metro_entry_vertical style_one <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?> clearfix" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <div class="metro_image_container">
                    <span class="metro_image" style="<?php echo $thumb; ?>"></span>
                </div>
                <div class="metro_entry_small style_one <?php echo $text_class; ?>" style="background-color: <?php echo $color; ?>;">
                    <a href="<?php the_permalink(); ?>">
                        <div class="entry_icon">
                            <span class="<?php echo $icon; ?>"></span>
                        </div>
                        <h2 class="entry_title"><?php the_title(); ?></h2>
                    </a>
                </div>
            </article>
            <?php
            break;

        default:
            ?>
            <article class="metro_entry metro_entry_small style_one <?php echo $text_class.' post_filter_item '.get_post_filter_cats(); ?>" style="background-color: <?php echo $color; ?>;" post-id="<?php echo $post->ID; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="entry_icon">
                        <span aria-hidden="true" class="<?php echo $icon; ?>"></span>
                    </div>
                    <h2 class="entry_title"><?php the_title(); ?></h2>
                </a>
            </article>
            <?php
            break;
    }
}

add_action('wp_head', 'render_frontend_metro_item');

function render_frontend_metro_item() {
    echo '<script type="text/javascript">
			var metro_frontend_ajax = "' . site_url() . '/wp-admin/admin-ajax.php";
		  </script>';
}

add_action('wp_ajax_get_metro_item_content', 'get_metro_item_content_hook');
add_action('wp_ajax_nopriv_get_metro_item_content', 'get_metro_item_content_hook');

function get_metro_item_content_hook() {
    if (isset($_POST['post_id']) && (int) $_POST['post_id'] > 0) {
        //global $post;
        //$post = get_post( (int)$_POST['post_id'] );
        $args = array(
            'post_type' => 'post',
            'p' => (int) $_POST['post_id']
        );
        $the_query = new WP_Query($args);
        while ($the_query->have_posts()):
            $the_query->the_post();
            global $post;
            global $smof_data;

            $prev_link = '';
            $next_link = '';

            $prev_post = get_previous_post();
            if (!empty($prev_post)) {
                $prev_link = '<a href="' . get_permalink($prev_post->ID) . '" class="prev_post_link metro_content_control" post-id="' . $prev_post->ID . '">&#xf060;</a>';
            }

            $next_post = get_next_post();
            if (!empty($next_post)) {
                $next_link = '<a href="' . get_permalink($next_post->ID) . '" class="next_post_link metro_content_control" post-id="' . $next_post->ID . '">&#xf061;</a>';
            }

            $actions = '<div class="post_actions">
						' . $prev_link . '
						<a href="javascript:;" class="close_post_link metro_content_control">&#xf00d;</a>
						' . $next_link . '
					</div>';

            $color = tt_getmeta('color');
            $color = $color != '' ? $color : '#ffffff';
            $text_class = get_text_class($color);

            $thumb = '';
            $class_content = 'twelve';
            if (has_post_thumbnail()) {
                $class_content = 'seven';
                //$thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                $thumb = "<div class='featured_image'><img src='$thumb[0]' /></div>";
            }

            $sidebar = '<div class="block five">
		        	' . $actions . '
		        	' . $thumb . '
		        	</div>';

            echo '
			<article style="background-color:' . $color . '" class="' . $text_class . '">
				<div class="wrapper">
	                <div class="container">
	                	<div class="block ' . $class_content . '">
	                		<div class="content">
		                		<h1 class="entry_title">' . get_the_title() . '</h1>';
            ?>
            <?php the_content(); ?>
            <?php
            wp_link_pages(array(
                'before' => '<div class="page-link"><span>' . __('Pages:', 'themeton') . '</span>',
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>'
            ));
            ?>
            <div class="entry_meta">
                <?php themeton_entry_meta(); ?>
                <?php edit_post_link(__('Edit', 'themeton'), '<span class="edit_link">', '</span>'); ?>
            </div>
            <footer class="entry_meta">
                <?php if (get_the_author_meta('description') && is_multi_author()) : ?>
                    <?php get_template_part('author-bio'); ?>
                <?php endif; ?>
            </footer>
            <?php
            if (isset($smof_data['post_comment']) && $smof_data['post_comment'] == 1):
                comments_template('', true);
            endif;
            ?>
            <?php
            echo ($class_content == 'twelve' ? $actions : '') . '
			        		</div>
			        	</div>
			        	' . ($class_content != 'twelve' ? $sidebar : '') . '
	                </div>
	            </div>
            </article>';

        endwhile;
        wp_reset_postdata();
    }
    else {
        echo '-1';
    }
    exit;
}
?>