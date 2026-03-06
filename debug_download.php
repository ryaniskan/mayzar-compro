<?php
require_once 'db.php';
header('Content-Type: application/json');

$results = [
    'download_buttons' => db_get_all('download_buttons'),
];

echo json_encode($results, JSON_PRETTY_PRINT);
?>