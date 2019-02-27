<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.elk-lab.com
 * @since             1.0.0
 * @package           Vpb
 *
 * @wordpress-plugin
 * Plugin Name:       Visa PassePartout Booking
 * Plugin URI:        http://www.visamultimedia.com/
 * Description:       This plugin integrates a PassePartout Booking reservation form.
 * Version:           1.0.2
 * Author:            VisaMultimedia
 * Author URI:        http://www.visamultimedia.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       visa-passepartout-booking
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VPB_VERSION', '1.0.2' );

/**
 * Current environment state.
 *
 */
define( 'VPB_ENVIRONMENT', 'production' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vpb-activator.php
 */
function activate_vpb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vpb-activator.php';
	Vpb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vpb-deactivator.php
 */
function deactivate_vpb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vpb-deactivator.php';
	Vpb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vpb' );
register_deactivation_hook( __FILE__, 'deactivate_vpb' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vpb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vpb() {

	$plugin = new Vpb();
	$plugin->run();

}
run_vpb();
