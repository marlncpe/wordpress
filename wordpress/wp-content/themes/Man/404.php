<?php
get_header();
global $smof_data;
?>

<!-- Start Content -->
<section id="content" class="<?php text_brightness_indicator('content'); ?>">
    <!-- Start Container -->
    <div class="container">
        <div class="row">

            <div class="col-xs-12 col-xxs-12 col-md-12 col-lg-12 col-sm-12">
                <div id="primary" class="content">
                    <div id="error-404">
                        <h1>404</h1>
                        <h2>Not Found</h2>
                        <p class="search_text"><?php _e('Sorry, the post you are looking for is not available. Maybe you want to perform a search?', 'themeton'); ?></p>
                        <div class="not_found_search">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div><!-- end #primary -->
            </div><!-- end grid -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>

<?php get_footer(); ?>