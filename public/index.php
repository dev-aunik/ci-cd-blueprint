<?php

declare(strict_types=1);

use Blueprint\Config;
use Blueprint\Router;

require_once dirname(__DIR__).'/vendor/autoload.php';

$router = new Router(Config::fromEnvironment());
$router->resolve($_SERVER['REQUEST_URI'] ?? '/')->send();
