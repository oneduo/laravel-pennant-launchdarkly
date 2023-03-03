<?php

namespace Oneduo\LaravelPennantLaunchdarkly\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Oneduo\LaravelPennantLaunchdarkly\LaravelPennantLaunchdarklyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Oneduo\\LaravelPennantLaunchdarkly\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPennantLaunchdarklyServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-pennant-launchdarkly_table.php.stub';
        $migration->up();
        */
    }
}
