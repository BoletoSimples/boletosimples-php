<?php

class ConfigurationTest extends PHPUnit_Framework_TestCase {
	public function testDefaults () {
    putenv('BOLETOSIMPLES_ENV');
    putenv('BOLETOSIMPLES_APP_ID');
    putenv('BOLETOSIMPLES_APP_SECRET');
    putenv('BOLETOSIMPLES_ACCESS_TOKEN');
    $this->subject = new BoletoSimples\Configuration();
    $this->assertEquals ($this->subject->environment, 'sandbox');
    $this->assertNull ($this->subject->application_id);
    $this->assertNull ($this->subject->application_secret);
    $this->assertNull ($this->subject->access_token);
    $this->assertEquals ($this->subject->baseUri(), 'https://sandbox.boletosimples.com.br/api/v1/');
    $this->assertFalse ($this->subject->hasAccessToken());
	}
  public function testUserAgent() {
    $this->subject = new BoletoSimples\Configuration();
    $this->assertEquals ($this->subject->userAgent(), "BoletoSimples PHP Client v0.0.8 (contato@boletosimples.com.br)");
  }
  public function testEnvironmentVariables() {
    putenv('BOLETOSIMPLES_ENV=production');
    putenv('BOLETOSIMPLES_APP_ID=app-id');
    putenv('BOLETOSIMPLES_APP_SECRET=app-secret');
    putenv('BOLETOSIMPLES_ACCESS_TOKEN=access-token');
    $this->subject = new BoletoSimples\Configuration();
    $this->assertEquals ($this->subject->environment, 'production');
    $this->assertEquals ($this->subject->application_id, 'app-id');
    $this->assertEquals ($this->subject->application_secret, 'app-secret');
    $this->assertEquals ($this->subject->access_token, 'access-token');
    $this->assertEquals ($this->subject->baseUri(), 'https://boletosimples.com.br/api/v1/');
    $this->assertTrue ($this->subject->hasAccessToken());
  }
  public function testConfiguration() {
    BoletoSimples::configure([
      "environment" => 'production',
      "application_id" => 'app-id',
      "application_secret" => 'app-secret',
      "access_token" => 'access-token'
    ]);
    $this->subject = BoletoSimples::$configuration;
    $this->assertEquals ($this->subject->environment, 'production');
    $this->assertEquals ($this->subject->application_id, 'app-id');
    $this->assertEquals ($this->subject->application_secret, 'app-secret');
    $this->assertEquals ($this->subject->access_token, 'access-token');
    $this->assertEquals ($this->subject->baseUri(), 'https://boletosimples.com.br/api/v1/');
    $this->assertTrue ($this->subject->hasAccessToken());
  }
}
