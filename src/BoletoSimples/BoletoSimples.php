<?php

class BoletoSimples {
  public static $configuration = null;

  static public function configure($params = array()) {
    BoletoSimples::$configuration = new BoletoSimples\Configuration($params);
  }

}
