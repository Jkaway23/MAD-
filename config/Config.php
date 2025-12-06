<?php
// config/config.php

// Auto detect environment (localhost vs production)
$isLocal = (
    $_SERVER['HTTP_HOST'] == 'localhost' || 
    strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false ||
    strpos($_SERVER['HTTP_HOST'], '::1') !== false
);

if ($isLocal) {
    // LOCAL DEVELOPMENT
    define('BASEURL', 'http://localhost/lecture27/aimvc/public/');
    define('APP_PATH', 'http://localhost/lecture27/aimvc/public/');
    
    if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
    if (!defined('DB_PORT')) define('DB_PORT', 3306);
    if (!defined('DB_NAME')) define('DB_NAME', 'lecture27');
    if (!defined('DB_USER')) define('DB_USER', 'aimvc_user');
    if (!defined('DB_PASS')) define('DB_PASS', 'AimvcPass2025!@#');
} else {
    // PRODUCTION SERVER
    define('BASEURL', 'https://nathanwebsite.site/lecture27/aimvc/public/');
    define('APP_PATH', 'https://nathanwebsite.site/lecture27/aimvc/public/');
    
    // Database credentials production
    if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
    if (!defined('DB_PORT')) define('DB_PORT', 3306);
    if (!defined('DB_NAME')) define('DB_NAME', 'lecture27');
    if (!defined('DB_USER')) define('DB_USER', 'aimvc_user');
    if (!defined('DB_PASS')) define('DB_PASS', 'AimvcPass2025!@#');
}

// Start session
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
