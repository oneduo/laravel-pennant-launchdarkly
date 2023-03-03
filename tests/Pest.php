<?php

use LaunchDarkly\Integrations\TestData;
use Oneduo\LaravelPennantLaunchdarkly\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function testData(): TestData
{
    if (! app()->has('launchdarkly.testdata')) {
        app()->singleton('launchdarkly.testdata', function () {
            return new TestData();
        });
    }

    return app('launchdarkly.testdata');
}
