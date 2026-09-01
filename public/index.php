<?php

declare(strict_types=1);

use Blueprint\Config;
use Blueprint\Router;

require_once dirname(__DIR__).'/vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'] ?? '/';

$router = new Router(Config::fromEnvironment());
$router->resolve(is_string($uri) ? $uri : '/')->send();
