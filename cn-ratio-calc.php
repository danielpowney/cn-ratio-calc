<?php
/**
 * Plugin Name: C:N Ratio Calculator
 * Plugin URI: https://github.com/danielpowney/cn-ratio-calc
 * Description: 
 * Author: Daniel Powney
 * Author URI: https://danielpowney.com
 * Version: 1.1
 * Text Domain: cn-ratio-calc
 * Domain Path: languages
 *
 * C:N Ratio Calculator is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * C:N Ratio Calculator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Easy Digital Downloads. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     CNRC
 * @author 		Daniel Powney
 * @version		1.0
 */

	/**
	 * Main CN_Ratio_Calc Class.
	 *
	 * @since 1.4
	 */
	final class CN_Ratio_Calc {

		/** Singleton *************************************************************/

		/**
		 * @var CN_Ratio_Calc The one true CN_Ratio_Calc
		 * @since 1.4
		 */
		private static $instance;

		/**
		 * Used to identify multiple chatbots on the same page...
		 */
		public static $sequence = 0;


		/**
		 * Main CN_Ratio_Calc Instance.
		 *
		 * Insures that only one instance of CN_Ratio_Calc exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 0.1
		 * @static
		 * @staticvar array $instance
		 * @uses CN_Ratio_Calc::setup_constants() Setup the constants needed.
		 * @uses CN_Ratio_Calc::includes() Include the required files.
		 * @uses CN_Ratio_Calc::load_textdomain() load the language files.
		 * @see CNRC()
		 * @return object|CN_Ratio_Calc The one true CN_Ratio_Calc
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CN_Ratio_Calc ) ) {

				self::$instance = new CN_Ratio_Calc;
				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
				add_action( 'in_plugin_update_message-cn-ratio-calc/cn-ratio-calc.php', array( self::$instance, 'upgrade_notice' ), 10, 2 );

				self::$instance->includes();
			}
			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.6
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'cn-ratio-calc' ), '1.6' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.6
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'cn-ratio-calc' ), '1.6' );
		}

		/**
		 * Setup plugin constants.
		 *
		 * @access private
		 * @since 1.4
		 * @return void
		 */
		private function setup_constants() {

			// Plugin version.
			if ( ! defined( 'CNRC_VERSION' ) ) {
				define( 'CNRC_VERSION', '1.1' );
			}

			// Plugin slug.
			if ( ! defined( 'CNRC_SLUG' ) ) {
				define( 'CNRC_SLUG', 'cn-ratio-calc' );
			}

			// Plugin Folder Path.
			if ( ! defined( 'CNRC_PLUGIN_DIR' ) ) {
				define( 'CNRC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'CNRC_PLUGIN_URL' ) ) {
				define( 'CNRC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'CNRC_PLUGIN_FILE' ) ) {
				define( 'CNRC_PLUGIN_FILE', __FILE__ );
			}
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since 1.4
		 * @return void
		 */
		private function includes() {
			global $cnrc_options;

			require_once CNRC_PLUGIN_DIR . 'includes/admin/settings/register-settings.php';
			$cnrc_options = cnrc_get_settings();

			require_once CNRC_PLUGIN_DIR . 'includes/actions.php';
			if( file_exists( CNRC_PLUGIN_DIR . 'includes/deprecated-functions.php' ) ) {
				require_once CNRC_PLUGIN_DIR . 'includes/deprecated-functions.php';
			}
			require_once CNRC_PLUGIN_DIR . 'includes/ajax-functions.php';
			require_once CNRC_PLUGIN_DIR . 'includes/template-functions.php';
			require_once CNRC_PLUGIN_DIR . 'includes/misc-functions.php';
			require_once CNRC_PLUGIN_DIR . 'includes/shortcodes.php';
			require_once CNRC_PLUGIN_DIR . 'includes/scripts.php';

			if ( is_admin() ) {
				require_once CNRC_PLUGIN_DIR . 'includes/admin/admin-actions.php';
				require_once CNRC_PLUGIN_DIR . 'includes/admin/admin-pages.php';
				require_once CNRC_PLUGIN_DIR . 'includes/admin/settings/display-settings.php';
				require_once CNRC_PLUGIN_DIR . 'includes/admin/upgrades/upgrade-functions.php';
			}

			require_once CNRC_PLUGIN_DIR . 'includes/install.php';
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.4
		 * @return void
		 */
		public function load_textdomain() {
			global $wp_version;

			// Set filter for plugin's languages directory.
			$cnrc_lang_dir  = dirname( plugin_basename( CNRC_PLUGIN_FILE ) ) . '/languages/';
			$cnrc_lang_dir  = apply_filters( 'cnrc_languages_directory', $cnrc_lang_dir );

			// Traditional WordPress plugin locale filter.

			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {

				$get_locale = get_user_locale();
			}

			/**
			 * Defines the plugin language locale used in AffiliateWP.
			 *
			 * @var $get_locale The locale to use. Uses get_user_locale()` in WordPress 4.7 or greater,
			 *                  otherwise uses `get_locale()`.
			 */
			$locale        = apply_filters( 'plugin_locale',  $get_locale, 'cn-ratio-calc' );
			$mofile        = sprintf( '%1$s-%2$s.mo', 'cn-ratio-calc', $locale );

			// Look for wp-content/languages/cnrc/cn-ratio-calc-{lang}_{country}.mo
			$mofile_global1 = WP_LANG_DIR . '/cnrc/cn-ratio-calc-' . $locale . '.mo';

			// Look for wp-content/languages/cnrc/cnrc-{lang}_{country}.mo
			$mofile_global2 = WP_LANG_DIR . '/cnrc/cnrc-' . $locale . '.mo';

			// Look in wp-content/languages/plugins/cn-ratio-calc
			$mofile_global3 = WP_LANG_DIR . '/plugins/cn-ratio-calc/' . $mofile;

			if ( file_exists( $mofile_global1 ) ) {

				load_textdomain( 'cn-ratio-calc', $mofile_global1 );

			} elseif ( file_exists( $mofile_global2 ) ) {

				load_textdomain( 'cn-ratio-calc', $mofile_global2 );

			} elseif ( file_exists( $mofile_global3 ) ) {

				load_textdomain( 'cn-ratio-calc', $mofile_global3 );

			} else {

				// Load the default language files.
				load_plugin_textdomain( 'cn-ratio-calc', false, $cnrc_lang_dir );
			}

		}

		/**
		 * Displays upgrade notice
		 */
		public function upgrade_notice( $data, $response ) {
		
			if( isset( $data['upgrade_notice'] ) ) {
				printf(
					'<div class="update-message">%s</div>',
					wpautop( $data['upgrade_notice'] )
				);
			}
		}

	}

	/**
	 * The main function for that returns CN_Ratio_Calc
	 *
	 * The main function responsible for returning the one true CN_Ratio_Calc
	 * Instance to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $cnrc = CNRC(); ?>
	 *
	 * @since 1.4
	 * @return object|CN_Ratio_Calc The one true CN_Ratio_Calc Instance.
	 */
	function CNRC() {
		return CN_Ratio_Calc::instance();
	}

	// Get CNRC Running.
	CNRC();
