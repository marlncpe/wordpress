<?php


/**
 *  Site Message
 */
global $smof_data;

if ( isset($smof_data['message_bar']) && $smof_data['message_bar'] == '1' && !(isset($_COOKIE['message_bar']) && $_COOKIE['message_bar']=='hide' ) ) {
    ?>
    <!-- Start Top Bar -->
    <div id="message_bar" class="<?php text_brightness_indicator('message_bar'); ?>">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                    <div class="site_message">
                        <i class="<?php echo $smof_data['message_icon'] ? $smof_data['message_icon']: 'icon-user'; ?>"></i>
                        <p class="message"><?php echo $smof_data['site_message']; ?></p>
                        <a href="#" title="" class="icon-remove"></a>
                    </div>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- End Message bar -->

<?php
}

/*
 * Returns if the page closed top bar
 */
if(tt_getmeta('customize_page') == '1' && tt_getmeta('hidetopbar') == '1') return;


/**
 * Header Top bar
 */
if ($smof_data['top_bar'] == '1') {
    ?>
    <!-- Start Top Bar -->
    <div id="top_bar" class="<?php text_brightness_indicator('top_bar'); ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
                    <div class="top_left">
                        <?php top_bar_content($smof_data['top_bar_left']); ?>
                    </div><!-- end top_left -->
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-12 col-md-6">
                    <div class="top_right">
                        <?php top_bar_content($smof_data['top_bar_right'], 'right'); ?>
                    </div><!-- end top_right -->
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- End Top Bar -->
    <?php
}
?>