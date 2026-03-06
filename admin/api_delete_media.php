<?php
require_once __DIR__ . '/auth_check.php';
check_auth();

require_once __DIR__ . '/media_helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => __('Invalid request method')]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$items = $input['items'] ?? [];

if (empty($items)) {
    echo json_encode(['success' => false, 'message' => __('No items selected for deletion')]);
    exit;
}

$base_dir = realpath(__DIR__ . '/../assets/img');
$normalized_base = str_replace('\\', '/', $base_dir);

$successCount = 0;
$errors = [];

foreach ($items as $itemPath) {
    // Basic path traversal check
    if (strpos($itemPath, '..') !== false) {
        $errors[] = sprintf(__('Invalid path: %s'), $itemPath);
        continue;
    }

    $fullPath = realpath($base_dir . '/' . $itemPath);

    if (!$fullPath) {
        $errors[] = sprintf(__('File not found: %s'), $itemPath);
        continue;
    }

    $normalized_target = str_replace('\\', '/', $fullPath);

    // Security check: ensure target is within base_dir
    if (strpos($normalized_target, $normalized_base) !== 0) {
        $errors[] = sprintf(__('Access denied: %s'), $itemPath);
        continue;
    }

    if (is_dir($fullPath)) {
        if (delete_directory_recursive($fullPath)) {
            $successCount++;
        } else {
            $errors[] = sprintf(__('Could not delete directory: %s'), $itemPath);
        }
    } else {
        if (unlink($fullPath)) {
            $successCount++;
        } else {
            $errors[] = sprintf(__('Could not delete file: %s'), $itemPath);
        }
    }
}

function delete_directory_recursive($dir)
{
    if (!file_exists($dir))
        return true;
    if (!is_dir($dir))
        return unlink($dir);

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..')
            continue;
        if (!delete_directory_recursive($dir . DIRECTORY_SEPARATOR . $item))
            return false;
    }

    return rmdir($dir);
}

$message = $successCount > 0 ? sprintf(__('Successfully deleted %d items.'), $successCount) : __('Deletion failed.');
if (!empty($errors)) {
    $message .= " " . __('Encountered errors with some items.');
}

echo json_encode([
    'success' => $successCount > 0,
    'count' => $successCount,
    'message' => $message,
    'errors' => $errors
]);
?>