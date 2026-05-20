<?php

declare(strict_types=1);

$appName = getenv('APP_NAME') ?: 'CI/CD Blueprint';
$environment = getenv('APP_ENV') ?: 'local';
$version = getenv('APP_VERSION') ?: '0.1.0';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if ($path === '/health') {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'ok',
        'service' => $appName,
        'environment' => $environment,
        'version' => $version,
        'timestamp' => gmdate('c'),
    ], JSON_PRETTY_PRINT);
    exit;
}

header('Content-Type: text/html; charset=UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        :root {
            color-scheme: light dark;
            --bg: #f6f8fb;
            --surface: #ffffff;
            --text: #18212f;
            --muted: #5c6678;
            --accent: #12715b;
            --line: #d9e0ea;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #10151d;
                --surface: #161d28;
                --text: #f1f5f9;
                --muted: #a9b4c3;
                --accent: #3dd6a3;
                --line: #2b3543;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            width: min(720px, 100%);
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 32px;
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.05;
        }

        p {
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        dl {
            display: grid;
            grid-template-columns: max-content 1fr;
            gap: 12px 20px;
            margin: 28px 0 0;
        }

        dt {
            color: var(--muted);
        }

        dd {
            margin: 0;
            font-weight: 700;
        }

        a {
            color: var(--accent);
            font-weight: 700;
        }
    </style>
</head>
<body>
<main>
    <h1><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></h1>
    <p>
        A containerized PHP service prepared for professional CI/CD demonstrations,
        pull request validation, Docker image publishing, and release smoke checks.
    </p>
    <dl>
        <dt>Environment</dt>
        <dd><?= htmlspecialchars($environment, ENT_QUOTES, 'UTF-8') ?></dd>
        <dt>Version</dt>
        <dd><?= htmlspecialchars($version, ENT_QUOTES, 'UTF-8') ?></dd>
        <dt>Health</dt>
        <dd><a href="/health">/health</a></dd>
    </dl>
</main>
</body>
</html>
