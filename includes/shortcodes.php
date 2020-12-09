<?php
/**
 * Shortcodes
*
* @package     CNRC
* @subpackage  Shortcodes
* @copyright   Copyright (c) 2017, Daniel Powney
* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
* @since       1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Shortcode
 *
 */
function cn_ratio_calc_shortcode( $atts = array(), $content = null, $tag ) {

	extract( shortcode_atts( array(
			'echo' => false,
			'debug' => false
	), $atts ) );

	if ( is_string( $debug ) ) {
		$debug = $debug == 'true' ? true : false;
	}

	$general_settings = (array) get_option( 'cnrc_general_settings' );

	ob_start();
	cnrc_get_template_part( 'calculator', 'shortcode', true, array(
			'debug' 					=> $debug
	) );
	$html = ob_get_contents();
	ob_end_clean();

	$html = apply_filters( 'cnrc_template_html', $html );

	if ( $echo == true ) {
		echo $html;
	}

	return $html;
}
add_shortcode( 'cn_ratio_calc', 'cn_ratio_calc_shortcode' );
