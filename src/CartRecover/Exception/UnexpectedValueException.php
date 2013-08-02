<?php

/**
 * Exception thrown if a value does not match with a set of values.
 * Typically this happens when a function calls another function and expects the return value to be of a certain type or value not including arithmetic or buffer related errors.
 *
 * @package CartRecover
 * @category Exception
 */
class CartRecover_Exception_UnexpectedValueException extends UnexpectedValueException implements CartRecover_Exception {

}