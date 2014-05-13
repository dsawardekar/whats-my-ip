<?php

namespace WhatsMyIp;

class ScriptPlacer {

  public $enabled = false;

  function needs() {
    return array('scriptLoader');
  }

  function enable() {
    if ($this->enabled) {
      return;
    }

    $this->scriptLoader->stream('whats-my-ip', array('jquery'));
    $this->scriptLoader->stream('whats-my-ip-options', array('whats-my-ip'));

    $this->enabled = true;
  }

}
