<?php
/**
 * Request Service interface, exists to separate the service call signature from its implementation to support mocking and testing
 */

namespace HRS;

interface IRequestService {

  /**
   * @param HRSModel $model  Model containing data to submit in the request
   * @param string   $method Operation to call for this object on the remote service
   *
   * @return string Response body
   */
  function request($model, $method);

}
