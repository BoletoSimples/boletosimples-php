<?php

namespace BoletoSimples;

class ResponseError extends \Exception {
  /**
   * GuzzleHttp\Message\Response object
   */
  public $response = null;

  /**
   * Constructor method.
   */
  public function __construct($response) {
    $this->response = $response;

    $json = $response->json();
    if (isset($json['error'])) {
      $this->message = $json['error'];
      throw $this;
    }
  }
}