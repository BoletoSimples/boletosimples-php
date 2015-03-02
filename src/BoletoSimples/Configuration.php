<?php

namespace BoletoSimples;

const VERSION = "0.0.1";

class Configuration {
  private $environments_uri = array('sandbox' => 'https://sandbox.boletosimples.com.br/api/v1', 'production' => 'https://boletosimples.com.br/api/v1');
  public $environment = null;
  public $application_id = null;
  public $application_secret = null;
  public $access_token = null;

  function __construct($params = array()) {
    $this->environment = isset($params['environment']) ? $params['environment'] : (isset($_ENV['BOLETOSIMPLES_ENV']) ? $_ENV['BOLETOSIMPLES_ENV'] : 'sandbox');
    $this->application_id =  isset($params['application_id']) ? $params['application_id'] : (isset($_ENV['BOLETOSIMPLES_ENV']) ? $_ENV['BOLETOSIMPLES_APP_ID'] : null);
    $this->application_secret =  isset($params['application_secret']) ? $params['application_secret'] : (isset($_ENV['BOLETOSIMPLES_APP_SECRET']) ? $_ENV['BOLETOSIMPLES_APP_SECRET'] : null);
    $this->access_token =  isset($params['access_token']) ? $params['access_token'] : (isset($_ENV['BOLETOSIMPLES_ACCESS_TOKEN']) ? $_ENV['BOLETOSIMPLES_ACCESS_TOKEN'] : null);
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