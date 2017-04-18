<?php
/**
 * Request Service implementation using the HRS API
 */

namespace HRS;

require_once __DIR__ . '/IRequestService.php';

class RequestService implements IRequestService {

  const REQUEST_URL = 'https://api.healthrecoverysolutions.ftld';

  /**
   * @param HRSModel $model  See IRequestService
   * @param string   $method See IRequestService
   *
   * @return string See IRequestService
   */
  function request($model, $method) {
    $url = self::REQUEST_URL . '/' . $model::getName() . '/' . $method;
    $data = json_encode($model);
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($handle);
    curl_close($handle);
    return $result;
  }

}
