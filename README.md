# BUTTON Wallet PHP API Client

PHP package for the [BUTTON Wallet](https://client.buttonwallet.com/api) API.

## Getting Started

Run the following command to install this package into your project.

```
composer require coinrequest/button-wallet-php-api 
```

### Prerequisites

You will need Composer to install this package.

### Installing

After installing this package with composer, create a new ButtonWallet
instance. And include your API key.

Something like this

```
$buttonWallet = new ButtonWallet('yourpersonalapikey', 'yourcompanyid');
```

And call the desired endpoint

```
$buttonWallet->linkEndpoint()->fastLink($params);
```

The current implemented endpoints are: 

* /FastLink

Documentation of the endpoints will be later available online. Please check the code for any documentation.

## Running the tests

First, create a .env file and set your API Key and your Company ID. Please see the .env.example for the template.

Run the tests in the Tests directory with PHPUnit.


## Built With

* [ButtonWallet](https://client.buttonwallet.com/api/) - For the API Server
* [PHPUnit](https://github.com/sebastianbergmann/phpunit/) - Test Framework
* [Guzzle](https://github.com/guzzle/guzzle) - For HTTP Requests

## Contributing

Please help us to develop this package. Every input and/or feedback is really appreciated!

## License

This project is licensed under the MIT License.


