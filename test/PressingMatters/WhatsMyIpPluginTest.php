<?php

namespace PressingMatters;

class WhatsMyIpPluginTest extends \PHPUnit_Framework_TestCase {

  public $plugin;

  function setUp() {
    $this->plugin = new WhatsMyIpPlugin();
  }

  function test_it_has_a_container() {
    $container = $this->plugin->container;
    $this->assertInstanceOf('Encase\\Container', $container);
  }

  function test_it_has_a_twig_helper() {
    $helper = $this->plugin->getTwigHelper();
    $this->assertInstanceOf('WordPress\\TwigHelper', $helper);
  }

}
