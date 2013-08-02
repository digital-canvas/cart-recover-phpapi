<?php

/**
 * Sends Requests using the curl extension
 *
 * @package CartRecover
 * @category Adapter
 * @see http://php.net/manual/en/book.curl.php
 */
class CartRecover_Adapter_Curl implements CartRecover_Adapter_Interface {

  /**
   *
   * @var string $response
   */
  public $response;

  /**
   * Returns the response string
   * @return string
   */
  public function getResponse() {
    return $this->response;
  }

  /**
   * Sends a request and returns a response
   *
   * @param CartRecover_Request $request
   * @return Cart_Recover_Response
   */
  public function sendRequest(CartRecover_Request $request) {
    if(!extension_loaded('curl')){
      throw new CartRecover_Exception_RuntimeException("cURL extension not found.");
    }
    $ch = curl_init();
    $uri = $request->getUri() . '?' . http_build_query($request->getParams());
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    $this->response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($this->response, 0, $header_size);
    $body = substr($this->response, $header_size);
    $contenttype = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $status = $this->getStatusMessage($headers);
    curl_close($ch);
    if ($contenttype != 'application/json') {
      throw new CartRecover_Exception_UnexpectedValueException("Unknown response format.");
    }
    $body = json_decode($body, true);
    $response = new CartRecover_Response();
    $response->setRawResponse($this->response);
    $response->setBody($body);
    $response->setHeaders($this->http_parse_headers($headers));
    $response->setStatus($status, $code);
    return $response;
  }

  /**
   * Parses headers into array
   * @param string $header
   * @return array
   */
  private function http_parse_headers($header) {
    $retVal = array();
    $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
    foreach ($fields as $field) {
      if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
        $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
        if (isset($retVal[$match[1]])) {
          if (!is_array($retVal[$match[1]])) {
            $retVal[$match[1]] = array($retVal[$match[1]]);
          }
          $retVal[$match[1]][] = $match[2];
        } else {
          $retVal[$match[1]] = trim($match[2]);
        }
      }
    }
    return $retVal;
  }

  /**
   * Gets status message from response
   * @param string $headers Raw header string
   * @return string
   */
  private function getStatusMessage($headers) {
    $array = explode("\r\n", $headers);
    $status = array_shift($array);
    if (preg_match("/^HTTP\\/[\\d\\.]+\\s\\d+\\s(.+)/i", $status, $matches)) {
      $status = $matches[1];
    }
    return $status;
  }

}