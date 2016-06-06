[![Build Status](https://travis-ci.org/rearley/ebay.svg?branch=master)](https://travis-ci.org/rearley/ebay)
[![Latest Stable Version](https://poser.pugx.org/rearley/ebay/v/stable.svg)](https://packagist.org/packages/rearley/ebay)
[![Latest Unstable Version](https://poser.pugx.org/rearley/ebay/v/unstable.svg)](https://packagist.org/packages/rearley/ebay)
[![License](https://poser.pugx.org/rearley/ebay/license.svg)](https://packagist.org/packages/rearley/ebay)

eBay API
========
PHP Client Library for the Ebay API.

## Services
The client library currently supports the Finding, Shopping and Trading APIs. 

```php

// Call to the Trading's AddDispute call
$service = new Earley\Ebay\API\Trading('AddDispute');

// Call to the Trading's AddDispute call with the user token for authentication
$service = new Earley\Ebay\API\Trading('AddDispute','some long token string');

```

Each service API has one required argument and a optional argument. The first argument is the API's call and the second
is the user token that is required for certain calls to the trading API.

### TODO
* More detailed documentation
* Unit Testing Completion
* Other Ebay API Calls