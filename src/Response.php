<?php

declare(strict_types=1);

namespace Blueprint;

final class Response
{
    /**
     * @param array<string, string> $headers
     */
    private function __construct(
        public readonly int $status,
        public readonly string $body,
        public readonly array $headers,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function json(int $status, array $payload): self
    {
        return new self(
            $status,
            (string) json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
            ['Content-Type' => 'application/json'],
        );
    }

    public static function html(int $status, string $body): self
    {
        return new self($status, $body, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $name => $value) {
            header($name.': '.$value);
        }

        echo $this->body;
    }
}
