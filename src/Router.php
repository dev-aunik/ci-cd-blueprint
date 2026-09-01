<?php

declare(strict_types=1);

namespace Blueprint;

final class Router
{
    public function __construct(private readonly Config $config)
    {
    }

    public static function normalisePath(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!is_string($path) || $path === '') {
            return '/';
        }

        return rtrim($path, '/') ?: '/';
    }

    public function resolve(string $uri): Response
    {
        return match (self::normalisePath($uri)) {
            '/' => Response::html(200, $this->render('home')),
            '/health' => Response::json(200, (new HealthCheck($this->config))->toArray()),
            default => Response::json(404, ['status' => 'not_found', 'path' => self::normalisePath($uri)]),
        };
    }

    private function render(string $view): string
    {
        $config = $this->config;

        ob_start();
        require dirname(__DIR__).'/resources/views/'.$view.'.php';

        return (string) ob_get_clean();
    }
}
