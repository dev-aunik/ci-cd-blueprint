<?php

declare(strict_types=1);

namespace Blueprint\Tests;

use Blueprint\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Config::class)]
final class ConfigTest extends TestCase
{
    protected function tearDown(): void
    {
        foreach (['APP_NAME', 'APP_ENV', 'APP_VERSION'] as $key) {
            putenv($key);
        }
    }

    public function testFallsBackToDefaultsWhenEnvironmentIsEmpty(): void
    {
        putenv('APP_NAME');
        putenv('APP_ENV');
        putenv('APP_VERSION');

        $config = Config::fromEnvironment();

        self::assertSame('CI/CD Blueprint', $config->name);
        self::assertSame('local', $config->environment);
        self::assertSame('0.1.0', $config->version);
    }

    public function testReadsValuesFromEnvironment(): void
    {
        putenv('APP_NAME=Checkout Service');
        putenv('APP_ENV=production');
        putenv('APP_VERSION=2.4.1');

        $config = Config::fromEnvironment();

        self::assertSame('Checkout Service', $config->name);
        self::assertSame('production', $config->environment);
        self::assertSame('2.4.1', $config->version);
    }

    public function testTreatsAnEmptyVariableAsUnset(): void
    {
        putenv('APP_ENV=');

        self::assertSame('local', Config::fromEnvironment()->environment);
    }
}
