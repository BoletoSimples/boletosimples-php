<?php

require_once 'vendor/autoload.php';
use ActiveResource\ActiveResource;

require_once dirname (__FILE__) . '/BoletoSimples/Resources/BaseResource.php';
require_once dirname (__FILE__) . '/BoletoSimples/Resources/BankBillet.php';

class BoletoSimples {
  private $configuration = null;

  function configure($params) {
    $this->configuration = new BoletoSimples\Configuration;
    $this->configuration->configure($params);
    return true;
  }

  function configuration() {
    return $this->configuration;
  }
}


?>