<?php
declare(strict_types=1);

// Centralized session + cookie hardening.
// Must be included BEFORE any output.

if (session_status() === PHP_SESSION_NONE) {
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (!empty($_SERVER['SERVER_PORT']) && (string)$_SERVER['SERVER_PORT'] === '443');

    // 30 days
    $lifetime = 86400 * 30;

    // PHP 7.3+ supports array options; fallback if needed.
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => $lifetime,
            'path' => '/',
            'secure' => $is_https,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    } else {
        session_set_cookie_params($lifetime, '/; samesite=Lax', '', $is_https, true);
    }

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    if ($is_https) {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}

