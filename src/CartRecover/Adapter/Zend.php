<?php

/**
 * Sends Requests using the Zend_Http_Client library from Zend Framework 1.x
 *
 * @package CartRecover
 * @category Adapter
 * @see http://framework.zend.com/manual/1.12/en/zend.http.client.html
 */
class CartRecover_Adapter_Zend implements CartRecover_Adapter_Interface {

  /**
   * HTTP Client instance
   * @var Zend_Http_Client $client
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
   * @param Zend_Http_Client $client
   */
  public function __construct(Zend_Http_Client $client) {
    $this->setClient($client);
  }

  /**
   * Sets HTTP Client instance
   *
   * @param Zend_Http_Client $client
   */
  public function setClient(Zend_Http_Client $client) {
    $this->client = $client;
  }

  /**
   * Returns the zend http client
   * @return Zend_Http_Client
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
    $this->client->setUri($request->getUri());
    $this->client->setParameterGet($request->getParams());
    $this->client->setMethod($request->getMethod());
    $this->client->setHeaders('Accept', 'application/json');
    $this->response = $this->client->request();
    if ($this->response->getHeader('Content-Type') != 'application/json') {
      throw new CartRecover_Exception_UnexpectedValueException("Unknown response format.");
    }
    $body = json_decode($this->response->getBody(), true);
    $response = new CartRecover_Response();
    $response->setRawResponse($this->response->asString());
    $response->setBody($body);
    $response->setHeaders($this->response->getHeaders());
    $response->setStatus($this->response->getMessage(), $this->response->getStatus());
    return $response;
  }

}