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

/**
 * Remove Error Message 
 */
if( isset( $_GET['page'] ) && $_GET['page'] == 'themify-data-migration' ) {
	error_reporting( E_ERROR );
}

/**
 * Themify data migration class
 * @package default
 */
class ThemifyDataMigrate {

	/**
	 * Constructor
	 * @return void
	 */
	function __construct() {
		add_action( 'init', array( &$this, 'init' ), 20 );
	}

	/**
	 * Init Function
	 * @return void
	 */
	function init() {

		// In case user has chosen to disable the upgrader
		if( !defined('THEMIFY_MIGRATION') ) define('THEMIFY_MIGRATION', true);
		if( !THEMIFY_MIGRATION ) return;

		$this->check_data();
		$this->check_data_frontend();
	}

	/**
	 * Check old data backend
	 * @return void
	 */
	function check_data() {
		// register function only current data is old data
		if (is_admin() && current_user_can('manage_options') && $this->check_current_db_data() ) {
			add_action( 'admin_menu', array( &$this, 'register_data_migration_page' ), 10 );
			if( !isset($_GET['action']) && $_GET['page'] != 'themify-data-migration' ) {
				wp_redirect( admin_url( 'admin.php?page=themify-data-migration' ) );
				die();
			}
		}
	}

	/**
	 * Check old data frontend
	 * @return void
	 */
	function check_data_frontend() {
		if ( is_user_logged_in() && current_user_can( 'manage_options' ) && !is_admin() && $this->check_current_db_data() )
			add_action( 'wp_footer', array( &$this, 'frontend_notification' ), 10 );
	}

	/**
	 * Register page migration
	 * @return void
	 */
	function register_data_migration_page() {
		add_submenu_page( null, __('Themify Data Update', 'themify'), __('Themify Data Update', 'themify'), 'manage_options', 'themify-data-migration', array( &$this, 'data_migration_menu_callback' ) );
	}

	/**
	 * Data migration page
	 * @return void
	 */
	function frontend_notification() {
		wp_enqueue_style( 'themify-notification', THEMIFY_URI . '/css/themify-notification.css' );
		echo sprintf('<div class="themify-notification update"><p>'.__('<strong>Important:</strong> Theme setting data needs to be updated. Please <a href="%s">click here to update</a>', 'themify').'</p></div>', admin_url( 'admin.php?page=themify-data-migration' ) );
	}

	/**
	 * Menu Callback
	 * @return void
	 */
	function data_migration_menu_callback() {
		echo '<div class="icon32" id="icon-options-general"><br></div>';
		echo '<h2>' . __('Theme Settings Update Data', 'themify') . '</h2>';

		if( isset( $_GET['action'] ) && $_GET['action'] == 'update' ) {
			$this->update_data();
		}
		else {
			$baseurl = wp_nonce_url(admin_url('admin.php?page=themify-data-migration'), 'themify_export_nonce');
			echo sprintf( '<br /><p>' . __( '<strong>Important:</strong> Theme setting data needs to be updated. Please <a href="%s" class="export" id="download-export">click here to backup</a> the current setting data before updating the data.', 'themify') . '</p>', $baseurl.'&amp;export_old=true' );
			echo sprintf( '<p><a href="%s" class="button button-primary">'.__('Update Now', 'themify').'</a></p>', admin_url('admin.php?page=themify-data-migration&action=update') );
		}
	}

	/**
	 * Save new data value
	 * @return void
	 */
	function update_data() {
		$theme = wp_get_theme();
		$old_data = unserialize( base64_decode( get_option( $theme->display('Name') . '_themify_data' ) ) );
		$new_data = array();
		
		// convert data
		$new_data = $this->convert_data( $old_data );
		
		// convert and update into new array format
		update_option( $theme->display('Name') . '_themify_data', $new_data );

		// redirect to themify panel
		echo '<script>window.location.href="'.admin_url('admin.php?page=themify').'"</script>';

	}

	/**
	 * Convert old data to new data
	 * @param type $old_data 
	 * @return array
	 */
	function convert_data( $old_data ) {
		$new_data = array();
		
		// convert old data
		if( is_array( $old_data ) && count( $old_data ) >= 1 ) {
			foreach( $old_data as $name => $value ) {
				$array = explode( '-', $name );
				$path = "";
				foreach( $array as $part ) {
					$path .= "['$part']";
				}
				eval( "\$config".$path." = \$value;" );
			}
			if( is_array( $config['styling'] ) ) {
				foreach( $config['styling'] as $nav => $value ) {
					// get parent array
					$parent_arr = themify_get_theme_arr( $nav, 'styling' );

					foreach( $value as $element => $val ) {
						$selector = urldecode( themify_scrub_decode( $element ) );
						$title = str_replace( '_', ' ', $nav );

						// return id of element by selector
						$id_style = themify_search_arr( $parent_arr, 'selector', $selector, true );

						if ( isset( $id_style[0]['id'] ) ) {
					  	$style_key = $id_style[0]['id'];
					  	$config['styling'][$nav][$style_key] = $val;
					  }
					}
				}
			}

			// convert into new array
			$new_data = $this->dfs( $config );
		}

		return $new_data;
	}

	/**
	 * Restructur array
	 * @param type $array 
	 * @param type $parent 
	 * @return array
	 */
	function dfs( $array, $parent = null ) {
    static $result = array();

    if ( is_array( $array ) * count( $array ) > 0) {
      foreach ( $array as $key => $value ) {
      	$this->dfs( $value, $parent . '-' . $key );
      }
    }
    else {
      $result[ltrim($parent, '-')] = $array;
    }

    return $result;
	}

	/**
	 * Check current db theme option data
	 * @param string $type
	 * @return boolean
	 */
	function check_current_db_data( $type = 'base64' ) {
		$theme = wp_get_theme();
		$data = false;
		$settings = get_option( $theme->display('Name') . '_themify_data' );
		if ( 'base64' == $type && ! is_array( $settings ) ) {
			   $data = @base64_decode( $settings, true );
		}

		if ( $data ) {
			   return true;
		} else {
			   return false;
		}
	}
}

// initiate class
$GLOBALS['ThemifyDataMigrate'] = new ThemifyDataMigrate();