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
        header("Location: " . BASE_URL . "/admin/hero");
        exit;
    }

    // Process Features
    $features = [];
    if (isset($_POST['feature_icons']) && is_array($_POST['feature_icons'])) {
        foreach ($_POST['feature_icons'] as $idx => $icon) {
            $text = $_POST['feature_texts'][$idx] ?? '';
            if (!empty($text)) {
                $features[] = [
                    'icon' => $icon,
                    'text' => $text
                ];
            }
        }
    }

    // 4. Update Hero Data (Parent Table)
    $data = [
        'tagline' => $_POST['tagline'] ?? '',
        'anchor_id' => 'hero',
        'title' => $_POST['title'],
        'description' => $_POST['description'] ?? '',
        'app_store_url' => $_POST['app_store_url'] ?? '',
        'video_url' => $_POST['video_url'] ?? '',
        'button_text' => $_POST['button_text'] ?? '',
        'button_icon' => $_POST['button_icon'] ?? '',
        'main_image' => $_POST['main_image'] ?? ''
    ];
    db_update_by_id('hero', 1, $data);

    // 5. Sync Features (Child Table)
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "hero_features WHERE hero_id = 1")->execute();
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "hero_features (hero_id, icon, text, sort_order) VALUES (1, ?, ?, ?)");
    foreach ($features as $idx => $feat) {
        $stmt->execute([$feat['icon'], $feat['text'], $idx]);
    }
    set_flash('success', 'Hero section updated successfully!');
    header("Location: " . BASE_URL . "/admin/hero");
    exit;
}
?>