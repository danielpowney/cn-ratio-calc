<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check for updates
 */
function cnrc_upgrade_check() {

	// Check if we need to do an upgrade from a previous version
	$previous_plugin_version = get_option( 'cnrc_plugin_version' );

	if ( ! isset( $previous_plugin_version ) ) {
		//return;
	}

	if ( ! cnrc_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
		@set_time_limit( 0 );
	}

	if ( $previous_plugin_version != CNRC_VERSION && $previous_plugin_version < 0.4 ) {
		cnrc_upgrade_to_0_4();
	}

	update_option( 'cnrc_plugin_version', CNRC_VERSION ); // latest version upgrade complete

}
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	cnrc_upgrade_check();
}


/**
 * Upgrade to v0.4. Copy some settings.
 */
function cnrc_upgrade_to_0_4() {

	$general_settings = (array) get_option( 'cnrc_general_settings' );
	$overlay_settings = (array) get_option( 'cnrc_overlay_settings' );

	/*
	 * Copy the following settings from the general settings to overlay settings:
	 * enable_overlay, overlay_default_open, overlay_powered_by_text, overlay_header_text,
	 * overlay_header_background_color and overlay_header_font_color
	 */
	if ( isset( $general_settings['enable_overlay'] ) ) {
		$overlay_settings['enable_overlay'] = $general_settings['enable_overlay'];
		unset( $general_settings['enable_overlay'] );
	}
	if ( isset( $general_settings['overlay_default_open'] ) ) {
		$overlay_settings['overlay_default_open'] = $general_settings['overlay_default_open'];
		unset( $general_settings['overlay_default_open'] );
	}
	if ( isset( $general_settings['overlay_powered_by_text'] ) ) {
		$overlay_settings['overlay_powered_by_text'] = $general_settings['overlay_powered_by_text'];
		unset( $general_settings['overlay_powered_by_text'] );
	}
	if ( isset( $general_settings['overlay_header_text'] ) ) {
		$overlay_settings['overlay_header_text'] = $general_settings['overlay_header_text'];
		unset( $general_settings['overlay_header_text'] );
	}
	if ( isset( $general_settings['overlay_header_background_color'] ) ) {
		$overlay_settings['overlay_header_background_color'] = $general_settings['overlay_header_background_color'];
		unset( $general_settings['overlay_header_background_color'] );
	}
	if ( isset( $general_settings['overlay_header_font_color'] ) ) {
		$overlay_settings['overlay_header_font_color'] = $general_settings['overlay_header_font_color'];
		unset( $general_settings['overlay_header_font_color'] );
	}

	update_option( 'cnrc_general_settings',  $general_settings );
	update_option( 'cnrc_overlay_settings',  $overlay_settings );

}
