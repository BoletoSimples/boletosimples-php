<?php

class UtilTest extends PHPUnit_Framework_TestCase {
	public function testPluralize () {
    $this->assertEquals (BoletoSimples\Util::pluralize('bank_billet'), 'bank_billets');
    $this->assertEquals (BoletoSimples\Util::pluralize('BankBillet'), 'BankBillets');
    $this->assertEquals (BoletoSimples\Util::pluralize('bankbillet'), 'bankbillets');
  }
	public function testUnderscorize () {
    $this->assertEquals (BoletoSimples\Util::underscorize('BankBillet'), 'bank_billet');
    $this->assertEquals (BoletoSimples\Util::underscorize('Bank Billet'), 'bank_billet');
    $this->assertEquals (BoletoSimples\Util::underscorize('Bank-Billet'), 'bank_billet');
    $this->assertEquals (BoletoSimples\Util::underscorize('Bank.Billet'), 'bank_billet');
  }
}