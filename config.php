<?php
// Database config
define('DB_DRIVER', 'sql'); // 'json' or 'sql'
define('DB_HOST', 'localhost');
define('DB_NAME', 'mayzar');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PREFIX', 'compro_');

// Session config
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']), // Secure if HTTPS
        'httponly' => true, // Protect against XSS
        'samesite' => 'Strict' // Protect against CSRF
    ]);
    session_start();
}

// Base URL detection
$project_root = rtrim(str_replace('\\', '/', __DIR__), '/');
$document_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$base_path = '';
if (stripos($project_root, $document_root) === 0) {
    $base_path = substr($project_root, strlen($document_root));
}
define('BASE_URL', $base_path);
?>