<?php

namespace PressingMatters;

use Encase\Container;

class ScriptPlacerTest extends \PHPUnit_Framework_TestCase {

  public $container;
  public $placer;

  function setUp() {
    $this->container = new Container();
    $this->container->singleton('placer', 'PressingMatters\\ScriptPlacer');
    $this->container->object('baseDir', getcwd());

    $this->placer = $this->container->lookup('placer');
  }

  function test_it_has_a_base_dir() {
    $this->assertEquals(getcwd(), $this->placer->baseDir);
  }

  function test_it_can_build_plugin_file_from_base_dir() {
    $file = $this->placer->getPluginFile();
    $this->assertStringStartsWith(getcwd(), $file);
  }

  function test_it_can_build_url_for_script() {
    $name = 'whats-my-ip';
    $url = $this->placer->urlFor($name);
    $expected = "/js\/" . $name . '.js$/';

    $this->assertRegExp($expected, $url);
  }

  function test_it_can_register_script_without_dependencies() {
    $this->placer->registerScript('whats-my-ip');
    $actual = wp_script_is('whats-my-ip', 'registered');

    $this->assertTrue($actual);
  }

  function test_it_can_register_script_with_dependencies() {
    $this->placer->registerScript('foo');
    $this->placer->registerScript('bar', array('foo'));
    $actual = wp_script_is('bar', 'registered');

    $this->assertTrue($actual);
  }

  function test_it_can_register_multiple_scripts() {
    $scripts = array(
      'foo' => null,
      'bar' => 'foo'
    );

    $this->placer->registerScripts($scripts);

    $this->assertTrue(wp_script_is('foo', 'registered'));
    $this->assertTrue(wp_script_is('bar', 'registered'));
  }

  function test_it_can_register_default_scripts() {
    $this->placer->register();
    $this->assertTrue(wp_script_is('whats-my-ip', 'registered'));
  }

  function test_it_can_enable_scripts() {
    $this->placer->enable();
    $this->assertTrue(wp_script_is('whats-my-ip', 'enqueued'));
  }

}
