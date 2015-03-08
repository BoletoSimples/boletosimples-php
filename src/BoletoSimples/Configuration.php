<?php

namespace BoletoSimples;

class Configuration {
  private $environments_uri = array('sandbox' => 'https://sandbox.boletosimples.com.br/api/v1/', 'production' => 'https://boletosimples.com.br/api/v1/');
  public $environment = null;
  public $application_id = null;
  public $application_secret = null;
  public $access_token = null;

  public function __construct($params = array()) {
    $this->environment = isset($params['environment']) ? $params['environment'] : (getenv('BOLETOSIMPLES_ENV') ? getenv('BOLETOSIMPLES_ENV') : 'sandbox');
    $this->application_id = isset($params['application_id']) ? $params['application_id'] : (getenv('BOLETOSIMPLES_APP_ID') ? getenv('BOLETOSIMPLES_APP_ID') : null);
    $this->application_secret = isset($params['application_secret']) ? $params['application_secret'] : (getenv('BOLETOSIMPLES_APP_SECRET') ? getenv('BOLETOSIMPLES_APP_SECRET') : null);
    $this->access_token = isset($params['access_token']) ? $params['access_token'] : (getenv('BOLETOSIMPLES_ACCESS_TOKEN') ? getenv('BOLETOSIMPLES_ACCESS_TOKEN') : null);
  }

  public function userAgent() {
    return "BoletoSimples PHP Client v".\BoletoSimples::VERSION." (contato@boletosimples.com.br)";
  }

  public function hasAccessToken() {
    return $this->access_token != null;
  }

  public function baseUri() {
    return $this->environments_uri[$this->environment];
  }

}
