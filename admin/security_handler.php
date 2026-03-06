<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_flash('danger', 'Invalid CSRF token.');
        header('Location: security');
        exit;
    }

    $id = 1; // Assuming single section
    $data = [
        'tagline' => $_POST['tagline'] ?? '',
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'show_btn' => $_POST['show_btn'] ?? '0',
        'btn_url' => $_POST['btn_url'] ?? '',
        'btn_icon' => $_POST['btn_icon'] ?? '',
        'btn_small' => $_POST['btn_small'] ?? '',
        'btn_label' => $_POST['btn_label'] ?? '',
        'anchor_id' => $_POST['anchor_id'] ?? 'security'
    ];

    $result = db_update_by_id('security', $id, $data);

    // Handle items
    // First, clear existing items for this security section
    global $pdo;
    if ($pdo) {
        $tbl = DB_PREFIX . 'security_items';
        $stmt = $pdo->prepare("DELETE FROM `$tbl` WHERE security_id = ?");
        $stmt->execute([$id]);

        // Insert new items
        if (!empty($_POST['items'])) {
            $stmt = $pdo->prepare("INSERT INTO `$tbl` (security_id, title, content) VALUES (?, ?, ?)");
            foreach ($_POST['items'] as $item) {
                if (!empty($item['title'])) {
                    $stmt->execute([$id, $item['title'], $item['content']]);
                }
            }
        }
    }

    if ($result) {
        set_flash('success', 'Security Section updated successfully.');
    } else {
        set_flash('danger', 'Failed to update section.');
    }

    header('Location: security');
    exit;
}

header('Location: security');
exit;