<?php

require_once 'vendor/autoload.php';

require_once dirname (__FILE__) . '/BoletoSimples/Resources/BaseResource.php';
require_once dirname (__FILE__) . '/BoletoSimples/Resources/BankBillet.php';

class BoletoSimples {
  public static $configuration = null;

  static function configure($params = array()) {
    BoletoSimples::$configuration = new BoletoSimples\Configuration($params);
  }

}

BoletoSimples::configure();

?>