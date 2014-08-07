<?php
/*
Plugin Name: whats-my-ip
Description: Display User's IP address via Widget or Shortcode
Version: 0.5.2
Author: Darshan Sawardekar
Author URI: http://pressing-matters.io/
Plugin URI: http://wordpress.org/plugins/whats-my-ip
License: GPLv2
*/

require_once(__DIR__ . '/vendor/dsawardekar/arrow/lib/Arrow/ArrowPluginLoader.php');

function whats_my_ip_main() {
  $options = array(
    'plugin'       => 'WhatsMyIp\Plugin',
    'arrowVersion' => '1.8.0'
  );

  ArrowPluginLoader::load(__FILE__, $options);
}

whats_my_ip_main();
