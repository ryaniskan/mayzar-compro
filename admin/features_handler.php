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
        header("Location: " . BASE_URL . "/admin/features");
        exit;
    }


    $items = [];
    if (isset($_POST['items_titles']) && is_array($_POST['items_titles'])) {
        foreach ($_POST['items_titles'] as $idx => $title) {
            if (!empty($title)) {
                $items[] = [
                    'icon' => $_POST['items_icons'][$idx] ?? '',
                    'title' => $title,
                    'label' => $_POST['items_badges'][$idx] ?? '',
                    'label_color' => $_POST['items_badge_colors'][$idx] ?? '#5842bc'
                ];
            }
        }
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "features (id, anchor_id, tagline, title) VALUES (1, 'features', ?, ?) ON DUPLICATE KEY UPDATE tagline = VALUES(tagline), title = VALUES(title)");
    $stmt->execute([$_POST['tagline'] ?? '', $_POST['title'] ?? '']);

    // Sync Child Table (Items)
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "features_items WHERE feature_id = 1")->execute();
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "features_items (feature_id, icon, title, label, label_color, sort_order) VALUES (1, ?, ?, ?, ?, ?)");

    $fIdx = 0;
    foreach ($items as $item) {
        $stmt->execute([
            $item['icon'] ?? '',
            $item['title'] ?? '',
            $item['label'] ?? '',
            $item['label_color'] ?? '#5842bc',
            $fIdx++
        ]);
    }
    set_flash('success', 'Features updated successfully!');
    header("Location: " . BASE_URL . "/admin/features");
    exit;
}
?>