<?php
require_once __DIR__ . '/auth_check.php';
check_auth();

require_once __DIR__ . '/media_helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => __('Invalid request method')]);
    exit;
}

if (!isset($_FILES['files'])) {
    echo json_encode(['success' => false, 'message' => __('No files uploaded')]);
    exit;
}

$path = $_POST['path'] ?? 'uploads';
$base_dir = realpath(__DIR__ . '/../assets/img');

// Normalize separators and remove trailing slash for comparison
$normalized_base = str_replace('\\', '/', $base_dir);
$target_path = str_replace('\\', '/', $base_dir . '/' . $path);

// Security check: ensure target is within base_dir and no path traversal
if (strpos($target_path, $normalized_base) !== 0 || strpos($path, '..') !== false) {
    echo json_encode(['success' => false, 'message' => __('Invalid upload path')]);
    exit;
}

$upload_dir = $target_path;

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
}

$files = $_FILES['files'];
$successCount = 0;
$errors = [];

for ($i = 0; $i < count($files['name']); $i++) {
    $fileName = strtolower(basename($files['name'][$i]));
    $tmpName = $files['tmp_name'][$i];
    $error = $files['error'][$i];

    if ($error !== UPLOAD_ERR_OK) {
        $errors[] = "Error uploading $fileName (PHP Upload Error Code: $error)";
        continue;
    }

    if (!media_is_valid_mime($tmpName, $fileName)) {
        $errors[] = "$fileName is not a valid image or video file.";
        continue;
    }

    $targetFile = $upload_dir . '/' . $fileName;

    // Avoid overwriting
    $counter = 1;
    $info = pathinfo($targetFile);
    while (file_exists($targetFile)) {
        $targetFile = $upload_dir . '/' . $info['filename'] . '_' . $counter . '.' . $info['extension'];
        $counter++;
    }

    if (move_uploaded_file($tmpName, $targetFile)) {
        $successCount++;
    } else {
        $error_msg = error_get_last()['message'] ?? 'Unknown error';
        $errors[] = "Could not move $fileName to target directory. Error: $error_msg. Target: $targetFile";
    }
}

$message = $successCount > 0 ? sprintf(__('Successfully uploaded %d files.'), $successCount) : __('Upload failed.');
if (!empty($errors)) {
    $message .= " " . __('Encountered errors with some files.');
}

echo json_encode([
    'success' => $successCount > 0,
    'count' => $successCount,
    'message' => $message,
    'errors' => $errors
]);
?>