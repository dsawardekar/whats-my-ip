<?php

namespace WhatsMyIp;

use Arrow\AssetManager\AssetManager;

class Plugin extends \Arrow\Plugin {

  function __construct($file) {
    parent::__construct($file);
    $this->container
      ->object('pluginMeta', new PluginMeta($file))
      ->object('assetManager', new AssetManager($this->container))
      ->singleton('shortcode', 'WhatsMyIp\Shortcode')
      ->singleton('twigHelper', 'Arrow\TwigHelper\TwigHelper')
      ->singleton('scriptPlacer', 'WhatsMyIp\ScriptPlacer')
      ->initializer('twigHelper', array($this, 'initializeTwig'));
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
