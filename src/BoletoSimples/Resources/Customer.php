<?php

namespace BoletoSimples;

class Customer extends BaseResource {
  public static function cnpj_cpf($cnpj_cpf) {
    if (!$cnpj_cpf) {
      throw new \Exception("Couldn't find ".get_called_class()." without an cnpj or cpf.");
    }
    $response = self::sendRequest('GET', 'customers/cnpj_cpf', ['query' => ['q' => $cnpj_cpf]]);
    return new Customer($response->json());
  }
  public static function email($email) {
    if (!$email) {
      throw new \Exception("Couldn't find ".get_called_class()." without an email.");
    }
    $response = self::sendRequest('GET', 'customers/email', ['query' => ['q' => $email]]);
    return new Customer($response->json());
  }
}
