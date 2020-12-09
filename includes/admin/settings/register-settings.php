<?php
/**
 * Register Settings
 *
 * @package     CNRC
 * @subpackage  Admin/Settings
 * @copyright   Copyright (c) 2017, Daniel Powney
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Get Settings
 *
 * Retrieves all plugin settings
 *
 * @since 0.1
 * @return array CNRC settings
 */
function cnrc_get_settings() {

	$settings = get_option( 'cnrc_settings' );

	if( empty( $settings ) ) {

		// Update old settings with new single option

		$general_settings = is_array( get_option( 'cnrc_general_settings' ) )    ? get_option( 'cnrc_general_settings' )    : array();

		$settings = array_merge( $general_settings );

		update_option( 'cnrc_settings', $settings );
	}

	return apply_filters( 'cnrc_get_settings', $settings );
}

/**
 * Reister settings
 */
function cnrc_register_settings() {

	register_setting( 'cnrc_general_settings', 'cnrc_general_settings', 'cnrc_sanitize_general_settings' );
	register_setting( 'cnrc_overlay_settings', 'cnrc_overlay_settings', 'cnrc_sanitize_overlay_settings' );

	add_settings_section( 'cnrc_section_general', null, 'cnrc_section_general_desc', 'cn-ratio-calc&tab=cnrc_general_settings' );
	add_settings_section( 'cnrc_section_overlay', null, 'cnrc_section_overlay_desc', 'cn-ratio-calc&tab=cnrc_overlay_settings' );


	$setting_fields = array(
	);

	$setting_fields = apply_filters( 'cnrc_setting_fields', $setting_fields );

	foreach ( $setting_fields as $setting_id => $setting_data ) {
		// $id, $title, $callback, $page, $section, $args
		add_settings_field( $setting_id, $setting_data['title'], $setting_data['callback'], $setting_data['page'], $setting_data['section'], $setting_data['args'] );
	}
}

/**
 * Set default settings if not set
 */
function cnrc_default_settings() {

	$general_settings = (array) get_option( 'cnrc_general_settings' );

	$general_settings = array_merge( apply_filters('cnrc_general_settings', array(
			
	) ), $general_settings );

	update_option( 'cnrc_general_settings', $general_settings );

}

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	add_action( 'admin_init', 'cnrc_default_settings', 10, 0 );
	add_action( 'admin_init', 'cnrc_register_settings' );

}

/**
 * Sanitize general settings
 * @param 	$input
 */
function cnrc_sanitize_general_settings( $input ) {
	return $input;
}
