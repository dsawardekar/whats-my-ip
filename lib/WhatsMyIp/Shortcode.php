<?php

namespace WhatsMyIp;

class Shortcode {

  public $templateRenderer;

  public $defaults = array(
    'country' => false,
    'coords' => false,
    'ip' => true,
    'mode' => 'inline'
  );

  function needs() {
    return array('templateRenderer');
  }

  function render($params) {
    $context  = $this->parse($params);
    $template = $this->getTemplate();

    return $this->templateRenderer->render($template, $context);
  }

  function parse($params) {
    $items = shortcode_atts($this->defaults, $params);

    if ($items['mode'] == 'inline') {
      $items['wrapper'] = 'span';
    } else {
      $items['wrapper'] = 'div';
    }

    $this->toBoolean($items, 'ip');
    $this->toBoolean($items, 'country');
    $this->toBoolean($items, 'coords');

    return $items;
  }

  function toBoolean(&$items, $key) {
    if (array_key_exists($key, $items)) {
      $items[$key] = filter_var($items[$key], FILTER_VALIDATE_BOOLEAN);
    }
  }

  function getTemplate() {
    return 'shortcode.twig';
  }
}
