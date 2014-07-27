<?php

namespace WhatsMyIp;

class Widget extends \WP_Widget {

  public $templateRenderer;
  public $defaults = array(
    'ip' => true,
    'country' => false,
    'coords' => false,
    'title' => ''
  );

  function needs() {
    return array('templateRenderer');
  }

  function __construct() {
    parent::__construct(
      'whats-my-ip-widget',
      'What\'s My IP',
      array('description' => 'Displays Current User\'s IP Address')
    );
  }

  function widget($args, $instance) {
    $params = $this->toParams($instance);
    $this->renderTemplate('widget', $params);
    $this->lookup('scriptPlacer')->enable();
  }

  function form($instance) {
    $params = $this->toParams($instance);
    $context = array(
      'title_id' => $this->get_field_id('title'),
      'title_name' => $this->get_field_name('title'),
      'title_label' => 'Title',
      'title_value' => $params['title'],

      'ip_id' => $this->get_field_id('ip'),
      'ip_name' => $this->get_field_name('ip'),
      'ip_label' => 'Show IP Address',
      'ip_checked' => $this->toChecked($params['ip']),

      'country_id' => $this->get_field_id('country'),
      'country_name' => $this->get_field_name('country'),
      'country_label' => 'Show Country',
      'country_checked' => $this->toChecked($params['country']),

      'coords_id' => $this->get_field_id('coords'),
      'coords_name' => $this->get_field_name('coords'),
      'coords_label' => 'Show Latitude & Longitude',
      'coords_checked' => $this->toChecked($params['coords'])
    );

    $this->renderTemplate('widget_form', $context);
  }

  function update($new, $old) {
    $instance            = $old;
    $instance['ip']      = $this->pickOption('ip', $new);
    $instance['country'] = $this->pickOption('country', $new);
    $instance['coords']  = $this->pickOption('coords', $new);
    $instance['title']   = strip_tags($new['title']);

    return $instance;
  }

  function pickOption($key, $opts) {
    if (array_key_exists($key, $opts)) {
      return filter_var($opts[$key], FILTER_VALIDATE_BOOLEAN);
    } else {
      return false;
    }
  }

  function toParams(&$instance) {
    $params            = wp_parse_args($instance, $this->defaults);
    $params['ip']      = filter_var($params['ip'], FILTER_VALIDATE_BOOLEAN);
    $params['country'] = filter_var($params['country'], FILTER_VALIDATE_BOOLEAN);
    $params['coords']  = filter_var($params['coords'], FILTER_VALIDATE_BOOLEAN);
    $params['title']   = strip_tags($params['title']);

    return $params;
  }

  function toChecked($value) {
    return $value === true ? 'checked' : '';
  }

  function renderTemplate($template, &$context) {
    $template = $template . '.twig';
    $helper   = $this->getTemplateRenderer();
    $helper->display($template, $context);
  }

  function getTemplateRenderer() {
    if (is_null($this->templateRenderer)) {
      $this->inject();
    }

    return $this->templateRenderer;
  }

  function getContainer() {
    return Plugin::getInstance()->container;
  }

  function inject() {
    return $this->getContainer()->inject($this);
  }

  function lookup($key) {
    return $this->getContainer()->lookup($key);
  }

}
