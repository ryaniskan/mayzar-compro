<?php
header('Content-Type: application/json');
echo json_encode([
    'finfo_exists' => function_exists('finfo_open'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'memory_limit' => ini_get('memory_limit'),
    'assets_writable' => is_writable(__DIR__ . '/../assets/img'),
    'uploads_writable' => is_writable(__DIR__ . '/../assets/img/uploads'),
]);
?>