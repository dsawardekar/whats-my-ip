<?php

namespace WhatsMyIp;

class PluginMeta extends \Arrow\PluginMeta {

  function getVersion() {
    return Version::$version;
  }

}
