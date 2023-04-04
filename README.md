# Track Poste Italiane shipments

[![Latest Version on Packagist](https://img.shields.io/packagist/v/anmartini/poste-track.svg?style=flat-square)](https://packagist.org/packages/anmartini/poste-track)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/anmartini/poste-track/run-tests.yml?branch=main&style=flat-square&label=tests)](https://github.com/anmartini/poste-track/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/anmartini/poste-track.svg?style=flat-square)](https://packagist.org/packages/anmartini/poste-track)

Track Poste Italiane shipments

## Disclaimer

This project has no affiliation with Poste Italiane S.p.A. and it is solely intended for personal use.

## Installation

You can install the package via composer:

```bash
composer require anmartini/poste-track
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Anmartini\PosteTrack\PosteTrackServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Tries
    |--------------------------------------------------------------------------
    |
    | This value is the number of times the request will be retried
    | with a sleep time of 1 second between tries. This is needed
    | to pass the reCAPTCHA validation.
    |
    */

    'tries' => env('POSTE_TRACK_TRIES', 3),
];
```

## Usage

```php
$tracking = PosteTrack::track('CODE');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrea Martini](https://github.com/anmartini)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
