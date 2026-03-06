<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
check_auth();

require_once __DIR__ . '/flash_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modules'])) {
        // Clear and re-insert modules with new order
        $pdo->exec("DELETE FROM " . DB_PREFIX . "modules");
        $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "modules (module_id, name, visible, sort_order) VALUES (?, ?, ?, ?)");
        foreach ($_POST['modules'] as $idx => $module_data) {
            $stmt->execute([
                $module_data['id'],
                $module_data['name'],
                isset($module_data['visible']) ? 1 : 0,
                $idx
            ]);
        }
        set_flash('success', 'Modules configuration updated successfully!');
        header('Location: ' . BASE_URL . '/admin/modules');
        exit;
    } else {
        set_flash('danger', 'No modules data received.');
    }
} else {
    set_flash('danger', 'Invalid request method.');
}

header('Location: ' . BASE_URL . '/admin/modules');
exit;
