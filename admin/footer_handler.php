<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs for disallowed HTML (Allow <a> in footer specifically)
    if (!validate_recursive($_POST, true, true)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt;, &lt;br /&gt;, and &lt;a&gt; are allowed.');
        header('Location: ' . BASE_URL . '/admin/footer');
        exit;
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "footer SET copyright = ? WHERE id = 1");
    $stmt->execute([$_POST['copyright'] ?? '']);

    // Sync Links
    $links = $_POST['links'] ?? [];
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "footer_links WHERE footer_id = 1")->execute();
    $stmtL = $pdo->prepare("INSERT INTO " . DB_PREFIX . "footer_links (footer_id, label, url, sort_order) VALUES (1, ?, ?, ?)");
    foreach ($links as $idx => $link) {
        $stmtL->execute([$link['label'] ?? '', $link['url'] ?? '', $idx]);
    }

    set_flash('success', 'Footer configuration updated successfully!');
    header('Location: ' . BASE_URL . '/admin/footer');
    exit;
}
