<?php

namespace BoletoSimples;

class BankBillet extends BaseResource {
  public function cancel() {
    $response = self::sendRequest('PUT', $this->path('cancel'));
    return $this->parseResponse($response);
  }
}