<?php
/***************************************************************************
 *
 * 	----------------------------------------------------------------------
 * 						DO NOT EDIT THIS FILE
 *	----------------------------------------------------------------------
 * 
 *  				     Copyright (C) Themify
 * 
 *	----------------------------------------------------------------------
 *
 ***************************************************************************/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function themify_config_init() {
	/* 	Set Error Reporting
 	***************************************************************************/
	if(defined('WP_DEBUG') && WP_DEBUG) error_reporting( E_ERROR | E_WARNING | E_PARSE );
	else error_reporting( E_ERROR );

	/* 	Global Vars
 	***************************************************************************/
	global $themify_config, $pagenow, $ThemifyConfig, $themify_gfonts;

	/*	Activate Theme
 	***************************************************************************/

	if ( isset( $_GET['activated'] ) && 'themes.php' == $pagenow ) {
		themify_maybe_unset_image_script();
		themify_maybe_clear_legacy();
		header( 'Location: ' . admin_url() . 'admin.php?page=themify&firsttime=true' );
	}

	/* 	Theme Config
 	***************************************************************************/
	define( 'THEMIFY_VERSION', '1.7.4' );
	
	/*	Load Config from theme-config.php or custom-config.php
 	***************************************************************************/
	$themify_config = $ThemifyConfig->get_config();

	/* 	Google Fonts
 	***************************************************************************/
	$themify_gfonts = themify_get_google_font_lists();

	/* 	Woocommerce
	 ***************************************************************************/
	if( themify_is_woocommerce_active() ) {
		add_theme_support('woocommerce');
	}

};
add_action('after_setup_theme', 'themify_config_init');

/**
 * Load class for mobile detection if it doesn't exist yet
 * @since 1.6.8
 */
if ( ! class_exists( 'Themify_Mobile_Detect' ) ) {
	require_once 'class-themify-mobile-detect.php';
	global $themify_mobile_detect;
	$themify_mobile_detect = new Themify_Mobile_Detect;
}
	
/**
 * Load Shortcodes
 * @since 1.1.3
 */
require_once(THEME_DIR . '/themify/themify-shortcodes.php');

/**
 * Load Regenerate Thumbnails plugin if the corresponding class doesn't exist.
 * @since 1.1.5
 */
if(!class_exists('RegenerateThumbnails'))
	require_once(THEMIFY_DIR . '/regenerate-thumbnails/regenerate-thumbnails.php' );

/**
 * Load Page Builder
 * @since 1.1.3
 */
require_once( THEMIFY_DIR . '/themify-builder/themify-builder.php' );
 
/**
 * Remove featured image metabox
 * @since 1.1.5
 */
add_action('do_meta_boxes', 'themify_cpt_image_box');

/**
 * Enqueue framework CSS Stylesheets:
 * 1. themify-skin
 * 2. custom-style
 */
add_action( 'wp_enqueue_scripts', 'themify_enqueue_framework_stylesheets', 12 );

/**
 * Output module styling and Custom CSS:
 * 1. module styling
 * 2. Custom CSS
 */
add_action( 'wp_head', 'themify_output_framework_styling' );

/**
 * Themify - Insert settings page link in WP Admin Bar
 * @since 1.1.2
 */
add_action('wp_before_admin_bar_render', 'themify_admin_bar');

/**
 * Add support for feeds on the site
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Load Themify Hooks
 * @since 1.2.2
 */
require_once(THEMIFY_DIR . '/themify-hooks.php' );

/**
 * Themify Data Migrate
 *******************************************************/
require_once( THEMIFY_DIR . '/class-themify-data-migrate.php' );
	
/**
 * Admin Only code follows
 ******************************************************/
