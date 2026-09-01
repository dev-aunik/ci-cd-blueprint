<?php

declare(strict_types=1);

namespace Blueprint\Tests;

use Blueprint\Config;
use Blueprint\HealthCheck;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HealthCheck::class)]
final class HealthCheckTest extends TestCase
{
    public function testReportsConfiguredService(): void
    {
        $payload = (new HealthCheck(new Config('Orders', 'staging', '3.0.0')))->toArray();

        self::assertSame('ok', $payload['status']);
        self::assertSame('Orders', $payload['service']);
        self::assertSame('staging', $payload['environment']);
        self::assertSame('3.0.0', $payload['version']);
    }

    public function testTimestampIsIso8601Utc(): void
    {
        $payload = (new HealthCheck(new Config('Orders', 'staging', '3.0.0')))->toArray();

        self::assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\+00:00$/',
            $payload['timestamp'],
        );
    }
}
