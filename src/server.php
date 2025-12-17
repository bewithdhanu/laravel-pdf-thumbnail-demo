<?php

/**
 * Router for PHP's built-in server.
 *
 * This ensures existing static files (e.g. /storage/thumbnail/*.png) are served
 * directly, while everything else is handled by Laravel.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';


