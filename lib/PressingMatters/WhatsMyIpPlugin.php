<?php

namespace PressingMatters;

use Encase\Container;
use WordPress\TwigHelper;
use PressingMatters\WhatsMyIpShortcode;
use PressingMatters\ScriptPlacer;
use PressingMatters\WhatsMyIpWidget;

class WhatsMyIpPlugin {

  public $container;
  static public $instance = null;

  static public function create($file) {
    self::$instance = new WhatsMyIpPlugin($file);
    return self::$instance;
  }

  static public function instance() {
    return self::$instance;
  }

  function __construct($file) {
    $this->container = new Container();
    $this->container->object('baseDir', plugin_dir_path($file));
    $this->container->singleton('twigHelper', 'WordPress\\TwigHelper');
    $this->container->singleton('shortcode', 'PressingMatters\\WhatsMyIpShortcode');
    $this->container->singleton('scriptPlacer', 'PressingMatters\\ScriptPlacer');
  }

  function lookup($key) {
    return $this->container->lookup($key);
  }

  function enable() {
    $twigHelper = $this->lookup('twigHelper');
    $twigHelper->setBaseDir($this->lookup('baseDir'));

    add_shortcode('whatsmyip', array($this, 'doShortcode'));
    add_action('widgets_init', array($this, 'registerWidget'));
  }

  function doShortcode($params) {
    $this->lookup('scriptPlacer')->enable();
    return $this->lookup('shortcode')->render($params);
  }

  function registerWidget() {
    register_widget('PressingMatters\\WhatsMyIpWidget');
  }
}
