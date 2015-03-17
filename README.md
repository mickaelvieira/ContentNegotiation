# Content Negotiation

PHP implementation of server-driven negotiation

Specification: 
- [RFC7231: Content Negotiation](https://tools.ietf.org/html/rfc7231#section-5.3)

## Installation

ContentNegotiation requires php >= 5.4

Install CollectionJson with [Composer](https://getcomposer.org/)

```json
{
    "require": {
        "mvieira/content-negotiation": "dev-master"
    }
}
```

## Contributing

```sh
$ git clone git@github.com:mickaelvieira/ContentNegotiation.git
$ cd ContentNegotiation
$ composer install
```

### Run the test

The test suite has been written with [PHPSpec](http://phpspec.net/)

```sh
$ ./bin/phpspec run --format=pretty
```

### PHP Code Sniffer

This project follows the coding style guide [PSR2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

```sh
$ ./bin/phpcs --standard=PSR2 ./src/
```

## Documentation

```php
use ContentNegotiation\Negotiation;

$negotiation = new Negotiation(getallheaders());

$media    = $negotiation->getMedia(['application/json', 'application/xml']);
$language = $negotiation->getLanguage(['en', 'fr']);
$charset  = $negotiation->getCharset(['utf-8']);

```

