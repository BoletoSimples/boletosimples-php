<?php

class LastRequestTest extends PHPUnit_Framework_TestCase {
  use \Xpmock\TestCaseTrait;

	public function testConstructor () {
    $request = $this->mock('\GuzzleHttp\Message\Request')
      ->disableOriginalConstructor()
      ->new();
    $response = $this->mock('\GuzzleHttp\Message\Response')
      ->disableOriginalConstructor()
      ->new();

    $response->this()->setHeaders([
      'Total'=>['110'],
      'X-Ratelimit-Limit'=>['500'],
      'X-Ratelimit-Remaining'=>['498'],
      'Link'=>['<https://sandbox.boletosimples.com.br/api/v1/bank_billets?page=55&per_page=2>; rel="last", <https://sandbox.boletosimples.com.br/api/v1/bank_billets?page=2&per_page=2>; rel="next"']
    ]);

    $this->subject = new BoletoSimples\LastRequest($request, $response);

    $this->assertEquals($this->subject->request, $request);
    $this->assertEquals($this->subject->response, $response);
    $this->assertEquals($this->subject->total, 110);
    $this->assertEquals($this->subject->ratelimit_limit, 500);
    $this->assertEquals($this->subject->ratelimit_remaining, 498);
    $this->assertEquals($this->subject->links['last'], 'https://sandbox.boletosimples.com.br/api/v1/bank_billets?page=55&per_page=2');
    $this->assertEquals($this->subject->links['next'],'https://sandbox.boletosimples.com.br/api/v1/bank_billets?page=2&per_page=2');
	}
}
