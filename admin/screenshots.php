<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'screenshots';
$page_title = __('Screenshot Slider');

$screenshots_data = db_get_by_id('screenshots', 1) ?: [];
$screenshots_data['images'] = array_column(db_get_children('screenshots_items', 'screenshot_id', 1), 'image_path');
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
                            <h1 class="m-0"><?php echo __('Screenshot Slider'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="screenshotsForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('Mobile App Screenshots'); ?></h3>
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-xs" onclick="addScreenshot()">
                                        <i class="fas fa-plus mr-1"></i> <?php echo __('Add One'); ?>
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-xs"
                                        onclick="addMultipleScreenshots(5)">+5</button>
                                    <button type="button" class="btn btn-outline-success btn-xs"
                                        onclick="addMultipleScreenshots(10)">+10</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-4">
                                <?php echo __('You can add multiple screenshots of your mobile application to display in the slider. Recommended size: 600x1200px.'); ?>
                            </p>

                            <form id="screenshotsForm" action="screenshots_handler" method="POST">
                                <?php render_csrf_input(); ?>

                                <div id="screenshotContainer" class="row">
                                    <?php foreach (($screenshots_data['images'] ?? $screenshots_data) as $idx => $path):
                                        if (is_array($path))
                                            continue;
                                        ?>
                                        <div class="col-md-3 col-sm-6 mb-4 screenshot-item" id="item-<?php echo $idx; ?>">
                                            <div class="card h-100 shadow-sm border">
                                                <div class="card-img-top bg-light p-3 text-center"
                                                    style="height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($path); ?>"
                                                        class="img-fluid rounded" id="preview-<?php echo $idx; ?>"
                                                        style="max-height: 100%; object-fit: contain;">
                                                </div>
                                                <div class="card-body p-2 text-center">
                                                    <input type="hidden" name="screenshots[]" id="path-<?php echo $idx; ?>"
                                                        value="<?php echo htmlspecialchars($path); ?>">
                                                    <div class="btn-group d-flex">
                                                        <button type="button" class="btn btn-outline-primary btn-xs w-100"
                                                            onclick="openMediaBrowser('<?php echo $idx; ?>')">
                                                            <i class="fas fa-image mr-1"></i> <?php echo __('Change'); ?>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-xs"
                                                            style="z-index: 10;"
                                                            onclick="this.closest('.screenshot-item').remove()">
                                                            <i class="fas fa-trash" style="pointer-events: none;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" form="screenshotsForm" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> <?php echo __('Save All Screenshots'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <!-- Media Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><?php echo __('Select Screenshot'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/partials/media_browser.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        let activeIdx = null;

        function openMediaBrowser(idx) {
            activeIdx = idx;
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            initMediaBrowser((path) => {
                const pathInput = document.getElementById('path-' + activeIdx);
                const previewImg = document.getElementById('preview-' + activeIdx);
                if (pathInput) pathInput.value = path;
                if (previewImg) previewImg.src = CONFIG.BASE_URL + path;
                $('#mediaModal').modal('hide');
            });
        });

        function addScreenshot() {
            const container = document.getElementById('screenshotContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'col-md-3 col-sm-6 mb-4 screenshot-item';
            div.id = 'item-' + idx;
            div.innerHTML = `
                <div class="card h-100 shadow-sm border">
                    <div class="card-img-top bg-light p-3 text-center" style="height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="<?php echo BASE_URL; ?>/assets/img/icons/image_placeholder.png" class="img-fluid rounded" id="preview-${idx}" style="max-height: 100%; object-fit: contain;">
                    </div>
                    <div class="card-body p-2 text-center">
                        <input type="hidden" name="screenshots[]" id="path-${idx}" value="/assets/img/icons/image_placeholder.png">
                        <div class="btn-group d-flex">
                            <button type="button" class="btn btn-outline-primary btn-xs w-100" onclick="openMediaBrowser('${idx}')">
                                <i class="fas fa-image mr-1"></i> Change
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-xs" style="z-index: 10;" onclick="this.closest('.screenshot-item').remove()">
                                <i class="fas fa-trash" style="pointer-events: none;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        function addMultipleScreenshots(count) {
            for (let i = 0; i < count; i++) {
                setTimeout(() => addScreenshot(), i * 10);
            }
        }

    </script>
</body>

</html>