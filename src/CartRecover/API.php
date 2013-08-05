<?php

/**
 * CartRecover API class
 *
 * @package CartRecover
 */
class CartRecover_API {

  const VERSION = 'v1.0';

  const URL = 'https://api.cart-recover.com/cart/';

  /**
   * HTTP Client Adapter
   * @var CartRecover_Adapter_Interface $adapter
   */
  protected $adapter = null;

  /**
   * The url to send requests to
   * @var type
   */
  protected $url;

  /**
   * Account key for api authorization
   * @var string $_account_key
   */
  protected $_account_key;

  /**
   * Cart default values
   * @var array $cart
   */
  public static $cart = array(
      'cartid' => null,
      'first_name' => null,
      'last_name' => null,
      'name' => null,
      'email' => null,
      'order_number' => null,
      'amount' => null,
  );

  /**
   * Class constructor
   * @param string $account_key Accoun key
   * @param string $test_url Test url override
   */
  public function __construct($account_key, $test_url = null) {
    $this->_account_key = $account_key;
    if ($test_url) {
      $this->url = trim($test_url,'/') . '/cart/' . self::VERSION;
    } else {
      $this->url = self::URL . self::VERSION;
    }
  }

  /**
   * Sets the HTTP Client Adapter
   *
   * If not provided CartRecover_Adapter_Curl will be used
   *
   * @param CartRecover_Adapter_Interface $adapter
   * @return CartRecover_API
   */
  public function setHTTPClientAdapter(CartRecover_Adapter_Interface $adapter = null) {
    if (is_null($adapter)) {
      $adapter = new CartRecover_Adapter_Curl();
    }
    $this->adapter = $adapter;
    return $this;
  }

  /**
   * Returns current HTTP Client Adapter
   *
   * @return CartRecover_Adapter_Interface
   */
  public function getHTTPClientAdapter() {
    if(is_null($this->adapter)){
      $this->setHTTPClientAdapter(null);
    }
    return $this->adapter;
  }

  /**
   * Creates a new cart
   * @param array $cart
   * @return array
   */
  public function createCart(array $cart = array()) {
    $cart = array_merge(self::$cart, array_intersect_key($cart, self::$cart));
    return $this->sendRequest('/create', $cart);
  }

  /**
   * Updates an existing cart
   * @param array $cart
   * @return array
   */
  public function updateCart(array $cart = array()) {
    $cart = array_merge(self::$cart, array_intersect_key($cart, self::$cart));
    return $this->sendRequest('/update', $cart);
  }

  /**
   * Closes an open cart
   * @param array $cart
   * @return array
   */
  public function closeCart(array $cart = array()) {
    $cart = array_merge(self::$cart, array_intersect_key($cart, self::$cart));
    return $this->sendRequest('/close', $cart);
  }

  /**
   * Builds the Request object
   * @param type $path
   * @param array $params
   * @return \CartRecover_Request
   */
  protected function buildRequest($path, array $params = array()){
    $uri = $this->url . $path;
    $params['account_key'] = $this->_account_key;
    $request = new CartRecover_Request();
    $request->setUri($uri);
    $request->setMethod('GET');
    $request->setParams($params);
    return $request;
  }

  /**
   * Sends request and returns response
   * @param string $path
   * @param array $params
   * @return CartRecover_Response
   */
  protected function sendRequest($path, array $params) {
    $request = $this->buildRequest($path, $params);
    return $this->getHTTPClientAdapter()->sendRequest($request);

  }

}