if( is_admin() ){
	
	/**
	 * Remove Themify themes from upgrade check
	 * @since 1.1.8
	 */
	add_filter( 'http_request_args', 'themify_hide_themes', 5, 2);
	
	if( current_user_can('manage_options') ){
		/**
	 	 * Themify - Admin Menu
	 	 *******************************************************/
		add_action('admin_menu', 'themify_admin_nav');
		
		/**
		 * Themify Updater - In multisite, it's only available to super admins.
		 **********************************************************************/
		if ( is_multisite() && is_super_admin() ) {
			require_once(THEMIFY_DIR . '/themify-updater.php');
		} elseif ( ! is_multisite() ) {
			require_once(THEMIFY_DIR . '/themify-updater.php');
		}
	}
	
	/**
 	* Add buttons to TinyMCE
 	*******************************************************/
	require_once(THEMIFY_DIR . '/tinymce/class-themify-tinymce.php');
	require_once(THEMIFY_DIR . '/tinymce/dialog.php');
	
	/**
 	* Enqueue jQuery and other scripts
 	*******************************************************/
	add_action('admin_enqueue_scripts', 'themify_enqueue_scripts');
	
	/**
	 * Display additional ID column in categories list
	 * @since 1.1.8
	 */
	add_filter('manage_edit-category_columns', 'themify_custom_category_header', 10, 2);
	add_filter('manage_category_custom_column', 'themify_custom_category', 10, 3);

	/**
 	* Ajaxify admin
 	*******************************************************/
	require_once(THEMIFY_DIR . '/themify-wpajax.php');
}

/**
 * Enqueue JS and CSS for Themify settings page and meta boxes
 * @param String $page
 * @since 1.1.1
 *******************************************************/
