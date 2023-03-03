<?php

declare(strict_types=1);

namespace Oneduo\LaravelPennantLaunchdarkly;

use BadMethodCallException;
use InvalidArgumentException;
use Laravel\Pennant\Contracts\Driver;
use LaunchDarkly\FeatureFlagsState;
use LaunchDarkly\LDClient;
use LaunchDarkly\LDUser;

class LaunchDarklyDriver implements Driver
{
    protected LDClient $client;

    protected LDUser $context;

    protected FeatureFlagsState $flags;

    public function __construct(protected array $config)
    {
        $this->client = app(LDClient::class, [
            'sdkKey' => $this->config['sdk_key'],
            'options' => $this->config['options'] ?? [],
        ]);
    }

    public function getAll(array $features): array
    {
        return collect($features)
            ->map(function ($scopes, $feature) {
                return collect($scopes)
                    ->map(fn ($scope) => $this->get($feature, $scope))
                    ->all();
            })
            ->all();
    }

    public function get(string $feature, mixed $scope): bool
    {
        if (! $scope instanceof LDUser) {
            throw new InvalidArgumentException(
                sprintf('[E1] Scope must be an instance of %s, got %s', LDUser::class, $scope::class)
            );
        }

        return $this->client->variation($feature, $scope);
    }

    public function defined(): array
    {
        return [];
    }

    public function define(string $feature, callable $resolver): void
    {
        throw new BadMethodCallException('[E2] Not implemented, Launchdarkly driver does not support this method');
    }

    public function set(string $feature, mixed $scope, mixed $value): void
    {
        throw new BadMethodCallException('[E2] Not implemented, Launchdarkly driver does not support this method');
    }

    public function setForAllScopes(string $feature, mixed $value): void
    {
        throw new BadMethodCallException('[E2] Not implemented, Launchdarkly driver does not support this method');
    }

    public function delete(string $feature, mixed $scope): void
    {
        throw new BadMethodCallException('[E2] Not implemented, Launchdarkly driver does not support this method');
    }

    public function purge(?array $features): void
    {
        throw new BadMethodCallException('[E2] Not implemented, Launchdarkly driver does not support this method');
    }
}
