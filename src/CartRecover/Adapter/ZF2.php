<?php

/**
 * Sends Requests using the Zend\Http\Client library from Zend Framework 2.x
 *
 * @package CartRecover
 * @category Adapter
 * @see http://framework.zend.com/manual/2.2/en/modules/zend.http.client.html
 */
class CartRecover_Adapter_ZF2 implements CartRecover_Adapter_Interface {

  /**
   * HTTP Client instance
   * @var Zend\Http\Client $client
   */
  public $client;

  /**
   *
   * @var Zend\Http\Response $response
   */
  public $response;

  /**
   * Class constructor
   *
   * Sets HTTP Client instance
   *
   * @param Zend\Http\Client $client
   */
  public function __construct(Zend\Http\Client $client) {
    $this->setClient($client);
  }

  /**
   * Sets HTTP Client instance
   *
   * @param Zend\Http\Client $client
   */
  public function setClient(Zend\Http\Client $client) {
    $this->client = $client;
  }

  /**
   * Returns the zend http client
   * @return Zend\Http\Client
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * Returns the zend response object
   * @return Zend\Http\Response
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
    $this->client->setHeaders(array('Accept' => 'application/json'));
    $this->response = $this->client->send();
    if ($this->response->getHeaders()->get('Content-Type')->getFieldValue() != 'application/json') {
      throw new CartRecover_Exception_UnexpectedValueException("Unknown response format.");
    }
    $body = json_decode($this->response->getContent(), true);
    $response = new CartRecover_Response();
    $response->setRawResponse($this->response->toString());
    $response->setBody($body);
    $response->setHeaders($this->response->getHeaders()->toArray());
    $response->setStatus($this->response->getReasonPhrase(), $this->response->getStatusCode());
    return $response;
  }
}