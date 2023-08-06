<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://erich.biz
 * @since             1.0.0
 * @package           Admin_Login_Alert
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Login Alert
 * Plugin URI:        https://admin-login-alert.com
 * Description:       On successful login of a user at administrator level - sends an email alert with login details.
 * Version:           1.0.0
 * Author:            Vladimir Eric
 * Author URI:        https://erich.biz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       admin-login-alert
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
define( 'ADMIN_LOGIN_ALERT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-admin-login-alert-activator.php
 */
function activate_admin_login_alert() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-login-alert-activator.php';
	Admin_Login_Alert_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-admin-login-alert-deactivator.php
 */
function deactivate_admin_login_alert() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-login-alert-deactivator.php';
	Admin_Login_Alert_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_admin_login_alert' );
register_deactivation_hook( __FILE__, 'deactivate_admin_login_alert' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-admin-login-alert.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_admin_login_alert() {

	$plugin = new Admin_Login_Alert();
	$plugin->run();

}
run_admin_login_alert();
