Cart Recover - PHP API
======================

[![Latest Stable Version](https://poser.pugx.org/digital-canvas/cart-recover-phpapi/version.png)](https://packagist.org/packages/digital-canvas/cart-recover-phpapi)
[![Total Downloads](https://poser.pugx.org/digital-canvas/cart-recover-phpapi/d/total.png)](https://packagist.org/packages/digital-canvas/cart-recover-phpapi)

PHP API implementation of the Cart Recover order API.

[http://www.cart-recover.com](http://www.cart-recover.com)  
Developed by [Digital Canvas](http://www.digitalcanvas.com)

## Installation

### Requirements

- PHP 5.2.4+ *(external libraries used by adapters may have their own requirements)*

**At least one of the following adapters:**
- [PHP cURL extension](http://php.net/manual/en/book.curl.php) to use cURL adapter
- [Zend Framework 1.x](http://framework.zend.com/manual/1.12/en/zend.http.html) to use Zend_Http_Client adapter
- [Zend Framework 2.2.x](http://framework.zend.com/manual/2.2/en/modules/zend.http.html) to use Zend Zend\Http\Client adapter
- [Guzzle library](http://guzzlephp.org/) to use Guzzle adapter
- [PEAR HTTP_Request2](http://pear.php.net/package/HTTP_Request2) library to use PEAR adapter


### Install with composer

The easiest way to install the Cart Recover PHP API library is via [composer](http://getcomposer.org/). Create the following `composer.json` file and run the `php composer.phar install` command to install it.

*Note composer requires PHP 5.3+*

```json
{
    "require": {
        "digital-canvas/cart-recover-phpapi": "*"
    }
}
```

```php
<?php
require 'vendor/autoload.php';

$account_key = 'my-unique-account-key';

$cart_recover = new CartRecover_API($account_key);
$adapter = new CartRecover_Adapter_Curl();
$cart_recover->setHTTPClientAdapter($adapter);
```

### Install without composer

Download the libraries from https://github.com/digital-canvas/cart-recover-phpapi/archive/master.zip and extract to a folder accessible from your app.

```php
<?php
require 'path/to/src/CartRecover/Autoloader.php';

CartRecover_Autoloader::registerAutoloader();

$account_key = 'my-unique-account-key';

$cart_recover = new CartRecover_API($account_key);
$adapter = new CartRecover_Adapter_Curl();
$cart_recover->setHTTPClientAdapter($adapter);
```


