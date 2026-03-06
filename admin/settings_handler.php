<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/validation_helper.php';
require_once __DIR__ . '/flash_helper.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check is automatically done by check_auth() in auth_check.php
    // but we can be explicit here for clarity or if check_auth() didn't call it.
    // Actually, check_auth() already calls it.

    // Validate text inputs
    if (!validate_recursive($_POST)) {
        set_flash('danger', 'Invalid HTML detected in settings.');
        header("Location: " . BASE_URL . "/admin/settings");
        exit;
    }

    $settings = db_get_flat('settings');

    // Handle Metadata
    $settings['site_name'] = $_POST['site_name'] ?? ($settings['site_name'] ?? '');

    // Handle SMTP Settings
    $settings['smtp_host'] = $_POST['smtp_host'] ?? ($settings['smtp_host'] ?? '');
    $settings['smtp_port'] = $_POST['smtp_port'] ?? ($settings['smtp_port'] ?? '587');
    $settings['smtp_user'] = $_POST['smtp_user'] ?? ($settings['smtp_user'] ?? '');
    $settings['smtp_pass'] = $_POST['smtp_pass'] ?? ($settings['smtp_pass'] ?? '');
    $settings['from_email'] = $_POST['from_email'] ?? ($settings['from_email'] ?? '');
    $settings['from_name'] = $_POST['from_name'] ?? ($settings['from_name'] ?? '');
    $settings['smtp_encryption'] = $_POST['smtp_encryption'] ?? ($settings['smtp_encryption'] ?? 'tls');

    // Handle Branding
    $settings['site_logo'] = $_POST['site_logo'] ?? ($settings['site_logo'] ?? '');
    $settings['site_favicon'] = $_POST['site_favicon'] ?? ($settings['site_favicon'] ?? '');

    db_save_flat('settings', $settings);
    set_flash('success', 'Settings updated successfully!');
    header("Location: " . BASE_URL . "/admin/settings");
    exit;
}
?>