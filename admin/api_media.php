<?php
require_once __DIR__ . '/auth_check.php';
check_auth();
require_once __DIR__ . '/media_helper.php';

$path = $_GET['path'] ?? '';
$data = media_get_assets($path);

header('Content-Type: application/json');
echo json_encode($data);
?>