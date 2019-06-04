# A Laravel-oriented BluePay client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/teamzac/bluepay-php.svg?style=flat-square)](https://packagist.org/packages/teamzac/bluepay-php)
[![Build Status](https://img.shields.io/travis/teamzac/bluepay-php/master.svg?style=flat-square)](https://travis-ci.org/teamzac/bluepay-php)
[![Quality Score](https://img.shields.io/scrutinizer/g/teamzac/bluepay-php.svg?style=flat-square)](https://scrutinizer-ci.com/g/teamzac/bluepay-php)
[![Total Downloads](https://img.shields.io/packagist/dt/teamzac/bluepay-php.svg?style=flat-square)](https://packagist.org/packages/teamzac/bluepay-php)

If you need to reach the BluePay API in Laravel 5.8+ but don't particularly care for the official SDK, this might be for you. 

**This package is not yet ready for production use. It does not yet have tests and the API should be considered unstable. Use at your own risk.**

## Installation

You can install the package via composer:

```bash
composer require teamzac/laravel-bluepay
```

The service provider and ```BluePay``` facade will be automatically registered for you.

## Usage

Using the facade to create save customer information and return a token for future use

``` php
BluePay::tokens()->setCustomer([
  // data
])->setCard([
  // data
])->create();
```

Using the facade to charge a token

``` php
BluePay::tokens()->setToken($token)->charge(100.00);
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email chad@zactax.com instead of using the issue tracker.

## Credits

- [Chad Janicek](https://github.com/teamzac)
- [All Contributors](../../contributors)
- [Laravel Package Boilerplate](https://laravelpackageboilerplate.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
