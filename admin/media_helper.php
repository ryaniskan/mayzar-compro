<?php
/**
 * Media Helper for Admin CMS
 */

function media_get_assets($subpath = '')
{
    $base_dir = realpath(__DIR__ . '/../assets/img');
    $target_dir = realpath($base_dir . '/' . $subpath);

    // Security check: ensure path is within assets/img
    if (strpos($target_dir, $base_dir) !== 0) {
        return ['error' => 'Invalid path'];
    }

    $items = [];
    if (is_dir($target_dir)) {
        $files = scandir($target_dir);
        foreach ($files as $file) {
            if ($file === '.' || ($subpath === '' && $file === '..'))
                continue;

            $path = $target_dir . '/' . $file;
            $relative_path = ltrim($subpath . '/' . $file, '/');
            $is_dir = is_dir($path);

            if ($is_dir) {
                $items[] = [
                    'name' => $file,
                    'type' => 'directory',
                    'path' => $relative_path
                ];
            } elseif (preg_match('/\.(jpg|jpeg|png|gif|svg|webp|mp4|webm)$/i', $file)) {
                $items[] = [
                    'name' => $file,
                    'type' => 'file',
                    'path' => '/assets/img/' . $relative_path,
                    'url' => BASE_URL . '/assets/img/' . $relative_path
                ];
            }
        }
    }

    // Sort: Folders first, then Files
    usort($items, function ($a, $b) {
        if ($a['type'] === $b['type']) {
            return strcasecmp($a['name'], $b['name']);
        }
        return ($a['type'] === 'directory') ? -1 : 1;
    });

    return [
        'current_path' => $subpath,
        'parent_path' => dirname($subpath) === '.' ? '' : dirname($subpath),
        'items' => $items
    ];
}

function media_is_valid_mime($filePath, $fileName = '')
{
    if (!file_exists($filePath))
        return false;

    // Fallback if finfo is missing
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
    } elseif (function_exists('mime_content_type')) {
        $mimeType = mime_content_type($filePath);
    } else {
        // Very basic fallback: check extension AND use getimagesize for images
        $ext = strtolower(pathinfo($fileName ?: $filePath, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'mp4', 'webm'];

        if (!in_array($ext, $allowedExtensions))
            return false;

        // For images, we can at least try getimagesize
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $info = @getimagesize($filePath);
            return $info !== false;
        }

        // For SVG and Videos, if finfo is missing, we must trust the extension
        return true;
    }

    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
        'video/mp4',
        'video/webm',
        'video/x-matroska'
    ];

    return in_array($mimeType, $allowedMimeTypes);
}
?>