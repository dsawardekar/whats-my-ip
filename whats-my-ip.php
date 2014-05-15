<?php
/*
Plugin Name: whats-my-ip
Description: Display User's IP address via Widget or Shortcode
Version: 0.3.0
Author: Darshan Sawardekar
Author URI: http://pressing-matters.io/
Plugin URI: http://wordpress.org/plugins/whats-my-ip
License: GPLv2
*/

require_once(__DIR__ . '/vendor/dsawardekar/wp-requirements/lib/Requirements.php');

function whats_my_ip_main() {
  $requirements = new WP_Requirements();

  if ($requirements->satisfied()) {
    whats_my_ip_register();
  } else {
    $plugin = new WP_Faux_Plugin('Whats My IP', $requirements->getResults());
    $plugin->activate(__FILE__);
  }
}

function whats_my_ip_register() {
  require_once(__DIR__ . '/vendor/dsawardekar/arrow/lib/Arrow/ArrowPluginLoader.php');

  $loader = ArrowPluginLoader::getInstance();
  $loader->register(__FILE__, '0.5.1', 'whats_my_ip_load');
}

function whats_my_ip_load() {
  $plugin = \WhatsMyIp\Plugin::create(__FILE__);
  $plugin->enable();
}

whats_my_ip_main();
