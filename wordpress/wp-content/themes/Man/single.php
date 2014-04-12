<?php
get_header();

while (have_posts()) : the_post();

    global $smof_data, $layout_sidebar;
    
    // Sidebar position
    $layout_sidebar = tt_getmeta('page_layout');
    $layout_class = $layout_sidebar == 'full' ? 'col-xs-12 col-md-12 col-lg-12 col-sm-12' : 'col-xs-12 col-md-9 col-lg-9 col-sm-8';
    if ($layout_sidebar == 'left') {
        $layout_class .= ' pull-right';
    }
    
    ?>
    <!-- Start Feature -->
    <div id="feature" class="<?php text_brightness_indicator(); ?>">

        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-9 col-sm-12">
                    <h1 class="page_title"><?php the_title(); ?></h1>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-3 col-sm-12">
                    <?php tt_breadcrumbs(); ?>
                </div>
            </div>
        </div>
        <!-- End Container -->

    </div>
    <!-- End Feature -->
    <!-- Start Content -->
    <section id="content" class="<?php text_brightness_indicator('content'); ?>">
        <!-- Start Container -->
        <div class="container">
            <div class="row">

                <div class="<?php echo $layout_class; ?>">
                    <div id="primary" class="content left_content">

                        <article itemscope="" itemtype="http://schema.org/BlogPosting" class="entry <?php echo format_class(get_the_ID()); ?> blog_medium medium_top_image clearfix">
                            
                            <?php
                            
                            // Post format content printing
                            if($smof_data['show_post_format'] == 1 && tt_getmeta('hidefeaturedimg') != 1) {
                                if(in_array(get_post_format(), array('image', 'audio', 'video'))) {
                                    call_user_func('blox_format_'.get_post_format());
                                }
                                else{
                                    echo hover_featured_image(get_the_ID(), '', false, 868);
                                }       
                            }
                            ?>
                            <div class="entry_meta">
                                <ul class="top_meta">
                                    <li class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></li>
                                    <li itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . get_the_category_list(', '); ?></li>
                                    <li><?php edit_post_link(__('Edit', 'themeton'), '<span class="edit-link">', '</span>'); ?></li>
                                </ul>
                                <ul class="bottom_meta">
                                    <li itemprop="dateCreated"class="meta_date"><i class="icon-time"></i> <?php echo __("", "themeton") . date_i18n("M j, Y", strtotime(get_the_date())); ?></li>
                                    <li itemprop="comment"class="meta_comment"><i class="icon-comment"></i> <?php echo __("", "themeton") . comment_count(); ?></li>
                                    <li class="meta_like"><a href="javascript:;" pid="<?php echo get_the_ID(); ?>" class="<?php echo blox_post_liked(get_the_ID()); ?>"><i class="icon-heart"></i> <span><?php echo (int)blox_getmeta(get_the_ID(), 'post_like'); ?></span></a></li>
                                </ul>
                                <a href="<?php echo get_post_format_link(get_post_format(get_the_ID()));?>" title="<?php echo ucfirst(get_post_format()) .' '. __('posts', 'themeton'); ?>" class="entry_format"></a>
                            </div>
                            <div class="entry_content">
                                <?php the_content(); 
                                    // WP pages
                                    wp_link_pages(array(
                                        'before' => '<div class="page-link"><span>' . __('Pages:', 'themeton') . '</span>',
                                        'after' => '</div>',
                                        'link_before' => '<span>',
                                        'link_after' => '</span>'
                                    ));
                                ?>
                            </div>
                            <?php if ($smof_data['post_author'] == 1)
                                about_author();
                            ?>
                            <div class="single_footer">
                                <div class="row">
                                    <div class="col-xs-12 col-xxs-6 col-sm-6 col-md-6 col-lg-6">
                                        <?php
                                        if ($smof_data['share_posts'] == 1)
                                            social_share();
                                        ?>
                                    </div>
                                    <div class="col-xs-12 col-xxs-6 col-sm-6 col-md-6 col-lg-6">
                                        <span class="sf_text"><?php 
                                        $tags_list = get_the_tag_list('', ' ');
                                        if ($tags_list)
                                            _e('Tagged:', 'themeton'); ?></span>
                                        <div class="post_tags">
                                            <div class="tagcloud">
                                                <?php
                                                if ($tags_list)
                                                    printf(__('%2$s', 'themeton'), '', $tags_list);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php 
                        
                        // Next Preview post links
                        if($smof_data['next_prev_links'] == 1) { ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="prev_post"><?php previous_post_link('%link', __('<i class="icon-arrow-left"></i> %title', 'themeton')); ?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 align_right">
                                <div class="next_post"><?php next_post_link('%link', __('%title <i class="icon-arrow-right"></i>', 'themeton')); ?></div>
                            </div>
                        </div>
                        <?php }
                        
                        // Related posts
                        if($smof_data['related_posts'] == 1) {
                            tt_related_posts();                        
                        }                        
                        
                        // Post comment
                        if ($smof_data['post_comment'] == 1){
                            comments_template('', true);
                        }
                        ?>
                    </div><!-- end #primary -->
                </div><!-- end grid -->

            <?php
            if ($layout_sidebar != 'full') {
                if ($layout_sidebar == 'left')
                    get_sidebar('left');
                else
                    get_sidebar();
            }
            ?>
            </div><!-- end row -->
        </div><!-- end container -->
    </section>

    <?php
endwhile; // end of the loop.   
get_footer();
?>