<?php
require_once __DIR__ . '/db.php';

$settings = db_get_flat('settings');
$home_data = [];

// Common Data Fetching
$footer_parent = db_get_by_id('footer', 1) ?: [];
$footer_parent['links'] = db_get_children('footer_links', 'footer_id', 1);

$download_parent = db_get_by_id('download', 1) ?: [];
$download_parent['buttons'] = db_get_children('download_buttons', 'download_id', 1);

$header_row = db_get_by_id('header', 1) ?: [];
$header_nav_links = db_get_children('header_nav_links', 'header_id', 1);
$header = [
    'top_bar' => [
        'show' => !empty($header_row['top_bar_show']),
        'badge' => $header_row['top_bar_badge'] ?? '',
        'icon' => $header_row['top_bar_icon'] ?? '',
        'text' => $header_row['top_bar_text'] ?? '',
        'link_text' => $header_row['top_bar_link_text'] ?? '',
        'link_url' => $header_row['top_bar_link_url'] ?? ''
    ],
    'navbar' => [
        'nav_links' => $header_nav_links,
        'cta' => [
            'text' => $header_row['cta_text'] ?? '',
            'url' => $header_row['cta_url'] ?? ''
        ]
    ]
];

$home_data['footer'] = $footer_parent;
$home_data['download'] = $download_parent;
$home_data['header'] = $header;
?>