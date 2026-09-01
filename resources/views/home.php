<?php

declare(strict_types=1);

/** @var \Blueprint\Config $config */
$e = static fn (string $v): string => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $e($config->name) ?></title>
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

        * { box-sizing: border-box; }

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

        dt { color: var(--muted); }

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
    <h1><?= $e($config->name) ?></h1>
    <p>
        A small PHP service for exercising Docker builds, GitHub Actions,
        image publishing, and health checks.
    </p>
    <dl>
        <dt>Environment</dt>
        <dd><?= $e($config->environment) ?></dd>
        <dt>Version</dt>
        <dd><?= $e($config->version) ?></dd>
        <dt>Health</dt>
        <dd><a href="/health">/health</a></dd>
    </dl>
</main>
</body>
</html>
