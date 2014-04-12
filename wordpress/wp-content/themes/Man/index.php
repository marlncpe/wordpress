<?php
get_header();
?>

<!-- Start Content -->
<section id="content" class="page_content <?php text_brightness_indicator('content'); ?>">
    <!-- Start Container -->
    <div class="container">
        <div class="row">

            <div class="col-xs-12 col-md-9 col-lg-9 col-sm-8">
                <div id="primary" class="content"> 
                    <div class="row clearfix" style="position:relative;">
                        <div class="col-xs-12 col-xxs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php
                            if (have_posts()) :
                                while (have_posts()) : the_post();
                                    blox_loop_regular();
                                endwhile;
                                tt_paginate_links();
                            endif;
                            ?>
                        </div>
                    </div>
                </div><!-- end #primary -->
            </div><!-- end grid -->

            <?php get_sidebar(); ?>

        </div><!-- end row -->
    </div><!-- end container -->
</section>

<?php
get_footer();
?>