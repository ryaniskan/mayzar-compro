<?php
require_once __DIR__ . '/common_data.php';

$home_data = $home_data ?? [];

$hero = db_get_by_id('hero', 1) ?: [];
$hero['features'] = db_get_children('hero_features', 'hero_id', 1);

$integ = db_get_by_id('integrations', 1) ?: [];
$integ['items'] = db_get_children('integrations_items', 'integration_id', 1);

$clients = db_get_by_id('clients', 1) ?: [];
$clients['logos_data'] = db_get_children('clients_logos', 'client_id', 1);
$clients['logos'] = array_column($clients['logos_data'], 'logo_path');

$features_parent = db_get_by_id('features', 1) ?: [];
$features_parent['items'] = db_get_children('features_items', 'feature_id', 1);

$products_parent = db_get_by_id('products', 1) ?: [];
$prod_tabs = db_get_children('product_tabs', 'product_id', 1);
foreach ($prod_tabs as &$tab) {
    $tab['features'] = db_get_children('product_features', 'tab_id', $tab['id']);
}
unset($tab);
$products_parent['tabs'] = $prod_tabs;

$security_parent = db_get_by_id('security', 1) ?: [];
$security_parent['items'] = db_get_children('security_items', 'security_id', 1);

$themes_parent = db_get_by_id('themes', 1) ?: [];
$themes_parent['bullets'] = array_column(db_get_children('themes_bullets', 'theme_id', 1), 'text');

$screenshots_parent = db_get_by_id('screenshots', 1) ?: [];
$screenshots_parent['images'] = array_column(db_get_children('screenshots_items', 'screenshot_id', 1), 'image_path');

$testi_parent = db_get_by_id('testimonials', 1) ?: [];
$testi_parent['stats'] = db_get_children('testimonial_stats', 'testimonials_id', 1);
$testi_parent['list'] = db_get_children('testimonial_list', 'testimonials_id', 1);

$pricing_parent = db_get_by_id('pricing', 1) ?: [];
$pricing_plans = db_get_children('pricing_plans', 'pricing_id', 1);
foreach ($pricing_plans as &$plan) {
    $plan['features'] = db_get_children('pricing_features', 'plan_id', $plan['id']);
}
unset($plan);
$pricing_parent['plans'] = $pricing_plans;

$faq_parent = db_get_by_id('faq', 1) ?: [];
$faq_parent['list'] = db_get_children('faq_list', 'faq_id', 1);

$community_parent = db_get_by_id('community', 1) ?: [];
$community_parent['list'] = db_get_children('community_list', 'community_id', 1);

// Merging into home_data
$home_data['hero'] = $hero;
$home_data['integrations'] = $integ;
$home_data['clients'] = $clients;
$home_data['features'] = $features_parent;
$home_data['products'] = $products_parent;
$home_data['security'] = $security_parent;
$home_data['themes'] = $themes_parent;
$home_data['screenshots'] = $screenshots_parent;
$home_data['testimonials'] = $testi_parent;
$home_data['pricing'] = $pricing_parent;
$home_data['faq'] = $faq_parent;
$home_data['community'] = $community_parent;

include 'partials/head.php';
include 'partials/preloader.php';
include 'partials/top-navbar.php';
include 'partials/navbar.php';

$modules_raw = db_get_all('modules');
$modules = [];
foreach ($modules_raw as $m) {
    $modules[] = ['id' => $m['module_id'], 'visible' => !empty($m['visible'])];
}
if (empty($modules)) {
    // Fallback defaults
    $modules = [
        ['id' => 'hero', 'visible' => true],
        ['id' => 'clients', 'visible' => true],
        ['id' => 'features', 'visible' => true],
        ['id' => 'products', 'visible' => true],
        ['id' => 'security', 'visible' => true],
        ['id' => 'themes', 'visible' => true],
        ['id' => 'integrations', 'visible' => true],
        ['id' => 'screenshots', 'visible' => true],
        ['id' => 'testimonials', 'visible' => true],
        ['id' => 'pricing', 'visible' => true],
        ['id' => 'faq', 'visible' => true],
        ['id' => 'community', 'visible' => true],
        ['id' => 'download', 'visible' => true]
    ];
}
?>

<main>
    <?php foreach ($modules as $module): ?>
        <?php if (!empty($module['visible'])): ?>
            <?php
            $file = __DIR__ . '/partials/sections/' . $module['id'] . '.php';
            if (file_exists($file)) {
                include $file;
            }
            ?>
        <?php endif; ?>
    <?php endforeach; ?>
</main>

<?php include 'partials/footer.php'; ?>
<?php include 'partials/scripts.php'; ?>