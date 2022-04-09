# Ovh PHP Api Client

This is a simple PHP client for the [Ovh Api](https://api.ovh.com/console/#/).

More information about API usage at [first-steps-with-ovh-api](https://docs.ovh.com/gb/en/api/first-steps-with-ovh-api/)

![Ovh Api](https://api.ovh.com/images/ovh-under-construction.png)

This project is inspired by [GitLab PHP API Client](https://github.com/GitLabPHP/Client)

<p align="center">
<a href="https://github.com/Hikingyo/php-ovh-api/actions?query=workflow%3ABUILD"><img src="https://img.shields.io/github/workflow/status/Hikingyo/php-ovh-api/BUILD?label=BUILD&style=flat-square" alt="Build Status"/></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"/></a>
<a href="https://packagist.org/packages/hikingyo/php-ovh-api"><img src="https://img.shields.io/packagist/dt/hikingyo/php-ovh-api?style=flat-square" alt="Packagist Downloads"/></a>
<a href="https://github.com/Hikingyo/php-ovh-api/releases"><img src="https://img.shields.io/github/v/release/Hikingyo/php-ovh-api?display_name=tag&include_prereleases" alt="Latest Version"/></a>

</p>

## Installation

This version supports [PHP](https://php.net) 7.4 and above.

To get started, siply require the library using [Composer](https://getcomposer.org/):

You will also need to install packages that "
provide" [`psr/http-client-implementation`](https://packagist.org/providers/psr/http-client-implementation)
and [`psr/http-factory-implementation`](https://packagist.org/providers/psr/http-factory-implementation) in order to
have a working client.

```bash
$ composer require "hikingyo/php-ovh-api" "guzzlehttp/guzzle:^7.4" "http-interop/http-factory-guzzle:^1.2"
```

We are decoupled from any HTTP messaging client by using

* [PSR-7](https://www.php-fig.org/psr/psr-7/)
* [PSR-17](https://www.php-fig.org/psr/psr-17/)
* [PSR-18](https://www.php-fig.org/psr/psr-18/)
* [HTTPlug](https://httplug.io/)

You can visit [HTTPlug for library users](https://docs.php-http.org/en/latest/httplug/users.html) to get more
information about installing HTTPlug related packages.

## General API Usage

```php
<?php
$api = new \Ovh\Api();
$api->setEndpoint('ovh-eu');

$time = $api->auth()->time();

// Some endpoint need authentication
// See https://docs.ovh.com/gb/en/api/first-steps-with-ovh-api/ to get your consumer key and secret
$api->authenticate('<your_application_key>', '<your_application_secret>', '<your_consumer_key>');

$domains = $api->domain()->list()
```

### HTTP Client Factory

By providing a `Hikingyo\Ovh\HttpClient\HttpClientFactory` to the `Hikingyo\Ovh\Client` constructor, you can customize
the HTTP client. For example, to customize the user agent:

```php
$plugin = new Http\Client\Common\Plugin\HeaderSetPlugin([
    'User-Agent' => 'Foobar',
]);
$builder = new Hikingyo\Ovh\HttpClient\HttpClientFactory();
$builder->addPlugin($plugin);
$client = new Hikingyo\Ovh\Client($builder);
```

One can read more about HTTPlug
plugins [here](https://docs.php-http.org/en/latest/plugins/introduction.html#how-it-works).

Take a look around the [API methods](https://github.com/hikingyo/ovh-api-client/tree/master/src/EndPoint), and please
feel free to report any bugs, noting our [code of conduct](.github/CODE_OF_CONDUCT.md).

## Authors

* [Hikingyo](https://twitter.com/hikingyo)

## Contributing

See the [contributing guide](CONTRIBUTING.md) for more information.

## License

This project is under [MIT license](LICENSE.md).

## Code of Conduct

See the [code of conduct](CODE_OF_CONDUCT.md) for more information.