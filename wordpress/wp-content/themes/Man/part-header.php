<?php
/*
 * Returns if the page closed Header
 */
if(tt_getmeta('customize_page') == '1' && tt_getmeta('hideheader') == '1') return;


/**
 * Header Area
 */
global $smof_data;

$layout = isset($smof_data['header_layout']) ? $smof_data['header_layout'] : '1';
$header_transparent = isset($smof_data['header_transparent']) && $smof_data['header_transparent']=='1' ? 'header_transparent' : '';
$header_bg_color = $page_menu_bg_color = '';
$pcolor = $hcolor = '';
// Taking page customization
if(is_page() && tt_getmeta('customize_page') == '1') {
    $layout = tt_getmeta('header_layout');
    $header_transparent = tt_getmeta('header_transparent')=='1' ? 'header_transparent' : '';
    $pcolor = tt_getmeta('menu_bg_color');
    $page_menu_bg_color = ($pcolor != '' && $pcolor != $smof_data['menu_bg_color']) ? "style='background-color: $pcolor;'" : '';
    $hcolor = tt_getmeta('header_bg_color');
    $header_bg_color = ($hcolor != '' && $hcolor != $smof_data['header_bg_color']) ? "style='background-color: $hcolor;'" : '';
}

if ($layout == '1' ||
        $layout == '2' ||
        $layout == '3') {

    /**
     * Header layout type 1 & 2 & 3. 
     * Simply logo image + Right navigation
     * Logo : Three
     * Navigation : Nine columns and right aligned
     */
    $menutype = 'default_menu';
    if ($layout == '1') {
        $menutype = 'icon_menu';
    } elseif ($layout == '2') {
        $menutype = 'metro_menu';
    }
    $onlyicon = isset($smof_data['only_icon']) ? ' only_icon' : '';
    ?>

    <!-- Start Header -->
    <header id="header" class="<?php echo $header_transparent.' '.($layout=='2' ? 'metro_menu_header' : ''); echo $hcolor!='' ? get_text_class($hcolor) : '';  ?>" <?php echo $header_bg_color; ?>>
        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                    <?php tt_site_logo(); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="<?php echo $menutype . $onlyicon; ?> align_right">
                        <?php
                        if (isset($post) && tt_getmeta('wp_page_template') == 'page-one-page.php') {
                            //render_mega_nav('onepage_nav' . $post->ID);
                            render_mega_nav();
                        } else {
                            render_mega_nav();
                        }
                        ?>
                    </div>
                </div>
                <?php get_mobile_shopping_cart(); ?>
            </div>
        </div><!-- End Row -->
        <!-- End Container -->
    </header>
    <?php
} elseif ($layout == '4' || $layout == '5') {
    /**
     * Header layout type 4 or 5. 
     * Logo image + Right Banner area by widget (float right) + Full menu area with search form
     * Logo : Three
     * Banner : Nine
     * Navigation : Nine columns
     * Search form : Three columns right
     */
    $class = 'col-xs-12 col-md-12 col-lg-3 col-sm-4';
    if ($layout == '5')
        $class = 'col-xs-12 col-md-12 col-lg-12 col-sm-12 align_center';
    ?>
    <!-- Start Header -->
    <header id="header" <?php echo $header_bg_color; ?>>

        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <div class="<?php echo $class; ?>">
                    <?php tt_site_logo(); ?>
                </div>
                <?php if ($layout == '4') { ?>
                    <div class="col-xs-12 col-md-12 col-lg-9 col-sm-8">
                        <div class="custom_box hidden-xs hidden-sm visible-md visible-lg align_right">
                            <?php echo do_shortcode($smof_data['top_content']); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php get_mobile_shopping_cart(); ?>
            </div>
        </div>
        <!-- End Container -->

    </header>

    <!-- Start Wide Menu -->
    <div class="wide_menu <?php echo get_text_class($pcolor); ?>" <?php echo $page_menu_bg_color; ?>>
        <!-- Start Container -->
        <div class="container">
            <div class="row">
                <?php 
                $layout_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
                if($smof_data['search_box'] == 1) {
                    $layout_class = 'col-xs-12 col-sm-12 col-md-12 col-lg-9';
                }
                ?>
                <div class="<?php echo $layout_class; ?>">
                    <?php
                    if (isset($post) && tt_getmeta('wp_page_template') == 'page-one-page.php') {
                        render_mega_nav('onepage_nav' . $post->ID);
                    } else {
                        render_mega_nav();
                    }
                    ?>
                </div>
                <?php if($smof_data['search_box'] == 1) { ?>
                <!-- Search form -->
                <div class="col-lg-3 visible-lg visible">
                    <form role="search" method="get" id="searchform" action="<?php echo site_url(); ?>">
                        <div class="clearfix">
                            <input type="submit" id="searchsubmit" value="&#xf002;" class="icon-search">
                            <div id="s_input"><input type="text" value="" name="s" id="s" autocomplete="off" placeholder="<?php _e('Search', 'themeton'); ?>"></div>
                        </div>
                    </form>
                </div>
                <?php } //endif for search_box ?>
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Wide Menu -->
    <?php
}