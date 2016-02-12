<?php

namespace BoletoSimples;

class Discharge extends BaseResource {
  public function pay_off() {
    $response = self::sendRequest('PUT', $this->path('pay_off'));
    return $this->parseResponse($response);
  }
}