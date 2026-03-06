<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/csrf_helper.php';
require_once __DIR__ . '/flash_helper.php';
check_auth();

$current_page = 'about';
$page_title = __('About Page Content');
$page_data = db_get_by_slug('pages', 'about');
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include __DIR__ . '/partials/navbar.php'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo __('Edit About Page'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="pageForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>
                    <form id="pageForm" action="pages_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>
                        <input type="hidden" name="slug" value="about">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Header Content'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <?php render_wysiwyg([
                                        'id' => 'pageTitle',
                                        'name' => 'title',
                                        'value' => $page_data['title'] ?? '',
                                        'type' => 'oneliner',
                                        'label' => __('Page Title (Hero)')
                                    ]); ?>
                                    <small
                                        class="text-muted mt-n2 d-block"><?php echo __('Use <span>text</span> tag for highlight colors.'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label><?php echo __('Page Description'); ?></label>
                                    <textarea name="description" class="form-control"
                                        rows="3"><?php echo htmlspecialchars($page_data['description'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i> Note: The About page also displays the
                            <strong><?php echo __('Products'); ?></strong> and
                            <strong><?php echo __('Clients'); ?></strong> sections, which can be managed from
                            their respective menu items.
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>
    <?php include __DIR__ . '/partials/scripts.php'; ?>
</body>

</html>