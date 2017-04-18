<?php
/**
 * Base model for the HRS model-view-controller framework
 */

namespace HRS;

abstract class HRSModel implements \JsonSerializable {

  /**
   * @var string Model name, set by classes extending HRSModel
   */
  protected static $_name = '';

  /**
   * @var array Available property names, set by classes extending HRSModel
   */
  protected static $_properties = [];

  /**
   * @var array Associative array of model data, set in the constructor or by using _set()
   */
  protected $_data = [];

  /**
   * @var IRequestService
   */
  private $service;

  /**
   * @param IRequestService $service Service provider for the request() function
   * @param array           $data    Associative array of model data
   */
  public function __construct($service = null, $data = null) {
    $this->service = $service;
    if ($data && is_array($data)) {
      foreach ($data as $name => $value) {
        // Only store the value if it is for a supported property
        if (in_array($name, static::$_properties)) {
          $this->_data[$name] = $value;
        }
      }
    }
  }

  /**
   * @return string Model name
   */
  public static function getName() {
    return static::$_name;
  }

  /**
   * @return array Available property names
   */
  public static function getProperties() {
    return static::$_properties;
  }

  /**
   * Magic method to get the data for a given property name if it is one of the predefined properties
   *
   * @param string $name Property name
   *
   * @return mixed
   */
  public function __get($name) {
    return in_array($name, static::$_properties) && array_key_exists($name, $this->_data) ? $this->_data[$name] : null;
  }

  /**
   * Magic method to set the data for a given property name if it is one of the predefined properties
   *
   * @param string $name  Property name
   * @param mixed  $value Property value
   */
  public function __set($name, $value) {
    if (in_array($name, static::$_properties)) {
      $this->_data[$name] = $value;
    }
  }

  /**
   * Magic method to catch function calls that aren't implemented, so that we can be lazy and not have to implement
   * getters and setters. This will also call request() for any non-implemented function that isn't a getter/setter.
   *
   * @param string $name      Function name
   * @param array  $arguments Function arguments
   *
   * @return mixed
   */
  public function __call($name, $arguments) {
    $prefix = substr($name, 0, 3);
    if ($prefix == 'get' || $prefix == 'set') {
      $name = lcfirst(substr($name, 3));                            // getFirstName -> firstName
      $name = strtolower(preg_replace('/([A-Z]+)/', '_$1', $name)); // firstName -> first_name
      if ($prefix == 'get') {
        return $this->$name;
      } else {
        $this->$name = array_pop($arguments);
        return null;
      }
    } else {
      return $this->request($name);
    }
  }

  /**
   * Returns a representation of this model that can be serialized using json_encode()
   *
   * @return mixed
   */
  public function jsonSerialize() {
    return $this->_data;
  }

  /**
   * Submits a POST web request containing the JSON representation of this model to the specified method
   * For example, calling $user->request('login') for $user of type UserModel hits the endpoint /User/login
   *
   * @param string $method Operation to call for this object on the remote service
   *
   * @return string Response body
   */
  public function request($method) {
    return $this->service->request($this, $method);
  }

}
