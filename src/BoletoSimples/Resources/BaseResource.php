<?php

namespace BoletoSimples;

use GuzzleHttp\Client;
use CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber;

class BaseResource {
  /**
   * The GuzzleHttp\Client object
   */
  public static $client = null;

  /**
   * Default options used on Guzzle requests
   */
  public static $default_options = null;

  /**
   * The attributes of the current object, accessed via the anonymous get/set methods.
   */
  private $_attributes = array();

  /**
   * Array with all errors returned from last request.
   */
  public $response_errors = array();

  /**
   * Constructor method.
   */
  public function __construct($attributes = array()) {
    $this->_attributes = $attributes;
    self::configure();
  }

  /**
   * Configure the GuzzleHttp\Client with default options.
   */
  public static function configure() {
    $config = \BoletoSimples::$configuration;
    if (!$config) {
      return;
    }

    $oauth2 = new Oauth2Subscriber();
    if ($config->access_token) {
      $oauth2->setAccessToken($config->access_token);
    }

    self::$client = new Client([
      'base_url' => $config->baseUri(),
      'defaults' => [
        'headers' => [
          'User-Agent' => $config->userAgent()
        ],
        'auth' => 'oauth2',
        'subscribers' => [$oauth2],
      ]
    ]);

    self::$default_options = ['headers' => ['Content-Type'=> 'application/json'], 'exceptions' => false];
  }

  public function attributes() {
    return $this->_attributes;
  }

  public function isNew() {
    return !isset($this->_attributes['id']) || $this->_attributes['id'] == null;
  }

  public function isPersisted() {
    return !$this->isNew();
  }

  public static function methodFor($action) {
    $methods = array(
      'create' => 'POST',
      'update' => 'PUT',
      'find' => 'GET',
      'destroy' => 'DELETE',
      'new' => 'GET'
    );
    return $methods[$action];
  }

  public static function statusCodeFor($action) {
    $codes = array(
      'create' => 201,
      'update' => 200,
      'find' => 200,
      'destroy' => 200,
      'new' => 200
    );
    return $codes[$action];
  }

  public static function find($id) {
    if(!$id) {
      throw new \Exception("Couldn't find " . get_called_class() . " without an ID.");
    }
    $class = get_called_class();
    $object = new $class(['id' => $id]);
    return $object->_find();
  }

  public static function create($attributes = array()) {
    $class = get_called_class();
    $object = new $class($attributes);
    $object->save();
    return $object;
  }

  public function save() {
    $action = $this->isNew() ? 'create' : 'update';
    return $this->_request($action);
  }

  public static function all($params = array()) {
    $class = get_called_class();
    $options = self::$default_options;
    $options = array_merge($options, ['query' => $params]);
    $response = self::$client->get($class::element_name_plural(), $options);
    $collection = [];
    if($response->getStatusCode() == 200) {
      foreach($response->json() as $attributes) {
        $collection[] = new $class($attributes);
      }
    }
    return $collection;
  }

  private function _find() {
    if($this->_request('find')) {
      return $this;
    } else {
      throw new \Exception("Couldn't find " . get_called_class() . " with 'id'=". $this->id);
    }
  }

  private function _request($action) {
    $class = get_called_class();
    $method = self::methodFor($action);
    $path = $this->isNew() ? $class::element_name_plural() : $class::element_name_plural() . "/". $this->_attributes['id'];
    $options = self::$default_options;
    if($method == 'POST') {
      $attributes = [$class::element_name() => $this->_attributes];
      $options = array_merge($options, ['json' => $attributes]);
    }

    $request = self::$client->createRequest($method, $path, $options);
    $response = self::$client->send($request);
    if($response->getStatusCode() == self::statusCodeFor($action)) {
      $this->_attributes = $response->json();
      return true;
    } else {
      if(isset($response->json()['errors'])) {
        $this->response_errors = $response->json()['errors'];
      }
      return false;
    }
  }

  /**
   * Getter for internal object data.
   */
  public function __get($k) {
    if (isset ($this->_attributes[$k])) {
      return $this->_attributes[$k];
    }
    return $this->{$k};
  }

  /**
   * Setter for internal object data.
   */
  public function __set($k, $v) {
    $this->_attributes[$k] = $v;
    $this->{$k} = $v;
  }

  public static function element_name() {
    // Allow class-defined element name or use class name if not defined
    $element_name = self::underscorize(get_called_class());

    // Detect for namespaces, and take just the class name
    if (stripos($element_name, '\\'))
    {
      $classItems = explode('\\', $element_name);
      $element_name = end($classItems);
    }
    return $element_name;
  }

  public static function element_name_plural() {
    return self::pluralize(self::element_name());
  }

  /**
   * Pluralize the element name.
   */
  private static function pluralize($word) {
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
  private static function underscorize($word){
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
