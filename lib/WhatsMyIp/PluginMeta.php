<?php

namespace WhatsMyIp;

class PluginMeta extends \Arrow\PluginMeta {

  function __construct($file) {
    parent::__construct($file);
    $this->version = Version::$version;
  }

}
