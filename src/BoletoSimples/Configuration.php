<?php

namespace BoletoSimples;

const VERSION = "0.0.1";

class Configuration {
  private $environments_uri = array('sandbox' => 'https://sandbox.boletosimples.com.br/api/v1', 'production' => 'https://boletosimples.com.br/api/v1');
  public $environment = null;
  public $application_id = null;
  public $application_secret = null;
  public $access_token = null;

  function __construct() {
    $this->environment = ($_ENV['BOLETOSIMPLES_ENV'] === null ? 'sandbox' : $_ENV['BOLETOSIMPLES_ENV']);
    $this->application_id = $_ENV['BOLETOSIMPLES_APP_ID'];
    $this->application_secret = $_ENV['BOLETOSIMPLES_APP_SECRET'];
    $this->access_token = $_ENV['BOLETOSIMPLES_ACCESS_TOKEN'];
  }

  function configure($params) {
    $this->environment = $params['environment'];
    $this->application_id = $params['application_id'];
    $this->application_secret = $params['application_secret'];
    $this->access_token = $params['access_token'];
  }

  function userAgent() {
    return "BoletoSimples PHP Client v".VERSION." (contato@boletosimples.com.br)";
  }

  function hasAccessToken() {
    return $this->access_token != null;
  }

  function baseUri() {
    return $this->environments_uri[$this->environment];
  }

}

?>