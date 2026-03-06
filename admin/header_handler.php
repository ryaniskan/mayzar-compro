<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs: Only span/br allowed, no inline styles
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;span&gt; and &lt;br&gt; are allowed, no inline styles.');
        header("Location: " . BASE_URL . "/admin/header");
        exit;
    }

    $top_bar = $_POST['top_bar'] ?? [];
    $navbar = $_POST['navbar'] ?? [];

    // Sync Parent Table (Header)
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "header SET top_bar_show = ?, top_bar_badge = ?, top_bar_icon = ?, top_bar_text = ?, top_bar_link_text = ?, top_bar_link_url = ?, cta_text = ?, cta_url = ? WHERE id = 1");
    $stmt->execute([
        isset($top_bar['show']) ? 1 : 0,
        validate_input($top_bar['badge'] ?? ''),
        validate_input($top_bar['icon'] ?? ''),
        validate_input($top_bar['text'] ?? ''),
        validate_input($top_bar['link_text'] ?? ''),
        validate_input($top_bar['link_url'] ?? '', true),
        validate_input($navbar['cta']['text'] ?? ''),
        validate_input($navbar['cta']['url'] ?? '#', true)
    ]);

    // Sync Nav Links
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "header_nav_links WHERE header_id = 1")->execute();
    if (isset($navbar['nav_links']) && is_array($navbar['nav_links'])) {
        $stmtL = $pdo->prepare("INSERT INTO " . DB_PREFIX . "header_nav_links (header_id, label, url, icon, sort_order) VALUES (1, ?, ?, ?, ?)");
        foreach ($navbar['nav_links'] as $idx => $link) {
            if (!empty($link['label'])) {
                $stmtL->execute([
                    validate_input($link['label']),
                    validate_input($link['url'] ?? '#', true),
                    validate_input($link['icon'] ?? ''),
                    $idx
                ]);
            }
        }
    }

    set_flash('success', 'Header & Top Bar updated successfully!');
    header("Location: " . BASE_URL . "/admin/header");
    exit;
}
?>