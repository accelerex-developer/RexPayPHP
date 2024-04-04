# rexpay


A PHP API wrapper for [Rexpay](https://www.myrexpay.com/).

[![Rexpay](img/rexpay.svg "Rexpay")](https://www.myrexpay.com/)

## Requirements
- Curl 7.34.0 or more recent (Unless using Guzzle)
- PHP 5.4.0 or more recent

## Install

### Via Composer

``` bash
    $ composer require pils36/rexpay
```

### Via download

Download a release version from the [releases page](https://github.com/Pils36/rexpay/releases).
Extract, then:
``` php
    require 'path/to/src/autoload.php';
```

## Usage

Do a redirect to the authorization URL received from calling the /transaction endpoint. This URL is valid for one time use, so ensure that you generate a new URL per transaction.

When the payment is successful, we will call your callback URL (as setup in your dashboard or while initializing the transaction) and return the reference sent in the first step as a query parameter.

If you use a test secret key, we will call your test callback url, otherwise, we'll call your live callback url.

### 0. Prerequisites
Confirm that your server can conclude a TLSv1.2 connection to Rexpay's servers. Most up-to-date software have this capability. Contact your service provider for guidance if you have any SSL errors.
*Don't disable SSL peer verification!*

### 1. Prepare your parameters
`email`, `userId`, `amount`, `description`, `reference` and `authToken` are the most common compulsory parameters.

### 2. Initialize a transaction
Initialize a transaction by calling our API.


### Note: $authtoken is a Basic Authentication Token 
Your username:password in base64 encoded. You can reference the link to generate basic authentication token 
### [Basic Auth Header Generator](https://www.debugbear.com/basic-auth-header-generator)




```php

    require_once('./vendor/autoload.php');

    $rexpay = new \Pils36\Rexpay;
    
    try
    {

      $tranx = $rexpay->transaction->initialize([
        'reference'=>"sm23oyr1122",     // string   
        'amount'=>200,     // integer   
        'currency'=>"NGN",     // string   
        'userId'=>"awoyeyetimilehin@gmail.com",     // string   
        'callbackUrl'=>"google.com",     // string   
        'metadata'=> ['email' => "awoyeyetimilehin@gmail.com", 'customerName' => "Victor Musa"], // string
        'authToken'=> `$authtoken`, // string - (Basic Authentication Token)
        'mode' => 'test' // test or production
      ]);



    } catch(\Pils36\Rexpay\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }

    // store transaction reference so we can query in case user never comes back
    // perhaps due to network issue
    saveLastTransactionId($tranx);

```

When the user enters their card details, Rexpay will validate and charge the card. It will do all the below:

Redirect back to a callback_url set when initializing the transaction or on your dashboard. Customers see a Transaction was successful message.


Before you give value to the customer, please make a server-side call to our verification endpoint to confirm the status and properties of the transaction.


### 3. Verify Transaction
After we redirect to your callback url, please verify the transaction before giving value.

```php
    // initiate the Library's Rexpay Object
    $rexpay = new Pils36\Rexpay;
    try
    {
      // verify using the library
      $tranx = $rexpay->transaction->verify([
        'transactionReference'=>$reference, // unique to transactions
        'authToken'=> `$authtoken`, // string - (Basic Authentication Token)
        'mode' => 'test' // test or production
      ]);
    } catch(\Pils36\Rexpay\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }

    ($tranx->responseCode === 00) => "success";
    ($tranx->responseCode === 01) => "failed";
    ($tranx->responseCode === 02) => "pending";

    if ($tranx->responseCode === 00) {
      // transaction was successful... Please check other things like whether you already gave value for this transactions
      // if the email matches the customer who owns the product etc
      // Save your transaction information here
    }
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
    $ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details. Check our [todo list](TODO.md) for features already intended.

## Security

If you discover any security related issues, please email adenugaadebambo41@gmail.com instead of using the issue tracker.

## Credits

- [Pils36][link-author]
- [All Contributors][link-contributors]


[link-author]: https://github.com/Pils36
[link-contributors]: ../../contributors


