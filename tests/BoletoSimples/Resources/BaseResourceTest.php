<?php

class ExampleResource extends BoletoSimples\BaseResource {
  public $property = 'value';
}

class BaseResourceTest extends PHPUnit_Framework_TestCase {
  public function testConstruct () {
    $subject = new ExampleResource(array ('foo' => 'bar'));

    $this->assertEquals ($subject->foo, 'bar');
    $subject->foo = 'asdf';
    $this->assertEquals ($subject->foo, 'asdf');
    $this->assertEquals ($subject->attributes(), array ('foo' => 'asdf'));
    $this->assertEquals ($subject->property, 'value');
    $this->assertEquals (ExampleResource::element_name(), 'example_resource');
    $this->assertEquals (ExampleResource::element_name_plural(), 'example_resources');
  }
  public function testIsNew () {
    $subject = new ExampleResource();
    $this->assertTrue ($subject->isNew());

    $subject = new ExampleResource(array ('id' => null));
    $this->assertTrue ($subject->isNew());

    $subject = new ExampleResource(array ('id' => 1));
    $this->assertFalse ($subject->isNew());
  }
  public function testIsPersisted () {
    $subject = new ExampleResource(array ('id' => null));
    $this->assertFalse ($subject->isPersisted());

    $subject = new ExampleResource(array ('id' => 1));
    $this->assertTrue ($subject->isPersisted());
  }
  public function testMethodFor () {
    $this->assertEquals (ExampleResource::methodFor('create'), 'POST');
    $this->assertEquals (ExampleResource::methodFor('update'), 'PUT');
    $this->assertEquals (ExampleResource::methodFor('find'), 'GET');
    $this->assertEquals (ExampleResource::methodFor('destroy'), 'DELETE');
    $this->assertEquals (ExampleResource::methodFor('new'), 'GET');
  }
  /**
   * @expectedException     Exception
   * @expectedExceptionMessage Couldn't find ExampleResource without an ID.
   */
  public function testFindWithoutParams () {
    ExampleResource::find('');
  }
}
