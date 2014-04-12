<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class TT_Welcome_Page {

    public function __construct() {

        add_action('admin_menu', array($this, 'admin_menus'));
        add_action('admin_head', array($this, 'admin_head'));
    }

    public function admin_menus() {

        $welcome_dash_title = __('Mana Theme', 'themeton');
        $welcome_page_title = __('Welcome to Mana Theme', 'themeton');

        // About
        $about = add_dashboard_page($welcome_page_title, $welcome_dash_title, 'manage_options', 'mana-about', array($this, 'about_screen'));

        // Themes
        $themes = add_dashboard_page($welcome_page_title, $welcome_dash_title, 'manage_options', 'tt-themes', array($this, 'themes_screen'));
    }

    public function admin_head() {

        remove_submenu_page('index.php', 'mana-about');
        remove_submenu_page('index.php', 'tt-themes');
    }

    private function intro() {
        ?>
        <style>
            .welcome_themes a {
                display: block;
                text-decoration: none;
            }
            h4.theme_name {
                text-align: center;
                margin: 0 10% !important;
                line-height: 1.5;
            }
            .about-wrap .feature-section.welcome_themes.three-col img {
                padding: 5%;
                max-width: 90%;
                margin-top: 40px;
                border: none;
                margin-bottom: 15px;
            }
            .feature-section.images-stagger-right .video {
                float: right;
                margin: 0 5px 12px 2em;
            }
        </style>
        <h1><?php printf(__('Welcome to Mana %s', 'themeton'), THEMEVERSION); ?></h1>

        <div class="about-text woocommerce-about-text">
        <?php
        $message = __('Thank you for using this theme!', 'themeton');

        printf(__('%s We hope you enjoy it.', 'themeton'), $message, THEMEVERSION);
        ?>
        </div>
        <div class="pull-right">
            <a href="<?php echo admin_url('admin.php?page=theme-options'); ?>" class="button button-primary"><?php _e('Theme Options', 'themeton'); ?></a>
            <a class="docs button button-primary" href="<?php echo THEMEDOC; ?>"><?php _e('Documentation', 'themeton'); ?></a>
        </div>

        <h2 class="nav-tab-wrapper">
            <a class="nav-tab <?php if ($_GET['page'] == 'mana-about') echo 'nav-tab-active'; ?>" href="<?php echo esc_url(admin_url(add_query_arg(array('page' => 'mana-about'), 'index.php'))); ?>">
        <?php _e("Features", 'themeton'); ?>
            </a>
            <a class="nav-tab <?php if ($_GET['page'] == 'tt-themes') echo 'nav-tab-active'; ?>" href="<?php echo esc_url(admin_url(add_query_arg(array('page' => 'tt-themes'), 'index.php'))); ?>">
        <?php _e('ThemeTon themes', 'themeton'); ?>
            </a>
        </h2>
        <?php
    }

    public function about_screen() {
        ?>
        <div class="wrap about-wrap">

        <?php $this->intro(); ?>

            <div class="changelog">

                <h3><?php _e('The New Page Builder', 'themeton'); ?></h3>
                <div class="feature-section images-stagger-right">
                    <div class="video">
                        <iframe src="http://www.screenr.com/embed/1QtH" width="550" height="335" frameborder="0"></iframe>
                    </div>
                    <p><?php _e('Introducing new Page Builder.', 'themeton'); ?></p>
                    <h4><?php _e('Drag & Drop User Interface', 'themeton'); ?></h4>
                    <p><?php _e('Quick and Easy tools help you to build any kind of page. Drag & Drop Interface saves your time.', 'themeton'); ?></p>
                    <h4><?php _e('Page Builder Elements', 'themeton'); ?></h4>
                    <p><?php _e('There have 33 power elements despite multiple column layouts. Those give you freedom of creativity.', 'themeton'); ?></p>
                </div>
                <div style="margin-bottom:60px; margin-top: 0; padding-bottom: 20px; border-bottom: 1px solid #e9e9e9; width: 100%; clear: both; height: 0px;"></div>
                <h3><?php _e('Introducing Page Customizer', 'themeton'); ?></h3>
                <div class="feature-section images-stagger-right">
                    <div class="video">
                        <iframe src="http://www.screenr.com/embed/FQtH" width="550" height="335" frameborder="0"></iframe>
                    </div>
                    <p><?php _e('Every page has an option section called "Page Cusomization" which gives you opportunity to create Unique and different looking pages with few simple options. There have enable disable option every part (top bar, header, title and footer) change color and property of the web pages despite admin panel options.', 'themeton'); ?></p>
                </div>
                <div style="margin-bottom:60px; margin-top: 0; padding-bottom: 20px; border-bottom: 1px solid #e9e9e9; width: 100%; clear: both; height: 0px;"></div>

                <h3><?php _e('Key Features', 'themeton'); ?></h3>
                <div class="feature-section col three-col">

                    <div>
                        <h4><?php _e('Page Mixer', 'themeton'); ?></h4>
                        <p><?php _e('Build a new page with your existing pages and show navigation by including page links. You can create beautiful One Page design and custom parallax effects with it.', 'themeton'); ?></p>
                    </div>

                    <div>
                        <h4><?php _e('Menu System', 'themeton'); ?></h4>
                        <p><?php _e('Theme has four unique and beautiful menu designs. You can create 10+ different looking navigations with those Regular, Icon, Metro and Wide options. Also mega menu option available.', 'themeton'); ?></p>
                    </div>	
                    <div class="last-feature">
                        <h4><?php _e('Parallax', 'themeton'); ?></h4>
                        <p><?php _e('Any page and Rows can show background image. Those images can move as Parallax when you scroll your website. It is a very nice and hope you enjoy it.', 'themeton'); ?></p>
                    </div>
                </div>

                <div class="feature-section col three-col">
                    <div>
                        <h4><?php _e('Premium Sliders', 'themeton'); ?></h4>
                        <p><?php _e('You save $30 for Layer Slider & Revolution slider those are top popular items of Codecanyon site. Those power sliders give you to show your slides easier.', 'themeton'); ?></p>
                    </div>
                    <div>
                        <h4><?php _e('Rich Snippets & Micro Data Format', 'themeton'); ?></h4>
                        <p><?php _e('SEO, Snippets - The few lines of text that appear under every search result are designed to give users a sense for what\'s on the page and why it\'s relevant to their query.', 'themeton'); ?></p>
                    </div>
                    <div class="last-feature">
                        <h4><?php _e('Woo Commerce', 'themeton'); ?></h4>
                        <p><?php _e('Transform your WordPress website into a thorough-bred eCommerce store for free. Delivering enterprise-level quality & features whilst backed by a name you can trust.', 'themeton'); ?></p>
                    </div>

                </div>
                <div style="margin-bottom:60px; margin-top: 0; padding-bottom: 20px; border-bottom: 1px solid #e9e9e9; width: 100%; clear: both; height: 0px;"></div>
            </div>

            <div class="changelog">
                <h3><?php _e('Noteable Features', 'themeton'); ?></h3>

                <div class="feature-section col three-col">
                    <div>
                        <h4><?php _e('Super Responsive', 'themeton'); ?></h4>
                        <p><?php _e('It is based on Bootstrap 3.0 and has a specific Grid System, Menu, and Elements which can work adaptivity with all Devices and screen resolutions.', 'themeton'); ?></p>
                    </div>

                    <div>
                        <h4><?php _e('Unlimited Colors & Page Customization', 'themeton'); ?></h4>
                        <p><?php _e('You can choose color, design and solutions by yourself, and it is possible to build your web site into any type. And possible to do your desired design by controlling whole parts of the one page.', 'themeton'); ?></p>
                    </div>

                    <div class="last-feature">
                        <h4><?php _e('Layered PSD', 'themeton'); ?></h4>
                        <p><?php _e('Included detailed PSD files those contain all web elements of the theme. You can redesign your elements with it.', 'themeton'); ?></p>
                    </div>
                </div>
                <div class="feature-section col three-col">
                    <div>
                        <h4><?php _e('Icon Fonts', 'themeton'); ?></h4>
                        <p><?php _e('Font Awesome gives you scalable vector icons that can instantly be customized size, color, drop shadow, and anything that can be done with the power of CSS.', 'themeton'); ?></p>
                    </div>
                    <div>
                        <h4><?php _e('Theme Options', 'themeton'); ?></h4>
                        <p><?php _e('Theme has tons of admin options those helps you to control your site as you want. You can tell your wishes If you need more specific one.', 'themeton'); ?></p>
                    </div>
                    <div class="last-feature">
                        <h4><?php _e('Retina Ready', 'themeton'); ?></h4>
                        <p><?php _e('All graphics within WC have been optimised for HiDPI displays.', 'themeton'); ?></p>
                    </div>

                </div>
                <div class="feature-section col three-col">
                    <div>
                        <h4><?php _e('Loops & Layouts', 'themeton'); ?></h4>
                        <p><?php _e('There have 11+ loop layouts including Classic, Metro and Grid of Blog page feels like a miracle. You can use them on any columns place with page builder and shortcode.', 'themeton'); ?></p>
                    </div>
                    <div>
                        <h4><?php _e('Stunning Support', 'themeton'); ?></h4>
                        <p><?php _e('Our team had worked for 3 months. Every parts were improved and renewed. 3 people will work on support of the Theme, and they would be ready to serve you on design, development, error bug and instruction.', 'themeton'); ?></p>
                    </div>
                    <div class="last-feature">
                        <h4><?php _e('Translation ready & WPML supports', 'themeton'); ?></h4>
                        <p><?php _e('Includes PO/MO files for your new languages. WPML makes it easy to build multilingual sites and run them. It\'s powerful enough for corporate sites, yet simple for blogs.', 'themeton'); ?></p>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }

    /**
     * Output the credits.
     *
     * @access public
     * @return void
     */
    public function themes_screen() {
        ?>
        <div class="wrap about-wrap">

        <?php $this->intro(); ?>

            <p></p>

        <?php //echo $this->contributors();  ?>

            <?php
            $themes = file_get_contents('http://marketplace.envato.com/api/edge/new-files-from-user:themeton,themeforest.json');
            $themes_json = json_decode($themes, true);
            foreach ($themes_json as $key => $value) {
                echo '<div class="feature-section col three-col welcome_themes">';
                $index = 0;
                foreach ($value as $item) {
                    $index++;
                    echo '<div class="' . ($index % 3 == 0 ? 'last-feature' : '') . '">
                            <a href="' . $item['url'] . '" target="_blank">
                                <img src="' . $item['live_preview_url'] . '" class="preview_img" />
                            </a>
                            <h4 class="theme_name"><a href="' . $item['url'] . '">' . $item['item'] . '</a></h4>
                        </div>';
                }
                echo '</div>';
            }
            ?>

        </div>
        <?php
    }

    /**
     * Render Contributors List
     *
     * @access public
     * @return string $contributor_list HTML formatted list of contributors.
     */
    public function contributors() {
        $contributors = $this->get_contributors();

        if (empty($contributors))
            return '';

        $contributor_list = '<ul class="wp-people-group">';

        foreach ($contributors as $contributor) {
            $contributor_list .= '<li class="wp-person">';
            $contributor_list .= sprintf('<a href="%s" title="%s">', esc_url('https://github.com/' . $contributor->login), esc_html(sprintf(__('View %s', 'themeton'), $contributor->login))
            );
            $contributor_list .= sprintf('<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url($contributor->avatar_url), esc_html($contributor->login));
            $contributor_list .= '</a>';
            $contributor_list .= sprintf('<a class="web" href="%s">%s</a>', esc_url('https://github.com/' . $contributor->login), esc_html($contributor->login));
            $contributor_list .= '</a>';
            $contributor_list .= '</li>';
        }

        $contributor_list .= '</ul>';

        return $contributor_list;
    }

    /**
     * Retreive list of contributors from GitHub.
     *
     * @access public
     * @return void
     */
    public function get_contributors() {
        $contributors = get_transient('woocommerce_contributors');

        if (false !== $contributors)
            return $contributors;

        $response = wp_remote_get('https://api.github.com/repos/woothemes/woocommerce/contributors', array('sslverify' => false));

        if (is_wp_error($response) || 200 != wp_remote_retrieve_response_code($response))
            return array();

        $contributors = json_decode(wp_remote_retrieve_body($response));

        if (!is_array($contributors))
            return array();

        set_transient('woocommerce_contributors', $contributors, 3600);

        return $contributors;
    }

}

new TT_Welcome_Page();