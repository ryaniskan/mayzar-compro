<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all inputs: Only span/br allowed, no inline styles
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected. Only &lt;span&gt; and &lt;br&gt; are allowed, no inline styles.');
        header("Location: " . BASE_URL . "/admin/testimonials");
        exit;
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "testimonials SET tagline = ?, title = ?, description = ? WHERE id = 1");
    $stmt->execute([$_POST['tagline'] ?? '', $_POST['title'] ?? '', $_POST['description'] ?? '']);

    // Sync Stats
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "testimonial_stats WHERE testimonials_id = 1")->execute();
    $stmtS = $pdo->prepare("INSERT INTO " . DB_PREFIX . "testimonial_stats (testimonials_id, icon, value, label, show_stars, sort_order) VALUES (1, ?, ?, ?, ?, ?)");
    $stats = $_POST['stats'] ?? [];
    $sIdx = 0;
    foreach ($stats as $s) {
        $stmtS->execute([$s['icon'] ?? '', $s['value'] ?? '', $s['label'] ?? '', !empty($s['show_stars']) ? 1 : 0, $sIdx++]);
    }

    // Sync List
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "testimonial_list WHERE testimonials_id = 1")->execute();
    $stmtL = $pdo->prepare("INSERT INTO " . DB_PREFIX . "testimonial_list (testimonials_id, image, stars, quote, name, position, sort_order) VALUES (1, ?, ?, ?, ?, ?, ?)");
    $list = $_POST['list'] ?? [];
    $lIdx = 0;
    foreach ($list as $item) {
        $stmtL->execute([$item['image'] ?? '', $item['stars'] ?? 5, $item['quote'] ?? '', $item['name'] ?? '', $item['position'] ?? '', $lIdx++]);
    }
    set_flash('success', 'Testimonials section updated successfully!');
    header("Location: " . BASE_URL . "/admin/testimonials");
    exit;
}
?>