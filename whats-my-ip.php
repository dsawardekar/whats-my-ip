<?php
/*
Plugin Name: whats-my-ip
Description: Display User's IP address via Widget or Shortcode
Version: 0.1.0
Author: Darshan Sawardekar
Author URI: http://pressing-matters.io/
Plugin URI: http://wordpress.org/plugins/whats-my-ip
License: GPLv2
*/

require_once(__DIR__ . '/vendor/autoload.php');

use PressingMatters\WhatsMyIpPlugin;

$whats_my_ip_plugin = WhatsMyIpPlugin::create(__FILE__);
$whats_my_ip_plugin->enable();
