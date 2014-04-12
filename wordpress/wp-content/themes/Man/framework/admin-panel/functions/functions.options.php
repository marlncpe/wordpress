<?php

add_action('init', 'of_options');

if (!function_exists('of_options')) {

    function of_options() {
        //Access the WordPress Categories via an Array
        $of_categories = $of_categories_pure = array();
        $of_categories_obj = get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
        }
        $of_categories_pure = $of_categories;
        $categories_tmp = array_unshift($of_categories, "Select a category:");

        //Access the WordPress Pages via an Array
        $of_pages = array();
        $of_pages_obj = get_pages('sort_column=post_parent,menu_order');
        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name;
        }
        $of_pages_tmp = array_unshift($of_pages, "Select a page:");

        //Stylesheets Reader
        $alt_stylesheet_path = LAYOUT_PATH;
        $alt_stylesheets = array();

        if (is_dir($alt_stylesheet_path)) {
            if ($alt_stylesheet_dir = opendir($alt_stylesheet_path)) {
                while (($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false) {
                    if (stristr($alt_stylesheet_file, ".css") !== false) {
                        $alt_stylesheets[] = $alt_stylesheet_file;
                    }
                }
            }
        }


        //Background Images Reader
        $bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
        $bg_images_url = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
        $bg_images = array();

        if (is_dir($bg_images_path)) {
            if ($bg_images_dir = opendir($bg_images_path)) {
                while (($bg_images_file = readdir($bg_images_dir)) !== false) {
                    if (stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }
            }
        }

        include_once('google-fonts.php');
        $google_fonts = get_google_webfonts();

        $google_webfonts["default"] = "Default (Helvetica, Arial, sans-serif)";
        foreach ($google_fonts as $font) {
            $google_webfonts[$font['family']] = $font['family'];
        }
		
        /* ----------------------------------------------------------------------------------- */
        /* TO DO: Add options/functions that use these */
        /* ----------------------------------------------------------------------------------- */

        //More Options
        $uploads_arr = wp_upload_dir();
        $all_uploads_path = $uploads_arr['path'];
        $all_uploads = get_option('of_uploads');
        $other_entries = array("Select a number:", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19");
        $body_repeat = array("no-repeat", "repeat-x", "repeat-y", "repeat");
        $body_pos = array("top left", "top center", "top right", "center left", "center center", "center right", "bottom left", "bottom center", "bottom right");

        // Image Alignment radio box
        $of_options_thumb_align = array("alignleft" => "Left", "alignright" => "Right", "aligncenter" => "Center");

        // Image Links to Options
        $of_options_image_link_to = array("image" => "The Image", "post" => "The Post");

        /* ----------------------------------------------------------------------------------- */
        /* The Options Array */
        /* ----------------------------------------------------------------------------------- */

        global $of_options,$tt_social_icons,$tt_sidebars;
        $of_options = array();
        $url = ADMIN_IMAGES;



        /* General settings
         ***********************************************************************/
        $of_options[] = array("name" => "General Settings",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Container Layout",
            "desc" => "",
            "id" => "layout",
            "std" => "full",
            "type" => "images",
            "options" => array('full' => $url . 'wide.png',
                'boxed' => $url . 'boxed.png',
                'attached' => $url . 'attached.png',)
        );
        $of_options[] = array("name" => "Site Top Spacing",
            "desc" => "Please set site top margin for <b>Attached</b> layout.",
            "id" => "body_margin_top",
            "std" => "40",
            "min" => "0",
            "step" => "5",
            "max" => "300",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Site Bottom Spacing",
            "desc" => "Please set site bottom margin for <b>Attached</b> layout.",
            "id" => "body_margin_bottom",
            "std" => "40",
            "min" => "0",
            "step" => "5",
            "max" => "300",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Responsive Feature",
            "desc" => "Use Responsive design layout.",
            "id" => "use_responsive",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Logo Image",
            "desc" => "Upload the main logo image. If you don't upload here an image, header area shows Site Title text.",
            "id" => "logo",
            "std" => get_template_directory_uri() . "/images/logo.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Logo Image Top Space",
            "desc" => "You can set logo top spacing here. Your number value increases layout margin space. <b>Default</b>: 50 (in pixels).",
            "id" => "logo_top",
            "std" => "50",
            "min" => "50",
            "step" => "1",
            "max" => "200",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Logo Image Bottom Space",
            "desc" => "You can set logo bottom spacing here. Your number value increases layout margin space. <b>Default</b>: 50 (in pixels).",
            "id" => "logo_bottom",
            "std" => "50",
            "min" => "50",
            "step" => "1",
            "max" => "200",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Logo Image (retina, 2x)",
            "desc" => "Upload an image for the retina version displays. It should be double size of main logo image.",
            "id" => "logo_retina",
            "std" => get_template_directory_uri() . "/images/logo2x.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Favicon",
            "desc" => "Upload a 16 x 16px Ico/Png/Gif image that will represent your site's favicon.",
            "id" => "icon_favicon",
            "std" => get_template_directory_uri() . "/images/favicon.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Login Page Logo",
            "desc" => "Upload an image (up to 274 x 95px) here to replace the login page logo.",
            "id" => "logo_admin",
            "std" => get_template_directory_uri() . "/images/logo-login.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Apple iPhone Icon",
            "desc" => "Upload an image (57 x 57px) here for Apple iPhone.",
            "id" => "icon_iphone",
            "std" => get_template_directory_uri() . "/images/logo-iphone.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Apple iPhone Retina Icon",
            "desc" => "Upload an image (114 x 114px) here for Apple iPhone Retina.",
            "id" => "icon_iphone_retina",
            "std" => get_template_directory_uri() . "/images/logo-iphone2x.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Apple iPad Icon",
            "desc" => "Upload an image (72 x 72px) here for Apple iPad.",
            "id" => "icon_ipad",
            "std" => get_template_directory_uri() . "/images/logo-ipad.png",
            "mod" => "min",
            "type" => "media"
        );        
        $of_options[] = array("name" => "Apple iPad Retina Icon",
            "desc" => "Upload an image (144 x 144px) here for Apple iPad Retina.",
            "id" => "icon_ipad_retina",
            "std" => get_template_directory_uri() . "/images/logo-ipad2x.png",
            "mod" => "min",
            "type" => "media"
        );
        $of_options[] = array("name" => "Tracking Code",
            "desc" => "Add your <a href='http://analytics.google.com' target='_blank'>Google Analytics</a> or other tracking code here. This will be added into the footer of your site.",
            "id" => "site_analytics",
            "std" => "",
            "type" => "textarea"
        );


		/* Top Bar settings 
         ***********************************************************************/
        $of_options[] = array("name" => "Page Builder",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Posts",
            "desc" => "",
            "id" => "pb_posts",
            "std" => 1,
            "type" => "switch"
        );        
        $of_options[] = array("name" => "Pages",
            "desc" => "",
            "id" => "pb_pages",
            "std" => 1,
            "type" => "switch"
        );        
        $of_options[] = array("name" => "Portfolio",
            "desc" => "",
            "id" => "pb_port",
            "std" => 1,
            "type" => "switch"
        );        
        /*
        $of_options[] = array("name" => "For all other post types",
            "desc" => "Controls page builder range on your custom post types.",
            "id" => "pb_other",
            "std" => 0,
            "type" => "switch"
        );
        */

        
        /* Top Bar settings 
         ***********************************************************************/
        $of_options[] = array("name" => "Top Bar",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Enable Top Bar",
            "desc" => "",
            "id" => "top_bar",
            "std" => 1,
            "folds" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Top Bar Left",
            "desc" => "Please select left side element on your top bar.",
            "id" => "top_bar_left",
            "std" => 'text',
            "fold" => "top_bar",
            "type" => "select",
            "options" => array(
                'text' => 'Custom text (left)',
                'social' => 'Social links',
                'menu' => 'Custom Menu',
                'cart' => 'Shopping cart',
                'language' => 'Language widget')
        );
        $of_options[] = array("name" => "Top Bar Right",
            "desc" => "Please select the right side element on your top bar.",
            "id" => "top_bar_right",
            "std" => 'text',
            "fold" => "top_bar",
            "type" => "select",
            "options" => array(
                'text' => 'Custom text (right)',
                'social' => 'Social links',
                'menu' => 'Custom Menu',
                'cart' => 'Shopping cart',
                'language' => 'Language widget')
        );
        $of_options[] = array("name" => "Custom Text (left)",
            "desc" => "",
            "id" => "top_bar_text_left",
            "fold" => "top_bar",
            "std" => "Your left top text here.",
            "type" => "text"
        );
        $of_options[] = array("name" => "Custom Text (right)",
            "desc" => "",
            "id" => "top_bar_text_right",
            "fold" => "top_bar",
            "std" => "Your top bar right text here.",
            "type" => "text"
        );
        $of_options[] = array("name" => "Background Color",
            "desc" => "Pick a background color for the Top Bar area (default: #00b4cc).",
            "id" => "top_bar_bg_color",
            "fold" => "top_bar",
            "std" => "#00b4cc",
            "type" => "color"
        );
        $of_options[] = array("name" => "Enable Message Bar",
            "desc" => "",
            "id" => "message_bar",
            "std" => 1,
            "folds" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Message Text",
            "desc" => "",
            "id" => "site_message",
            "std" => "Hello everyone ... Have a nice day!",
            "fold" => "message_bar",
            "type" => "text"
        );
        $of_options[] = array("name" => "Message Icon",
            "desc" => "Message icon by class. You can get icon name from <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/cheatsheet/'>FontAwesome</a> cheatsheet.",
            "id" => "message_icon",
            "std" => "icon-smile",
            "fold" => "message_bar",
            "type" => "text"
        );
        $of_options[] = array("name" => "Background Color",
            "desc" => "Pick a background color for the Message Bar.",
            "id" => "message_bar_bg_color",
            "fold" => "message_bar",
            "std" => "#53a67b",
            "type" => "color"
        );
        



        /* Header settings
         ***********************************************************************/
        $of_options[] = array("name" => "Header Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Header layout!",
            "std" => "<h3 style=\"margin: 0 0 20px;\">Please select your header layout</h3>
                <ul style='margin-left:20px'>
                    <li>1. Left logo and right Icon menu</li>
                    <li>2. Left logo and right Metro menu.</li>
                    <li>3. Left logo and right regular menu.</li>
                    <li>4. Left logo and right content. Menu styled bottom line and wide.</li>
                    <li>5. Centered logo and wide below menu.</li>
                </ul>",
            "icon" => true,
            "type" => "info"
        );
        $of_options[] = array("name" => "",
            "desc" => "",
            "id" => "header_layout",
            "std" => "1",
            "type" => "images",
            "options" => array(
                '1' => $url.'/Header-1.jpg',
                '2' => $url.'/Header-2.jpg',
                '3' => $url.'/Header-3.jpg',
                '4' => $url.'/Header-4.jpg',
                '5' => $url.'/Header-5.jpg',)
        );
        
        $of_options[] = array("name" => "Header Background Color",
            "desc" => "",
            "id" => "header_bg_color",
            "std" => "#ffffff",
            "type" => "color"
        );
        $of_options[] = array("name" => "Header Transparent",
            "desc" => "Your header shows as transparent and fixed at top of your site despite you've selected layout options on above options.",
            "id" => "header_transparent",
            "std" => "0",
            "type" => "switch"
        );
        $of_options[] = array("name" => "Menu Bar Color",
            "desc" => "Pick a background color for the menu bar when you select <b>4th and 5th layout</b> option.",
            "id" => "menu_bg_color",
            "std" => "#ffffff",
            "type" => "color"
        );
        $of_options[] = array("name" => "Enable Search Box",
            "desc" => "Header layout 4 and 5 has search box in next of menu. But you can remove search box from there If you want to show wider menu area.",
            "id" => "search_box",
            "std" => "1",
            "type" => "switch"
        );
        $of_options[] = array("name" => "Top Content",
            "desc" => "This content shows up at top of your site If you are selected <b>Layout 4</b>. You can add here shortcode or html (image/iframe/adsense) code.",
            "id" => "top_content",
            "std" => "<img src='".get_template_directory_uri()."/images/header-content.png' alt='Content'/>",
            "type" => "textarea"
        );



        /* Page title settings
         ***********************************************************************/
        $of_options[] = array("name" => "Page Title",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Page Title Spacing",
            "desc" => "Set a margin value of the page title area (default: 40px).",
            "id" => "title_space",
            "std" => "40",
            "min" => "0",
            "step" => "5",
            "max" => "300",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Title Background Image",
            "desc" => "Custom background image and patterns are acceptable.",
            "id" => "title_bg_image",
            "std" => "",
            "type" => "media",
        );
        $of_options[] = array("name" => "",
            "desc" => "Repeat",
            "id" => "title_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => $body_repeat
        );
        $of_options[] = array("name" => "",
            "desc" => "Position",
            "id" => "title_bg_position",
            "std" => "",
            "type" => "select",
            "options" => $body_pos
        );
        $of_options[] = array("name" => "",
            "desc" => "Fixed or Scroll",
            "id" => "title_bg_fixed",
            "std" => "fixed",
            "type" => "select",
            "options" => array('scroll', 'fixed')
        );
        $of_options[] = array("name" => "Title Background Color",
            "desc" => "",
            "id" => "title_bg_color",
            "std" => "#00b4cc",
            "type" => "color"
        );
        $of_options[] = array("name" => "Title Text Color",
            "desc" => "You need to set here your title color If you set background color. Also it aspects on Breacrumb color too.",
            "id" => "title_bg_color",
            "std" => "#FFFFFF",
            "type" => "color"
        );
        $of_options[] = array("name" => "Use Breadcrumb",
            "desc" => "You should turn this option Off If you want to remove breadcrumb nav at title area.",
            "id" => "use_breadcrumb",
            "std" => 1,
            "type" => "switch"
        );
        



        /* COMMENT & AUTHOR 
         ***********************************************************************/
        $of_options[] = array("name" => "Single and Page",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Post Format in Single",
            "desc" => "If you turned this option OFF, post format content won't show on single post pages.",
            "id" => "show_post_format",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Related Posts",
            "desc" => "Related posts on bottom of post content in single post page.",
            "id" => "related_posts",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Next Preview Links",
            "desc" => "Next preview post links on single post page.",
            "id" => "next_prev_links",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Author box on Posts",
            "desc" => "",
            "id" => "post_author",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Author box on Pages",
            "desc" => "",
            "id" => "page_author",
            "std" => 0,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Author box on Portfolio item page",
            "desc" => "",
            "id" => "port_author",
            "std" => 0,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Comment on Posts",
            "desc" => "WordPress has its own way to disable comments in a Post. But you should turn this option OFF if you want to remove comments for all your posts.",
            "id" => "post_comment",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Comment on Pages",
            "desc" => "WordPress has its own way to disable comments in a Page. But you should turn this option OFF if you want to remove comments for all your pages.",
            "id" => "page_comment",
            "std" => 1,
            "type" => "switch"
        );



        /* Portfolio
         ***********************************************************************/

        $of_options[] = array("name" => "Portfolio Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Portfolio Slug",
            "type" => "text",
            "id" => "portfolio_slug",
            "desc" => "Portfolio slug that should be show at url for portfolio single items.",
            "std" => "portfolio-item"
        );
        $of_options[] = array("name" => "Portfolio Columns",
            "desc" => "Item column on Taxonomy / Category page. You can select 2, 3 and 4 columns layout.",
            "id" => "portfolio_layout",
            "std" => "grid3",
            "type" => "images",
            "options" => array(
                'grid2' => $url . 'blog-grid2.png',
                'grid3' => $url . 'blog-grid3.png',
                'grid4' => $url . 'blog-grid4.png'
            )
        );
        $of_options[] = array("name" => "Portolio Sidebar Type",
            "desc" => "",
            "id" => "portfolio_sidebar_type",
            "std" => "full",
            "type" => "images",
            "options" => array(
                'right' => $url . '2cr.png',
                'left' => $url . '2cl.png',
                'full' => $url . '1col.png'
            )
        );
        $of_options[] = array("name" => "Portfolio Sidebar",
            "desc" => "",
            "id" => "portfolio_sidebar",
            "std" => "portfolio-sidebar",
            "type" => "select",
            "options" => $tt_sidebars
        );
        $of_options[] = array("name" => "Wanna Hide Portfolio Featured?",
            "desc" => "You can hide featured image on single portfolio pages with this option when you turn this ON.",
            "id" => "port_hide_featured_img",
            "std" => 0,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Portfolio Related Links",
            "desc" => "You can turn off <a href='http://d.pr/i/SK3g' target='_blank'>Next Preview and Main page links</a> at right bottom on single portfolio page.",
            "id" => "port_next_prev_links",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Main Portfolio Page",
            "desc" => "A page which shows when click on View all button from single portfolio item.",
            "id" => "portfolio_page",
            "std" => "",
            "type" => "select",
            "options" => $of_pages
        );
        
        /* Archive and Category layout
         ***********************************************************************/

        $of_options[] = array("name" => "Archive Category Tags",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Category Layout",
            "desc" => "",
            "id" => "category_layout",
            "std" => "regular",
            "type" => "images",
            "options" => array(
                'regular' => $url . 'blog-regular.png',
                'centered' => $url . 'blog-centered.png',
                'metro' => $url . 'blog-metro.png',
                'rightimage' => $url . 'blog-right.png',
                'leftimage' => $url . 'blog-left.png',
                'grid2' => $url . 'blog-grid2.png',
                'grid3' => $url . 'blog-grid3.png',
                'grid4' => $url . 'blog-grid4.png',
                'masonry2' => $url . 'blog-masonry2.png',
                'masonry3' => $url . 'blog-masonry3.png',
                'masonry4' => $url . 'blog-masonry4.png'
            )
        );
        $of_options[] = array("name" => "Category Sidebar Type",
            "desc" => "",
            "id" => "category_sidebar_type",
            "std" => "right",
            "type" => "images",
            "options" => array(
                'right' => $url . '2cr.png',
                'left' => $url . '2cl.png',
                'full' => $url . '1col.png'
            )
        );
        $of_options[] = array("name" => "Category Sidebar",
            "desc" => "",
            "id" => "category_sidebar",
            "std" => "blog-sidebar",
            "type" => "select",
            "options" => $tt_sidebars
        );
        
        $of_options[] = array("name" => "Archive Layout",
            "desc" => "",
            "id" => "archive_layout",
            "std" => "regular",
            "type" => "images",
            "options" => array(
                'regular' => $url . 'blog-regular.png',
                'centered' => $url . 'blog-centered.png',
                'metro' => $url . 'blog-metro.png',
                'rightimage' => $url . 'blog-right.png',
                'leftimage' => $url . 'blog-left.png',
                'grid2' => $url . 'blog-grid2.png',
                'grid3' => $url . 'blog-grid3.png',
                'grid4' => $url . 'blog-grid4.png',
                'masonry2' => $url . 'blog-masonry2.png',
                'masonry3' => $url . 'blog-masonry3.png',
                'masonry4' => $url . 'blog-masonry4.png'
            )
        );
        $of_options[] = array("name" => "Archive Sidebar Type",
            "desc" => "",
            "id" => "archive_sidebar_type",
            "std" => "right",
            "type" => "images",
            "options" => array(
                'right' => $url . '2cr.png',
                'left' => $url . '2cl.png',
                'full' => $url . '1col.png'
            )
        );
        $of_options[] = array("name" => "Archive Sidebar",
            "desc" => "",
            "id" => "archive_sidebar",
            "std" => "blog-sidebar",
            "type" => "select",
            "options" => $tt_sidebars
        );
        $of_options[] = array("name" => "Tag Layout",
            "desc" => "",
            "id" => "tag_layout",
            "std" => "regular",
            "type" => "images",
            "options" => array(
                'regular' => $url . 'blog-regular.png',
                'centered' => $url . 'blog-centered.png',
                'metro' => $url . 'blog-metro.png',
                'rightimage' => $url . 'blog-right.png',
                'leftimage' => $url . 'blog-left.png',
                'grid2' => $url . 'blog-grid2.png',
                'grid3' => $url . 'blog-grid3.png',
                'grid4' => $url . 'blog-grid4.png',
                'masonry2' => $url . 'blog-masonry2.png',
                'masonry3' => $url . 'blog-masonry3.png',
                'masonry4' => $url . 'blog-masonry4.png'
            )
        );
        $of_options[] = array("name" => "Tag Sidebar Type",
            "desc" => "",
            "id" => "tag_sidebar_type",
            "std" => "right",
            "type" => "images",
            "options" => array(
                'right' => $url . '2cr.png',
                'left' => $url . '2cl.png',
                'full' => $url . '1col.png'
            )
        );
        $of_options[] = array("name" => "Tag Sidebar",
            "desc" => "",
            "id" => "tag_sidebar",
            "std" => "blog-sidebar",
            "type" => "select",
            "options" => $tt_sidebars
        );
        
        $of_options[] = array("name" => "Search Result Layout",
            "desc" => "",
            "id" => "search_layout",
            "std" => "regular",
            "type" => "images",
            "options" => array(
                'regular' => $url . 'blog-regular.png',
                'centered' => $url . 'blog-centered.png',
                'metro' => $url . 'blog-metro.png',
                'rightimage' => $url . 'blog-right.png',
                'leftimage' => $url . 'blog-left.png',
                'grid2' => $url . 'blog-grid2.png',
                'grid3' => $url . 'blog-grid3.png',
                'grid4' => $url . 'blog-grid4.png',
                'masonry2' => $url . 'blog-masonry2.png',
                'masonry3' => $url . 'blog-masonry3.png',
                'masonry4' => $url . 'blog-masonry4.png'
            )
        );
        $of_options[] = array("name" => "Search Sidebar Type",
            "desc" => "",
            "id" => "search_sidebar_type",
            "std" => "right",
            "type" => "images",
            "options" => array(
                'right' => $url . '2cr.png',
                'left' => $url . '2cl.png',
                'full' => $url . '1col.png'
            )
        );
        $of_options[] = array("name" => "Search Sidebar",
            "desc" => "",
            "id" => "search_sidebar",
            "std" => "blog-sidebar",
            "type" => "select",
            "options" => $tt_sidebars
        );
        
        $of_options[] = array("name" => "Author Page Layout",
            "desc" => "",
            "id" => "author_layout",
            "std" => "regular",
            "type" => "images",
            "options" => array(
                'regular' => $url . 'blog-regular.png',
                'centered' => $url . 'blog-centered.png',
                'metro' => $url . 'blog-metro.png',
                'rightimage' => $url . 'blog-right.png',
                'leftimage' => $url . 'blog-left.png',
                'grid2' => $url . 'blog-grid2.png',
                'grid3' => $url . 'blog-grid3.png',
                'grid4' => $url . 'blog-grid4.png',
                'masonry2' => $url . 'blog-masonry2.png',
                'masonry3' => $url . 'blog-masonry3.png',
                'masonry4' => $url . 'blog-masonry4.png'
            )
        );
        $of_options[] = array("name" => "Sidebar Type on Author Page",
            "desc" => "",
            "id" => "author_sidebar_type",
            "std" => "right",
            "type" => "images",
            "options" => array(
                'right' => $url . '2cr.png',
                'left' => $url . '2cl.png',
                'full' => $url . '1col.png'
            )
        );
        $of_options[] = array("name" => "Author Sidebar",
            "desc" => "",
            "id" => "author_sidebar",
            "std" => "blog-sidebar",
            "type" => "select",
            "options" => $tt_sidebars
        );


        /* Skin and and Color
         ***********************************************************************/

        $of_options[] = array("name" => "Styling and Color",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Site General Color",
            "desc" => "Pick main ancient color for the theme section including title area background, recent post widget, post separator & image hoverlay styles etc.",
            "id" => "general_color",
            "std" => "#00b4cc",
            "type" => "color"
        );
        $of_options[] = array("name" => "Menu Text Color",
            "desc" => "Pick a text color for menu element. But it will overwritten by menu color if you set specific color on menu element.",
            "id" => "menu_text_color",
            "std" => "#00b4cc",
            "type" => "color"
        );
        $of_options[] = array("name" => "Menu Text Hover Color",
            "desc" => "Pick a default background color for posts which styles on Metro layout If you have posts those didn't set specific color there yet.",
            "id" => "menu_text_hover_color",
            "std" => "#00b4cc",
            "type" => "color"
        );
        $of_options[] = array("name" => "Post General Color",
            "desc" => "Pick a default background color for posts which styles on Metro layout If you have posts those didn't set specific color there yet.",
            "id" => "body_background",
            "std" => "#00b4cc",
            "type" => "color"
        );

        $of_options[] = array("name" => "Font Color",
            "desc" => "Pick a regular body text color for content area.",
            "id" => "content_text_color",
            "std" => "#666666",
            "type" => "color"
        );
        $of_options[] = array("name" => "Link Color",
            "desc" => "Pick a link color for post title, links, post meta, sidebar widget links etc. All links except than menu.",
            "id" => "link_color",
            "std" => "#00b4cc",
            "type" => "color"
        );
        $of_options[] = array("name" => "Link Hover Color",
            "desc" => "Pick a link hover color.",
            "id" => "link_hover_color",
            "std" => "#00a2bf",
            "type" => "color"
        );
        
        $of_options[] = array("name" => "Heading Color",
            "desc" => "Color for heading tags H1, H2, .. H6.",
            "id" => "heading_text_color",
            "std" => "#666666",
            "type" => "color"
        );
        $of_options[] = array("name" => "Widget Title Color",
            "desc" => "Color for widget title on sidebar and footer area.",
            "id" => "widget_title_color",
            "std" => "#666666",
            "type" => "color"
        );
        
        $of_options[] = array("name" => "Content Background Color",
            "desc" => "Pick a background color for content area.",
            "id" => "content_bg_color",
            "std" => "#ffffff",
            "type" => "color"
        );
        $of_options[] = array("name" => "Body Background Color",
            "desc" => "Pick a background color for site body. This color won't show up If you selected Full layout on General tab.",
            "id" => "body_bg_color",
            "std" => "#ffffff",
            "type" => "color"
        );
        $of_options[] = array("name" => "Body Background Image",
            "desc" => "Background image and custom pattern are acceptable.",
            "id" => "bg_image",
            "std" => "",
            "type" => "media",
        );
        $of_options[] = array("name" => "",
            "desc" => "Repeat",
            "id" => "bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => $body_repeat
        );
        $of_options[] = array("name" => "",
            "desc" => "Position",
            "id" => "bg_position",
            "std" => "",
            "type" => "select",
            "options" => $body_pos
        );
        $of_options[] = array("name" => "",
            "desc" => "Fixed or Scroll",
            "id" => "bg_fixed",
            "std" => "scroll",
            "type" => "select",
            "options" => array('scroll', 'fixed')
        );



        /* Font Options
         ***********************************************************************/

        $of_options[] = array("name" => "Font Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Body Font",
            "desc" => "",
            "id" => "body_font",
            "std" => array('size' => '13px', 'face' => 'Open Sans', 'style' => 'normal', 'color' => '#000000'),
            "type" => "typography"
        );
        $of_options[] = array("name" => "Heading sizes",
            "desc" => "H1 size in pixels (default: 36)",
            "id" => "heading1",
            "std" => "36",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "",
            "desc" => "H2 size (default: 30)",
            "id" => "heading2",
            "std" => "30",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "",
            "desc" => "H3 size (default: 24)",
            "id" => "heading3",
            "std" => "24",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "",
            "desc" => "H4 size (default: 18)",
            "id" => "heading4",
            "std" => "18",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "",
            "desc" => "H5 size (default: 14)",
            "id" => "heading5",
            "std" => "14",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "",
            "desc" => "H6 size (default: 12)",
            "id" => "heading6",
            "std" => "12",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Menu Size",
            "desc" => "In pixels. Default: 13",
            "id" => "menu_font",
            "std" => "13",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Widget Title",
            "desc" => "In pixels. Default: 12",
            "id" => "widget_font",
            "std" => "12",
            "min" => "8",
            "step" => "1",
            "max" => "72",
            "type" => "sliderui"
        );
        $of_options[] = array("name" => "Use Google Fonts",
            "desc" => "",
            "id" => "google_font",
            "std" => 1,
            "folds" => 1,
            "type" => "switch"
        );
		
        include_once('google-fonts.php');
        $of_options[] = array("name" => "Menu Font",
            "desc" => "",
            "id" => "google_menu",
            "std" => "Open Sans",
            "fold" => "google_font",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "This is my preview text!", //this is the text from preview box
                "size" => "18px" //this is the text size from preview box
            ),
            "options" => $google_webfonts
        );
        $of_options[] = array("name" => "Heading Font",
            "desc" => "Heading font style incluing H1 through H6 and widget title etc.",
            "id" => "google_heading",
            "std" => "Open Sans",
            "fold" => "google_font",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "This is my preview text!", //this is the text from preview box
                "size" => "24px" //this is the text size from preview box
            ),
            "options" => $google_webfonts
        );
        $of_options[] = array("name" => "Body Font",
            "desc" => "Main body text font.",
            "id" => "google_body",
            "std" => "default",
            "fold" => "google_font",
            "type" => "select_google_font",
            "preview" => array(
                "text" => "This is my preview text! Quick brown fox jump oeer the lazy dog. 123 456 7890 !@#$%^&*()_-+=.", //this is the text from preview box
                "size" => "14px" //this is the text size from preview box
            ),
            "options" => $google_webfonts
        );
        $of_options[] = array("name" => "Google Font Subset",
            "desc" => "Some of Google fonts require additional subsets. Please insert those subsets seperated with comma (,) as <i>greek,latin,cryllic</i> etc. More information <a href='https://developers.google.com/fonts/docs/getting_started#Subsets' target='_blank'>Google Font Subset</a>",
            "id" => "google_subset",
            "std" => "",
            "fold" => "google_font",
            "type" => "text"
        );



        /* Social Options
         ***********************************************************************/

        $of_options[] = array("name" => "Share and Socials",
            "type" => "heading"
        );
        $share_buttons = array("facebook" => "Facebook", "twitter" => "Twitter", "googleplus" => "Google+", "pinterest" => "Pinterest", 'email' => 'Email');
        $of_options[] = array("name" => "Share Buttons",
            "desc" => "",
            "id" => "share_buttons",
            "std" => array('facebook', 'twitter', 'googleplus', 'pinterest', 'email'),
            "type" => "multicheck",
            "options" => $share_buttons
        );
        $of_options[] = array("name" => "Visibility of Share Buttons",
            "std" => "",
            "id" => "cat_color",
            "type" => ""
        );
        $of_options[] = array("name" => "",
            "desc" => "Share On Posts",
            "id" => "share_posts",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "",
            "desc" => "Share On Pages",
            "id" => "share_pages",
            "std" => 0,
            "type" => "switch"
        );
        $of_options[] = array("name" => "",
            "desc" => "Share On Portfolio posts",
            "id" => "share_port",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "",
            "desc" => "Share On Single Product page",
            "id" => "share_woo",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Social Profiles on Top Bar",
            "desc" => "",
            "id" => "social_addresses",
            "std" => "",
            "type" => ""
        );
        foreach ($tt_social_icons as $id => $value) {
            $of_options[] = array("name" => "",
                "desc" => ucfirst($id) . " address",
                "id" => "social_" . $id,
                "std" => "",
                "type" => "text"
            );
        }
        $of_options[] = array("name" => "Social Profiles on Sub Footer Bar",
            "desc" => "",
            "id" => "social_addresses_f",
            "std" => "",
            "type" => ""
        );
        foreach ($tt_social_icons as $id => $value) {
            $of_options[] = array("name" => "",
                "desc" => ucfirst($id) . " address",
                "id" => "footer_social_" . $id,
                "std" => "",
                "type" => "text"
            );
        }

        $of_options[] = array("name" => "social_tip",
            "std" => "<h3 style='margin: 0 0 10px'>Add Custom Social Profile</h3>
                Here I've added some popular social sites. Probably if your familiar social site don't have here, you can extend those as following.
                <p> Please open up the <em>framework/common-functions.php</em> file from theme directory and find <strong>tt_social_icons</strong> array which locates at top of the file.
                This is a very popular array that saves social list for above options and widget socials too. So now we need to extend it with our new socials same as their structure (as Name and Icon code). You should find proper icon for your new social from <a href='http://fortawesome.github.io/Font-Awesome/cheatsheet/' target='_blank'>FontAwesome library</a>.
                </p>
                <p>Also you can reorder those as you want them.</p>",
            "icon" => true,
            "type" => "info"
        );


        /* Sidebar Options
         ***********************************************************************/

        $of_options[] = array("name" => "Custom Sidebar",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Custom sidebar",
            "desc" => "You can create unlimited siderbars for your site. You should add widgets on <strong>Appearance=><a href='widgets.php'>Widgets</a></strong> after you have added new sidebar here.",
            "id" => "custom_sidebar",
            "type" => "sidebar",
            "std" => ""
        );

        
        
        
        /* Footer Options
         ***********************************************************************/

        $of_options[] = array("name" => "Footer Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Enable Footer",
            "desc" => "",
            "id" => "footer",
            "std" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Footer Layout",
            "desc" => "Those are general footer layouts. If you need more creative footer area there, you should select Footer layout #1 and add your layout content there. It is possible to add page layout shortcode in here with text widget.",
            "id" => "footer_layout",
            "std" => "3",
            "type" => "images",
            "options" => array(
                '1' => $url . 'footer1.png',
                '2' => $url . 'footer2.png',
                '3' => $url . 'footer3.png',
                '4' => $url . 'footer4.png',
                '5' => $url . 'footer5.png',
                '6' => $url . 'footer6.png',
            )
        );
        $of_options[] = array("name" => "Footer Background Image",
            "desc" => "Select a background image or pattern.",
            "id" => "footer_bg_image",
            "std" => "",
            "type" => "media",
        );
        $of_options[] = array("name" => "",
            "desc" => "Repeat",
            "id" => "footer_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => $body_repeat
        );
        $of_options[] = array("name" => "",
            "desc" => "Position",
            "id" => "footer_bg_position",
            "std" => "",
            "type" => "select",
            "options" => $body_pos
        );
        $of_options[] = array("name" => "",
            "desc" => "Fixed or Scroll",
            "id" => "footer_bg_fixed",
            "std" => "scroll",
            "type" => "select",
            "options" => array('scroll', 'fixed')
        );
        $of_options[] = array("name" => "Background color",
            "desc" => "",
            "id" => "footer_bg_color",
            "std" => "#2e3739",
            "type" => "color",
        );
        $of_options[] = array("name" => "Custom colors on footer columns",
            "desc" => "If you turn this option ON, following colors fill your footer columns and previous 2 options (footer bg color and bg image) won't work.",
            "id" => "use_footer_column_color",
            "std" => 0,
            "folds" => 1,
            "type" => "switch"
        );
        for ($i = 1; $i <= 4; $i++) {
            $of_options[] = array("name" => "",
                "desc" => "Column " . $i . "'s color.",
                "id" => "footer_" . $i. '_bg_color',
                "std" => "#16a085",
                "fold" => "use_footer_column_color",
                "type" => "color",
            );
        }



        /* Footer Bar
         ***********************************************************************/

        $of_options[] = array("name" => "Footer Bar",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Footer Bar",
            "desc" => "",
            "id" => "sub_footer",
            "std" => 1,
            "folds" => 1,
            "type" => "switch"
        );
        $of_options[] = array("name" => "Background Color",
            "desc" => "",
            "id" => "sub_footer_bg_color",
            "std" => "#1a1f20",
            "fold" => "sub_footer",
            "type" => "color",
        );
        $of_options[] = array("name" => "On Left Side",
            "desc" => "On left of Footer Bar.",
            "id" => "sub_footer_left",
            "fold" => "sub_footer",
            "std" => "text",
            "type" => "select",
            "options" => array(
                'text' => 'Custom text (left)',
                'menu' => 'Menu',
                'social' => 'Social icons',
                'gotop' => 'Go to top arrow',
            )
        );
        $of_options[] = array("name" => "On Right Side",
            "desc" => "On right of Sub footer area.",
            "id" => "sub_footer_right",
            "fold" => "sub_footer",
            "std" => "gotop",
            "type" => "select",
            "options" => array(
                'text' => 'Custom text (right)',
                'menu' => 'Menu',
                'social' => 'Social icons',
                'gotop' => 'Go to top arrow',
            )
        );
        $of_options[] = array("name" => "Custom Text (Left)",
            "desc" => "",
            "id" => "footer_text_left",
            "fold" => "sub_footer",
            "std" => "Powered by WordPress. Developed by <a href='http://themeton.com'>ThemeTon</a>.",
            "type" => "text"
        );
        $of_options[] = array("name" => "Custom Text (Right)",
            "desc" => "",
            "id" => "footer_text_right",
            "fold" => "sub_footer",
            "std" => "Copyright &copy; 2013.",
            "type" => "text"
        );
        $of_options[] = array("name" => "Go To Top Text",
            "desc" => "",
            "id" => "footer_text_gotop",
            "fold" => "sub_footer",
            "std" => "Back to top",
            "type" => "text"
        );



        /* CUSTOM CSS
         ***********************************************************************/

        $of_options[] = array("name" => "Custom CSS",
            "type" => "heading"
        );
        $of_options[] = array("name" => "CSS Tips!",
            "std" => "<h3 style=\"margin: 0 0 10px;\">Tips, Before customizing</h3>
                Control everything is impossible with options. Therefore we have to use custom styling for our sites if we have deep changes. 
                You can make your changes in css files but it doesn't safe and probably you lose those for next version updates of the theme. Then I suggest you to use following options. It is a safe place :)

                <p>If you don't have enough experience with CSS and selectors, you should visit following links
                <ul style='margin-left:20px'>
                    <li> - Learn about <a href='http://www.w3schools.com/cssref/css_selectors.asp' target='_blank'>CSS selectors</a></li>
                    <li> - Learn about <a href='http://net.tutsplus.com/tutorials/html-css-techniques/the-30-css-selectors-you-must-memorize/' target='_blank'>CSS selectors</a> by Jeffrey Way</li>
                    <li> - How to use <a href='http://www.youtube.com/watch?v=nOEw9iiopwI' target='_blank'>Chrome Inspector</a></li>
                    <li> - How to use <a href='http://www.youtube.com/watch?v=3KdNRZS-uSg' target='_blank'>Mozilla Firebug</a> for editing css</li>
                </ul>
                </p>",
            "icon" => true,
            "type" => "info"
        );
        $of_options[] = array("name" => "Custom CSS (General)",
            "desc" => "",
            "id" => "custom_css",
            "std" => "",
            "type" => "textarea"
        );
        $of_options[] = array("name" => "For Tablets",
            "desc" => "Screen width between 768px and 985px",
            "id" => "tablet_css",
            "std" => "",
            "type" => "textarea"
        );
        $of_options[] = array("name" => "For Wide Phones",
            "desc" => "Screen width between 480px and 767px",
            "id" => "wide_phone_css",
            "std" => "",
            "type" => "textarea"
        );
        $of_options[] = array("name" => "For Phone",
            "desc" => "Screen width up to 479px",
            "id" => "phone_css",
            "std" => "",
            "type" => "textarea"
        );



        /* Backup and Restore
         ***********************************************************************/

        $of_options[] = array("name" => "Backup Options",
            "type" => "heading"
        );
        $of_options[] = array("name" => "Backup and Restore Options",
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
        );

        $of_options[] = array("name" => "Transfer Theme Options Data",
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
        );
    }

//End function: of_options()
}//End chack if function exists: of_options()
?>
