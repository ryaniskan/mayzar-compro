<?php
require_once __DIR__ . '/common_data.php';

$privacy_page = db_get_by_slug('pages', 'privacy');
$page_title = $privacy_page['title'] ?? 'Privacy Policy';

include 'partials/head.php';
include 'partials/navbar.php';
?>

<header class="inner-header style-4">
    <div class="container">
        <div class="info text-center">
            <h1><?php echo $privacy_page['title'] ?? 'Privacy <span>Policy</span>'; ?></h1>
            <p><?php echo htmlspecialchars($privacy_page['description'] ?? ''); ?></p>
        </div>
    </div>
</header>

<section class="policy section-padding style-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content card p-5 shadow-sm border-0 rounded-4">
                    <?php echo $privacy_page['content'] ?? ''; ?>
                </div>
            </div>
        </div>
    </div>
</section>

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

    .policy .content h3 {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .policy .content p {
        color: #666;
        line-height: 1.8;
    }
</style>