<?php

class CustomerTest extends PHPUnit_Framework_TestCase {
  private static $customer_id;
  /**
   * @before
   */
  public function setupSomeFixtures()
  {
    BoletoSimples::configure(['environment' => 'sandbox']);
  }

  public function testConstruct () {
    $subject = new BoletoSimples\Customer(array ('foo' => 'bar'));

    $this->assertEquals ($subject->foo, 'bar');
    $subject->foo = 'asdf';
    $this->assertEquals ($subject->foo, 'asdf');
    $this->assertEquals ($subject->attributes(), array ('foo' => 'asdf'));
    $this->assertEquals (BoletoSimples\Customer::element_name(), 'customer');
    $this->assertEquals (BoletoSimples\Customer::element_name_plural(), 'customers');
  }

  /**
   * @vcr customers/create/invalid_root
   */
  public function testCreateInvalidRoot() {
    $customer = BoletoSimples\Customer::create();

    $this->assertTrue($customer instanceof \BoletoSimples\Customer);
    $this->assertFalse ($customer->isPersisted());
    $this->assertEquals ($customer->response_errors, ["customer"=>["não pode ficar em branco"]]);
  }

  /**
   * @vcr customers/create/invalid_params
   */
  public function testCreateInvalidParams() {
    $customer = BoletoSimples\Customer::create(['person_name' => '']);

    $this->assertTrue($customer instanceof \BoletoSimples\Customer);
    $this->assertFalse ($customer->isPersisted());
    $this->assertEquals ($customer->response_errors, ["person_name"=>["não pode ficar em branco"],"cnpj_cpf"=>["não pode ficar em branco"],"zipcode"=>["não pode ficar em branco"],"state"=>["não pode ficar em branco"],"address"=>["não pode ficar em branco"],"neighborhood"=>["não pode ficar em branco"],"city_id"=>["não pode ficar em branco"]]);
  }

  /**
   * @vcr customers/create/success
   */
  public function testCreateSuccess() {
    $customer = BoletoSimples\Customer::create(array (
      'person_name' => "Joao da Silva",
      'cnpj_cpf' => "732.327.384-60",
      'email' => "cliente@example.com",
      'address' => "Rua quinhentos",
      'city_name' => "Rio de Janeiro",
      'state' => "RJ",
      'neighborhood' => "bairro",
      'zipcode' => "12312-123",
      'address_number' => "111",
      'address_complement' => "Sala 4",
      'phone_number' => "2112123434"
    ));
    self::$customer_id = $customer->id;

    $this->assertTrue($customer instanceof \BoletoSimples\Customer);
    $this->assertTrue ($customer->isPersisted());
    $this->assertEquals ($customer->response_errors, array());
    $this->assertEquals (array_keys($customer->attributes()), ["id","city_name","person_name","address","address_complement","address_number","mobile_number","cnpj_cpf","email","neighborhood","person_type","phone_number","zipcode","mobile_local_code","notes","state","created_via_api","email_cc"]);
  }

  /**
   * @vcr customers/save/failure
   */
  public function testSaveFailure() {
    $customer = new BoletoSimples\Customer(['person_name' => 'Joao da Silva']);
    $customer->cnpj_cpf = '321.315.217-07';
    $customer->save();

    $this->assertTrue($customer instanceof \BoletoSimples\Customer);
    $this->assertFalse ($customer->isPersisted());
    $this->assertEquals ($customer->response_errors, ["cnpj_cpf"=>["já está em uso"],"zipcode"=>["não pode ficar em branco"],"state"=>["não pode ficar em branco"],"address"=>["não pode ficar em branco"],"neighborhood"=>["não pode ficar em branco"],"city_id"=>["não pode ficar em branco"]]);
    $this->assertEquals (array_keys($customer->attributes()), ["person_name","cnpj_cpf"]);
  }

  /**
   * @vcr customers/save/success
   */
  public function testSaveSuccess() {
    $customer = new BoletoSimples\Customer();
    $customer->cnpj_cpf = '036.045.511-53';
    $customer->person_name = 'Joao da Silva';
    $customer->zipcode = '12312-123';
    $customer->email = 'cliente@example.com';
    $customer->address = 'Rua quinhentos';
    $customer->city_name = 'Rio de Janeiro';
    $customer->state = 'RJ';
    $customer->neighborhood = 'bairro';
    $customer->address_number = '222';
    $customer->address_complement = 'sala 5';
    $customer->phone_number = '2112123434';
    $customer->save();
    $this->assertTrue($customer instanceof \BoletoSimples\Customer);
    $this->assertTrue ($customer->isPersisted());
    $this->assertEquals ($customer->response_errors, array());
    $this->assertEquals (array_keys($customer->attributes()), ["id","city_name","person_name","address","address_complement","address_number","mobile_number","cnpj_cpf","email","neighborhood","person_type","phone_number","zipcode","mobile_local_code","notes","state","created_via_api","email_cc"]);
  }

  /**
   * @vcr customers/find/success
   */
  public function testFindSuccess() {
    $customer = BoletoSimples\Customer::find(self::$customer_id);
    $this->assertTrue($customer instanceof \BoletoSimples\Customer);
    $this->assertTrue ($customer->isPersisted());
    $this->assertEquals (array_keys($customer->attributes()), ["id","city_name","person_name","address","address_complement","address_number","mobile_number","cnpj_cpf","email","neighborhood","person_type","phone_number","zipcode","mobile_local_code","notes","state","created_via_api","email_cc"]);
  }

  /**
   * @vcr customers/find/failure
   * @expectedException     \BoletoSimples\ResponseError
   * @expectedExceptionMessage Not Found
   */
  public function testFindFailure() {
    $customer = BoletoSimples\Customer::find(1);
  }

  /**
   * @vcr customers/find/unauthenticated
   * @expectedException     \BoletoSimples\ResponseError
   * @expectedExceptionMessage Você precisa se logar ou registrar antes de prosseguir.
   */
  public function testFindUnauthenticated() {
    BoletoSimples::configure(['environment' => 'sandbox', 'access_token' => 'invalid']);
    $customer = BoletoSimples\Customer::find(1);
  }

  /**
   * @vcr customers/all/success
   */
  public function testAllSuccess() {
    $customers = BoletoSimples\Customer::all(['page'=>1, 'per_page'=>2]);
    $this->assertTrue(is_array($customers));
    $this->assertCount(2, $customers);
    $this->assertTrue($customers[0] instanceof \BoletoSimples\Customer);

    $this->assertEquals(BoletoSimples::$last_request->total, 10);
    $this->assertEquals(BoletoSimples::$last_request->ratelimit_limit, 500);
    $this->assertEquals(BoletoSimples::$last_request->ratelimit_remaining, 485);
    $this->assertEquals(BoletoSimples::$last_request->links['last'], 'https://sandbox.boletosimples.com.br/api/v1/customers?page=5&per_page=2');
    $this->assertEquals(BoletoSimples::$last_request->links['next'], 'https://sandbox.boletosimples.com.br/api/v1/customers?page=2&per_page=2');
  }

  /**
   * @vcr customers/update/success
   */
  public function testUpdateSuccess() {
    $customer = BoletoSimples\Customer::find(self::$customer_id);
    $customer->person_name = 'Joao da Costa';
    $this->assertTrue($customer->save());
    $this->assertEquals($customer->person_name, 'Joao da Costa');
  }

}
