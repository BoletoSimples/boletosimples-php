<?php

class TransactionTest extends PHPUnit_Framework_TestCase {
  /**
   * @before
   */
  public function setupSomeFixtures()
  {
    BoletoSimples::configure(['environment' => 'sandbox']);
  }

  public function testConstruct () {
    $subject = new BoletoSimples\Transaction(array ('foo' => 'bar'));

    $this->assertEquals ($subject->foo, 'bar');
    $subject->foo = 'asdf';
    $this->assertEquals ($subject->foo, 'asdf');
    $this->assertEquals ($subject->attributes(), array ('foo' => 'asdf'));
    $this->assertEquals (BoletoSimples\Transaction::element_name(), 'transaction');
    $this->assertEquals (BoletoSimples\Transaction::element_name_plural(), 'transactions');
  }

  /**
   * @vcr transactions/all
   */
  public function testAllSuccess() {
    $transactions = BoletoSimples\Transaction::all();
    $this->assertTrue(is_array($transactions));
    $this->assertCount(2, $transactions);
    $this->assertTrue($transactions[0] instanceof \BoletoSimples\Transaction);

    $this->assertEquals(BoletoSimples::$last_request->total, 2);
    $this->assertEquals(BoletoSimples::$last_request->ratelimit_limit, 500);
    $this->assertEquals(BoletoSimples::$last_request->ratelimit_remaining, 499);
  }
}
