# LaunchDarkly driver for Laravel Pennant

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oneduo/laravel-pennant-launchdarkly.svg?style=flat-square)](https://packagist.org/packages/oneduo/laravel-pennant-launchdarkly)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/oneduo/laravel-pennant-launchdarkly/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/oneduo/laravel-pennant-launchdarkly/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/oneduo/laravel-pennant-launchdarkly/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/oneduo/laravel-pennant-launchdarkly/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oneduo/laravel-pennant-launchdarkly.svg?style=flat-square)](https://packagist.org/packages/oneduo/laravel-pennant-launchdarkly)

A Laravel Pennant driver for LaunchDarkly.

- [Installation](#installation)
- [Usage](#usage)
    * [Related documentation:](#related-documentation-)
- [Troubleshooting](#troubleshooting)
    * [[E1] Scope must be an instance of LDUser](#-e1--scope-must-be-an-instance-of-lduser)
    * [[E2] Not implemented, Launchdarkly driver does not support this method](#-e2--not-implemented--launchdarkly-driver-does-not-support-this-method)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

```bash
composer require oneduo/laravel-pennant-launchdarkly
```

## Usage

You may use the driver in your existing Laravel Pennant configuration file, by setting your store's driver
to `LaunchDarklyDriver::class`.

You should provide your SDK key in your store's configuration.

You may add any LaucnhDarkly cleint specific configuration options to the store's configuration.

A typical configuration might look like this:

```php
// config/pennant.php

<?php

use Oneduo\LaravelPennantLaunchdarkly\LaunchDarklyDriver;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Pennant Store
    |--------------------------------------------------------------------------
    |
    | Here you will specify the default store that Pennant should use when
    | storing and resolving feature flag values. Pennant ships with the
    | ability to store flag values in an in-memory array or database.
    |
    | Supported: "array", "database"
    |
    */

    'default' => env('PENNANT_STORE', 'laucnhdarkly'),

    /*
    |--------------------------------------------------------------------------
    | Pennant Stores
    |--------------------------------------------------------------------------
    |
    | Here you may configure each of the stores that should be available to
    | Pennant. These stores shall be used to store resolved feature flag
    | values - you may configure as many as your application requires.
    |
    */

    'stores' => [
        // ...
        
        'laucnhdarkly' => [
            'driver' => LaunchDarklyDriver::class,
            'sdk_key' => env('LAUNCHDARKLY_SDK_KEY'),
            'options' => [],
        ],
    ],
];
```

Then, in your scopeable Model, for instance your User model, you should implement the `FeatureScopeable`
interface, and provide a `toFeatureIdentifier` method.

```php 
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Laravel\Pennant\Contracts\FeatureScopeable;
use LaunchDarkly\LDUser;
use LaunchDarkly\LDUserBuilder;

class User extends Authenticable implements FeatureScopeable
{
    // ...
    public function toFeatureIdentifier(string $driver): LDUser
    {
        return (new LDUserBuilder($this->getKey()))
        // you may add more attributes to your LDUser
        // ->email($this->email)
        // ->firstName($this->firstname)
        // ->lastName($this->lastname)
        //->custom([...])
        ->build();
    }
}
```

### Related documentation

- https://docs.launchdarkly.com/sdk/features/test-data-sources#php
- https://launchdarkly.github.io/php-server-sdk/

## Troubleshooting

### [E1] Scope must be an instance of LDUser

This is most likely due to either the scope you are using, or the fact that your currently authenticated user not having
implemented `FeatureScopeable` correctly.

Please check the usage instructions.

### [E2] Not implemented, Launchdarkly driver does not support this method

The LaunchDarkly driver for Laravel Pennant only supports read operations, and does not support write operations. If you
need to write to LaunchDarkly, you should use the LaunchDarkly platform or the REST API.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Charaf Rezrazi](https://github.com/rezrazi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
