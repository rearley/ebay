eBay API
========
PHP Client Library for the Ebay API.

## Services
The client library currently supports the Finding, Shopping and Trading APIs. 

```php

// Call a Service
$trading = new \Ebay\Service\Finding();

$finding = new \Ebay\Service\Shopping();

$shopping = new \Ebay\Service\Trading();

// Configure Service
$service
        ->setAppId($appID)
        ->setCallVersion('869')
        ->setCertId($certID)
        ->setDebugMode(true)
        ->setDevId($devID)
        ->setSiteId(0)
        ->setUserToken($userToken);

```

### Request
Once you have configured a service, the next step is to initiate a request. We will use the Trading API ```GeteBayDetails``` call as our example. 

```php
// Basic Request
$request = new Ebay\Common\Request('GeteBayDetails');
```

### Fields
Each request is made of of one or more fields. A field can have a name, value and attributes.

```php

// Single Field
$request->addField(
        new \Ebay\Common\Field('DetailName','BuyerRequirementDetails')
        );

// Multiple Fields
$request->addFields(array(
        new \Ebay\Common\Field('DetailName','BuyerRequirementDetails')
        ));
```

### Send Request
The last step to sending a request is the service's makeRequest method.
```php
$response = $service->makeRequest($request);
```


### TODO
* More detailed documentation
* Unit Testing Completion
* Other Ebay API Calls