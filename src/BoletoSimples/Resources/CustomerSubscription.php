<?php

namespace BoletoSimples;

class CustomerSubscription extends BaseResource {
  public function next_charge() {
    $response = self::sendRequest('POST', $this->path('next_charge'));
    return $this->parseResponse($response);
  }
}