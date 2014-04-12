<?php


function is_bbpress_active()
{
	if (class_exists( 'bbPress' )) { return true; }
	return false;
}

//check if the plugin is enabled, otherwise stop the script
if(!is_bbpress_active()) { return false; }


//register my own styles
if(!is_admin()){ add_action('bbp_enqueue_scripts', 'tt_bbpress_register_assets',15); }


function tt_bbpress_register_assets()
{
	wp_dequeue_style( 'bbp-default-bbpress' );
	wp_enqueue_style( 'tt-bbpress-custom', get_template_directory_uri().'/framework/config-bbp/bbpress-custom-style.css');
}

