<?php

namespace WhatsMyIp;

class PluginTest extends \PHPUnit_Framework_TestCase {

  public $plugin;

  function setUp() {
    $file = getcwd() . '/whats-my-ip.php';
    $this->plugin = new Plugin($file);
  }

  function test_it_has_a_container() {
    $container = $this->plugin->container;
    $this->assertInstanceOf('Encase\Container', $container);
  }

  function test_it_has_a_twig_helper() {
    $helper = $this->plugin->lookup('twigHelper');
    $this->assertInstanceOf('Arrow\TwigHelper\TwigHelper', $helper);
  }

  function test_it_has_a_shortcode() {
    $shortcode = $this->plugin->lookup('shortcode');
    $this->assertInstanceOf('WhatsMyIp\Shortcode', $shortcode);
  }

  function test_it_has_a_script_placer() {
    $placer = $this->plugin->lookup('scriptPlacer');
    $this->assertInstanceOf('WhatsMyIp\ScriptPlacer', $placer);
  }

  function test_it_can_render_shortcode() {
    $this->plugin->enable();

    $params = shortcode_parse_atts('');
    $html = $this->plugin->doShortcode($params);

    $matcher = array(
      'tag' => 'span',
      'attributes' => array('class' => 'ip')
    );

    do_action('wp_enqueue_scripts');

    $this->assertTag($matcher, $html);
    $this->assertTrue(wp_script_is('whats-my-ip', 'enqueued'));
    $this->assertTrue(wp_script_is('whats-my-ip-options', 'enqueued'));
  }

}
