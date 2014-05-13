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
      'whats-my-ip', array('dependencies' => 'jquery')
    );

    $this->scriptLoader->stream(
      'whats-my-ip-options', array('dependencies' => 'whats-my-ip')
    );

    $this->enabled = true;
  }

}
