<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt; or &lt;br /&gt; are allowed.');
        header("Location: " . BASE_URL . "/admin/integrations");
        exit;
    }

    // Update Integrations Data (Parent Table)
    $data = [
        'anchor_id' => 'integrations',
        'tagline' => $_POST['tagline'] ?? '',
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];
    db_update_by_id('integrations', 1, $data);

    // Sync Items (Child Table)
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "integrations_items WHERE integration_id = 1")->execute();

    $items = $_POST['items'] ?? [];
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "integrations_items (integration_id, image, spacing, sort_order) VALUES (1, ?, ?, ?)");
    foreach ($items as $idx => $item) {
        $stmt->execute([$item['image'], $item['spacing'] ?? 30, $idx]);
    }
    set_flash('success', 'Integrations section updated successfully!');
    header("Location: " . BASE_URL . "/admin/integrations");
    exit;
}
?>