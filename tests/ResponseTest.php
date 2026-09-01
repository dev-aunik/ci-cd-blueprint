<?php

declare(strict_types=1);

namespace Blueprint\Tests;

use Blueprint\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Response::class)]
final class ResponseTest extends TestCase
{
    public function testJsonResponseCarriesStatusAndContentType(): void
    {
        $response = Response::json(422, ['error' => 'invalid']);

        self::assertSame(422, $response->status);
        self::assertSame('application/json', $response->headers['Content-Type']);
        self::assertStringContainsString('"error": "invalid"', $response->body);
    }

    public function testHtmlResponseCarriesCharset(): void
    {
        $response = Response::html(200, '<p>hi</p>');

        self::assertSame(200, $response->status);
        self::assertSame('text/html; charset=UTF-8', $response->headers['Content-Type']);
        self::assertSame('<p>hi</p>', $response->body);
    }
}
