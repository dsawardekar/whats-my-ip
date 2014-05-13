<?php

namespace PressingMatters;

class WhatsMyIpPluginTest extends \PHPUnit_Framework_TestCase {

  public $plugin;

  function setUp() {
    $file = getcwd() . '/whats-my-ip.php';
    $this->plugin = new WhatsMyIpPlugin($file);
  }

  function test_it_has_a_container() {
    $container = $this->plugin->container;
    $this->assertInstanceOf('Encase\\Container', $container);
  }

  function test_it_has_a_base_dir() {
    $dir = $this->plugin->lookup('baseDir');
    $this->assertStringStartsWith(getcwd(), $dir);
  }

  function test_it_has_a_twig_helper() {
    $helper = $this->plugin->lookup('twigHelper');
    $this->assertInstanceOf('WordPress\\TwigHelper', $helper);
  }

  function test_it_has_a_shortcode() {
    $shortcode = $this->plugin->lookup('shortcode');
    $this->assertInstanceOf('PressingMatters\\WhatsMyIpShortcode', $shortcode);
  }

  function test_it_has_a_script_placer() {
    $placer = $this->plugin->lookup('scriptPlacer');
    $this->assertInstanceOf('PressingMatters\\ScriptPlacer', $placer);
  }

  function test_it_can_render_shortcode() {
    $this->plugin->enable();

    $params = shortcode_parse_atts('');
    $html = $this->plugin->doShortcode($params);

    $matcher = array(
      'tag' => 'p',
      'attributes' => array('class' => 'ip')
    );

    $this->assertTag($matcher, $html);
    $this->assertTrue(wp_script_is('whats-my-ip', 'enqueued'));
    $this->assertTrue(wp_script_is('whats-my-ip-run', 'enqueued'));
  }

}
