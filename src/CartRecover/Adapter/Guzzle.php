<?php

/**
 * Sends Requests using the Guzzle\Http\Client
 *
 * @package CartRecover
 * @category Adapter
 * @see http://guzzlephp.org/
 */
class CartRecover_Adapter_Guzzle implements CartRecover_Adapter_Interface {

  /**
   * HTTP Client instance
   * @var Guzzle\Http\Client $client
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
   * @param Guzzle\Http\Client $client
   */
  public function __construct(Guzzle\Http\Client $client) {
    $this->setClient($client);
  }

  /**
   * Sets HTTP Client instance
   *
   * @param Guzzle\Http\Client $client
   */
  public function setClient(Guzzle\Http\Client $client) {
    $this->client = $client;
  }

  /**
   * Returns the http client
   * @return Guzzle\Http\Client
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * Returns the response object
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
    $url = Guzzle\Http\Url::factory($request->getUri());
    $url->setQuery($request->getParams());
    $this->client->setBaseUrl($url);
    $grequest = $this->client->createRequest($request->getMethod(), $url);
    $grequest->addHeader('Accept', 'application/json');
    $this->response = $this->client->send($grequest);
    if (!$this->response->isContentType('application/json')) {
      throw new CartRecover_Exception_UnexpectedValueException("Unknown response format.");
    }
    $response = new CartRecover_Response();
    $response->setRawResponse($this->response->__toString());
    $response->setBody($this->response->json());
    $response->setHeaders($this->response->getHeaders()->toArray());
    $response->setStatus($this->response->getReasonPhrase(), $this->response->getStatusCode());
    return $response;
  }
}