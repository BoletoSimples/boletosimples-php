<?php

class BoletoSimples {
  public static $configuration = null;

  public static function configure($params = array()) {
    BoletoSimples::$configuration = new BoletoSimples\Configuration($params);
  }

}
