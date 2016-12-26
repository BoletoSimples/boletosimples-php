<?php

class ExtraTest extends PHPUnit_Framework_TestCase {
  /**
   * @before
   */
  public function setupSomeFixtures()
  {
    BoletoSimples::configure(['environment' => 'sandbox']);
  }

  /**
   * @vcr extra/userinfo
   * ATENÇÃO: Após apagar a fixture extra/userinfo e rodar o teste denovo,
   * edite o arquivo e remova o token do login_url por questão de segurança.
   */
  public function testUserinfo() {
    $this->subject = BoletoSimples\Extra::userinfo();
    $this->assertEquals(array_keys($this->subject), ["id","login_url","email","account_type","first_name","middle_name","last_name","full_name","cpf","date_of_birth","mother_name","father_name","account_level","phone_number","address_street_name","address_number","address_complement","address_neighborhood","address_postal_code","address_city_name","address_state","business_name","business_cnpj","business_legal_name","balance_cents"]);
  }
}
