<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/csrf_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Invalid CSRF token.');
        header('Location: ' . ($_POST['redirect'] ?? 'settings'));
        exit;
    }

    $slug = $_POST['slug'] ?? '';
    if (empty($slug)) {
        set_flash('error', 'Missing page identifier.');
        header('Location: settings');
        exit;
    }

    $data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'content' => $_POST['content'] ?? ''
    ];

    global $pdo;
    $tbl = DB_PREFIX . 'pages';

    $stmt = $pdo->prepare("UPDATE `$tbl` SET title = ?, description = ?, content = ? WHERE slug = ?");
    $result = $stmt->execute([$data['title'], $data['description'], $data['content'], $slug]);

    if ($result) {
        set_flash('success', 'Page content updated successfully.');
    } else {
        set_flash('error', 'Failed to update page content.');
    }

    header('Location: ' . $slug);
    exit;
}

header('Location: settings');
exit;
