<?php

declare(strict_types=1);

namespace Blueprint;

final class Config
{
    public function __construct(
        public readonly string $name,
        public readonly string $environment,
        public readonly string $version,
    ) {
    }

    public static function fromEnvironment(): self
    {
        return new self(
            name: self::read('APP_NAME', 'CI/CD Blueprint'),
            environment: self::read('APP_ENV', 'local'),
            version: self::read('APP_VERSION', '0.1.0'),
        );
    }

    private static function read(string $key, string $default): string
    {
        $value = getenv($key);

        return is_string($value) && $value !== '' ? $value : $default;
    }
}
