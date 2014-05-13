<?php
/*
Plugin Name: whats-my-ip
Description: Display User's IP address via Widget or Shortcode
Version: 0.1.8
Author: Darshan Sawardekar
Author URI: http://pressing-matters.io/
Plugin URI: http://wordpress.org/plugins/whats-my-ip
License: GPLv2
*/

require_once(__DIR__ . '/vendor/dsawardekar/wp-requirements/lib/Requirements.php');

function whats_my_ip_main() {
  $requirements = new WP_Requirements();

  if ($requirements->satisfied()) {
    whats_my_ip_load();
  } else {
    $plugin = new WP_Faux_Plugin('Whats My IP', $requirements->getResults());
    $plugin->activate(__FILE__);
  }
}

function whats_my_ip_load() {
  require_once(__DIR__ . '/vendor/dsawardekar/arrow/lib/Arrow/ArrowPluginLoader.php');

  $loader = ArrowPluginLoader::getInstance();
  $loader->register('whats-my-ip', '0.2.0', 'whats_my_ip_loaded');
}

function whats_my_ip_loaded() {
  require_once(__DIR__ . '/vendor/autoload.php');

  $plugin = \WhatsMyIp\Plugin::create(__FILE__);
  $plugin->enable();
}

whats_my_ip_main();
