<?php
/**
 * Admin Options Page
 *
 * @package     CNRC
 * @subpackage  Admin/Settings
 * @copyright   Copyright (c) 2017, Daniel Powney
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Options Page
 *
 * Renders the options page contents.
 *
 * @since 1.0
 * @return void
 */
function cnrc_options_page() {
	?>
	<div class="wrap">
		<?php
		$general_settings = (array) get_option( 'cnrc_general_settings' );
		?>
		<h1><?php _e( 'C:N Ratio Calculator Settings', 'cn-ratio-calc' ); ?></h1>
		<h2 class="nav-tab-wrapper">
			<?php
			$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'cnrc_general_settings';
			$tabs = array (
					'cnrc_general_settings'				=> __( 'General', 'cn-ratio-calc' )
			);

			$tabs = apply_filters( 'cnrc_settings_tabs', $tabs );

			foreach ( $tabs as $tab_key => $tab_caption ) {
				$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
				echo '<a class="nav-tab ' . $active . '" href="options-general.php?page=cn-ratio-calc&tab=' . $tab_key . '">' . $tab_caption . '</a>';
			}
			?>
		</h2>

		<form method="post" name="<?php echo $current_tab; ?>" action="options.php">
			<?php
			wp_nonce_field( 'update-options' );
			settings_fields( $current_tab );
			do_settings_sections( 'cn-ratio-calc&tab=' . $current_tab );
			submit_button( null, 'primary', 'submit', true, null );
			?>
		</form>

	</div>
	<?php
}

/**
 * General settings section
 */
function cnrc_section_general_desc() {
?>
	<p class="cnrc-settings-section"></p>
	<?php
}


/**
 * Field input setting
 */
function cnrc_field_input( $args ) {
	$settings = (array) get_option( $args['option_name' ] );
	$class = isset( $args['class'] ) ? $args['class'] : 'regular-text';
	$type = isset( $args['type'] ) ? $args['type'] : 'text';
	$min = isset( $args['min'] ) && is_numeric( $args['min'] ) ? intval( $args['min'] ) : null;
	$max = isset( $args['max'] ) && is_numeric( $args['max'] ) ? intval( $args['max'] ) : null;
	$step = isset( $args['step'] ) && is_numeric( $args['step'] ) ? floatval( $args['step'] ) : null;
	$readonly = isset( $args['readonly'] ) && $args['readonly'] ? ' readonly' : '';
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	$required = isset( $args['required'] ) && $args['required'] === true ? 'required' : '';
	?>
	<input class="<?php echo $class; ?>" type="<?php echo $type; ?>" name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>]"
			value="<?php echo esc_attr( $settings[$args['setting_id']] ); ?>" <?php if ( $min !== null ) { echo ' min="' . $min . '"'; } ?>
			<?php if ( $max !== null) { echo ' max="' . $max . '"'; } echo $readonly; ?>
			<?php if ( $step !== null ) { echo ' step="' . $step . '"'; } ?>
			placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?> />
	<?php
	if ( isset( $args['label'] ) ) { ?>
		<label><?php echo $args['label']; ?></label>
	<?php }
}



/**
 * Field input setting
 */
function cnrc_field_textarea( $args ) {
	$settings = (array) get_option( $args['option_name' ] );
	$class = isset( $args['class'] ) ? $args['class'] : 'widefat';
	$readonly = isset( $args['readonly'] ) && $args['readonly'] ? ' readonly' : '';
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	$required = isset( $args['required'] ) && $args['required'] === true ? 'required' : '';
	?>
	<textarea class="<?php echo $class; ?>" name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>]"
			<?php echo $readonly; ?>
			placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?> cols="50" rows="5"><?php echo esc_attr( $settings[$args['setting_id']] ); ?></textarea>
	<?php
	if ( isset( $args['label'] ) ) { ?>
		<label><?php echo $args['label']; ?></label>
	<?php }
}



/**
 * Color picker field
 *
 * @param unknown $args
 */
function cnrc_field_select( $args ) {
	$settings = (array) get_option( $args['option_name' ] );
	$value = $settings[$args['setting_id']];
	?>
	<select name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>]">
		<?php
		foreach ( $args['select_options'] as $option_value => $option_label ) {
			$selected = '';
			if ( $value == $option_value ) {
				$selected = 'selected="selected"';
			}
			echo '<option value="' . $option_value . '" ' . $selected . '>' . $option_label . '</option>';
		}
		?>
	</select>
	<?php
	if ( isset( $args['label'] ) ) { ?>
		<label><?php echo $args['label']; ?></label>
	<?php }
}


/**
 * Color picker field
 *
 * @param unknown $args
 */
function cnrc_field_color_picker( $args ) {
	$settings = (array) get_option( $args['option_name' ] );
	?>
	<input type="text" class="color-picker" name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>]" value="<?php echo $settings[$args['setting_id']]; ?>" />
	<?php
}


/**
 * Checkbox setting
 */
function cnrc_field_checkbox( $args ) {
	$settings = (array) get_option( $args['option_name' ] );
	?>
	<input type="checkbox" name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>]" value="true" <?php checked( true, isset( $settings[$args['setting_id']] ) ? $settings[$args['setting_id']] : false , true ); ?> />
	<?php
	if ( isset( $args['label'] ) ) { ?>
		<label><?php echo $args['label']; ?></label>
	<?php }
}


/**
 *
 */
function cnrc_field_checkbox_list( $args ) {
	$settings = (array) get_option( $args['option_name' ] );

	foreach ( $args['checkboxes'] as $checkbox ) {

		$checked = '';
		if ( is_array( $settings[$args['setting_id']] ) ) {
			if ( in_array( $checkbox['value'], $settings[$args['setting_id']] ) ) {
				$checked = 'checked="checked"';
			}
		} else if ( $checkbox['value'] == $settings[$args['setting_id']] ) {
			$checked = 'checked="checked"';
		}

		?>
		<input type="checkbox" name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>][]" value="<?php echo $checkbox['value']; ?>" <?php echo $checked; ?> />
		<label style="margin-right: 12px;"><?php echo $checkbox['label']; ?></label>
		<?php
	}
	?>
	<br /><br />
	<label><?php echo $args['label']; ?></label>
	<?php
}


/**
 * Field radio buttons
 */
function cnrc_field_radio_buttons( $args ) {
	$settings = (array) get_option( $args['option_name' ] );
	foreach ( $args['radio_buttons'] as $radio_button ) {
		?>
		<input type="radio" name="<?php echo $args['option_name']; ?>[<?php echo $args['setting_id']; ?>]" value="<?php echo $radio_button['value']; ?>" <?php checked( $radio_button['value'], $settings[$args['setting_id']], true); ?> />
		<label><?php echo $radio_button['label']; ?></label><br />
		<?php
	}
	?>
	<br />
	<label><?php echo $args['label']; ?></label>
	<?php
}