<?php

namespace PressingMatters;

use Encase\Container;
use WordPress\TwigHelper;
use PressingMatters\WhatsMyIpShortcode;
use PressingMatters\ScriptPlacer;

class WhatsMyIpPlugin {

  public $container;

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
  }

  function doShortcode($params) {
    $this->lookup('scriptPlacer')->enable();
    return $this->lookup('shortcode')->render($params);
  }
}
