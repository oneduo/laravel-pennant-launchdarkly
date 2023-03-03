<?php

declare(strict_types=1);

namespace Oneduo\LaravelPennantLaunchdarkly;

use Illuminate\Contracts\Foundation\Application;
use Laravel\Pennant\Feature;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPennantLaunchdarklyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-pennant-launchdarkly');
    }

    public function packageBooted(): void
    {
        Feature::extend(LaunchDarklyDriver::class, function (Application $app, array $config) {
            return new LaunchDarklyDriver($config);
        });
    }
}
