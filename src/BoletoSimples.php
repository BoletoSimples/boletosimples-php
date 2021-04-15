<?php

class BoletoSimples {
  const VERSION = "1.0.0";
  public static $configuration = null;
  public static $last_request = null;

  public static function configure($params = array()) {
    BoletoSimples::$configuration = new BoletoSimples\Configuration($params);
  }

}

BoletoSimples::configure();
