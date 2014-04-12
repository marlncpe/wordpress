<?php
global $smof_data;
if ($smof_data['footer'] == 1 && tt_getmeta('hidefooter') != '1') {
    $layout = isset($smof_data['footer_layout']) ? $smof_data['footer_layout'] : 3;
    switch ($layout) {
        case 1:
            $col = 1;
            $percent = array(
                'col-xs-12 col-sm-12 col-md-12 col-lg-12');
            break;
        case 2:
            $col = 2;
            $percent = array(
                'col-xs-12 col-sm-6 col-md-6 col-lg-6',
                'col-xs-12 col-sm-6 col-md-6 col-lg-6');
            break;
        case 3:
            $col = 3;
            $percent = array(
                'col-xs-12 col-sm-12 col-md-6 col-lg-6',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3');
            break;
        case 4:
            $col = 3;
            $percent = array(
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-right');
            break;
        case 5:
            $col = 3;
            $percent = array(
                'col-xs-12 col-sm-12 col-md-4 col-lg-4',
                'col-xs-12 col-sm-12 col-md-4 col-lg-4',
                'col-xs-12 col-sm-12 col-md-4 col-lg-4');
            break;
        case 6:
            $col = 4;
            $percent = array(
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3');
            break;
        default:
            $col = 4;
            $percent = array(
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3',
                'col-xs-12 col-sm-6 col-md-3 col-lg-3');
            break;
    }
    ?>
    <!-- Start Footer -->
    <footer id="footer" class="clearfix">
        <div class="container">
            <div class="row">
                <?php 
                $footer_custom_color = '';
                $prefix = 'footer';
                for ($i = 1; $i <= $col; $i++) {
                    if(isset($smof_data['use_footer_column_color']) && $smof_data['use_footer_column_color'] == 1) {
                        $footer_custom_color = "style='background-color:".$smof_data['footer_' . $i . '_bg_color']."'";
                        $prefix = 'footer_' . $i;
                    }
                    echo "<div class='footer_widget_container ".$percent[$i - 1]." "; text_brightness_indicator($prefix); echo "' $footer_custom_color>";
                    dynamic_sidebar('sidebar_metro_footer' . $i);
                    echo '</div>';
                } ?>
            </div><!-- End row -->
        </div><!-- End container -->
    </footer>
    <!-- End Footer -->
<?php } ?>


<?php if (isset($smof_data['sub_footer']) && $smof_data['sub_footer'] == 1 && tt_getmeta('hidesubfooter') != '1') { ?>
    <!-- Start sub footer -->
    <div id="sub_footer" class="sub_footer <?php text_brightness_indicator('sub_footer'); ?>">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-6 col-sm-6">
    <?php sub_footer_content($smof_data['sub_footer_left']); ?>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-6 col-sm-6 align_right">
    <?php sub_footer_content($smof_data['sub_footer_right'], 'right'); ?>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </div>
    <!-- End sub footer -->
<?php } ?>
<?php tt_trackingcode(); ?>
<?php wp_footer(); ?>

    </div><!-- end .wrapper -->

    <span class="gototop_footer gototop">
        <i class="icon-angle-up"></i>
    </span>
</body>
</html>