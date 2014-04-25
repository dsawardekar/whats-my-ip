<?php

namespace PressingMatters;

use Encase\Container;
use WordPress\TwigHelper;

class WhatsMyIpPlugin {

  public $container;

  function __construct() {
    $this->container = new Container();
    $this->container->factory('twig_helper', 'WordPress\\TwigHelper', true);
  }

  function getTwigHelper() {
    return $this->container->lookup('twig_helper');
  }
}
