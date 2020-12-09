<?php
/**
 * Scripts
 *
 * @package     CNRC
 * @subpackage  Functions
 * @copyright   Copyright (c) 2017, Daniel Powney
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 * @since 0.1
 * @return void
 */
function cnrc_load_scripts() {

	$js_dir = CNRC_PLUGIN_URL . 'assets/js/';

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ''; //( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';


	wp_register_script( 'cnrc-script', $js_dir . 'frontend' . $suffix . '.js', array( 'jquery' ), CNRC_VERSION );
	wp_enqueue_script( 'cnrc-script' );

	$general_settings = (array) get_option( 'cnrc_general_settings' );

	$cnrc_script_vars = array(
	);

	wp_localize_script( 'cnrc-script', 'cnrc_script_vars', apply_filters( 'cnrc_script_vars', $cnrc_script_vars ) );

}
add_action( 'wp_enqueue_scripts', 'cnrc_load_scripts' );


/**
 * Register Styles
 *
 * Checks the styles option and hooks the required filter.
 *
 * @since 0.1
 * @return void
*/
function cnrc_register_styles() {

	$general_settings = (array) get_option( 'cnrc_general_settings' );


	$css_dir = CNRC_PLUGIN_URL . 'assets/css/';

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ''; //( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_style( 'cnrc-style', $css_dir . 'frontend' . $suffix . '.css', array(), CNRC_VERSION, 'all' );

	$custom_css = '
		
	';

	wp_add_inline_style( 'cnrc-style', apply_filters( 'cnrc_custom_css', $custom_css ) );
	wp_enqueue_style( 'cnrc-style' );
}
add_action( 'wp_enqueue_scripts', 'cnrc_register_styles' );


/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @since 0.1
 * @return void
 */
function cnrc_load_admin_scripts() {

	$js_dir = CNRC_PLUGIN_URL . 'assets/js/';
	$css_dir = CNRC_PLUGIN_URL . 'assets/css/';

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ''; //( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	
	wp_register_script( 'cnrc-admin-script', $js_dir . 'admin' . $suffix . '.js', array( 'jquery' ), CNRC_VERSION );
	wp_enqueue_script( 'cnrc-admin-script' );

	wp_enqueue_style( 'cnrc-admin-style', $css_dir . 'admin' . $suffix . '.css' );

}
add_action( 'admin_enqueue_scripts', 'cnrc_load_admin_scripts' );
