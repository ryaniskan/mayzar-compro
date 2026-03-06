<?php
/**
 * CSRF Protection Helper
 */

/**
 * Get the current CSRF token from the session, or generate one if it doesn't exist.
 */
function get_csrf_token()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF input field for forms.
 */
function render_csrf_input()
{
    echo '<input type="hidden" name="csrf_token" value="' . get_csrf_token() . '">';
}

/**
 * Verify if the provided token matches the one in the session.
 */
function verify_csrf_token($token)
{
    $session_token = get_csrf_token();
    return hash_equals($session_token, $token);
}

/**
 * Automatically handle CSRF verification for POST requests.
 */
function check_csrf()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';

        // If not in $_POST, try reading from JSON input
        if (empty($token)) {
            $input = json_decode(file_get_contents('php://input'), true);
            $token = $input['csrf_token'] ?? '';
        }

        if (!verify_csrf_token($token)) {
            // Log this as a potential CSRF attack
            error_log('CSRF Token Mismatch from ' . $_SERVER['REMOTE_ADDR']);

            // Clear token to be safe
            unset($_SESSION['csrf_token']);

            header('Content-Type: application/json', true, 403);
            die(json_encode(['success' => false, 'message' => 'Security Error: CSRF Token Mismatch. Please refresh and try again.']));
        }
    }
}
?>