<!DOCTYPE HTML>
<!--[if IE 6]>
<html class="oldie ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html class="oldie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="oldie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $paged;

        if(is_front_page()) {
            bloginfo('name'); echo ' | '; bloginfo('description');
        } else { wp_title('|', true, 'right'); }


        // Add a page number if necessary:
	if ( $paged >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'themeton' ), $paged );

	?></title>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/ie8.css">
        <![endif]-->
        <!--[if IE 7]>
            <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/framework/Pagebuilder/css/font-awesome-ie7.min.css">
        <![endif]-->

        <?php
        tt_icons(); // Favicon and Touch icons 

        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');


        /**
         * Layout variables 
         */
        global $smof_data;
        
        // Responsiveness
        if($smof_data['use_responsive'] == 1) {
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        }
        $boxed = $style = '';
        if (is_page() && tt_getmeta('customize_page')) {
            if (tt_getmeta('layout') != 'full') {
                $boxed = "boxed";
                if (tt_getmeta('layout') == 'attached') {
                    $top = tt_getmeta('body_margin_top');
                    $bottom = tt_getmeta('body_margin_bottom');
                    $style = " style='margin-top:$top" . "px;margin-bottom:$bottom" . "px;'";
                }
            }
        } elseif (isset($smof_data['layout']) && ($smof_data['layout'] == 'boxed' || $smof_data['layout'] == 'attached')) {
            $boxed = "boxed";
        }

        /**
         * Javascript variables 
         */
        echo '<script>var footer = false, colorful_footer = false;</script>';
        if ($smof_data['footer'] == 1) {
            echo '<script>footer = true;var footer_layout = ' . $smof_data['footer_layout'] . ';</script>';
            if (isset($smof_data['use_footer_column_color']) && $smof_data['use_footer_column_color'] == 1) {
                echo '<script>colorful_footer = true;</script>';
            }
        }
        wp_head();
        ?>
    </head>
    <body <?php body_class($boxed); echo $style; ?>>
        <div class="wrapper">
            <?php
            // Header Top layout type
            get_template_part('part', 'topbar');
            // Header layout type
            get_template_part('part', 'header');
            ?>