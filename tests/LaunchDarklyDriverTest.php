<?php

declare(strict_types=1);

use Laravel\Pennant\Feature;
use Oneduo\LaravelPennantLaunchdarkly\LaunchDarklyDriver;
use Oneduo\LaravelPennantLaunchdarkly\Tests\Support\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $testData = testData();

    config()->set('pennant.stores.launchdarkly', [
        'driver' => LaunchDarklyDriver::class,
        'sdk_key' => 'sdk-'.fake()->uuid(),
        'options' => [
            'feature_requester' => $testData,
        ],
    ]);

    config()->set('pennant.default', 'launchdarkly');
});

it('uses the driver', function () {
    $driver = Feature::store()->getDriver();

    expect($driver)->toBeInstanceOf(LaunchDarklyDriver::class);
});

it('determines activation of a feature', function () {
    $user = User::query()->make([
        'id' => fake()->uuid(),
    ]);

    actingAs($user);

    $feature = fake()->asciify('flag-*****');

    $td = testData();

    $state = fake()->boolean();

    $td->update($td->flag($feature)->variationForAll($state));

    $active = $state ? Feature::active($feature) : Feature::inactive($feature);

    expect($active)->toBeTrue();
});
