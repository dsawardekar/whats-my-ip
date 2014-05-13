<?php

namespace PressingMatters;

class WhatsMyIpShortcode {

  public $twigHelper;

  public $defaults = array(
    'country' => false,
    'coords' => false,
    'ip' => true
  );

  function needs() {
    return array('twigHelper');
  }

  function render($params) {
    $context  = $this->parse($params);
    $template = $this->getTemplate();

    return $this->twigHelper->render($template, $context);
  }

  function parse($params) {
    $items = shortcode_atts($this->defaults, $params);

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
    return 'shortcode';
  }
}
