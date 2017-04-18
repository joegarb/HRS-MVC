<?php
/**
 * Unit tests for HRSModel
 */

namespace HRS\Tests;

require_once __DIR__ . '/MockRequestService.php';
require_once __DIR__ . '/MockUserModel.php';

class HRSModelTest extends \PHPUnit_Framework_TestCase {

  public function testGetName() {
    $this->assertEquals('User', MockUserModel::getName());
  }

  public function testGetProperties() {
    $this->assertEquals(['first_name', 'last_name'], MockUserModel::getProperties());
  }

  public function testConstructWithUndefinedProperty() {
    $user = new MockUserModel(null, ['social_security_number' => 123456789]);
    $this->assertEmpty($user->getSocialSecurityNumber());
  }

  public function testSetUndefinedProperty() {
    $user = new MockUserModel();
    $user->setSocialSecurityNumber(123456789);
    $this->assertEmpty($user->getSocialSecurityNumber());
  }

  public function testGetNotSetProperty() {
    $user = new MockUserModel();
    $this->assertEmpty($user->getFirstName());
  }

  public function testGetEmptyProperty() {
    $user = new MockUserModel(null, ['first_name' => null]);
    $this->assertEmpty($user->getFirstName());
  }

  public function testConstructWithData() {
    $user = new MockUserModel(null, ['first_name' => 'John']);
    $this->assertEquals('John', $user->getFirstName());
  }

  public function testSetProperty() {
    $user = new MockUserModel(null, ['first_name' => 'John']);
    $user->setFirstName('Bob');
    $this->assertEquals('Bob', $user->getFirstName());
  }

  public function testJsonEncode() {
    $user = new MockUserModel(null, ['first_name' => 'John']);
    $this->assertEquals('{"first_name":"John"}', json_encode($user));
  }

  public function testNonExistentMethodShortName() {
    $user = new MockUserModel(new MockRequestService());
    $user->setFirstName('John');
    $user->setLastName('Smith');
    $result = $user->hi();
    $this->assertEquals(
      [
        'url' => 'https://api.healthrecoverysolutions.ftld/User/hi',
        'data' => '{"first_name":"John","last_name":"Smith"}'
      ],
      $result
    );
  }

  public function testRequestMethod() {
    $user = new MockUserModel(new MockRequestService());
    $user->setFirstName('John');
    $user->setLastName('Smith');
    $result = $user->login();
    $this->assertEquals(
      [
        'url' => 'https://api.healthrecoverysolutions.ftld/User/login',
        'data' => '{"first_name":"John","last_name":"Smith"}'
      ],
      $result
    );
  }

}
