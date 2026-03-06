<?php
require_once __DIR__ . '/common_data.php';

$about_page = db_get_by_slug('pages', 'about');
$page_title = $about_page['title'] ?? 'About Us';

// Sections data
$home_data['products'] = db_get_by_id('products', 1) ?: [];
$prod_tabs = db_get_children('product_tabs', 'product_id', 1);
foreach ($prod_tabs as &$tab) {
    $tab['features'] = db_get_children('product_features', 'tab_id', $tab['id']);
}
unset($tab);
$home_data['products']['tabs'] = $prod_tabs;

$home_data['clients'] = db_get_by_id('clients', 1) ?: [];
$home_data['clients']['logos'] = array_column(db_get_children('clients_logos', 'client_id', 1), 'logo_path');

include 'partials/head.php';
include 'partials/navbar.php';
?>

<header class="inner-header style-4">
    <div class="container">
        <div class="info text-center">
            <h1><?php echo $about_page['title'] ?? 'About Our <span>Enterprise</span>'; ?></h1>
            <p><?php echo $about_page['description'] ?? ''; ?></p>
        </div>
    </div>
</header>

<main>
    <?php include 'partials/sections/products.php'; ?>
    <?php include 'partials/sections/clients.php'; ?>
</main>

<?php include 'partials/footer.php'; ?>
<?php include 'partials/scripts.php'; ?>
<style>
    .inner-header {
        padding: 150px 0 100px;
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }

    .inner-header h1 {
        font-size: 45px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .inner-header h1 span {
        color: #5842bc;
    }

    .inner-header p {
        color: #666;
        font-size: 18px;
    }
</style>