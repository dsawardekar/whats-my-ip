<?php

namespace WhatsMyIp;

use Encase\Container;

class ShortcodeTest extends \PHPUnit_Framework_TestCase {

  public $shortcode;
  public $container;
  public $templateRenderer;

  function setUp() {
    $container = new Container();
    $container->object('pluginMeta', new \WhatsMyIp\PluginMeta('whats-my-ip.php'));
    $container->packager('twigPackager', 'Arrow\Twig\Packager');
    $container->singleton('shortcode', 'WhatsMyIp\Shortcode');

    $this->container  = $container;
    $this->shortcode  = $container->lookup('shortcode');
    $this->templateRenderer = $container->lookup('templateRenderer');
  }

  function test_it_has_a_template_renderer() {
    $helper = $this->shortcode->templateRenderer;
    $this->assertInstanceOf('Arrow\Twig\Renderer', $helper);
  }

  function test_it_can_convert_string_key_to_boolean() {
    $items = array('ip' => 'true');
    $this->shortcode->toBoolean($items, 'ip');
    $this->assertTrue($items['ip']);
  }

  function test_it_can_convert_falsy_string_key_to_boolean() {
    $items = array('country' => 'no');
    $this->shortcode->toBoolean($items, 'country');
    $this->assertFalse($items['country']);
  }

  function test_it_can_parse_shortcode_with_empty_params() {
    $params = shortcode_parse_atts('');
    $actual = $this->shortcode->parse($params);

    $this->assertTrue($actual['ip']);
    $this->assertFalse($actual['country']);
    $this->assertFalse($actual['coords']);
  }

  function test_it_can_parse_shortcode_with_country() {
    $params = shortcode_parse_atts('country=true');
    $actual = $this->shortcode->parse($params);

    $this->assertTrue($actual['ip']);
    $this->assertTrue($actual['country']);
    $this->assertFalse($actual['coords']);
  }

  function test_it_can_parse_shortcode_with_coords() {
    $params = shortcode_parse_atts('ip=no coords=yes country=yes');
    $actual = $this->shortcode->parse($params);

    $this->assertFalse($actual['ip']);
    $this->assertTrue($actual['country']);
    $this->assertTrue($actual['coords']);
  }

  function getMatcherFor($name) {
    $matcher = array(
      'tag' => 'span',
      'attributes' => array('class' => $name)
    );

    return $matcher;
  }

  function assertShortcodeTag($name, $html) {
    $matcher = $this->getMatcherFor($name);
    $this->assertTag($matcher, $html);
  }

  function assertNotShortcodeTag($name, $html) {
    $matcher = $this->getMatcherFor($name);
    $this->assertNotTag($matcher, $html);
  }

  function test_it_can_render_shortcode() {
    $params = shortcode_parse_atts('ip=no coords=yes country=yes');
    $html = $this->shortcode->render($params);

    $this->assertNotShortcodeTag('ip', $html);
    $this->assertShortcodeTag('country', $html);
    $this->assertShortcodeTag('coords', $html);
  }
}
