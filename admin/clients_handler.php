<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs for disallowed HTML
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt; or &lt;br /&gt; are allowed.');
        header("Location: " . BASE_URL . "/admin/clients");
        exit;
    }


    $logos = [];
    if (isset($_POST['logos']) && is_array($_POST['logos'])) {
        foreach ($_POST['logos'] as $logo) {
            if (!empty($logo)) {
                $logos[] = $logo;
            }
        }
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "clients (id, anchor_id, title) VALUES (1, 'clients', ?) ON DUPLICATE KEY UPDATE title = VALUES(title)");
    $stmt->execute([$_POST['title']]);

    // Sync Child Table (Logos)
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "clients_logos WHERE client_id = 1")->execute();
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "clients_logos (client_id, logo_path, sort_order) VALUES (1, ?, ?)");
    foreach ($logos as $idx => $logo) {
        $stmt->execute([$logo, $idx]);
    }
    set_flash('success', 'Clients section updated successfully!');
    header("Location: " . BASE_URL . "/admin/clients");
    exit;
}
?>