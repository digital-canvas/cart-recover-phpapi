<?php

/**
 * Sends Requests using the HTTP_Request2 from PEAR
 *
 * @package CartRecover
 * @category Adapter
 * @see http://pear.php.net/package/HTTP_Request2
 */
class CartRecover_Adapter_PEAR implements CartRecover_Adapter_Interface {

  /**
   * HTTP Client instance
   * @var HTTP_Request2 $client
   */
  public $client;

  /**
   *
   * @var Zend_Http_Response $response
   */
  public $response;

  /**
   * Class constructor
   *
   * Sets HTTP Client instance
   *
   * @param HTTP_Request2 $client
   */
  public function __construct(HTTP_Request2 $client) {
    $this->setClient($client);
  }

  /**
   * Sets HTTP Client instance
   *
   * @param HTTP_Request2 $client
   */
  public function setClient(HTTP_Request2 $client) {
    $this->client = $client;
  }

  /**
   * Returns the http client
   * @return HTTP_Request2
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * Returns the zend response object
   * @return Zend_Http_Response
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
    $this->client->setUrl($request->getUri());
    $this->client->getUrl()->setQueryVariables($request->getParams());
    $this->client->setMethod($request->getMethod());
    $this->client->setHeader('Accept', 'application/json');
    $this->response = $this->client->send();
    if ($this->response->getHeader('Content-Type') != 'application/json') {
      throw new CartRecover_Exception_UnexpectedValueException("Unknown response format.");
    }
    $body = json_decode($this->response->getBody(), true);
    $response = new CartRecover_Response();
    $response->setRawResponse($this->response->getBody());
    $response->setBody($body);
    $response->setHeaders($this->response->getHeader());
    $response->setStatus($this->response->getReasonPhrase(), $this->response->getStatus());
    return $response;
  }
}