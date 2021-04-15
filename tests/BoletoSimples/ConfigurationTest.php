<?php
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase {
	public function testDefaults () {
    putenv('BOLETOSIMPLES_ENV');
    putenv('BOLETOSIMPLES_USER_AGENT');
    putenv('BOLETOSIMPLES_API_TOKEN');
    $this->subject = new BoletoSimples\Configuration();
    $this->assertEquals ($this->subject->environment, 'sandbox');
    $this->assertNull ($this->subject->api_token);
    $this->assertNull ($this->subject->user_agent);
    $this->assertEquals ($this->subject->baseUri(), 'https://sandbox.boletosimples.com.br/api/v1/');
    $this->assertFalse ($this->subject->hasAccessToken());
	}

  public function testEnvironmentVariables() {
    putenv('BOLETOSIMPLES_ENV=production');
    putenv('BOLETOSIMPLES_USER_AGENT=user-agent');
    putenv('BOLETOSIMPLES_API_TOKEN=api-token');
    $this->subject = new BoletoSimples\Configuration();
    $this->assertEquals ($this->subject->environment, 'production');
    $this->assertEquals ($this->subject->user_agent, 'user-agent');
    $this->assertEquals ($this->subject->api_token, 'api-token');
    $this->assertEquals ($this->subject->baseUri(), 'https://boletosimples.com.br/api/v1/');
    $this->assertTrue ($this->subject->hasAccessToken());
  }
  public function testConfiguration() {
    BoletoSimples::configure([
      "environment" => 'production',
      "user_agent" => 'user-agent',
      "api_token" => 'api-token'
    ]);
    $this->subject = BoletoSimples::$configuration;
    $this->assertEquals ($this->subject->environment, 'production');
    $this->assertEquals ($this->subject->api_token, 'api-token');
    $this->assertEquals ($this->subject->user_agent, 'user-agent');
    $this->assertEquals ($this->subject->baseUri(), 'https://boletosimples.com.br/api/v1/');
    $this->assertTrue ($this->subject->hasAccessToken());
  }
}
