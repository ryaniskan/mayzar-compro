<?php
require_once __DIR__ . '/config.php';

$pdo = null;

// Initialize PDO if using SQL driver
if (DB_DRIVER === 'sql') {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $e) {
        // In a production app, we'd log this and show a nicer error
        if (basename($_SERVER['PHP_SELF']) !== 'install.php') {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}

/**
 * Get all records from a table
 */
function db_get_all($table)
{
    global $pdo;
    if (DB_DRIVER === 'json') {
        $file = __DIR__ . '/data/' . $table . '.json';
        if (file_exists($file)) {
            return json_decode(file_get_contents($file), true);
        }
    } elseif (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $stmt = $pdo->query("SELECT * FROM `$tbl` ORDER BY id ASC");
        return $stmt->fetchAll();
    }
    return [];
}

/**
 * Get a single record by slug
 */
function db_get_by_slug($table, $slug)
{
    global $pdo;
    if (DB_DRIVER === 'json') {
        $all = db_get_all($table);
        foreach ($all as $item) {
            if (($item['slug'] ?? '') === $slug) {
                return $item;
            }
        }
    } elseif (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $stmt = $pdo->prepare("SELECT * FROM `$tbl` WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    return null;
}

/**
 * Get a single record by ID
 */
function db_get_by_id($table, $id)
{
    global $pdo;
    if (DB_DRIVER === 'json') {
        $all = db_get_all($table);
        foreach ($all as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
    } elseif (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $stmt = $pdo->prepare("SELECT * FROM `$tbl` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    return null;
}

/**
 * Get dynamic settings as a flat key-value array
 */
function db_get_flat($table)
{
    global $pdo;
    if (DB_DRIVER === 'json') {
        $data = db_get_all($table);
        $flat = [];
        foreach ($data as $item) {
            if (isset($item['key'], $item['value'])) {
                $flat[$item['key']] = $item['value'];
            }
        }
        return $flat;
    } elseif (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $stmt = $pdo->query("SELECT `key`, `value` FROM `$tbl` WHERE 1=1");
        $rows = $stmt->fetchAll();
        $flat = [];
        foreach ($rows as $row) {
            $flat[$row['key']] = $row['value'];
        }
        return $flat;
    }
    return [];
}

/**
 * Get children for a relational module
 */
function db_get_children($table, $fk_name, $parent_id)
{
    global $pdo;
    if (DB_DRIVER === 'json') {
        $data = db_get_all($table);
        return array_values(array_filter($data, function ($row) use ($fk_name, $parent_id) {
            return ($row[$fk_name] ?? null) == $parent_id;
        }));
    } elseif (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $stmt = $pdo->prepare("SELECT * FROM `$tbl` WHERE `$fk_name` = ? ORDER BY sort_order ASC, id ASC");
        $stmt->execute([$parent_id]);
        return $stmt->fetchAll();
    }
    return [];
}

/**
 * Save flat settings to SQL table
 */
function db_save_flat($table, $data)
{
    global $pdo;
    if (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        foreach ($data as $key => $value) {
            $stmt = $pdo->prepare("INSERT INTO `$tbl` (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = ?");
            $stmt->execute([$key, $value, $value]);
        }
        return true;
    }
    return false;
}

/**
 * Update a row in a table by ID
 */
function db_update_by_id($table, $id, $data)
{
    global $pdo;
    if (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "`$key` = ?";
            $values[] = $value;
        }
        $values[] = $id;

        $sql = "UPDATE `$tbl` SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    }
    return false;
}

/**
 * Insert a row into a table
 */
function db_insert($table, $data)
{
    global $pdo;
    if (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $keys = array_keys($data);
        $fields = "`" . implode("`, `", $keys) . "`";
        $placeholders = str_repeat('?, ', count($keys) - 1) . '?';
        $values = array_values($data);

        $sql = "INSERT INTO `$tbl` ($fields) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        return $pdo->lastInsertId();
    }
    return false;
}

/**
 * Delete a row by ID
 */
function db_delete_by_id($table, $id)
{
    global $pdo;
    if (DB_DRIVER === 'sql' && $pdo) {
        $tbl = DB_PREFIX . $table;
        $stmt = $pdo->prepare("DELETE FROM `$tbl` WHERE id = ?");
        return $stmt->execute([$id]);
    }
    return false;
}

/**
 * Render an icon (image path or font class)
 */
function render_icon($icon, $attrs = '')
{
    if (empty($icon)) {
        return '';
    }

    // Check if it's a URL or relative path
    if (strpos($icon, '/') !== false || strpos($icon, 'http') === 0 || preg_match('/\.(png|jpg|jpeg|gif|svg)$/i', $icon)) {
        $path = (strpos($icon, 'http') === 0) ? $icon : BASE_URL . $icon;
        return "<img src=\"" . htmlspecialchars($path) . "\" $attrs />";
    }

    // Otherwise assume it's a Bootstrap Icon class
    return "<i class=\"" . htmlspecialchars($icon) . "\" $attrs></i>";
}

