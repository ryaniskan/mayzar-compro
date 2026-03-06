<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/csrf_helper.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/lang.php';

/**
 * Basic security headers
 */
function apply_security_headers()
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

function check_auth()
{
    apply_security_headers();

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['admin_user'])) {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    // Automatically verify CSRF on all state-changing POST requests
    check_csrf();
}

function get_logged_in_user()
{
    if (!isset($_SESSION['admin_user']))
        return null;

    $user = $_SESSION['admin_user'];

    // Refresh role name just in case it changed
    $role = db_get_by_id('roles', $user['role_id']);
    if ($role) {
        $user['role_name'] = $role['name'];
    }

    return $user;
}
?>