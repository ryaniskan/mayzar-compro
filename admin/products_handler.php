<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs: Only span/br allowed, no inline styles
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt;, and &lt;br /&gt; are allowed.');
        header("Location: " . BASE_URL . "/admin/products");
        exit;
    }

    $_POST['anchor_id'] = 'products';

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "products SET header_slogan = ?, header_title = ?, header_desc = ? WHERE id = 1");
    $stmt->execute([$_POST['header_slogan'] ?? '', $_POST['header_title'] ?? '', $_POST['header_desc'] ?? '']);

    // Sync Tabs and Features
    // Delete existing features for this product first, then delete the tabs
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "product_features WHERE tab_id IN (SELECT id FROM " . DB_PREFIX . "product_tabs WHERE product_id = 1)")->execute();
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "product_tabs WHERE product_id = 1")->execute();

    $stmtTab = $pdo->prepare("INSERT INTO " . DB_PREFIX . "product_tabs (product_id, nav_label, nav_icon, main_image, side_slogan, side_title, side_desc, btn_text, btn_url, sort_order) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtFeat = $pdo->prepare("INSERT INTO " . DB_PREFIX . "product_features (tab_id, icon, text, sort_order) VALUES (?, ?, ?, ?)");

    $tabs = $_POST['tabs'] ?? [];
    $tIdx = 0;
    foreach ($tabs as $tab) {
        $stmtTab->execute([
            $tab['nav_label'] ?? '',
            $tab['nav_icon'] ?? 'bi-star',
            $tab['main_image'] ?? '',
            $tab['side_slogan'] ?? '',
            $tab['side_title'] ?? '',
            $tab['side_desc'] ?? '',
            $tab['btn_text'] ?? '',
            $tab['btn_url'] ?? '',
            $tIdx++
        ]);
        $tabId = $pdo->lastInsertId();

        if (!empty($tab['features']) && is_array($tab['features'])) {
            $fIdx = 0;
            foreach ($tab['features'] as $feat) {
                $stmtFeat->execute([$tabId, $feat['icon'] ?? 'bi-check', $feat['text'] ?? '', $fIdx++]);
            }
        }
    }
    set_flash('success', 'Products section updated successfully!');
    header("Location: " . BASE_URL . "/admin/products");
    exit;
}
?>