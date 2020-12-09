<?php
/**
 * Misc Functions
 *
 * @package     CNRC
 * @subpackage  Functions
 * @copyright   Copyright (c) 2017, Daniel Powney
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1
 */

// Exit if accessed directly
if (! defined ( 'ABSPATH' ))
	exit ();

/**
 * Checks whether function is disabled.
 *
 * @param string  $function Name of the function.
 * @return bool Whether or not function is disabled.
 */
function cnrc_is_func_disabled( $function ) {
    $disabled = explode( ',',  ini_get( 'disable_functions' ) );

    return in_array( $function, $disabled );
}