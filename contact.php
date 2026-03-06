<?php
require_once __DIR__ . '/common_data.php';

$contact_page = db_get_by_slug('pages', 'contact');
$page_title = $contact_page['title'] ?? 'Contact Us';

include 'partials/head.php';
include 'partials/navbar.php';
?>

<header class="inner-header style-4">
    <div class="container">
        <div class="info text-center">
            <h1><?php echo $contact_page['title'] ?? 'Get In <span>Touch</span>'; ?></h1>
            <p><?php echo htmlspecialchars($contact_page['description'] ?? ''); ?></p>
        </div>
    </div>
</header>

<section class="contact section-padding style-4">
    <div class="container">
        <div class="content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php echo $contact_page['content'] ?? ''; ?>

                    <?php if (isset($_SESSION['contact_success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 shadow-sm border-0"
                            role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?php echo $_SESSION['contact_success'];
                            unset($_SESSION['contact_success']); ?>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['contact_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 shadow-sm border-0"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php echo $_SESSION['contact_error'];
                            unset($_SESSION['contact_error']); ?>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="contact_handler" method="POST" class="form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-20">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-20">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-20">
                                    <textarea name="message" rows="5" class="form-control" placeholder="Your Message"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit"
                                    class="btn rounded-pill bg-blue4 text-white p-3 px-5 fw-bold mt-20">
                                    <span>Send Message</span>
                                </button>
                            </div>
                        </div>
                    </form>
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

    .contact .item {
        padding: 40px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .contact .item:hover {
        transform: translateY(-10px);
    }

    .contact .form-control {
        border-radius: 10px;
        padding: 15px;
        border: 1px solid #eee;
    }

    .contact .form-control:focus {
        border-color: #5842bc;
        box-shadow: none;
    }
</style>