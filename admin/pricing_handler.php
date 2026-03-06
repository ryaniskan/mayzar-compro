<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs: Only span/br allowed, no inline styles
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;b&gt;, &lt;span&gt;, &lt;span class="color-blue4"&gt;, &lt;br&gt;, and &lt;br /&gt; are allowed.');
        header("Location: " . BASE_URL . "/admin/pricing");
        exit;
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "pricing SET tagline = ?, title = ? WHERE id = 1");
    $stmt->execute([$_POST['tagline'] ?? '', $_POST['title'] ?? '']);

    // Sync Plans and Features
    $pdo->exec("DELETE FROM " . DB_PREFIX . "pricing_features WHERE plan_id IN (SELECT id FROM " . DB_PREFIX . "pricing_plans WHERE pricing_id = 1)");
    $pdo->exec("DELETE FROM " . DB_PREFIX . "pricing_plans WHERE pricing_id = 1");

    $stmtPlan = $pdo->prepare("INSERT INTO " . DB_PREFIX . "pricing_plans (pricing_id, name, icon, price, period, description, button_text, button_url, is_popular, off_text, sort_order) VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtFeat = $pdo->prepare("INSERT INTO " . DB_PREFIX . "pricing_features (plan_id, icon, text, active, sort_order) VALUES (?, ?, ?, ?, ?)");

    $plans = $_POST['plans'] ?? [];
    $pIdx = 0;
    foreach ($plans as $plan) {
        $stmtPlan->execute([
            $plan['name'] ?? '',
            $plan['icon'] ?? '',
            $plan['price'] ?? '',
            $plan['period'] ?? '',
            $plan['description'] ?? '',
            $plan['button_text'] ?? '',
            $plan['button_url'] ?? '',
            !empty($plan['is_popular']) ? 1 : 0,
            $plan['off_text'] ?? '',
            $pIdx++
        ]);
        $planId = $pdo->lastInsertId();

        if (!empty($plan['features']) && is_array($plan['features'])) {
            $fIdx = 0;
            foreach ($plan['features'] as $feat) {
                $stmtFeat->execute([$planId, $feat['icon'] ?? '', $feat['text'] ?? '', !empty($feat['active']) ? 1 : 0, $fIdx++]);
            }
        }
    }
    set_flash('success', 'Pricing plans updated successfully!');
    header("Location: " . BASE_URL . "/admin/pricing");
    exit;
}
?>