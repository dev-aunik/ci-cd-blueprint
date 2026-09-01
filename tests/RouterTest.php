<?php

declare(strict_types=1);

namespace Blueprint\Tests;

use Blueprint\Config;
use Blueprint\Router;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Router::class)]
final class RouterTest extends TestCase
{
    #[DataProvider('pathProvider')]
    public function testNormalisePath(string $uri, string $expected): void
    {
        self::assertSame($expected, Router::normalisePath($uri));
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function pathProvider(): iterable
    {
        yield 'root' => ['/', '/'];
        yield 'empty string' => ['', '/'];
        yield 'query string is dropped' => ['/health?verbose=1', '/health'];
        yield 'trailing slash is trimmed' => ['/health/', '/health'];
        yield 'nested path' => ['/a/b/', '/a/b'];
        yield 'absolute url' => ['https://example.test/health', '/health'];
    }

    public function testHealthEndpointReturnsJsonPayload(): void
    {
        $response = $this->router()->resolve('/health');

        self::assertSame(200, $response->status);
        self::assertSame('application/json', $response->headers['Content-Type']);

        /** @var array<string, string> $payload */
        $payload = json_decode($response->body, true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('ok', $payload['status']);
        self::assertSame('Blueprint', $payload['service']);
        self::assertSame('1.2.3', $payload['version']);
    }

    public function testRootReturnsHtml(): void
    {
        $response = $this->router()->resolve('/');

        self::assertSame(200, $response->status);
        self::assertSame('text/html; charset=UTF-8', $response->headers['Content-Type']);
        self::assertStringContainsString('<!doctype html>', $response->body);
    }

    public function testUnknownPathReturnsNotFound(): void
    {
        $response = $this->router()->resolve('/does-not-exist');

        self::assertSame(404, $response->status);

        /** @var array<string, string> $payload */
        $payload = json_decode($response->body, true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('not_found', $payload['status']);
        self::assertSame('/does-not-exist', $payload['path']);
    }

    public function testViewEscapesConfiguredName(): void
    {
        $router = new Router(new Config('<script>alert(1)</script>', 'testing', '1.0.0'));

        self::assertStringNotContainsString('<script>alert(1)</script>', $router->resolve('/')->body);
    }

    private function router(): Router
    {
        return new Router(new Config('Blueprint', 'testing', '1.2.3'));
    }
}
