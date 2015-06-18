<?php

class UserTest extends PHPUnit_Framework_TestCase {
  private static $user_id;
  
  /**
   * @before
   */
  public function setupSomeFixtures()
  {
    BoletoSimples::configure(['environment' => 'sandbox']);
  }

  public function testConstruct () {
    $subject = new BoletoSimples\Partner\User(array ('foo' => 'bar'));

    $this->assertEquals ($subject->foo, 'bar');
    $subject->foo = 'asdf';
    $this->assertEquals ($subject->foo, 'asdf');
    $this->assertEquals ($subject->attributes(), array ('foo' => 'asdf'));
    $this->assertEquals (BoletoSimples\Partner\User::element_name(), 'partner/user');
    $this->assertEquals (BoletoSimples\Partner\User::element_name_plural(), 'partner/users');
  }

  /**
   * @vcr users/create/invalid_root
   */
  public function testCreateInvalidRoot() {
    $user = BoletoSimples\Partner\User::create();

    $this->assertTrue($user instanceof \BoletoSimples\Partner\User);
    $this->assertFalse ($user->isPersisted());
    $this->assertEquals ($user->response_errors, ["user"=>["não pode ficar em branco"]]);
  }

  /**
   * @vcr users/create/invalid_params
   */
  public function testCreateInvalidParams() {
    $user = BoletoSimples\Partner\User::create(['email' => '']);

    $this->assertTrue($user instanceof \BoletoSimples\Partner\User);
    $this->assertFalse ($user->isPersisted());
    $this->assertEquals ($user->response_errors, ["email"=>["não pode ficar em branco"]]);
  }

  /**
   * @vcr users/create/success
   */
  public function testCreateSuccess() {
    $user = BoletoSimples\Partner\User::create(array (
      'email' => "cliente@example.com"
    ));
    self::$user_id = $user->id;

    $this->assertTrue($user instanceof \BoletoSimples\Partner\User);
    $this->assertTrue ($user->isPersisted());
    $this->assertEquals ($user->response_errors, array());
    $this->assertEquals (array_keys($user->attributes()), ["id","city_name","person_name","address","address_complement","address_number","mobile_number","cnpj_cpf","email","neighborhood","person_type","phone_number","zipcode","mobile_local_code","state","created_via_api"]);
  }
}
