<?php

namespace WhatsMyIp;

use Encase\Container;
use Arrow\AssetManager\AssetManager;
use Arrow\PluginMeta;

class ScriptPlacerTest extends \PHPUnit_Framework_TestCase {

  public $container;
  public $placer;

  function setUp() {
    $this->container = new Container();
    $this->container->object('pluginMeta', new PluginMeta('foo.php'));
    $this->container->object('assetManager', new AssetManager($this->container));
    $this->container->singleton('scriptPlacer', 'WhatsMyIp\ScriptPlacer');

    $this->placer = $this->container->lookup('scriptPlacer');
  }

  function test_it_has_a_script_loader() {
    $this->assertEquals(
      $this->container->lookup('scriptLoader'),
      $this->placer->scriptLoader
    );
  }

  function test_it_is_not_enabled_initially() {
    $this->assertFalse($this->placer->enabled);
  }

  function test_it_can_be_enabled() {
    $this->placer->enable();
    $this->assertTrue($this->placer->enabled);
  }

  function test_it_can_enqueue_scripts() {
    $this->placer->enable();

    do_action('wp_enqueue_scripts');

    $this->assertTrue(wp_script_is('whats-my-ip', 'enqueued'));
    $this->assertTrue(wp_script_is('whats-my-ip-options', 'enqueued'));
  }
}
