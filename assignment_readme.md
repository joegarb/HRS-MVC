We are building a new application in PHP 5.6. We are using the model view controller design pattern for our new application, and we need you to implement an abstract class for the base model.

Implement a PHP abstract class called HRSModel

* HRSModel must be an abstract class
* HRSModel must implement JsonSerializable
* HRSModel must contain a static variable called _properties that is intended to be an indexed array, and will be populated by classes extending this class (e.g. for a User model: `static $_properties = array("first_name", "last_name", "username", "password");//etc`).
* HRSModel must contain a static variable called _name that is intended to be a string that will be populated by classes extending this class (e.g. for User model this would be "User").
* HRSModel must contain a protected class variable _data that is intended to be an associative array, and will be populated by the class's constructor

Methods:
  __construct - constructor, it should take in an array as its argument. This array will be in the form of $property => $value, where $property is the name of the property of the model (e.g. user model having first_name and last_name as properties). If this array contains any keys that are not in the _properties array, those keys and values should be removed. The class variable _data should be assigned this resulting array.
  __get - this method should check if the given property name exists in the properties array and return the corresponding value that is in the _data object if it does exist
  __set - this method should check if the given property name exists in the properties array and assign the corresponding value that is in the _data object if it does exist
  getName - static method should return the name of the model
  getProperties - static method should return an indexed array containing the names of properties of the class (e.g. User model would return array("first_name", "last_name", "username", "password", "salt"), etc.)
  request - this method should take a string as its only argument. It shoud perform a CURL post request to the host "http://api.healthrecoverysolutions.ftld". The body of the request should be the json encoded String that represents the object. The path of the request should be the "/{model_name}/{method_argument}". For example, if we had an User Model that extended this Model called `$user` and we wanted to request login, we could do this:  `$user->request("login");` and it would send a post request to "https://api.healthrecoverysolutions.ftld/User/login" with the result of jsonSerialize called on the object as the post body.

