<?php

interface CartRecover_Adapter_Interface {

  /**
   * Sends a request and returns a response
   * @param CartRecover_Request $request
   * @return Cart_Recover_Response
   */
  public function sendRequest(CartRecover_Request $request);
}