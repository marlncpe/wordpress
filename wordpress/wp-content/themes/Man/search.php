<?php
get_header();

global $smof_data, $layout_sidebar;

$prefix = 'search';

$layout_container = 'col-xs-12 col-md-9 col-lg-9 col-sm-8';

$layout_sidebar = 'right';
if ($smof_data[$prefix.'_sidebar_type'] == 'left') {
    $layout_sidebar = 'left';
    $layout_container .= ' pull-right';
} elseif ($smof_data[$prefix.'_sidebar_type'] == 'full') {
    $layout_sidebar = 'full';
    $layout_container = 'col-xs-12 col-md-12 col-lg-12 col-sm-12';
}

$open_grid_container = '';
$loop_layout = (isset($smof_data[$prefix.'_layout']) && $smof_data[$prefix.'_layout'] != '') ? $smof_data[$prefix.'_layout'] : 'regular';
if (strpos($loop_layout,'grid') !== false) {
    $open_grid_container = '<div class="grid_entry"><div class="row">';
}
if (strpos($loop_layout,'masonry') !== false) {
    $open_grid_container = '<div class="grid_entry masonry"><div class="row">';
}

$close_grid_container = '';
if (strpos($loop_layout,'grid') !== false || strpos($loop_layout,'masonry') !== false) {
    $close_grid_container = '</div></div><!-- end grid_entry -->';
}
?>

<!-- Start Feature -->
<div id="feature" class="<?php text_brightness_indicator(); ?>">

    <!-- Start Container -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-9 col-sm-12">
                <h1 class="page_title"><?php printf(__('Search Results for: %s', 'themeton'), get_search_query()); ?></h1>
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
                    /* Start the Loop */
                    if ( have_posts() ){
                        echo $open_grid_container;
                        while (have_posts()) : the_post();
                            call_user_func('blox_loop_'.$loop_layout);
                        endwhile;
                        echo $close_grid_container;
                        tt_paginate_links();
                    }
                    else{
                        echo '<p>'.__('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'themeton').'</p>';
                    }
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