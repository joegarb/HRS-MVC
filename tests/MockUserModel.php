<?php
/**
 * User model for testing
 */

namespace HRS\Tests;

require_once __DIR__ . '/../HRSModel.php';

use HRS\HRSModel;

class MockUserModel extends HRSModel {

  /**
   * @var string Model name
   */
  protected static $_name = 'User';

  /**
   * @var array See HRSModel
   */
  protected static $_properties = ['first_name', 'last_name'];

}
