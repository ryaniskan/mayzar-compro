<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs: Only span/br allowed, no inline styles
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt;, and &lt;br /&gt; are allowed.');
        header("Location: " . BASE_URL . "/admin/download");
        exit;
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "download SET title = ?, description = ? WHERE id = 1");
    $stmt->execute([$_POST['title'] ?? '', $_POST['description'] ?? '']);

    // Sync Buttons
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "download_buttons WHERE download_id = 1")->execute();
    $stmtB = $pdo->prepare("INSERT INTO " . DB_PREFIX . "download_buttons (download_id, icon, text, url, is_primary, sort_order) VALUES (1, ?, ?, ?, ?, ?)");
    $buttons = $_POST['buttons'] ?? [];
    $idx = 0;
    foreach ($buttons as $btn) {
        $stmtB->execute([$btn['icon'] ?? '', $btn['text'] ?? '', $btn['url'] ?? '', !empty($btn['is_primary']) ? 1 : 0, $idx++]);
    }

    set_flash('success', 'Download section updated successfully!');
    header("Location: " . BASE_URL . "/admin/download");
    exit;
}
?>