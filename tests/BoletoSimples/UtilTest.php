<?php
use PHPUnit\Framework\TestCase;

final class UtilTest extends TestCase {
	public function testPluralize(): void {
    $this->assertEquals (BoletoSimples\Util::pluralize('bank_billet'), 'bank_billets');
    $this->assertEquals (BoletoSimples\Util::pluralize('BankBillet'), 'BankBillets');
    $this->assertEquals (BoletoSimples\Util::pluralize('bankbillet'), 'bankbillets');
  }
	public function testUnderscorize(): void {
    $this->assertEquals (BoletoSimples\Util::underscorize('BankBillet'), 'bank_billet');
    $this->assertEquals (BoletoSimples\Util::underscorize('Bank Billet'), 'bank_billet');
    $this->assertEquals (BoletoSimples\Util::underscorize('Bank-Billet'), 'bank_billet');
    $this->assertEquals (BoletoSimples\Util::underscorize('Bank.Billet'), 'bank_billet');
  }
}