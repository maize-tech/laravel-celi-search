# Laravel Celi Search

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maize-tech/laravel-celi-search.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-celi-search)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/maize-tech/laravel-celi-search/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/maize-tech/laravel-celi-search/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/maize-tech/laravel-celi-search/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/maize-tech/laravel-celi-search/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maize-tech/laravel-celi-search.svg?style=flat-square)](https://packagist.org/packages/maize-tech/laravel-celi-search)

This package allows you to easily integrate your project with Celi Search, adding a custom Laravel Scout provider.

> This project is a work-in-progress. Code and documentation are currently under development and are subject to change.

## Installation

You can install the package via composer:

```bash
composer require maize-tech/laravel-celi-search
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="celi-search-config"
```

This is the contents of the published config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Base url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the full base url used to perform update and destroy
    | requests to the Celi Search backoffice.
    |
    */

    'base_url' => env('CELI_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Search base url
    |--------------------------------------------------------------------------
    |
    | Here you may specify the full base url used to perform search queries.
    |
    */

    'search_base_url' => env('CELI_SEARCH_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Project name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the name of the project defined in Celi Search.
    |
    */

    'project' => env('CELI_PROJECT'),

    /*
    |--------------------------------------------------------------------------
    | Searchable models
    |--------------------------------------------------------------------------
    |
    | Here you may specify the list of fully qualified class names of
    | searchable models.
    |
    */

    'searchables' => [
        // \App\Models\User::class,
    ],

];
```

## Usage

```php
$celiSearch = new Maize\CeliSearch();
echo $celiSearch->echoPhrase('Hello, Maize!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/maize-tech/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](https://github.com/maize-tech/.github/security/policy) on how to report security vulnerabilities.

## Credits

- [Enrico De Lazzari](https://github.com/enricodelazzari)
- [Riccardo Dalla Via](https://github.com/riccardodallavia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
