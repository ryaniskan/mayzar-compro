<?php
require_once __DIR__ . '/common_data.php';

$terms_page = db_get_by_slug('pages', 'terms');
$page_title = $terms_page['title'] ?? 'Terms of Service';

include 'partials/head.php';
include 'partials/navbar.php';
?>

<header class="inner-header style-4">
    <div class="container">
        <div class="info text-center">
            <h1><?php echo $terms_page['title'] ?? 'Terms Of <span>Service</span>'; ?></h1>
            <p><?php echo htmlspecialchars($terms_page['description'] ?? ''); ?></p>
        </div>
    </div>
</header>

<section class="terms section-padding style-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content card p-5 shadow-sm border-0 rounded-4">
                    <?php echo $terms_page['content'] ?? ''; ?>
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

    .terms .content h3 {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .terms .content p {
        color: #666;
        line-height: 1.8;
    }
</style>