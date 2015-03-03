<?php

class BankBilletTest extends PHPUnit_Framework_TestCase {
  /**
   * @before
   */
  public function setupSomeFixtures()
  {
    BoletoSimples::configure(['environment' => 'sandbox']);
  }

  public function testConstruct () {
    $subject = new BoletoSimples\BankBillet(array ('foo' => 'bar'));

    $this->assertEquals ($subject->foo, 'bar');
    $subject->foo = 'asdf';
    $this->assertEquals ($subject->foo, 'asdf');
    $this->assertEquals ($subject->attributes(), array ('foo' => 'asdf'));
    $this->assertEquals ($subject->element_name, 'bank_billet');
    $this->assertEquals ($subject->element_name_plural, 'bank_billets');
  }

  /**
   * @vcr bank_billets/create
   */
  public function testCreate() {
    $bank_billet = BoletoSimples\BankBillet::create(array (
      'amount' => '9,01',
      'description' => 'Despesas do contrato 0012',
      'expire_at' => '2014-01-01',
      'customer_address' => 'Rua quinhentos',
      'customer_address_complement' => 'Sala 4',
      'customer_address_number' => '111',
      'customer_city_name' => 'Rio de Janeiro',
      'customer_cnpj_cpf' => '012.345.678-90',
      'customer_email' => 'cliente@example.com',
      'customer_neighborhood' => 'Sao Francisco',
      'customer_person_name' => 'Joao da Silva',
      'customer_person_type' => 'individual',
      'customer_phone_number' => '2112123434',
      'customer_state' => 'RJ',
      'customer_zipcode' => '12312-123',
      'notification_url' => 'http://example.com.br/notify'
    ));

    $this->assertTrue($bank_billet instanceof \BoletoSimples\BankBillet);
    $this->assertTrue ($bank_billet->isPersisted());
    $this->assertEquals ($bank_billet->response_errors, array());
    $this->assertEquals (array_keys($bank_billet->attributes()), ["id","expire_at","paid_at","description","status","shorten_url","customer_person_type","customer_person_name","customer_cnpj_cpf","customer_address","customer_state","customer_neighborhood","customer_zipcode","customer_address_number","customer_address_complement","customer_phone_number","customer_email","notification_url","send_email_on_creation","created_via_api","customer_city_name","paid_amount","amount"]);
  }

  /**
   * @vcr bank_billets/save/failure
   */
  public function testSaveFailure() {
    $bank_billet = new BoletoSimples\BankBillet(['amount' => '199,99', 'expire_at' => '2020-01-01']);
    $bank_billet->description = 'Cobrança XPTO';
    $bank_billet->save();

    $this->assertTrue($bank_billet instanceof \BoletoSimples\BankBillet);
    $this->assertFalse ($bank_billet->isPersisted());
    $this->assertEquals ($bank_billet->response_errors, ["customer_person_name"=>["não pode ficar em branco"],"customer_cnpj_cpf"=>["não pode ficar em branco"],"customer_zipcode"=>["não pode ficar em branco"],"expire_at"=>["deve ser em ou até 02/02/2015"],"amount"=>["deve ser menor ou igual a 10"]]);
    $this->assertEquals (array_keys($bank_billet->attributes()), ["amount","expire_at","description"]);
  }

  /**
   * @vcr bank_billets/save/success
   */
  public function testSaveSuccess() {
    $bank_billet = new BoletoSimples\BankBillet(['amount' => '9,99', 'expire_at' => '2015-01-01']);
    $bank_billet->customer_cnpj_cpf = '012.345.678-90';
    $bank_billet->customer_person_name = 'Joao da Silva';
    $bank_billet->customer_zipcode = '12312-123';
    $bank_billet->description = 'Cobrança XPTO';
    $bank_billet->save();

    $this->assertTrue($bank_billet instanceof \BoletoSimples\BankBillet);
    $this->assertTrue ($bank_billet->isPersisted());
    $this->assertEquals ($bank_billet->response_errors, array());
    $this->assertEquals (array_keys($bank_billet->attributes()), ["id","expire_at","paid_at","description","status","shorten_url","customer_person_type","customer_person_name","customer_cnpj_cpf","customer_address","customer_state","customer_neighborhood","customer_zipcode","customer_address_number","customer_address_complement","customer_phone_number","customer_email","notification_url","send_email_on_creation","created_via_api","customer_city_name","paid_amount","amount"]);
  }
}
