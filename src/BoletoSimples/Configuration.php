<?php

namespace BoletoSimples;

class Configuration {
  private $environments_uri = array('sandbox' => 'https://sandbox.boletosimples.com.br/api/v1/', 'production' => 'https://boletosimples.com.br/api/v1/');
  public $environment = null;
  public $api_token = null;
  public $user_agent = null;

  public function __construct($params = array()) {
    $default_environment = getenv('BOLETOSIMPLES_ENV') ? getenv('BOLETOSIMPLES_ENV') : 'sandbox';
    $default_user_agent = getenv('BOLETOSIMPLES_USER_AGENT') ? getenv('BOLETOSIMPLES_USER_AGENT') : null;
    $default_api_token = getenv('BOLETOSIMPLES_API_TOKEN') ? getenv('BOLETOSIMPLES_API_TOKEN') : null;

    $this->environment = isset($params['environment']) ? $params['environment'] : $default_environment;
    $this->user_agent = isset($params['user_agent']) ? $params['user_agent'] : $default_user_agent;
    $this->api_token = isset($params['api_token']) ? $params['api_token'] : $default_api_token;
  }

  public function userAgent() {
    return $this->user_agent != null;
  }

  public function hasAccessToken() {
    return $this->api_token != null;
  }

  public function baseUri() {
    return $this->environments_uri[$this->environment];
  }

}