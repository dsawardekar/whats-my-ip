<?php

namespace WhatsMyIp;

class ScriptPlacer {

  public $enabled = false;
  public $scriptLoader;

  function needs() {
    return array('scriptLoader');
  }

  function enable() {
    if ($this->enabled) {
      return;
    }

    $this->scriptLoader->stream(
      'whats-my-ip', array('dependencies' => array('jquery'))
    );

    $this->scriptLoader->stream(
      'whats-my-ip-options', array('dependencies' => array('whats-my-ip'))
    );

    $this->enabled = true;
  }

}
