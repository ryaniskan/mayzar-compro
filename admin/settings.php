<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'settings';
$page_title = __('Site Settings');

$settings = db_get_flat('settings');
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
                            <h1 class="m-0"><?php echo __('Global Site Settings'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="settingsForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Settings'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="settingsForm" action="settings_handler" method="POST">
                        <?php render_csrf_input(); ?>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card card-primary card-outline shadow-sm mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title font-weight-bold">
                                            <?php echo __('General Configuration'); ?>
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label class="font-weight-bold"><?php echo __('Site Name'); ?></label>
                                            <input type="text" name="site_name" class="form-control"
                                                value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>"
                                                placeholder="Enter Website Name">
                                        </div>

                                        <hr class="my-4">
                                        <h6 class="text-primary font-weight-bold mb-3 small uppercase">
                                            <?php echo __('Visual Branding'); ?>
                                        </h6>

                                        <div class="row">
                                            <div class="col-md-6 mb-4 text-center">
                                                <label
                                                    class="d-block text-left font-weight-bold"><?php echo __('Site Logo'); ?></label>
                                                <div class="logo-preview border rounded p-3 bg-light mb-3 d-flex align-items-center justify-content-center"
                                                    id="logoPreview" style="height: 120px;">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($settings['site_logo'] ?? ''); ?>"
                                                        alt="Current Logo"
                                                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                </div>
                                                <input type="hidden" name="site_logo" id="selectedLogo"
                                                    value="<?php echo htmlspecialchars($settings['site_logo'] ?? ''); ?>">

                                                <button type="button" class="btn btn-primary btn-sm btn-block shadow-sm"
                                                    onclick="openMediaBrowser('logo')">
                                                    <i class="fas fa-images mr-1"></i>
                                                    <?php echo __('Choose From Media'); ?>
                                                </button>
                                            </div>

                                            <div class="col-md-6 mb-4 text-center">
                                                <label
                                                    class="d-block text-left font-weight-bold"><?php echo __('Site Favicon'); ?></label>
                                                <div class="border rounded p-3 bg-light mb-3 d-flex align-items-center justify-content-center"
                                                    id="faviconPreview" style="height: 120px;">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($settings['site_favicon'] ?? ''); ?>"
                                                        alt="Favicon" style="max-width: 32px; max-height: 32px;">
                                                </div>
                                                <input type="hidden" name="site_favicon" id="selectedFavicon"
                                                    value="<?php echo htmlspecialchars($settings['site_favicon'] ?? ''); ?>">

                                                <button type="button" class="btn btn-primary btn-sm btn-block shadow-sm"
                                                    onclick="openMediaBrowser('favicon')">
                                                    <i class="fas fa-images mr-1"></i>
                                                    <?php echo __('Choose From Media'); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Configuration Card -->
                                <div class="card card-info card-outline shadow-sm mb-4">
                                    <div class="card-header">
                                        <h3 class="card-title font-weight-bold">
                                            <?php echo __('Email (SMTP) Configuration'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <label
                                                    class="small font-weight-bold text-muted"><?php echo __('SMTP Host'); ?></label>
                                                <input type="text" name="smtp_host" class="form-control"
                                                    value="<?php echo htmlspecialchars($settings['smtp_host'] ?? ''); ?>"
                                                    placeholder="smtp.example.com">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label
                                                    class="small font-weight-bold text-muted"><?php echo __('SMTP Port'); ?></label>
                                                <input type="number" name="smtp_port" class="form-control"
                                                    value="<?php echo htmlspecialchars($settings['smtp_port'] ?? '587'); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label
                                                    class="small font-weight-bold text-muted"><?php echo __('SMTP Username'); ?></label>
                                                <input type="text" name="smtp_user" class="form-control"
                                                    value="<?php echo htmlspecialchars($settings['smtp_user'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label
                                                    class="small font-weight-bold text-muted"><?php echo __('SMTP Password'); ?></label>
                                                <input type="password" name="smtp_pass" class="form-control"
                                                    value="<?php echo htmlspecialchars($settings['smtp_pass'] ?? ''); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label
                                                    class="small font-weight-bold text-muted"><?php echo __('Sender Email (From)'); ?></label>
                                                <input type="email" name="from_email" class="form-control"
                                                    value="<?php echo htmlspecialchars($settings['from_email'] ?? ''); ?>"
                                                    placeholder="noreply@example.com">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label
                                                    class="small font-weight-bold text-muted"><?php echo __('Sender Name'); ?></label>
                                                <input type="text" name="from_name" class="form-control"
                                                    value="<?php echo htmlspecialchars($settings['from_name'] ?? ''); ?>"
                                                    placeholder="Mayzar Support">
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label
                                                        class="small font-weight-bold text-muted"><?php echo __('Encryption'); ?></label>
                                                    <select name="smtp_encryption" class="form-control">
                                                        <option value="tls" <?php echo ($settings['smtp_encryption'] ?? '') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                                                        <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                                        <option value="none" <?php echo ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : ''; ?>>None</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card card-dark shadow-sm">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Utility'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted small">
                                            <?php echo __('The site branding affects the header logo, footer, and browser tab icon across the entire frontend.'); ?>
                                        </p>
                                        <hr>
                                        <a href="/" target="_blank" class="btn btn-outline-secondary btn-block mb-2">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            <?php echo __('View Website'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    <h5 class="modal-title font-weight-bold"><?php echo __('Select Asset'); ?></h5>
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
        let activeTarget = null;

        function openMediaBrowser(target) {
            activeTarget = target;
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {

            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    if (activeTarget === 'logo') {
                        document.getElementById('selectedLogo').value = path;
                        document.getElementById('logoPreview').innerHTML = `<img src="${CONFIG.BASE_URL + path}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
                    } else if (activeTarget === 'favicon') {
                        document.getElementById('selectedFavicon').value = path;
                        document.getElementById('faviconPreview').innerHTML = `<img src="${CONFIG.BASE_URL + path}" alt="Preview" style="max-width:32px;max-height:32px;">`;
                    }
                    $('#mediaModal').modal('hide');
                });
            }
        });
    </script>
</body>

</html>