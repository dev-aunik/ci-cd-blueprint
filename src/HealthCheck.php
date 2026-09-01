<?php

declare(strict_types=1);

namespace Blueprint;

final class HealthCheck
{
    public function __construct(private readonly Config $config)
    {
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'status' => 'ok',
            'service' => $this->config->name,
            'environment' => $this->config->environment,
            'version' => $this->config->version,
            'timestamp' => gmdate('c'),
        ];
    }
}
