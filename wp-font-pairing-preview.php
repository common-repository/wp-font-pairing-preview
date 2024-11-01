<?php
/*
Plugin Name: Font Pairing Preview
Plugin URI: http://www.wpsolutions-hq.com/
Description: This plugin allows you to preview any google web font family pairings from your administration page.
Author: WPSolutions HQ
Version: 1.3
Author URI: http://www.wpsolutions-hq.com/
*/

/*
 * The main plugin class, 
 * initialized right after declaration
 */
if( !class_exists( 'wpFontPairingPreview' ) ) :

class wpFontPairingPreview
{
	function __construct() {
		$this->define_constants();
		$this->loader_operations();
	}

	function define_constants() {
		define('WP_FPP_PATH', dirname(__FILE__));
		define('WP_FPP_URL', plugins_url('',__FILE__));
	}
	
	function loader_operations(){
		add_action('admin_init', array(&$this, 'wp_fpp_admin_init'));
		add_action('plugins_loaded', array( &$this, 'wp_fpp_execute_plugins_loaded_operations' ));
	}
	
	function wp_fpp_execute_plugins_loaded_operations()
	{	
		add_action( 'admin_menu', array( &$this, 'add_admin_menus' ) );
	}
	
	function wp_fpp_admin_init()
	{	
		wp_register_script( 'jquery-ui-core', null);
		wp_register_script( 'jquery-ui-widget', null);
		wp_register_script( 'jquery-ui-position', null);
		wp_register_script( 'jquery-ui-autocomplete', null);
	}

	/******************************************************************************
	 * Now we just need to define an admin page.
	 ******************************************************************************/

	/*
	 * Called during admin_menu, adds an options
	 * page under Settings 
	*/
	
	function add_admin_menus(){	    
		$fpp_admin_menu = add_options_page( 'Font Pairing Preview', 'Font Pairing Preview', 'manage_options', 'wp_fpp_plugin', array(&$this, 'wp_fpp_admin_page') );
		/* Using registered $wpdbsc_admin_menu handle to hook stylesheet loading */
    	add_action( 'admin_print_styles-' .$fpp_admin_menu, array( &$this, 'fpp_load_style' ) );
    	
    	/* Using registered $fpp_admin_menu handle to hook script load */
        add_action('load-' . $fpp_admin_menu, array( &$this, 'wp_fpp_admin_scripts'));
		
	}
	
	function fpp_load_style() {
		/** Register */
	    wp_register_style('fpp-styles', WP_FPP_URL.'/css/fpp_style.css', array(), '1.0.0', 'all');
		
		 /** Enqueue 
		  * It will be called only on your plugin admin page, enqueue our stylesheet here*/
	    wp_enqueue_style('fpp-styles');
	}
	
	function wp_fpp_admin_scripts()
	{	
		wp_enqueue_script( 'jquery-ui-core', null);
		wp_enqueue_script( 'jquery-ui-widget', null);
		wp_enqueue_script( 'jquery-ui-position', null);
		wp_enqueue_script( 'jquery-ui-autocomplete', null);
	}
	

	/*
	 * Plugin Options page rendering goes here, checks
	 * for active tab and replaces key with the related
	 * settings key. Uses the plugin_options_tabs method
	 * to render the tabs.
	 */
	function wp_fpp_admin_page() {
		include_once('wp-font-pairing-settings.php');
		wpFontPairingSettings();				
	}
} //end class
endif;

$wpFontPairingPreview = new wpFontPairingPreview();
?>