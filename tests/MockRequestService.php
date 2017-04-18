<?php
/**
 * Mock Request Service implementation for testing
 */

namespace HRS\Tests;

require_once __DIR__ . '/../IRequestService.php';

use HRS\IRequestService;

class MockRequestService implements IRequestService {

  /**
   * @param \HRS\HRSModel $model  See IRequestService
   * @param string        $method See IRequestService
   *
   * @return array
   */
  function request($model, $method) {
    return [
      'url' => 'https://api.healthrecoverysolutions.ftld/' . $model::getName() . '/' . $method,
      'data' => json_encode($model)
    ];
  }

}
