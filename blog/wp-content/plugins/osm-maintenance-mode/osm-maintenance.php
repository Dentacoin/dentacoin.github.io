<?php

/*
Plugin Name: OSM Maintenance Mode
Plugin URI: http://ohseemedia.com/plugins/osm-maintenace
Description: A simple maintenance mode plugin based on IP for WordPress.
Version: 0.0.1
Author: Oh See Media (Owen Conti)
Author URI: http://ohseemedia.com/
License: GPL2
*/

if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

class OSMMaintenance {

	public function __construct() {
		register_activation_hook(__FILE__, array(&$this, "activate"));
		register_deactivation_hook(__FILE__, array(&$this, "deactivate"));
		
		if (is_multisite()) {
			add_action("network_admin_menu", array(&$this, "admin_menu"));
		}
		add_action("admin_menu", array(&$this, "admin_menu"));
		add_action("init", array(&$this, "init"));
		add_action("plugins_loaded", array(&$this, "do_maintenance_check"));
	}
	
	public function activate() {
		
	}
	
	public function deactivate() {
		
	}
	
	public function init() {
		// if no IPs whitelisted then display a notice
		if (is_admin() && !isset($_POST["osm_submit"])) { 
			$whitelist = $this->getWhitelist();
			if (count($whitelist) == 1) {
				add_action("admin_notices", array(&$this, "admin_notice"));
			}
		}
	}
	
	public function admin_menu() {
		add_menu_page("OSM Maintenance", "OSM Maintenance", "activate_plugins", "osm-maintenance", array(&$this, "do_admin_page"), "", "100.1");
	}
	
	public function do_maintenance_check() {
		$ipArray = $this->getWhitelist();
		$userIP = $this->get_user_ip();
		
		if (!in_array($userIP, $ipArray) && !is_user_logged_in()) {
			wp_die(get_bloginfo("title") . " is in maintenance mode.");
		}
	}
	
	public function do_admin_page() {
		
		$delete = (isset($_GET["delete"])) ? stripslashes($_GET["delete"]) : false;
		$ipAddress = (isset($_GET["ip"])) ? stripslashes($_GET["ip"]) : null;
		$ipArray = $this->getWhitelist();
		
		// Get whitelisted IPs
		if ($delete) {
			if (in_array($ipAddress, $ipArray)) {
				$pos = array_search($ipAddress, $ipArray);
				unset($ipArray[$pos]);
			}
			$this->updateWhitelist($ipArray);
			
			$ipArray = $this->getWhitelist();
			include_once(plugin_dir_path(__FILE__) . "assets/templates/admin-page.php");
		} else if (isset($_POST["osm_submit"])) {
			$userIP = stripslashes($_POST["ip_address"]);
			if (!in_array($userIP, $ipArray)) {
				array_push($ipArray, $userIP);
			}
			$this->updateWhitelist($ipArray);
			
			$ipArray = $this->getWhitelist();
			include_once(plugin_dir_path(__FILE__) . "assets/templates/admin-page.php");
		} else {
			include_once(plugin_dir_path(__FILE__) . "assets/templates/admin-page.php");
		}
	}
	
	public function getWhitelist() {
		$whitelist = get_option("osm_maintenance_whitelist");
		$whitelist = explode(",", $whitelist);
		return $whitelist;
	}
	
	public function updateWhitelist($whitelist) {
		$whitelist = implode(",", $whitelist);
		
		update_option("osm_maintenance_whitelist", $whitelist);
	}
	
	public function admin_notice() {
		echo '<div class="error">
			<p>Error: OSM Maintenance mode is active, but no IP addresses have been whitelisted.</p>
		</div>';
	}
	
	public function get_user_ip() {
		$ip = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
		return $ip;
	}
}
$osmMaintenance = new OSMMaintenance();