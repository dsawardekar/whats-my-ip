<?php

namespace WhatsMyIp;

use Encase\Container;
use Arrow\AssetManager\AssetManager;

class Plugin {

  public $container;
  static public $instance = null;

  static public function create($file) {
    if (is_null(self::$instance)) {
      self::$instance = new Plugin($file);
    }

    return self::$instance;
  }

  static public function getInstance() {
    return self::$instance;
  }

  function __construct($file) {
    $this->container = new Container();
    $this->container
      ->object('pluginMeta', new PluginMeta($file))
      ->object('assetManager', new AssetManager($this->container))
      ->singleton('shortcode', 'WhatsMyIp\Shortcode')
      ->singleton('twigHelper', 'Arrow\TwigHelper\TwigHelper')
      ->singleton('scriptPlacer', 'WhatsMyIp\ScriptPlacer')
      ->initializer('twigHelper', array($this, 'initializeTwig'));
  }

  function lookup($key) {
    return $this->container->lookup($key);
  }

  function initializeTwig($twigHelper, $container) {
    $twigHelper->setBaseDir($container->lookup('pluginMeta')->getDir());
  }

  function enable() {
    add_shortcode('whatsmyip', array($this, 'doShortcode'));
    add_action('widgets_init', array($this, 'registerWidget'));
  }

  function doShortcode($params) {
    $this->lookup('scriptPlacer')->enable();
    return $this->lookup('shortcode')->render($params);
  }

  function registerWidget() {
    register_widget('WhatsMyIp\Widget');
  }
}
