<?php

/**
 * Autoloads CartRecover Classes
 *
 * @package CartRecover
 * @category Autoloader
 */
class CartRecover_Autoloader {

  /**
   * Registers autoloader
   */
  public static function registerAutoloader() {
    spl_autoload_register(array('CartRecover_Autoloader', 'loadClass'));
  }

  /**
   * Unregisters autoloader
   */
  public static function unregisterAutoloader() {
    spl_autoload_unregister(array('CartRecover_Autoloader', 'loadClass'));
  }

  /**
   * The class to load
   * @param string $class The class name
   */
  public static function loadClass($class) {
    if (preg_match("/^CartRecover_\\w+$/", $class)) {
      $path = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
      if (file_exists($path)) {
        include_once($path);
      }
    }
  }

}