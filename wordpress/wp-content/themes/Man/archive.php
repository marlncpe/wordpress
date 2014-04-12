<?php
get_header();
global $smof_data, $layout_sidebar;

$prefix = 'archive';
if (is_category())
    $prefix = 'category';
elseif (is_tag())
    $prefix = 'tag';
elseif(is_author())
    $prefix = 'author';

$layout_container = 'col-xs-12 col-md-9 col-lg-9 col-sm-8';

$layout_sidebar = 'right';
if ($smof_data[$prefix.'_sidebar_type'] == 'left') {
    $layout_sidebar = 'left';
    $layout_container .= ' pull-right';
} elseif ($smof_data[$prefix.'_sidebar_type'] == 'full') {
    $layout_sidebar = 'full';
    $layout_container = 'col-xs-12 col-md-12 col-lg-12 col-sm-12';
}

$open_grid_container = $open_grid_pager = '';
$loop_layout = (isset($smof_data[$prefix.'_layout']) && $smof_data[$prefix.'_layout'] != '') ? $smof_data[$prefix.'_layout'] : 'regular';
if (strpos($loop_layout,'grid') !== false) {
    $open_grid_container = '<div class="grid_entry"><div class="row">';
    $open_grid_pager = '<div class="grid_pager">';
}
if (strpos($loop_layout,'masonry') !== false) {
    $open_grid_container = '<div class="grid_entry masonry"><div class="row">';
    $open_grid_pager = '<div class="grid_pager">';
}

$close_grid_container = $close_grid_pager = '';
if (strpos($loop_layout,'grid') !== false || strpos($loop_layout,'masonry') !== false) {
    $close_grid_container = '</div></div><!-- end grid_entry -->';
    $close_grid_pager = '</div><!-- .grid_pager -->';
}
?>
<!-- Start Feature -->
<div id="feature" class="<?php text_brightness_indicator('title'); ?>">

    <!-- Start Container -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-9 col-sm-12">
                <?php 
                    if (is_author()) {
                        echo '<div class="item-author clearfix">';
                        $author_email = get_the_author_meta('email');
                        echo get_avatar($author_email, $size = '60');
                        if(have_posts()) { 
                            the_post();
                            echo '<h3>'.__("Written by ", "themeton") . get_the_author().'</h3>';
                   
                            rewind_posts();
                        }
                        
                        $description = get_the_author_meta('description');
                        if ($description != '') {
                            echo '<div class="author-title-line"></div><p>';
                            echo $description;
                        } else {
                            _e('The author didnt add any Information to his profile yet', 'themeton');
                        }
                        echo '</p></div>';
                    } else {
                ?>
                <h1 class="page_title">
                    <?php
                    if (is_category()) {
                        printf(__('Category : %s', 'themeton'), single_cat_title('', false));
                    } elseif (is_tag()) {
                        printf(__('Tag Archives: %s', 'themeton'), single_tag_title('', false));
                    } elseif (is_archive()) {
                        if (is_day()) :
                            printf(__('Daily Archives: %s', 'themeton'), get_the_date());
                        elseif (is_month()) :
                            printf(__('Monthly Archives: %s', 'themeton'), get_the_date(_x('F Y', 'monthly archives date format', 'themeton')));
                        elseif (is_year()) :
                            printf(__('Yearly Archives: %s', 'themeton'), get_the_date(_x('Y', 'yearly archives date format', 'themeton')));
                        else :
                            _e('Archives', 'themeton');
                        endif;
                    }
                    ?>
                </h1>
                <?php }
                if (is_category() && category_description()) : ?>
                    <div class="page_teaser"><?php echo category_description(); ?> </div>
                <?php endif; ?>
                <?php if (is_tag() && tag_description()) : ?>
                    <div class="page_teaser"><?php echo tag_description(); ?></div>
                <?php endif; ?>            
            </div>
            <div class="col-xs-12 col-md-12 col-lg-3 col-sm-12">
                <?php tt_breadcrumbs(); ?>
            </div>
        </div><!-- end row -->
    </div><!-- End Container -->

</div><!-- End Feature -->

<!-- Start Content -->
<section id="content" class="<?php text_brightness_indicator('content'); ?>">
    <!-- Start Container -->
    <div class="container">
        <div class="row">

            <div class="<?php echo $layout_container; ?>">
                <div id="primary" class="content">
                    <?php
                    echo $open_grid_container;
                    /* Start the Loop */
                    while (have_posts()) : the_post();
                        //get_template_part('content', get_post_format()); 
                        if(function_exists('blox_loop_'.$loop_layout))
                            call_user_func('blox_loop_'.$loop_layout);
                        else
                            call_user_func('blox_loop_regular');
                    endwhile;
                    echo $close_grid_container.$open_grid_pager;                    
                    tt_paginate_links();
                    echo $close_grid_pager;
                    ?>
                </div><!-- end #primary -->
            </div><!-- end grid -->
            <?php
            if ($layout_sidebar == 'right') {
                get_sidebar();
            } elseif ($layout_sidebar == 'left') {
                get_sidebar('left');
            }
            ?>

        </div><!-- end row -->
    </div><!-- end container -->
</section>
<?php get_footer(); ?>
