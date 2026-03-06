<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt;, and &lt;br /&gt; are allowed.');
        header("Location: " . BASE_URL . "/admin/themes");
        exit;
    }

    $_POST['anchor_id'] = 'themes';

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "themes SET tagline = ?, title = ?, description = ?, main_image = ?, btn_text = ?, btn_url = ?, btn_color = ? WHERE id = 1");
    $stmt->execute([
        $_POST['tagline'] ?? '',
        $_POST['title'] ?? '',
        $_POST['description'] ?? '',
        $_POST['main_image'] ?? '',
        $_POST['btn_text'] ?? '',
        $_POST['btn_url'] ?? '',
        $_POST['btn_color'] ?? '#5842bc'
    ]);

    // Sync Bullets
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "themes_bullets WHERE theme_id = 1")->execute();
    $stmt = $pdo->prepare("INSERT INTO " . DB_PREFIX . "themes_bullets (theme_id, text, sort_order) VALUES (1, ?, ?)");
    $bullets = $_POST['bullets'] ?? [];
    $idx = 0;
    foreach ($bullets as $text) {
        $stmt->execute([$text, $idx++]);
    }
    set_flash('success', 'Themes section updated successfully!');
    header("Location: " . BASE_URL . "/admin/themes");
    exit;
}
?>