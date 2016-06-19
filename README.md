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
## Add Element
Add element to the call.

```php

$service->addElement('CallElement','CallValue');

```

The call above will produce the following XML document that will be passed to the Trading API.

```
<?xml version="1.0" encoding="UTF-8"?>
<AddDisputeRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>user_token</eBayAuthToken>
  </RequesterCredentials>
  <CallElement>CallValue</CallElement>
</AddDisputeRequest>

```

## Add Element
This method will allow you to add an array of Elements and Values

```php

$service = new \Earley\Ebay\API\Trading('AddDispute');

$call = array('CallElement' => 'CallValue');
$service->addElements($call);

```

This will produce the same result as above.

## Sending API Call

```php

// Send Request
$response = $service->send();

```

## Working with the Response
The response object has a few methods to get the Ebay Response in a few different formats.

```php

// Array
$object = $response->toArray();

// XML
$object = $response->toXml();

// String
$object = $response->toString();

```

You have a few other methods in order to get other basic information.

```php

// Headers
$response->getHeaders();

// HTTP Code
$response->getStatusCode();

// HTTP Response Phrase
$response->getReasonPhrase();

```



Each service API has one required argument and a optional argument. The first argument is the API's call and the second
is the user token that is required for certain calls to the trading API.

### TODO
* More detailed documentation
* Unit Testing Completion
* Other Ebay API Calls