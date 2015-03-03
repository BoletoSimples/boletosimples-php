<?php

class VcrSecurityListener implements \PHPUnit_Framework_TestListener
{
    private $dataChanged = null;

    private function sensitiveData() {
      return [
        'BOLETOSIMPLES_APP_ID' => getenv('BOLETOSIMPLES_APP_ID'),
        'BOLETOSIMPLES_APP_SECRET' => getenv('BOLETOSIMPLES_APP_SECRET'),
        'BOLETOSIMPLES_ACCESS_TOKEN' => getenv('BOLETOSIMPLES_ACCESS_TOKEN'),
        'BOLETOSIMPLES_CLIENT_CREDENTIALS_TOKEN' => getenv('BOLETOSIMPLES_CLIENT_CREDENTIALS_TOKEN')
      ];
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite) {
      foreach($this->sensitiveData() as $k => $v) {
        if($v != null) {
          shell_exec("perl -e \"s/" . $k . "/" . $v . "/g;\" -pi $(find " . dirname (__FILE__) . "/../fixtures -type f)");
        }
      }
      $this->dataChanged = $this->sensitiveData();
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite) {
      foreach($this->dataChanged as $k => $v) {
        if($v != null) {
          shell_exec("perl -e \"s/" . $v . "/" . $k . "/g;\" -pi $(find " . dirname (__FILE__) . "/../fixtures -type f)");
        }
      }
    }

    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {}
    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time) {}
    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time) {}
    public function startTest(\PHPUnit_Framework_Test $test) { }
    public function endTest(\PHPUnit_Framework_Test $test, $time) { }
    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) { }
    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) { }
}