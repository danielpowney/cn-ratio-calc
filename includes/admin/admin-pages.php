<?php
/**
 * Admin Pages
 *
 * @package     CNRC
 * @subpackage  Admin/Pages
 * @copyright   Copyright (c) 2017, Daniel Powney
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates an options page for plugin settings and links it to a global variable
 *
 * @since 0.1
 * @return void
 */
function cnrc_add_options_link() {
	global $cnrc_settings_page;

	$cnrc_settings_page      = 	add_options_page( __( 'C:N Ratio Calculator', 'cn-ratio-calc' ), __( 'C:N Ratio Calculator', 'cn-ratio-calc' ), 'manage_options', 'cn-ratio-calc', 'cnrc_options_page');
	
}
add_action( 'admin_menu', 'cnrc_add_options_link', 10 );