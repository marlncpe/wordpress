<?php
if (tt_getmeta('slider') != '' && tt_getmeta('slider') != 'none') {
    ?>
    <!-- Start Slider -->
    <div id="tt-slider" class="tt-slider">
        <?php
        $slider_name = tt_getmeta("slider");
        $slider = split("_", $slider_name);
        $shortcode = '';
        if (strpos($slider_name, "layerslider") !== false)
            $shortcode = "[" . $slider[0] . " id='" . $slider[1] . "']";
        elseif (strpos($slider_name, "revslider") !== false)
            $shortcode = "[rev_slider " . $slider[1] . "]";
        echo do_shortcode($shortcode); ?>
    </div>
    <!-- End Slider -->
    <?php
}

/**
 * Page Title
 */
global $smof_data, $layout_sidebar;

// Page styling arguments
$headerbclass = $contentbclass = 'dark';
$is_custom_titlebg = $is_custom_contentbg = false;
$title_style = $bg_style = '';

// Sidebar postion
$layout_sidebar = tt_getmeta('page_layout') != '' ? tt_getmeta('page_layout') : 'full';

// check single product
if( is_singular(array('product')) ){ $layout_sidebar = 'right'; }

// Layout class
$layout_class = ($layout_sidebar == 'full' || $layout_sidebar == 'no_sidebar') ? 'col-xs-12 col-md-12 col-lg-12 col-sm-12' : 'col-xs-12 col-md-9 col-lg-9 col-sm-8';
if ($layout_sidebar == 'left') {
    $layout_class .= ' pull-right';
}

// Page teaser text
$teaser = tt_getmeta('teaser');

$bg_scroll = '';

// Is this page activated custom style
if(tt_getmeta('customize_page') == '1') {
    // Title BG color style
    $titlebg = tt_page_title_bg_color();

    // Content BG color style
    $contentbg = tt_page_content_bg_color();

    if ($titlebg != '') {
        $headerbclass = get_text_class(tt_getmeta('title_bgcolor'));
        $is_custom_titlebg = true;
    }
    if ($contentbg != '') {
        $contentbclass = get_text_class(tt_getmeta('general_color'));
        $is_custom_contentbg = true;
    }

    // Page background image style
    $title_style = tt_page_title_bg_image($titlebg);
    
    // Page background image style
    $bg_style = tt_page_content_bg_image($contentbg);
    $bg_scroll = tt_getmeta('bg_fixed');
}

if (tt_getmeta('customize_page')=='' || tt_getmeta('customize_page') == '0' || (tt_getmeta('customize_page') == '1' && tt_getmeta('hidetitle') == '0')) {
    ?>
    <!-- Start Feature -->
    <div id="feature" permalink="<?php the_permalink(); ?>" class="<?php echo $is_custom_titlebg == true ? $headerbclass : text_brightness_indicator(); ?>" <?php echo $title_style; ?>>

        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <?php 
                $title_class = "col-xs-12 col-md-12 col-lg-9 col-sm-12";
                $show_breadcrumb = true;
                if (isset($smof_data['use_breadcrumb']) && $smof_data['use_breadcrumb'] == 0) {
                    $title_class = "col-xs-12 col-md-12 col-lg-12 col-sm-12";
                    $show_breadcrumb = false;
                }
                ?>
                <div class="<?php echo $title_class; ?>">
                    <h1 class="page_title">
                        <?php
                        if( function_exists('is_woocommerce') && is_woocommerce() && !is_singular(array('product')) ){
                            woocommerce_page_title();
                        }
                        else{
                            the_title();
                        }
                        ?>
                    </h1>
                    <?php if ($teaser != '') { ?>
                        <div class="page_teaser"><?php echo do_shortcode($teaser); ?></div>
                    <?php } ?>
                </div>
                <?php if($show_breadcrumb) { ?>
                <div class="col-xs-12 col-md-12 col-lg-3 col-sm-12">
                    <?php tt_breadcrumbs(); ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Feature -->
<?php } // Hide title  ?>
<!-- Start Content -->
<section id="content" <?php if(tt_getmeta('hidetitle') == '1') {echo "permalink='".get_permalink()."'";} ?> class="<?php echo $is_custom_contentbg == true ? $contentbclass : text_brightness_indicator('content'); ?> <?php echo $bg_scroll == 'parallax' ? 'skrollable skrollable-between' : ''; ?>" <?php echo $bg_style; ?>>
    <!-- Start Container -->
    <div class="container">
        <div class="row">

            <div class="<?php echo $layout_class; ?>">
                <div id="primary" class="content">
                    <article>
                        <div class="entry_content">
                            <?php
                                if( isset( $print_woocontent ) && $print_woocontent == true ){
                                    woocommerce_content();
                                    $post = $tmp_post;
                                    $wp_query = $temp_query;
                                }
                                else{
                                    the_content();
                                }
                            ?>
                            <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'themeton') . '</span>', 'after' => '</div>')); ?>
                        </div>

                        <?php
                        if ($smof_data['page_author'] == 1)
                            about_author();
                        ?>

                        <?php if (isset($smof_data['share_pages']) && $smof_data['share_pages'] == '1'): ?>
                        <div class="single_footer">
                            <div class="row">
                                <div class="col-xs-12 col-xxs-8 col-sm-6 col-md-6 col-lg-6">
                                    <?php
                                        social_share();
                                    ?>
                                </div>
                                <div class="col-xs-12 col-xxs-4 col-sm-6 col-md-6 col-lg-6">
                                    <div class="post_meta">
                                    <?php edit_post_link(__('Edit', 'themeton'), '<span class="edit-link">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                    </article>
                    <?php
                    if (isset($smof_data['page_comment']) && $smof_data['page_comment'] == 1 && (!isset($print_woocontent) || !$print_woocontent) ){
                        comments_template('', true);
                    }
                    ?>
                </div><!-- end #primary -->
            </div><!-- end grid -->

            <?php

            if( is_singular(array('product'))  ){
                get_sidebar('shop');
            }
            else if ($layout_sidebar != 'full') {
                if ($layout_sidebar == 'left'){
                    get_sidebar('left');
                }
                elseif($layout_sidebar == 'right'){
                    get_sidebar();
                }
            }

            ?>

        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- End Section -->