require_once __DIR__ . '/config.php';
$uri = $_SERVER['REQUEST_URI'];
$full_path = parse_url($uri, PHP_URL_PATH);

// 1. Strip BASE_URL from the path for internal routing
$path = $full_path;
if (defined('BASE_URL') && BASE_URL !== '' && strpos($path, BASE_URL) === 0) {
$path = substr($path, strlen(BASE_URL));
}

// 2. Force remove .php from URL (Transparent Redirect for SEO/Consistency)
if (str_ends_with($path, '.php')) {
$clean_url = substr($path, 0, -4);
$query = parse_url($uri, PHP_URL_QUERY);
$location = (defined('BASE_URL') ? BASE_URL : '') . $clean_url . ($query ? '?' . $query : '');
header("Location: " . $location, true, 301);
exit;
}

// 3. Convenience aliases and Path Normalization
$path = rtrim($path, '/');
if ($path === '')
$path = '/';

$aliases = [
'/login' => '/admin/login',
'/logout' => '/admin/logout',
'/admin' => '/admin/settings',
];

if (isset($aliases[$path])) {
$file = __DIR__ . $aliases[$path] . '.php';
if (file_exists($file)) {
chdir(dirname($file));
require basename($file);
return true;
}
}

// 3. File resolution
$file = __DIR__ . $path;

// Serve existing files (images, css, etc.)
if ($path !== '/' && file_exists($file) && !is_dir($file)) {
return false;
}

// Try appending .php for extensionless URLs
if (file_exists($file . '.php')) {
chdir(dirname($file . '.php'));
require basename($file . '.php');
return true;
}

// 4. Default behavior (Home or 404)
return false;
?>