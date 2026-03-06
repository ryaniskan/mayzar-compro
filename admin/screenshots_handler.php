<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/validation_helper.php';
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected.');
        header("Location: " . BASE_URL . "/admin/screenshots");
        exit;
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "screenshots SET anchor_id = ? WHERE id = 1");
    $stmt->execute([$_POST['anchor_id'] ?? 'screenshots']);

    // Sync Items
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "screenshots_items WHERE screenshot_id = 1")->execute();
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "screenshots_items (screenshot_id, image_path, sort_order) VALUES (1, ?, ?)");
    $screenshots = $_POST['screenshots'] ?? [];
    foreach ($screenshots as $idx => $path) {
        $stmt->execute([$path, $idx]);
    }
    set_flash('success', 'Screenshot slider updated successfully!');
    header("Location: " . BASE_URL . "/admin/screenshots");
    exit;
}
?>