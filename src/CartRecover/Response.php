<?php

/**
 * HTTP Response Object
 *
 * @package CartRecover
 * @category Response
 */
class CartRecover_Response {

  /**
   * Raw Response string
   * @var array $response
   */
  protected $response;

  /**
   * Response body
   * @var array $body
   */
  protected $body;

  /**
   * Response Headers
   * @var array $headers
   */
  protected $headers;

  /**
   * Response HTTP Status message
   * @var int $status
   */
  protected $status;

  /**
   * Response HTTP Status code
   * @var int $code
   */
  protected $code;

  /**
   * Sets the body response
   * Should already be converted from json
   *
   * @param array $body
   * @return CartRecover_Response
   */
  public function setBody(array $body) {
    $this->body = $body;
    return $this;
  }

  /**
   * Returns response body
   *
   * @return array
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * Sets Response Headers
   * CartRecover_Response
   * @param array $headers
   * @return CartRecover_Response
   */
  public function setHeaders(array $headers) {
    $this->headers = $headers;
    return $this;
  }

  /**
   * Returns HTTP Response headers
   *
   * @return array
   */
  public function getHeaders() {
    return $this->headers;
  }

  /**
   * Sets HTTP response status
   *
   * @param string $status Status Message
   * @param int $code Status Code
   * @return CartRecover_Response
   */
  public function setStatus($status, $code) {
    $this->status = $status;
    $this->code = $code;
    return $this;
  }

  /**
   * Returns HTTP status code
   *
   * @return int
   */
  public function getStatusCode() {
    return $this->code;
  }

  /**
   * Returns HTTP status message
   *
   * @return int
   */
  public function getStatusMessage() {
    return $this->status;
  }

  /**
   * Sets raw response string
   *
   * @param string $response
   * @return CartRecover_Response
   */
  public function setRawResponse($response) {
    $this->response = $response;
    return $this;
  }

  /**
   * Returns raw response as string
   *
   * @return string
   */
  public function getRawResponse() {
    return $this->response;
  }

  /**
   * Returns response as string
   * @return string
   */
  public function __toString() {
    return $this->getRawResponse();
  }

}