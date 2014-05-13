<?php

namespace PressingMatters;

class ScriptPlacer {

  public $baseDir;
  public $registered = false;
  public $enabled = false;
  public $pluginFile = null;

  function needs() {
    return array('baseDir');
  }

  function getScripts() {
    return array(
      'whats-my-ip' => array('jquery'),
      'whats-my-ip-run' => array('jquery', 'whats-my-ip')
    );
  }

  function enable() {
    if ($this->enabled) {
      return;
    }

    if (!$this->registered) {
      $this->register();
    }

    $scripts = $this->getScripts();
    foreach ($scripts as $name => $depends) {
      $this->enableScript($name);
    }

    $this->enabled = true;
  }

  function register() {
    $this->registerScripts($this->getScripts());
    $this->registered = true;
  }

  function enableScript($name) {
    wp_enqueue_script($name);
  }

  function registerScripts($scripts) {
    foreach ($scripts as $name => $depends) {
      $this->registerScript($name, $depends);
    }
  }

  function registerScript($name, $depends = null) {
    if (is_null($depends)) {
      wp_register_script($name, $this->urlFor($name));
    } else {
      wp_register_script($name, $this->urlFor($name), $depends);
    }
  }

  function urlFor($scriptName) {
    return plugins_url("js/${scriptName}.js", $this->getPluginFile());
  }

  function getPluginFile() {
    if (is_null($this->pluginFile)) {
      $pluginName = basename($this->baseDir);
      $this->pluginFile = "$this->baseDir/${pluginName}.php";
    }

    return $this->pluginFile;
  }

}
