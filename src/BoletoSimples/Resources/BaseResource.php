<?php

namespace BoletoSimples;

use GuzzleHttp\Client;
use CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber;

class BaseResource {
  /**
   * The GuzzleHttp\Client object
   */
  public $client = null;

	/**
	 * The data of the current object, accessed via the anonymous get/set methods.
	 */
	private $_data = array ();

  /**
   * The Oauth2Subscriber object
   */
  private $_oauth2 = null;

	/**
	 * Constructor method.
	 */
	function __construct ($data = array ()) {
		$this->_data = $data;
		// Allow class-defined element name or use class name if not defined
		$this->element_name = $this->element_name ? $this->element_name : strtolower (get_class ($this));
		$this->element_name_plural = $this->pluralize ($this->element_name);

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
  function configure() {
    $config = \BoletoSimples::$configuration;
    if(!$config) return;

    $oauth2 = new Oauth2Subscriber();
    if($config->access_token) $oauth2->setAccessToken($config->access_token);

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

	/**
	 * Pluralize the element name.
	 */
	function pluralize ($word) {
		$word .= 's';
		$word = preg_replace ('/(x|ch|sh|ss])s$/', '\1es', $word);
		$word = preg_replace ('/ss$/', 'ses', $word);
		$word = preg_replace ('/([ti])ums$/', '\1a', $word);
		$word = preg_replace ('/sises$/', 'ses', $word);
		$word = preg_replace ('/([^aeiouy]|qu)ys$/', '\1ies', $word);
		$word = preg_replace ('/(?:([^f])fe|([lr])f)s$/', '\1\2ves', $word);
		$word = preg_replace ('/ieses$/', 'ies', $word);
		if (isset ($this->pleural_corrections[$word])) {
			return $this->pleural_corrections[$word];
		}
		return $word;
	}

	/**
	 * Getter for internal object data.
	 */
	function __get ($k) {
		if (isset ($this->_data[$k])) {
			return $this->_data[$k];
		}
		return $this->{$k};
	}

	/**
	 * Setter for internal object data.
	 */
	function __set ($k, $v) {
		if (isset ($this->_data[$k])) {
			$this->_data[$k] = $v;
			return;
		}
		$this->{$k} = $v;
	}

	/**
	 * Quick setter for chaining methods.
	 */
	function set ($k, $v = false) {
		if (! $v && is_array ($k)) {
			foreach ($k as $key => $value) {
				$this->_data[$key] = $value;
			}
		} else {
			$this->_data[$k] = $v;
		}
		return $this;
	}
}

?>