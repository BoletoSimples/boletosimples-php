<?php

class ResponseErrorTest extends PHPUnit_Framework_TestCase {
  use \Xpmock\TestCaseTrait;

  /**
   * @expectedException     \BoletoSimples\ResponseError
   * @expectedExceptionMessage Você precisa se logar ou registrar antes de prosseguir.
   */
  public function testWithError () {
    $response = $this->mock('\GuzzleHttp\Message\Response')
      ->disableOriginalConstructor()
      ->new();

    $response->this()->setBody(GuzzleHttp\Stream\Stream::factory('{"error":"Você precisa se logar ou registrar antes de prosseguir."}'));
    $this->subject = new BoletoSimples\ResponseError($response);
  }

  public function testWithoutError () {
    $response = $this->mock('\GuzzleHttp\Message\Response')
      ->disableOriginalConstructor()
      ->new();

    $this->subject = new BoletoSimples\ResponseError($response);
    $this->assertEquals($this->subject->response, $response);
  }
}
