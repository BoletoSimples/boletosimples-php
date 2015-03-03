<?php

namespace BoletoSimples;

use GuzzleHttp\Client;
use CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber;

class BaseResource {
  /**
   * The data of the current object, accessed via the anonymous get/set methods.
   */
  private $_data = array();

  /**
   * Element name used in path of member requests
   */
  private $element_name = null;

  /**
   * Element name in plural used in path of collection requests
   */
  private $element_name_plural = null;

  /**
   * The GuzzleHttp\Client object
   */
  public $client = null;

  /**
   * Array with all errors returned from last request.
   */
  public $response_errors = array();

  /**
   * Constructor method.
   */
  public function __construct($data = array()) {
    $this->_data = $data;

    // Allow class-defined element name or use class name if not defined
    $this->element_name = $this->element_name ? $this->element_name : $this->underscorize(get_class($this));
    $this->element_name_plural = $this->pluralize($this->element_name);

    // Detect for namespaces, and take just the class name
    if (stripos($this->element_name, '\\'))
    {
      $classItems = explode('\\', $this->element_name);
      $this->element_name = end($classItems);
    }
    $this->configure();
  }

  /**
   * Configure the GuzzleHttp\Client with default options.
   */
  public function configure() {
    $config = \BoletoSimples::$configuration;
    if (!$config) {
      return;
    }

    $oauth2 = new Oauth2Subscriber();
    if ($config->access_token) {
      $oauth2->setAccessToken($config->access_token);
    }

    $this->client = new Client([
      'base_url' => $config->baseUri(),
      'defaults' => [
        'headers' => [
          'User-Agent' => $config->userAgent()
        ],
        'auth' => 'oauth2',
        'subscribers' => [$oauth2],
      ]
    ]);
  }

  public static function methodFor($action) {
    return array(
      'create' => 'POST',
      'update' => 'PUT',
      'find' => 'GET',
      'destroy' => 'DELETE',
      'new' => 'GET'
    )[$action];
  }

  public static function statusCodeFor($action) {
    return array(
      'create' => 201,
      'update' => 200,
      'find' => 200,
      'destroy' => 200,
      'new' => 200
    )[$action];
  }

  public static function create($attributes = array()) {
    $class = get_called_class();
    $object = new $class($attributes);
    $object->save();
    return $object;
  }

  public function save() {
    $action = $this->isNew() ? 'create' : 'update';
    $method = self::methodFor($action);
    $path = $this->isNew() ? $this->element_name_plural : $this->element_name_plural . "/". $this->_data['id'];
    $attributes = [$this->element_name => $this->_data];

    $request = $this->client->createRequest($method, $path, ['headers' => ['Content-Type'=> 'application/json'], 'json' => $attributes, 'exceptions' => false]);
    $response = $this->client->send($request);

    if($response->getStatusCode() == self::statusCodeFor($action)) {
      $this->_data = $response->json();
      return true;
    } else {
      $this->response_errors = $response->json()['errors'];
      return false;
    }
  }

  public function attributes() {
    return $this->_data;
  }

  public function isNew() {
    return !isset($this->_data['id']) || $this->_data['id'] == null;
  }

  public function isPersisted() {
    return !$this->isNew();
  }

  /**
   * Getter for internal object data.
   */
  public function __get($k) {
    if (isset ($this->_data[$k])) {
      return $this->_data[$k];
    }
    return $this->{$k};
  }

  /**
   * Setter for internal object data.
   */
  public function __set($k, $v) {
    if (isset ($this->_data[$k])) {
      $this->_data[$k] = $v;
      return;
    }
    $this->{$k} = $v;
  }

  /**
   * Pluralize the element name.
   */
  private function pluralize($word) {
    $word .= 's';
    $word = preg_replace('/(x|ch|sh|ss])s$/', '\1es', $word);
    $word = preg_replace('/ss$/', 'ses', $word);
    $word = preg_replace('/([ti])ums$/', '\1a', $word);
    $word = preg_replace('/sises$/', 'ses', $word);
    $word = preg_replace('/([^aeiouy]|qu)ys$/', '\1ies', $word);
    $word = preg_replace('/(?:([^f])fe|([lr])f)s$/', '\1\2ves', $word);
    $word = preg_replace('/ieses$/', 'ies', $word);
    return $word;
  }

  /**
   * Undescorize the element name.
   */
  private function underscorize($word){
    $word = preg_replace('/[\'"]/', '', $word);
    $word = preg_replace('/[^a-zA-Z0-9]+/', '_', $word);
    $word = preg_replace('/([A-Z\d]+)([A-Z][a-z])/', '\1_\2', $word);
    $word = preg_replace('/([a-z\d])([A-Z])/', '\1_\2', $word);
    $word = trim($word, '_');
    $word = strtolower($word);
    $word = str_replace('boleto_simples_','', $word);
    return $word;
  }

}
