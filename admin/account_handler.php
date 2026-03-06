<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/csrf_helper.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('danger', 'Invalid CSRF token.');
        header('Location: account');
        exit;
    }

    $current_pass = $_POST['current_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    if (empty($current_pass) || empty($new_pass) || empty($confirm_pass)) {
        set_flash('danger', 'All fields are required.');
        header('Location: account');
        exit;
    }

    if ($new_pass !== $confirm_pass) {
        set_flash('danger', 'New passwords do not match.');
        header('Location: account');
        exit;
    }

    $user_id = $_SESSION['admin_user']['id'];
    $user = db_get_by_id('users', $user_id);

    if (!$user || !password_verify($current_pass, $user['password_hash'])) {
        set_flash('danger', 'Incorrect current password.');
        header('Location: account');
        exit;
    }

    $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);

    global $pdo;
    $tbl = DB_PREFIX . 'users';
    $stmt = $pdo->prepare("UPDATE `$tbl` SET password_hash = ? WHERE id = ?");
    $result = $stmt->execute([$new_hash, $user_id]);

    if ($result) {
        // Update session
        $_SESSION['admin_user']['password_hash'] = $new_hash;
        set_flash('success', 'Password updated successfully.');
    } else {
        set_flash('danger', 'Failed to update password.');
    }

    header('Location: account');
    exit;
}

header('Location: settings');
exit;
