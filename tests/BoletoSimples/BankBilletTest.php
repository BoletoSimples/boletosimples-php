<?php
require_once dirname (__FILE__) . '/../testHelper.php';

class BankBilletTest extends PHPUnit_Framework_TestCase {
  public function testConstruct () {
    $subject = new BoletoSimples\BankBillet(array ('foo' => 'bar'));

    $this->assertEquals ($subject->foo, 'bar');
    $subject->foo = 'asdf';
    $this->assertEquals ($subject->foo, 'asdf');
    $this->assertEquals ($subject->_data, array ('foo' => 'asdf'));
    $this->assertEquals ($subject->element_name_plural, 'bank_billets');
    $this->assertEquals ($subject->site, 'https://sandbox.boletosimples.com.br/');
  }

  public function testCreate() {
    $subject = new BoletoSimples\BankBillet(array (
      'amount' => '9,01',
      'description' => 'Despesas do contrato 0012',
      'expire_at' => '2014-01-01',
      'customer_address' => 'Rua quinhentos',
      'customer_address_complement' => 'Sala 4',
      'customer_address_number' => '111',
      'customer_city_name' => 'Rio de Janeiro',
      'customer_cnpj_cpf' => '012.345.678-90',
      'customer_email' => 'cliente@bom.com',
      'customer_neighborhood' => 'Sao Francisco',
      'customer_person_name' => 'Joao da Silva',
      'customer_person_type' => 'individual',
      'customer_phone_number' => '2112123434',
      'customer_state' => 'RJ',
      'customer_zipcode' => '12312-123',
      'notification_url' => 'http://example.com.br/notify'
    ));
    // $subject.save ();
  }
}

?>