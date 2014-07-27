<?php

namespace WhatsMyIp;

use Arrow\AssetManager\AssetManager;

class Plugin extends \Arrow\Plugin {

  function __construct($file) {
    parent::__construct($file);
    $this->container
      ->object('pluginMeta'      , new PluginMeta($file))
      ->packager('assetPackager' , 'Arrow\Asset\Packager')
      ->packager('twigPackager'  , 'Arrow\Twig\Packager')
      ->singleton('shortcode'    , 'WhatsMyIp\Shortcode')
      ->singleton('scriptPlacer' , 'WhatsMyIp\ScriptPlacer');
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