function themify_enqueue_scripts($page){
	global $typenow;

	$pagenow = isset($_GET['page'])? $_GET['page'] : '';
	$types = themify_post_types();
	$pages = apply_filters( 'themify_top_pages', array( 'post.php', 'post-new.php', 'toplevel_page_themify', 'nav-menus.php' ) );
	$pagenows = apply_filters( 'themify_pagenow', array( 'themify' ) );
	
	// Custom Write Panel
	if( ($page == 'post.php' || $page == 'post-new.php') && in_array($typenow, $types) ){
		wp_enqueue_script( 'meta-box-tabs', get_template_directory_uri() . '/themify/js/meta-box-tabs.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'media-library-browse', get_template_directory_uri() . '/themify/js/media-lib-browse.js', array('jquery'), '1.0', true );
	}

	// Settings Panel 
	if( $page == 'toplevel_page_themify' ){
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
	if( in_array( $page, $pages ) ) {
		//Enqueue styles
		wp_enqueue_style( 'themify-ui',  THEMIFY_URI . '/css/themify-ui.css', array(), THEMIFY_VERSION );
		if ( is_rtl() ) {
			wp_enqueue_style( 'themify-ui-rtl',  THEMIFY_URI . '/css/themify-ui-rtl.css', array(), THEMIFY_VERSION );
		}
		wp_enqueue_style( 'colorpicker', THEMIFY_URI . '/css/jquery.minicolors.css', array(), THEMIFY_VERSION );
		
		//Enqueue scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'json2' );
		wp_enqueue_script( 'plupload-all' );
		wp_enqueue_script( 'validate', THEMIFY_URI . '/js/jquery.validate.pack.js', array('jquery'), THEMIFY_VERSION );
		wp_enqueue_script( 'colorpicker-js', THEMIFY_URI . '/js/jquery.minicolors.js', array('jquery'), THEMIFY_VERSION );
		if( in_array($typenow, $types) || in_array( $pagenow, $pagenows ) ){
			//Don't include Themify JavaScript if we're not in one of the Themify-managed pages
			wp_enqueue_script( 'themify-scripts', THEMIFY_URI . '/js/scripts.js', array('jquery'), THEMIFY_VERSION );
			wp_enqueue_script( 'themify-plupload', THEMIFY_URI . '/js/plupload.js', array('jquery', 'themify-scripts'), THEMIFY_VERSION);
			wp_register_script( 'gallery-shortcode', THEMIFY_URI . '/js/gallery-shortcode.js', array('jquery', 'themify-scripts'), THEMIFY_VERSION, true );
		}
		themify_font_icons_admin_assets();
		wp_enqueue_style ( 'magnific', THEMIFY_URI . '/css/lightbox.css');
		wp_enqueue_script( 'magnific', THEMIFY_URI . '/js/lightbox.js', array('jquery'), false, true );
	}
	//Inject variable values to scripts.js previously enqueued
	wp_localize_script('themify-scripts', 'themify_js_vars', array(
			'themify' 	=> THEMIFY_URI,
			'nonce' 	=> wp_create_nonce('ajax-nonce'),
			'admin_url' => admin_url( 'admin.php?page=themify' ),
			'ajax_url' 	=> admin_url( 'admin-ajax.php' ),
			'app_url'	=> get_template_directory_uri() . '/themify/',
			'theme_url'	=> get_template_directory_uri() . '/',
			'blog_url'	=> site_url() . '/'
		)
	);
	
	// Inject variable for Plupload
	$global_plupload_init = array(
	    'runtimes'				=> 'html5,flash,silverlight,html4',
	    'browse_button'			=> 'plupload-browse-button', // adjusted by uploader
	    'container' 			=> 'plupload-upload-ui', // adjusted by uploader
	    'drop_element' 			=> 'drag-drop-area', // adjusted by uploader
	    'file_data_name' 		=> 'async-upload', // adjusted by uploader
	    'multiple_queues' 		=> true,
	    'max_file_size' 		=> wp_max_upload_size() . 'b',
	    'url' 					=> admin_url('admin-ajax.php'),
	    'flash_swf_url' 		=> includes_url('js/plupload/plupload.flash.swf'),
	    'silverlight_xap_url' 	=> includes_url('js/plupload/plupload.silverlight.xap'),
	    'filters' 				=> array( array(
	    	'title' => __('Allowed Files', 'themify'), 'extensions' => 'jpg,jpeg,gif,png,ico,zip,txt,svg') ),
	    'multipart' 			=> true,
	    'urlstream_upload' 		=> true,
	    'multi_selection' 		=> false, // added by uploader
	     // additional post data to send to our ajax hook
	    'multipart_params' 		=> array(
	        '_ajax_nonce' 		=> '', // added by uploader
	        'action' 			=> 'themify_plupload', // the ajax action name
	        'imgid' 			=> 0 // added by uploader
	    )
	);
	wp_localize_script('themify-scripts', 'global_plupload_init', $global_plupload_init);
	
	wp_localize_script('themify-scripts', 'themify_lang', array(
			'confirm_reset_styling'	=> __('Are you sure you want to reset your theme style?', 'themify'),
			'confirm_reset_settings' => __('Are you sure you want to reset your theme settings?', 'themify'),
			'confirm_refresh_webfonts'	=> __('Are you sure you want to reset the Google WebFonts list? This will also save the current settings.', 'themify'),
			'check_backup' => __('Make sure to backup before upgrading. Files and settings may get lost or changed.', 'themify'),
			'confirm_delete_image' => __('Do you want to delete this image permanently?', 'themify'),
			'invalid_login' => __('Invalid username or password.<br/>Contact <a href="http://themify.me/contact">Themify</a> for login issues.', 'themify'),
			'enable_zip_upload' => sprintf(
				__('Go to your <a href="%s">Network Settings</a> to enable <strong>zip</strong>, <strong>txt</strong> and <strong>svg</strong> extensions in <strong>Upload file types</strong> field.', 'themify'),
				esc_url(network_admin_url('settings.php').'#upload_filetypes')
			),
			'filesize_error' => __('The file you are trying to upload exceeds the maximum file size allowed.', 'themify'),
			'filesize_error_fix' => sprintf(
				__('Go to your <a href="%s">Network Settings</a> and increase the value of the <strong>Max upload file size</strong>.', 'themify'),
				esc_url(network_admin_url('settings.php').'#fileupload_maxk')
			)
		)
	);

	// Add strings to TinyMCE menu button
	wp_localize_script('editor', 'themifyEditor', array(
		'nonce' => wp_create_nonce( 'themify-editor-nonce' ),
		'editor' => array(
			'menuTooltip' => __('Shortcodes', 'themify'),
			'menuName' => __('Shortcodes', 'themify'),
			'button' => __('Button', 'themify'),
			'columns' => __('Columns', 'themify'),
			'half21' => __('2-1 Half', 'themify'),
			'half21first' => __('2-1 Half First', 'themify'),
			'third31' => __('3-1 One-Third', 'themify'),
			'third31first' => __('3-1 One-Third First', 'themify'),
			'quarter41' => __('4-1 Quarter', 'themify'),
			'quarter41first' => __('4-1 Quarter First', 'themify'),
			'image' => __('Image', 'themify'),
			'horizontalRule' => __('Horizontal Rule', 'themify'),
			'quote' => __('Quote', 'themify'),
			'isLoggedIn' => __('Is Logged In', 'themify'),
			'isGuest' => __('Is Guest', 'themify'),
			'map' => __('Map', 'themify'),
			'video' => __('Video', 'themify'),
			'flickr' => __('Flickr Gallery', 'themify'),
			'twitter' => __('Twitter Stream', 'themify'),
			'postSlider' => __('Post Slider', 'themify'),
			'customSlider' => __('Custom Slider', 'themify'),
			'slider' => __('Slider', 'themify'),
			'slide' => __('Slide', 'themify'),
			'listPosts' => __('List Posts', 'themify'),
			'box' => __('Box', 'themify'),
			'authorBox' => __('Author Box', 'themify'),
		)
	));
}

/**
 * Add Themify Settings link to admin bar
 * @since 1.1.2
 */
function themify_admin_bar() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	$wp_admin_bar->add_menu( array(
		'id' => 'themify-settings',
		'parent' => 'appearance',
		'title' => __( 'Themify Settings', 'themify' ),
		'href' => admin_url( 'admin.php?page=themify' )
	));
}
/**
 * Remove WordPress' Post Thumbnail metabox. This functionality is handled by Themify
 * @since 1.1.5
 */
function themify_cpt_image_box() {
	$types = themify_post_types();
	foreach( $types as $type )
		remove_meta_box( 'postimagediv', $type, 'side' );
	
}

/**
 * Checks ONLY ONCE if img.php exists and if it doesn't, sets setting-img_settings_use=on.
 * Note that if later, for whatever reason, img.php is restored, this won't automatically enable it.
 * User will have to manually enable img.php again.
 * @since 1.6.0
 */
function themify_maybe_unset_image_script() {
	$flag = 'themify_unset_image_script';
	$noimg = get_option( $flag );
	if ( ! isset( $noimg ) || ! $noimg ) {
		if ( ! file_exists( trailingslashit( THEMIFY_DIR ) . 'img.php' ) ) {
			$get_data = array_merge( themify_get_data(), array( 'setting-img_settings_use' => 'on' ) );
			$data = array();
			foreach( $get_data as $key => $val ) {
				$data[] = $key . '=' . $val;
			}
			$temp = array();
			foreach( $data as $a ) {
				$v = explode( '=', $a );
				$temp[$v[0]] = urldecode( str_replace( '+', ' ', preg_replace( '/%([0-9a-f]{2})/ie', "chr(hexdec('\\1'))", urlencode($v[1] ) ) ) );
			}
			themify_set_data( $temp );
		}
		update_option( $flag, true );
	}
}
add_action( 'after_setup_theme', 'themify_maybe_unset_image_script', 9 );

/**
 * Clear legacy themify-ajax.php and strange files that might have been uploaded to or directories created in the uploads folder within the theme.
 * @since 1.6.3
 */
function themify_maybe_clear_legacy() {
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	WP_Filesystem();
	global $wp_filesystem;

	$flag = 'themify_clear_legacy';
	$clear = get_option( $flag );
	if ( ! isset( $clear ) || ! $clear ) {
		$legacy = THEMIFY_DIR . '/themify-ajax.php';
		if ( $exists = $wp_filesystem->exists( $legacy ) ) {
			$wp_filesystem->delete( $legacy );
		}
		$list = $wp_filesystem->dirlist( THEME_DIR . '/uploads/', true, true );
		foreach ( $list as $item ) {
			if ( 'd' == $item['type'] ) {
				foreach ( $item['files'] as $subitem ) {
					if ( 'd' == $subitem['type'] ) {
						// There shouldn't be a directory here, let's delete it
						$del_dir = THEME_DIR . '/uploads/' . $item['name'] . '/' . $subitem['name'];
						$wp_filesystem->delete( $del_dir, true );
					} else {
						$extension = pathinfo( $subitem['name'], PATHINFO_EXTENSION );
						if ( ! in_array( $extension, array( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ) ) ) {
							$del_file = THEME_DIR . '/uploads/' . $item['name'] . '/' . $subitem['name'];
							$wp_filesystem->delete( $del_file );
						}
					}
				}
			} else {
				$extension = pathinfo( $item['name'], PATHINFO_EXTENSION );
				if ( ! in_array( $extension, array( 'jpg', 'gif', 'png', 'jpeg', 'bmp' ) ) ) {
					$del_file = THEME_DIR . '/uploads/' . $item['name'];
					$wp_filesystem->delete( $del_file );
				}
			}
		}
		update_option( $flag, true );
	}
}
add_action( 'init', 'themify_maybe_clear_legacy', 9 );