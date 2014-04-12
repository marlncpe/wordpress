<?php
get_header();

while (have_posts()) : the_post();

    global $smof_data, $layout_sidebar;

    // Title BG color style
    $titlebg = tt_page_title_bg_color();

    // Content BG color style
    $contentbg = tt_page_content_bg_color();

    $headerbclass = 'dark';
    $contentbclass = '';
    if($titlebg != '') {
        $headerbclass = get_text_class(tt_getmeta('title_bgcolor'));
    }
    else if( isset($smof_data['title_bg_color']) ){
        $headerbclass = get_text_class($smof_data['title_bg_color']);
    }

    if($contentbg != '') {
        $contentbclass = get_text_class(tt_getmeta('general_color'));
    }

    // Sidebar postion
    $layout_sidebar = tt_getmeta('page_layout');
    
    // Layout class
    $layout_class = $layout_sidebar == 'full' ? 'col-xs-12 col-md-12 col-lg-12 col-sm-12' : 'col-xs-12 col-md-9 col-lg-9 col-sm-8';
    if ($layout_sidebar == 'left') {
        $layout_class .= ' pull-right';
    }

    // Page teaser text
    $teaser = tt_getmeta('teaser');

    // Page background image style
    $bg_style = tt_page_content_bg_image($contentbg);

    if(tt_getmeta('hidetitle') != '1') {
    ?>
    <!-- Start Feature -->
    <div id="feature" class="<?php echo $headerbclass!='' ? $headerbclass : text_brightness_indicator(); ?>" <?php echo $titlebg; ?>>

        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-9 col-sm-12">
                    <h1 class="page_title"><?php the_title(); ?></h1>
                    <?php if ($teaser != '') { ?>
                    <div class="page_teaser"><?php echo do_shortcode($teaser); ?></div>
                    <?php } ?>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-3 col-sm-12">
                    <?php tt_breadcrumbs(); ?>
                </div>
            </div>
        </div>
        <!-- End Container -->

    </div>
    <!-- End Feature -->
    <?php } // Hide title ?>
    
    <!-- Start Content -->
    <section id="content" class="<?php echo $contentbclass; ?>" <?php echo $bg_style; ?>>
        <!-- Start Container -->
        <div class="container">
            <div class="row">

                <div class="<?php echo $layout_class; ?>">
                    <div id="primary" class="content left_content">

                        <article itemscope="" itemtype="http://schema.org/BlogPosting" class="entry portfolio portfolio_big clearfix">

                            <?php
                            if(isset($smof_data['port_hide_featured_img']) && $smof_data['port_hide_featured_img'] != 1) {
                                echo hover_featured_image(get_the_ID(), '', false, 868);
                            }
                            ?>

                            <div class="entry_content">
                                <?php
                                the_content();
                                // WP pages
                                wp_link_pages(array(
                                    'before' => '<div class="page-link"><span>' . __('Pages:', 'themeton') . '</span>',
                                    'after' => '</div>',
                                    'link_before' => '<span>',
                                    'link_after' => '</span>'
                                ));
                                ?>
                            </div>
                            <?php
                            if ($smof_data['port_author'] == 1)
                                about_author();
                            ?>
                            <div class="single_footer">
                                <div class="row">
                                    <div class="col-xs-12 col-xxs-8 col-sm-6 col-md-6 col-lg-6">
                                        <?php
                                        if ($smof_data['share_port'] == 1)
                                            social_share();
                                        ?>
                                    </div>
                                    <div class="col-xs-12 col-xxs-4 col-sm-6 col-md-6 col-lg-6">
                                        <?php
                                        // Next Preview post links
                                        if ($smof_data['port_next_prev_links'] == 1) {
                                            ?>
                                            <div class="next_prev_projects">
                                                <ul class="next_prev_list inline_list">
                                                    <li><?php previous_post_link('%link', __('<i class="icon-chevron-left"></i>', 'themeton')); ?></li>
                                                    <?php if ($smof_data['portfolio_page'] && $smof_data['portfolio_page'] != 'Select a page:') : ?>
                                                        <li><a href="<?php echo get_permalink(get_page_by_path($smof_data['portfolio_page'])); ?>"><i class="icon-th"></i></a></li>
                                                    <?php endif; ?>
                                                    <li><?php next_post_link('%link', __('<i class="icon-chevron-right"></i>', 'themeton')); ?></li>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php
                        // Post comment
                        if ($smof_data['post_comment'] == 1) {
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