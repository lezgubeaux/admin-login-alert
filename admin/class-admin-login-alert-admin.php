<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://erich.biz
 * @since      1.0.0
 *
 * @package    Admin_Login_Alert
 * @subpackage Admin_Login_Alert/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Admin_Login_Alert
 * @subpackage Admin_Login_Alert/admin
 * @author     Vladimir Eric <murallez@gmail.com>
 */
class Admin_Login_Alert_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Admin_Login_Alert_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Admin_Login_Alert_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/admin-login-alert-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Admin_Login_Alert_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Admin_Login_Alert_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/admin-login-alert-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * when a user (of an admministrator level) logs in, send alert (with login details)
	 */
	public function send_alert($user_login, $user)
	{
		ve_debug_log("successful admin login", "admin_login");

		$user_ip = $_SERVER['REMOTE_ADDR'];

		$to = 'murallez@gmail.com';
		$subject = $user_login . ' ' . $user_ip . ' successfully logged to ' . esc_url(home_url()) . ' as administrator';
		$message = 'A user with Administrator privileges loged in to ' . esc_url(home_url());
		$message .= '<br />' . $user_login . " " . $user->user_email;
		$message .= '<br />user IP was: ' . $user_ip;

		$allowed_roles = array('administrator');
		$is_admin = array_intersect($allowed_roles, $user->roles);
		if ($is_admin) {
			ve_debug_log("Logged user is: ADMIN", "admin_login");

			// send email alert
			$sent = wp_mail($to, $subject, $message);

			if (!$sent) {
				ve_debug_log("Alert was not mailed! send_alert() failed to send an email on successful admin login", "error");
			}
			ve_debug_log("Alert was mailed! send_alert() succeeded to send an email on successful admin login", "admin_login");

			return;
		}
	}

	/**
	 * send an alert on user role change to admin
	 */
	public function get_role_change($id, $role)
	{

		$check = ['administrator'];

		// if role is of a monitored kind
		if (in_array($role, $check)) {
			// get user by id
			$user = get_user_by('id', $id);

			if (!is_object($user)) {
				// failed to get user from given ID
				return;
			}

			// send alert 
			$this->send_alert('', $user);
		}
	}
}
