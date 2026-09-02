<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * Forward requests from repository root to public/index.php
 * for environments where the web server document root is the project root.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? ''
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
