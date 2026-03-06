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
        header("Location: " . BASE_URL . "/admin/faq");
        exit;
    }

    // Sync Parent Table
    $stmt = $pdo->prepare("UPDATE " . DB_PREFIX . "faq SET tagline = ?, title = ? WHERE id = 1");
    $stmt->execute([$_POST['tagline'] ?? '', $_POST['title'] ?? '']);

    // Sync List
    $pdo->prepare("DELETE FROM " . DB_PREFIX . "faq_list WHERE faq_id = 1")->execute();
    $stmtL = $pdo->prepare("INSERT INTO " . DB_PREFIX . "faq_list (faq_id, question, answer, sort_order) VALUES (1, ?, ?, ?)");
    $list = $_POST['list'] ?? [];
    $idx = 0;
    foreach ($list as $item) {
        $stmtL->execute([$item['question'] ?? '', $item['answer'] ?? '', $idx++]);
    }

    set_flash('success', 'FAQ updated successfully!');
    header("Location: " . BASE_URL . "/admin/faq");
    exit;
}
?>