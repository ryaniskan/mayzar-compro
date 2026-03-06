<?php
require_once __DIR__ . '/common_data.php';

$page_title = 'Our Blog';

include 'partials/head.php';
include 'partials/navbar.php';
?>

<header class="inner-header style-4">
    <div class="container">
        <div class="info text-center">
            <h1>Our <span>Blog</span></h1>
            <p>Insights, trends, and updates from the world of Enterprise and POS technology.</p>
        </div>
    </div>
</header>

<section class="blog section-padding style-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-30">
                <div class="blog-card card shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=800&q=80"
                        alt="" class="card-img-top">
                    <div class="card-body p-4">
                        <small class="color-blue4 fw-bold mb-2 d-block">Enterprise Tech</small>
                        <h5 class="fw-bold mb-3">5 Ways Cloud ERP Can Boost Your Productivity</h5>
                        <p class="text-muted small">Learn how centralizing your data can save hours of manual work every
                            week.</p>
                        <a href="#" class="btn btn-link p-0 color-blue4 fw-bold">Read More <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-30">
                <div class="blog-card card shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?auto=format&fit=crop&w=800&q=80"
                        alt="" class="card-img-top">
                    <div class="card-body p-4">
                        <small class="color-blue4 fw-bold mb-2 d-block">Retail Solutions</small>
                        <h5 class="fw-bold mb-3">The Future of Smart POS in 2026</h5>
                        <p class="text-muted small">Discover the latest trends in point-of-sale technology for growing
                            businesses.</p>
                        <a href="#" class="btn btn-link p-0 color-blue4 fw-bold">Read More <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-30">
                <div class="blog-card card shadow-sm border-0 rounded-4 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80"
                        alt="" class="card-img-top">
                    <div class="card-body p-4">
                        <small class="color-blue4 fw-bold mb-2 d-block">Success Stories</small>
                        <h5 class="fw-bold mb-3">Scaling Your Retail Business to 50 Locations</h5>
                        <p class="text-muted small">A guide to infrastructure and management for multi-store
                            enterprises.</p>
                        <a href="#" class="btn btn-link p-0 color-blue4 fw-bold">Read More <i
                                class="bi bi-arrow-right"></i></a>
                    </div>
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

    .blog-card {
        transition: all 0.3s ease;
        height: 100%;
    }

    .blog-card:hover {
        transform: translateY(-10px);
    }

    .card-img-top {
        height: 200px;
        object-fit: crop;
    }
</style>