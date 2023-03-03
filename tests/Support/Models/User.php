<?php

declare(strict_types=1);

namespace Oneduo\LaravelPennantLaunchdarkly\Tests\Support\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Laravel\Pennant\Contracts\FeatureScopeable;
use LaunchDarkly\LDUser;
use LaunchDarkly\LDUserBuilder;

class User extends Authenticable implements FeatureScopeable
{
    protected $guarded = [];

    protected $keyType = 'string';

    public function toFeatureIdentifier(string $driver): LDUser
    {
        return (new LDUserBuilder($this->getKey()))->build();
    }
}
